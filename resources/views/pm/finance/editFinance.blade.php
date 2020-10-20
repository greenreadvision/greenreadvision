@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{__('customize.Edit')}}{{__('customize.Finance')}}</h4>
                </div>
                <div class="card-body">
                    <form action="update" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <ul>
                                    @foreach($data['finance'] as $key => $value)
                                        @if ($key == 'test')
                                            @dump($value)
                                        @else
                                            <li><label class="col-form-label">{{__('customize.'.$key)}}</label><input type="text" name="{{__($key)}}" value="{{$value}}" class="form-control"></li>
                                        @endif
                                    @endforeach
                                    <li><label class="col-form-label">{{__('customize.Project')}}</label><select type="text" name="project_id" class="form-control">
                                        @foreach ($data['projects'] as $project)
                                            <option value="{{$project['project_id']}}" {{$project['selected']}}>{{$project['name']}}</option>
                                        @endforeach
                                    </select></li>
                                </ul>
                            </div>
                        </div>
                        <div style="float: right;">
                            <button type="submit" class="btn btn-primary">{{__('customize.Save')}}</button>
                        </div>
                    </form>

                    <form action="delete" method="POST">
                        @method('DELETE')
                        @csrf
                        <div style="float: left;">
                            <button type="submit" class="btn btn-primary">{{__('customize.Delete')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@stop