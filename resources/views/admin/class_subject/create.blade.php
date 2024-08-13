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

                        <div class="form-group">
                            <label for="class_id">Анги сонгох: </label>
                            <select class="form-control" name="class_id" id="class_id">
                                @foreach ($classes as $class)
                                    <option
                                        value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }} </option>
                                @endforeach
                            </select>
                            @error('class_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>


                        <div class="mb-3">
                            @foreach ($subjectsByDepartment as $department => $subjects)
                                <label class="checkbox checkbox-success" style="font-size: 15px; margin-top: 3px">{{ $department }}</label>
                                <hr style="margin-top: 0">
                                <div class="row">
                                    @forelse ($subjects as $subject)
                                        <div class="col-md-3">
                                            <div class="p-2 border mb-3">
                                                <input id="subjects"
                                                       type="checkbox"
                                                       name="subjects[{{ $subject->id }}]"
                                                       value="{{ $subject->id }}"/>
                                                {{ $subject->name }}
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-md-12">
                                            <h1>No Subject Found!</h1>
                                        </div>
                                    @endforelse
                                </div>
                            @endforeach
                        </div>

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
