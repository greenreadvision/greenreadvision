@extends('layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-1 mb-4">
            <button type="button" class="btn btn-primary btn-primary-style" data-toggle="modal" data-target="#passsword">
                更改密碼
            </button>
        </div>
        <div class="col-lg-1 mb-4">
            <button type="button" class="btn btn-primary btn-primary-style" data-toggle="modal" data-target="#acccount">
                編輯帳號
            </button>
        </div>
        <div class="col-lg-10 mb-4">
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
<div class="modal fade" id="acccount" tabindex="-1" role="dialog" aria-labelledby="acccount" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="acccount">編輯帳號</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="account" method="POST">
                    @method('PUT')
                    <div class="form-group row">
                        <label for="account" class="col-md-4 col-form-label text-md-right">新{{ __('customize.account') }}</label>

                        <div class="col-md-6">
                            <input id="account" type="account" class="form-control{{ $errors->has('account') ? ' is-invalid' : '' }}" name="account" required>

                            @if ($errors->has('account'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('account') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="account-confirm" class="col-md-4 col-form-label text-md-right">{{ __('customize.Confirm account') }}</label>

                        <div class="col-md-6">
                            <input id="account-confirm" type="account" class="form-control" name="account_confirmation" required>
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
                                    <div class="d-flex justify-content-center "><label class="content-label-style col-form-label">{{$data['celephone']==null? '-未填寫-':$data['celephone']}}</label></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="container-fluid">

    <div class="row">
        <div class="col-sm-4 col-md-4 col-lg-3 mb-2">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body">
                    <div class="col-lg-12 form-group">
                        <label id="photo" class="input-photo-label label-style col-form-label p-0 rounded-circle" for="photos">
                            <small>大頭照</small>
                            <input accept="image/*" type="file" name="photos" id="photos" class="input-photo-input py-0 form-control{{ $errors->has('photos') ? ' is-invalid' : '' }}" />
                        </label>
                    
                    </div>
                   
                </div>
            </div>
        </div>

    </div>
</div> -->
@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#photo').height($('#photo').width())
        $(window).resize(function() {
            $('#photo').height($('#photo').width())
        });
        $('input').on('change', function(e) {
            id = e.target.id
            const file = this.files[0];

            const fr = new FileReader();
            fr.onload = function(e) {
                
                    $("#photo" ).css("background-image", "url(" + e.target.result + ")");
                
            };

            // 使用 readAsDataURL 將圖片轉成 Base64
            fr.readAsDataURL(file);
        });
    });
</script>
@stop