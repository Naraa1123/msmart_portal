@extends('layouts.admin')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        Subject Edit
                    </h3>
                </div>

                <form action="{{ url('admin/subject/'.$subject->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group">
                            <label for="class_id">Анги сонгох: </label>
                            <select name="department" class="form-control">
                                <option value="Программ хангамж" {{ $subject->department == 'Программ хангамж' ? 'selected' : '' }}>Программ хангамж</option>
                                <option value="График дизайн" {{ $subject->department == 'График дизайн' ? 'selected' : '' }}>График дизайн</option>
                                <option value="Интерьер дизайн" {{ $subject->department == 'Интерьер дизайн' ? 'selected' : '' }}>Интерьер дизайн</option>
                                <option value="Хүүхдийн анги" {{ $subject->department == 'Хүүхдийн анги' ? 'selected' : '' }}>Хүүхдийн анги</option>
                                <option value="Ерөнхий судлах хичээл" {{ $subject->department == 'Ерөнхий судлах хичээл' ? 'selected' : '' }}>Ерөнхий судлах хичээл</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="grading_topic">Сэдэв сонгох: </label>
                            <select name="grading_topic" class="form-control">
                                <option value="">Сэдвээ сонгоно уу</option>
                                @foreach($topics as $item)
                                    <option value="{{$item->id}}" {{ $subject->grading_topic_id == $item->id ? 'selected' : '' }}>
                                        {{$item->topic}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-2 col-form-label">Хичээлийн нэр:</label>
                            <div class="col-12">
                                <input class="form-control" name="name" type="text" value="{{$subject->name}}"
                                       id="name"/>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-3 col-form-label" for="status">Status</label>
                            <div class="col-3">
                                <span class="switch">
                                <label>
                                    <input type="checkbox" name="status" {{ $subject->status == '1' ? 'checked' : '' }} />
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







