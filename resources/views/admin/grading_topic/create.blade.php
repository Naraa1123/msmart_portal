@extends('layouts.admin')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        Topic create
                    </h3>
                </div>

                <form class="form" action="{{route('admin.grading-topic.store')}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="topic" class="col-2 col-form-label">Сэдвийн нэр:</label>
                            <div class="col-12">
                                <input class="form-control" name="topic" type="text" value="{{old('topic')}}"
                                       id="topic" required/>
                                @error('topic') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="department">Анги сонгох: </label>
                            <select name="department" class="form-control" required>
                                <option value="Программ хангамж">Программ хангамж</option>
                                <option value="График дизайн">График дизайн</option>
                                <option value="Интерьер дизайн">Интерьер дизайн</option>
                                <option value="Хүүхдийн анги">Хүүхдийн анги</option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label" for="status" style="padding-left: 12.5px">Status:</label>
                            <div class="col-3">
                                <span class="switch">
                                    <label>
                                        <input type="checkbox" name="status" />
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
@endsection
