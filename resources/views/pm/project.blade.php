@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h1>{{$data->name}}</h1>
                </div>
                <div class="card-body">
                    <h5><b>{{__('customize.Information')}}</b></h5>
                    <div class="row">
                        @foreach($data->toArray() as $key => $value)
                            @if (strpos($key, '_at')&&\Auth::user()->role!="manager")
                                @continue
                            @elseif (!is_Array($value))
                                {{-- if add operater ($value!=null), would disable the value which haven't writed. --}}
                                <div class="col-sm-6 row">
                                    <div class="col-md-7">
                                        <li><label class="col-form-label">{{__('customize.'.$key)}} : </label></li>
                                    </div>
                                    <div class="col-md-5">
                                        @if ($key == 'user_id')
                                            <label class="col-form-label">{{$data->user->name}}</label>
                                        @elseif ($key == 'color')
                                            <label class="col-form-label"><div style="backgroundColor:{{$value}};">{{$value==null? '未填寫': $value}}</div></label>
                                        @else
                                            <label class="col-form-label">{{$value==null? '未填寫': $value}}</label>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                            @endif
                        @endforeach
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><b>{{__('customize.Invoice')}}</b></h5>
                            @if (count($data->invoice))
                                @foreach ($data->invoice as $key => $invoice)
                                    <label>{{$key+1}} | <a href="{{route('invoice.review', $invoice->invoice_id)}}">{{$invoice->company}}</a> - {{$invoice->created_at->format('Y/m/d')}}</label><br>
                                @endforeach
                            @else
                                <label>{{__('customize.None')}}</label>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5><b>{{__('customize.Todo')}}</b></h5>
                            @if (count($data->todo))
                                @foreach ($data->todo as $key => $todo)
                                    <label>{{$key+1}} | <a href="{{route('todo.review', $todo->todo_id)}}">{{$todo->name}}</a></label><br>
                                @endforeach
                            @else
                                <label>{{__('customize.None')}}</label>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div style="float:left;">
                        <button class="btn btn-primary" onclick="location.href='{{route('project.edit', $data->project_id)}}'">{{__('customize.Edit')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop