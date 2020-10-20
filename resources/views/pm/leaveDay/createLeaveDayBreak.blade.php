@extends('layouts.app')
@section('content')
<!-- <div class="d-flex align-items-center mb-3">
    <h2>休假申請</h2>
</div> -->
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        @empty($length)
        @if(Auth::user()->role == 'accountant'||\Auth::user()->role == 'manager')
        <form action="/leaveDayBreak/{{$leaveDayId}}/create/next" method="post">
            @else
            <form action="/leaveDayBreak/create/next" method="post">
                @endif
                @endempty
                @isset($length)
                @if(Auth::user()->role == 'accountant'||\Auth::user()->role == 'manager')
                <form action="/leaveDayBreak/{{$leaveDayId}}/create/review" method="post">
                    @else
                    <form action="/leaveDayBreak/create/review" method="post">
                        @endif
                        @endisset
                        @csrf
                        <input autocomplete="off" type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-row">
                            <div class="col-md-12 mb-2" {{isset($length)? 'hidden':''}}>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text{{ $errors->has('length') ? ' is-invalid' : '' }}" for="length">@lang('customize.time')@lang('customize.length')</label>
                                    </div>
                                    <select name="length" class="custom-select">
                                        <option hidden></option>
                                        @foreach ($selected as $key => $select)
                                        <option value="{{$key}}" {{$select}}>@lang('customize.'.$key)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @isset($length)
                            @foreach ($names as $key => $name)
                            <div class="col-md mb-2" {{$hidden[$key]}}>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div for="{{$name}}" class="input-group-text{{$errors->has($name) ? ' is-invalid' : ''}}">
                                            @lang('customize.'.(strstr($name, '_', 2)))@lang("customize.".$types[$key])
                                        </div>
                                    </div>
                                    <input autocomplete="off" type="{{$types[$key]}}" name="{{$name}}" class="form-control">
                                </div>
                            </div>
                            @endforeach
                            @endisset
                        </div>
                        <div class="d-flex">
                            @isset($length)
                            <div>
                                <button type="button" onclick="location.href='{{url()->previous()}}'" class="btn btn-primary btn-primary-style">{{__('customize.prev')}}</button>
                            </div>
                            @endisset
                            <div class="ml-auto">
                                <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.next')}}</button>
                            </div>
                        </div>
                    </form>
    </div>
</div>
<!-- <div class="row justify-content-center">
    <div class="col-md-12 col-lg-10 col-xl-8">
        <div class="card" style="margin: 10px 0px;">
            <div class="card-header">
                <h4>休假申請</h4>
            </div>
            <div class="card-body">
                @empty($length)
                @if(Auth::user()->role == 'accountant'||\Auth::user()->role == 'manager')
                <form action="/leaveDayBreak/{{$leaveDayId}}/create/next" method="post">
                    @else
                    <form action="/leaveDayBreak/create/next" method="post">
                        @endif

                        @endempty
                        @isset($length)
                        @if(Auth::user()->role == 'accountant'||\Auth::user()->role == 'manager')
                        <form action="/leaveDayBreak/{{$leaveDayId}}/create/review" method="post">
                            @else
                            <form action="/leaveDayBreak/create/review" method="post">
                                @endif
                                @endisset
                                @csrf
                                <input autocomplete="off" type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-row">
                                    <div class="col-md-12 mb-2" {{isset($length)? 'hidden':''}}>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text{{ $errors->has('length') ? ' is-invalid' : '' }}" for="length">@lang('customize.time')@lang('customize.length')</label>
                                            </div>
                                            <select name="length" class="custom-select">
                                                <option hidden></option>
                                                @foreach ($selected as $key => $select)
                                                <option value="{{$key}}" {{$select}}>@lang('customize.'.$key)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @isset($length)
                                    @foreach ($names as $key => $name)
                                    <div class="col-md mb-2" {{$hidden[$key]}}>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div for="{{$name}}" class="input-group-text{{$errors->has($name) ? ' is-invalid' : ''}}">
                                                    @lang('customize.'.(strstr($name, '_', 2)))@lang("customize.".$types[$key])
                                                </div>
                                            </div>
                                            <input autocomplete="off" type="{{$types[$key]}}" name="{{$name}}" class="form-control">
                                        </div>
                                    </div>
                                    @endforeach
                                    @endisset
                                </div>
                                <div class="d-flex">
                                    @isset($length)
                                    <div>
                                        <button type="button" onclick="location.href='{{url()->previous()}}'" class="btn btn-primary">{{__('customize.prev')}}</button>
                                    </div>
                                    @endisset
                                    <div class="ml-auto">
                                        <button type="submit" class="btn btn-primary ">{{__('customize.next')}}</button>
                                    </div>
                                </div>
                            </form>
            </div>
        </div>
    </div>
</div> -->
@stop