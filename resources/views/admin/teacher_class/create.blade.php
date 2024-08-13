@extends('layouts.admin')

@section('content')

    <div style="">
        <div class="container mb-10">
            <div class="card card-custom">
                <div class="card-header">
                    <h2 class="card-title" style="font-weight: bold">
                        Багшийг ангиудтай холбох
                    </h2>
                </div>

                <form class="form" action="{{ url('admin/teacher-classes') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="user_id">Багш сонгох: </label>
                            <select class="form-control" name="user_id" id="user_id">
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->userDetails->firstname }}</option>
                                @endforeach
                            </select>
                            @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <hr>
                            @php $currentDepartmentId = null; @endphp
                            @foreach ($classes as $class)
                                @if ($currentDepartmentId != $class->department_id)
                                    @if ($currentDepartmentId !== null)
                        </div> <!-- Close the flex container if the department changes -->
                        @endif
                        @php $currentDepartmentId = $class->department_id; @endphp
                        <label class="font-weight-bold"
                               style="margin-bottom: 0; font-size: 16px">{{ $class->department->name }}</label>
                        <hr>
                        <div class="mr-2 mb-2 d-flex">
                            @endif
                            <div>
                                @php
                                    $isConnected = $class->teachers()->exists();
                                    $bgColor = $isConnected ? 'bg-warning' : '';

                                @endphp

                                <div class="p-2 border {{ $bgColor }}" style="font-weight: bold; font-size: medium">
                                    <input id="classes_{{ $class->id }}" type="checkbox"
                                           name="classes[{{ $class->id }}]" value="{{ $class->id }}"/>
                                    {{ $class->name }}
                                </div>
                            </div>
                            @endforeach
                            @if ($currentDepartmentId !== null)
                        </div> <!-- Close the flex container if there are no more classes left -->
                        @endif
                        @if (empty($classes))
                            <div>
                                <h1>No Class Found!</h1>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-10">
                                <button type="submit" class="btn btn-success mr-2">SAVE</button>
                                <button type="button" class="btn btn-secondary" onclick="goBack()">BACK</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection

