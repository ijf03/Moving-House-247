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

        window.addEventListener('load', ()=>{
            var current = new Date().toISOString().split(".")[0];
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
                    backgroundColor: '#FF0000'
                };
            });
            window.calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                height: '1600px',
                editable: true,
                events: formatted_events,
                eventResizableFromStart: true,
                eventClick: function(info) {
                    const event = info.event;
                    activeEventID = event.id;
                    window.startTimezone = (event.startStr.includes("+")?"+":"-")+event.startStr.split(event.startStr.includes("+")?"+":"-")[1]
                    window.endTimezone = (event.endStr.includes("+")?"+":"-")+event.endStr.split(event.endStr.includes("+")?"+":"-")[1]
                    document.getElementById('start_datetime').value = event.startStr.split(event.startStr.includes("+")?"+":"-")[0];
                    document.getElementById('end_datetime').value = event.endStr.split(event.endStr.includes("+")?"+":"-")[0];

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
                start_datetime: event.start,
                end_datetime: event.end
            }));

            document.getElementById('availability-json').value = JSON.stringify(events);

            document.getElementById('availability-form').submit();
        }

        function save() {
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
            calendar.addEvent(
                {
                    id: null,
                    start: document.getElementById('new_start').value+timezoneOffset,
                    end: document.getElementById('new_end').value+timezoneOffset,
                    backgroundColor: '#FF0000'
                });
            submitForm();
        }

        function deleteEvent() {
            calendar.getEventById(activeEventID).remove();
            submitForm();
        }

    </script>
</head>
<body>
<?= $this->Form->create(null, ['id' => 'availability-form']) ?>

<?= $this->Form->button(__('Add Event'), [
    'type' => 'button',
    'onclick' => 'newEvent()',
    'class' => 'mh-btn-primary'
]) ?>

<?= $this->Form->control('availability_json', ['type' => 'hidden', 'id' => 'availability-json']) ?>

<div id="calendar"></div>

<?= $this->Form->button(__('Save'), [
    'type' => 'button',
    'onclick' => 'submitForm()',
    'class' => 'mh-btn-primary'
]) ?>

<?= $this->Form->end() ?>
<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Event Details</h5>
            </div>
            <div class="modal-body">
                <p>Start time</p>
                <input type="datetime-local" id="start_datetime" required>
                <p>End time</p>
                <input type="datetime-local" id="end_datetime" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-auto" id="btn-delete" onclick="deleteEvent()">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="save()">Apply Changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Event Details</h5>
            </div>
            <div class="modal-body">
                <p>Start time</p>
                <input type="datetime-local" id="new_start" required>
                <p>End time</p>
                <input type="datetime-local" id="new_end" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="add()">Save</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
