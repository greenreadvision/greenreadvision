@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
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
                                    @foreach ($data as $project)
                                        <option value="{{$project['project_id']}}">{{$project['name']}}</option>
                                    @endforeach
                                </select></li>
                                <li><label class="col-form-label">{{__('customize.Name')}}</label><input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required></li>
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label">{{__('customize.content')}}</label><input type="text" name="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" required></li>
                                <li><label class="col-form-label">{{__('customize.Deadline')}}</label><input type="date" name="deadline" class="form-control{{ $errors->has('deadline') ? ' is-invalid' : '' }}" placeholder="2018-11-22" required></li>
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
    </div>

@stop