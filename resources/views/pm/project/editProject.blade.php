@extends('layouts.app')
@section('content')
<form action="update" method="POST">
    @csrf
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-1 mb-3">
                <input type="color" id="color" name="color" value="{{$data['project']->color}}" class="form-control" style="height:37px;" required>
            </div>
            <div class="col-lg-2 mb-3">
                <select type="text" id="company_name" name="company_name" class="form-control" autofocus>
                    @foreach ($data['company_name'] as $key)
                    @if($data['project']->company_name==$key)
                    <option value="{{$key}}" selected>{{__('customize.'.$key)}}</option>
                    @else
                    <option value="{{$key}}">{{__('customize.'.$key)}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 mb-3">
                <input autocomplete="off" type="text" name="name" value="{{$data['project']->name}}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="尚未填寫">
                @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>專案名稱已重複</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-3 mb-3 d-flex align-items-center">
                <input type="hidden" name="finished" value="0">
                <input type="checkbox" id="finished" name="finished" value="1" {{$data['project']->finished? 'checked':''}}>
                <label class="label-style col-form-label ml-2" for="finished">關閉標案</label>
            </div>
            @if($data['project']->receiver == "")
            <div class="col-lg-3 mb-3">
                <div style="float: right;">
                    <button type="button" class="btn btn-primary btn-primary-style" data-toggle="modal" data-target="#transfer">轉讓標案</button>
                </div>
            </div>
            @else
            <div class="col-lg-3 mb-3">
                <div style="float: right;">
                    <button type="button" class="btn btn-danger btn-danger-style">轉讓中</button>
                </div>
            </div>
            @endif
            
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
                                <div class="d-flex justify-content-center"><label class="content-label-style col-form-label">{{$data['project']->user->name}}</label></div>
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
                                    <label class="content-label-style col-form-label">
                                        <input autocomplete="off" type="text" id="case_num" name="case_num" value="{{$errors->has('case_num')? old('case_num'): $data['project']->case_num}}" class="form-control{{ $errors->has('case_num') ? ' is-invalid' : '' }}" placeholder="尚未填寫">
                                    </label>
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
                                                <input type="date" id="deadline_date" name="deadline_date" value="{{$data['project']->deadline_date}}" class="my-1 form-control" placeholder="">
                                                <input type="time" id="deadline_time" name="deadline_time" value="{{$data['project']->deadline_time}}" class="my-1 form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="time-line">
                                        <i class="time-i" style="background-color:#39afd1;"><i style="background-color:#9ae8ff;"></i></i>
                                        <div class="ml-4">
                                            <div class="ml-1">
                                                <span style="background-color:#39afd1;">開標日期</span>
                                                <input type="date" id="open_date" name="open_date" value="{{$data['project']->open_date}}" class="my-1 form-control" placeholder="">
                                                <input type="time" id="open_time" name="open_time" value="{{$data['project']->open_time}}" class="my-1 form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="time-line">
                                        <i class="time-i" style="background-color:#ffbc00;"><i style="background-color:#fbdd87;"></i></i>
                                        <div class="ml-4">
                                            <div class="ml-1">
                                                <span style="background-color:#ffbc00;">履約日期</span>
                                                <input type="date" id="beginning_date" name="beginning_date" value="{{$data['project']->beginning_date}}" class="my-1 form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="time-line">
                                        <i class="time-i" style="background-color:#fa5c7c;"><i style="background-color:#ff99ad;"></i></i>
                                        <div class="ml-4">
                                            <div class="ml-1">
                                                <span style="background-color:#fa5c7c;">結案日期</span>
                                                <input type="date" id="closing_date" name="closing_date" value="{{$data['project']->closing_date}}" class="my-1 form-control" placeholder="">

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
                                @foreach($data['project']->toArray() as $key => $value)
                                @if (strpos($key, '_at'))
                                @continue
                                @elseif (!is_Array($value))
                                @if($key=='bid_bound'||$key=='default_fine'||$key=='total_amount')
                                <div>
                                    <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                                    <div class="d-flex justify-content-center">
                                        <label class="content-label-style col-form-label">
                                            <input autocomplete="off" type="text" id="{{$key}}" name="{{$key}}" value="{{$errors->has($key)? old($key): $value}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" placeholder="尚未填寫">
                                        </label>
                                    </div>
                                </div>
                                @endif
                                @endif
                                @endforeach
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
                        @foreach($data['project']->toArray() as $key => $value)
                        @if (strpos($key, '_at'))
                        @continue
                        @elseif (!is_Array($value))
                        {{-- if add operater ($value!=null), would disable the value which haven't writed. --}}
                        @if($key=='estimated_cost'||$key=='estimated_profit'||$key=='actual_cost'||$key=='actual_profit'||$key=='effective_interest_rate')
                        @if(\Auth::user()->user_id==$data['project']['user_id']||\Auth::user()->role=='manager')

                        @if($key=='effective_interest_rate')
                        <div>
                            <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}(填數字)</label></div>
                            <div class="d-flex justify-content-center">
                                <label class="content-label-style col-form-label">
                                    <input autocomplete="off" type="text" id="{{$key}}" name="{{$key}}" value="{{$errors->has($key)? old($key): $value}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" placeholder="尚未填寫">
                                </label>
                                @if ($errors->has('effective_interest_rate'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>專案名稱已重複</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @else
                        <div>
                            <div><label class="ml-2 col-form-label font-weight-bold">{{__('customize.'.$key)}}</label></div>
                            <div class="d-flex justify-content-center">
                                <label class="content-label-style col-form-label">
                                    <input autocomplete="off" type="text" id="{{$key}}" name="{{$key}}" value="{{$errors->has($key)? old($key): $value}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" placeholder="尚未填寫">
                                </label>
                            </div>
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
    <div class="col-lg-12">
        <div style="float: right;">
            @method('PUT')
            @csrf
            <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
        </div>



        @if($data['project']->invoices=='[]'&&$data['project']->todos=='[]')
        <div style="float: left;">
            <button type="button" class="btn btn-danger btn-danger-style" data-toggle="modal" data-target="#deleteModal">
                <i class='fas fa-trash-alt'></i><span class="ml-3">{{__('customize.Delete')}}</span>
            </button>
        </div>
        @endif
    </div>
</form>

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
                <form action="delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">是</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="transfer" tabindex="-1" role="dialog" aria-labelledby="transfer" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                <form action="transfer" method="POST" class="mb-3">
                    @method('PUT')
                    @csrf
                    
                    <select name="user" class="form-control">
                        <option value=""></option>
                        @foreach($data['users'] as $user)
                        @if($user->user_id != \Auth::user()->user_id && $user->status != "resignation" && $user->role != "manager")
                        <option value="{{$user['user_id']}}">{{$user->nickname}}</option>

                        @endif
                        @endforeach
                    </select>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">確認</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop