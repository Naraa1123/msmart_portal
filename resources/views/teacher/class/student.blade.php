@extends('layouts.teacher')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5')}}" rel="stylesheet" type="text/css"/>
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
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon2-favourite text-primary"></i>
                            </span>
                            <h3 class="card-label">
                                Оюутнууд
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Оюутны ID</th>
                                <th>Овог Нэр</th>
                                <th>Утасны дугаар 1</th>
                                <th>Утасны дугаар 2</th>
                                <th>Утасны дугаар 3</th>
                                <th>Оюутны элссэн (он-сар-өдөр)</th>
                                <th>Үйлдэл</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{$item->school_id}}</td>
                                    <td>{{ $item->userDetails->lastname }} {{ $item->userDetails->firstname }}</td>
                                    <td>{{ $item->userDetails->phone_number_1 }}</td>
                                    <td>{{ $item->userDetails->phone_number_2 }}</td>
                                    <td>{{ $item->userDetails->phone_number_3 }}</td>

                                    <td>{{ $item->userDetails->admission_year }}</td>
                                    <td>
                                        <a href="{{ url('teacher/class/student/grades/'.encrypt($item->id))}}" class="btn btn-success btn-sm">
                                            дүн
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#AddModalPlan{{$item->id}}">
                                            report
                                        </button>

                                        <!-- Modal-->
                                        <div class="modal fade" id="AddModalPlan{{$item->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{route('teacher.student-report-store',['id'=>$item->id])}}">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="eventModalLabel">Create Event</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label style="font-weight: bold; margin-top: 5px;">Зөрчил</label>
                                                                <input type="text" name="name" class="form-control" required>
                                                                <label style="font-weight: bold;margin-top: 5px;">Тайлбар</label>
                                                                <textarea name="description" class="form-control" required></textarea>
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
                                    </td>
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
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5')}}"></script>
    <!--end::Page Scripts-->
@endsection




