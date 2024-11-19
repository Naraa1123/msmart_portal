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
                            <h3 class="card-label">Subjects</h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <a href="{{ url('admin/subject/create') }}" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i>Create Subject</a>
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <div class="col-md-3 col-sm-12 my-2">
                                <div class="d-flex align-items-center">
                                    <label for="filterDepartment" class="mr-3 mb-0">Тэнхим:</label>
                                    <select id="filterDepartment" class="form-control">
                                        <option value="">Тэнхим сонгоно уу:</option>
                                        @foreach($departments as $dep)
                                            <option value="{{$dep}}">{{$dep}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Department</th>
                                <th>Хичээлийн Нэр</th>
                                <th>Төлөв</th>
                                <th>Created Date</th>
                                <th>Үйлдэл</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $key=>$item)
                                <tr>
{{--                                    <td>{{ ++$key }}</td>--}}
                                    <td>{{ $item->id }}</td>
                                    <td>{{$item->department}}</td>
                                    <td>{{$item->name}}</td>
                                    <td class="datatable-cell-sorted datatable-cell" data-field="Status" aria-label="1">
                                        @if($item->status == '0')
                                            <span style="width: 112px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-success label-inline">Public</span>
                                        </span>
                                        @elseif($item->status == '1')
                                            <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-primary label-inline">Private</span></span>
                                        @else
                                            <span style="width: 112px;">
                                            <span
                                                class="label font-weight-bold label-lg  label-light-success label-inline">Хөгжүүлэгчид хэл</span>
                                        </span>
                                        @endif
                                    </td>

                                    <td>{{ $item->created_at}}</td>
                                    <td>
                                        <a href="{{ url('admin/subject/edit/'.encrypt($item->id)) }}"
                                           class="btn btn-sm btn-clean btn-icon" title="edit">
                                            <i class="la la-edit"></i>
                                        </a>

                                        <a href="{{ url('admin/subject/delete/'.$item->id) }}"
                                           onclick="return confirm('Are you sure to Delete?')"
                                           class="btn btn-sm btn-clean btn-icon" title="delete">
                                            <i class="la la-trash"></i>
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
    <script>
        $(document).ready(function () {
            // DataTable initialization

            if ($.fn.DataTable.isDataTable('#kt_datatable')) {
                $('#kt_datatable').DataTable().destroy();
            }

            var table = $('#kt_datatable').DataTable({
                pageLength: 10,
                responsive: true,
            });

            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var filterDepartment = $('#filterDepartment').val();
                var department = data[1]; // Assuming department is in the 3rd column
                if (filterDepartment === "" || department === filterDepartment) {
                    return true;
                }
                return false;
            });

            $('#filterDepartment').change(function () {
                table.draw();
            });
        });
    </script>
@endsection





