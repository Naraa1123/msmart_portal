@extends('layouts.admin')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        Class Edit
                    </h3>
                </div>

                <form action="{{ url('admin/class/' . $class->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="form-group">
                            <label for="department_id">Тэнхим</label>
                            <select class="form-control" name="department_id" id="department_id">
                                @foreach ($deps as $dep)
                                    <option value="{{ $dep->id }}"{{ $dep->id == $class->department_id ? 'selected':'' }}>
                                        {{$dep->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>


                        <div class="form-group row">
                            <label for="class_started_date" class="col-2 col-form-label">Хичээл эхлэх өдөр</label>
                            <div class="col-10">
                                <input class="form-control" type="date"
                                       name="class_started_date" id="class_started_date"
                                       value="{{ old('class_started_date', $class->class_started_date) }}"
                                />
                            </div>
                            @error('class_started_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>



                        <div class="form-group row">
                            <label class="col-3 col-form-label" for="status">Status</label>
                            <div class="col-3">
                                <span class="switch">
                                <label>
                                    <input type="checkbox" name="status" {{ $class->status == '1' ? 'checked' : '' }} />
                                    <span></span>
                                </label>
                            </span>
                            </div>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>


                        <div class="card-footer">
                            <div class="row">
                                <div class="col-2">
                                </div>
                                <div class="col-10">
                                    <button type="submit" class="btn btn-success mr-2">UPDATE</button>
                                    <button type="button" class="btn btn-secondary" onclick="goBack()">BACK</button>
                                </div>
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
