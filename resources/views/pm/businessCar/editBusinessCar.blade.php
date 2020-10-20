@extends('layouts.app')

@section('content')
<!-- <div class="d-flex align-items-center mb-3">
    <h2>{{__('customize.Edit')}}</h2>
</div> -->

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <form action="update" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                    <select type="text" id="project_id" name="project_id" class="form-control" autofocus>
                        @foreach ($data['projects'] as $project)
                        <option value="{{$project['project_id']}}" {{$project['selected']}}>{{$project['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="content">借車事由</label>
                    <input autocomplete="off" type="text" id="content" name="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" value="{{$errors->has('content')? old('content'): $data['business_car']['content']}}" required>
                    @if ($errors->has('content'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('content') }}</strong>
                    </span> @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="driver">{{__('customize.driver')}}</label>
                    <input autocomplete="off" type="text" id="driver" name="driver" class="form-control{{ $errors->has('driver') ? ' is-invalid' : '' }}" value="{{$errors->has('driver')? old('driver'): $data['business_car']['driver']}}" required>
                    @if ($errors->has('driver'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('driver') }}</strong>
                    </span> @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="phone_number">{{__('customize.phone_number')}}</label>
                    <input autocomplete="off" type="text" id="phone_number" name="phone_number" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" value="{{$errors->has('phone_number')? old('phone_number'): $data['business_car']['phone_number']}}" required>
                    @if ($errors->has('phone_number'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('phone_number') }}</strong>
                    </span> @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="begin_date">使用時間(自)</label>
                    <div class="row">
                        <div class="col-lg-6">
                            <input autocomplete="off" type="date" id="begin_date" name="begin_date" class="form-control{{ $errors->has('begin_date') ? ' is-invalid' : '' }}" value="{{$errors->has('begin_date')? old('begin_date'): $data['business_car']['begin_date']}}" required>
                            @if ($errors->has('begin_date'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('begin_date') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <input autocomplete="off" type="time" id="begin_time" name="begin_time" class="form-control{{ $errors->has('begin_time') ? ' is-invalid' : '' }}" value="{{$errors->has('begin_time')? old('begin_time'): $data['business_car']['begin_time']}}" required>
                            @if ($errors->has('begin_time'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('begin_time') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="end_date">使用時間(迄)</label>
                    <div class="row">
                        <div class="col-lg-6">
                            <input autocomplete="off" type="date" id="end_date" name="end_date" class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{$errors->has('end_date')? old('end_date'): $data['business_car']['end_date']}}" required>
                            @if ($errors->has('end_date'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('end_date') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <input autocomplete="off" type="time" id="end_time" name="end_time" class="form-control{{ $errors->has('end_time') ? ' is-invalid' : '' }}" value="{{$errors->has('end_time')? old('end_time'): $data['business_car']['end_time']}}" required>
                            @if ($errors->has('end_time'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('end_time') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="begin_location">{{__('customize.begin_location')}}</label>
                    <input autocomplete="off" type="text" id="begin_location" name="begin_location" class="form-control{{ $errors->has('begin_location') ? ' is-invalid' : '' }}" value="{{$errors->has('begin_location')? old('begin_location'): $data['business_car']['begin_location']}}" required>
                    @if ($errors->has('begin_location'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('begin_location') }}</strong>
                    </span> @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="end_location">{{__('customize.end_location')}}</label>
                    <input autocomplete="off" type="text" id="end_location" name="end_location" class="form-control{{ $errors->has('end_location') ? ' is-invalid' : '' }}" value="{{$errors->has('end_location')? old('end_location'): $data['business_car']['end_location']}}" required>
                    @if ($errors->has('end_location'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('end_location') }}</strong>
                    </span> @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="begin_mileage">{{__('customize.mileage')}}(去)</label>
                    <input autocomplete="off" type="text" id="begin_mileage" name="begin_mileage" value="{{$errors->has('begin_mileage')? old('begin_mileage'): $data['business_car']['begin_mileage']}}" class="form-control{{ $errors->has('begin_mileage') ? ' is-invalid' : '' }}" placeholder="尚未填寫">
                    @if ($errors->has('begin_mileage'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('begin_mileage') }}</strong>
                    </span> @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="end_mileage">{{__('customize.mileage')}}(回)</label>
                    <input autocomplete="off" type="text" id="end_mileage" name="end_mileage" value="{{$errors->has('end_mileage')? old('end_mileage'): $data['business_car']['end_mileage']}}" class="form-control{{ $errors->has('end_mileage') ? ' is-invalid' : '' }}" placeholder="尚未填寫">
                    @if ($errors->has('end_mileage'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('end_mileage') }}</strong>
                    </span> @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="payer">{{__('customize.payer')}}</label>
                    <input autocomplete="off" type="text" id="payer" name="payer" value="{{$errors->has('payer')? old('payer'): $data['business_car']['payer']}}" class="form-control{{ $errors->has('payer') ? ' is-invalid' : '' }}" placeholder="尚未填寫">
                    @if ($errors->has('payer'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('payer') }}</strong>
                    </span> @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="oil">{{__('customize.oil')}}</label>
                    <input autocomplete="off" type="text" id="oil" name="oil" value="{{$errors->has('oil')? old('oil'): $data['business_car']['oil']}}" class="form-control{{ $errors->has('oil') ? ' is-invalid' : '' }}" placeholder="尚未填寫">
                    @if ($errors->has('oil'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('oil') }}</strong>
                    </span> @endif
                </div>
            </div>
            <div style="float: left;">
                <button type="button" class="btn btn-danger btn-danger-style" data-toggle="modal" data-target="#deleteModal">
                    <i class='fas fa-trash-alt'></i><span class="ml-3">{{__('customize.Delete')}}</span>
                </button>
            </div>
            <div style="float: right;">
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