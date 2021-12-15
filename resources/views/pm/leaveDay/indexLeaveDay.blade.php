@extends('layouts.app')
@section('content')
@foreach($leave_day_breaks as $leaveDayBreak)

<div class="modal fade" id="break{{$leaveDayBreak['leave_day_break_id']}}" tabindex="-1" role="dialog" aria-labelledby="break{{$leaveDayBreak['leave_day_break_id']}}" aria-hidden="true">
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
                <button type="button" class="btn btn-red rounded-pill" data-dismiss="modal">否</button>
                <form action="../../../leaveDayBreak/{{$leaveDayBreak['leave_day_break_id']}}/{{$year}}/delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-blue rounded-pill">是</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if($leaveDayBreak['types'] == 'bereavement_leave')
<div class="modal fade" id="Prove{{$leaveDayBreak['leave_day_break_id']}}" tabindex="-1" role="dialog" aria-labelledby="Prove{{$leaveDayBreak['leave_day_break_id']}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
              @if($leaveDayBreak['prove'] != null)
              <img width="100%" src="{{route('download',  explode('/', $leaveDayBreak['prove']))}}" alt="">
              @endif
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

@foreach($leave_day_applies as $leaveDayApplie)
<div class="modal fade" id="apply{{$leaveDayApplie['leave_day_apply_id']}}" tabindex="-1" role="dialog" aria-labelledby="apply{{$leaveDayApplie['leave_day_apply_id']}}" aria-hidden="true">
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
                <button type="button" class="btn btn-red rounded-pill" data-dismiss="modal">否</button>
                <form action="../../../leaveDayApply/{{$leaveDayApplie['leave_day_apply_id']}}/{{$year}}/delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-blue rounded-pill">是</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="col-lg-12 ">
    <div class="row">
        <div class="col-lg-3 mb-3">
            <div class="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                <label class="btn btn-secondary w-50 {{$status == 'apply'?'active':''}}" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                    <input type="radio" name="options" onchange="changeLeave(0)" autocomplete="off"> 應休申請
                </label>
                <label class="btn btn-secondary w-50 {{$status == 'break'?'active':''}}" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                    <input type="radio" name="options" onchange="changeLeave(1)" autocomplete="off"> 請假申請
                </label>
            </div>

            <div class="card border-0 shadow rounded-pill">
                <div class="card-body ">
                    <div class="col-lg-12">
                        @if(Auth::user()->role == 'administrator'||Auth::user()->role == 'proprietor'|| Auth::user()->role == 'manager')
                        <form id="leaveDayForm" name="leaveDayForm" method="get" class="mb-3">
                            <select id="selectLeaveDay" class="form-control rounded-pill" onchange="changeLeaveDayForm()">
                                <option value=""></option>
                                @foreach($leaveDays as $leaveDay)
                                @if( $leaveDay->user->role != 'manager' && $leaveDay->user->status == 'general' && $leaveDay->user->user_id !='GRV00000')
                                <option value="{{$leaveDay['leave_day_id']}}">{{$leaveDay->user['name']}}({{$leaveDay->user['nickname']}})</option>
                                @endif
                                @endforeach
                            </select>
                        </form>
                        @endif

                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">年份</label>
                        <div class="col-lg-12 py-2 text-center">
                            <?php
                            include app_path() . '/Functions/Test.php';
                            $Test = new Test();
                            echo $Test->show($year, $leaveDayId, $status);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">月份</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-month" name="select-month" onchange="select()" class="rounded-pill form-control">
                                <option value=''></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button class="w-100 btn btn-green rounded-pill" onclick="reset()"><span>重置</span> </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <!-- <div class="row justify-content-center py-2 bg-darkBlue">
                休假
            </div> -->
            <div class="card border-0 shadow mb-3">
                <div class="row">
                    <div class="col-lg-4 py-2 text-center cursor-pointer" onclick="changeStatus()">
                        <small>應休</small>
                        <h4 class="status-d">
                            {{((double)$total_should_break)}}天
                        </h4>
                        <h4 class="status-h" hidden>
                            {{((double)$total_should_break)*8}}小時
                        </h4>
                    </div>
                    <div class="col-lg-4 py-2 text-center cursor-pointer" onclick="changeStatus()">
                        <small>已休</small>
                        <h4 class="status-d">
                            {{((double)$total_has_break['compensatory_leave_break'])}}天
                        </h4>
                        <h4 class="status-h" hidden>
                            {{((double)$total_has_break['compensatory_leave_break'])*8}}小時
                        </h4>
                    </div>

                    <div class="col-lg-4 py-2 text-center cursor-pointer" onclick="changeStatus()">
                        <small class="text-danger">未休</small>
                        <h4 class="status-d text-danger">
                            {{((double)$total_should_break)-((double)$total_has_break['compensatory_leave_break'])}}天
                        </h4>
                        <h4 class="status-h text-danger" hidden>
                            {{(((double)$total_should_break)-((double)$total_has_break['compensatory_leave_break']))*8}}小時
                        </h4>
                    </div>

                </div>
            </div>
            <div id="apply" class="card border-0 shadow " style="min-height: calc(100vh - 135px)" hidden>
                <div class="card-body">
                    <div class="col-lg-12 mb-2 d-flex justify-content-between">
                        <div>
                            <h4>{{$leave_day->user->nickname}} 應休申請</h4>
                        </div>
                        @if(\Auth::user()->leaveDay->leave_day_id == $leave_day->leave_day_id || \Auth::user()->role == 'administrator')
                        <button class="btn btn-green rounded-pill" onclick="location.href='{{route('leaveDayApply.create',$leave_day['leave_day_id'])}}'"></i><span class="mx-2">{{__('customize.Add')}}</span></button>
                        @endif
                    </div>
                    <div id="apply-page" class="col-lg-12 form-group d-flex align-items-end">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination mb-0">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-12">
                        <div class="table-style-invoice ">
                            <table id="search-leave-apply">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="break" class="card border-0 shadow " style="min-height: calc(100vh - 135px)" hidden>
                <div class="card-body">
                    <div class="col-lg-12 mb-2 d-flex justify-content-between">
                        <div>
                            <h4>{{$leave_day->user->nickname}} 請假申請</h4>
                        </div>
                        @if(\Auth::user()->leaveDay->leave_day_id == $leave_day->leave_day_id || \Auth::user()->role == 'administrator')
                        <button class="btn btn-green rounded-pill" onclick="location.href='{{route('leaveDayBreak.create',$leave_day['leave_day_id'])}}'"><span class="mx-2">{{__('customize.Add')}}</span></button>
                        @endif
                    </div>
                    <div id="break-page" class="col-lg-12 form-group d-flex align-items-end">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination mb-0">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-12">
                        <div class="table-style-invoice ">
                            <table id="search-leave-break">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
<script>
    var status = 'd'
    var year = '{{$year}}';
    var leaveDay = '{{$status}}'
    var month = ''
    var nowPage = 1
    var leaveApply = []
    var leaveBreak = []

    $(document).ready(function() {
        if (leaveDay == 'apply') {
            document.getElementById('apply').hidden = false
            document.getElementById('break').hidden = true
        } else {
            document.getElementById('apply').hidden = true
            document.getElementById('break').hidden = false
        }
        reset()
    })

    function changePage(index) {
        var temp = document.getElementsByClassName('page-item')
        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')
        listPage(leaveDay)
        if (leaveDay == 'apply') {
            listLeaveDayApply()
        } else {
            listLeaveDayBreak()
        }
    }

    function nextPage() {
        if (leaveDay == 'apply') {
            var number = Math.ceil(leaveApply.length / 10)
        } else {
            var number = Math.ceil(leaveBreak.length / 10)
        }

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage(leaveDay)
            if (leaveDay == 'apply') {
                listLeaveDayApply()
            } else {
                listLeaveDayBreak()
            }
        }

    }

    function previousPage() {
        if (leaveDay == 'apply') {
            var number = Math.ceil(leaveApply.length / 10)
        } else {
            var number = Math.ceil(leaveBreak.length / 10)
        }
        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage(leaveDay)
            if (leaveDay == 'apply') {
                listLeaveDayApply()
            } else {
                listLeaveDayBreak()
            }
        }

    }

    function listPage(leaveDay) {
        if (leaveDay == 'apply') {
            $("#apply-page").empty();
            var parent = document.getElementById('apply-page');
            var number = Math.ceil(leaveApply.length / 10)
        } else {
            $("#break-page").empty();
            var parent = document.getElementById('break-page');
            var number = Math.ceil(leaveBreak.length / 10)
        }
        var table = document.createElement("div");

        var data = ''
        if (nowPage < 4) {
            for (var i = 0; i < number; i++) {
                if (i < 5) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (nowPage >= 4 && nowPage - 3 <= 2) {
            for (var i = 0; i < number; i++) {
                if (i < nowPage + 2) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (nowPage >= 4 && nowPage - 3 > 2 && number - nowPage > 5) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= nowPage - 3 && i <= nowPage + 1) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'

                } else if (i > nowPage + 1) {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + number + ')">' + number + '</a></li>'
                    break
                }


            }
        } else if (number - nowPage <= 5 && number - nowPage >= 4) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= nowPage - 3) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        } else if (number - nowPage < 4) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= number - 5) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        }
        var previous = "previous"
        var next = "next"
        table.innerHTML = '<nav aria-label="Page navigation example">' +
            '<ul class="pagination mb-0">' +
            '<li class="page-item">' +
            '<a class="page-link" href="javascript:void(0)" onclick="previousPage()" aria-label="Previous">' +
            '<span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>' +
            '</a>' +
            '</li>' +
            data +
            '<li class="page-item">' +
            '<a class="page-link" href="javascript:void(0)" onclick="nextPage()" aria-label="Next">' +
            '<span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>' +
            '</a>' +
            '</li>' +
            '</ul>' +
            '</nav>'

        parent.appendChild(table);

        $(".page-" + String(nowPage)).addClass('active')
    }

    function reset() {
        setMonth()
        leaveApply = getApply()
        leaveBreak = getBreak()
        document.getElementById('select-month').value = ''
        select()
        nowPage = 1
        listPage(leaveDay)
        if(leaveDay == 'apply'){
            listLeaveDayApply()
        }
        else{
            listLeaveDayBreak()
        }
    }

    function select() {
        leaveApply = getApply()
        leaveBreak = getBreak()
        month = document.getElementById('select-month').value
        for (var i = 0; i < leaveApply.length; i++) {
            if (month != '') {
                if (leaveApply[i]['apply_date'].substr(5, 2) != month) {
                    leaveApply.splice(i, 1)
                    i--
                    continue
                }
            }
            if (leaveApply[i]['apply_date'].substr(0, 4) != year) {
                leaveApply.splice(i, 1)
                i--
                continue
            }
        }
        for (var i = 0; i < leaveBreak.length; i++) {

            if (month != '') {
                if (leaveBreak[i]['apply_date'].substr(5, 2) != month) {
                    leaveBreak.splice(i, 1)
                    i--
                    continue
                }
            }

            if (leaveBreak[i]['apply_date'].substr(0, 4) != year) {
                leaveBreak.splice(i, 1)
                i--
                continue
            }
        }
        nowPage = 1
        listPage(leaveDay)
        if(leaveDay == 'apply'){
            listLeaveDayApply()
        }
        else{
            listLeaveDayBreak()
        }
    }

    function listLeaveDayBreak() {
        $("#search-leave-break").empty();
        var parent = document.getElementById('search-leave-break');
        var table = document.createElement("tbody");

        table.innerHTML = '<tr class="text-white">' +
            '<th width="20%">類型</th>' +
            '<th width="20%">日期</th>' +
            '<th width="20%">事由</th>' +
            '<th width="20%">時間</th>' +
            '<th width="10%">狀態</th>' +
            '<th width="10%"></th>' +
            '</tr>'
        var tr, span, name, a


        for (var i = 0; i < leaveBreak.length; i++) {
            if (i >= (nowPage - 1) * 10 && i < nowPage * 10) {
                table.innerHTML = table.innerHTML + setBreakData(i)
            } else if (i >= nowPage * 10) {
                break
            }

        }


        parent.appendChild(table);
    }

    function listLeaveDayApply() {
        $("#search-leave-apply").empty();
        var parent = document.getElementById('search-leave-apply');
        var table = document.createElement("tbody");

        table.innerHTML = '<tr class="text-white">' +
            '<th width="20%">類型</th>' +
            '<th width="20%">日期</th>' +
            '<th width="20%">事由</th>' +
            '<th width="20%">時間</th>' +
            '<th width="10%">狀態</th>' +
            '<th width="10%"></th>' +
            '</tr>'
        var tr, span, name, a
        for (var i = 0; i < leaveApply.length; i++) {
            if (i >= (nowPage - 1) * 10 && i < nowPage * 10) {
                table.innerHTML = table.innerHTML + setApplyData(i)
            } else if (i >= nowPage * 10) {
                break
            }
        }

        parent.appendChild(table);
    }

    function setBreakData(i) {
        type = {
            'compensatory_leave_break': '休假',
            'compensatory_leave': '補休假',
            'bereavement_leave': '喪假',
            'special_leave': '特休假'
        }

        role = '{{Auth::user()->role}}'
        if (leaveBreak[i].status == 'waiting') {
            span = '<span class="badge badge-danger">審核中</span>'
            if (role == 'administrator' && leaveBreak[i].has_break < 3 || role == 'proprietor' && leaveBreak[i].has_break >= 3) {
                year = '{{$year}}'
                form = '<form id="formLb' + leaveBreak[i].leave_day_break_id + '" action="../../../leaveDayBreak/' + leaveBreak[i].leave_day_break_id + '/' + year + '/match" method="POST">' +
                    '@csrf' +
                    '<div onclick="approved(\'' + 'formLb' + leaveBreak[i].leave_day_break_id + '\')" class="mx-2 icon-green"><i class="far fa-check-circle"></i></div>' +
                    '</form>'
            } else {
                form = '<div class="mx-2 icon-green disabled"><i class="far fa-check-circle"></i></div>'
            }
        } else {
            form = '<div class="mx-2 icon-green disabled"><i class="far fa-check-circle"></i></div>'
            span = '<span class="badge badge-success">已審核</span>'
        }
        breakProve = ' <div class="mx-1 icon-blue ' + ((leaveBreak[i].types != 'bereavement_leave') ? 'disabled' : '') + '" data-toggle="modal" data-target="#Prove' + leaveBreak[i].leave_day_break_id + '"><i class="far fa-eye"></i></div>'
        breakDelete = '<div class="mx-2 icon-red " data-toggle="modal" data-target="#break' + leaveBreak[i].leave_day_break_id + '"><i class="far fa-trash-alt"></i></div>'
        tr = "<tr>" +
            "<td>" + type[leaveBreak[i].types] + "</td>" +
            "<td >" + leaveBreak[i].apply_date + "</td>" +
            "<td >" + leaveBreak[i].content + "</td>" +
            "<td class='status-d'>" + leaveBreak[i].has_break + "天</td>" +
            "<td class='status-h'hidden>" + leaveBreak[i].has_break * 8 + "小時</td>" +
            "<td >" + span + "</td>" +
            "<td ><div class='d-flex justify-content-center'>" + form + breakProve + breakDelete + "</div></td>" +
            "</tr>"



        return tr
    }

    function setApplyData(i) {
        type = {
            'compensatory_leave_break': '休假',
            'compensatory_leave': '補休假',
            'bereavement_leave': '喪假',
            'special_leave': '特休假'
        }

        role = '{{Auth::user()->role}}'
        if (leaveApply[i].status == 'waiting') {
            span = '<span class="badge badge-danger">審核中</span>'
            if (role == 'administrator') {
                year = '{{$year}}'
                form = '<form id="formLa' + leaveApply[i].leave_day_apply_id + '" action="../../../leaveDayApply/' + leaveApply[i].leave_day_apply_id + '/' + year + '/match" method="POST">' +
                    '@csrf' +
                    '<div onclick="approved(\'' + 'formLa' + leaveApply[i].leave_day_apply_id + '\')" class="mx-2 icon-green"><i class="far fa-check-circle"></i></div>' +
                    '</form>'
            } else {
                form = '<div class="mx-2 icon-green disabled"><i class="far fa-check-circle"></i></div>'
            }
        } else {
            form = '<div class="mx-2 icon-green disabled"><i class="far fa-check-circle"></i></div>'
            span = '<span class="badge badge-success">已審核</span>'
        }
        applyDelete = '<div class="mx-2 icon-red " data-toggle="modal" data-target="#apply' + leaveApply[i].leave_day_apply_id + '"><i class="far fa-trash-alt"></i></div>'
        tr = "<tr>" +
            "<td>" + type[leaveApply[i].type] + "</td>" +
            "<td >" + leaveApply[i].apply_date + "</td>" +
            "<td >" + leaveApply[i].content + "</td>" +
            "<td class='status-d'>" + leaveApply[i].should_break + "天</td>" +
            "<td class='status-h'hidden>" + leaveApply[i].should_break * 8 + "小時</td>" +
            "<td >" + span + "</td>" +
            "<td ><div class='d-flex justify-content-center'>" + form + applyDelete + "</div></td>" +
            "</tr>"
        return tr
    }

    function getApply() {
        data = "{{$leave_day_applies}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data;
    }

    function getBreak() {
        data = "{{$leave_day_breaks}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data;
    }

    function setMonth() {
        month = ""
        $("#select-month").empty();
        $("#select-month").append("<option value=''></option>");
        for (var i = 0; i < 12; i++) {
            if (i < 9) {
                $("#select-month").append("<option value='0" + (i + 1) + "'>" + "0" + (i + 1) + "</option>");
            } else {
                $("#select-month").append("<option value='" + (i + 1) + "'>" + (i + 1) + "</option>");

            }
        }
    }

    function changeLeave(i) {
        nowPage = 1
        if (i == 1) {
            document.getElementById('apply').hidden = true
            document.getElementById('break').hidden = false
            leaveDay = 'break'
            listPage(leaveDay)

        } else {
            document.getElementById('apply').hidden = false
            document.getElementById('break').hidden = true
            leaveDay = 'apply'
            listPage(leaveDay)

        }
        if(leaveDay == 'apply'){
            listLeaveDayApply()
        }
        else{
            listLeaveDayBreak()
        }
    }

    function changeLeaveDayForm(id) {
        var id = $("#selectLeaveDay").val();
        document.leaveDayForm.action = "/leaveDay/" + id + "/" + year + "-" + leaveDay;
        document.getElementById("leaveDayForm").submit()
    }

    function approved(id) {
        document.getElementById(id).submit()
    }

    function changeStatus() {
        h = document.getElementsByClassName('status-h')
        d = document.getElementsByClassName('status-d')
        if (status == 'd') {
            status = 'h'
            for (var i = 0; i < h.length; i++) {
                h[i].hidden = false
                d[i].hidden = true
            }
        } else if (status == 'h') {
            status = 'd'
            for (var i = 0; i < h.length; i++) {
                h[i].hidden = true
                d[i].hidden = false
            }
        }
    }
</script>
@stop