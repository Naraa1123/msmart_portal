@extends('layouts.teacher')

@section('content')
    <style>
        img{
            width: 100%;
            height: 100%;
        }
    </style>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                @if($teacherNews)
               @foreach($teacherNews as $item)

                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                {{$item->title}}
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4>
                       {!! $item->description !!}
                        </h4>
                    </div>
                </div>
                    @endforeach
                @endif


            </div>
        </div>
    </div>


@endsection


@section('script')
    @if(session('message'))
        <script>
            window.addEventListener('load', function() {
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('message') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
@endsection
