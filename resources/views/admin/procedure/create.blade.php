@extends('layouts.admin')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        Журам үүсгэх
                    </h3>
                </div>
                <form class="form" action="{{ route('admin.procedure.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="title" class="col-2 col-form-label">Гарчиг</label>
                            <div class="col-12">
                                <input class="form-control" name="title" type="text" id="title" required/>
                                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>PDF</label>
                            <div></div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="pdf" id="pdf"/>
                                <label class="custom-file-label" for="pdf">Choose file</label>
                                @error('pdf') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-10">
                                    <button type="submit" class="btn btn-success mr-2" id="saveBtn">SAVE</button>
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
