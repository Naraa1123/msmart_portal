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
                            <h3 class="card-label">Surveys</h3>
                        </div>

                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <a href="#" data-toggle="modal" data-target="#surveyModal" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i>Create Survey</a>
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

                                    <form action="{{route('admin.survey.store')}}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <label for="type">Ямар хэрэглэгчээс судалгаа авахаа сонгоно уу</label>
                                            <div class="input-group">
                                                <select class="form-control" id="type" name="type" required>
                                                    <option value="student">оюутан</option>
                                                    <option value="teacher">багш</option>
                                                </select>
                                            </div>
                                            <br>
                                            <label for="name">Судалгааны нэр: </label>
                                            <div class="input-group">
                                                <input placeholder="Судалгааны нэр бичнэ үү" name="name" class="form-control"
                                                       type="text"
                                                       id="name"
                                                       required/>
                                            </div>
                                            <br>
                                            <label for="description">Судалгааны тайлбар: </label>
                                            <div class="input-group">
                                                <input placeholder="Судалгааны тайлбар бичнэ үү" name="description" class="form-control"
                                                       type="text"
                                                       id="description"
                                                       required/>
                                            </div>

                                        </div>


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">SUBMIT</button>
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
                                <th>Name</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($surveys as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->type}}</td>
                                    <td>{{ $item->created_at}}</td>

                                    <td>
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-clean btn-icon edit-survey" title="edit"
                                           data-id="{{$item->id}}"
                                           data-name="{{$item->name}}"
                                           data-description="{{$item->description}}"
                                           data-type="{{$item->type}}">
                                            <i class="la la-edit"></i>
                                        </a>



                                        <!-- Edit Survey Modal -->
                                        <div class="modal fade" id="editSurveyModal" tabindex="-1" role="dialog" aria-labelledby="editSurveyModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editSurveyModalLabel">Edit Survey</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="editSurveyForm" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <input type="hidden" name="survey_id" id="edit_survey_id">

                                                            <label for="edit_type">Select Survey Type:</label>
                                                            <div class="input-group mb-3">
                                                                <select class="form-control" id="edit_type" name="type" required>
                                                                    <option value="student">Student</option>
                                                                    <option value="teacher">Teacher</option>
                                                                </select>
                                                            </div>

                                                            <label for="edit_name">Survey Name:</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" id="edit_name" name="name" class="form-control" placeholder="Enter survey name" required>
                                                            </div>

                                                            <label for="edit_description">Survey Description:</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" id="edit_description" name="description" class="form-control" placeholder="Enter survey description" required>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <a href="{{ route('admin.survey.delete', ['id' => encrypt($item->id)])}}"
                                           onclick="return confirm('Are you sure to Delete?')"
                                           class="btn btn-sm btn-clean btn-icon" title="delete">
                                            <i class="la la-trash"></i>
                                        </a>

                                        <a href="{{ route('admin.survey.questions', ['id' => encrypt($item->id)])}}"
                                           class="btn btn-sm btn-clean btn-icon" title="questions">
                                            <i class="la la-question"></i>
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
        $(document).ready(function() {
            $('.edit-survey').click(function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var description = $(this).data('description');
                var type = $(this).data('type');

                $('#edit_survey_id').val(id);
                $('#edit_name').val(name);
                $('#edit_description').val(description);
                $('#edit_type').val(type);
                $('#editSurveyModal').modal('show');
            });
        });
    </script>

    <script>
        $('.edit-survey').on('click', function() {
            var surveyId = $(this).data('id');
            var actionUrl = "{{ route('admin.survey.update', ['id' => ':id']) }}".replace(':id', surveyId);
            $('#editSurveyForm').attr('action', actionUrl);

        });

    </script>

@endsection



