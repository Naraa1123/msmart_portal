@extends('layouts.admin')

@section('content')
    <style>
        :root {
            --purple: hsl(240, 80%, 89%);
            --pink: hsl(0, 59%, 94%);
            --light-bg: hsl(204, 37%, 92%);
            --light-gray-bg: hsl(0, 0%, 94%);
            --white: hsl(0, 0%, 100%);
            --dark: hsl(0, 0%, 7%);
            --text-gray: hsl(0, 0%, 30%);
        }

        h3 {
            font-size: 1.5em;
            font-weight: 700;
        }

        p {
            font-size: 1em;
            line-height: 1.7;
            font-weight: 300;
        }


        a {
            text-decoration: none;
            color: inherit;
        }

        .wrap {
            display: flex;
            align-items: stretch;
            width: 100%;
            gap: 24px;
            padding: 24px;
            flex-wrap: wrap;
        }

        .box {
            display: flex;
            flex-direction: column;
            flex-basis: 100%;
            position: relative;
            padding: 24px;
            background: #fff;
            border-radius: 8px;
        }

        .box-top {
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .title-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .box-title {
            border-left: 3px solid var(--purple);
            padding-left: 12px;
        }

        .user-follow-info {
            color: hsl(0, 0%, 60%);
        }

        .button {
            display: block;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-top: auto;
            padding: 16px;
            color: #000;
            background: transparent;
            box-shadow: 0px 0px 0px 1px black inset;
            transition: background 0.4s ease;
        }

        .button:hover {
            background: var(--purple);
        }


        .fill-two {
            background: var(--pink);
        }

        /* RESPONSIVE QUERIES */

        @media (min-width: 320px) {
            .title-flex {
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                align-items: start;
            }

            .user-follow-info {
                margin-top: 6px;
            }
        }

        @media (min-width: 460px) {
            .title-flex {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: start;
            }

            .user-follow-info {
                margin-top: 6px;
            }
        }

        @media (min-width: 640px) {
            .box {
                flex-basis: calc(50% - 12px);
            }

            .title-flex {
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                align-items: start;
            }

            .user-follow-info {
                margin-top: 6px;
            }
        }

        @media (min-width: 840px) {
            .title-flex {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: start;
            }

            .user-follow-info {
                margin-top: 6px;
            }
        }

        @media (min-width: 1024px) {
            .box {
                flex-basis: calc(33.3% - 16px);
            }

            .title-flex {
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                align-items: start;
            }

            .user-follow-info {
                margin-top: 6px;
            }
        }

        @media (min-width: 1100px) {
            .box {
                flex-basis: calc(25% - 18px);
            }
        }
    </style>
    @if(!empty($teacher_surveys))
        <div class="wrap">
            @foreach($teacher_surveys as $survey)
                <div class="box">
                    <div class="box-top">
                        <div class="title-flex">
                            <h3 class="box-title">{{$survey->name}}   <span class="user-follow-info" style="font-size: small">Багш</span></h3>
                            <p class="user-follow-info">Судалгаа бөглөсөн багш нарын тоо : <span
                                    style="font-weight: bold">{{count($survey->respondents)}}</span></p>
                        </div>
                        <p class="description">{{$survey->description}}</p>
                    </div>
                    <a href="{{route('admin.survey_respondent_class',['id'=>encrypt($survey->id)])}}" class="button">Шалгах</a>
                </div>
            @endforeach
        </div>
    @endif
    @if(count($student_surveys)>0)
        <div class="wrap">
            @foreach($student_surveys as $survey)
                <div class="box">
                    <div class="box-top">
                        <div class="title-flex">
                            <h3 class="box-title">{{$survey->name}}
                                <span class="user-follow-info" style="font-size: small">Сурагч</span> </h3>
                            <p class="user-follow-info">Судалгаа бөглөсөн оюутнуудын тоо : <span
                                    style="font-weight: bold">{{count($survey->respondents)}}</span></p>
                        </div>
                        <p class="description">{{$survey->description}}</p>
                    </div>
                    <a href="{{route('admin.survey_respondent_class',['id'=>encrypt($survey->id)])}}" class="button">Шалгах</a>
                </div>
            @endforeach
        </div>

    @endif
@endsection
