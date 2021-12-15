@extends('layouts.app') 
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{__('customize.Add')}}{{__('customize.Invoice')}}</h4>
                </div>
                <div class="card-body">
                    <form action="create/review" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-6">
                                <li><label class="col-form-label" for="project_id">{{__('customize.Project')}}</label></li>
                                <select type="text" id="project_id" name="project_id" class="form-control" autofocus>
                                    @foreach ($data as $project)
                                        <option value="{{$project['project_id']}}">{{$project['name']}}</option>
                                    @endforeach
                                    </select>
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label" for="company">{{__('customize.company')}}</label></li>
                                <input type="text" id="company" name="company" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" value="{{ old('company') }}"
                                    required> @if ($errors->has('company'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span> @endif
                            </div>
                            <div class="col-md-12">
                                <li><label class="col-form-label" for="content">{{__('customize.content')}}</label></li>
                                <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"
                                    required>{{ old('content') }}</textarea> @if ($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span> @endif
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label" for="bank">{{__('customize.bank')}}</label></li>
                                <input type="text" id="bank" name="bank" class="form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{ old('bank') }}"
                                    required> @if ($errors->has('bank'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank') }}</strong>
                                    </span> @endif
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label" for="bank_branch">{{__('customize.bank_branch')}}</label></li>
                                <input type="text" id="bank_branch" name="bank_branch" class="form-control{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}"
                                    value="{{ old('bank_branch') }}" required> @if ($errors->has('bank_branch'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_branch') }}</strong>
                                    </span> @endif
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label" for="bank_account_number">{{__('customize.bank_account_number')}}</label></li>
                                <input type="text" id="bank_account_number" name="bank_account_number" class="form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}"
                                    value="{{ old('bank_account_number') }}" required> @if ($errors->has('bank_account_number'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_account_number') }}</strong>
                                    </span> @endif
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label" for="bank_account_name">{{__('customize.bank_account_name')}}</label></li>
                                <input type="text" id="bank_account_name" name="bank_account_name" class="form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}"
                                    value="{{ old('bank_account_name') }}" required> @if ($errors->has('bank_account_name'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_account_name') }}</strong>
                                    </span> @endif
                            </div>
                            <div class="row col-md-6" style="margin:auto;">
                                <li class="col-12" style="padding:unset;"><label class="col-form-label">{{__('customize.receipt')}}</label></li>
                                <label class="col-6 col-form-label" for="receipt_true"><input type="radio" id="receipt_true" name="receipt" value="1" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{old('receipt')? 'checked': ''}} required>有</label>
                                <label class="col-6 col-form-label" for="receipt_false"><input type="radio" id="receipt_false" name="receipt" value="0" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{old('receipt')? '': 'checked'}}>沒有，待補</label>                                @if ($errors->has('receipt'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('receipt') }}</strong>
                                    </span> @endif
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label" for="receipt_date">{{__('customize.receipt_date')}}</label></li>
                                <input type="date" id="receipt_date" name="receipt_date" class="form-control{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}"
                                    value="{{ old('receipt_date') }}" required> @if ($errors->has('receipt_date'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('receipt_date') }}</strong>
                                    </span> @endif
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label" for="remuneration">{{__('customize.remuneration')}}</label></li>
                                <input type="text" id="remuneration" name="remuneration" class="form-control{{ $errors->has('remuneration') ? ' is-invalid' : '' }}"
                                    value="{{ old('remuneration') }}" required> @if ($errors->has('remuneration'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('remuneration') }}</strong>
                                    </span> @endif
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label" for="price">{{__('customize.price')}}</label></li>
                                <input type="text" id="price" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') }}"
                                    required> @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span> @endif
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label" for="receipt_file">{{__('customize.receipt_file')}}</label></li>
                                <input type="file" id="receipt_file" name="receipt_file" class="form-control{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}">                                @if ($errors->has('receipt_file'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('receipt_file') }}</strong>
                                    </span> @endif
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label" for="detail_file">{{__('customize.detail_file')}}</label></li>
                                <input type="file" id="detail_file" name="detail_file" class="form-control{{ $errors->has('detail_file') ? ' is-invalid' : '' }}">                                @if ($errors->has('detail_file'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('detail_file') }}</strong>
                                    </span> @endif
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