@extends('layouts.app')

@section('content')
<!-- <div class="row">
    <div class="col-lg-6 mb-3">
        <h2>{{__('customize.Edit')}}{{__('customize.Profile')}}</h2>
    </div>
</div> -->
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-lg-12">
                <form action="update" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card card-style">
                        <div class="card-body">

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.name')}}</label></div>
                                        <div class="d-flex justify-content-center "><label class="content-label-style col-form-label"><input autocomplete="off" placeholder="尚未填寫" type="text" name="{{__('name')}}" value="{{$data['name']}}" class="form-control"></label></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.nickname')}}</label></div>
                                        <div class="d-flex justify-content-center "><label class="content-label-style col-form-label"><input autocomplete="off" placeholder="尚未填寫" type="text" name="{{__('nickname')}}" value="{{$data['nickname']}}" class="form-control"></label></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.email')}}</label></div>
                                        <div class="d-flex justify-content-center "><label class="content-label-style col-form-label"><input autocomplete="off" placeholder="尚未填寫" type="text" name="{{__('email')}}" value="{{$data['email']}}" class="form-control"></label></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.arrival_date')}}</label></div>
                                        <div class="d-flex justify-content-center "><label class="content-label-style col-form-label"><input type="date" name="{{__('arrival_date')}}" value="{{$data['arrival_date']}}" class="my-1 form-control" placeholder=""></label></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.bank')}}</label></div>
                                        <div class="d-flex justify-content-center "><label class="content-label-style col-form-label"><input autocomplete="off" placeholder="尚未填寫" type="text" name="{{__('bank')}}" value="{{$data['bank']}}" class="form-control"></label></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.bank_branch')}}</label></div>
                                        <div class="d-flex justify-content-center "><label class="content-label-style col-form-label"><input autocomplete="off" placeholder="尚未填寫" type="text" name="{{__('bank_branch')}}" value="{{$data['bank_branch']}}" class="form-control"></label></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.bank_account_number')}}</label></div>
                                        <div class="d-flex justify-content-center "><label class="content-label-style col-form-label"><input autocomplete="off" placeholder="尚未填寫" type="text" name="{{__('bank_account_number')}}" value="{{$data['bank_account_number']}}" class="form-control"></label></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.bank_account_name')}}</label></div>
                                        <div class="d-flex justify-content-center "><label class="content-label-style col-form-label"><input autocomplete="off" placeholder="尚未填寫" type="text" name="{{__('bank_account_name')}}" value="{{$data['bank_account_name']}}" class="form-control"></label></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.phone_number')}}(09xxxxxxxx)</label></div>
                                        <div class="d-flex justify-content-center "><label class="content-label-style col-form-label"><input autocomplete="off" placeholder="尚未填寫" type="text" name="{{__('phone_number')}}" value="{{$data['phone_number']}}" class="form-control"></label></div>
                                    </div>
                                </div>
                            </div>

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
<!-- 
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10 col-xl-8">
        <div class="card" style="margin: 10px 0px;">
            <div class="card-header">
                <h4>{{__('customize.Edit')}}{{__('customize.Profile')}}</h4>
            </div>
            <div class="card-body">
                <form action="update" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        @foreach($data as $key => $value)
                        <div class="col-lg-6">
                            @if (strpos($key, "_id") || strpos($key, "_at"))
                            <li><label class="col-form-label">{{__('customize.'.$key)}}</label></li>
                            <label class="col-md-12 col-form-label text-sm-right">{{$value==null? '無':$value}}</label>
                            @elseif (strpos($key, "_date"))
                            <li><label class="col-form-label">{{__('customize.'.$key)}}</label></li>
                            <input type="date" name="{{$key}}" value="{{$value}}" class="form-control" placeholder="2019-01-06">
                            @else
                            <li><label class="col-form-label">{{__('customize.'.$key)}} </label></li>
                            <input type="text" name="{{__($key)}}" value="{{$value}}" class="form-control">
                            @endif

                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div style="float: right;">
                        <button type="submit" class="btn btn-primary">{{__('customize.Save')}}</button>
                    </div>
                </form>
                <form>
                    <div style="float: left;">
                        <button type="submit" class="btn btn-primary">更改密碼</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->

@stop