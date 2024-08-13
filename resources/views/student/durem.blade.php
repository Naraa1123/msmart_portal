@extends('layouts.student')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            @if(Session('message'))
                <h2 class="alert alert-success">{{ Session('message') }}</h2>
            @endif

            <div class="durem">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="durem-img">
                                <img src="{{asset("uploads/durem/durem.jpg")}}" alt="" width="100%">
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
