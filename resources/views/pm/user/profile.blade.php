@extends('layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3">
            <button type="button" class="btn btn-primary btn-primary-style" data-toggle="modal" data-target="#passsword">
                更改密碼
            </button>
        </div>
        <div class="col-lg-6 mb-3">
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('editProfile')}}'"><i class='fas fa-edit'></i><span class="ml-3"> {{__('customize.Edit')}} </button>
        </div>
    </div>
</div>
<div class="modal fade" id="passsword" tabindex="-1" role="dialog" aria-labelledby="passsword" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passsword">更改密碼</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="password" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">新{{ __('customize.Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('customize.Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                    <div style="float: right;">
                        <button type="submit" class="btn btn-primary">{{__('customize.Save')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-style">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.name')}}</label></div>
                                    <div class="d-flex justify-content-center "><label class="content-label-style col-form-label">{{$data['name']==null? '-未填寫-':$data['name']}}</label></div>
                                </div>
                                <div class="col-lg-6">
                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.nickname')}}</label></div>
                                    <div class="d-flex justify-content-center "><label class="content-label-style col-form-label">{{$data['nickname']==null? '-未填寫-':$data['nickname']}}</label></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.email')}}</label></div>
                                    <div class="d-flex justify-content-center "><label class="content-label-style col-form-label">{{$data['email']==null? '-未填寫-':$data['email']}}</label></div>
                                </div>
                                <div class="col-lg-6">
                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.arrival_date')}}</label></div>
                                    <div class="d-flex justify-content-center "><label class="content-label-style col-form-label">{{$data['arrival_date']==null? '-未填寫-':$data['arrival_date']}}</label></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.bank')}}</label></div>
                                    <div class="d-flex justify-content-center "><label class="content-label-style col-form-label">{{$data['bank']==null? '-未填寫-':$data['bank']}}</label></div>
                                </div>
                                <div class="col-lg-6">
                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.bank_branch')}}</label></div>
                                    <div class="d-flex justify-content-center "><label class="content-label-style col-form-label">{{$data['bank_branch']==null? '-未填寫-':$data['bank_branch']}}</label></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.bank_account_number')}}</label></div>
                                    <div class="d-flex justify-content-center "><label class="content-label-style col-form-label">{{$data['bank_account_number']==null? '-未填寫-':$data['bank_account_number']}}</label></div>
                                </div>
                                <div class="col-lg-6">
                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.bank_account_name')}}</label></div>
                                    <div class="d-flex justify-content-center "><label class="content-label-style col-form-label">{{$data['bank_account_name']==null? '-未填寫-':$data['bank_account_name']}}</label></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.phone_number')}}</label></div>
                                    <div class="d-flex justify-content-center "><label class="content-label-style col-form-label">{{$data['phone_number']==null? '-未填寫-':$data['phone_number']}}</label></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop