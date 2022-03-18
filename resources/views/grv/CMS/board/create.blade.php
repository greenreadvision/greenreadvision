@extends('grv.CMS.app')
@section('content')

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    <form name="invoiceForm" action="create/review" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="label-style col-form-label" for="type">公告類型</label>
                                <select type="text" name="type" id="type" class="form-control rounded-pill" autofocus>
                                    <option value="news">最新訊息</option>
                                    <option value="service">服務項目</option>
                                    <option value="question">常見問題</option>
                                    
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="label-style col-form-label" for="Added-boolean">是否於今日上架</label>
                                <div class="form-group">
                                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                        <label class="btn btn-secondary active w-50 Added" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                                            <input type="radio" name="Added-true" id="Added-true" onchange="changeAddedBoolean(0)" autocomplete="off" checked> <span class="mx-2">是</span>
                                        </label>
                                        <label class="btn btn-secondary w-50 Added" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                                            <input type="radio" name="Added-false" id="Added-false" onchange="changeAddedBoolean(1)" autocomplete="off"> <span class="mx-2">否</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4" id='Added-time-labal' hidden>
                                <label class="label-style col-form-label" for="Added-time">預計上架日期</label>
                                <input type="date" name="Added-time" id="Added-time" class="form-control rounded-pill">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="label-style col-form-label" for="title">公布主旨</label>
                                <input type="text" name="Added-title" id="Added-title" class="form-control rounded-pill" required>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 10px">
                            <div class="col-lg-12">
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