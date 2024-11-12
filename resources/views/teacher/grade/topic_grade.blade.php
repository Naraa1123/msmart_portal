@extends('layouts.teacher')

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
                                {{$user->userDetails->lastname}}  {{$user->userDetails->firstname}} оюутны дүнгүүд
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
                                <th>Үйлдэл</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @foreach($topicsWithGrades as $index => $topicWithGrades)
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $topicWithGrades['topic']->topic }}</td>
                                    <td>{{ $topicWithGrades['grade'] }}</td>
                                    <td>
                                        @if ($topicWithGrades['grade'] == 'No Grade')
                                            {{ "Дүн Ороогүй" }}
                                        @elseif($topicWithGrades['grade'] >= 97)
                                            {{ "A+" }}
                                        @elseif($topicWithGrades['grade'] >= 93)
                                            {{ "A" }}
                                        @elseif($topicWithGrades['grade'] >= 90)
                                            {{ "A-" }}
                                        @elseif($topicWithGrades['grade'] >= 87)
                                            {{ "B+" }}
                                        @elseif($topicWithGrades['grade'] >= 83)
                                            {{ "B" }}
                                        @elseif($topicWithGrades['grade'] >= 80)
                                            {{ "B-" }}
                                        @elseif($topicWithGrades['grade'] >= 77)
                                            {{ "C+" }}
                                        @elseif($topicWithGrades['grade'] >= 73)
                                            {{ "C" }}
                                        @elseif($topicWithGrades['grade'] >= 70)
                                            {{ "C-" }}
                                        @elseif($topicWithGrades['grade'] >= 67)
                                            {{ "D+" }}
                                        @elseif($topicWithGrades['grade'] >= 63)
                                            {{ "D" }}
                                        @elseif($topicWithGrades['grade'] >= 60)
                                            {{ "D-" }}
                                        @else
                                            {{ "F" }}
                                        @endif
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm edit-grade-btn" data-toggle="modal" data-target="#editGradeModal{{ $index }}" data-grade="{{ $topicWithGrades['grade'] ?? '' }}" data-subject-id="{{ $topicWithGrades['topic']->id }}">
                                            дүн засах
                                        </button>
                                    </td>
                                    <!-- Modal Structure -->
                                    <div class="modal fade" id="editGradeModal{{ $index }}" tabindex="-1" aria-labelledby="editGradeModalLabel{{ $index }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editGradeModalLabel{{ $index }}">Дүн засах сэдэв: {{ $topicWithGrades['topic']->topic }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('teacher.topic-grade.updateOrCreate') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                        <input type="hidden" name="topic_id" value="{{ $topicWithGrades['topic']->id }}">
                                                        <div class="form-group">
                                                            <label for="scoreInput{{ $index }}">Score</label>
                                                            <input type="number" class="form-control" id="scoreInput{{ $index }}" name="score" value="{{ $topicWithGrades['grade'] ?? '' }}" required>
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
            $('.edit-grade-btn').click(function() {
                var modalId = $(this).data('target');
                var grade = $(this).data('grade');
                var subjectId = $(this).data('subject-id');
                var modal = $(modalId);

                modal.find('input[name="score"]').val(grade);
                modal.find('input[name="subject_id"]').val(subjectId);
            });
        });
    </script>
@endsection




