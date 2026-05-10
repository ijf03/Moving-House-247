<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js'></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var events = <?= json_encode($event_set) ?>;
            var formatted_events = Object.keys(events).map(function(start) {
                return {
                    start: start,
                    end: events[start],
                    backgroundColor: '#FF0000',
                };
            });
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                width: '60vw',
                height: '1600px',
                editable: true,
                events: formatted_events,
                select: function(info) {
                    document.getElementById('start-datetime').value = info.startStr;
                    document.getElementById('end-datetime').value = info.endStr;

                    document.getElementById('display-time').innerText =
                        new Date(info.startStr).toLocaleString() + ' to ' +
                        new Date(info.endStr).toLocaleTimeString();

                    var modalElement = document.getElementById('addEventModal');
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                },
            });
            calendar.render();
        });

    </script>
</head>
<body>
<div id='calendar'></div>
<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= $this->Form->create(null, ['url' => ['action' => 'availability', $staff->id]]) ?>
            <div class="modal-header">
                <h5 class="modal-title">Set Availability</h5>
            </div>
            <div class="modal-body">
                <?= $this->Form->control('start_datetime', ['type' => 'hidden', 'id' => 'start-datetime']) ?>
                <?= $this->Form->control('end_datetime', ['type' => 'hidden', 'id' => 'end-datetime']) ?>

                <p>Selected Slot: <span id="display-time"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <?= $this->Form->button(__('Save Availability'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</body>
</html>
