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
                            <h3 class="card-label">
                                {{$user->userDetails->lastname}}  {{$user->userDetails->firstname}} оюутны дүнгүүд
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-checkable" style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Судлагдахуун</th>
                                <th>Технологи</th>
                                <th>Дүн</th>
                                <th>Үнэлгээ</th>
                                <th>Үйлдэл</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $index = 1; @endphp


                            @foreach($nonGradableTopicsWithGrades as $nonGradableTopic)
                                @php
                                    $subjectCount = $nonGradableTopic['subjects']->count(); // Count subjects for rowspan
                                @endphp
                                @foreach($nonGradableTopic['subjects'] as $key => $subjectWithGrade)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        @if($loop->first)
                                            <td rowspan="{{ $subjectCount }}" style="vertical-align: middle">
                                                {{ $nonGradableTopic['topic']->topic ?? 'Unknown Topic' }}
                                            </td>
                                        @endif
                                        <td>{{ $subjectWithGrade['subject']->name }}</td>
                                        <td>{{ $subjectWithGrade['grade'] }}</td>
                                        <td>
                                            @if ($subjectWithGrade['grade'] === 'No Grade')
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
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm edit-grade-btn"
                                                    data-toggle="modal" data-target="#editGradeModal"
                                                    data-grade="{{ $subjectWithGrade['grade'] }}"
                                                    data-subject-id="{{ $subjectWithGrade['subject']->id }}"
                                                    data-subject-name="{{ $subjectWithGrade['subject']->name }}">
                                                дүн засах
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach

                                <!-- Gradable Topics -->
                            @foreach($gradableTopicsWithGrades as $gradableTopic)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td colspan="2">
                                        {{ $gradableTopic['topic']->topic }}
                                    </td>
                                    <td>{{ $gradableTopic['grade'] }}</td>
                                    <td>
                                        @if ($gradableTopic['grade'] === 'No Grade')
                                            {{ "Дүн Ороогүй" }}
                                        @elseif($gradableTopic['grade'] >= 97)
                                            {{ "A+" }}
                                        @elseif($gradableTopic['grade'] >= 93)
                                            {{ "A" }}
                                        @elseif($gradableTopic['grade'] >= 90)
                                            {{ "A-" }}
                                        @elseif($gradableTopic['grade'] >= 87)
                                            {{ "B+" }}
                                        @elseif($gradableTopic['grade'] >= 83)
                                            {{ "B" }}
                                        @elseif($gradableTopic['grade'] >= 80)
                                            {{ "B-" }}
                                        @elseif($gradableTopic['grade'] >= 77)
                                            {{ "C+" }}
                                        @elseif($gradableTopic['grade'] >= 73)
                                            {{ "C" }}
                                        @elseif($gradableTopic['grade'] >= 70)
                                            {{ "C-" }}
                                        @elseif($gradableTopic['grade'] >= 67)
                                            {{ "D+" }}
                                        @elseif($gradableTopic['grade'] >= 63)
                                            {{ "D" }}
                                        @elseif($gradableTopic['grade'] >= 60)
                                            {{ "D-" }}
                                        @else
                                            {{ "F" }}
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm edit-topic-grade-btn"
                                                data-toggle="modal" data-target="#editTopicGradeModal"
                                                data-grade="{{ $gradableTopic['topic'] }}"
                                                data-topic-id="{{ $gradableTopic['topic']->id }}"
                                                data-topic-name="{{ $gradableTopic['topic']->topic }}">
                                            дүн засах
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Non-Gradable Topics with Subjects -->

                            </tbody>
                        </table>

                        <div class="modal fade" id="editGradeModal" tabindex="-1" aria-labelledby="editGradeModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editGradeModalLabel">Дүн засах хичээл: <span id="modalSubjectName"></span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.subject-grade.updateOrCreate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="subject_id" id="modalSubjectId">
                                            <div class="form-group">
                                                <label for="modalScoreInput">Score</label>
                                                <input type="number" class="form-control" id="modalScoreInput" name="score" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="editTopicGradeModal" tabindex="-1" aria-labelledby="editGradeModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editGradeModalLabel">Дүн засах хичээл: <span id="modalSubjectName"></span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.topic-grade.updateOrCreate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="topic_id" id="modalSubjectId">
                                            <div class="form-group">
                                                <label for="modalScoreInput">Score</label>
                                                <input type="number" class="form-control" id="modalScoreInput" name="score" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        $(document).ready(function () {
            $('.edit-grade-btn').click(function () {
                var modalId = $(this).data('target');
                var grade = $(this).data('grade');
                var subjectId = $(this).data('subject-id');
                var modal = $(modalId);

                modal.find('input[name="score"]').val(grade);
                modal.find('input[name="subject_id"]').val(subjectId);
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.edit-topic-grade-btn').click(function () {
                var modalId = $(this).data('target');
                var grade = $(this).data('grade');
                var subjectId = $(this).data('topic-id');
                var modal = $(modalId);

                modal.find('input[name="score"]').val(grade);
                modal.find('input[name="topic_id"]').val(subjectId);
            });
        });
    </script>
@endsection





