@extends('layouts.admin')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        Ангийг хичээлүүдтэй холбох
                    </h3>
                </div>

                <form class="form" action="{{ url('admin/class-subjects') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="class_id">Class</label>
                                <select name="class_id" class="form-control" disabled>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" @if ($class_id == $class->id) selected @endif>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <h4 class="mb-4">Сонгосон хичээлүүд:</h4>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Subject Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($selectedSubjects as $classSubject)
                                        <tr>
                                            <td>{{ $classSubject->subject->name }}</td>
                                            <td>{{ $classSubject->status }}</td>
                                            <td>
                                                <a href="{{ route('admin.class-subjects.remove', ['classId' => $class_id, 'subjectId' => $classSubject->subject->id]) }}"
                                                   onclick="return confirm('Are you sure to remove this subject?')" class="btn btn-danger btn-sm">Remove</a>


                                                <a href="{{ route('admin.class-subjects.toggle-status', ['classId' => $class_id, 'subjectId' => $classSubject->subject->id]) }}"
                                                   class="btn btn-primary btn-sm">
                                                    Change Status
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12 mb-3">
                                <h4 class="mb-4">Сонгогдоогүй хичээлүүд:</h4>
                                @foreach ($unselectedSubjects as $department => $subjects)
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>{{ $department }}</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($subjects as $subject)
                                            <tr>
                                                <td>{{ $subject->name }}</td>
                                                <td>
                                                    <a href="{{ route('admin.class-subjects.add', ['classId' => $class_id, 'subjectId' => $subject->id]) }}"
                                                       class="btn btn-success btn-sm">Add</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

