@extends('layouts.admin')

@section('page-title', 'Nội Dung Trang')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Quản Lý Nội Dung Trang</h1>
        <p class="admin-page-subtitle">
            <span style="display: inline-flex; align-items: center; gap: 6px;">
                <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></span>
                Tự động lưu đã bật
            </span>
        </p>
    </div>
</div>

{{-- Tab Navigation --}}
<div class="admin-tabs-container">
    <div class="admin-tabs">
        @foreach($groups as $group)
            <button class="admin-tab {{ $loop->first ? 'active' : '' }}" data-tab="{{ $group }}">
                {{ $groupLabels[$group] ?? ucfirst($group) }}
            </button>
        @endforeach
    </div>
</div>

{{-- Tab Content --}}
@foreach($groups as $group)
<div class="admin-tab-content {{ $loop->first ? 'active' : '' }}" id="tab-{{ $group }}">
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">
                <div class="admin-card-title-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                {{ $groupLabels[$group] ?? ucfirst($group) }}
            </h2>
        </div>
        <div class="admin-card-body">
            @php
                $groupBlocks = $blocks->where('group', $group);
            @endphp
            
            @if($groupBlocks->isEmpty())
                <p style="color: var(--admin-text-muted); font-size: 14px;">Không có nội dung nào trong nhóm này.</p>
            @else
                <div class="content-blocks-grid">
                    @foreach($groupBlocks as $block)
                        <div class="content-block-item">
                            <label class="content-block-label">
                                {{ $block->label }}
                                @if($block->description)
                                    <span class="content-block-description">
                                        {{ $block->description }}
                                    </span>
                                @endif
                            </label>
                            
                            @if($block->type === 'textarea')
                                <textarea 
                                    name="content_{{ $block->key }}" 
                                    data-key="{{ $block->key }}"
                                    rows="3" 
                                    class="content-block-input content-block-auto-save"
                                    placeholder="Nhập nội dung...">{{ old('content_' . $block->key, $block->value) }}</textarea>
                            @elseif($block->type === 'richtext')
                                <textarea 
                                    name="content_{{ $block->key }}" 
                                    data-key="{{ $block->key }}"
                                    rows="5" 
                                    class="content-block-input content-block-auto-save"
                                    placeholder="Nhập nội dung...">{{ old('content_' . $block->key, $block->value) }}</textarea>
                            @else
                                <input 
                                    type="text" 
                                    name="content_{{ $block->key }}" 
                                    data-key="{{ $block->key }}"
                                    value="{{ old('content_' . $block->key, $block->value) }}" 
                                    class="content-block-input content-block-auto-save"
                                    placeholder="Nhập nội dung...">
                            @endif
                            
                            <div class="content-block-key">
                                <code>{{ $block->key }}</code>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endforeach

@endsection

@push('styles')
<style>
.admin-tabs-container {
    margin-bottom: 24px;
    border-bottom: 1px solid var(--admin-border);
}

.admin-tabs {
    display: flex;
    gap: 4px;
    overflow-x: auto;
}

.admin-tab {
    padding: 12px 20px;
    background: transparent;
    border: none;
    border-bottom: 2px solid transparent;
    color: var(--admin-text-muted);
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.admin-tab:hover {
    color: var(--admin-text-primary);
    background: var(--admin-bg-hover);
}

.admin-tab.active {
    color: var(--admin-primary);
    border-bottom-color: var(--admin-primary);
}

.admin-tab-content {
    display: none;
}

.admin-tab-content.active {
    display: block;
}

/* Content Blocks Grid Layout */
.content-blocks-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 20px;
}

.content-block-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 16px;
    background: var(--admin-card-bg, #ffffff);
    border: 1px solid var(--admin-border);
    border-radius: var(--admin-radius-lg);
    transition: all 0.2s;
}

.content-block-item:hover {
    border-color: var(--admin-border-hover, #d1d5db);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.content-block-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--admin-text-primary);
    margin: 0;
}

.content-block-description {
    display: block;
    font-weight: 400;
    color: var(--admin-text-muted);
    font-size: 12px;
    margin-top: 2px;
}

.content-block-input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--admin-border);
    border-radius: var(--admin-radius-md);
    font-size: 14px;
    font-family: inherit;
    transition: border-color 0.2s, box-shadow 0.2s, background-color 0.2s;
}

.content-block-input:focus {
    outline: none;
    border-color: var(--admin-primary);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

textarea.content-block-input {
    resize: vertical;
    min-height: 80px;
}

.content-block-key {
    margin-top: 4px;
}

.content-block-key code {
    display: inline-block;
    background: #f3f4f6;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-family: 'Courier New', monospace;
    color: #6b7280;
}

/* Auto-save states */
.content-block-auto-save.saving {
    border-color: #f59e0b;
    background: #fffbeb;
}

.content-block-auto-save.saved {
    border-color: #10b981;
    background: #ecfdf5;
}

.content-block-auto-save.error {
    border-color: #ef4444;
    background: #fef2f2;
}

/* Responsive */
@media (max-width: 1024px) {
    .content-blocks-grid {
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    }
}

@media (max-width: 768px) {
    .content-blocks-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabs = document.querySelectorAll('.admin-tab');
    const tabContents = document.querySelectorAll('.admin-tab-content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Update active tab
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Update active content
            tabContents.forEach(content => {
                if (content.id === 'tab-' + targetTab) {
                    content.classList.add('active');
                } else {
                    content.classList.remove('active');
                }
            });
        });
    });
    
    // Auto-save functionality
    const saveTimers = {};
    const saveDelay = 1000; // 1 second delay after typing stops
    
    document.querySelectorAll('.content-block-auto-save').forEach(input => {
        input.addEventListener('input', function() {
            const key = this.dataset.key;
            const inputElement = this;
            
            // Clear existing timer
            if (saveTimers[key]) {
                clearTimeout(saveTimers[key]);
            }
            
            // Show saving state
            inputElement.classList.remove('saved', 'error');
            inputElement.classList.add('saving');
            
            // Set new timer
            saveTimers[key] = setTimeout(() => {
                saveContentBlock(key, inputElement.value, inputElement);
            }, saveDelay);
        });
    });
    
    function saveContentBlock(key, value, inputElement) {
        fetch('{{ route("admin.content-blocks.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                key: key,
                value: value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success state
                inputElement.classList.remove('saving', 'error');
                inputElement.classList.add('saved');
                
                // Remove success state after 2 seconds
                setTimeout(() => {
                    inputElement.classList.remove('saved');
                }, 2000);
            } else {
                throw new Error(data.message || 'Lỗi không xác định');
            }
        })
        .catch(error => {
            console.error('Error saving content block:', error);
            
            // Show error state
            inputElement.classList.remove('saving', 'saved');
            inputElement.classList.add('error');
            
            // Remove error state after 3 seconds
            setTimeout(() => {
                inputElement.classList.remove('error');
            }, 3000);
        });
    }
});
</script>
@endpush
