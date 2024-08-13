@extends('layouts.admin')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5" rel="stylesheet" type="text/css"/>
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
                            <h3 class="card-label">Шилжилт хөдөлгөөнүүд</h3>
                        </div>

                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Оюутны нэр</th>
                                <th>Элссэн Анги</th>
                                <th>Шилжсэн Анги</th>
                                <th>Created Date</th>
                                <th>Үйлдэл</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($switch_history as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{$item->user->userDetails->lastname}} {{$item->user->userDetails->firstname}}</td>
                                    <td>{{$item->fromClass->name}}</td>
                                    <td>{{$item->toClass->name}}</td>
                                    <td>{{ $item->created_at}}</td>

                                    <td>
                                        <a href="{{ url('admin/user-class-attendance-history/'.encrypt($item->user->id)) }}"
                                           class="btn btn-sm btn-clean btn-icon" title="attendance">
                                            <i class="la la-eye"></i>
                                        </a>
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
    <script src="admin/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.5"></script>
    <!--end::Page Vendors-->
@endsection

@section('script')
    <!--begin::Page Scripts(used by this page)-->
    <script src="admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5"></script>
    <!--end::Page Scripts-->
@endsection
