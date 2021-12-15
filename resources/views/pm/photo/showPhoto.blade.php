@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3">
            <h2>{{$photo->name}}</h2>
        </div>
        <div class="col-lg-6 mb-3">
            <button type="button" class="float-right btn btn-danger btn-danger-style" data-toggle="modal" data-target="#deleteModal">
                <i class='fas fa-trash-alt'></i><span class="ml-3">{{__('customize.Delete')}}</span>
            </button>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-11">
        <div class="card card-style">
            <div class="card-body ">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <form action="show/review" method="post" enctype="multipart/form-data" onsubmit="return check_create();">
                                @csrf
                                <label class="label-style  col-form-label" for="path">上傳相片</label>
                                <div class="input-group mb-3">
                                    <input multiple="multiple" accept="image/jpeg,image/gif,image/png" type="file" id="path[]" name="path[]" class="form-control{{ $errors->has('path') ? ' is-invalid' : '' }}">
                                    @if ($errors->has('path'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('path') }}</strong>
                                    </span> @endif
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary btn-primary-style">上傳</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <form action="delete/image" method="POST" onsubmit="return check_delete();">
                        @method('DELETE')
                        @csrf
                        <!-- <button id="image-delete" type="submit" class="btn btn-primary" disabled>{{__('customize.Delete')}}</button> -->
                        <div class="row">
                            @foreach($image as $data)
                            <div class="col-lg-3" style="text-align:center;">
                                @if($data['photo_id']==$photo_id)
                                <div>
                                    <label for="{{$data['image_id']}}">

                                        <img src="{{route('download', $data['path'])}}" width="90%" alt="" for="{{$data['image_id']}}">

                                    </label>
                                </div>
                                <div>
                                    <input onchange="changeDisabled()" type="checkbox" name="checkbox[]" value="{{$data['image_id']}}" id="{{$data['image_id']}}" />
                                </div>
                                @endif
                            </div>
                            @endforeach

                        </div>
                        <button id="image-delete" type="submit" class="float-right btn btn-danger btn-danger-style" disabled>
                            <i class='fas fa-trash-alt'></i><span class="ml-3">{{__('customize.Delete')}}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="row justify-content-center">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card" style="margin: 10px 0px;">
            <div class="card-header">
                <h4>{{$photo->name}}</h4>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <img src="{{route('download', $photo['path'])}}" width="50%" alt="">
                    </div>
                    <div class="col-md-6">

                        {{$photo->name}}
                        <form action="delete" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-primary">{{__('customize.Delete')}}</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form action="show/review" method="post" enctype="multipart/form-data" onsubmit="return check_create();">
                            @csrf
                            <li><label class="col-form-label" for="path">image</label></li>
                            <input multiple="multiple" accept="image/jpeg,image/gif,image/png" type="file" id="path[]" name="path[]" class="form-control{{ $errors->has('path') ? ' is-invalid' : '' }}">
                            @if ($errors->has('path'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('path') }}</strong>
                            </span> @endif
                            <div style="float: right;">
                                <button type="submit" class="btn btn-primary">{{__('customize.Save')}}</button>
                            </div>
                        </form>

                    </div>
                    <div class="col-md-6"></div>
                    <form action="delete/image" method="POST" onsubmit="return check_delete();">
                        @method('DELETE')
                        @csrf
                        <button id="image-delete" type="submit" class="btn btn-primary" disabled>{{__('customize.Delete')}}</button>
                        @foreach($image as $data)
                        <div class="col-md-3">
                            @if($data['photo_id']==$photo_id)
                            <img src="{{route('download', $data['path'])}}" width="100%" alt="">
                            <input onchange="changeDisabled()" type="checkbox" name="checkbox[]" value="{{$data['image_id']}}" id="{{$data['image_id']}}" />
                            @endif
                        </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                是否刪除此相簿(包含所有相片)?
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
<!-- <div class="modal fade" id="deleteModal2" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                是否刪除?
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">否</button>
                <form action="delete/image" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">是</button>
                </form>
            </div>
        </div>
    </div>
</div> -->
@stop

@section('script')
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    function changeDisabled() {
        if ($("input[name='checkbox[]']:checked").length == 0) {
            $("#image-delete").attr("disabled", true);
        } else {
            $("#image-delete").attr("disabled", false);
        }
    }

    function check_delete() {

        if ($("input[name='checkbox[]']:checked").length == 0) {
            return false
        } else {
            return true
        }
    }

    function check_create() {

        var file = document.querySelector('input[type=file]').files;
        if (file.length == 0) {
            return false
        } else {
            return true
        }
    }
</script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop