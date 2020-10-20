@extends('layouts.app')
@section('content')
<!-- <div class="d-flex align-items-center mb-3">
    <h2>特休</h2>
</div> -->
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <form action="/leaveDayApply/{{$leaveDayId}}/add/review" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label">授課/活動日期</label>
                    <input type="date" name="apply_date" class="form-control{{ $errors->has('apply_date') ? ' is-invalid' : '' }}" placeholder="2018-11-22" required>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label">應休日數</label>
                    <input autocomplete="off" type="text" id="should_break" name="should_break" class="form-control{{ $errors->has('should_break') ? ' is-invalid' : '' }}" value="{{ old('should_break') }}" required>
                    @if ($errors->has('should_break'))
                    <span class="invalid-feedback" role="alert">
                        <strong>請輸入應休日數</strong>
                    </span>
                    @endif
                </div>

            </div>
            <div style="float: right;">
                <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>

    </div>
</div>
<!-- <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>特休</h4>
                </div>
                <div class="card-body">
               
                    <form action="/leaveDayApply/{{$leaveDayId}}/add/review" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                            <li><label class="col-form-label">授課/活動日期</label><input type="date" name="apply_date" class="form-control{{ $errors->has('apply_date') ? ' is-invalid' : '' }}" placeholder="2018-11-22" required></li>
                            <li><label class="col-form-label" >應休日數</label></li>
                                <input autocomplete="off" type="text" id="should_break" name="should_break" class="form-control{{ $errors->has('should_break') ? ' is-invalid' : '' }}" value="{{ old('should_break') }}"required>
                            </div>
                        </div>
                        <hr>
                        <div style="float: right;">
                            <button type="submit" class="btn btn-primary">{{__('customize.Save')}}</button>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                    @if($errors->any())
                        @foreach ($errors->toArray() as $errorName => $errorMessage)
                            <p>@lang($errorName)有誤，請重新更正。</p>
                        @endforeach
                    @endif          
                </div>
            </div>
        </div>
    </div> -->
@stop