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
                            <h3 class="card-label">Survey: {{$survey->name}}</h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <a href="{{route('admin.survey.list')}}" class="btn btn-success font-weight-bolder">
                                <i class="la la-arrow"></i>Back</a>
                            <a href="#" data-toggle="modal" style="margin-left: 10px" data-target="#surveyQuestionModal" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i>Create Question</a>
                            <!--end::Button-->
                        </div>

                        <div class="modal fade" id="surveyQuestionModal" tabindex="-1" role="dialog" aria-labelledby="surveyQuestionModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="surveyQuestionModalLabel">Question Create</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="{{route('admin.survey.question.store', ['id' => encrypt($survey->id)])}}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <label for="question_type">Ямар асуулт оруулахаа сонгоно уу</label>
                                            <div class="input-group">
                                                <select class="form-control" id="question_type" name="question_type" required>
                                                    <option value="text">бичих</option>
                                                    <option value="multiselect">олныг сонгох</option>
                                                    <option value="radio">нэгийг сонгох</option>
                                                    <option value="number">үнэлгээ өгөх</option>
                                                </select>
                                            </div>
                                            <br>

                                            <label for="question_text">Асуултын текст: </label>
                                            <div class="input-group">
                                                <input placeholder="Асуултаа бичнэ үү" name="question_text" class="form-control"
                                                       type="text"
                                                       id="question_text"
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
                                <th>Question</th>
                                <th>Type</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($survey_questions as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{$item->question_text}}</td>
                                    <td>{{$item->question_type}}</td>
                                    <td>{{ $item->created_at}}</td>

                                    <td>
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-clean btn-icon edit-survey-question" title="edit"
                                           data-id="{{$item->id}}"
                                           data-question_text="{{$item->question_text}}"
                                           data-question_type="{{$item->question_type}}">
                                            <i class="la la-edit"></i>
                                        </a>

                                        <!-- Edit Survey Modal -->
                                        <div class="modal fade" id="editSurveyQuestionModal" tabindex="-1" role="dialog" aria-labelledby="editSurveyQuestionModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editSurveyQuestionModalLabel">Edit Survey Question</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="editSurveyQuestionForm" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">

                                                            <input type="hidden" name="survey_question_id" id="edit_survey_question_id">

                                                            <label for="edit_question_type">Асуултын төрөл:</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" id="edit_question_type" name="question_type" class="form-control" readonly>
                                                            </div>

                                                            <label for="edit_question_text">Асуултын текст:</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" id="edit_question_text" name="question_text" class="form-control" placeholder="Засах асуултын текстийг оруулна уу" required>
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

                                        @if($item->question_type == 'multiselect')
                                            <a href="{{ route('admin.survey.question.option', ['id' => encrypt($item->id)])}}"
                                               class="btn btn-sm btn-clean btn-icon" title="questions">
                                                <i class="la la-bars"></i>
                                            </a>
                                        @endif

                                        @if($item->question_type == 'radio')
                                            <a href="{{ route('admin.survey.question.option', ['id' => encrypt($item->id)])}}"
                                               class="btn btn-sm btn-clean btn-icon" title="questions">
                                                <i class="la la-clipboard-list"></i>
                                            </a>
                                        @endif

                                        <a href="{{ route('admin.survey.question.delete', ['id' => encrypt($item->id)])}}"
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



    <script>
        $(document).ready(function() {
            $('.edit-survey-question').click(function() {
                var id = $(this).data('id');
                var question_text = $(this).data('question_text');
                var question_type = $(this).data('question_type');


                $('#edit_survey_question_id').val(id);
                $('#edit_question_text').val(question_text);
                $('#edit_question_type').val(question_type);
                $('#editSurveyQuestionModal').modal('show');
            });
        });
    </script>

    <script>
        $('.edit-survey-question').on('click', function() {
            var surveyQuestionId = $(this).data('id');
            var actionUrl = "{{ route('admin.survey.question.update', ['id' => ':id']) }}".replace(':id', surveyQuestionId);
            $('#editSurveyQuestionForm').attr('action', actionUrl);

        });

    </script>

@endsection



