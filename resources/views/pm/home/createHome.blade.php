@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{__('customize.Add')}}{{__('customize.Post')}}</h4>
                </div>
                <div class="card-body">
                <form action="create/review" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <li><label class="col-form-label">{{__('customize.Post')}}{{__('customize.Title')}}</label></li>
                                    <input type="text" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" required autofocus>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <li><label class="col-form-label" for="content">{{__('customize.Post')}}{{__('customize.content')}}</label></li>
                                    <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"
                                        required>{{ old('content') }}</textarea> @if ($errors->has('content'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span> @endif
                            </div>
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
@endsection
