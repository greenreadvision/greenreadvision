@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body ">
                    <div class="col-lg-12">
                        <div style="text-align:center;">
                            <p style="font-size: 30px">填寫員工基本資料表</p>
                        </div>
                        <form name="recruitForm" action="basicInformation/store" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row ">
                                <div class="col-lg-8">
                                    <div class="form-group row mb-0">
                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="name">姓名</label>
                                            <input autocomplete="off" type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{old('name')}}" required>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="sex">性別</label>
                                            <select type="text" id="sex" name="sex" class="form-control">
                                                <option value=""></option>
                                                <option value="M" {{old('sex')== "M"?'selected': ''}}>男</option>
                                                <option value="F" {{old('sex') == "F"?'selected': ''}}>女</option>
                                                <option value="other" {{old('other') == "F"? 'selected': ''}}>其他</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="EN_name">英文名稱(護照名稱)</label>
                                            <input autocomplete="off" type="text" id="EN_name" name="EN_name" class="form-control{{ $errors->has('EN_name') ? ' is-invalid' : '' }}" value="{{old('EN_name')}}" required>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="IDcard_number">身分證字號</label>
                                            <input autocomplete="off" maxlength="10" type="text" id="ID_number" name="ID_number" class="form-control{{ $errors->has('ID_number') ? ' is-invalid' : '' }}" value="{{old('ID_number')}}" required>
                                            @if ($errors->has('ID_number'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('ID_number') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="nickname">綽號</label>
                                            <input autocomplete="off" type="text" id="nickname" name="nickname" class="form-control{{ $errors->has('nickname') ? ' is-invalid' : '' }}" value="{{old('nickname')}}" required>
                                            @if ($errors->has('nickname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nickname') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="birthday">生日</label>
                                            <input type="date" id="birthday" name="birthday" class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}" value="{{ old('birthday') }}" required>
                                            @if ($errors->has('birthday'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('birthday') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group row mb-0 h-100">

                                        <div id="ID_photo_div" class="col-lg-12 form-group">
                                            <label id="ID_photo_label" class="input-photo-label label-style col-form-label" for="ID_photo">
                                                <small>上傳大頭照</small>
                                                <input accept="image/*" type="file" name="ID_photo" id="ID_photo" class="input-photo-input py-0 form-control{{ $errors->has('ID_photo') ? ' is-invalid' : '' }}" />
                                            </label>
                                            <!-- @if ($errors->has('ID_photo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('ID_photo') }}</strong>
                                            </span> @endif -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <div class="col-lg-4 form-group">
                                            <label class="label-style col-form-label" for="email">電子信箱</label>
                                            <input autocomplete="off" type="email" id="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{old('email')}}" required>
                                            @if ($errors->has('Email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('Email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label class="label-style col-form-label" for="phone">聯絡電話</label>
                                            <input autocomplete="off" type="text" id="phone" name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{old('phone')}}" required>
                                            @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label class="label-style col-form-label" for="celephone">手機電話</label>
                                            <input autocomplete="off" type="text" id="celephone" name="celephone" class="form-control{{ $errors->has('celephone') ? ' is-invalid' : '' }}" value="{{old('celephone')}}" required>
                                            @if ($errors->has('celephone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('celephone') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label class="label-style col-form-label" for="work_position">工作職稱</label>
                                            <input autocomplete="off" type="text" id="work_position" name="work_position" class="form-control{{ $errors->has('work_position') ? ' is-invalid' : '' }}" value="{{old('work_position')}}" required>
                                            @if ($errors->has('work_position'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('work_position') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        <div class="col-lg-4 form-group">
                                            <label class="label-style col-form-label" for="arrival_date">到職日期</label>
                                            <input autocomplete="off" type="date" id="arrival_date" name="arrival_date" class="form-control{{ $errors->has('arrival_date') ? ' is-invalid' : '' }}" value="{{old('arrival_date')}}" required>
                                            @if ($errors->has('first_day'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('first_day') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class=" col-lg-4 form-group">
                                            <label class="label-style col-form-label">婚姻狀況</label>
                                            <div class="d-flex justify-content-around" style="padding: .375rem .75rem">
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="marry_true" name="is_marry" value="1" class="{{ $errors->has('is_marry') ? ' is-invalid' : '' }}" {{old('is_marry')==1? 'checked': ''}} required>
                                                    <label class="form-check-label ml-1" for="marry_true">已婚</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="marry_flase" name="is_marry" value="0" class="{{ $errors->has('is_marry') ? ' is-invalid' : '' }}" {{old('is_marry')==0? 'checked': ''}}>
                                                    <label class="form-check-label ml-1" for="marry_flase">未婚</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <label class="label-style col-form-label" for="residence_address">戶籍地址</label>
                                            <input autocomplete="off" type="text" id="residence_address" name="residence_address" class="form-control{{ $errors->has('residence_address') ? ' is-invalid' : '' }}" value="{{old('residence_address')}}" required>
                                            @if ($errors->has('residence_address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('residence_address') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <label class="label-style col-form-label" for="contact_address">聯絡地址</label>
                                            <input autocomplete="off" type="text" id="contact_address" name="contact_address" class="form-control{{ $errors->has('contact_address') ? ' is-invalid' : '' }}" value="{{old('contact_address')}}" required>
                                            @if ($errors->has('contact_address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('contact_address') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="contact_person_name_1">緊急聯絡人1 名稱(必填)</label>
                                            <input autocomplete="off" type="text" id="contact_person_name_1	" name="contact_person_name_1" class="form-control{{ $errors->has('contact_person_name_1') ? ' is-invalid' : '' }}" value="{{old('contact_person_name_1')}}" required>
                                            @if ($errors->has('contact_person_name_1'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('contact_person_name_1') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="contact_person_phone_1">緊急聯絡人1 電話(必填)</label>
                                            <input autocomplete="off" type="text" id="contact_person_phone_1	" name="contact_person_phone_1" class="form-control{{ $errors->has('contact_person_phone_1') ? ' is-invalid' : '' }}" value="{{old('contact_person_phone_1')}}" required>
                                            @if ($errors->has('contact_person_phone_1'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('contact_person_phone_1') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="contact_person_name_2">緊急聯絡人2 名稱(選填)</label>
                                            <input autocomplete="off" type="text" id="contact_person_name_2	" name="contact_person_name_2" class="form-control" value="{{old('contact_person_name_2')}}">
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="contact_person_phone_2">緊急聯絡人2 電話(選填)</label>
                                            <input autocomplete="off" maxlength="10" pattern="[0-9]" type="text" id="contact_person_phone_2	" name="contact_person_phone_2" class="form-control" value="{{old('contact_person_phone_2')}}">
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label id="IDcard_front_label" class="label-style col-form-label input-photo-label" for="IDcard_front_path">
                                                <small>上傳身分證正面</small>
                                                <input accept="image/*" type="file" name="IDcard_front_path" id="IDcard_front_path" class="input-photo-input input-photo-input form-control{{ $errors->has('IDcard_front_path') ? ' is-invalid' : '' }}" />
                                                <!-- @if ($errors->has('IDcard_front_path'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('IDcard_front_path') }}</strong>
                                                </span> @endif -->
                                            </label>

                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label id="IDcard_back_label" class="label-style col-form-label input-photo-label" for="IDcard_back_path">
                                                <small>上傳身分證背面</small>
                                                <input accept="image/*" type="file" name="IDcard_back_path" id="IDcard_back_path" class="input-photo-input form-control{{ $errors->has('IDcard_back_path') ? ' is-invalid' : '' }}" />
                                                <!-- @if ($errors->has('IDcard_back_path'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('IDcard_back_path') }}</strong>
                                                </span> @endif -->
                                            </label>

                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label id="healthCard_front_label" class="label-style col-form-label input-photo-label" for="healthCard_front_path">
                                                <small>上傳健保卡正面</small>
                                                <input accept="image/*" type="file" name="healthCard_front_path" id="healthCard_front_path" class="input-photo-input form-control{{ $errors->has('healthCard_front_path') ? ' is-invalid' : '' }}" />
                                                <!-- @if ($errors->has('healthCard_front_path'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('healthCard_front_path') }}</strong>
                                                </span> @endif -->
                                            </label>

                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label id="healthCard_back_label" class="label-style col-form-label input-photo-label" for="healthCard_back_path">
                                                <small>上傳健保卡背面</small>
                                                <input  accept="image/*" type="file" name="healthCard_back_path" id="healthCard_back_path" class="input-photo-input form-control{{ $errors->has('healthCard_back_path') ? ' is-invalid' : '' }}" />
                                                <!-- @if ($errors->has('healthCard_back_path'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('healthCard_back_path') }}</strong>
                                                </span> @endif -->
                                            </label>

                                        </div>

                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="bank">銀行名稱</label>
                                            <input autocomplete="off" type="text" id="bank" name="bank" class="form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{old('bank')}}" required>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="bank_branch">銀行分行</label>
                                            <input autocomplete="off" type="text" id="bank_branch" name="bank_branch" class="form-control{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{old('bank_branch')}}" required>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="bank_account_number">銀行帳號</label>
                                            <input autocomplete="off" type="text" id="bank_account_number" name="bank_account_number" class="form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{old('bank_account_number')}}" required>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label class="label-style col-form-label" for="bank_account_name">銀行戶名</label>
                                            <input autocomplete="off" type="text" id="bank_account_name" name="bank_account_name" class="form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" value="{{old('bank_account_name')}}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="float-right">
                                <button type="submit" class="btn btn-green rounded-pill">{{__('customize.Save')}}</button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#ID_photo_label').height($('#ID_photo_div').outerHeight() - parseInt($('#ID_photo_label').css('padding-top')) * 2)
        $('#IDcard_front_label').height($('#IDcard_front_label').width() * 11 / 17)
        $('#IDcard_back_label').height($('#IDcard_back_label').width() * 11 / 17)
        $('#healthCard_front_label').height($('#healthCard_front_label').width() * 11 / 17)
        $('#healthCard_back_label').height($('#healthCard_back_label').width() * 11 / 17)
        $('input').on('change', function(e) {
            id = e.target.id
            const file = this.files[0];

            const fr = new FileReader();
            fr.onload = function(e) {
                if (id.indexOf('path') == -1) {
                    $("#" + id + "_label").css("background-image", "url(" + e.target.result + ")");
                    $("#" + id + "_label small").css("display", "none");

                } else {
                    $("#" + id.split('path')[0]+ "label").css("background-image", "url(" + e.target.result + ")");
                    $("#" + id.split('path')[0]+ "label small").css("display", "none");

                }
            };

            // 使用 readAsDataURL 將圖片轉成 Base64
            fr.readAsDataURL(file);
        });
    });
    window.onresize = (function() {
        $('#ID_photo_label').height($('#ID_photo_div').outerHeight() - parseInt($('#ID_photo_label').css('padding-top')) * 2)
        $('#IDcard_front_label').height($('#IDcard_front_label').width() * 11 / 17)
        $('#IDcard_back_label').height($('#IDcard_back_label').width() * 11 / 17)
        $('#healthCard_front_label').height($('#healthCard_front_label').width() * 11 / 17)
        $('#healthCard_back_label').height($('#healthCard_back_label').width() * 11 / 17)
    })
</script>
@stop