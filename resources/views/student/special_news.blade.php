@extends('layouts.student')

@section('style')
    {{--    <style>--}}
    {{--        .video-responsive, .pdf-responsive {--}}
    {{--            overflow: hidden;--}}
    {{--            padding-top: 56.25%; /* 16:9 Aspect Ratio for videos, adjust for PDF if needed */--}}
    {{--            position: relative;--}}
    {{--        }--}}

    {{--        .video-responsive iframe, .pdf-responsive iframe {--}}
    {{--            border: 0;--}}
    {{--            height: 100%;--}}
    {{--            left: 0;--}}
    {{--            position: absolute;--}}
    {{--            top: 0;--}}
    {{--            width: 100%;--}}
    {{--        }--}}

    {{--        img {--}}
    {{--            width: 100%;--}}
    {{--            height: 100%;--}}
    {{--        }--}}

    {{--    </style>--}}
    <style>
        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper {
            width: 100%;
            height: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
        }

        .mySwiper2 {
            height: 80%;
            width: 100%;
        }

        .mySwiper {
            height: 20%;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .mySwiper .swiper-slide {
            width: 25%;
            height: 100%;
            opacity: 0.4;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper-button-next, .swiper-button-prev{
            background-color: #000;
            border-radius: 8px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                @if($specialNews)
                    @foreach($specialNews as $item)
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

                                @if(!empty($item->yt_link))
                                    <div class="video-responsive">
                                        <iframe width="560" height="315" src="{{$item->yt_link}}"
                                                style="justify-self: center"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                        </iframe>
                                    </div>
                                @endif

                                @if($item->images->isNotEmpty())
                                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                                         class="swiper mySwiper2 mySwipers-{{$item->id}}">
                                        <div class="swiper-wrapper">
                                            @foreach($item->images as $index => $image)
                                                <div class="swiper-slide">
                                                    <img src="{{ asset($image->path) }}"/>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                    <div thumbsSlider="" class="swiper mySwiper mySwiperses-{{$item->id}}" style="margin-top: 10px">
                                        <div class="swiper-wrapper">
                                            @foreach($item->images as $index => $image)
                                                <div class="swiper-slide" >
                                                    <img src="{{ asset($image->path) }}" style="border-radius: 20px; height: 120px"/>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($item->pdf))
                                    <br>
                                    <div class="col-md-12">
                                        <div class="pdf-responsive">
                                            <iframe src="{{ asset($item->pdf) }}" width="100%" height="500px"
                                                    allowfullscreen></iframe>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection



@section('script')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @if(session('message'))
        <script>
            window.addEventListener('load', function () {
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('message') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
    <script>
        @foreach($specialNews as $item)
        var swiperThumbs{{$item->id}} = new Swiper(".mySwiperses-{{$item->id}}", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper{{$item->id}} = new Swiper(".mySwipers-{{$item->id}}", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiperThumbs{{$item->id}},
            },
        });
        @endforeach
    </script>
@endsection
