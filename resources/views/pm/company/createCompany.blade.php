@extends('layouts.app')
@section('content')


<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <form name="companyForm" action="create/review" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="number">廠商編號</label>
                    <input autocomplete="off" type="text" id="number" name="number" class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" value="{{ old('number') }}" required>
                    @if ($errors->has('number'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('number') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="name">廠商名稱</label>
                    <input autocomplete="off" type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                    @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-12 form-group">
                    <label class="label-style col-form-label" for="address">廠商地址</label>
                    <input autocomplete="off" type="text" id="address" name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address') }}" required>
                    @if ($errors->has('address'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="email">E-Mail</label>
                    <input autocomplete="off" type="text" id="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="phone">聯絡電話</label>
                    <input autocomplete="off" type="text" id="phone" name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" required>
                    @if ($errors->has('phone'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="md-5" style="float: right;">
                <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
            </div>


        </form>
    </div>
</div>


@stop