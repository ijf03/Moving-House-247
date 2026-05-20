// webroot/js/content-blocks-validation.js
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
        tooLong: false,
        invalidEmail: false,
        invalidPhone: false,
        containsHtml: false
    };
    function validateForm() {
        let isValid = true;
        validationErrors.tooLong = false;
        validationErrors.invalidEmail= false;
        validationErrors.invalidPhone=false;
        validationErrors.containsHtml=false;

        if (IS_PHONE) {
            textarea.value = textarea.value.replace(/\D/g, '');
        }

        const currentLength = textarea.value.length;
        const value = textarea.value.trim();

        counter.textContent = `${currentLength} / ${MAX_LENGTH} ${IS_PHONE ? 'digits' : 'characters'}`;

        if (currentLength > MAX_LENGTH) {
            counter.style.color = 'red';
            counter.style.fontWeight = 'bold';
            textarea.style.borderColor = 'red';
            validationErrors.tooLong = true;
            isValid = false;
        } else {
            counter.style.color = '#666';
            counter.style.fontWeight = 'normal';
            textarea.style.borderColor = '';
        }

        if (!IS_HTML) {
            const htmlTagPattern = /<[^>]*>/g;
            if (htmlTagPattern.test(value)) {
                if (htmlTagError) htmlTagError.style.display = 'block';
                textarea.style.borderColor = 'red';
                validationErrors.containsHtml = true;
                isValid = false;
            } else {
                if (htmlTagError) htmlTagError.style.display = 'none';
            }
        }

        if (IS_EMAIL) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(value)) {
                if (emailError) emailError.style.display = 'block';
                textarea.style.borderColor = 'red';
                isValid = false;
                validationErrors.invalidEmail = true;
            } else {
                if (emailError) emailError.style.display = 'none';
            }
        }

        if (IS_PHONE) {
            if (currentLength !== 10) {
                if (phoneError) phoneError.style.display = 'block';
                textarea.style.borderColor = 'red';
                isValid = false;
                validationErrors.invalidPhone = true;
            } else {
                if (phoneError) phoneError.style.display = 'none';
            }
        }

        return isValid;
    }

    textarea.addEventListener('input', validateForm);
    validateForm();

    form.addEventListener('submit', function (event) {
        if (!validateForm()) {
            event.preventDefault();

            if (validationErrors.tooLong) {
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
    });
});
