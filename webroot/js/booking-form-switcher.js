document.addEventListener('DOMContentLoaded', function () {
    const config = window.bookingFormConfig;

    if (!config || !config.bookingTypes) {
        return;
    }

    const bookingTypes = config.bookingTypes;

    const jobTypeInput = document.getElementById('job-type-id');
    const bookingTitle = document.getElementById('booking-title');
    const bookingDescription = document.getElementById('booking-description');
    const selectedServiceName = document.getElementById('selected-service-name');
    const selectedServiceDescription = document.getElementById('selected-service-description');

    const switchButtons = document.querySelectorAll('.booking-service-btn');
    const dropoffFields = document.querySelectorAll('.dropoff-field');

    function setLabel(inputName, labelText) {
        const input = document.querySelector(`[name="${inputName}"]`);

        if (!input) {
            return;
        }

        const group = input.closest('.booking-form-group');

        if (!group) {
            return;
        }

        const label = group.querySelector('label');

        if (label) {
            label.textContent = labelText;
        }
    }

    function updateForm(jobTypeId) {
        const selectedType = bookingTypes[jobTypeId];

        if (!selectedType) {
            return;
        }

        const requiresDropoff =
            selectedType.requires_dropoff === true ||
            selectedType.requires_dropoff === 1 ||
            selectedType.requires_dropoff === '1';

        jobTypeInput.value = jobTypeId;

        bookingTitle.textContent = `Book a ${selectedType.name}`;
        bookingDescription.textContent = selectedType.description;

        selectedServiceName.textContent = selectedType.name;
        selectedServiceDescription.textContent = selectedType.description;

        setLabel('pickup_street_address', `${selectedType.pickup_label} - Street Address`);
        setLabel('pickup_suburb', `${selectedType.pickup_label} - Suburb`);
        setLabel('pickup_postcode', `${selectedType.pickup_label} - Postcode`);

        setLabel('dropoff_street_address', `${selectedType.dropoff_label} - Street Address`);
        setLabel('dropoff_suburb', `${selectedType.dropoff_label} - Suburb`);
        setLabel('dropoff_postcode', `${selectedType.dropoff_label} - Postcode`);

        dropoffFields.forEach(function (fieldGroup) {
            fieldGroup.hidden = !requiresDropoff;

            fieldGroup.querySelectorAll('input').forEach(function (input) {
                input.required = requiresDropoff;
                input.disabled = !requiresDropoff;

                if (!requiresDropoff) {
                    input.value = '';
                }
            });
        });

        switchButtons.forEach(function (button) {
            button.hidden = button.dataset.jobTypeId === String(jobTypeId);
        });
    }

    switchButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            updateForm(button.dataset.jobTypeId);
        });
    });

    updateForm(config.selectedJobTypeId);
});
