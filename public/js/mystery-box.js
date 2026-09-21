// Mystery Box Multi-step Form
(function() {
    const form = document.getElementById('mysteryBoxForm');
    if (!form) return;

    let currentStep = 1;
    const totalSteps = 7;

    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    // Initialize
    updateStepDisplay();
    loadFromLocalStorage();

    // Navigation
    nextBtn.addEventListener('click', function() {
        if (validateStep(currentStep)) {
            saveToLocalStorage();
            if (currentStep < totalSteps) {
                currentStep++;
                updateStepDisplay();
            }
        }
    });

    prevBtn.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateStepDisplay();
        }
    });

    // Save form state to localStorage
    function saveToLocalStorage() {
        const formData = {
            style: getSelectedRadio('style'),
            colors: getSelectedCheckboxes('colors[]'),
            preferences: getSelectedCheckboxes('preferences[]'),
            budget_range: getSelectedRadio('budget_range'),
            surprise_level: getSelectedRadio('surprise_level'),
            name: document.getElementById('name')?.value || '',
            phone: document.getElementById('phone')?.value || '',
            email: document.getElementById('email')?.value || '',
            note: document.getElementById('note')?.value || '',
        };
        localStorage.setItem('mysteryBoxForm', JSON.stringify(formData));
    }

    // Load form state from localStorage
    function loadFromLocalStorage() {
        const saved = localStorage.getItem('mysteryBoxForm');
        if (!saved) return;

        try {
            const formData = JSON.parse(saved);
            
            if (formData.style) setRadio('style', formData.style);
            if (formData.colors) setCheckboxes('colors[]', formData.colors);
            if (formData.preferences) setCheckboxes('preferences[]', formData.preferences);
            if (formData.budget_range) setRadio('budget_range', formData.budget_range);
            if (formData.surprise_level) setRadio('surprise_level', formData.surprise_level);
            if (formData.name) document.getElementById('name').value = formData.name;
            if (formData.phone) document.getElementById('phone').value = formData.phone;
            if (formData.email) document.getElementById('email').value = formData.email;
            if (formData.note) document.getElementById('note').value = formData.note;
        } catch (e) {
            console.error('Failed to load saved form data', e);
        }
    }

    // Clear localStorage on successful submit
    form.addEventListener('submit', function() {
        localStorage.removeItem('mysteryBoxForm');
    });

    // Helper: Get selected radio value
    function getSelectedRadio(name) {
        const radio = document.querySelector(`input[name="${name}"]:checked`);
        return radio ? radio.value : '';
    }

    // Helper: Get selected checkbox values
    function getSelectedCheckboxes(name) {
        const checkboxes = document.querySelectorAll(`input[name="${name}"]:checked`);
        return Array.from(checkboxes).map(cb => cb.value);
    }

    // Helper: Set radio button
    function setRadio(name, value) {
        const radio = document.querySelector(`input[name="${name}"][value="${value}"]`);
        if (radio) radio.checked = true;
    }

    // Helper: Set checkboxes
    function setCheckboxes(name, values) {
        values.forEach(value => {
            const checkbox = document.querySelector(`input[name="${name}"][value="${value}"]`);
            if (checkbox) checkbox.checked = true;
        });
    }

    // Update step display
    function updateStepDisplay() {
        // Update step indicator
        document.querySelectorAll('.step-item').forEach((item, index) => {
            const stepNum = index + 1;
            item.classList.remove('active', 'completed');
            
            if (stepNum === currentStep) {
                item.classList.add('active');
            } else if (stepNum < currentStep) {
                item.classList.add('completed');
            }
        });

        // Update step content
        document.querySelectorAll('.step-content').forEach((content, index) => {
            const stepNum = index + 1;
            content.classList.toggle('active', stepNum === currentStep);
        });

        // Update buttons
        prevBtn.style.display = currentStep === 1 ? 'none' : 'flex';
        nextBtn.style.display = currentStep === totalSteps ? 'none' : 'flex';
        submitBtn.style.display = currentStep === totalSteps ? 'flex' : 'none';

        // Update summary on final step
        if (currentStep === totalSteps) {
            updateSummary();
        }

        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Validate current step
    function validateStep(step) {
        let valid = true;
        let errorMessage = '';

        switch(step) {
            case 1: // Style
                if (!getSelectedRadio('style')) {
                    errorMessage = 'Vui lòng chọn phong cách';
                    valid = false;
                }
                break;
            case 2: // Colors
                if (getSelectedCheckboxes('colors[]').length === 0) {
                    errorMessage = 'Vui lòng chọn ít nhất một màu sắc';
                    valid = false;
                }
                break;
            case 3: // Preferences
                if (getSelectedCheckboxes('preferences[]').length === 0) {
                    errorMessage = 'Vui lòng chọn ít nhất một sở thích';
                    valid = false;
                }
                break;
            case 4: // Budget
                if (!getSelectedRadio('budget_range')) {
                    errorMessage = 'Vui lòng chọn ngân sách';
                    valid = false;
                }
                break;
            case 5: // Surprise level
                if (!getSelectedRadio('surprise_level')) {
                    errorMessage = 'Vui lòng chọn mức độ bất ngờ';
                    valid = false;
                }
                break;
            case 6: // Contact info
                const name = document.getElementById('name').value.trim();
                const phone = document.getElementById('phone').value.trim();
                
                if (!name) {
                    errorMessage = 'Vui lòng nhập họ và tên';
                    valid = false;
                } else if (!phone) {
                    errorMessage = 'Vui lòng nhập số điện thoại';
                    valid = false;
                } else if (!/^[0-9\+\-\s]+$/.test(phone)) {
                    errorMessage = 'Số điện thoại không hợp lệ';
                    valid = false;
                }
                break;
        }

        if (!valid && errorMessage) {
            alert(errorMessage);
        }

        return valid;
    }

    // Update summary on final step
    function updateSummary() {
        // Style
        const style = getSelectedRadio('style');
        document.getElementById('summary-style').textContent = style || '-';

        // Colors
        const colors = getSelectedCheckboxes('colors[]');
        document.getElementById('summary-colors').textContent = colors.length > 0 ? colors.join(' · ') : '-';

        // Preferences
        const preferences = getSelectedCheckboxes('preferences[]');
        document.getElementById('summary-preferences').textContent = preferences.length > 0 ? preferences.join(' · ') : '-';

        // Budget
        const budget = getSelectedRadio('budget_range');
        const budgetLabel = {
            '500k-1M': '500.000đ - 1.000.000đ',
            '1M-2M': '1.000.000đ - 2.000.000đ',
            '2M-5M': '2.000.000đ - 5.000.000đ',
            '5M+': '5.000.000đ+'
        };
        document.getElementById('summary-budget').textContent = budgetLabel[budget] || '-';

        // Surprise level
        const surprise = getSelectedRadio('surprise_level');
        document.getElementById('summary-surprise').textContent = surprise || '-';
    }

    // Auto-save on input change
    form.addEventListener('change', function() {
        saveToLocalStorage();
    });

    form.addEventListener('input', function(e) {
        if (e.target.matches('input[type="text"], input[type="tel"], input[type="email"], textarea')) {
            saveToLocalStorage();
        }
    });
})();
