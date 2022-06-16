@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <a  href="/change" class="page_title_a" >系統更動申請表單</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/change/{{$data['change']['id']}}/review" class="page_title_a" >{{$data['change']['finished_id']}}</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">編輯資料</span>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    <form name="edit_changeForm" action="update" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            @if(\Auth::user()->role =='intern'||\Auth::user()->role =='manager')
                            <div class="col-lg-12 col-form-label" style="padding-left: 0px">
                                <div class="col-lg-6 form-group" >
                                    <label class="label-style col-form-label" for="intern_name">實習生姓名</label>
                                    <select type="text" id="intern_name" name="intern_name" class="form-control rounded-pill" autofocus>
                                    @foreach ($data['interns'] as $intern)
                                        <option value="{{$intern->name}}" {{$data['change']['intern_name'] == $intern->name? 'selected':''}}>{{$intern->nickname}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="change_type">申請類別</label>
                                <select type="text" id="change_type" name="change_type" class="rounded-pill form-control{{ $errors->has('change_type') ? ' is-invalid' : '' }}" value="{{ old('change_type') }}" required>
                                    <option {{$data['change']['change_type'] == '專案'? 'selected':''}}>專案</option>
                                    <option {{$data['change']['change_type'] == '其他'? 'selected':''}}>其他</option>
                                </select>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="title">申請項目</label>
                                <input id="title" autocomplete="off" type="text" name="title" class="form-control rounded-pill{{ $errors->has('title') ? ' is-invalid' : '' }}" value={{$data['change']['title']}} required>
                            </div>

                            <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="content">申請更動事項</label>
                                <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control rounded-pill{{ $errors->has('content') ? ' is-invalid' : '' }}" required>{{$errors->has('content')? old('content'): $data['change']['content']}}</textarea>
                                @if ($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>超出100個字</strong>
                                </span> 
                                @endif
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="file">說明檔案上傳</label>
                                <input type="file" id="file" name="file" class="form-control rounded-pill{{ $errors->has('file') ? ' is-invalid' : '' }}"> @if ($errors->has('file'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('file') }}</strong>
                                </span> @endif
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="urgency">最晚完成期限</label>
                                <input type="date" id="urgency" name="urgency" class="form-control rounded-pill{{ $errors->has('urgency') ? ' is-invalid' : '' }}" value="{{$data['change']['urgency']}}" required> @if ($errors->has('urgency'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('urgency') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @if($data['change']['status']=='first-fix'||$data['change']['status']=='second-fix'||$data['change']['status']=='third-fix')
                        <div>
                            <label class="label-style col-6 col-form-label" for="fix"><input type="checkbox" id="fix" name="fix[]" onchange="out()" value="1" >如要重新提交審核，請勾選</label>
                        </div>
                        @endif
                        <div class="float-right">
                            <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">完成編輯</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if($data['change']['user_id']==\Auth::user()->user_id)
<form action="delete" method="POST">
    @method('DELETE')
    @csrf
    <div class="col-lg-12 d-flex justify-content-end">
        <button class="btn btn-red rounded-pill" type="submit" ><span class="mx-2">{{__('customize.Delete')}}</span> </button>
    </div>
</form>
@endif
@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">
    function out(){
        console.log(document.getElementById('fix').value);
    }
</script>

@stop