@extends('layouts.student')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->

    <link href="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5')}}" rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors Styles-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

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
                                <span style="color:limegreen">{{$class_name}}</span>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog"
                         aria-labelledby="eventModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventModalLabel">Дэлгэрэнгүй</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="class_topic_id" id="eventId">
                                    <label style="font-weight: bold">Хичээл</label>
                                    <input type="text" name="topic" class="form-control" id="eventSubject" readonly>

                                    <label style="font-weight: bold">Сэдэв</label>
                                    <input type="text" name="topic" class="form-control" id="eventTitle" readonly>
                                    <label style="font-weight: bold">Даалгавар</label>
                                    <textarea name="homework" class="form-control" id="eventDescription" readonly></textarea>
                                    <label style="font-weight: bold">Орсон өдөр</label>
                                    <input type="date" name="date_of_topic" class="form-control" id="eventStart"
                                           readonly>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--begin::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

@endsection

@section('vendor')
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.5')}}"></script>
    <!--end::Page Vendors-->
@endsection

@section('script')
    <script src="{{asset('admin/assets/plugins/custom/secondcalendar/fullcalendar.bundle.js')}}"></script>

    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5')}}"></script>
    <!--end::Page Scripts-->
    <script type="text/javascript">
        var events = [];

        @foreach($events as $event)
        events.push({
            id: '{{$event['id']}}',
            subject: '{{$event['subject']}}',
            title: '{{ $event['title'] }} ',
            start: '{{ $event['start'] }}',
            description: '{{ $event['description']}}',
            className: "fc-event-info",
        });
        @endforeach


        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
            themeSystem: 'bootstrap',

            isRTL: KTUtil.isRTL(),

            views: {
                dayGridMonth: { buttonText: 'month' },
                timeGridWeek: { buttonText: 'week' },
                timeGridDay: { buttonText: 'day' }
            },

            defaultView: 'dayGridMonth',

            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },

            initialDate: new Date(),
            navLinks: true,
            editable: false,
            events: events,
            eventLimit:true,

            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },

            eventClick: function (info) {
                $('#eventId').val(info.event.id);
                var eventSubjectValue = info.event.extendedProps.subject;
                console.log(eventSubjectValue);


                $('#eventSubject').val(info.event.extendedProps.subject);

                $('#eventTitle').val(info.event.title);
                var startDate = info.event.start;
                startDate.setDate(startDate.getDate() + 1);
                var formattedStartDate = startDate.toISOString().slice(0, 10);
                $('#eventStart').val(formattedStartDate);
                $('#eventDescription').val(info.event.extendedProps.description);
                $('#eventModal').modal('show');

                var deleteEventLink = "{{ route('teacher.subject-topic-delete', ['id' => ':id']) }}";
                deleteEventLink = deleteEventLink.replace(':id', info.event.id);
                $('#deleteEvent').attr('href', deleteEventLink);
            },

            eventRender: function (info) {
                var element = $(info.el);

                if (info.event.extendedProps && info.event.extendedProps.description) {
                    element.attr('title', info.event.extendedProps.description);
                    element.tooltip({
                        container: 'body'
                    });
                    if (element.hasClass('fc-day-grid-event')) {
                        element.data('content', info.event.extendedProps.description, info.event.extendedProps.description);
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
