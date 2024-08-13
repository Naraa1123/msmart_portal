@extends('layouts.admin')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        Edit Teacher & Classes
                    </h3>
                </div>

                <form class="form" action="{{ url('admin/class-subjects') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="user_id">Class</label>
                                <select id="user_id" name="user_id" class="form-control" disabled>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ optional($teacherClass)->user_id == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->userDetails->firstname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <h4>Selected Classes:</h4>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Class Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($selectedClasses as $class)
                                        <tr>
                                            <td>{{ $class->name }}</td>
                                            <td>
                                                @if ($teacherClass && $teacherClass->user_id)
                                                    <a href="{{ route('admin.teacher-classes.remove', ['teacherId' => $teacherClass->user_id, 'classId' => $class->id]) }}"
                                                       onclick="return confirm('Are you sure to remove this class?')" class="btn btn-danger btn-sm">Remove</a>
                                                @else
                                                    <a href="{{ redirect('admin/teacher-classes') }}" class="btn btn-danger btn-sm disabled">Remove</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12 mb-3">
                                <h4>Unselected Classes:</h4>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Class Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($unselectedClasses as $class)
                                        <tr>
                                            <td>{{ $class->name }}</td>
                                            <td>
                                                @if ($teacherClass && $teacherClass->user_id)
                                                    <a href="{{ route('admin.teacher-classes.add', ['teacherId' => $teacherClass->user_id, 'classId' => $class->id]) }}"
                                                       class="btn btn-success btn-sm">Add</a>
                                                @else
                                                    <a href="{{ redirect('admin/teacher-classes') }}" class="btn btn-success btn-sm disabled">Add</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>



                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

