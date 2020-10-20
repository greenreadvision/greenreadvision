@extends('layouts.app')
@section('content')
@foreach($leaveDayApplies as $leaveDayApplie)
<div class="modal fade" id="{{$leaveDayApplie['leave_day_apply_id']}}apply" tabindex="-1" role="dialog" aria-labelledby="{{$leaveDayApplie['leave_day_apply_id']}}apply" aria-hidden="true">
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
                <form action="../../leaveDayApply/{{$leaveDayApplie['leave_day_apply_id']}}/delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">是</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ac{{$leaveDayApplie['leave_day_apply_id']}}apply" tabindex="-1" role="dialog" aria-labelledby="ac{{$leaveDayApplie['leave_day_apply_id']}}apply" aria-hidden="true">
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
                <form action="../../leaveDayApply/{{$leaveDayApplie['leave_day_apply_id']}}/delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">是</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach($leaveDayBreaks as $leaveDayBreak)
<div class="modal fade" id="{{$leaveDayBreak['leave_day_break_id']}}break" tabindex="-1" role="dialog" aria-labelledby="{{$leaveDayBreak['leave_day_break_id']}}break" aria-hidden="true">
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
                <form action="../../leaveDayBreak/{{$leaveDayBreak['leave_day_break_id']}}/delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">是</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ac{{$leaveDayBreak['leave_day_break_id']}}break" tabindex="-1" role="dialog" aria-labelledby="ac{{$leaveDayBreak['leave_day_break_id']}}break" aria-hidden="true">
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
                <form action="../../leaveDayBreak/{{$leaveDayBreak['leave_day_break_id']}}/delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">是</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="col-lg-12 ">
    <!-- 名單選擇 -->
    @if(Auth::user()->role == 'accountant'||Auth::user()->role == 'manager')
    <form id="leaveDayForm" name="leaveDayForm" method="get" class="mb-3">
        @csrf
        <select id="selectLeaveDay" class="form-control" onchange="changeLeaveDayForm()">
            <option value=""></option>
            @foreach($leaveDays as $leaveDay)
            @if($leaveDay->user->role != 'manager' && $leaveDay->user->status != 'resignation' && $leaveDay->user->name != "test")
            <option value="{{$leaveDay['leave_day_id']}}">{{$leaveDay->user['nickname']}}</option>

            @endif
            @endforeach
        </select>
    </form>

    <!-- @foreach($leaveDays as $leaveDay)
    <form action="/leaveDay/{{$leaveDay['leave_day_id']}}" method="get">
        @csrf
        <button style="margin:5px 5px" class="btn btn-primary btn-primary-style" onclick="">{{$leaveDay->user['nickname']}}</button>
    </form>
    @endforeach -->
    @endif
</div>
<div class="col-lg-12">
    <!-- 會計主管 -->
   
    @if(Auth::user()->role == 'accountant'||Auth::user()->role == 'manager')
    
    @foreach($leaveDays as $leaveDay)
    
    @if($leaveDay['leave_day_id']==$leaveDayId)
    
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-style">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>{{$leaveDay->user['nickname']}} 休假紀錄</h2>
                </div>
                <div class="card-body text-center">
                    <?php
                    include app_path() . '/Functions/Test.php';
                    $Test = new Test();
                    echo $Test->show($year, $leaveDayId);
                    ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>月份</th>
                                <th>年度休假日數</th>
                                <th>請假日期(半日)</th>
                                <th>請假日期(1日)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($months as $data )
                            <tr>
                                <th>{{$data}}</th>
                                <th>{{$hasdays[$data]}}</th>
                                <th>{{$halfdays[$data]}}</th>
                                <th>{{$days[$data]}}</th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col">
                            {{__('customize.should_break')}}
                        </div>
                        <div class="col">
                            {{$leaveDay['should_break']}}
                        </div>
                        <div class="col">
                            {{__('customize.has_break')}}
                        </div>
                        <div class="col">
                            {{$leaveDay['has_break']}}
                        </div>
                        <div class="col">
                            {{__('customize.not_break')}}
                        </div>
                        <div class="col">
                            {{$leaveDay['not_break']}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="d-flex">
                <form action="/leaveDayApply/{{$leaveDay['leave_day_id']}}/add" method="get">
                    @csrf
                    <button class="btn btn-primary btn-primary-style mb-3 mr-3" onclick="">新增特休</button>
                </form>
                <form action="/leaveDayBreak/{{$leaveDay['leave_day_id']}}/add" method="get">
                    @csrf
                    <button class="btn btn-primary btn-primary-style mb-3" onclick="">新增休假</button>
                </form>
            </div>
            <div class="card card-style">
                
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>{{$leaveDay->user['nickname']}} 應休申請</h2>
                    <form action="/leaveDayApply/{{$leaveDay['leave_day_id']}}/create" method="get">
                        @csrf
                        <button class="btn btn-primary btn-primary-style" onclick=""><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span> </button>
                    </form>
                </div>
                <div class="card-body text-center">
                    @foreach($applyYears as $year)
                    <div class="col-lg-12 collapse-style py-1 " data-toggle="collapse" data-target="#acapplymultiCollapse{{$year}}" aria-expanded="false" aria-controls="acapplymultiCollapse{{$year}}">{{$year}}年</div>
                    <div class="collapse multi-collapse" id="acapplymultiCollapse{{$year}}">
                        @foreach($applyMonths as $month)
                        @if(substr($month,0,4) == $year)
                        <div class="text-left col-lg-12 collapse-style py-1 pl-5" data-toggle="collapse" data-target="#acapplymultiCollapse{{$month}}" aria-expanded="false" aria-controls="acapplymultiCollapse{{$month}}">{{substr($month,5,2)}}月</div>
                        <div class="collapse multi-collapse" id="acapplymultiCollapse{{$month}}">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>授課/活動日期</th>
                                        <th>事由</th>
                                        <th>應休日數</th>
                                        <th></th>
                                        <th>@lang('customize.status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaveDayApplies as $leaveDayApplie)
                                    @if(substr($month,0,7)==substr($leaveDayApplie->apply_date,0,7))
                                    @if($leaveDay['leave_day_id']==$leaveDayApplie['leave_day_id']&&$leaveDayApplie['content']!='休假輸入')
                                    <tr>
                                        <th>{{$leaveDayApplie['apply_date']}}</th>
                                        <th>{{$leaveDayApplie['content']}}</th>
                                        <th>{{$leaveDayApplie['should_break']}}</th>
                                        <th>
                                            @if($leaveDayApplie['status']=='waiting' &&Auth::user()->role == 'accountant')
                                            <form action="../../leaveDayApply/{{$leaveDayApplie['leave_day_apply_id']}}/match" method="POST">
                                                @csrf
                                                <button style="margin:5px" type="submit" class="btn btn-primary btn-sm">{{__('customize.Permit')}}</button>
                                            </form>
                                            @endif

                                            <!-- <form action="../../leaveDayApply/{{$leaveDayApplie['leave_day_apply_id']}}/delete" method="POST">
                                        @method("DELETE")
                                        @csrf
                                        <button style="margin:5px" class="btn btn-outline-danger btn-sm">@lang('customize.Delete')</button>
                                    </form> -->

                                            <button type="button" style="margin:5px" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#ac{{$leaveDayApplie['leave_day_apply_id']}}apply">
                                                <span>{{__('customize.Delete')}}</span>
                                            </button>

                                        </th>
                                        <th><span class="badge badge-{{$leaveDayApplie->status=='waiting' ? 'danger' : 'success'}}">{{__('customize.'.$leaveDayApplie['status'].'')}}</span></th>
                                    </tr>
                                    @endif
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card card-style" style="margin:10px 0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>{{$leaveDay->user['nickname']}} 休假申請</h2>
                    @if($leaveDay['user_id'] == \Auth::user()->user_id)
                    <form action="/leaveDayBreak/{{$leaveDay['leave_day_id']}}/create" method="get">
                        @csrf
                        <button class="btn btn-primary btn-primary-style" onclick=""><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span></button>
                    </form>
                    @endif
                </div>
                <div class="card-body text-center">
                    @foreach($breakYears as $year)
                    <div class="col-lg-12 collapse-style py-1 " data-toggle="collapse" data-target="#acbreakmultiCollapse{{$year}}" aria-expanded="false" aria-controls="acbreakmultiCollapse{{$year}}">{{$year}}年</div>
                    <div class="collapse multi-collapse" id="acbreakmultiCollapse{{$year}}">
                        @foreach($breakMonths as $month)
                        @if(substr($month,0,4) == $year)
                        <div class="text-left col-lg-12 collapse-style py-1 pl-5" data-toggle="collapse" data-target="#acbreakmultiCollapse{{$month}}" aria-expanded="false" aria-controls="acbreakmultiCollapse{{$month}}">{{substr($month,5,2)}}月</div>
                        <div class="collapse multi-collapse" id="acbreakmultiCollapse{{$month}}">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>請假日期</th>
                                        <th>天數</th>
                                        <th></th>
                                        <th>@lang('customize.status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaveDayBreaks as $leaveDayBreak)
                                    @if(substr($month,0,7)==substr($leaveDayBreak->start_datetime,0,7))
                                    @if($leaveDay['leave_day_id']==$leaveDayBreak['leave_day_id']&&$leaveDayBreak['type']!='休假輸入')
                                    <tr>
                                        <th>{{$leaveDayBreak['apply_date']}}</th>
                                        <th>{{$leaveDayBreak['has_break']}}</th>
                                        <th>
                                            @if($leaveDayBreak['status']=='waiting' && ((Auth::user()->role == 'accountant'&&$leaveDayBreak['type']!='days')||(Auth::user()->role == 'manager'&&$leaveDayBreak['type']=='days')))
                                            <form action="../../leaveDayBreak/{{$leaveDayBreak->leave_day_break_id}}/match" method="POST">
                                                @csrf
                                                <button style="margin:5px" type="submit" class="btn btn-primary btn-sm">{{__('customize.Permit')}}</button>
                                            </form>
                                            @endif

                                            <!-- <form action="../../leaveDayBreak/{{$leaveDayBreak['leave_day_break_id']}}/delete" method="POST">
                                        @method("DELETE")
                                        @csrf
                                        <button style="margin:5px" class="btn btn-outline-danger btn-sm">@lang('customize.Delete')</button>
                                    </form> -->
                                            <button type="button" style="margin:5px" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#ac{{$leaveDayBreak['leave_day_break_id']}}break">
                                                <span>{{__('customize.Delete')}}</span>
                                            </button>
                                        </th>
                                        <th><span class="badge badge-{{$leaveDayBreak->status=='waiting' ? 'danger' : 'success'}}">{{__('customize.'.$leaveDayBreak['status'].'')}}</span></th>
                                    </tr>
                                    @endif
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
    <!-- <button class="btn btn-primary btn-primary-style mb-3 " data-toggle="modal" data-target="#exampleModal">新增</button>

            
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<form action="/leaveDayBreak/{{$leaveDay['leave_day_id']}}/add" method="post">
@csrf
<input autocomplete="off" type="text" id="has_break" name="has_break" class="form-control{{ $errors->has('has_break') ? ' is-invalid' : '' }}" value="{{ old('has_break') }}"required>
<button class="btn btn-primary btn-primary-style mb-3" onclick="">新增</button>
</div>
</div>
</div> -->

    @endif
    @endforeach
    <!-- 員工 -->
    @else
    <!-- 申請 -->
    @foreach($leaveDays as $leaveDay)
    @if($leaveDay['user_id'] == \Auth::user()->user_id)
    
    <div class="row">
        <!-- 休假紀錄 -->
        <div class="col-lg-6">
            <div class="card card-style">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>休假紀錄</h2>
                </div>
                <div class="card-body text-center">
                    <?php
                    include app_path() . '/Functions/Test.php';
                    $Test = new Test();
                    echo $Test->show($year, $leaveDay['leave_day_id']);
                    ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>月份</th>
                                <th>年度休假日數</th>
                                <th>休假日期(半日)</th>
                                <th>休假日期(1日)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($months as $data )
                            <tr>
                                <th>{{$data}}</th>
                                <th>{{$hasdays[$data]}}</th>
                                <th>{{$halfdays[$data]}}</th>
                                <th>{{$days[$data]}}</th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col">
                            {{__('customize.should_break')}}
                        </div>
                        <div class="col">
                            {{$leaveDay['should_break']}}
                        </div>
                        <div class="col">
                            {{__('customize.has_break')}}
                        </div>
                        <div class="col">
                            {{$leaveDay['has_break']}}
                        </div>
                        <div class="col">
                            {{__('customize.not_break')}}
                        </div>
                        <div class="col">
                            {{$leaveDay['not_break']}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-style">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>應休申請</h2>
                    <button class="btn btn-primary btn-primary-style" onclick="location.href='{{route('leaveDayApply.create')}}'"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span></button>
                </div>
                <div class="card-body text-center">
                    @foreach($applyYears as $year)
                    <div class="col-lg-12 collapse-style py-1 " data-toggle="collapse" data-target="#applymultiCollapse{{$year}}" aria-expanded="false" aria-controls="applymultiCollapse{{$year}}">{{$year}}年</div>
                    <div class="collapse multi-collapse" id="applymultiCollapse{{$year}}">
                        @foreach($applyMonths as $month)
                        @if(substr($month,0,4) == $year)
                        <div class="text-left col-lg-12 collapse-style py-1 pl-5" data-toggle="collapse" data-target="#applymultiCollapse{{$month}}" aria-expanded="false" aria-controls="applymultiCollapse{{$month}}">{{substr($month,5,2)}}月</div>
                        <div class="collapse multi-collapse" id="applymultiCollapse{{$month}}">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>授課/活動日期</th>
                                        <th>事由</th>
                                        <th>應休日數</th>
                                        <th></th>
                                        <th>@lang('customize.status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaveDayApplies as $leaveDayApplie)
                                    @if(substr($month,0,7)==substr($leaveDayApplie->apply_date,0,7))
                                    @if($leaveDay['leave_day_id']==$leaveDayApplie['leave_day_id']&& $leaveDayApplie['content']!='休假輸入')
                                    <tr>
                                        <th>{{$leaveDayApplie['apply_date']}}</th>
                                        <th>{{$leaveDayApplie['content']}}</th>
                                        <th>{{$leaveDayApplie['should_break']}}</th>
                                        <th>
                                            @if($leaveDayApplie['status']!='managed' )
                                            <!-- <form action="/leaveDayApply/{{$leaveDayApplie['leave_day_apply_id']}}/delete" method="POST">
                                        @method("DELETE")
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm">@lang('customize.Delete')</button>
                                    </form> -->
                                            <button type="button" style="margin:5px" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{$leaveDayApplie['leave_day_apply_id']}}apply">
                                                <span>{{__('customize.Delete')}}</span>
                                            </button>
                                            @endif
                                        </th>
                                        <th><span class="badge badge-{{$leaveDayApplie->status=='waiting' ? 'danger' : 'success'}}">{{__('customize.'.$leaveDayApplie['status'].'')}}</span></th>
                                    </tr>
                                    @endif
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card card-style">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>休假申請</h2>
                    <button class="btn btn-primary btn-primary-style" onclick="location.href='{{route('leaveDayBreak.create')}}'"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span></button>
                </div>
                <div class="card-body text-center">
                    @foreach($breakYears as $year)
                    <div class="col-lg-12 collapse-style py-1 " data-toggle="collapse" data-target="#multiCollapse{{$year}}" aria-expanded="false" aria-controls="multiCollapse{{$year}}">{{$year}}年</div>
                    <div class="collapse multi-collapse" id="multiCollapse{{$year}}">
                        @foreach($breakMonths as $month)
                        @if(substr($month,0,4) == $year)
                        <div class="text-left col-lg-12 collapse-style py-1 pl-5" data-toggle="collapse" data-target="#multiCollapse{{$month}}" aria-expanded="false" aria-controls="multiCollapse{{$month}}">{{substr($month,5,2)}}月</div>
                        <div class="collapse multi-collapse" id="multiCollapse{{$month}}">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>補假日期</th>
                                        <th>天數</th>
                                        <th></th>
                                        <th>@lang('customize.status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaveDayBreaks as $leaveDayBreak)
                                    @if(substr($month,0,7)==substr($leaveDayBreak->start_datetime,0,7))
                                    @if($leaveDay['leave_day_id']==$leaveDayBreak['leave_day_id']&& $leaveDayBreak['type']!='休假輸入')
                                    <tr>
                                        <th>{{$leaveDayBreak['apply_date']}}</th>
                                        <th>{{$leaveDayBreak['has_break']}}</th>
                                        <th>
                                            @if($leaveDayBreak['status']!='managed' || strtotime(substr($leaveDayBreak['start_datetime'],0,10))>=strtotime(date('Y-m-d')))
                                            <form action="/leaveDayBreak/{{$leaveDayBreak['leave_day_break_id']}}/delete" method="POST">
                                        @method("DELETE")
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm">@lang('customize.Delete')</button>
                                    </form>
                                            <!-- <button type="button" style="margin:5px" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{$leaveDayBreak['leave_day_break_id']}}break">
                                                <span>{{__('customize.Delete')}}</span>
                                            </button> -->
                                            @endif
                                        </th>
                                        <th><span class="badge badge-{{$leaveDayBreak->status=='waiting' ? 'danger' : 'success'}}">{{__('customize.'.$leaveDayBreak['status'].'')}}</span></th>
                                    </tr>
                                    @endif
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
    @endif
</div>

@stop
@section('javascript')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
<script>
    function changeLeaveDayForm(id) {
        var id = $("#selectLeaveDay").val();
        document.leaveDayForm.action = "/leaveDay/" + id;
        document.getElementById("leaveDayForm").submit()
    }
</script>
@stop