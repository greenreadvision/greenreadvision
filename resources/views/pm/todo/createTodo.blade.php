@extends('layouts.app')
@section('content')

<!-- <div class="d-flex align-items-center mb-3">
    <h2>{{__('customize.Add')}}{{__('customize.Todo')}}</h2>
</div> -->

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <form action="create/review" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="detail_file">{{__('customize.Project')}}</label>
                    <select type="text" name="project_id" class="form-control{{ $errors->has('project_id') ? ' is-invalid' : '' }}">
                        <optgroup label="綠雷德">
                            @foreach($data['grv_2'] as $grv2)
                            @if( $grv2['finished']==0)
                            <option value="{{$grv2['project_id']}}">{{$grv2->name}}</option>
                            @endif
                            @endforeach
                        </optgroup>
                        <optgroup label="閱野">
                            @foreach($data['rv'] as $r)
                            @if( $r['finished']==0)
                            <option value="{{$r['project_id']}}">{{$r->name}}</option>
                            @endif
                            @endforeach
                        </optgroup>
                        <optgroup label="綠雷德(舊)">
                            @foreach($data['grv'] as $gr)
                            @if($gr['name']!='其他' && $gr['finished']==0)
                            <option value="{{$gr['project_id']}}">{{$gr->name}}</option>
                            @endif

                            @endforeach
                        </optgroup>
                        
                        <option value="qs8dXg88gPm">其他</option>
                    </select>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="detail_file">{{__('customize.date')}}</label>
                    <input type="date" name="deadline" class="form-control{{ $errors->has('deadline') ? ' is-invalid' : '' }}" placeholder="2018-11-22" required>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="detail_file">{{__('customize.Name')}}</label>
                    <input autocomplete="off" type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="detail_file">{{__('customize.content')}}</label>
                    <input autocomplete="off" type="text" name="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" required>
                </div>
            </div>
            <div style="float: right;">
                <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>

    </div>
</div>

<!-- <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{__('customize.Add')}}{{__('customize.Todo')}}</h4>
                </div>
                <div class="card-body">
                    <form action="create/review" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <li><label class="col-form-label">{{__('customize.Project')}}</label><select type="text" name="project_id" class="form-control{{ $errors->has('project_id') ? ' is-invalid' : '' }}">
                                    
                                </select></li>
                                <li><label class="col-form-label">{{__('customize.Name')}}</label><input autocomplete="off" type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required></li>
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label">{{__('customize.content')}}</label><input autocomplete="off" type="text" name="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" required></li>
                                <li><label class="col-form-label">{{__('customize.date')}}</label><input type="date" name="deadline" class="form-control{{ $errors->has('deadline') ? ' is-invalid' : '' }}" placeholder="2018-11-22" required></li>
                            </div>
                        </div>
                        <hr>
                        <div style="float: right;">
                            <button type="submit" class="btn btn-primary">{{__('customize.Save')}}</button>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                    @if($errors->any())
                        @foreach ($errors->toArray() as $errorName => $errorMessage)
                            <p>@lang($errorName)有誤，請重新更正。</p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div> -->

@stop