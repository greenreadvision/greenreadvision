@extends('layouts.app')
@section('content')

<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">公司文案</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a href="/resource" class="page_title_a" >共用資源</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">{{$data->id}}</span>
        </div>
    </div>
</div>
<!--類型(修改)-->
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
                            <label class="label-style col-form-label" >類型</label>
                            <select name="type" id="type" class="form-control rounded-pill">
                            @foreach ($types as $type)
                                @if($type == $data->type)
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

<!--廠商名稱(修改)-->
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
                            <label class="label-style col-form-label" >廠商名稱</label>
                            <textarea class="form-control" name="name" id="name" style="height: 50px" >{!!$data->name!!}</textarea>
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

<!--電話(修改)-->
<div class="modal fade" id="phoneModal" role="dialog" aria-labelledby="phoneModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="phoneModalLabel">編輯</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    <form action="update/phone" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" >電話</label>
                            <textarea class="form-control" name="phone" id="phone" style="height: 50px" >{!!$data->phone!!}</textarea>
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
<!--電子郵件(修改)-->
<div class="modal fade" id="emailModal" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">編輯</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    <form action="update/email" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" >電子郵件</label>
                            <textarea class="form-control" name="email" id="email" style="height: 50px" >{!!$data->email!!}</textarea>
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
<!--電子郵件(修改)-->
<div class="modal fade" id="introModal" role="dialog" aria-labelledby="introModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="introModalLabel">編輯</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    <form action="update/intro" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" >簡介</label>
                            <textarea class="form-control" name="intro" id="intro" style="height: 50px" >{!!$data->intro!!}</textarea>
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
<!--備註 彈出框(修改)-->
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
                    <form action="update/note" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-lg-12 form-group justify-content-center">
                            <div style="padding-top: 10px">
                                <div class="col-lg-12">
                                    <label class="label-style col-form-label" for="content">備註</label>
                                    <textarea class="form-control" style="height: 600px" id="ckeditor" name="ckeditor">{!!$data->note!!}</textarea>
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
                                    <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#typeModal"></i>
                                </div>
                                <div class="col-lg-12">
                                    類型
                                </div>
                                <div class="col-lg-12 text-center"> 
                                    <h3>{{__('customize.'.$data->type)}}</h3>
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
                                    廠商名稱
                                </div>
                                <div class="col-lg-12 text-center">
                                    <h3>{{$data->name}}</h3>
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
                                    <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#phoneModal"></i>
                                </div>
                                <div class="col-lg-12">
                                    電話
                                </div>
                                <div class="col-lg-12 text-center">
                                    <h3>{{$data->phone}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <div class="col-lg-12 d-flex justify-content-end p-0">
                                    <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#emailModal"></i>
                                </div>
                                <div class="col-lg-12">
                                    電子郵件
                                </div>
                                <div class="col-lg-12 text-center"> 
                                    <h3>{{$data->email}}</h3>
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
                                    <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#introModal"></i>
                                </div>
                                <div class="col-lg-12">
                                    簡介
                                </div>
                                <div class="col-lg-12">
                                    <span id="intro">{!!$data->intro!!}</span>
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
                                    備註
                                </div>
                                <div class="col-lg-12">
                                    <span id="content">{!!$data->note!!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="delete" method="POST">
    @method('DELETE')
    @csrf
    <div class="col-lg-12 d-flex justify-content-end">
        <button class="btn btn-red rounded-pill" type="submit" ><span class="mx-2">{{__('customize.Delete')}}</span> </button>
    </div>
</form>
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
@stop