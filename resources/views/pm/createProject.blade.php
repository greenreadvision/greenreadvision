@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{__('customize.Add')}}{{__('customize.Project')}}</h4>
                </div>
                <div class="card-body">
                    <form action="create/review" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <li><label class="col-form-label">{{__('customize.Project')}}{{__('customize.Name')}}</label></li>
                                <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                <li><label class="col-form-label">{{__('customize.Beginning')}}{{__('customize.Date')}}</label></li>
                                <input type="date" name="beginning_date" class="form-control{{ $errors->has('beginning_date') ? ' is-invalid' : '' }}" value="{{ old('beginning_date') }}" placeholder="2018-11-22" required>
                                @if ($errors->has('beginning_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('beginning_date') }}</strong>
                                    </span>
                                @endif
                                <li><label class="col-form-label">{{__('customize.Deadline')}}{{__('customize.Date')}}</label></li>
                                <input type="date" name="deadline_date" class="form-control{{ $errors->has('deadline_date') ? ' is-invalid' : '' }}" value="{{ old('deadline_date') }}" placeholder="2018-11-22" required>
                                @if ($errors->has('deadline_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('deadline_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label">{{__('customize.Closing')}}{{__('customize.Date')}}</label></li>
                                <input type="date" name="closing_date" class="form-control{{ $errors->has('closing_date') ? ' is-invalid' : '' }}" value="{{ old('closing_date') }}" placeholder="2018-11-22" required>
                                @if ($errors->has('closing_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('closing_date') }}</strong>
                                    </span>
                                @endif
                                <li><label class="col-form-label">{{__('customize.BidBound')}}</label></li>
                                <input type="text" name="bid_bound" class="form-control{{ $errors->has('bid_bound') ? ' is-invalid' : '' }}" value="{{ old('bid_bound') }}" required>
                                @if ($errors->has('bid_bound'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bid_bound') }}</strong>
                                    </span>
                                @endif
                                <li><label class="col-form-label">{{__('customize.color')}}</label></li>
                                <input type="color" name="color" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" value="{{ old('color') }}" style="height:39px" required>
                                @if ($errors->has('color'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('color') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div style="float: right;">
                            <button type="submit" class="btn btn-primary">{{__('customize.Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@stop