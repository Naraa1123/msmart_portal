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
                    <div class="card-header">
                        <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-favourite text-primary"></i>
                        </span>
                            <h3 class="card-label">USERS</h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <a href="{{ url('admin/user/create') }}" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i>Create User</a>
                            <!--end::Button-->
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row align-items-center">
                            <div class="col-lg-12 col-xl-12">
                                <div class="row align-items-center">
                                    <!-- Department Filter -->
                                    <div class="col-md-3 col-sm-12 my-2">
                                        <div class="d-flex align-items-center">
                                            <label for="filterDepartment" class="mr-3 mb-0">Тэнхим:</label>
                                            <select id="filterDepartment" class="form-control">
                                                <option value="">Тэнхим сонгоно уу:</option>
                                                @foreach($departments as $dep)
                                                    <option value="{{$dep->name}}">{{$dep->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <!-- Class Filter -->
                                    <div class="col-md-3 col-sm-12 my-2">
                                        <div class="d-flex align-items-center">
                                            <label for="filterClass" class="mr-3 mb-0">Анги:</label>
                                            <select id="filterClass" class="form-control">
                                                <option value="">Анги сонгоно уу:</option>
                                                @foreach($classes as $class)
                                                    <option value="{{$class->name}}">{{$class->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Role Filter -->
                                    <div class="col-md-3 col-sm-12 my-2">
                                        <div class="d-flex align-items-center">
                                            <label for="filterRole" class="mr-3 mb-0">Role:</label>
                                            <select id="filterRole" class="form-control">
                                                <option value="">Role сонгоно уу:</option>
                                                <option value="admin">Admin</option>
                                                <option value="teacher">Teacher</option>
                                                <option value="student">Student</option>
                                                <option value="operator">Operator</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Status Filter -->
                                    <div class="col-md-3 col-sm-12 my-2">
                                        <div class="d-flex align-items-center">
                                            <label for="filterStatus" class="mr-3 mb-0">Төлөв:</label>
                                            <select id="filterStatus" class="form-control">
                                                <option value="">Төлөв сонгоно уу:</option>
                                                <option value="graduated">Төгссөн</option>
                                                <option value="studying">Суралцаж байгаа</option>
                                                <option value="took_leave">Чөлөө авсан</option>
                                                <option value="dropped_out">Гарсан</option>
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
                                <th>User Type</th>
                                <th>Тэнхим</th>
                                <th>Анги</th>
                                <th>USER ID</th>
                                <th>Овог Нэр</th>
                                <th>РЕГИСТР</th>
                                <th>Төлөв</th>
                                <th>Утасны дугаарууд</th>
                                <th>Гэрээ байгуулсан</th>
                                <th>Created At</th>
                                <th>Үйлдэл</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $key=>$item)
                                <tr>
{{--                                    <td>{{ ++$key }}</td>--}}
                                    <td>{{$item->id}}</td>
                                    <td class="datatable-cell-sorted datatable-cell" data-field="Status" aria-label="1">
                                        @if($item->role_as == '0')
                                            <span style="width: 112px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-success label-inline">wtf chinku д хэл</span>
                                        </span>
                                        @elseif($item->role_as == '1')
                                            <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-primary label-inline">admin</span></span>
                                        @elseif($item->role_as == '2')
                                            <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-info label-inline">teacher</span></span>
                                        @elseif($item->role_as == '3')
                                            <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-warning label-inline">student</span></span>
                                        @elseif($item->role_as == '4')
                                            <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-danger label-inline">operator</span></span>
                                        @else
                                            <span style="width: 112px;">
                                            <span
                                                class="label font-weight-bold label-lg  label-light-success label-inline">Хөгжүүлэгчид хэл</span>
                                        </span>
                                        @endif
                                    </td>
                                    <td>{{ optional($item->class)->department->name  ?? 'No Available' }}</td>
                                    <td>{{ optional($item->class)->name  ?? 'No Available' }}</td>
                                    <td>{{ $item->school_id }}</td>
                                    <td>{{ optional($item->userDetails)->lastname ?? 'No Available' }} {{ optional($item->userDetails)->firstname ?? 'No Available' }}</td>

                                    <td>{{$item->userDetails->registration_number}}</td>
                                    <td>
                                        {{ optional($item->userDetails)->status ?? 'No Available' }}
                                    </td>

                                    <td>
                                        {{ optional($item->userDetails)->phone_number_1 ?? '' }},
                                        {{ optional($item->userDetails)->phone_number_2 ?? '' }},
                                        {{ optional($item->userDetails)->phone_number_3 ?? '' }}
                                    </td>
                                    <td>
                                        @if($item->userDetails->made_contract=='yes')
                                            тийм
                                        @elseif($item->userDetails->made_contract=='no')
                                            үгүй
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at}}</td>

                                    <td>
                                        <a href="{{ url('admin/user/show/'.encrypt($item->id)) }}"
                                           class="btn btn-sm btn-clean btn-icon" title="show">
                                            <i class="la la-eye"></i>
                                        </a>

                                        <a href="{{ url('admin/user/edit/'.encrypt($item->id)) }}"
                                           class="btn btn-sm btn-clean btn-icon" title="edit">
                                            <i class="la la-edit"></i>
                                        </a>

                                        <a href="{{ url('admin/user/contract/'.encrypt($item->id)) }}"
                                           class="btn btn-sm btn-clean btn-icon" title="contract">
                                            <i class="la la-folder"></i>
                                        </a>

                                        <a href="{{ url('admin/user/delete/'.encrypt($item->id)) }}"
                                           onclick="return confirm('Are you sure to Delete?')"
                                           class="btn btn-sm btn-clean btn-icon" title="delete">
                                            <i class="la la-trash"></i>
                                        </a>

                                        <a href="{{url('admin/user/password/'.encrypt($item->id))}}"
                                           class="btn btn-sm btn-clean btn-icon" title="password">
                                            <i class="la la-lock"></i>
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
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.5')}}"></script>
@endsection

@section('script')
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5')}}"></script>

    <script>
        var KTSelect2 = function () {
            var demos = function () {
                // basic
                $('#filterClass').select2({
                    placeholder: "Анги сонгоно уу"
                });
            }

            var modalDemos = function () {
                $('#filterClass_modal').on('shown.bs.modal', function () {
                    // basic
                    $('#filterClass_modal').select2({
                        placeholder: "Анги сонгоно уу"
                    });
                });
            }

            // Public functions
            return {
                init: function () {
                    demos();
                    modalDemos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function () {
            KTSelect2.init();
        });
    </script>

    <script>
        $(document).ready(function () {
            if ($.fn.DataTable.isDataTable('#kt_datatable')) {
                // If DataTable is initialized, destroy it
                $('#kt_datatable').DataTable().destroy();
            }

            var table = $('#kt_datatable').DataTable({
                pageLength: 10,
                responsive: true,
            });

            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var filterDepartment = $('#filterDepartment').val();
                var department = data[2]; // Assuming department is in the 3rd column
                if (filterDepartment === "" || department === filterDepartment) {
                    return true;
                }
                return false;
            });

            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var filterRole = $('#filterRole').val();
                var role = data[1];
                if (filterRole === "" || role.includes(filterRole)) {
                    return true;
                }
                return false;
            });

            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var filterStatus = $('#filterStatus').val();
                var status = data[7];
                if (filterStatus === "" || status === filterStatus) {
                    return true;
                }
                return false;
            });

            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var filterClass = $('#filterClass').val();
                var className = data[3];
                if (filterClass === "" || className === filterClass) {
                    return true;
                }
                return false;
            });

            $('#filterDepartment, #filterRole, #filterStatus, #filterClass').change(function () {
                table.draw();
            });

            $(window).on('resize', function() {
                table.columns.adjust().draw();
            });
        });
    </script>

@endsection



