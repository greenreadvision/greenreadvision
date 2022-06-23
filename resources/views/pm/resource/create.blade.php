@extends('layouts.app')
@section('content')

<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">公司文案</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/resource" class="page_title_a" >共用資源</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">新增廠商資料</span>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    <form name="invoiceForm" action="create/review" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="label-style col-form-label" for="type">類型</label>
                                <select type="text" name="type" id="type" class="form-control rounded-pill" autofocus>
                                    @foreach($types as $type)
                                    <option value="{{$type}}">{{__('customize.'.$type)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="label-style col-form-label" for="name">廠商名稱</label>
                                <input type="text" name="name" id="name" class="form-control rounded-pill" required>
                            </div>
                        </div>

                        <div class="row" style="padding-top: 10px">
                            <div class="col-lg-6">
                                <label class="label-style col-form-label" for="phone">電話</label>
                                <input type="text" name="phone" id="phone" class="form-control rounded-pill" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="label-style col-form-label" for="email">電子郵件</label>
                                <input type="text" name="email" id="email" class="form-control rounded-pill" >
                            </div>
                        </div>
                        <div class="row" style="padding-top: 10px">
                            <div class="col-lg-12">
                                <label class="label-style col-form-label" for="intro">簡介</label>
                                <input type="text" name="intro" id="intro" class="form-control rounded-pill" >
                            </div>
                        </div>
                        <div class="row" style="padding-top: 10px">
                            <div class="col-lg-12">
                                <label class="label-style col-form-label" for="ckeditor">備註</label>
                                <textarea class="form-control" style="height: 600px" id="ckeditor" name="ckeditor"></textarea>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-lg-12" style="padding-top: 20px;text-align: end">
                                <button type="submit" class="w-15 btn btn-green rounded-pill">{{__('customize.Add')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>
<script src="{{URL::asset('ckeditor/ckeditor.js') }}"></script>
<script>
    setTimeout(function(){
        var editor = CKEDITOR.replace( 'ckeditor',{
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            language: 'zh-cn',
            
        } ); //Your selector must match the textarea ID
    },400);
</script>

<script>

    $(document).ready(function() {

    });

    function check(){
        alert (CKEDITOR.instances.ckeditor.getData());
        
    }

    function changeAddedBoolean(i){
        if(i==0)
        {
            document.getElementsByClassName("Added")[1].classList.remove("active")
            document.getElementsByClassName("Added")[0]+= " active"
            document.getElementById("Added-time-labal").hidden = true
            $("#Added-time").val("")
            
        }
        else if(i==1)
        {
            document.getElementsByClassName("Added")[0].classList.remove("active")
            document.getElementsByClassName("Added")[1]+= " active"
            document.getElementById("Added-time-labal").hidden = false
        }
    }
</script>

@stop