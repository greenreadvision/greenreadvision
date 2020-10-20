@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
    <form action="update" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="number">廠商編號</label>
                    <input autocomplete="off" type="text" id="number" name="number" class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" value="{{ $data->number }}" required>
                    @if ($errors->has('number'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('number') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="name">廠商名稱</label>
                    <input autocomplete="off" type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $data->name }}" required>
                    @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-12 form-group">
                    <label class="label-style col-form-label" for="address">廠商地址</label>
                    <input autocomplete="off" type="text" id="address" name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ $data->address }}" required>
                    @if ($errors->has('address'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="email">E-Mail</label>
                    <input autocomplete="off" type="text" id="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $data->email }}" required>
                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="phone">聯絡電話</label>
                    <input autocomplete="off" type="text" id="phone" name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ $data->phone }}" required>
                    @if ($errors->has('phone'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div style="float: left;">
                <button type="button" class="btn btn-danger btn-danger-style" data-toggle="modal" data-target="#deleteModal">
                    <i class='fas fa-trash-alt'></i><span class="ml-3">{{__('customize.Delete')}}</span>
                </button>
            </div>
            <div class="md-5" style="float: right;">
                <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
            </div>


        </form>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                是否刪除?

            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">否</button>
                    <form action="delete" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-primary">是</button>
                    </form>
            </div>
        </div>
    </div>
</div>

@stop