@extends('layouts.student')

@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="card card-custom">

                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                Student Calendar
                            </h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')

    <script type="text/javascript">
        var events = [];

        @foreach($result as $value)
        @foreach($value['week'] as $week)
        events.push({
            title: '{{ $value['name'] }} ',
            daysOfWeek: [{{ $week['fullcalendar_day'] }}],
            startTime: '{{ $week['start_time'] }}',
            endTime: '{{ $week['end_time'] }}',
            className: "fc-event-info",
            description: '{{ $value['department'] }} / {{ $week['room_number'] }}'
        });
        @endforeach
        @endforeach


        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
            themeSystem: 'bootstrap',

            defaultView: 'timeGridWeek',

            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },

            initialDate: new Date(),
            navLinks: true,
            editable: false,
            events: events,

            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },

            minTime: "09:00:00",
            maxTime: "22:00:00",

            eventRender: function (info) {
                var element = $(info.el);

                if (info.event.extendedProps && info.event.extendedProps.description) {
                    element.attr('title', info.event.extendedProps.description);
                    element.tooltip({
                        container: 'body'
                    });

                    if (element.hasClass('fc-day-grid-event')) {
                        element.data('content', info.event.extendedProps.description);
                        element.data('placement', 'top');
                    } else if (element.hasClass('fc-time-grid-event')) {
                        element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                    } else if (element.find('.fc-list-item-title').length !== 0) {
                        element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                    }
                }
            }
        });

        calendar.render();
    </script>


@endsection
