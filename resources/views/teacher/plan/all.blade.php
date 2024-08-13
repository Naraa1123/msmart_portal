@extends('layouts.teacher')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5')}}" rel="stylesheet"
          type="text/css"/>
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
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-toggle="modal" data-target="#AddModalPlan">
                                <i class="ki ki-plus"></i> Төлөвлөгөө нэмэх
                            </button>

                            <!-- Modal-->
                            <div class="modal fade" id="AddModalPlan" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form method="POST" action="{{route('teacher.subject-topic-store')}}">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="eventModalLabel">Create Event</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="class_topic_id" >
                                                    <label style="font-weight: bold">Хичээл</label>
                                                    <select class="form-control" name="class_subject_id" required>
                                                        <option value="">Select</option>
                                                        @foreach($data['getObject'] as $object)
                                                            <option value="{{ $object->id }}">{{ $object->subject->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label style="font-weight: bold; margin-top: 5px;">Сэдэв</label>
                                                    <input type="text" name="topic" class="form-control" required>
                                                    <label style="font-weight: bold;margin-top: 5px;">Даалгавар</label>
                                                    <textarea name="homework" class="form-control"></textarea>
                                                    <label style="font-weight: bold;margin-top: 5px;">Орсон өдөр</label>
                                                    <input type="date" name="date_of_topic" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary" id="saveEvent">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog"
                         aria-labelledby="eventModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="POST" action="{{route('teacher.subject-topic-update')}}">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="eventModalLabel">Update Event Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="class_topic_id" id="eventId">
                                        <label style="font-weight: bold">Хичээл</label>
                                        <select class="form-control" id="eventSubject" name="class_subject_id" required>
                                            <option value="">Select</option>
                                            @foreach($data['getObject'] as $object)
                                                <option value="{{ $object->id }}">{{ $object->subject->name }}</option>
                                            @endforeach
                                        </select>
                                        <label style="font-weight: bold">Сэдэв</label>
                                        <input type="text" name="topic" class="form-control" id="eventTitle" required>
                                        <label style="font-weight: bold">Даалгавар</label>
                                        <textarea name="homework" class="form-control" id="eventDescription"></textarea>
                                        <label style="font-weight: bold">Орсон өдөр</label>
                                        <input type="date" name="date_of_topic" class="form-control" id="eventStart"
                                               required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <a id="deleteEvent" href="#" class="btn btn-warning"
                                           onclick="return confirm('Are you sure to Delete?')">Delete</a>
                                        <button type="submit" class="btn btn-primary" id="saveEvent">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <!--begin::Card-->
                <div class="card card-custom" style="margin-top: 20px;">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon2-favourite text-primary"></i>
                            </span>
                            <h3 class="card-label">
                                Ангиуд
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="myDatatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Анги</th>
                                <th>Сэдэв</th>
                                <th>Огноо</th>
                                <th>Даалгавар</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($plans as $key=>$plan)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $class_name}}</td>
                                    <td>{{ $plan->topic }}</td>
                                    <td>{{ $plan->date_of_topic }}</td>
                                    <td>{{ $plan->homework }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
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
    <script>
        $(document).ready(function () {
            $('#myDatatable').DataTable({
                "order": [[0, "asc"]]
            });
            if ($.fn.DataTable.isDataTable('#myDatatable')) {
                $('#myDatatable').DataTable().destroy();
            }
            $('#myDatatable').DataTable({
                pageLength: 10,
                responsive: true,
            });

        });

    </script>

    <script>
        @if(count($plans) == 0)
        Swal.fire({
            title: "Одоогоор төлөвлөгөө байхгүй байна.",
            width: 600,
            padding: "3em",
            color: "#716add"
        });
        @endif
    </script>
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
                dayGridMonth: {buttonText: 'month'},
                timeGridWeek: {buttonText: 'week'},
                timeGridDay: {buttonText: 'day'}
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
            eventLimit: true,

            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },

            eventClick: function (info) {
                $('#eventId').val(info.event.id);
                var eventSubjectValue = info.event.extendedProps.subject;
                $('#eventSubject option').each(function () {
                    if ($(this).val() == eventSubjectValue) {
                        $(this).prop('selected', true);
                    }
                });
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
    <script>


    </script>
@endsection
