@extends('layouts.app')
@section('content')

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3">
            <h2>實名制</h2>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <div class="col-lg-3">
        <form action="/grvCode/create" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <div class="col-lg-12 form-group">
                    <label class="label-style col-form-label" for="name">姓名</label>
                    <input placeholder="請輸入姓名" autocomplete="off" type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                    @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 form-group">
                    <label class="label-style col-form-label" for="identity_card">身分證字號</label>
                    <input placeholder="請輸入身分證字號" autocomplete="off" type="text" id="identity_card" name="identity_card" class="form-control{{ $errors->has('identity_card') ? ' is-invalid' : '' }}" value="{{ old('identity_card') }}" required>
                    @if ($errors->has('identity_card'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('identity_card') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" onchange="acceptPrivacy()">
                <label class="form-check-label" for="defaultCheck1">
                    接受本服務的 <a href="javascript:void(0);" data-toggle="modal" data-target="#privacyModal">隱私權政策</a>
                </label>
            </div>
            <div class="md-5 d-flex justify-content-center" >
                <button id="test" type="submit" class="btn btn-primary btn-primary-style" disabled>取得通行碼</button>
            </div>



        </form>
    </div>
</div>
<div class="modal fade" id="privacyModal" tabindex="-1" role="dialog" aria-labelledby="privacyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="privacyModal">隱私權政策</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>
                    收集之個人資訊，僅限本次COVID-19（新冠肺炎）防疫措施產製實聯(名)制場管系統使用，並遵守個人資料保護法相關規定，保障您的個資，請填報您本人正確、最新的個資，不得濫用他人之個資，必要時可供服務人員查驗，勾選「接受本服務的隱私權政策」表示您接受本內容。
                </h4>
            </div>

        </div>
    </div>
</div>
@stop

@section('javascript')
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    function acceptPrivacy() {
        
        var value = document.getElementById("defaultCheck1").checked

        if (value == true) {
            $("#test").attr("disabled", false);
        } else {
            $("#test").attr("disabled", true);
        }
    }
</script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop