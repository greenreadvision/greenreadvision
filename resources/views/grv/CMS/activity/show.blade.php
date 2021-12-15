@extends('grv.CMS.app')
@section('content')
<!--隸屬標案彈出框(修改)-->
<div class="modal fade" id="projectModal" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectModalLabel">編輯</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    <form action="update/project" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <select name="projectName" id="projectName" class="form-control rounded-pill">
                                <optgroup id="select-project-grv_2" label="綠雷德">
                                @foreach($projects as $project)
                                @if($project->company_name == 'grv_2')
                                    @if($project->project_id == $activity->project_id)
                                    <option value="{{$project->project_id}}" selected>{{$project->name}}</option>
                                    @else
                                    <option value="{{$project->project_id}}">{{$project->name}}</option>
                                    @endif
                                @endif
                                @endforeach
                                <optgroup id="select-project-grv" label="綠雷德(舊)">
                                @foreach($projects as $project)
                                @if($project->company_name == 'grv')
                                    @if($project->project_id == $activity->project_id)
                                    <option value="{{$project->project_id}}" selected>{{$project->name}}</option>
                                    @else
                                    <option value="{{$project->project_id}}">{{$project->name}}</option>
                                    @endif
                                @endif
                                @endforeach
                                <optgroup id="select-project-rv" label="閱野">
                                @foreach($projects as $project)
                                @if($project->company_name == 'rv')
                                    @if($project->project_id == $activity->project_id)
                                    <option value="{{$project->project_id}}" selected>{{$project->name}}</option>
                                    @else
                                    <option value="{{$project->project_id}}">{{$project->name}}</option>
                                    @endif
                                @endif
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                        </div>
              
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--活動主辦單位以及名稱 彈出框(修改)-->
<div class="modal fade" id="nameModal" role="dialog" aria-labelledby="nameModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nameModalLabel">編輯</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    <form action="update/name" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="organizers">主辦單位名稱</label>
                            <input required id="organizer" autocomplete="off" type="text" name="organizer" class="rounded-pill form-control{{ $errors->has('organizers') ? ' is-invalid' : '' }}" value="{{ $activity->organizers }}">

                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="name">活動名稱</label>
                            <input required id="name" autocomplete="off" type="text" name="name" class="rounded-pill form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $activity->name }}">

                        </div>
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                        </div>
              
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--活動類型 彈出框(修改)-->
<div class="modal fade" id="typeModal"  role="dialog" aria-labelledby="typeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="typeModalLabel">編輯</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    <form action="update/type" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="organizers">活動類型</label>
                            <select name="type" id="type" class="form-control rounded-pill">
                                @foreach ($activity_type as $item)
                                    @if($item->type_id == $activity->type)
                                    <option value="{{$item->type_id}}" selected>{{$item->name}}</option>
                                    @else
                                    <option value="{{$item->type_id}}">{{$item->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                        </div>
              
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--活動時間 彈出框(修改)-->
<div class="modal fade" id="timeModal"  role="dialog" aria-labelledby="timeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timeModalLabel">編輯</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    <form action="update/date" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="organizers">活動日期</label>
                            <select class="rounded-pill form-control{{ $errors->has('choose_date_type') ? ' is-invalid' : '' }}" onchange="DateType(this.options[this.options.selectedIndex].value)" name= "choose_date_type">
                                @if($activity->end_time ==null)
                                <option value="one" selected>單日</option>
                                <option value="many">多日</option>
                                @else
                                <option value="one">單日</option>
                                <option value="many" selected>多日</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-12 form-group" id="begin_date_div">
                            <label class="label-style col-form-label" for="date">&nbsp 開始日期</label>
                            <input style="margin-right:5%" type="date" name="begin_date" id="begin_date" class="rounded-pill form-control{{ $errors->has('begin_time') ? ' is-invalid' : '' }}" value="{{$activity->begin_time}}" required>
                        </div>
                        <div class="col-lg-12 form-group" id="end_date_div" {{($activity->end_time == null) ? 'hidden' : '' }}>
                            <label class="label-style col-form-label" for="date">&nbsp 結束日期</label>
                            <input style="margin-right:5%" type="date" name="end_date" id="end_date" class="rounded-pill form-control{{ $errors->has('end_time') ? ' is-invalid' : '' }}" value="{{$activity->end_time}}">
                        </div>
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                        </div>
              
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--主視覺 彈出框(修改)-->
<div class="modal fade" id="imageModal"  role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">編輯</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    <form action="update/image" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-lg-12 justify-content-end">
                            <label class="label-style col-form-label" for="title">主視覺</label>
                            <label onclick="uploadImg()" id="view_lable" class="label-style col-form-label input-photo-label w-100 ">
                                <small>上傳主視覺</small>
                            </label>
                        </div>
                        <div class="col-lg-12 form-group d-flex justify-content-center">
                            <input type="file" name="img_path" accept="image/*" id="imgReader" data-target="view_image" hidden> 
                            <div class="activity-img" style="width: 15vw; height:15vw">
                                <img id="view_image" style="width: 100%" src="{{route('download', $activity->img_path)}}"/>
                                <span id="view_span">{{$activity->organizers}}<br>{{$activity->name}}</span>
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--詳細內容 彈出框(修改)-->
<div class="modal fade" id="contentModal"  role="dialog" aria-labelledby="contentModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:70vw" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contentModalLabel">編輯</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    <form action="update/content" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-lg-12 form-group justify-content-center">
                            <div style="padding-top: 10px">
                                <div class="col-lg-12">
                                    <label class="label-style col-form-label" for="content">詳細文章撰寫</label>
                                    <textarea class="form-control" style="height: 600px" id="ckeditor" name="ckeditor">{!!$activity->content!!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-lg-12 form-group d-flex justify-content-end">
                                <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--修改頁面-->
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <div class="col-lg-12 d-flex justify-content-end p-0">
                                    <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#projectModal"></i>
                                </div>
                                <div class="col-lg-12">
                                    文章所屬標案
                                </div>
                                <div class="col-lg-12 text-center">
                                    <h3>{{$activity['project']->name}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <div class="col-lg-12 d-flex justify-content-end p-0">
                                    <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#nameModal"></i>
                                </div>
                                <div class="col-lg-12">
                                    活動主辦單位以及名稱
                                </div>
                                <div class="col-lg-12 text-center">
                                    <h3>{{$activity->organizers}}</h3>
                                    <h3>{{$activity->name}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <div class="col-lg-12 d-flex justify-content-end p-0">
                                    <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#typeModal"></i>
                                </div>
                                <div class="col-lg-12">
                                    活動類型
                                </div>
                                <div class="col-lg-12 text-center">
                                    <h3>{{__('customize.' . $activity->type)}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <div class="col-lg-12 d-flex justify-content-end p-0">
                                    <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#timeModal"></i>
                                </div>
                                <div class="col-lg-12">
                                    活動時間
                                </div>
                                <div class="col-lg-12 text-center">
                                    @if($activity->end_time ==null)
                                    <h3>{{$activity->begin_time}}</h3>
                                    @else
                                    <h3>{{$activity->begin_time}} ~ {{$activity->end_time}}</h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <div class="col-lg-12 d-flex justify-content-end p-0">
                                    <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#contentModal"></i>
                                </div>
                                <div class="col-lg-12">
                                    活動內容介紹
                                </div>
                                <div class="col-lg-12">
                                    <!--<button type="button" id="content-upload" onclick="article('{{$activity->content}}')" hidden></button>-->
                                    <span id="content">{!!$activity->content!!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="row">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body">
                            <div class="col-lg-12 d-flex justify-content-end p-0">
                                <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#imageModal"></i>
                            </div>
                            <div class="col-lg-12">
                                首頁主視覺
                            </div>
                            <div class="col-lg-12" >
                                <div class="activity-img">
                                    <img style="width: 100%" src="{{route('download', $activity->img_path)}}"/>
                                    <span id="view_span">{{$activity->organizers}}<br/>{{$activity->name}}</span>
                                </div> 
                            </div>
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

<script >

    var span_text =[]
    $(document).ready(function() {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {
            modal_this = this
            $(document).on('focusin.modal', function (e) {
                if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length&& $(e.target.parentNode).hasClass('cke_contents cke_reset')) {
                    modal_this.$element.focus()
                }
            })
        };
        var view_input = document.querySelector('#imgReader')
        var view_span_title = document.querySelector('#name')
        var view_span_organizer = document.querySelector('#organizer')
        span_text = [view_span_organizer.value , view_span_title.value];
        
        view_input.addEventListener('change',function(e){
            readURL(e.target)
        })
        view_span_title.addEventListener('change',function(){
            addSpanTitle()
        })
        view_span_organizer.addEventListener('change',function(){
            addSpanOrganizer()
        })
    });
    function readURL(input){
        var imgId = input.getAttribute('data-target')
        var img = document.querySelector('#'+ imgId)
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                img.setAttribute('src',e.target.result);
            }
            reader.readAsDataURL(input.files[0])
        }
    }
    function addSpanOrganizer(){
        var title = document.getElementById('organizer')
        span_text[0] = title.value
        
        setSpan()
    }
    function addSpanTitle(){
        var title = document.getElementById('title')
        span_text[1] =title.value
        setSpan()
    }

    function setSpan(){
        var span = document.getElementById('view_span')
        span.innerHTML = span_text[0]+ "<br>" + span_text[1]
    }
    function DateType(val){
        var end_date_div = document.getElementById('end_date_div')
        var end_date =document.getElementById('end_date')
        switch(val){
            case "one":
                end_date_div.hidden = true
                break;
            case "many":
                end_date_div.hidden = false
                break;
            default:
                break;
        }
    }    
    function uploadImg() {
        document.querySelector('#imgReader').click()
    }
</script>
@stop