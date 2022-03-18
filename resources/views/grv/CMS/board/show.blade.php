@extends('grv.CMS.app')
@section('content')

<!--標題(修改)-->
<div class="modal fade" id="titleModal" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalLabel">編輯</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    <form action="update/title" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" >文章主旨</label>
                            <textarea class="form-control" name="title" id="title" style="height: 50px" >{!!$board->title!!}</textarea>
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

<!--公告類型(修改)-->
<div class="modal fade" id="typeModal" role="dialog" aria-labelledby="typeModalLabel" aria-hidden="true">
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
                            <label class="label-style col-form-label" >公告類型</label>
                            <select name="type" id="type" class="form-control rounded-pill">
                            @foreach ($types as $type)
                                @if($type == $board->newTypes)
                                <option value="{{$type}}" selected>{{__('customize.'.$type)}}</option>
                                @else
                                <option value="{{$type}}" >{{__('customize.'.$type)}}</option>
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
                                    <textarea class="form-control" style="height: 600px" id="ckeditor" name="ckeditor">{!!$board->content!!}</textarea>
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
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <div class="col-lg-12 d-flex justify-content-end p-0">
                                    <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#titleModal"></i>
                                </div>
                                <div class="col-lg-12">
                                    文章主旨
                                </div>
                                <div class="col-lg-12 text-center">
                                    <h3>{{$board->title}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <div class="col-lg-12 d-flex justify-content-end p-0">
                                    <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#typeModal"></i>
                                </div>
                                <div class="col-lg-12">
                                    公告類型
                                </div>
                                <div class="col-lg-12 text-center"> 
                                    <h3>{{__('customize.'.$board->newTypes)}}</h3>
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
                                    <span id="content">{!!$board->content!!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
{{--  <div class="d-flex justify-content-center">
    <div class="col-lg-10 mb-2">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow rounded-pill">
                    <div class="card-body">
                        <div class='justify-content-center' >
                            <div id="content" name= 'content'>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  --}}



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