@extends('layouts.app')
@section('content')
<!-- <div class="d-flex align-items-center mb-3">
    <h2>{{__('customize.BusinessCar')}}申請</h2>
</div> -->
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <form name="businessCarForm" action="create/review" method="post" >
            @csrf
            <div class="form-group row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                    <select type="text" id="project_id" name="project_id" class="form-control">
                        @foreach ($data as $project)
                        @if($project['name']!='其他' && $project['finished']==0)
                        <option value="{{$project['project_id']}}">{{$project['name']}}</option>
                        @endif
                        @endforeach
                        <option value="qs8dXg88gPm">其他</option>
                    </select>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="content">借車事由</label>
                    <input autocomplete="off" id="content" name="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" value="{{ old('content') }}" required>
                    @if ($errors->has('content'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('content') }}</strong>
                    </span> @endif
                </div>
                <!-- 駕駛人 -->
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="driver">{{__('customize.driver')}}</label>
                    <input autocomplete="off" type="text" id="driver" name="driver" class="form-control{{ $errors->has('driver') ? ' is-invalid' : '' }}" value="{{ old('driver') }}" required>
                    @if ($errors->has('driver'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('driver') }}</strong>
                    </span>
                    @endif
                </div>
                <!-- 駕駛人電話 -->
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="phone_number">{{__('customize.phone_number')}}(09xxxxxxxx)</label>
                    <input autocomplete="off" type="text" id="phone_number" name="phone_number" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" value="{{ old('phone_number') }}" required>
                    @if ($errors->has('phone_number'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('phone_number') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="begin_date">用車時間(自)</label>
                    <div class="form-row">
                        <div class="col-lg-6">
                            <input style="margin-right:5%" type="date" name="begin_date" class="form-control{{ $errors->has('begin_date') ? ' is-invalid' : '' }}" value="{{ old('begin_date') }}" placeholder="2018-11-22" required>
                        </div>
                        <div class="col-lg-6">
                            <input type="time" name="begin_time" class="form-control{{ $errors->has('begin_time') ? ' is-invalid' : '' }}" value="{{ old('begin_time') }}" required>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="end_date">用車時間(迄)</label>
                    <div class="form-row">
                        <div class="col-lg-6">
                            <input style="margin-right:5%" type="date" name="end_date" class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{ old('end_date') }}" placeholder="2018-11-22" required>
                        </div>
                        <div class="col-lg-6">
                            <input type="time" name="end_time" class="form-control{{ $errors->has('end_time') ? ' is-invalid' : '' }}" value="{{ old('end_time') }}" required>
                        </div>
                    </div>
                </div>



                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="begin_location">{{__('customize.begin_location')}}</label>
                    <input autocomplete="off" type="text" id="begin_location" name="begin_location" class="form-control{{ $errors->has('begin_location') ? ' is-invalid' : '' }}" value="{{ old('begin_location') }}" required>
                    @if ($errors->has('begin_location'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('begin_location') }}</strong>
                    </span> @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="end_location">{{__('customize.end_location')}}</label>
                    <input autocomplete="off" type="text" id="end_location" name="end_location" class="form-control{{ $errors->has('end_location') ? ' is-invalid' : '' }}" value="{{ old('end_location') }}" required>
                    @if ($errors->has('end_location'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('end_location') }}</strong>
                    </span> @endif
                </div>

            </div>
            <div class="md-5" style="float: right;">
                <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
            </div>


        </form>
    </div>
</div>
@stop