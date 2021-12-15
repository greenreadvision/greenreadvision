@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
            <form name="updateForm" action="update" method="post">
                @method('PUT')
                @csrf
                <div class="form-group row">
                    <div class="col-lg-6 form-group" style="padding-left:100%">
                        <button type="button" class="btn btn-danger btn-danger-style" data-toggle="modal" data-target="#deleteModal">
                            <i class='fas fa-trash-alt'></i><span class="ml-3">{{__('customize.Delete')}}</span>
                        </button>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="type">題庫選擇</label>
                        <select type="text" id="type" name="type" class="form-control" autofocus>
                            @if($data->type=='active')
                                <option value="active" selected>活動題庫</option>
                                <option value="pm">公司網站題庫</option>
                            @elseif($data->type=='pm')
                                <option value="avtive">活動題庫</option>
                                <option value="pm" selected>公司網站題庫</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="title">題目</label>
                        <input autocomplete="off" type="text" id="title" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{$data->title}}" required>
                    </div>
                    <div class="col-lg-3 form-group">
                        <input type="radio" name="answer" value="option_1" onclick="answer_check()" {{$data->answer == 'option_1' ? 'checked': ''}}>
                        <label class="label-style col-form-label " name="option" style="color: red;{{ $data->answer == 'option_1' ? 'display:inline' : 'display:none' }}">(答案)</label><label class="label-style col-form-label" for="option_1">選項(A)</label>
                        <input autocomplete="off" type="text" id="option_1" name="option_1" class="form-control{{ $errors->has('option_1') ? ' is-invalid' : '' }}" value="{{$data->option_1}}" required>
                    </div>
                    <div class="col-lg-3 form-group">
                        <input type="radio" name="answer" value="option_2" onclick="answer_check()" {{$data->answer == 'option_2' ? 'checked': ''}}>
                        <label class="label-style col-form-label " name="option" style="color: red;{{ $data->answer == 'option_2' ? 'display:inline' : 'display:none' }}">(答案)</label><label class="label-style col-form-label" for="option_2">選項(B)</label>
                        <input autocomplete="off" type="text" id="option_2" name="option_2" class="form-control{{ $errors->has('option_2') ? ' is-invalid' : '' }}" value="{{$data->option_2}}" required>
                    </div>
                    <div class="col-lg-3 form-group">
                        <input type="radio" name="answer" value="option_3" onclick="answer_check()" {{$data->answer == 'option_3' ? 'checked': ''}}>
                        <label class="label-style col-form-label " name="option" style="color: red;{{ $data->answer == 'option_3' ? 'display:inline' : 'display:none' }}">(答案)</label><label class="label-style col-form-label" for="option_3">選項(C)</label>
                        <input autocomplete="off" type="text" id="option_3" name="option_3" class="form-control{{ $errors->has('option_3') ? ' is-invalid' : '' }}" value="{{$data->option_3}}" required>
                    </div>
                    <div class="col-lg-3 form-group">
                        <input type="radio" name="answer" value="option_4" onclick="answer_check()" {{$data->answer == 'option_4' ? 'checked': ''}}>
                        <label class="label-style col-form-label " name="option" style="color: red;{{ $data->answer == 'option_4' ? 'display:inline' : 'display:none' }}">(答案)</label><label class="label-style col-form-label" for="option_4">選項(D)</label>
                        <input autocomplete="off" type="text" id="option_4" name="option_4" class="form-control{{ $errors->has('option_4') ? ' is-invalid' : '' }}" value="{{$data->option_4}}" required>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="label-style col-form-label" for="content">詳細解釋(選填)</label>
                            <input autocomplete="off" type="text" id="content" name="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" value="{{$data->content!=null ? $data->content: old('content')}}">
                    </div>
                    <div class="col-lg-12 form-group" style="padding-left:100%">
                        <button type="submit" class="btn btn-primary btn-primary-style">更改</button>
                    </div>
                    
                </div>
                
                
            </form>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                <span style="font-size: 32px">
                是否刪除?
                </span>
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
@stop

@section('script')
<script type="text/javascript">
    var i;
    var radio = document.getElementsByName("answer");
    var answer = document.getElementsByName("option");
    function answer_check(){
        for(i=0;i<answer.length;i++){
            answer[i].style.display = "none";
            if(radio[i].checked){
                answer[i].style.display = "inline";
            }
        }
    }
</script>
@stop