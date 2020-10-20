@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-8 mb-3 d-flex">
            <h2>
                <span style="background:{{$data->color}}">&nbsp;</span>&nbsp;({{__('customize.'.$data->company_name)}})&nbsp;{{$data->name}}
            </h2>
            @if($data->finished==1)
            <div class="d-flex align-items-center ml-3">
                <span style="color:red">帳務已關閉</span>
            </div>
            @endif
        </div>
        <div class="col-lg-4 mb-3">
            @if(\Auth::user()->user_id==$data['user_id'])
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('project.edit', $data->project_id)}}'"><i class='fas fa-edit'></i><span class="ml-3"> {{__('customize.Edit')}}</span></button>
            @endif
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class=" col-lg-6">
                    <div class="card card-style">
                        <div class="px-3">
                            <div class="card-header bg-white">
                                <i class='fas fa-user-circle' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label ">{{__('customize.User')}}</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center"><label class="content-label-style col-form-label">{{$data->user->nickname}}</label></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-style">
                        <div class="px-3">
                            <div class="card-header bg-white">
                                <i class='fas fa-check-circle' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label">{{__('customize.case_num')}}</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <label class="content-label-style col-form-label">{{$data->case_num==null? '-未填寫-': $data->case_num}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class=" col-lg-6">
                    <div class="card card-style">
                        <div class="px-3">
                            <div class="card-header bg-white">
                                <i class='fas fa-calendar-alt' style="font-size:1.5rem;"></i>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <div>
                                <div class="time-line ">
                                    <i class="time-i" style="background-color:#0acf97;"><i style="background-color:#96fde0;"></i></i>
                                    <div class="ml-4">
                                        <div class="ml-1">
                                            <span style="background-color:#0acf97;">截標日期</span>
                                            <p class="text-center">{{$data->deadline_date}}&nbsp;{{str_split($data->deadline_time,5)[0]}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="time-line">
                                    <i class="time-i" style="background-color:#39afd1;"><i style="background-color:#9ae8ff;"></i></i>
                                    <div class="ml-4">
                                        <div class="ml-1">
                                            <span style="background-color:#39afd1;">開標日期</span>
                                            <p class="text-center">{{$data->open_date}}&nbsp;{{str_split($data->open_time,5)[0]}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="time-line">
                                    <i class="time-i" style="background-color:#ffbc00;"><i style="background-color:#fbdd87;"></i></i>
                                    <div class="ml-4">
                                        <div class="ml-1">
                                            <span style="background-color:#ffbc00;">履約日期</span>
                                            <p class="text-center">{{$data->beginning_date==null? '-未填寫-': $data->beginning_date}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="time-line">
                                    <i class="time-i" style="background-color:#fa5c7c;"><i style="background-color:#ff99ad;"></i></i>
                                    <div class="ml-4">
                                        <div class="ml-1">
                                            <span style="background-color:#fa5c7c;">結案日期</span>
                                            <p class="text-center">{{$data->closing_date}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-6">
                    <div class="card card-style">
                        <div class="px-3">
                            <div class="card-header bg-white">
                                <i class='fas fa-dollar-sign' style="font-size:1.5rem;"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($data->toArray() as $key => $value)
                            @if (strpos($key, '_at'))
                            @continue
                            @elseif (!is_Array($value))
                            @if($key=='bid_bound'||$key=='default_fine'||$key=='total_amount')
                            <div>
                                <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                                <div class="d-flex justify-content-center"><label class="content-label-style col-form-label">{{$value==null? '-未填寫-': number_format($value)}}</label></div>
                            </div>
                            @endif
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-style">
                        <div class="card-body">
                            <h5><b>{{__('customize.Invoice')}}</b></h5>
                            @if (count($data->invoices))
                            @foreach ($data->invoices as $key => $invoice)
                            <!-- <label>{{$key+1}} | <a href="{{route('invoice.review', $invoice->invoice_id)}}">{{$invoice->user['nickname']}}-{{$invoice['company']}}-{{$invoice->content}}</a></label><br> -->
                            <label>{{$key+1}} | <a href="{{route('invoice.review', $invoice->invoice_id)}}">{{$invoice->company}}</a> - {{$invoice->created_at->format('Y/m/d')}}</label><br>
                            @endforeach
                            @else
                            <label>{{__('customize.None')}}</label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-style">
                        <div class="card-body">
                            <h5><b>{{__('customize.Todo')}}</b></h5>
                            @if (count($data->todos))
                            @foreach ($data->todos as $key => $todo)
                            <label>{{$key+1}} | <a href="{{route('todo.review', $todo->todo_id)}}">{{$todo['deadline']}} {{$todo['name']}}</a></label><br>
                            @endforeach
                            @else
                            <label>{{__('customize.None')}}</label>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">

            <div class="card card-style">
                <div class="px-3">
                    <div class="card-header bg-white">
                        <i class='fas fa-poll ' style="font-size:1.5rem;"></i>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($data->toArray() as $key => $value)
                    @if (strpos($key, '_at'))
                    @continue
                    @elseif (!is_Array($value))
                    {{-- if add operater ($value!=null), would disable the value which haven't writed. --}}
                    @if($key=='estimated_cost'||$key=='estimated_profit'||$key=='actual_cost'||$key=='actual_profit'||$key=='effective_interest_rate')
                    @if(\Auth::user()->user_id==$data['user_id']||\Auth::user()->role=='manager')
                    @if($key=='effective_interest_rate')
                    <div>
                        <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}(填數字)</label></div>
                        <div class="d-flex justify-content-center"><label class="content-label-style col-form-label">{{$value==null? '-未填寫-': $value.'%'}}</label></div>
                    </div>
                    @else
                    <div>
                        <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                        <div class="d-flex justify-content-center"><label class="content-label-style col-form-label">{{$value==null? '-未填寫-': number_format($value)}}</label></div>
                    </div>
                    @endif
                    @else
                    <div>
                        <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                        <div class="d-flex justify-content-center"><label class="content-label-style col-form-label"><i class='fas fa-lock'></i></label></div>
                    </div>
                    @endif
                    @endif
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


@stop