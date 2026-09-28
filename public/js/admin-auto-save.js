/**
 * Admin Auto-Save System
 * - Debounced auto-save for text inputs
 * - Immediate save for selects, checkboxes, file uploads
 * - Toast notifications for success/error feedback
 * - Image delete with immediate AJAX call
 */

(function() {
    'use strict';

    // ============================================================
    // Debounce Timer Storage (per element) - For clearing on Enter
    // ============================================================
    const debounceTimers = new Map();
    const savingFlags = new Map(); // Prevent double-save per element

    // ============================================================
    // Toast Notification System
    // ============================================================
    window.Toast = {
        container: null,

        init: function() {
            if (!this.container) {
                this.container = document.createElement('div');
                this.container.id = 'toast-container';
                this.container.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 99999;
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                    pointer-events: none;
                `;
                document.body.appendChild(this.container);
            }
        },

        show: function(message, type = 'success', duration = 3000) {
            this.init();

            const toast = document.createElement('div');
            const bgColor = type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6';
            const icon = type === 'success' 
                ? '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
                : type === 'error'
                ? '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>'
                : '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';

            toast.style.cssText = `
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 12px 20px;
                background: ${bgColor};
                color: white;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 500;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                pointer-events: auto;
                animation: toastSlideIn 0.3s ease-out;
            `;
            toast.innerHTML = icon + message;

            // Add animation keyframes if not exists
            if (!document.getElementById('toast-animations')) {
                const style = document.createElement('style');
                style.id = 'toast-animations';
                style.textContent = `
                    @keyframes toastSlideIn {
                        from { transform: translateX(100%); opacity: 0; }
                        to { transform: translateX(0); opacity: 1; }
                    }
                    @keyframes toastSlideOut {
                        from { transform: translateX(0); opacity: 1; }
                        to { transform: translateX(100%); opacity: 0; }
                    }
                `;
                document.head.appendChild(style);
            }

            this.container.appendChild(toast);

            // Auto remove
            setTimeout(() => {
                toast.style.animation = 'toastSlideOut 0.3s ease-out forwards';
                setTimeout(() => toast.remove(), 300);
            }, duration);
        },

        success: function(message) { this.show(message, 'success'); },
        error: function(message) { this.show(message, 'error'); },
        info: function(message) { this.show(message, 'info'); }
    };

    // ============================================================
    // Debounce Helper (with timer storage for clearing)
    // ============================================================
    window.debounce = function(func, wait) {
        return function executedFunction(...args) {
            const element = args[0]?.target || args[0];
            
            // Clear existing timer for this element
            if (debounceTimers.has(element)) {
                clearTimeout(debounceTimers.get(element));
            }
            
            const timer = setTimeout(() => {
                debounceTimers.delete(element);
                func.apply(this, args);
            }, wait);
            
            debounceTimers.set(element, timer);
        };
    };

    // ============================================================
    // Auto-Save Core Functions
    // ============================================================
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // Generic field save function
    async function saveField(entity, id, field, value, saveUrl) {
        const url = saveUrl || `${window.location.origin}/admin/${entity}/${id}/auto-save`;
        
        try {
            const response = await fetchWithRetry(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ field, value })
            });

            if (response.ok) {
                const data = await response.json();
                Toast.success(data.message || 'Đã lưu');
                return { success: true, data };
            } else {
                const error = await response.json();
                Toast.error(error.message || error.error || 'Lỗi khi lưu');
                return { success: false, error };
            }
        } catch (err) {
            console.error('Auto-save error:', err);
            Toast.error('Lỗi kết nối');
            return { success: false, error: err };
        }
    }

    // Fetch with retry logic
    async function fetchWithRetry(url, options, retries = 3) {
        let lastError;
        for (let i = 0; i < retries; i++) {
            try {
                const response = await fetch(url, options);
                return response;
            } catch (err) {
                lastError = err;
                if (i < retries - 1) {
                    await new Promise(r => setTimeout(r, 1000 * (i + 1)));
                }
            }
        }
        throw lastError;
    }

    // ============================================================
    // Initialize Auto-Save for Text Inputs (debounced)
    // ============================================================
    function initTextInputs() {
        document.querySelectorAll('.auto-save-input').forEach(input => {
            // Skip if already initialized
            if (input.dataset.autoSaveInitialized === 'true') return;
            input.dataset.autoSaveInitialized = 'true';

            const entity = input.dataset.entity;
            const id = input.dataset.id;
            const field = input.name;
            const saveUrl = input.dataset.saveUrl;

            // Skip if no entity/id (create pages)
            if (!entity || !id) return;

            // Show saving indicator
            const showSaving = () => {
                input.style.borderColor = '#3b82f6';
                input.dataset.saving = 'true';
            };

            const hideSaving = () => {
                input.style.borderColor = '';
                input.dataset.saving = '';
            };

            // Handle input changes (debounced 1.5s)
            input.addEventListener('input', debounce(async (e) => {
                showSaving();
                const result = await saveField(entity, id, field, e.target.value, saveUrl);
                hideSaving();
                
                // Trigger custom event for other listeners
                input.dispatchEvent(new CustomEvent('autosave', { 
                    detail: { field, value: e.target.value, result }
                }));
            }, 1500));

            // ============================================================
            // Enter Key Handler - Immediate Save (for text inputs)
            // ============================================================
            input.addEventListener('keydown', (e) => {
                if (e.key !== 'Enter') return;
                
                // Only for <input>, not <textarea>
                if (input.tagName === 'TEXTAREA') return;
                
                // Skip if already saving (prevent double-save)
                if (savingFlags.get(input)) return;
                
                // Clear pending debounce timer
                if (debounceTimers.has(input)) {
                    clearTimeout(debounceTimers.get(input));
                    debounceTimers.delete(input);
                }
                
                e.preventDefault(); // Prevent form submit
                
                // Visual feedback - flash green
                input.style.borderColor = '#10b981';
                Toast.info('Đang lưu...');
                
                // Mark as saving
                savingFlags.set(input, true);
                input.disabled = true;
                
                saveField(entity, id, field, input.value, saveUrl)
                    .then((result) => {
                        // Restore input
                        input.style.borderColor = '';
                        input.disabled = false;
                        savingFlags.delete(input);
                        
                        // Trigger custom event
                        input.dispatchEvent(new CustomEvent('autosave', {
                            detail: { field, value: input.value, result }
                        }));
                    })
                    .catch(() => {
                        input.style.borderColor = '';
                        input.disabled = false;
                        savingFlags.delete(input);
                    });
            });
        });
    }

    // ============================================================
    // Initialize Auto-Save for Textareas (Ctrl+Enter to save)
    // ============================================================
    function initTextareas() {
        document.querySelectorAll('.auto-save-input[rows]').forEach(textarea => {
            // Only process actual textareas (have rows attribute)
            if (textarea.tagName !== 'TEXTAREA') return;
            
            // Skip if already initialized
            if (textarea.dataset.autoSaveInitialized === 'true') return;
            textarea.dataset.autoSaveInitialized = 'true';
            
            const entity = textarea.dataset.entity;
            const id = textarea.dataset.id;
            const field = textarea.name;
            const saveUrl = textarea.dataset.saveUrl;

            if (!entity || !id) return;

            // ============================================================
            // Ctrl+Enter Handler - Immediate Save for Textareas
            // ============================================================
            textarea.addEventListener('keydown', (e) => {
                if (e.key !== 'Enter') return;
                if (!e.ctrlKey && !e.metaKey) return; // Must be Ctrl+Enter or Cmd+Enter
                
                // Skip if already saving
                if (savingFlags.get(textarea)) return;
                
                // Clear pending debounce timer
                if (debounceTimers.has(textarea)) {
                    clearTimeout(debounceTimers.get(textarea));
                    debounceTimers.delete(textarea);
                }
                
                e.preventDefault();
                
                // Visual feedback
                textarea.style.borderColor = '#10b981';
                Toast.info('Đang lưu...');
                
                // Mark as saving
                savingFlags.set(textarea, true);
                textarea.disabled = true;
                
                saveField(entity, id, field, textarea.value, saveUrl)
                    .then((result) => {
                        textarea.style.borderColor = '';
                        textarea.disabled = false;
                        savingFlags.delete(textarea);
                        
                        textarea.dispatchEvent(new CustomEvent('autosave', {
                            detail: { field, value: textarea.value, result }
                        }));
                    })
                    .catch(() => {
                        textarea.style.borderColor = '';
                        textarea.disabled = false;
                        savingFlags.delete(textarea);
                    });
            });
        });
    }

    // ============================================================
    // Initialize Auto-Save for Selects (immediate)
    // ============================================================
    function initSelects() {
        document.querySelectorAll('.auto-save-select').forEach(select => {
            // Skip if already initialized
            if (select.dataset.autoSaveInitialized === 'true') return;
            select.dataset.autoSaveInitialized = 'true';

            const entity = select.dataset.entity;
            const id = select.dataset.id;
            const field = select.name;
            const saveUrl = select.dataset.saveUrl;

            if (!entity || !id) return;

            select.addEventListener('change', async (e) => {
                select.disabled = true;
                const result = await saveField(entity, id, field, e.target.value, saveUrl);
                select.disabled = false;
                
                select.dispatchEvent(new CustomEvent('autosave', {
                    detail: { field, value: e.target.value, result }
                }));
            });
        });
    }

    // ============================================================
    // Initialize Auto-Save for Checkboxes (immediate)
    // ============================================================
    function initCheckboxes() {
        document.querySelectorAll('.auto-save-checkbox').forEach(checkbox => {
            // Skip if already initialized
            if (checkbox.dataset.autoSaveInitialized === 'true') return;
            checkbox.dataset.autoSaveInitialized = 'true';

            const entity = checkbox.dataset.entity;
            const id = checkbox.dataset.id;
            const field = checkbox.name;
            const saveUrl = checkbox.dataset.saveUrl;

            if (!entity || !id) return;

            checkbox.addEventListener('change', async (e) => {
                checkbox.disabled = true;
                const result = await saveField(entity, id, field, e.target.checked ? '1' : '0', saveUrl);
                checkbox.disabled = false;
                
                checkbox.dispatchEvent(new CustomEvent('autosave', {
                    detail: { field, value: e.target.checked, result }
                }));
            });
        });
    }

    // ============================================================
    // Initialize File Uploads (immediate on change)
    // ============================================================
    function initFileUploads() {
        document.querySelectorAll('.auto-save-file').forEach(input => {
            // Skip if already initialized (prevent duplicate listeners)
            if (input.dataset.autoSaveInitialized === 'true') return;
            input.dataset.autoSaveInitialized = 'true';

            const entity = input.dataset.entity;
            const id = input.dataset.id;
            const field = input.dataset.field || input.name.replace('[]', ''); // Use data-field or strip [] from name
            const uploadUrl = input.dataset.uploadUrl;

            if (!entity || !id) return;

            input.addEventListener('change', async (e) => {
                const files = Array.from(e.target.files);
                if (!files.length) return;

                // Get max images from data attribute or default to 10
                const maxImages = parseInt(input.dataset.maxImages || '10');
                
                // Client-side validation: check file count
                if (files.length > maxImages) {
                    Toast.error(`Chỉ được chọn tối đa ${maxImages} ảnh`);
                    e.target.value = '';
                    return;
                }

                // Show uploading state
                const preview = document.getElementById('imagePreview');
                if (preview) {
                    preview.innerHTML = `<div style="padding: 20px; text-align: center; color: #3b82f6;">Đang tải lên ${files.length} ảnh...</div>`;
                }

                const formData = new FormData();
                
                // Append all files - Laravel expects 'images[]' for array of files
                files.forEach((file, index) => {
                    formData.append('images[]', file);
                });
                formData.append('field', field);

                const url = uploadUrl || `${window.location.origin}/admin/${entity}/${id}/upload-file`;

                try {
                    const response = await fetchWithRetry(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    if (response.ok) {
                        const data = await response.json();
                        Toast.success(data.message || `Đã tải lên ${files.length} ảnh`);
                        
                        // Reload page to show new images
                        setTimeout(() => location.reload(), 800);
                        
                        // Trigger custom event
                        input.dispatchEvent(new CustomEvent('autosave', {
                            detail: { field, files, result: { success: true, data } }
                        }));
                    } else {
                        const error = await response.json();
                        Toast.error(error.message || 'Lỗi khi tải lên');
                        input.value = ''; // Reset file input
                        if (preview) preview.innerHTML = '';
                    }
                } catch (err) {
                    console.error('Upload error:', err);
                    Toast.error('Lỗi kết nối');
                    input.value = '';
                    if (preview) preview.innerHTML = '';
                }
            });
        });
    }

    // ============================================================
    // Image Delete Functions
    // ============================================================
    
    // Generic delete image function
    window.deleteImageNow = async function(entity, entityId, imageId, element) {
        if (!confirm('Xóa ảnh này?')) return;

        // Build URL based on entity type
        let url;
        switch(entity) {
            case 'products':
                // Products: /admin/products/{id}/images/{imageId}
                url = `${window.location.origin}/admin/products/${entityId}/images/${imageId}`;
                break;
            case 'categories':
                // Categories: /admin/categories/{id}/image (single image, no /images/ segment)
                url = `${window.location.origin}/admin/categories/${entityId}/image`;
                break;
            case 'subcategories':
                // Subcategories: /admin/subcategories/{id}/image (single image, no /images/ segment)
                url = `${window.location.origin}/admin/subcategories/${entityId}/image`;
                break;
            case 'posts':
                // Posts: /admin/posts/{id}/thumbnail (single thumbnail, no /images/ segment)
                url = `${window.location.origin}/admin/posts/${entityId}/thumbnail`;
                break;
            default:
                // Generic fallback: /admin/{entity}/{id}/images/{imageId}
                url = `${window.location.origin}/admin/${entity}/${entityId}/images/${imageId}`;
        }
        
        try {
            const response = await fetchWithRetry(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                Toast.success(data.message || 'Đã xóa ảnh');
                
                // Remove element from DOM
                if (element) {
                    element.style.transition = 'all 0.3s ease-out';
                    element.style.opacity = '0';
                    element.style.transform = 'scale(0.8)';
                    setTimeout(() => element.remove(), 300);
                }
                
                return { success: true, data };
            } else {
                const error = await response.json();
                Toast.error(error.message || 'Lỗi khi xóa ảnh');
                return { success: false, error };
            }
        } catch (err) {
            console.error('Delete image error:', err);
            Toast.error('Lỗi kết nối');
            return { success: false, error: err };
        }
    };

    // Product image delete (specific)
    window.deleteProductImage = function(productId, imageId, button) {
        const item = button ? button.closest('.existing-image-item, .image-preview-item') : null;
        return deleteImageNow('products', productId, imageId, item);
    };

    // Category image delete (single image per category)
    window.deleteCategoryImage = function(categoryId, button) {
        const container = button ? button.closest('.category-image-container') : null;
        return deleteImageNow('categories', categoryId, null, container);
    };

    // Category hover image delete
    window.deleteCategoryHoverImage = async function(categoryId, button) {
        if (!confirm('Xóa ảnh hover này?')) return;

        const url = `${window.location.origin}/admin/categories/${categoryId}/hover-image`;
        const container = button ? button.closest('.category-hover-image-container') : null;
        
        try {
            const response = await fetchWithRetry(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                Toast.success(data.message || 'Đã xóa ảnh hover');
                
                // Remove element from DOM
                if (container) {
                    container.style.transition = 'all 0.3s ease-out';
                    container.style.opacity = '0';
                    container.style.transform = 'scale(0.8)';
                    setTimeout(() => container.remove(), 300);
                }
                
                return { success: true, data };
            } else {
                const error = await response.json();
                Toast.error(error.message || 'Lỗi khi xóa ảnh hover');
                return { success: false, error };
            }
        } catch (err) {
            console.error('Delete hover image error:', err);
            Toast.error('Lỗi kết nối');
            return { success: false, error: err };
        }
    };

    // Subcategory image delete (single image per subcategory)
    window.deleteSubcategoryImage = function(subcategoryId, button) {
        const container = button ? button.closest('.subcategory-image-container') : null;
        return deleteImageNow('subcategories', subcategoryId, null, container);
    };

    // Post thumbnail delete (single thumbnail per post)
    window.deletePostThumbnail = function(postId, button) {
        const container = button ? button.closest('.thumbnail-container') : null;
        return deleteImageNow('posts', postId, null, container);
    };

    // ============================================================
    // Settings Auto-Save (special handling)
    // ============================================================
    function initSettingsAutoSave() {
        // Text inputs
        document.querySelectorAll('.settings-auto-save').forEach(input => {
            // Skip if already initialized
            if (input.dataset.autoSaveInitialized === 'true') return;
            input.dataset.autoSaveInitialized = 'true';

            const field = input.name;
            
            input.addEventListener('input', debounce(async (e) => {
                const result = await saveSettingsField(field, e.target.value);
                input.dispatchEvent(new CustomEvent('autosave', { detail: { field, result } }));
            }, 1500));

            input.addEventListener('change', async (e) => {
                const result = await saveSettingsField(field, e.target.value);
                input.dispatchEvent(new CustomEvent('autosave', { detail: { field, result } }));
            });
        });

        // Checkboxes
        document.querySelectorAll('.settings-auto-save-checkbox').forEach(checkbox => {
            // Skip if already initialized
            if (checkbox.dataset.autoSaveInitialized === 'true') return;
            checkbox.dataset.autoSaveInitialized = 'true';

            const field = checkbox.name;
            
            checkbox.addEventListener('change', async (e) => {
                const result = await saveSettingsField(field, e.target.checked ? '1' : '0');
                checkbox.dispatchEvent(new CustomEvent('autosave', { detail: { field, result } }));
            });
        });
    }

    async function saveSettingsField(field, value) {
        const url = `${window.location.origin}/admin/settings/update-field`;
        
        try {
            const response = await fetchWithRetry(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ field, value })
            });

            if (response.ok) {
                const data = await response.json();
                Toast.success(data.message || 'Đã lưu');
                return { success: true, data };
            } else {
                const error = await response.json();
                Toast.error(error.message || 'Lỗi khi lưu');
                return { success: false, error };
            }
        } catch (err) {
            console.error('Settings save error:', err);
            Toast.error('Lỗi kết nối');
            return { success: false, error: err };
        }
    }

    // ============================================================
    // Initialize All Auto-Save Features
    // ============================================================
    function init() {
        initTextInputs();
        initTextareas(); // NEW: Textarea Ctrl+Enter handler
        initSelects();
        initCheckboxes();
        initFileUploads();
        initSettingsAutoSave();

        console.log('[Auto-Save] Initialized');
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Re-initialize on AJAX content load
    document.addEventListener('ajaxContentLoaded', init);

})();
