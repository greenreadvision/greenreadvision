@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3 d-flex">
        </div>
        <div class="col-lg-6 mb-3">
            <button data-toggle="modal" data-target="#createModal" class="float-right btn btn-primary btn-primary-style"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span> </button>
        </div>
    </div>
</div>


<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">新增帳戶</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="bank/create" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="name">名稱</label>
                            <input autocomplete="off" type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="bank">銀行名稱</label>
                            <input autocomplete="off" type="text" id="bank" name="bank" class="form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{ old('bank') }}" required>
                            @if ($errors->has('bank'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="bank_branch">分行</label>
                            <input autocomplete="off" type="text" id="bank_branch" name="bank_branch" class="form-control{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{ old('bank_branch') }}" required>
                            @if ($errors->has('bank_branch'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_branch') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="bank_account_number">銀行帳號</label>
                            <input autocomplete="off" type="text" id="bank_account_number" name="bank_account_number" class="form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{ old('bank_account_number') }}" required>
                            @if ($errors->has('bank_account_number'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_account_number') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="bank_account_name">銀行戶名</label>
                            <input autocomplete="off" type="text" id="bank_account_name" name="bank_account_name" class="form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" value="{{ old('bank_account_name') }}" required>
                            @if ($errors->has('emabank_account_nameil'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_account_name') }}</strong>
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
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card card-style">
            <div class="card-body ">
                <div class="col-lg-12">
                    @foreach($data as $bank)
                    <div data-toggle="modal" data-target="#{{$bank->bank_id}}Modal" class="col-lg-12 collapse-style py-3 border-bottom">{{$bank->name}}</div>
                    <div class="modal fade" id="{{$bank->bank_id}}Modal" tabindex="-1" role="dialog" aria-labelledby="{{$bank->bank_id}}Modal" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form action="bank/{{$bank->bank_id}}/update" method="post" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-lg-12 form-group">
                                                <label class="label-style col-form-label" for="name">名稱</label>
                                                <input autocomplete="off" type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{$bank->name}}" required>
                                                @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bank') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <label class="label-style col-form-label" for="bank">銀行名稱</label>
                                                <input autocomplete="off" type="text" id="bank" name="bank" class="form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{$bank->bank}}" required>
                                                @if ($errors->has('bank'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bank') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <label class="label-style col-form-label" for="bank_branch">分行</label>
                                                <input autocomplete="off" type="text" id="bank_branch" name="bank_branch" class="form-control{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{ $bank->bank_branch }}" required>
                                                @if ($errors->has('bank_branch'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bank_branch') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <label class="label-style col-form-label" for="bank_account_number">銀行帳號</label>
                                                <input autocomplete="off" type="text" id="bank_account_number" name="bank_account_number" class="form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{ $bank->bank_account_number}}" required>
                                                @if ($errors->has('bank_account_number'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bank_account_number') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <label class="label-style col-form-label" for="bank_account_name">銀行戶名</label>
                                                <input autocomplete="off" type="text" id="bank_account_name" name="bank_account_name" class="form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" value="{{ $bank->bank_account_name }}" required>
                                                @if ($errors->has('emabank_account_nameil'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bank_account_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="md-5" style="float: right;">
                                            <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
                                        </div>

                                    </form>
                                    <div class="md-5" style="float: left">
                                        <form action="bank/{{$bank->bank_id}}/delete" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-danger-style">
                                                <i class='fas fa-trash-alt'></i><span class="ml-3">{{__('customize.Delete')}}</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@stop