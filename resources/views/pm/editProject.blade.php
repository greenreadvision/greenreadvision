@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{__('customize.Edit')}}{{__('customize.Project')}}</h4>
                </div>
                <div class="card-body">
                    <form action="update" method="POST">
                        <div class="row">
                        @foreach($data->toArray() as $key => $value)
                            <div class="col-md-6">
                                <li><label class="col-form-label" for="{{$key}}">{{__('customize.'.$key)}}</label></li>
                                @if (is_array($value)) 
                                    {{-- @foreach($value as $arrayKey => $content)
                                        <li><label>{{__('customize.'.$arrayKey)}}</label><input type="text" name="{{$arrayKey}}" value="{{$content}}" class="form-control"></li>
                                    @endforeach --}}
                                @elseif (strpos($key, "_id"))
                                    <label class="col-form-label">{{$value}}</label>
                                @elseif (strpos($key, "_at"))
                                    <label class="col-form-label">{{$value}}</label>
                                @elseif (strpos($key, "_date"))
                                    <input type="date" id="{{$key}}" name="{{$key}}" value="{{$value}}" class="form-control" placeholder="2019-01-06">
                                @elseif (strpos($key, "inished"))
                                    <input type="hidden" name="{{$key}}" value="0">
                                    <input type="checkbox" id="{{$key}}" name="{{$key}}" value="1" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" {{$value? 'checked':''}}>
                                @elseif (strpos($key, "olor"))
                                    <input type="color" id="{{$key}}" name="{{$key}}" value="{{$errors->has($key)? old($key): $value}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" style="height:37px;" required>
                                @else
                                    <input type="text" id="{{$key}}" name="{{$key}}" value="{{$errors->has($key)? old($key): $value}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" placeholder="~尚未填寫~">
                                @endif
                                @if ($errors->has($key))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first($key) }}</strong>
                                    </span>
                                @endif
                            </div>
                        @endforeach
                        </div>
                        <hr>
                        <div style="float: right;">
                            @method('PUT')
                            @csrf
                            <button type="submit" class="btn btn-primary">{{__('customize.Save')}}</button>
                        </div>
                    </form>
                    <div style="float: left;">
                        <form action="delete" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-primary">{{__('customize.Delete')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@stop