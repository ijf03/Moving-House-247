document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.booking-form');

    if (!form) {
        return;
    }

    const rules = {
        job_date: {
            message: 'Please choose a booking date.'
        },
        job_time: {
            message: 'Please choose a booking time.'
        },
        pickup_street_address: {
            message: 'Please enter a pickup street address.'
        },
        pickup_suburb: {
            message: 'Please enter a pickup suburb.'
        },
        pickup_postcode: {
            message: 'Pickup postcode must be exactly 4 digits.',
            pattern: /^[0-9]{4}$/
        },
        dropoff_street_address: {
            message: 'Please enter a dropoff street address.'
        },
        dropoff_suburb: {
            message: 'Please enter a dropoff suburb.'
        },
        dropoff_postcode: {
            message: 'Dropoff postcode must be exactly 4 digits.',
            pattern: /^[0-9]{4}$/
        }
    };

    const touchedFields = new Set();

    function getInput(name) {
        return form.querySelector(`[name="${name}"]`);
    }

    function getFieldGroup(input) {
        return input.closest('.booking-form-group') || input.parentElement;
    }

    function getErrorElement(input) {
        const fieldGroup = getFieldGroup(input);
        let error = fieldGroup.querySelector('.error-message.js-error-message');

        if (!error) {
            error = document.createElement('div');
            error.className = 'error-message js-error-message';
            fieldGroup.appendChild(error);
        }

        return error;
    }

    function isActive(input) {
        return !input.disabled && input.offsetParent !== null;
    }

    function showError(input, message) {
        const error = getErrorElement(input);
        error.textContent = message;
    }

    function clearError(input) {
        const error = getErrorElement(input);
        error.textContent = '';
    }

    function validateField(name, showMessage = true) {
        const input = getInput(name);
        const rule = rules[name];

        if (!input || !rule) {
            return true;
        }

        if (!isActive(input)) {
            clearError(input);
            return true;
        }

        const value = input.value.trim();

        if (value === '') {
            if (showMessage) {
                showError(input, rule.message);
            }
            return false;
        }

        if (rule.pattern && !rule.pattern.test(value)) {
            if (showMessage) {
                showError(input, rule.message);
            }
            return false;
        }

        if (input.type === 'date' && input.min && value < input.min) {
            if (showMessage) {
                showError(input, 'Booking date must be at least 7 days from today.');
            }
            return false;
        }

        clearError(input);
        return true;
    }

    Object.keys(rules).forEach(function (fieldName) {
        const input = getInput(fieldName);

        if (!input) {
            return;
        }

        input.addEventListener('blur', function () {
            touchedFields.add(fieldName);
            validateField(fieldName, true);
        });

        input.addEventListener('input', function () {
            if (touchedFields.has(fieldName)) {
                validateField(fieldName, true);
            }
        });

        input.addEventListener('change', function () {
            touchedFields.add(fieldName);
            validateField(fieldName, true);
        });
    });

    form.addEventListener('submit', function (event) {
        let formIsValid = true;

        Object.keys(rules).forEach(function (fieldName) {
            const valid = validateField(fieldName, true);

            if (!valid) {
                formIsValid = false;
            }
        });

        if (!formIsValid) {
            event.preventDefault();

            const firstError = form.querySelector('.js-error-message:not(:empty)');

            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }
    });
});
