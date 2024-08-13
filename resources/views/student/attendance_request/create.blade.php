@extends('layouts.student')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        Чөлөөний хүсэлт үүсгэх
                    </h3>
                </div>

                <form class="form" action="{{ url('student/attendance-request') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        <div class="form-group">
                            <label for="request_type" class="select-request">Хүсэлтийн төрөл сонгоно уу</label>
                            <select name="request_type" class="form-control" id="request_type">
                                <option value="чөлөө" {{ old('request_type') == 'чөлөө' ? 'selected' : '' }}>чөлөө
                                </option>
                                <option value="өвчтэй" {{ old('request_type') == 'өвчтэй' ? 'selected' : '' }}>өвчтэй
                                </option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label for="request_start_date" class="col-2 col-form-label">Чөлөө эхлэх өдөр:</label>
                            <div class="col-10">
                                <input value="{{ old('request_start_date') }}" placeholder="Чөлөө эхлэх өдөр"
                                       type="date" id="request_start_date"
                                       name="request_start_date"
                                       onchange="updateEndDate()" class="form-control">
                            </div>
                            @error('request_start_date')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="request_end_date" class="col-2 col-form-label">Чөлөө дуусах өдөр:</label>
                            <div class="col-10">
                                <input value="{{ old('request_end_date') }}" placeholder="Чөлөө эхлэх өдөр"
                                       type="date" id="request_end_date"
                                       name="request_end_date"
                                       min=""
                                       onchange="updateEndDate()" class="form-control">
                            </div>
                            @error('request_end_date')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="form-group mb-3">
                            <label for="description">Тайлбар</label>
                            <textarea name="description" class="form-control" id="description"
                                      rows="3">{{old('description')}}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Хавсаргалт</label>
                            <div></div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="attachment" id="attachment"/>
                                <label class="custom-file-label" for="attachment">Choose file</label>
                                @error('attachment') <small class="text-danger">{{ $message }}</small> @enderror
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

    <script>
        document.getElementById('request_start_date').min = new Date().toISOString().split('T')[0];

        function updateEndDate() {
            var startDate = document.getElementById('request_start_date').value;
            var endDateInput = document.getElementById('request_end_date');
            endDateInput.min = startDate;
            if (endDateInput.value < startDate) {
                endDateInput.value = startDate;
            }
        }
    </script>
@endsection








