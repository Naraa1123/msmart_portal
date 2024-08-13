@extends('layouts.teacher')

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
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon2-favourite text-primary"></i>
                            </span>
                            <h3 class="card-label">
                                Хичээлийн төлөвлөгөө
                            </h3>
                        </div>
                    </div>

                </div>


                <!--begin::Card-->
                <div class="card card-custom">

                    <form class="form" method="POST" action="{{route('teacher.attendance-plans')}}" >
                        @csrf
                        <div class="card-body" style="padding: 0; padding-top: 50px">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">Анги</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <select class="form-control" id="getClass" name="class_id" required onchange="this.form.submit()">
                                        <option value="">Select</option>
                                        @foreach($data['getClass'] as $class)
                                            <option {{ (Request::get('class_id') == $class->id) ? 'selected' : ''}} value="{{$class->id}}">{{$class->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    </form>
                    @if(empty($plan))
                        <form class="form" method="POST" action="{{route('teacher.subject-topic-store')}}" >
                            @csrf
                            <div class="card-body" style="padding: 0; padding-bottom: 50px">
                                @if(!empty($data['getObject']))
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Хичээл</label>
                                        <div class="col-lg-4 col-md-9 col-sm-12 ">
                                            <select class="form-control" id="getObject" name="class_subject_id" required>
                                                <option value="">Select</option>
                                                @foreach($data['getObject'] as $object)
                                                    <option value="{{ $object->id }}">{{ $object->subject->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-3 col-sm-12" for="topic">Сэдэв</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="topic" id="topic" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-3 col-sm-12" for="homework">Гэрийн даалгавар</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="homework" id="homework"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-3 col-sm-12">Өдөр</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" name="date_of_topic" value="{{ date('Y-m-d') }}" readonly/>
                                            <div class="input-group-append">
                                                   <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                   </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" style="margin-left: 53%">Save</button>
                            </div>
                        </form>
                    @endif
                </div>

                <!--begin::Card-->
                <div class="card card-custom" style="margin-top: 10px">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon2-favourite text-primary"></i>
                            </span>
                            <h3 class="card-label">
                                Ирц авах
                            </h3>
                        </div>
                    </div>

                    <form class="form" method="POST" action="">
                        @csrf
                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">Анги</label>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <select class="form-control" id="getClass" name="class_id" required
                                            onchange="this.form.submit()">
                                        <option value="">Select</option>
                                        @foreach($data['getClass'] as $class)
                                            <option
                                                {{ (Request::get('class_id') == $class->id) ? 'selected' : ''}} value="{{$class->id}}">{{$class->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">Өдөр</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" value="{{ date('Y-m-d') }}" readonly
                                               disabled/>
                                        <div class="input-group-append">
                                                   <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                   </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


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
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($data['getStudent']) && !empty($data['getStudent']->count()))
                                @foreach($data['getStudent'] as $key=>$value)
                                    @php
                                        $attendance_type = '';

                                         $getAttendance = $value->getAttendance($value->id, Request::get('class_id'), now()->format('Y-m-d'));

                                        if (!empty($getAttendance->attendance_type)) {
                                            $attendance_type = $getAttendance->attendance_type;
                                        }
                                    @endphp
                                    <tr style="{{ $value->hasIssue ? 'background-color: #FFE2E5;' : '' }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{$value->school_id}}</td>
                                        <td>{{$value->userDetails->lastname}} {{$value->userDetails->firstname}}</td>
                                        <td>{{$value->userDetails->status}}</td>
                                        
                                        <td>
                                            <div class="col-9 col-form-label">
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
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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
    <!--begin::Page Scripts(used by this page)-->


    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5')}}"></script>

    <!--end::Page Scripts-->

    <script>
        $(document).ready(function () {
            if ( $.fn.DataTable.isDataTable('#kt_datatable') ) {
                $('#kt_datatable').DataTable().destroy();
            }
            $('#kt_datatable').DataTable({
                pageLength: 50,
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

    <script type="text/javascript">

        $(document).ready(function () {
            $('.SaveAttendance').change(function () {
                var user_id = $(this).attr('id');
                var attendance_type = $(this).val();
                var class_id = $('#getClass').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ url('teacher/attendance/student/save') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "user_id": user_id,
                        "attendance_type": attendance_type,
                        "class_id": class_id
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log('Attendance updated successfully.');
                    },
                    error: function (error) {
                        console.error('Error updating attendance.');
                    }
                });
            });
        });
    </script>
@endsection





