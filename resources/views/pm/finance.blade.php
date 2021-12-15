@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h1>{{__('customize.Finance')}}</h1>
                </div>
                <div class="card-body row">
                    @foreach ($finances as $key => $finance)
                    <div class="col-md-12">
                        <p style="float: left;">{{$key+1}} | <a href="{{route('finance.review', $finance->finance_id)}}">{{$finance->project['name']}} => {{$finance->name}}</a></p>
                        <p style="float: right;">{{$finance->date}}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-10 col-xl-8">
            <hr>
            <button class="btn btn-primary" onclick="location.href='{{route('finance.create')}}'">{{__('customize.Add')}}</button>
        </div>
    </div>
@stop