@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{__('customize.Add')}}{{__('customize.Finance')}}</h4>
                </div>
                <div class="card-body">
                    <form action="create/review" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <li><label class="col-form-label">{{__('customize.Finance')}}{{__('customize.Name')}}</label><input type="text" name="name" class="form-control" required autofocus></li>
                            </div>
                            <div class="col-md-6">
                                <li><label class="col-form-label">{{__('customize.Project')}}</label><select type="text" name="project_id" class="form-control">
                                    @foreach ($data as $project)
                                        <option value="{{$project['project_id']}}">{{$project['name']}}</option>
                                    @endforeach
                                </select></li>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary">{{__('customize.Add')}}{{__('customize.Property')}}</button>
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
    
@stop