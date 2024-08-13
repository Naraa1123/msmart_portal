@extends('layouts.admin')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5')}}" rel="stylesheet"
          type="text/css"/>
    <!--end::Page Vendors Styles-->
    <style>
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
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card mb-3">
                <div style="text-align: center; padding-top: 10px">
                    <h3 class="card-title" style="font-weight: bold">{{$survey->name}}</h3>
                </div>
            </div>
            @if(count($surveyClasses)>0)
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon2-favourite text-primary"></i>
                                </span>
                            <h3 class="card-label">Судалгааг бөглөсөн ангиуд</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($surveyClasses as $surveyClass)
                                <div class="col-md-2">
                                    <div class="class-code">
                                        <h3>
                                            <a class="btn font-weight-bold font-size-h6 px-10 py-4 mr-2 square-btn btn-info"
                                               href="{{ route('admin.survey-respondent-student', ['class_id' => encrypt($surveyClass->class->id), 'survey_id' => encrypt($survey->id)]) }}">
                                                {{ $surveyClass->class->name }}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @if(!empty($teachers))
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon2-favourite text-primary"></i>
                                </span>
                            <h3 class="card-label">Судалгааг бөглөсөн багш нар</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($teachers as $teacher)
                                <div class="col-md-2">
                                    <div class="class-code">
                                        <h3>
                                            <a class="btn font-weight-bold font-size-h6 px-10 py-4 mr-2 square-btn btn-info"
                                               data-toggle="modal" data-target="#surveyModal{{$teacher->id}}">
                                                {{ $teacher->userDetails->firstname }}
                                            </a>
                                            <div class="modal fade" id="surveyModal{{$teacher->id}}" tabindex="-1"
                                                 role="dialog" aria-labelledby="surveyModal{{$teacher->id}}"
                                                 aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="surveyModal{{$teacher->id}}">Төлбөрийн түүх</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" id="surveyModalBody{{$teacher->id}}">
                                                            <div class="survey-answers">
                                                                @php
                                                                    $previousQuestionText = null;
                                                                @endphp

                                                                @foreach($teacher->answers as $answer)
                                                                    @if ($answer->question->question_text != $previousQuestionText)
                                                                        <p class="question">{{$answer->question->question_text}}</p>
                                                                    @endif
                                                                    <p class="form-control">- {{$answer->answer}}</p>
                                                                    @php
                                                                        $previousQuestionText = $answer->question->question_text;
                                                                    @endphp
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
                                        </h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <div class="card card-custom" style="margin-top: 50px">
                <div class="card-body">
                    <div class="row">
                        @php
                        $count=0;
                        @endphp
                        @foreach($chartsData as $chartData)
                            <div class="col-lg-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{$chartData['question_text']}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <canvas class="card-img-bottom" id="chart{{ ++$count }}"></canvas>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5')}}"></script>
    <!--end::Page Scripts-->
    <script>
        @php $myCount=0 @endphp
        @foreach($chartsData as $chartData)
        var ctx = document.getElementById('chart{{ ++$myCount }}');
        var chart{{$count}} = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: @json($chartData['question_text']),
                    data: @json($chartData['data']),
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        @endforeach
    </script>

@endsection
