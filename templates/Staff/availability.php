<head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js'></script>
    <script>
        window.activeEventID = null;
        offset = new Date().getTimezoneOffset();
        isPlus = String(offset).includes("+")?"+":"-";
        absOffset = Math.abs(offset);
        const hours = String(Math.floor(absOffset / 60)).padStart(2, "0");
        const minutes = String(absOffset % 60).padStart(2, "0");
        window.timezoneOffset = (isPlus?"+":"-")+hours+":"+minutes;

        function datetimeFormat(datetime){
            split = datetime.split(':');
            return split[0]+':'+split[1];
        }

        function addOffset(datetime){
            var head = datetime.toString().split(datetime.toString().includes("+")?"+":"-")[0];
            return head;
        }

        window.addEventListener('load', ()=>{
            var current = new Date().toISOString().split(".")[0];
            current = datetimeFormat(current);
            var start_datetime = document.getElementById('start_datetime');
            var end_datetime = document.getElementById('end_datetime');
            var new_start = document.getElementById('new_start');
            var new_end = document.getElementById('new_end');
            start_datetime.min = current;
            new_start.min = current;
            start_datetime.addEventListener('change', ()=>{
                end_datetime.min = start_datetime.value;

                if (end_datetime.value && end_datetime.value < start_datetime.value){
                    end_datetime.value = start_datetime.value;
                }
            })
            new_start.addEventListener('change', ()=>{
                new_end.min = new_start.value;

                if (new_end.value && new_end.value < new_start.value){
                    new_end.value = new_start.value;
                }
            })

        })
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var events = <?= json_encode($events) ?>;
            var formatted_events = Object.keys(events).map(function(id) {
                return {
                    start: events[id]['start'],
                    end: events[id]['end'],
                    id: events[id]['id'],
                    backgroundColor: '#FF0000',
                    deleted: false
                };
            });
            window.calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 800 ? 'timeGrid' : 'timeGridWeek',
                duration: {days: window.innerWidth < 600 ? 1 : 3},
                windowResize: function (){
                    calendar.changeView(window.innerWidth < 900 ? 'timeGrid' : 'timeGridWeek');
                    calendar.setOption('duration', { days: window.innerWidth < 600 ? 1 : 3 });
                },
                height: 'auto',
                editable: true,
                events: formatted_events,
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: 'short'
                },
                allDaySlot: false,
                eventResizableFromStart: true,
                eventResize: function(info) {
                    console.log(info);
                    var event = info.event;
                    var start = addOffset(event.startStr);
                    var end = addOffset(event.endStr);
                    if (isNaN(new Date(start))||isNaN(new Date(end))){
                        alert('Invalid Datetime!');
                        return;
                    }
                    if (!start|| !end){
                        alert('Start time and end time cannot be empty!');
                        return;
                    }
                    if (Date.parse(start) >= Date.parse(end)){
                        alert('Start time must be earlier than end time');
                        return
                    }
                    if (!confirm('Change available time to '+datetimeFormat(start.replace('T',' '))+' - '+datetimeFormat(end.replace('T',' '))+'?\nYou will receive jobs for that period of time')){
                        return;
                    }
                    submitForm()
                },
                eventDrop: function(info) {
                    console.log(info);
                    var event = info.event;
                    var start = addOffset(event.startStr);
                    var end = addOffset(event.endStr);
                    if (isNaN(new Date(start))||isNaN(new Date(end))){
                        alert('Invalid Datetime!');
                        return;
                    }
                    if (!start|| !end){
                        alert('Start time and end time cannot be empty!');
                        return;
                    }
                    if (Date.parse(start) >= Date.parse(end)){
                        alert('Start time must be earlier than end time');
                        return
                    }
                    if (!confirm('Change available time to '+datetimeFormat(start.replace('T',' '))+' - '+datetimeFormat(end.replace('T',' '))+'?\nYou will receive jobs for that period of time')){
                        return;
                    }
                    submitForm()
                },
                eventClick: function(info) {
                    const event = info.event;
                    activeEventID = event.id;
                    window.startTimezone = (event.startStr.includes("+")?"+":"-")+event.startStr.split(event.startStr.includes("+")?"+":"-")[-1]
                    window.endTimezone = (event.endStr.includes("+")?"+":"-")+event.endStr.split(event.endStr.includes("+")?"+":"-")[-1]
                    document.getElementById('start_datetime').value = datetimeFormat(event.startStr.split(event.startStr.includes("+")?"+":"-").slice(0,-1).join('-'));
                    document.getElementById('end_datetime').value = datetimeFormat(event.endStr.split(event.endStr.includes("+")?"+":"-").slice(0,-1).join('-'));

                    document.querySelector('.modal-title').innerText = 'Edit Availability';

                    var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                    modal.show();

                    window.activeEvent = event;
                }
            });
            calendar.render();
        });

        function submitForm() {
            const events = calendar.getEvents().map(event => ({
                id: event.id,
                start_datetime: addOffset(event.start),
                end_datetime: addOffset(event.end),
                deleted: event.extendedProps.deleted
            }));

            document.getElementById('availability-json').value = JSON.stringify(events);

            document.getElementById('availability-form').submit();
        }

        function save() {
            var start = document.getElementById('start_datetime').value;
            var end = document.getElementById('end_datetime').value;
            if (isNaN(new Date(start))||isNaN(new Date(end))){
                alert('Invalid Datetime!');
                return;
            }
            if (!start|| !end){
                alert('Start time and end time cannot be empty!');
                return;
            }
            if (Date.parse(start) >= Date.parse(end)){
                alert('Start time must be earlier than end time');
                return
            }
            if (!confirm('Change available time to '+datetimeFormat(start.replace('T',' '))+' - '+datetimeFormat(end.replace('T',' '))+'?\nYou will receive jobs for that period of time')){
                return;
            }
            calendar.getEventById(activeEventID).setDates(document.getElementById('start_datetime').value + startTimezone,
                document.getElementById('end_datetime').value + endTimezone);
            submitForm();
        }

        function newEvent() {
            document.getElementById('new_start').value = null;
            document.getElementById('new_end').value = null;
            var modal = new bootstrap.Modal(document.getElementById('addEventModal'));
            modal.show();
        }
        function add() {
            var start = document.getElementById('new_start').value;
            var end = document.getElementById('new_end').value;
            if (isNaN(new Date(start))||isNaN(new Date(end))){
                alert('Invalid Datetime!');
                return;
            }
            if (!start || !end){
                alert('Start time and end time cannot be empty!');
                return;
            }
            if (Date.parse(start) >= Date.parse(end)){
                alert('Start time must be earlier than end time');
                return;
            }
            if (!confirm('Do you want to mark '+datetimeFormat(start.replace('T',' '))+' - '+datetimeFormat(end.replace('T',' '))+' as available?\nYou will receive jobs for that period of time')){
                return;
            }
            calendar.addEvent(
                {
                    id: null,
                    start: document.getElementById('new_start').value+timezoneOffset,
                    end: document.getElementById('new_end').value+timezoneOffset,
                    backgroundColor: '#FF0000',
                    deleted: false
                });
            submitForm();
        }

        function deleteEvent() {
            calendar.getEventById(activeEventID).setExtendedProp('deleted', true);
            submitForm();
        }

    </script>
</head>
<body>
<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Staff') ?></span>
                    <h1><?= __('Manage Availability') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Add and manage times when you are available for jobs.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="admin-table-card">
                <div class="admin-table-header admin-table-header-split">
                    <div>
                        <h2><?= __('Available Schedule') ?></h2>
                        <p><?= __('Click an event to edit available time blocks.') ?></p>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <?= $this->Form->create(null, ['id' => 'availability-form']) ?>

                        <?= $this->Form->button(__('Add Available Time'), [
                            'type' => 'button',
                            'onclick' => 'newEvent()',
                            'class' => 'admin-primary-link'
                        ]) ?>

                        <?= $this->Form->control('availability_json', [
                            'type' => 'hidden',
                            'id' => 'availability-json'
                        ]) ?>

                        <?= $this->Form->end() ?>
                    </div>
                </div>

                <div class="mh-form-card p-3">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content mh-form-card">
            <div class="modal-header border-0 px-0 pt-0">
                <h5 class="modal-title" id="modalTitle"><?= __('Timeslot Details') ?></h5>
            </div>

            <div class="modal-body px-0 mh-form">
                <div class="mb-3">
                    <label for="start_datetime" class="form-label fw-bold"><?= __('Start time') ?></label>
                    <input type="datetime-local" id="start_datetime" step="60" required/>
                </div>

                <div class="mb-3">
                    <label for="end_datetime" class="form-label fw-bold"><?= __('End time') ?></label>
                    <input type="datetime-local" id="end_datetime" step="60" required/>
                </div>
            </div>

            <div class="modal-footer border-0 px-0 pb-0 d-flex justify-content-between">
                <button type="button" class="admin-action-link admin-action-link-danger" id="btn-delete" onclick="deleteEvent()">
                    <?= __('Delete') ?>
                </button>

                <div class="d-flex gap-2">
                    <button type="button" class="admin-action-link" data-bs-dismiss="modal">
                        <?= __('Cancel') ?>
                    </button>

                    <button type="button" class="admin-primary-link" onclick="save()">
                        <?= __('Apply Changes') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content mh-form-card">
            <div class="modal-header border-0 px-0 pt-0">
                <h5 class="modal-title" id="modalTitle"><?= __('Add Availability') ?></h5>
            </div>

            <div class="modal-body px-0 mh-form">
                <div class="mb-3">
                    <label for="new_start" class="form-label fw-bold"><?= __('Start time') ?></label>
                    <input type="datetime-local" id="new_start" step="60" required/>
                </div>

                <div class="mb-3">
                    <label for="new_end" class="form-label fw-bold"><?= __('End time') ?></label>
                    <input type="datetime-local" id="new_end" step="60" required/>
                </div>
            </div>

            <div class="modal-footer border-0 px-0 pb-0">
                <button type="button" class="admin-action-link" data-bs-dismiss="modal">
                    <?= __('Cancel') ?>
                </button>

                <button type="button" class="admin-primary-link" onclick="add()">
                    <?= __('Save') ?>
                </button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
