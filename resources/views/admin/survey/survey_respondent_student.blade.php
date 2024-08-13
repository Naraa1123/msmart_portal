@extends('layouts.admin')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5')}}" rel="stylesheet"
          type="text/css"/>
    <!--end::Page Vendors Styles-->
    <style>
        /* Styles for survey answers */
        .survey-answers {
            padding: 10px;
        }

        .question {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
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
                            <h3 class="card-label">{{$respondentStudents->first()->survey->name}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>ClassId</th>
                                <th>Овог</th>
                                <th>Нэр</th>
                                <th>Утас</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($respondentStudents as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{$item->user->class->name}}</td>
                                    <td>{{$item->user->userDetails->lastname}}</td>
                                    <td>{{$item->user->userDetails->firstname}}</td>
                                    <td>{{$item->user->userDetails->phone_number_1}}</td>
                                    <td width="13%">
                                        <a class="btn btn-sm btn-success" title="судалгаа харах" data-toggle="modal"
                                           data-target="#surveyModal{{$item->user->id}}">
                                            Судалгаа харах
                                        </a>
                                        <div class="modal fade" id="surveyModal{{$item->user->id}}" tabindex="-1"
                                             role="dialog" aria-labelledby="surveyModal{{$item->user->id}}"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="surveyModal{{$item->user->id}}">
                                                            Төлбөрийн түүх</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" id="surveyModalBody{{$item->user->id}}">
                                                        <div class="survey-answers">
                                                            @foreach($item->survey->questions as $question)
                                                                <span class="question">{{$question->question_text}}</span>
                                                                @foreach($item->user->answers as $answer)
                                                                    @php
                                                                        $previousQuestionText = $question->question_text;
                                                                    @endphp
                                                                    @if($answer->question->question_text==$question->question_text)
                                                                        <span class="form-control">- {{$answer->answer}}</span>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Хаах
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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





