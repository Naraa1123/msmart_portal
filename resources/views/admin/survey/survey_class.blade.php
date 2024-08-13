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
                            <h3 class="card-label">Survey and Class</h3>
                        </div>

                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <a href="#" data-toggle="modal" data-target="#surveyModal" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i>CLASS connect SURVEY</a>
                            <!--end::Button-->
                        </div>

                        <div class="modal fade" id="surveyModal" tabindex="-1" role="dialog" aria-labelledby="surveyModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="surveyModalLabel">Survey Create</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="{{route('admin.survey-class.store')}}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <label for="survey_id">Судалгаа сонгоно уу</label>
                                            <div class="input-group">
                                                <select class="form-control" name="survey_id" id="survey_id"
                                                        required>
                                                    @foreach($surveys as $survey)
                                                        <option
                                                            value="{{ $survey->id }}" {{ old('survey_id') == $survey->id ? 'selected' : '' }}>{{ $survey->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>

                                            <label for="class_id">Анги сонгоно уу</label>
                                            <div class="input-group">
                                                <select class="form-control" name="class_id" id="class_id"
                                                        required>
                                                    @foreach($classes as $class)
                                                        <option
                                                            value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">CONNECT</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Survey</th>
                                <th>Class</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($survey_class as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{$item->survey->name}}</td>
                                    <td>{{$item->class->name}}</td>
                                    <td>{{ $item->created_at}}</td>

                                    <td>
                                        <a href="{{ route('admin.survey-class.delete', ['id' => encrypt($item->id)])}}"
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
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.5')}}"></script>
    <!--end::Page Vendors-->
@endsection

@section('script')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5')}}"></script>
    <!--end::Page Scripts-->



@endsection



