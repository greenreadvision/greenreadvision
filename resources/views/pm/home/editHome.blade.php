@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header text-center">
                    <h1>@lang('customize.Edit')@lang('customize.Post')</h1>
                </div>
                <div class="card-body">
                    <form action="update" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <li><label class="col-form-label">{{__('customize.Post')}}{{__('customize.Title')}}</label></li>
                                @foreach($data->toArray() as $key => $value)
                                    @if($key=="title")
                                     <input type="text" name="{{$key}}" class="form-control" value="{{$value}}" >
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-md-12">
                                <li><label class="col-form-label" for="content">{{__('customize.Post')}}{{__('customize.content')}}</label></li>
                                @foreach($data->toArray() as $key => $value)
                                    @if($key=="content")
                                    <textarea id="{{$key}}" name="{{$key}}" rows="5" style="resize:none;" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"
                                        required>{{ $value }}</textarea>
                                    @endif
                                @endforeach
                                    
                            </div>
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
@endsection
