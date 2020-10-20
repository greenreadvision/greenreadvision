@extends('layouts.app')
@section('content')
<!-- <div class="d-flex align-items-center mb-3 col-lg-12">
    <h2>{{__('customize.Add')}}{{__('customize.Project')}}</h2>
</div> -->

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <form action="create/review" method="post">
            @csrf
            <div class="form-row">
                <div class="col-lg-6 form_group">
                    <label class="label-style col-form-label" for="company_name"></label>
                    <select type="text" id="company_name" name="company_name" class="form-control" autofocus>
                        <option value="grv">綠雷德</option>
                        <option value="rv">閱野</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-lg-12">
                    <label class="label-style col-form-label">{{__('customize.Project')}}{{__('customize.Name')}}</label>
                    <div class="form-row">
                        <!-- project name -->
                        <div class="form-group col-lg-6">
                            <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" autocomplete="off" required autofocus>
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>專案名稱已重複</strong>
                            </span>
                            @endif
                        </div>
                        <!-- color -->
                        <div class="form-group col-lg-6">
                            <input type="color" name="color" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" value="#0000ff" style="height:39px" required>
                            @if ($errors->has('color'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('color') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-lg-6">
                    <label class="label-style col-form-label">{{__('customize.Deadline')}}{{__('customize.date')}}</label>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <input style="margin-right:5%" type="date" name="deadline_date" class="form-control{{ $errors->has('deadline_date') ? ' is-invalid' : '' }}" value="{{ old('deadline_date') }}" placeholder="2018-11-22" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="time" name="deadline_time" class="form-control{{ $errors->has('deadline_time') ? ' is-invalid' : '' }}" value="{{ old('deadline_time') }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <label class="label-style col-form-label">{{__('customize.Open')}}{{__('customize.date')}}</label>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <input style="margin-right:5%" type="date" name="open_date" class="form-control{{ $errors->has('open_date') ? ' is-invalid' : '' }}" value="{{ old('open_date') }}" placeholder="2018-11-22" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="time" name="open_time" class="form-control{{ $errors->has('open_time') ? ' is-invalid' : '' }}" value="{{ old('open_time') }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-lg-6">
                    <label class="label-style col-form-label">{{__('customize.Closing')}}{{__('customize.date')}}</label>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <input type="date" name="closing_date" class="form-control{{ $errors->has('closing_date') ? ' is-invalid' : '' }}" value="{{ old('closing_date') }}" placeholder="2018-11-22" required>
                            @if ($errors->has('closing_date'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('closing_date') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <label class="label-style col-form-label">{{__('customize.BidBound')}}</label>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <input type="text" name="bid_bound" class="form-control{{ $errors->has('bid_bound') ? ' is-invalid' : '' }}" value="{{ old('bid_bound') }}" autocomplete="off" required>
                            @if ($errors->has('bid_bound'))
                            <span class="invalid-feedback" role="alert">
                                <strong>請輸入數字，不包含字元、標點符號</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div style="float: right;">
                <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
            </div>
        </form>
    </div>
</div>
@stop