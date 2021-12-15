@extends('layouts.app')
@section('content')

<div class="col-lg-12">
    <div style="text-align:center;">
        <p style="font-size: 30px">新增題目</p>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
            <form name="questionForm" action="/train/question/review" onsubmit="return check();" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="type">題庫選擇</label>
                        <select type="text" id="type" name="type" class="form-control" autofocus>
                            <option value="active">活動題庫</option>
                            <option value="pm">公司網站題庫</option>
                        </select>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="title">題目</label>
                        <input autocomplete="off" type="text" id="title" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{old('title')}}" required>
                    </div>
                    <div class="col-lg-3 form-group">
                        <input type="radio" id="answer" name="answer" value="option_1" onclick="answer_check()" checked>
                        <label class="label-style col-form-label " name="option" style="color: red;display:inline;">(答案)</label><label class="label-style col-form-label" for="option_1">選項(A)</label>
                        <input autocomplete="off" type="text" id="option_1" name="option_1"  class="option form-control{{ $errors->has('option_1') ? ' is-invalid' : '' }}" value="{{old('option_1')}}" required>
                    </div>
                    <div class="col-lg-3 form-group">
                        <input type="radio" id="answer" name="answer" value="option_2" onclick="answer_check()">
                        <label class="label-style col-form-label " name="option" style="color: red;display:none;">(答案)</label><label class="label-style col-form-label" for="option_2">選項(B)</label>
                        <input autocomplete="off" type="text" id="option_2" name="option_2"  class="option form-control{{ $errors->has('option_2') ? ' is-invalid' : '' }}" value="{{old('option_2')}}" required>
                    </div>
                    <div class="col-lg-3 form-group">
                        <input type="radio" id="answer" name="answer" value="option_3" onclick="answer_check()">
                        <label class="label-style col-form-label " name="option" style="color: red;display:none;">(答案)</label><label class="label-style col-form-label" for="option_3">選項(C)</label>
                        <input autocomplete="off" type="text" id="option_3" name="option_3"  class="option form-control{{ $errors->has('option_3') ? ' is-invalid' : '' }}" value="{{old('option_3')}}" required>
                    </div>
                    <div class="col-lg-3 form-group">
                        <input type="radio" id="answer" name="answer" value="option_4" onclick="answer_check()">
                        <label class="label-style col-form-label " name="option" style="color: red;display:none;">(答案)</label><label class="label-style col-form-label" for="option_4">選項(D)</label>
                        <input autocomplete="off" type="text" id="option_4" name="option_4"  class="option form-control{{ $errors->has('option_4') ? ' is-invalid' : '' }}" value="{{old('option_4')}}" required>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="label-style col-form-label" for="content">詳細解釋(選填)</label>
                        <input autocomplete="off" type="text" id="content" name="content" class="form-control" value="{{old('content')}}">
                    </div>
                    <div class="col-lg-12 form-group" style="padding-left:100%">
                        <button type="submit"  class="btn btn-primary btn-primary-style">新增</button>
                    </div>
                </div>
                
            </form>
    </div>
</div>
@stop
@section('script')
<script type="text/javascript">
    var i,j;
    var answer = document.getElementsByName("answer");
    var word = document.getElementsByName("option");
    var option = document.getElementsByClassName("option");
    function answer_check(){
        for(i=0;i<word.length;i++){
            word[i].style.display = "none";
            if(answer[i].checked){
                word[i].style.display = "inline";
            }
        }
    }

    function check(){
        for(i=0;i<option.length;i++){
            for(j=i+1;j<option.length;j++){
                if( option[i].value == option[j].value){
                    option[i].style.border = "1px solid red"
                    option[j].style.border = "1px solid red"
                    alert("選項值不能重複。");
                    return false;
                }
            }
        }
        return true;
    }

    
</script>
@stop