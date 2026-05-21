document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('content-block-value');
    const counter = document.getElementById('char-counter');
    const emailError = document.getElementById('email-error');
    const phoneError = document.getElementById('phone-error');
    const htmlTagError = document.getElementById('html-tag-error')

    if (!textarea) return;
    const form = textarea.closest('form');
    const MAX_LENGTH = parseInt(textarea.getAttribute('data-maxlength')) || 64;
    const IS_EMAIL = textarea.getAttribute('isEmail') === 'true';
    const IS_PHONE = textarea.getAttribute('isPhone') === 'true';
    const IS_HTML = textarea.getAttribute('isHTML') !== 'false';

    let validationErrors = {
        isEmpty: false,
        tooLong: false,
        invalidEmail: false,
        invalidPhone: false,
        containsHtml: false
    };

    function validateForm(isInitializing = false) {
        let isValid = true;
        validationErrors.isEmpty = false;
        validationErrors.tooLong = false;
        validationErrors.invalidEmail = false;
        validationErrors.invalidPhone = false;
        validationErrors.containsHtml = false;

        if (IS_PHONE) {
            textarea.value = textarea.value.replace(/\D/g, '');
        }

        const currentLength = textarea.value.length;
        const value = textarea.value.trim();

        if (value === '') {
            validationErrors.isEmpty = true;
            isValid = false;
            if (!isInitializing) {
                textarea.style.borderColor = 'red';
            }
        }

        counter.textContent = `${currentLength} / ${MAX_LENGTH} ${IS_PHONE ? 'digits' : 'characters'}`;

        if (currentLength > MAX_LENGTH) {
            if (!isInitializing) {
                counter.style.color = 'red';
                counter.style.fontWeight = 'bold';
                textarea.style.borderColor = 'red';
            }
            validationErrors.tooLong = true;
            isValid = false;
        } else {
            counter.style.color = '#666';
            counter.style.fontWeight = 'normal';
            if (!validationErrors.isEmpty && !isInitializing) {
                textarea.style.borderColor = '';
            }
        }

        if (!IS_HTML) {
            const htmlTagPattern = /<[^>]*>/g;
            if (htmlTagPattern.test(value)) {
                if (htmlTagError && !isInitializing) htmlTagError.style.display = 'block';
                if (!isInitializing) textarea.style.borderColor = 'red';
                validationErrors.containsHtml = true;
                isValid = false;
            } else {
                if (htmlTagError) htmlTagError.style.display = 'none';
            }
        }

        if (IS_EMAIL && value !== '') {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(value)) {
                if (emailError && !isInitializing) emailError.style.display = 'block';
                if (!isInitializing) textarea.style.borderColor = 'red';
                isValid = false;
                validationErrors.invalidEmail = true;
            } else {
                if (emailError) emailError.style.display = 'none';
            }
        }

        if (IS_PHONE && value !== '') {
            if (currentLength !== 10) {
                if (phoneError && !isInitializing) phoneError.style.display = 'block';
                if (!isInitializing) textarea.style.borderColor = 'red';
                isValid = false;
                validationErrors.invalidPhone = true;
            } else {
                if (phoneError) phoneError.style.display = 'none';
            }
        }

        if (isInitializing) {
            textarea.style.borderColor = '';
            if (htmlTagError) htmlTagError.style.display = 'none';
            if (emailError) emailError.style.display = 'none';
            if (phoneError) phoneError.style.display = 'none';
        }

        return isValid;
    }

    textarea.addEventListener('input', function() {
        validateForm(false);
    });


    validateForm(true);
    function handleAlerts() {
        if (validationErrors.isEmpty) {
            alert('Cannot save. The content field cannot be empty. Please enter a value.');
        } else if (validationErrors.tooLong) {
            alert(`Cannot save. The entry exceeds the maximum allowed limit of ${MAX_LENGTH} ${IS_PHONE ? 'digits' : 'characters'}. Please shorten it.`);
        } else if (validationErrors.containsHtml) {
            alert('Cannot save. HTML markup code formatting is not allowed in this plain text field slots.');
        } else if (validationErrors.invalidEmail) {
            alert('Cannot save. Please enter a valid email address with right formatting.');
        } else if (validationErrors.invalidPhone) {
            alert('Cannot save. Phone contacts fields must match exactly 10 numbers');
        } else {
            alert('Cannot save. Please review the highlighted errors.');
        }
    }

    window.validateContentBlockForm = function() {
        const result = validateForm(false);
        if (!result) {
            handleAlerts();
        }
        return result;
    };

    form.addEventListener('submit', function (event) {
        if (!validateForm(false)) {
            event.preventDefault();
            handleAlerts();
        }
    });
});
