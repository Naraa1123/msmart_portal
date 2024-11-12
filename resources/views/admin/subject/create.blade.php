@extends('layouts.admin')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        Subject Create
                    </h3>
                </div>

                <form class="form" action="{{ url('admin/subject') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="department">Төрөл сонгох: </label>
                            <select name="department" class="form-control">
                                <option value="">Ангиа сонгоно уу</option>
                                <option value="Программ хангамж">Программ хангамж</option>
                                <option value="График дизайн">График дизайн</option>
                                <option value="Интерьер дизайн">Интерьер дизайн</option>
                                <option value="Хүүхдийн анги">Хүүхдийн анги</option>
                                <option value="Ерөнхий судлах хичээл">Ерөнхий судлах хичээл</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="grading_topic">Сэдэв сонгох: </label>
                            <select name="grading_topic" class="form-control">
                            </select>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-2 col-form-label">Хичээлийн нэр:</label>
                            <div class="col-12">
                                <input class="form-control" name="name" type="text" value="{{old('name')}}"
                                       id="name"/>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-3 col-form-label" for="status">Status:</label>
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
        $(document).ready(function() {
            $('select[name="department"]').on('change', function() {
                const department = $(this).val();
                const gradingTopicSelect = $('select[name="grading_topic"]');

                // Clear the grading_topic dropdown
                gradingTopicSelect.empty();

                if (department) {
                    $.ajax({
                        url: `admin/get-grading-topics?department=${department}`, // Adjust endpoint as needed
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            $.each(data, function(key, topic) {
                                gradingTopicSelect.append(new Option(topic.topic, topic.id));
                            });
                        }
                    });
                }
            });
        });

    </script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
