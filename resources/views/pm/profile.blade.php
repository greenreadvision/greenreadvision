@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-11 col-lg-10">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{__('customize.Profile')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($data as $key => $value)
                        <div class="col-md-6 row">
                            <li class="col-md-6"><label class="col-form-label"><b>{{__('customize.'.$key)}} :</b></label></li>
                            <label class="col-md-6 col-form-label text-sm-right">{{$value==null? '無':$value}}</label>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div style="float: right;">
                        <button class="btn btn-primary" onclick="location.href='{{route('editProfile')}}'">{{__('customize.Edit')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop