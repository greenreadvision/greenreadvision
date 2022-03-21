@extends('grv.CMS.app')
@section('content')

<div class="modal fade" id="PreviewModal" role="dialog" aria-labelledby="PreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:90vw;min-width:900px " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>整體預覽</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-x:hidden;overflow-y:auto">
                <div class="col-lg-12">
                    <label  class="label-style col-form-label" style="font-size: 16pt">簡易介紹預覽</label>
                    <section class="ActivityContent" style="min-height: auto">
                        <div class="ActivityContent-wrap">
                            <div class="ActivityMenu">
                                <div class="ActivityMenu-list">
                                        <a class="ActivityMenu-list-table row">
                                            <div class="ActivityMenu-show-group">
                                                <div class="ActivityMenu-list-img" id="ActivityMenu-list-img">
                                                    <span></span>
                                                </div>
                                            </div>
                                            
                                            <div class="ActivityMenu-content-group">
                                                <span class="title" id="modal_title"></span></br>
                                                
                                            </div>
                                            <div class="ActivityMenu-create-group">
                                                <span style="font-weight:bolder;">政府單位：</br></span>
                                                <span id="modal_group"></span></br>
                                                <span ></br></span> 
                                                <span style="font-weight:bolder;">專案負責人：</br></span>
                                                <span id="modal_user_id"></span>
                                            </div>
                                        </a>
                                </div>
                            </div>
                
                        </div>
                    </section>
                </div>
                <hr size="2px" align="center" width="100%">
                <div class="col-lg-12">
                    <label  class="label-style col-form-label" style="font-size: 16pt">詳細內容預覽</label>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <form name="activityForm" action="create/review" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="type">公告類型</label>
                                    <select type="text" name="type" id="type" class="form-control rounded-pill" autofocus>
                                        @foreach($types as $key => $type)
                                        <option value="{{$type['type_id']}}">{{__('customize.' . $type['type_id'])}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                                    <select type="text" id="project_id" name="project_id" class="rounded-pill form-control" onchange="select('project',this.options[this.options.selectedIndex].value)">
                                        <optgroup label="綠雷德創新">
                                            @foreach($grv2 as $gr)
                                            @if($gr['name']!='其他')
                                            <option value="{{$gr['project_id']}}">{{$gr->name}}</option>
                                            @endif

                                            @endforeach
                                        </optgroup>
                                        
                                        <optgroup label="綠雷德(舊)">
                                            @foreach($grv as $gr)
                                            @if($gr['name']!='其他')
                                            <option value="{{$gr['project_id']}}">{{$gr->name}}</option>
                                            @endif

                                            @endforeach
                                        </optgroup>
                                        <optgroup label="閱野">
                                            @foreach($rv as $r)
                                            <option value="{{$r['project_id']}}">{{$r->name}}</option>
                                            @endforeach
                                        </optgroup>
                                        <!-- @foreach ($projects as $project)
                            
                                        @if($project['name']!='其他')
                                        <option value="{{$project['project_id']}}">{{$project['name']}}</option>
                                        @endif
                                        @endforeach -->
                                        <option value="qs8dXg88gPm">其他</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="organizer">主辦單位</label>
                                    <input type="text" name="organizer" id="organizer" data-target="organizer" onchange="select(organizer,this.id)" class="form-control rounded-pill" required>
                                </div>
                                <div class="col-lg-6">
                                    <label class="label-style col-form-label" for="name">活動名稱</label>
                                    <input type="text" name="name" id="name" data-target="name" class="form-control rounded-pill" onchange="select(title,this.id)" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <label  class="label-style col-form-label">活動日期</label>
                                    <select class="rounded-pill form-control{{ $errors->has('choose_date_type') ? ' is-invalid' : '' }}" onchange="DateType(this.options[this.options.selectedIndex].value)" name= "choose_date_type">
                                        <option value=""></option>
                                        <option value="one">單日</option>
                                        <option value="many">多日</option>
                                    </select>
                                </div>
                                <div class="col-lg-4" id="begin_date_div">
                                    <label class="label-style col-form-label" for="type">&nbsp 開始日期</label>
                                    <input style="margin-right:5%" type="date" name="begin_date" id="begin_date" class="rounded-pill form-control{{ $errors->has('begin_date') ? ' is-invalid' : '' }}" value="{{ old('begin_date') }}" required>
                                </div>
                                <div class="col-lg-4" id="end_date_div">
                                    <label class="label-style col-form-label" for="type">&nbsp 結束日期</label>
                                    <input style="margin-right:5%" type="date" name="end_date" id="end_date" class="rounded-pill form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{ old('end_date') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="row" id="img_row">
                                <div class="col-lg-12">
                                    <label class="label-style col-form-label" for="title">主視覺</label>
                                    <!--<label  id="view_lable" class="label-style col-form-label input-photo-label w-100">
                                        <small>上傳主視覺</small>
                                    </label>-->
                                </div>
                                <div class="col-lg-12">
                                    <input type="file" name="img_path" accept="image/*" id="imgReader" data-target="view_image"   required> 
                                    <div onclick="uploadImg()" class="activity-img" id= 'activity-img'>
                                        <a href="javascript:void(0)" class="view_image" id="view_image">
                                            <span id="view_span"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row justify-content-center" style="padding-top: 10px">
                            <div class="col-lg-12">
                                <label class="label-style col-form-label" for="title">詳細文章撰寫</label>
                                <textarea class="form-control" style="height: 600px" id="ckeditor" name="ckeditor"></textarea>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col lg 6" style="display:none;padding-top: 20px;text-align: start;">
                                <button onclick="showPreview()" class="w-15 btn btn-blue rounded-pill" type="button" id="previewButton">預覽</button>
                            </div>
                            <div class="col-lg-12" style="padding-top: 20px;text-align: end">
                                <button type="submit" onclick="checkValid()" class="w-15 btn btn-green rounded-pill">{{__('customize.Add')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
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

<style>
    .valid{
        border:2px solid green;
    }
    .invalid{
        border:2px solid red;
    }

    #imgReader {
        display: none;

    }

    .img-check {
        cursor: pointer;
        background-color: white;
        opacity: .8;
        transition: all .2s;
    }

    .img-check-show {

        opacity: 0;
        transition: all .2s;
    }


    .previewBox {
        box-shadow: 0 0 5px #adadad;
        width: 200px;
        height: 200px;
        background: rgb(250, 250, 250);
        overflow: hidden;
    }
</style>
<script type="text/javascript">
    var span_text = []
    
    $(document).ready(function() {
        var view_input = document.querySelector('#imgReader')
        var begin_date = document.getElementById('begin_date_div')
        var end_date = document.getElementById('end_date_div')
        begin_date.hidden = true
        end_date.hidden = true
        
        view_input.addEventListener('change',function(e){
            readURL(e.target)
        })

        var imgReader = document.getElementById('imgReader')
        var img_row = document.getElementById('img_row')
        imgReader.addEventListener('input', function(){
            if(imgReader.checkValidity()){
                img_row.classList.remove('invalid')
            }else{
                img_row.classList.add('invalid')
                if(imgReader.validity.valueMissing){
                    imgReader.setCustomValidity('此欄位為必填，請重新確認');
                    return
                }
                console.log('???')
            }
        })

    });

    function select(type,val){
    var modal_title = document.getElementById('modal_title');
    var modal_user_id = document.getElementById('modal_user_id');
    var modal_group = document.getElementById('modal_group');
        switch(type){
            case 'title':
                modal_title.value = document.getElementById(val).value;
                modal_title.innerHTML = document.getElementById(val).value;
                break;
            case 'project':
                modal_user_id.value =document.getElementById(val).value;
                modal_user_id.innerHTML =document.getElementById(val).value;
                break;
            case 'organizer':
                modal_group.val = val;
                modal_group.innerHTML = val;
                break;
            default:
        }
    }
    
    function readURL(input){
        var img = document.getElementById('activity-img')
        var modal_img = document.getElementById('ActivityMenu-list-img')
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                img.style.backgroundImage = "url('" + e.target.result + "')"
                modal_img.style.backgroundImage = "url('" + e.target.result + "')"
            }
            reader.readAsDataURL(input.files[0])
        }
    }

    function DateType(val){
        console.log(val)
        var begin_date = document.getElementById('begin_date_div')
        var end_date = document.getElementById('end_date_div')
        switch(val){
            case "":
                begin_date.hidden = true
                end_date.hidden = true
                break;
            case "one":
                begin_date.hidden = false
                end_date.hidden = true
                break;
            case "many":
                begin_date.hidden = false
                end_date.hidden = false
                end_date.required
                break;
            default:
                break;
        }
    }

    function showPreview(){
        $('#PreviewModal').modal('show');
    }

    function addSpanOrganizer(){
        var title = document.getElementById('organizer')
        span_text[0] = title.value
        
        setSpan()
    }
    function addSpanTitle(){
        var title = document.getElementById('name')
        span_text[1] =title.value
        setSpan()
    }

    function setSpan(){
    }

    function check(){
        alert (CKEDITOR.instances.ckeditor.getData());
        
    }
    function uploadImg() {
        document.querySelector('#imgReader').click()
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

<script type="text/javascript">
    function checkValid(){
        /*var imgReader = document.getElementById("imgReader")
        if (imgReader.validity.valueMissing) {
            console.log('請輸入')
            imgReader.classList.remove('valid')
            imgReader.classList.add('invalid')
            imgReader.setCustomValidity('此欄位為必填，請重新確認');
        } else {
            imgReader.classList.add('valid')
            imgReader.classList.remove('invalid')
        } */
        
       
    }

</script>

@stop