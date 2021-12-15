@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    <form action="create/review" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="col-lg-2 form-group">
                                <label class="label-style col-form-label" for="company_name">投標公司</label>
                                <select type="text" id="company_name" name="company_name" class="form-control rounded-pill" autofocus>
                                    <option value='grv_2'>綠雷德創新</option>
                                    <option value='rv'>閱野</option>
                                    <option value='grv'>綠雷德(舊)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-lg-8 form-group">
                                <label class="label-style col-form-label">{{__('customize.Project')}}名稱</label>
                                <input type="text" name="name" class="rounded-pill form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" autocomplete="off" required autofocus>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>專案名稱已重複</strong>
                                </span>
                                @endif

                            </div>
                            <div class="form-group col-lg-2 d-flex align-items-end">
                                <input type="color" name="color" class="rounded-pill form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" value="#ffffff" style="height:39px" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-6">
                                <label class="label-style col-form-label">{{__('customize.Deadline')}}{{__('customize.date')}}</label>
                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <input style="margin-right:5%" type="date" name="deadline_date" class="rounded-pill form-control{{ $errors->has('deadline_date') ? ' is-invalid' : '' }}" value="{{ old('deadline_date') }}" placeholder="2018-11-22" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input type="time" name="deadline_time" class="rounded-pill form-control{{ $errors->has('deadline_time') ? ' is-invalid' : '' }}" value="{{ old('deadline_time') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="label-style col-form-label">{{__('customize.Open')}}{{__('customize.date')}}</label>
                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <input style="margin-right:5%" type="date" name="open_date" class="rounded-pill form-control{{ $errors->has('open_date') ? ' is-invalid' : '' }}" value="{{ old('open_date') }}" placeholder="2018-11-22" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input type="time" name="open_time" class="rounded-pill form-control{{ $errors->has('open_time') ? ' is-invalid' : '' }}" value="{{ old('open_time') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-6">
                                <label class="label-style col-form-label">{{__('customize.Closing')}}{{__('customize.date')}}</label>
                                <div class="form-row">
                                    <div class="form-group col-lg-12">
                                        <input type="date" name="closing_date" class="rounded-pill form-control{{ $errors->has('closing_date') ? ' is-invalid' : '' }}" value="{{ old('closing_date') }}" placeholder="2018-11-22" required>
                                        @if ($errors->has('closing_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('closing_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6">
                                <label class="label-style col-form-label">{{__('customize.BidBound')}}</label>
                                <div class="form-row">
                                    <div class="form-group col-lg-12">
                                        <input type="text" name="contract_value" class="form-control{{ $errors->has('contract_value') ? ' is-invalid' : '' }}" value="{{ old('contract_value') }}" autocomplete="off" required>
                                        @if ($errors->has('contract_value'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>請輸入數字，不包含字元、標點符號</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div style="float: right;">
                            <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">{{__('customize.Add')}}</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop