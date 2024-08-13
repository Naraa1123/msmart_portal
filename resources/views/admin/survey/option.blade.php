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
                            <h3 class="card-label">{{$question->question_text}} асуултын сонголтууд</h3>
                        </div>

                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <a href="{{route('admin.survey.questions',['id'=>encrypt($question->survey->id)])}}" class="btn btn-success font-weight-bolder">
                                <i class="la la-arrow"></i>Back</a>
                            <a href="#" style="margin-left: 10px" data-toggle="modal" data-target="#optionModal" class="btn btn-primary font-weight-bolder">
                                <i class="la la-plus"></i>Create Option</a>
                            <!--end::Button-->
                        </div>

                        <div class="modal fade" id="optionModal" tabindex="-1" role="dialog" aria-labelledby="optionModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="optionModalLabel">Survey Create</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="{{route('admin.survey.question.option.store', ['id' => encrypt($question->id)])}}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <label for="answer_text">Сонголтуудын нэр: </label>
                                            <div class="input-group">
                                                <input placeholder="Сонголт бичнэ үү" name="answer_text" class="form-control"
                                                       type="text"
                                                       id="answer_text"
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
                                <th>Option</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($question_answers as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{$item->answer_text}}</td>

                                    <td>{{ $item->created_at}}</td>
                                    <td>{{ $item->updated_at}}</td>

                                    <td>
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-clean btn-icon edit-option" title="edit"
                                           data-id="{{$item->id}}"
                                           data-answer_text="{{$item->answer_text}}">
                                            <i class="la la-edit"></i>
                                        </a>

                                        <!-- Edit Survey Modal -->
                                        <div class="modal fade" id="editOptionModal" tabindex="-1" role="dialog" aria-labelledby="editOptionModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editOptionModalLabel">Edit Survey</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="editOptionForm" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <input type="hidden" name="option_id" id="edit_option_id">

                                                            <label for="edit_answer_text">Option Text:</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" id="edit_answer_text" name="answer_text" class="form-control" placeholder="Edit Option" required>
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


                                        <a href="{{ route('admin.survey.question.option.delete', ['id' => encrypt($item->id)])}}"
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
            $('.edit-option').click(function() {
                var id = $(this).data('id');
                var answer_text = $(this).data('answer_text');

                $('#edit_option_id').val(id);
                $('#edit_answer_text').val(answer_text);
                $('#editOptionModal').modal('show');
            });
        });
    </script>

    <script>
        $('.edit-survey').on('click', function() {
            var optionId = $(this).data('id');
            var actionUrl = "{{ route('admin.survey.question.option.update', ['id' => ':id']) }}".replace(':id', optionId);
            $('#editOptionForm').attr('action', actionUrl);

        });

    </script>

@endsection



