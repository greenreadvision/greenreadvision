@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{__('customize.Edit')}}{{__('customize.Profile')}}</h4>
                </div>
                <div class="card-body">
                    <form action="update" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            @foreach($data as $key => $value)
                            <div class="col-lg-6">
                                @if (strpos($key, "_id") || strpos($key, "_at"))
                                    <li><label class="col-form-label">{{__('customize.'.$key)}}</label></li>
                                    <label class="col-md-12 col-form-label text-sm-right">{{$value==null? '無':$value}}</label>
                                @elseif (strpos($key, "_date"))
                                    <li><label class="col-form-label">{{__('customize.'.$key)}}</label></li>
                                    <input type="date" name="{{$key}}" value="{{$value}}" class="form-control" placeholder="2019-01-06">
                                @else
                                    <li><label class="col-form-label">{{__('customize.'.$key)}} </label></li>
                                    <input type="text" name="{{__($key)}}" value="{{$value}}" class="form-control">
                                @endif
                            </div>
                            @endforeach
                        </div>
                        <hr>
                        <div style="float: right;">
                            <button type="submit" class="btn btn-primary">{{__('customize.Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@stop