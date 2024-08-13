@extends('layouts.admin')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5')}}" rel="stylesheet"
          type="text/css"/>
    <!--end::Page Vendors Styles-->
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon2-favourite text-primary"></i>
                            </span>
                            <h3 class="card-label">
                                Ирц хяналт
                            </h3>
                        </div>
                    </div>

                    <form class="form" method="GET" action="">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">Анги</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <select class="form-control select2" id="getClass" name="class_id" required>
                                        <option value="">Select</option>
                                        @foreach($data['getClass'] as $class)
                                            <option
                                                {{ (Request::get('class_id') == $class->id) ? 'selected' : ''}}
                                                value="{{$class->id}}">{{$class->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">Өдөр</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <div class="input-group date">
                                        <input type="date" class="form-control" id="getAttendanceDate"
                                               value="{{ Request::get('attendance_date')}}"
                                               required name="attendance_date">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4 col-md-9 col-sm-12 mx-auto">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                    <a href="{{url('admin/attendance/student')}}" class="btn btn-success">Reset</a>
                                </div>
                            </div>


                        </div>
                    </form>

                    @if(!empty(Request::get('class_id')) && !empty(Request::get('attendance_date')))
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Оюутны ID</th>
                                    <th>Оюутны Овог Нэр</th>
                                    <th>Оюутны төлөв</th>
                                    <th>Ирцийн төлөв</th>
                                    <th>хэзээ авсан</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(!empty($data['getStudent']) && !empty($data['getStudent']->count()))
                                    @foreach($data['getStudent'] as $key=>$value)
                                        @php
                                            $attendance_type = '';
                                            $contact_status='';

                                              $getAttendance = $value->getAttendance($value->id, Request::get('class_id'),
                                              Request::get('attendance_date'));

                                              if(!empty($getAttendance->attendance_type))
                                              {
                                                  $attendance_type = $getAttendance->attendance_type;
                                              }
                                              if(!empty($getAttendance->contact_status))
                                              {
                                                  $contact_status = $getAttendance->contact_status;
                                              }
                                        @endphp
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{$value->school_id}}</td>
                                            <td>{{$value->userDetails->lastname}} {{$value->userDetails->firstname}}</td>
                                            <td>{{$value->userDetails->status}}</td>
                                            <td>
                                                <div class="col-14 col-form-label">
                                                    <div class="radio-inline">
                                                        <label class="radio">
                                                            <input value="1" type="radio"
                                                                   {{ ($attendance_type == '1') ? 'checked' : '' }}
                                                                   id="{{$value->id}}" class="SaveAttendance"
                                                                   name="attendance{{$value->id}}"><span></span>тас
                                                        </label>

                                                        <label class="radio">
                                                            <input value="2" type="radio"
                                                                   {{ ($attendance_type == '2') ? 'checked' : '' }} id="{{$value->id}}"
                                                                   class="SaveAttendance"
                                                                   name="attendance{{$value->id}}"><span></span>ирсэн
                                                        </label>
                                                        <label class="radio">
                                                            <input value="3" type="radio"
                                                                   {{ ($attendance_type == '3') ? 'checked' : '' }} id="{{$value->id}}"
                                                                   class="SaveAttendance"
                                                                   name="attendance{{$value->id}}"><span></span>хоцорсон
                                                        </label>
                                                        <label class="radio">
                                                            <input value="4" type="radio"
                                                                   {{ ($attendance_type == '4') ? 'checked' : '' }} id="{{$value->id}}"
                                                                   class="SaveAttendance"
                                                                   name="attendance{{$value->id}}"><span></span>өвчтэй
                                                        </label>
                                                        <label class="radio">
                                                            <input value="5" type="radio"
                                                                   {{ ($attendance_type == '5') ? 'checked' : '' }} id="{{$value->id}}"
                                                                   class="SaveAttendance"
                                                                   name="attendance{{$value->id}}"><span></span>чөлөө
                                                        </label>

                                                        <label class="radio">
                                                            <input value="6" type="radio"
                                                                   {{ ($attendance_type == '6') ? 'checked' : '' }} id="{{$value->id}}"
                                                                   class="SaveAttendance"
                                                                   name="attendance{{$value->id}}"><span></span>BB
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ optional($getAttendance)->created_at ? optional($getAttendance)->created_at->format('Y-m-d H:i:s') : 'No Available' }}</td>


                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <!--end: Datatable-->
                        </div>
                    @endif
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
    <!--begin::Page Scripts(used by this page)-->

    <script type="text/javascript">
        $(document).ready(function () {

            $(document).on('change', '.SaveAttendance', function (e) {
                e.preventDefault();

                var user_id = $(this).attr('id');
                var attendance_type = $(this).val();
                var class_id = $('#getClass').val();
                var attendance_date = $('#getAttendanceDate').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ url('admin/attendance/student/save') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "user_id": user_id,
                        "attendance_type": attendance_type,
                        "class_id": class_id,
                        "attendance_date": attendance_date,
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data.message);
                    },
                    error: function (xhr, status, error) {
                        console.error("Error saving attendance:", error);
                    }
                });
            });
        });
    </script>

    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5')}}"></script>

    <!--end::Page Scripts-->

    <script>
        $(document).ready(function () {

            if ($.fn.DataTable.isDataTable('#kt_datatable')) {
                $('#kt_datatable').DataTable().destroy();
            }

            $('#kt_datatable').DataTable({
                pageLength: 50,
                responsive: true,
            });

        });
    </script>

    <script>
        var KTSelect2 = function () {
            var demos = function () {
                $('#getClass').select2({
                    placeholder: "Select a class"
                });

            }

            var modalDemos = function () {
                $('#getClass_modal').on('shown.bs.modal', function () {
                    $('#getClass_modal').select2({
                        placeholder: "Select a class"
                    });
                });
            }

            return {
                init: function () {
                    demos();
                    modalDemos();
                }
            };
        }();

        jQuery(document).ready(function () {
            KTSelect2.init();
        });
    </script>


@endsection





