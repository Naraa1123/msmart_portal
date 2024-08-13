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
                            <h3 class="card-label">Class & Subjects</h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <a href="{{ url('admin/class-subjects/create') }}" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i>Connect Class to Subjects</a>
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
                                            <option value="{{$dep->name}}">{{$dep->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Анги</th>
                                <th>Багш</th>
                                <th>Хичээлүүд</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $classSubjectMap = [];
                            @endphp
                            @foreach($class_subjects as $item)
                                @if (!isset($classSubjectMap[$item->class_id]))
                                    @php
                                        $classSubjectMap[$item->class_id] = [
                                            'class' => $item->class->name,
                                            'teacher'=>$item->class->id ,
                                            'subjects' => [],
                                            'created_at' => $item->created_at
                                        ];
                                    @endphp
                                @endif
                                @php
                                    $classSubjectMap[$item->class_id]['subjects'][] = $item->subject->name;
                                @endphp
                            @endforeach

                            @foreach($classSubjectMap as $classId => $data)
                                <tr>
                                    <td>{{ $classId }}</td>
                                    <td>{{ $data['class'] }}</td>

                                    <td>
                                        @foreach($teacher_detail as $td)
                                            @if($data['teacher'] == $td['class_id'])
                                                {{ $td['name'] }}
                                                @php break; @endphp
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>{{ implode(', ', $data['subjects']) }}</td>
                                    <td>{{$data['created_at']}}</td>

                                    <td>
                                        <a href="{{ url('admin/class-subjects/edit/'.encrypt($classId)) }}"
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

    <script>
        $(document).ready(function () {
            // DataTable initialization

            if ($.fn.DataTable.isDataTable('#kt_datatable')) {
                $('#kt_datatable').DataTable().destroy();
            }

            var table = $('#kt_datatable').DataTable({
                pageLength: 10,
            });

            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var filterDepartment = $('#filterDepartment').val();
                var department = data[1];

                var departmentPrefixes = {
                    "Програм хангамж 1 жил": "SO",
                    "Програм хангамж 6 сар": "SS",
                    "График Дизайн 1 жил": "GO",
                    "График Дизайн 5 сар": "GF",
                    "Интерьер Дизайн 1 жил": "IO",
                    "Интерьер Дизайн 5 сар": "IF",
                    "Хүүхдийн Анги I шат": "KT",
                    "Гуравласан 1,2 жил": "TO",
                    "UI/UX Дизайн 2 сар": "UI",
                    "Хүүхдийн Анги II шат": "KS",
                    "Вэб хөгжүүлэлт 3 сар": "WE",
                };

                if (filterDepartment in departmentPrefixes && department.startsWith(departmentPrefixes[filterDepartment])) {
                    return true;
                }

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

