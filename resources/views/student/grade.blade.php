@extends('layouts.student')

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
                                Дүнгийн мэдээлэл
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
                                <th>Хичээл</th>
                                <th>Дүн</th>
                                <th>Үнэлгээ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjectsWithGrades as $key => $subjectWithGrade)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $subjectWithGrade['subject']->name }}</td>
                                    <td>{{ $subjectWithGrade['grade'] }}</td>
                                    <td>
                                        @if ($subjectWithGrade['grade'] == 'No Grade')
                                            {{ "Дүн Ороогүй" }}
                                        @elseif($subjectWithGrade['grade'] >= 97)
                                            {{ "A+" }}
                                        @elseif($subjectWithGrade['grade'] >= 93)
                                            {{ "A" }}
                                        @elseif($subjectWithGrade['grade'] >= 90)
                                            {{ "A-" }}
                                        @elseif($subjectWithGrade['grade'] >= 87)
                                            {{ "B+" }}
                                        @elseif($subjectWithGrade['grade'] >= 83)
                                            {{ "B" }}
                                        @elseif($subjectWithGrade['grade'] >= 80)
                                            {{ "B-" }}
                                        @elseif($subjectWithGrade['grade'] >= 77)
                                            {{ "C+" }}
                                        @elseif($subjectWithGrade['grade'] >= 73)
                                            {{ "C" }}
                                        @elseif($subjectWithGrade['grade'] >= 70)
                                            {{ "C-" }}
                                        @elseif($subjectWithGrade['grade'] >= 67)
                                            {{ "D+" }}
                                        @elseif($subjectWithGrade['grade'] >= 63)
                                            {{ "D" }}
                                        @elseif($subjectWithGrade['grade'] >= 60)
                                            {{ "D-" }}
                                        @else
                                            {{ "F" }}
                                        @endif
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



