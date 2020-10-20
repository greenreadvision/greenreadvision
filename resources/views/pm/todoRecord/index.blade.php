@extends('layouts.app')
@section('content')
<div class="row">
    <!-- <div class="col-lg-3">
        <select id="selectTodoRecord" class="form-control" onchange="changeTodoRecord()">
            <option value=""></option>
            @foreach($users as $user)
            @if($user->role != 'manager' && $user->status != 'resignation' && $user->name != "test")
            <option value="{{$user['user_id']}}">{{$user['nickname']}}</option>
            @endif
            @endforeach
        </select>
    </div> -->
    <div class="col-lg-2">
        <input class="form-control" type="date" id="todoRecordDate">
    </div>

    <div class="col-lg-2">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTodayTodoModal">今日完成事項</button>
    </div>
    <div class="col-lg-2">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createNexyDayTodoModal">明日代辦事項</button>
    </div>

</div>
<div class="row">
    <div class="col-lg-4">
        <h5>今日待辦</h5>
        @foreach($users as $user)
            @if($user->user_id == \Auth::user*-)
        @endforeach
    </div>
    <div class="col-lg-4">
        <h5>今日完成</h5>
    </div>
    <div class="col-lg-4">
        <h5>明日待辦</h5>
    </div>
</div>


<div class="modal fade" id="createNexyDayTodoModal" tabindex="-1" role="dialog" aria-labelledby="createNexyDayTodoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createNexyDayTodoModalLabel">明日代辦事項</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="todoRecord/create/nextDay" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12 form-group">
                        <input placeholder="活動" autocomplete="off" type="text" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" required>
                    </div>
                    <div class="col-lg-12 form-group">
                        <textarea placeholder="完成事項" name="event" rows="20" style="resize:none;" class="form-control{{ $errors->has('event') ? ' is-invalid' : '' }}" required>{{ old('event') }}</textarea>
                        <p style="color:red;"><strong>※每個項目用換行分開</strong></p>
                    </div>


                    <div class="float-right">
                        <button type="submit" class="mb-3 btn btn-primary btn-primary-style">新增</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="createTodayTodoModal" tabindex="-1" role="dialog" aria-labelledby="createTodayTodoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTodayTodoModalLabel">今日完成事項</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="todoRecord/create/today" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12 form-group">
                        <input placeholder="活動" autocomplete="off" type="text" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" required>
                    </div>
                    <div class="col-lg-12 form-group">
                        <textarea placeholder="完成事項" name="event" rows="20" style="resize:none;" class="form-control{{ $errors->has('event') ? ' is-invalid' : '' }}" required>{{ old('event') }}</textarea>
                        <p style="color:red;"><strong>※每個項目用換行分開</strong></p>
                    </div>


                    <div class="float-right">
                        <button type="submit" class="mb-3 btn btn-primary btn-primary-style">新增</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


@stop

@section('script')


<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>

<script>
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth() + 1
    if (month < 10) {
        month = '0' + month;
    }
    var date = today.getDate();

    $(document).ready(function($) {
        $('#todoRecordDate').val(year + '-' + (month) + '-' + date)
    })
</script>

<script src="{{ URL::asset('js/grv.js') }}"></script>


@stop