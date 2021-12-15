@extends('layouts.app')
@section('content')


<div class="col-lg-12">
    <div style="text-align:center;">
        <p style="font-size: 30px">填寫員工基本資料表</p>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
            <form name="recruitForm" action="/train/first/review" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="user_name_CH">中文名稱</label>
                        <input autocomplete="off" type="text" id="user_name_CH" name="user_name_CH" class="form-control{{ $errors->has('user_name_CH') ? ' is-invalid' : '' }}" value="{{\Auth::user()->name}}" required>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="sex">性別</label>
                        <select type="text" id="sex" name="sex" class="form-control">
                            <option value="men">男性</option>
                            <option value="women">女性</option>
                            <option value="other">其他</option>
                        </select>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="user_name_EN">英文名稱(護照名稱)</label>
                        <input autocomplete="off" type="text" id="user_name_EN" name="user_name_EN" class="form-control{{ $errors->has('user_name_EN') ? ' is-invalid' : '' }}" value="{{old('user_name_EN')}}" required>
                        @if ($errors->has('user_name_EN'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('user_name_EN') }}</strong>
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
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="nickname">公司別名(動物名)</label>
                        <input autocomplete="off" type="text" id="nickname" name="nickname" class="form-control{{ $errors->has('nickname') ? ' is-invalid' : '' }}" value="{{old('nickname')}}" required>
                        @if ($errors->has('nickname'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('nickname') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="work_position">工作名稱(工作類型)</label>
                        <input autocomplete="off" type="text" id="work_position" name="work_position" class="form-control{{ $errors->has('work_position') ? ' is-invalid' : '' }}" value="{{old('work_position')}}" required>
                        @if ($errors->has('work_position'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('work_position') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="Email">電子信箱</label>
                        <input autocomplete="off" type="email" id="Email" name="Email" class="form-control{{ $errors->has('Email') ? ' is-invalid' : '' }}" value="{{\Auth::user()->email}}" required>
                        @if ($errors->has('Email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('Email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="photo_path">證件照(大頭照)</label>
                        <input accept="image/*" type="file" name="photo_path" id="photo_path" class="form-control{{ $errors->has('photo_path') ? ' is-invalid' : '' }}" />
                        @if ($errors->has('photo_path'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('photo_path') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="phone">聯絡電話</label>
                        <input autocomplete="off" type="text" id="phone" name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{old('phone')}}" required>
                        @if ($errors->has('phone'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="celephone">手機電話</label>
                        <input autocomplete="off"  type="text" id="celephone" name="celephone" class="form-control{{ $errors->has('celephone') ? ' is-invalid' : '' }}" value="{{old('celephone')}}" required>
                        @if ($errors->has('celephone'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('celephone') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="row col-lg-6 form-group" style="margin:auto;">
                        <label class="label-style col-12">婚姻狀況</label>                    
                        <label class="label-style col-6 col-form-label" for="marry_true"><input type="radio" id="marry_true" name="marry" value="1" class="{{ $errors->has('marry') ? ' is-invalid' : '' }}"{{old('marry')? 'checked': ''}} checked>已婚</label>
                        <label class="label-style col-6 col-form-label" for="marry_flase"><input type="radio" id="marry_flase" name="marry" value="0" class="{{ $errors->has('marry') ? ' is-invalid' : '' }}"{{old('marry')? 'checked': ''}}>未婚</label>
                        @if ($errors->has('marry'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('marry') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="IDcard_number">身分證字號</label>
                        <input autocomplete="off" maxlength="10" type="text" id="IDcard_number" name="IDcard_number" class="form-control{{ $errors->has('IDcard_number') ? ' is-invalid' : '' }}" value="{{old('IDcard_number')}}" required>
                        @if ($errors->has('IDcard_number'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('IDcard_number') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="first_day">到職日(第一天上班日)</label>
                        <input autocomplete="off" type="date" id="first_day" name="first_day" class="form-control{{ $errors->has('first_day') ? ' is-invalid' : '' }}" value="{{old('first_day')}}" required>
                        @if ($errors->has('first_day'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('first_day') }}</strong>
                        </span>
                        @endif
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
                        <label class="label-style col-form-label" for="contact_person_1_name">緊急聯絡人1 名稱(必填)</label>
                        <input autocomplete="off" type="text" id="contact_person_1_name	" name="contact_person_1_name" class="form-control{{ $errors->has('contact_person_1_name') ? ' is-invalid' : '' }}" value="{{old('contact_person_1_name')}}" required>
                        @if ($errors->has('contact_person_1_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('contact_person_1_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="contact_person_1_phone">緊急聯絡人1 電話(必填)</label>
                        <input autocomplete="off" type="text" id="contact_person_1_phone	" name="contact_person_1_phone" class="form-control{{ $errors->has('contact_person_1_phone') ? ' is-invalid' : '' }}" value="{{old('contact_person_1_phone')}}" required>
                        @if ($errors->has('contact_person_1_phone'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('contact_person_1_phone') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="contact_person_2_name">緊急聯絡人2 名稱(選填)</label>
                        <input autocomplete="off" type="text" id="contact_person_2_name	" name="contact_person_2_name" class="form-control">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="contact_person_2_phone">緊急聯絡人2 電話(選填)</label>
                        <input autocomplete="off" maxlength="10" pattern="[0-9]" type="text" id="contact_person_2_phone	" name="contact_person_2_phone" class="form-control">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="front_of_IDcard_path">身分證正面</label>
                        <input accept="image/*" type="file" name="front_of_IDcard_path" id="front_of_IDcard_path" class="form-control{{ $errors->has('front_of_IDcard_path') ? ' is-invalid' : '' }}" />
                        @if ($errors->has('front_of_IDcard_path'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('front_of_IDcard_path') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="back_of_IDcard_path">身分證背面</label>
                        <input accept="image/*" type="file" name="back_of_IDcard_path" id="back_of_IDcard_path" class="form-control{{ $errors->has('back_of_IDcard_path') ? ' is-invalid' : '' }}" />
                        @if ($errors->has('back_of_IDcard_path'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('back_of_IDcard_path') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="front_of_healthCard_path">健保卡正面</label>
                        <input accept="image/*" type="file" name="front_of_healthCard_path" id="front_of_healthCard_path" class="form-control{{ $errors->has('front_of_healthCard_path') ? ' is-invalid' : '' }}" />
                        @if ($errors->has('front_of_healthCard_path'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('front_of_healthCard_path') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="back_of_healthCard_path">健保卡背面</label>
                        <input accept="image/*" type="file" name="back_of_healthCard_path" id="back_of_healthCard_path" class="form-control{{ $errors->has('back_of_healthCard_path') ? ' is-invalid' : '' }}" />
                        @if ($errors->has('back_of_healthCard_path'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('back_of_healthCard_path') }}</strong>
                        </span> @endif
                    </div>
                    <div class="md-5 col-lg-6 form-group" style="float: right;">
                        <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
                    </div>
                </div>
                
            </form>
    </div>
</div>
@endsection


