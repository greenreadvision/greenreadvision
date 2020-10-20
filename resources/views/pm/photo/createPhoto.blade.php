@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
    <form action="create/review" method="post" enctype="multipart/form-data">
                    <!-- <input type="file"> -->
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label  class="label-style col-form-label" for="type">類型</label>
                            <select type="text" id="type" name="type" class="form-control" autofocus>
                                <option value="hakka">客家文化</option>
                                <option value="read">閱讀</option>
                                <option value="child">親子活動</option>
                                <option value="operation">營運類</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="label-style col-form-label" for="name">名稱</label>
                            <input autocomplete="off" type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                            @if ($errors->has('company'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <label class="label-style col-form-label" for="path">主視覺</label>
                            <input  onchange="previewFile()" accept="image/jpeg,image/gif,image/png" type="file" id="path" name="path" class="form-control{{ $errors->has('path') ? ' is-invalid' : '' }}">
                           
                            @if ($errors->has('path'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('path') }}</strong>
                            </span> @endif
                        </div>
                        <div class="col-lg-6" style="padding:2%">
                            <img src="" width="100%">
                        </div>
                    </div>
                   
                    <div style="float: right;">
                        <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
                    </div>
                </form>
    </div>
</div>


@stop
@section('javascript')
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>

function previewFile() {
//   var preview = document.querySelector('img');
//   var file    = document.querySelector('input[type=file]').files[0];
//   var reader  = new FileReader();

//   reader.onloadend = function () {
//     preview.src = reader.result;
//   }

//   if (file) {
//     reader.readAsDataURL(file);
//   } else {
//     preview.src = "";
//   }
}
</script>
    <script src="{{ URL::asset('js/grv.js') }}"></script>

@stop