@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3 ">
            <!-- <h2>{{__('customize.Todo')}}</h2> -->
        </div>
        <div class="col-lg-6 mb-3">
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('todo.create')}}'"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span> </button>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card card-style">
            <div class="card-body ">
                <div class="col-lg-12">
                @foreach ($todo_groups as $key => $todos)
                <span style="background-color:{{$todos[0]->project->color}}; border-radius: 100rem; width: 15px; height: 15px; display: inline-block; margin-right: .5rem; box-shadow:0 0 10px {{$todos[0]->project->color}};"></span>
                <a href="{{route('project.review', $todos[0]->project_id)}}/" style="color:black; font-size:1.1rem;">{{$todos[0]->project['name']}}</a>
                <ol>
                    @foreach ($todos as $todo)
                    <li class="mb-1">
                        <div class="row justify-content-center">
                            <div class="col text-center">
                                <span>{{$todo->user['nickname']}}</span>
                            </div>
                            <div class="col text-center">
                                <a href="{{route('todo.review', $todo->todo_id)}}">{{$todo->name}}</a>
                            </div>
                            <div class="col text-center">
                                <span class="mr-2 text-secondary">{{$todo->deadline}}</span>
                                @if (boolval($todo['finished']))
                                <span class="badge badge-success mr-2">@lang('customize.finished')</span>
                                @else
                                <span class="badge badge-danger mr-2">@lang('customize.notFinished')</span>
                                @endif

                            </div>
                        </div>
                    </li>
                    @endforeach
                </ol>
                @if ($key + 1
                < count($todo_groups)) <hr>
                    @endif @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="row justify-content-center">
    <div class="col-md-12 col-lg-10 col-xl-8">
        <div class="card" style="margin: 10px 0px;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>{{__('customize.Todo')}}</h1>
                <button class="btn btn-primary" onclick="location.href='{{route('todo.create')}}'">{{__('customize.Add')}}</button>
            </div>
            <div class="card-body">
                @foreach ($todo_groups as $key => $todos)
                <span style="background-color:{{$todos[0]->project->color}}; border-radius: 100rem; width: 15px; height: 15px; display: inline-block; margin-right: .5rem; box-shadow:0 0 10px {{$todos[0]->project->color}};"></span>
                <a href="{{route('project.review', $todos[0]->project_id)}}/" style="color:black; font-size:1.1rem;">{{$todos[0]->project['name']}}</a>
                <ol>
                    @foreach ($todos as $todo)
                    <li class="mb-1">
                        <div class="row justify-content-center">
                            <div class="col text-center">
                                <span>{{$todo->user['nickname']}}</span>
                            </div>
                            <div class="col text-center">
                                <a href="{{route('todo.review', $todo->todo_id)}}">{{$todo->name}}</a>
                            </div>
                            <div class="col text-center">
                                <span class="mr-2 text-secondary">{{$todo->deadline}}</span>
                                @if (boolval($todo['finished']))
                                <span class="badge badge-success mr-2">@lang('customize.finished')</span>
                                @else
                                <span class="badge badge-danger mr-2">@lang('customize.notFinished')</span>
                                @endif

                            </div>
                        </div>
                    </li>
                    @endforeach
                </ol>
                @if ($key + 1
                < count($todo_groups)) <hr>
                    @endif @endforeach
            </div>
        </div>
    </div>
    {{--
        <div class="col-md-12 col-lg-10 col-xl-8">
            <hr>
        </div> --}}
</div> -->

@stop