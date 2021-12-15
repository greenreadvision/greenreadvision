@extends('layouts.app') 
@section('content')
    <div class="row justify-content-center">
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
                                <div class="col">
                                    <span>{{$todo->user['nickname']}}</span>
                                    <a href="{{route('todo.review', $todo->todo_id)}}">{{$todo->name}}</a>
                                </div>
                                <div class="col-auto"> @if (boolval($todo['finished']))
                                    <span class="badge badge-success mr-2">@lang('customize.finished')</span> @endif
                                    <span>{{$todo->updated_at->format('Y-m-d')}}</span>
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
    </div>

@stop