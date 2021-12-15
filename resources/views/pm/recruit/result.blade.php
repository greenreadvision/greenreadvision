@extends('layouts.app')
@section('content')
<div class= "col-lg-12 form-group" style="padding-left:25%;padding-right:25%; align-self: center">
    <div class="card-style ">
        <div class="card-header" style="text-align: center;color:black; {{ $grade >= 80 ? ' background-color: #02DF82' : ' background-color: #FFB5B5' }}">
           <label class="label-style col-form-label" style="font-size: 26px;" > 整體獲得分數</label>
        </div>
        <div class="card-body" style="color: black; text-align:center;">
            <label class="label-style col-form-label" style="font-size: 26px;{{$grade >= 100 ?'display:block' : 'display:none'}}" >恭喜!完全正確!</label>
            <label class="label-style col-form-label" style="font-size: 26px;{{$grade >=80&&$grade<100 ?'display:block' : 'display:none'}}" >雖然還是有點小錯，以後多加注意。</label>
            <label class="label-style col-form-label" style="font-size: 26px;{{$grade <80 ?'display:block' : 'display:none'}}" >錯得有點多喔!回去再多看一次介紹。</label>
            <label class="label-style col-form-label" style="font-size: 26px;" >分數： {{round($grade,2)}}</label>
        </div>
    </div>
</div>
<div class= "col-lg-12 form-group" style="padding-left:25%;padding-right:25%; align-self: center">
    @foreach($fail as $item)
    <div class="card-style ">
        <div class="card-header" style="background-color:#FFB5B5;">
            <label class="label-style col-form-label" style="color: black" for="{{$item[0]->question_id}}"> {{$item[0]->title}}</label>
            <button type="button" style="{{$item[0]->content != null ? 'display:block' :'display:none'}} ;float:right;" class="btn btn-secondary" data-trigger="focus" data-toggle="popover" title="註解" data-placement="right" data-content="{{$item[0]->content}}">
                解釋
            </button>
        </div>
        <div class="card-body" style="color: black">
            <input type="radio" name="{{$item[0]->question_id}}" {{$item[1] == 'option_1' ? 'checked' : 'disabled'}}><span style="{{ $item[1] == 'option_1' ? ' background-color: #FFB5B5' : '' }};{{ $item[0]->answer == 'option_1' ? ' background-color: #02DF82' : '' }}"> (A) {{$item[0]->option_1}}</span><br>
            <input type="radio" name="{{$item[0]->question_id}}" {{$item[1] == 'option_2' ? 'checked' : 'disabled'}}><span style="{{ $item[1] == 'option_2' ? ' background-color: #FFB5B5' : '' }};{{ $item[0]->answer == 'option_2' ? ' background-color: #02DF82' : '' }}"> (B) {{$item[0]->option_2}}</span><br>
            <input type="radio" name="{{$item[0]->question_id}}" {{$item[1] == 'option_3' ? 'checked' : 'disabled'}}><span style="{{ $item[1] == 'option_3' ? ' background-color: #FFB5B5' : '' }};{{ $item[0]->answer == 'option_3' ? ' background-color: #02DF82' : '' }}"> (C) {{$item[0]->option_3}}</span><br>
            <input type="radio" name="{{$item[0]->question_id}}" {{$item[1] == 'option_4' ? 'checked' : 'disabled'}}><span style="{{ $item[1] == 'option_4' ? ' background-color: #FFB5B5' : '' }};{{ $item[0]->answer == 'option_4' ? ' background-color: #02DF82' : '' }}"> (D) {{$item[0]->option_4}}</span><br>
        </div>
    </div>
    @endforeach
</div>
@if($href =="active")
    @if($grade >= 100)
    <div class="col-lg-12 form-group" style="padding-left:70%">
        <button type="button" class="btn btn-primary btn-primary-style" onclick="window.location='{{route('train.three')}}'">{{__('customize.Next')}}</button>
    </div>
    @elseif($grade>80 && $grade<100)
    <div class="col-lg-12 form-group" style="padding-left:70%">
        <button type="button" class="btn btn-primary btn-primary-style" onclick="window.location='{{route('train.three')}}'">{{__('customize.Next')}}</button>
    </div>
    @else
    <div class="col-lg-12 form-group" style="padding-left:25%">
        <button type="button" class="btn btn-primary btn-primary-style" onclick="window.location='{{route('train.two')}}'">返回</button>
    </div>
    @endif
@elseif($href == "pm")
    @if($grade == 100)
    <div class="col-lg-12 form-group" style="padding-left:70%">
        <form action="{{ route('train.update') }}" method="POST">
            @method('PUT')
            @csrf
            <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Next')}}</button>
        </form>
    </div>
    @elseif($grade>80 && $grade<100)
    <div class="col-lg-12 form-group" style="padding-left:70%">
        <form action="{{ route('train.update') }}" method="POST">
            @method('PUT')
            @csrf
            <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Next')}}</button>
        </form>
    </div>
    @else
    <div class="col-lg-12 form-group" style="padding-left:25%">
        <button type="button" class="btn btn-primary btn-primary-style" onclick="window.location='{{route('train.three')}}'">返回</button>
    </div>
    @endif
@endif
@stop

@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
            $(document).ready(function() {
                $('[data-toggle="popover"]').popover({
                    container: 'body',
                    
                });
            });
    </script>
@stop
    