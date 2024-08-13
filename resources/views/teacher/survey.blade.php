@extends('layouts.teacher')

@section('content')
    <style>

        form {
            background-color: #fff;
            margin: 50px auto;
            width: 70%;
            padding: 30px 20px;
            box-shadow: 2px 5px 10px rgba(0, 0, 0, 0.5);
        }

        .form-group {
            text-align: left;
            display: flex;
            flex-direction: column;
        }

        #surveyForm {
            border-radius: 10px;
        }

        #submitBtn {
            background-color: #12bbd4;
            border: 1px solid #777;
            border-radius: 2px;
            font-family: inherit;
            font-size: 21px;
            display: block;
            width: 100%;
            margin-top: 50px;
            margin-bottom: 20px;
        }
        ul{
            width: 100%;
        }

        ul li{
            margin-left: 10px;
        }


        ul.ks-cboxtags {
            list-style: none;
        }

        ul.ks-cboxtags li {
            display: inline-block;
            width: 23%;
            text-align: center;
            box-sizing: border-box;
        }

        ul.ks-cboxtags li label {
            display: block;
            width: 100%;
            padding: 8px 0;
        }
        @media (max-width: 430px) {
            ul.ks-cboxtags li {
                display: block;
                width: 100%;
                text-align: center;
                box-sizing: border-box;
                margin-left: 0;
            }
            ul.ks-cboxtags li label {
                display: block;
                width: 100%;
                padding: 8px 0;
            }
            ul.ks-cboxtags li label::before {
                padding: 2px 0 2px 2px;
                font-size: 20px;
            }
            .ks-cboxtags{
                padding-left: 0;
            }
        }

        ul.ks-cboxtags li label {
            display: inline-block;
            background-color: rgba(255, 255, 255, .9);
            border: 2px solid rgba(139, 139, 139, .3);
            color: #adadad;
            border-radius: 25px;
            white-space: nowrap;
            margin: 3px 0px;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
            transition: all .2s;
        }

        ul.ks-cboxtags li label {
            padding: 8px 12px;
            cursor: pointer;
        }

        ul.ks-cboxtags li label::before {
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 12px;
            padding: 2px 6px 2px 2px;
            content: "\f067";
            transition: transform .3s ease-in-out;
        }

        ul.ks-cboxtags li input[type="checkbox"],
        ul.ks-cboxtags li input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        ul.ks-cboxtags li input[type="checkbox"]:focus + label,
        ul.ks-cboxtags li input[type="radio"]:focus + label {
            border: 2px solid #e9a1ff;
        }

        ul.ks-cboxtags li input[type="checkbox"]:checked + label::before,
        ul.ks-cboxtags li input[type="radio"]:checked + label::before {
            content: "\f00c";
            transform: rotate(-360deg);
            transition: transform .3s ease-in-out;
        }

        ul.ks-cboxtags li input[type="checkbox"]:checked + label,
        ul.ks-cboxtags li input[type="radio"]:checked + label {
            border: 2px solid #1bdbf8;
            background-color: #12bbd4;
            color: #fff;
            transition: all .2s;
        }

    </style>

    <form id="surveyForm" action="{{ route('teacher.submit-survey', ['id' => $survey->id]) }}" method="POST">
        @csrf

        <div class="form-group" style="text-align: center">
            <h1 style="font-weight: bold;">{{$survey->name}}</h1>
            <label>{{$survey->description}}</label>
        </div>
        @foreach($survey->questions as $question)
            @if($question->question_type=='text')
                <div class="form-group">
                    <label for="name" id="label-name" style="font-weight: bold">
                        {{$question->question_text}}
                    </label>
                    <input class="form-control" type="text" id="name"
                           name="answers[{{ $question->id }}]" placeholder="Enter your answer"/>
                </div>
            @elseif($question->question_type=='multiselect')
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="name" id="label-name" style="font-weight: bold">
                        {{$question->question_text}} <span style="font-weight: normal">/Олныг сонгох боломжтой/</span>
                    </label>
                    <ul class="ks-cboxtags">
                        @foreach($question->answers as $answer)
                            <li><input type="checkbox" id="answer{{$answer->id}}" name="answers[{{ $question->id }}][]"
                                       value="{{$answer->answer_text}}"><label
                                    for="answer{{$answer->id}}">{{$answer->answer_text}}</label></li>
                        @endforeach
                    </ul>
                </div>
            @elseif($question->question_type=='radio')
                <div class="form-group">
                    <label for="name" id="label-name" style="font-weight: bold">
                        {{$question->question_text}}
                    </label>
                    <ul class="ks-cboxtags">
                        @foreach($question->answers as $answer)
                            <li><input type="radio" id="flexRadioDefault{{$answer->id}}" name="answers[{{ $question->id }}]"
                                       value="{{$answer->answer_text}}">
                                <label for="flexRadioDefault{{$answer->id}}">{{$answer->answer_text}}</label></li>
                        @endforeach
                    </ul>
                </div>
            @elseif($question->question_type=='number')
                <div class="form-group">
                    <label for="name" id="label-name" style="font-weight: bold">
                        {{$question->question_text}}
                    </label>
                    <select class="form-control" name="answers[{{ $question->id }}]">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
            @endif
        @endforeach
        <button id="submitBtn" type="submit" value="submit">
            Submit
        </button>
    </form>
@endsection
