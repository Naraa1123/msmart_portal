@extends('layouts.student')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5')}}" rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors Styles-->
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @if (session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif
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
                                Илгээсэн чөлөөний хүсэлтүүд
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <a href="{{ route('student.attendance-request-create') }}"
                               class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i>Чөлөөний хүсэлт үүсгэх</a>
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Хүсэлтийн төрөл</th>
                                <th>Эхлэх өдөр</th>
                                <th>Дуусах өдөр</th>
                                <th>Тайлбар</th>
                                <th>Хавсаргалт</th>
                                <th>Хүсэлтийн шийдвэр</th>
                                <th>Үүсгэсэн өдөр</th>
                                <th>Үйлдэл</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($student_attendance_requests as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{$item->request_type}}</td>
                                    <td>{{$item->request_start_date}}</td>
                                    <td>{{$item->request_end_date}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>
                                        <a href="{{ asset($item->attachment) }}"
                                           download>{{ basename($item->attachment) }}</a>
                                    </td>

                                    <td class="datatable-cell-sorted datatable-cell" data-field="Status" aria-label="1">
                                        @if($item->request_decision == 'зөвшөөрөгдсөн')
                                            <span style="width: 112px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-success label-inline">зөвшөөрөгдсөн</span>
                                        </span>
                                        @elseif($item->request_decision == 'зөвшөөрөгдөөгүй')
                                            <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-danger label-inline">зөвшөөрөгдөөгүй</span></span>
                                        @elseif($item->request_decision == 'шийдвэр_гараагүй')
                                            <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-warning label-inline">шийдвэр гараагүй</span></span>
                                        @else
                                            <span style="width: 112px;">
                                            <span
                                                class="label font-weight-bold label-lg  label-light-success label-inline">Хөгжүүлэгчид хэл</span>
                                        </span>
                                        @endif
                                    </td>

                                    <td>{{$item->created_at}}</td>

                                    @if($item->request_decision == 'шийдвэр_гараагүй')
                                        <td>
                                            <a href="{{ url('student/attendance-request/delete/'.$item->id) }}"
                                               onclick="return confirm('Are you sure to Delete?')"
                                               class="btn btn-sm btn-clean btn-icon" title="delete">
                                                <i class="la la-trash"></i>
                                            </a>
                                        </td>
                                    @else
                                        <td>

                                        </td>
                                    @endif
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


