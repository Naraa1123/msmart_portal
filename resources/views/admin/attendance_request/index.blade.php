@extends('layouts.admin')

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
                            <h3 class="card-label">Чөлөөний хүсэлтүүд</h3>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-xl-12">
                                <div class="row align-items-center">
                                    <!-- Status Filter -->
                                    <div class="col-md-3 col-sm-12 my-2">
                                        <div class="d-flex align-items-center">
                                            <label for="filterStatus" class="mr-3 mb-0">Төлөв:</label>
                                            <select id="filterStatus" class="form-control">
                                                <option value="">Төлөв сонгоно уу:</option>
                                                <option value="зөвшөөрөгдсөн">зөвшөөрөгдсөн</option>
                                                <option value="зөвшөөрөгдөөгүй">зөвшөөрөгдөөгүй</option>
                                                <option value="шийдвэр_гараагүй">шийдвэр_гараагүй</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Анги</th>
                                <th>Овог Нэр</th>
                                <th>USER ID</th>
                                <th>Хүсэлтийн төрөл</th>
                                <th>Эхлэх өдөр</th>
                                <th>Дуусах өдөр</th>
                                <th>Тайлбар</th>
                                <th>Хавсаргалт</th>
                                <th>Хүсэлтийн шийдвэр</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($attendance_request as $key=>$item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        @if(!empty($item->user->class->name))
                                            {{$item->user->class->name}}
                                        @endif
                                    </td>
                                    <td>{{$item->user->userDetails->firstname}}  {{$item->user->userDetails->lastname}}</td>
                                    <td>{{$item->user->school_id}}</td>
                                    <td>{{$item->request_type}}</td>
                                    <td>{{$item->request_start_date}}</td>
                                    <td>{{$item->request_end_date}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>
                                        <a href="{{ asset($item->attachment) }}" download>{{ basename($item->attachment) }}</a>
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
                                                    class="label font-weight-bold label-lg  label-light-info label-inline">шийдвэр_гараагүй</span></span>
                                        @else
                                            <span style="width: 112px;">
                                            <span
                                                class="label font-weight-bold label-lg  label-light-success label-inline">Хөгжүүлэгчид хэл</span>
                                        </span>
                                        @endif

                                    </td>

                                    <td>{{ $item->created_at}}</td>
                                    <td>

                                        <div class="dropdown">
                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="statusDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                шийдвэр гаргах
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                                <a class="dropdown-item" href="{{ url('admin/attendance-request/change-decision/'.$item->id.'/зөвшөөрөгдсөн') }}">зөвшөөрөгдсөн</a>
                                                <a class="dropdown-item" href="{{ url('admin/attendance-request/change-decision/'.$item->id.'/зөвшөөрөгдөөгүй') }}">зөвшөөрөгдөөгүй</a>
                                            </div>
                                        </div>
                                        <a href="{{ url('admin/attendance-request/delete/'.$item->id) }}" onclick="return confirm('Are you sure to Delete?')" class="btn btn-danger btn-sm">
                                            Delete
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
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.5')}}"></script>
    <!--end::Page Vendors-->
@endsection

@section('script')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5')}}"></script>
    <!--end::Page Scripts-->

    <script>
        $(document).ready(function () {
            if ($.fn.DataTable.isDataTable('#kt_datatable')) {
                $('#kt_datatable').DataTable().destroy();
            }
            // Initialize DataTable
            var table = $('#kt_datatable').DataTable({
                pageLength: 10,
                // Enable sorting by status column (index 2)
                columnDefs: [
                    { targets: 9, orderable: true } // Enable sorting on column index 2 (status)
                ],
                responsive: true,
            });

            // Event handler for select change
            $('#filterStatus').change(function () {
                var selectedStatus = $(this).val();
                // Apply filter based on selected status
                table.column(9).search(selectedStatus).draw();
            });
        });
    </script>
@endsection



