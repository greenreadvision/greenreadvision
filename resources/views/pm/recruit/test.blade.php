@extends('layouts.app')
@section('content')
    
    <form action = "test/review" method="POST" enctype="multipart/form-data">
        @csrf
            <div class= "col-lg-12 form-group" style="padding-left:25%;padding-right:25%; align-self: center">
                @foreach($data as $item)

                <div class="card-style">
                    <div class="card-header">
                        <label class="label-style col-form-label" style="color: black" for="{{$item->question_id}}"> {{$item->title}}</label>
                    </div>
                    <div class="card-body" style="color: black">
                        <input type="radio" name="{{$item->question_id}}" value="option_1" checked> (A) {{$item->option_1}}<br>
                        <input type="radio" name="{{$item->question_id}}" value="option_2"> (B) {{$item->option_2}}<br>
                        <input type="radio" name="{{$item->question_id}}" value="option_3"> (C) {{$item->option_3}}<br>
                        <input type="radio" name="{{$item->question_id}}" value="option_4"> (D) {{$item->option_4}}<br>
                    </div>
                </div>
                @endforeach
            </div>
        <div class="col-lg-12 form-group" style="padding-left:70%">
            <button type="submit" class="btn btn-primary btn-primary-style">提交</button>
        </div>
    </form>
@stop