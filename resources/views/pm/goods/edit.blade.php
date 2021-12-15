@extends('layouts.app')
@section('content')
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

                <form action="/goods/{{$good->goods_id}}/delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">是</button>
                </form>
            </div>
        </div>
    </div>
</div>

<form action="update" method="post" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="form-group row">
        <div class="col-lg-6 form-group">
            <label class="label-style col-form-label" for="signer">簽收人</label>
            <select required name="signer" type="text" class="form-control mb-2">
                <option value=""></option>
                @foreach($users as $user)
                @if($user->name == $good->signer)
                <option value="{{$user['name']}}" selected>{{$user['name']}}({{$user['nickname']}})</option>
                @else
                <option value="{{$user['name']}}">{{$user['name']}}({{$user['nickname']}})</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="col-lg-6 form-group">
            <label class="label-style col-form-label" for="purchase_id">採購單號</label>
            <input disabled id="purchase_id" type="text" name="purchase_id" class="form-control{{ $errors->has('purchase_id') ? ' is-invalid' : '' }}" value="{{$good->purchases->id}}">

            @if ($errors->has('purchase_id'))
            <span class="invalid-feedback" role="alert">
                <strong>不存在此單號</strong>
            </span>
            @endif
        </div>
        <div class="col-lg-6 form-group">
            <label class="label-style col-form-label" for="freight_name">貨運名稱</label>
        </div>
        <div class="col-lg-6 form-group">
            <label class="label-style col-form-label" for="receipt_date">簽收日期</label>
            <input required id="receipt_date" autocomplete="off" type="date" name="receipt_date" class="form-control{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}" value="{{ $good->receipt_date }}">
        </div>
        <div class="col-lg-6 form-group">
            <label class="label-style col-form-label" for="delivery_number">貨運單號</label>
        </div>
        <div class="col-lg-6 form-group">
                </div>
      
        <div class="col-lg-6 form-group">
            <label class="label-style col-form-label" for="inventory_name">清點人</label>
            <select name="inventory_name" type="text" class="form-control mb-2">
                <option value=""></option>
                @foreach($users as $user)
                @if($user->name == $good->inventory_name)
                <option value="{{$user['name']}}" selected>{{$user['name']}}({{$user['nickname']}})</option>
                @else
                <option value="{{$user['name']}}">{{$user['name']}}({{$user['nickname']}})</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="col-lg-6 form-group">
        </div>

        <div class="col-lg-6 form-group">
            <label class="label-style col-form-label" for="freight_bill">貨運單</label>
            <input accept="image/jpeg,image/gif,image/png" type="file" id="freight_bill" name="freight_bill" class="form-control{{ $errors->has('freight_bill') ? ' is-invalid' : '' }}">
        </div>
        <div class="col-lg-6 form-group">
            <label class="label-style col-form-label" for="freight_exterior">貨運外觀</label>
            <input accept="image/jpeg,image/gif,image/png" type="file" id="freight_exterior" name="freight_exterior" class="form-control{{ $errors->has('freight_exterior') ? ' is-invalid' : '' }}">
        </div>
        <div class="col-lg-6 form-group">
            <label class="label-style col-form-label" for="all_goods">全部物品</label>
            <input accept="image/jpeg,image/gif,image/png" type="file" id="all_goods" name="all_goods" class="form-control{{ $errors->has('all_goods') ? ' is-invalid' : '' }}">
        </div>
        <div class="col-lg-6 form-group">
            <label class="label-style col-form-label" for="single_good">單一物品</label>
            <input accept="image/jpeg,image/gif,image/png" type="file" id="single_good" name="single_good" class="form-control{{ $errors->has('single_good') ? ' is-invalid' : '' }}">
        </div>
        <div class="col-lg-6 form-group">
            <label class="label-style col-form-label" for="defect_goods">瑕疵物品</label>
            <input accept="image/jpeg,image/gif,image/png" type="file" id="defect_goods" name="defect_goods" class="form-control{{ $errors->has('defect_goods') ? ' is-invalid' : '' }}">
        </div>

    </div>
    <div class="md-5" style="float: right;">
        <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
    </div>
    <div class="md-5 float-left">
        <button type="button" class="btn btn-danger btn-danger-style" data-toggle="modal" data-target="#deleteModal">
            <span>{{__('customize.Delete')}}</span>
        </button>
    </div>


</form>


@stop