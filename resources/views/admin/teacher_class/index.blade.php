@extends('layouts.admin')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5" rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors Styles-->
@endsection

@section('content')
    <div class="content flex-column flex-column-fluid" id="kt_content">

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
                            <h3 class="card-label">Teacher & Classes</h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <a href="{{ url('admin/teacher-classes/create') }}" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i>Connect Teacher to Classes</a>
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <th>Багш</th>
                                <th>Ангиуд</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $teacherClassMap = [];
                            @endphp
                            @forelse ($teacher_classes as $item)
                                @if (!isset($teacherClassMap[$item->user_id]))
                                    @php
                                        $teacherClassMap[$item->user_id] = [
                                            'id' => $item->id,
                                            'user' => $item->user->userDetails->firstname,
                                            'teacher_id' => $item->user->id,
                                            'created_at' => $item->created_at,
                                            'classes' => [],
                                        ];
                                    @endphp
                                @endif
                                @php
                                    $teacherClassMap[$item->user_id]['classes'][] = $item->class->name;
                                @endphp
                            @empty

                                <tr>
                                    <td colspan="7">No Class Available</td>
                                </tr>
                            @endforelse

                            @foreach ($teacherClassMap as $teacherId => $data)
                                <tr>
                                    <td>{{ $data['id'] }}</td>
                                    <td>{{ $data['user'] }}</td>
                                    <td>{{ implode(', ', $data['classes']) }}</td>
                                    <td>{{$data['created_at']}}</td>

                                    <td>
                                        <a href="{{ url('admin/teacher-classes/edit/'.encrypt($data['teacher_id'])) }}"
                                           class="btn btn-sm btn-clean btn-icon" title="edit">
                                            <i class="la la-edit"></i>
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



