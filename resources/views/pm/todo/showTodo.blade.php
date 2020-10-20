@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3">
           <h2>{{$data->project->name}}</h2>
        </div>
        <div class="col-lg-6 mb-3">
            @if(\Auth::user()->user_id==$data['user_id'])
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('todo.edit', $data['todo_id'])}}'"><i class='fas fa-edit'></i><span class="ml-3"> {{__('customize.Edit')}}</span></button>
            @endif
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card" style="margin: 10px 0px;">
            <div class="card-header">
                <h4>{{__($data['name'])}}</h4>
            </div>
            <div class="card-body">
                <form action="edit" method="get">
                    <div class="col-lg-12 row">
                        <div class="col-lg-3">
                            <label class="label-style col-form-label">{{__('customize.deadline')}} : </label>
                        </div>
                        <div class="col-lg-9">
                            <label class="label-style col-form-label">{{$data->deadline}}</label>
                        </div>
                    </div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-3">
                            <label class="label-style col-form-label">{{__('customize.content')}} : </label>
                        </div>
                        <div class="col-lg-9">
                            <label class="label-style col-form-label">{{$data->content}}</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@stop