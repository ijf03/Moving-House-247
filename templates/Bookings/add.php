<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var \Cake\Collection\CollectionInterface|string[] $customers
 * @var \Cake\Collection\CollectionInterface|string[] $jobTypes
 */
?>

<div class="booking-page">
    <section class="booking-hero">
        <div class="container">
            <div class="booking-hero-shell">
                <div class="booking-hero-content">
                    <p class="booking-eyebrow">Moving House 24/7</p>
                    <h1>Book a Service</h1>
                    <p class="booking-hero-text">
                        Tell us the details of your move and we will get your booking into the system.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="booking-section">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-4">
                    <div class="booking-info-stack">
                        <div class="mh-info-card">
                            <div class="mh-info-icon">📦</div>
                            <div>
                                <h3>Simple Booking</h3>
                                <p>
                                    Fill in your service type, addresses, and preferred job schedule.
                                </p>
                            </div>
                        </div>

                        <div class="mh-info-card">
                            <div class="mh-info-icon">🚚</div>
                            <div>
                                <h3>Removal, Storage, or Transfer</h3>
                                <p>
                                    Choose the service that best fits your moving needs.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="mh-form-card">
                        <div class="booking-form-header">
                            <h2>Booking Details</h2>
                            <p>Complete the form below to submit your booking request.</p>
                        </div>

                        <?= $this->Form->create($booking, ['class' => 'booking-form']) ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <?=
                                $this->Form->control('job_type_id', [
                                    'type' => 'select',
                                    'label' => 'Service Type',
                                    'empty' => 'Please select a service type',
                                    'options' => [
                                        1 => 'Removal',
                                        2 => 'Storage',
                                        3 => 'Transfer',
                                    ],
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ])
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?=
                                $this->Form->control('job_date', [
                                    'type' => 'date',
                                    'min' => date('Y-m-d'),
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ])
                                ?>
                            </div>


                            <div class="col-12">
                                <?= $this->Form->control('pickup_street_address', [
                                    'id'   => 'pickup-street-address',
                                    'autocomplete' => 'off',
                                    'label' => 'Pickup Street Address',
                                    'placeholder' => 'e.g. 123 Queen Street',
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('pickup_suburb', [
                                    'label' => 'Pickup Suburb',
                                    'placeholder' => 'e.g. Melbourne',
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('pickup_postcode', [
                                    'label' => 'Pickup Postcode',
                                    'placeholder' => 'e.g. 3000',
                                    'pattern' => '[0-9]{4}',
                                    'inputmode' => 'numeric',
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ]) ?>
                            </div>


                            <div class="col-12">
                                <?= $this->Form->control('dropoff_street_address', [
                                    'id' => 'dropoff-street-address',
                                    'autocomplete' => 'off',
                                    'label' => 'Dropoff Street Address',
                                    'placeholder' => 'e.g. 456 Collins Street',
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('dropoff_suburb', [
                                    'label' => 'Dropoff Suburb',
                                    'placeholder' => 'e.g. Richmond',
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('dropoff_postcode', [
                                    'label' => 'Dropoff Postcode',
                                    'placeholder' => 'e.g. 3121',
                                    'pattern' => '[0-9]{4}',
                                    'inputmode' => 'numeric',
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?=
                                $this->Form->control('job_time', [
                                    'type' => 'time',
                                    'step' => 60,
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ])
                                ?>
                            </div>

                            <div class="col-12">
                                <?= $this->Form->control('message', [
                                    'type' => 'textarea',
                                    'label' => 'Additional Message',
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ]) ?>
                            </div>
                        </div>

                        <div class="booking-form-actions">
                            <?= $this->Form->button(__('Submit Booking'), ['class' => 'booking-submit-btn']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if (!empty($geoapifyApiKey)): ?>
    <style>
        .address-suggestions {
            position: relative;
            z-index: 1000;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-top: 4px;
            max-height: 220px;
            overflow-y: auto;
        }

        .address-suggestion-item {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }

        .address-suggestion-item:hover {
            background: #f5f5f5;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const apiKey = <?= json_encode($geoapifyApiKey) ?>;

            function setupAutocomplete(streetId, suburbName, postcodeName) {
                const streetInput = document.getElementById(streetId);
                const suburbInput = document.querySelector(`[name="${suburbName}"]`);
                const postcodeInput = document.querySelector(`[name="${postcodeName}"]`);

                if (!streetInput) {
                    return;
                }

                const suggestionsBox = document.createElement('div');
                suggestionsBox.className = 'address-suggestions';
                streetInput.parentNode.appendChild(suggestionsBox);

                let timer = null;

                streetInput.addEventListener('input', function () {
                    const text = streetInput.value.trim();

                    clearTimeout(timer);
                    suggestionsBox.innerHTML = '';

                    if (text.length < 3) {
                        return;
                    }

                    timer = setTimeout(function () {
                        const url =
                            'https://api.geoapify.com/v1/geocode/autocomplete' +
                            '?text=' + encodeURIComponent(text) +
                            '&format=json' +
                            '&filter=countrycode:au' +
                            '&limit=30' +
                            '&apiKey=' + encodeURIComponent(apiKey);

                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                suggestionsBox.innerHTML = '';

                                if (!data.results || data.results.length === 0) {
                                    return;
                                }

                                data.results.forEach(result => {
                                    const isVictoria =
                                        result.state === 'Victoria' ||
                                        result.state_code === 'VIC';

                                    if (!isVictoria) {
                                        return;
                                    }

                                    const item = document.createElement('div');
                                    item.className = 'address-suggestion-item';
                                    item.textContent = result.formatted;

                                    item.addEventListener('click', function () {
                                        streetInput.value = result.address_line1 || result.formatted;

                                        const suburb =
                                            result.suburb ||
                                            result.city ||
                                            result.town ||
                                            result.village ||
                                            result.district ||
                                            '';

                                        if (suburbInput) {
                                            suburbInput.value = suburb;
                                        }

                                        if (postcodeInput) {
                                            postcodeInput.value = result.postcode || '';
                                        }

                                        suggestionsBox.innerHTML = '';
                                    });

                                    suggestionsBox.appendChild(item);
                                });
                            })
                            .catch(() => {
                                suggestionsBox.innerHTML = '';
                            });
                    }, 300);
                });

                document.addEventListener('click', function (event) {
                    if (!suggestionsBox.contains(event.target) && event.target !== streetInput) {
                        suggestionsBox.innerHTML = '';
                    }
                });
            }

            setupAutocomplete('pickup-street-address', 'pickup_suburb', 'pickup_postcode');
            setupAutocomplete('dropoff-street-address', 'dropoff_suburb', 'dropoff_postcode');
        });
    </script>
<?php endif; ?>
