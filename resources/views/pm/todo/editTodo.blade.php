@extends('layouts.app')

@section('content')
<!-- <div class="d-flex align-items-center mb-3">
    <h2>{{__('customize.Edit')}}{{__('customize.Todo')}}</h2>
</div> -->
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <form action="update" method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label">{{__('customize.Project')}}</label>
                    <select type="text" name="project_id" class="form-control">
                        @foreach ($data['projects'] as $project)
                        <option value="{{$project['project_id']}}" {{$project['selected']}}>{{$project['name']}}</option>
                        @endforeach
                    </select>
                </div>
                @foreach($data['todo'] as $key => $value)
                @if (($key=='matched'||$key=='managed')||((strpos($key, '_id')||strpos($key, '_at'))&&\Auth::user()->role!='engineer'))
                @continue
                @endif
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label">{{__('customize.'.$key)}}</label>
                    <!-- <li><label class="col-form-label" for="{{$key}}">{{__('customize.'.$key)}}</label></li> -->
                    @if ($key == 'test')
                    @dump($value)
                    @elseif (strpos($key, "_id") || strpos($key, "_at"))
                    <span>{{$value}}</span>
                    @elseif (strpos($key, "_date"))
                    <input type="date" name="{{$key}}" value="{{$value}}" class="form-control" placeholder="2019-01-06">
                    @elseif (strpos($key, "eadline"))
                    <input type="date" name="{{$key}}" value="{{$value}}" class="form-control" placeholder="2019-01-06">
                    @elseif (strpos($key, "inished"))
                    <input type="hidden" name="{{$key}}" value="0">
                    <input type="checkbox" id="{{$key}}" name="{{$key}}" value="1" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" {{$value? 'checked':''}}>
                    @else
                    <input type="text" name="{{$key}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" value="{{$value}}">
                    @endif
                    @if ($errors->has($key))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first($key) }}</strong>
                    </span>
                    @endif
                </div>
                @endforeach
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
                @if(strpos(URL::full(),'other'))
                <form action="../delete/other" method="POST">
                    @else
                    <form action="delete" method="POST">
                        @endif
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-primary">是</button>
                    </form>
            </div>
        </div>
    </div>
</div>
<!-- <div class="row justify-content-center">
    <div class="col-md-12 col-lg-10 col-xl-8">
        <div class="card" style="margin: 10px 0px;">
            <div class="card-header">
                <h4>{{__('customize.Edit')}}{{__('customize.Todo')}}</h4>
            </div>
            <div class="card-body">
                <form action="update" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <li><label class="col-form-label">{{__('customize.Project')}}</label><select type="text" name="project_id" class="form-control">
                                    @foreach ($data['projects'] as $project)
                                    <option value="{{$project['project_id']}}" {{$project['selected']}}>{{$project['name']}}</option>
                                    @endforeach
                                </select></li>
                        </div>
                        @foreach($data['todo'] as $key => $value)
                        @if (($key=='matched'||$key=='managed')||((strpos($key, '_id')||strpos($key, '_at'))&&\Auth::user()->role!='engineer'))
                        @continue
                        @endif
                        <div class="col-md-6">
                            <li><label class="col-form-label" for="{{$key}}">{{__('customize.'.$key)}}</label></li>
                            @if ($key == 'test')
                            @dump($value)
                            @elseif (strpos($key, "_id") || strpos($key, "_at"))
                            <span>{{$value}}</span>
                            @elseif (strpos($key, "_date"))
                            <input type="date" name="{{$key}}" value="{{$value}}" class="form-control" placeholder="2019-01-06">
                            @elseif (strpos($key, "eadline"))
                            <input type="date" name="{{$key}}" value="{{$value}}" class="form-control" placeholder="2019-01-06">
                            @elseif (strpos($key, "inished"))
                            <input type="hidden" name="{{$key}}" value="0">
                            <input type="checkbox" id="{{$key}}" name="{{$key}}" value="1" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" {{$value? 'checked':''}}>
                            @else
                            <input type="text" name="{{$key}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" value="{{$value}}">
                            @endif
                            @if ($errors->has($key))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first($key) }}</strong>
                            </span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <hr>
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
</div> -->

@stop