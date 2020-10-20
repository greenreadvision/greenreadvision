@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <form name="invoiceForm" action="create/review" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="id">採購單號</label>
                    <input autocomplete="off" type="text" id="id" name="id" class="form-control{{ $errors->has('id') ? ' is-invalid' : '' }}" value="{{$id}}" required readOnly>
                </div>

                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="applicant">採購人</label>
                    <input autocomplete="off" type="text" id="applicant" name="applicant" class="form-control{{ $errors->has('applicant') ? ' is-invalid' : '' }}" value="{{\Auth::user()->name}}" required>
                    @if ($errors->has('applicant'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('applicant') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                    <select type="text" id="project_id" name="project_id" class="form-control">
                        @foreach ($projects as $project)
                        @if($project['name']!='其他')
                        <option value="{{$project['project_id']}}">{{$project['name']}}</option>
                        @endif
                        @endforeach
                        <option value="qs8dXg88gPm">其他</option>
                    </select>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="purchase_date">採購日期</label>
                    <input type="date" id="purchase_date" name="purchase_date" class="form-control{{ $errors->has('purchase_date') ? ' is-invalid' : '' }}" value="{{ old('purchase_date') }}" required>
                    @if ($errors->has('purchase_date'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('purchase_date') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="company">廠商名稱</label>
                    <input autocomplete="off" type="text" id="company1" name="company1" class="form-control{{ $errors->has('company1') ? ' is-invalid' : '' }}" value="{{ old('company1') }}" required>
                    @if ($errors->has('company'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('company') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="delivery_date">交貨日期</label>
                    <input type="date" id="delivery_date" name="delivery_date" class="form-control{{ $errors->has('delivery_date') ? ' is-invalid' : '' }}" value="{{ old('delivery_date') }}" required>
                    @if ($errors->has('delivery_date'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('delivery_date') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="contact_person">聯絡人</label>
                    <input autocomplete="off" type="text" id="contact_person" name="contact_person" class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" value="{{ old('contact_person') }}" required>
                    @if ($errors->has('contact_person'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('contact_person') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="address">送貨地址</label>
                    <input autocomplete="off" type="text" id="address" name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address') }}" required>
                    @if ($errors->has('address'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <div class=" form-group">
                        <label class="label-style col-form-label" for="phone">電話 <span style="font-size:.9rem">例 : 0287726321</span></label>
                        <input autocomplete="off" type="text" id="phone" name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" required>
                        @if ($errors->has('phone'))
                        <span class="invalid-feedback" role="alert">
                            <strong>請照範例填寫</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="label-style col-form-label" for="fax">傳真</label>
                        <input autocomplete="off" type="text" id="fax" name="fax" class="form-control{{ $errors->has('fax') ? ' is-invalid' : '' }}" value="{{ old('fax') }}" required>
                        @if ($errors->has('fax'))
                        <span class="invalid-feedback" role="alert">
                            <strong>請照範例填寫</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="note">備註(50字以內)</label>
                    <textarea id="note" name="note" rows="5" style="resize:none;" class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}">{{ old('note') }}</textarea>
                    @if ($errors->has('note'))
                    <span class="invalid-feedback" role="alert">
                        <strong>超出50個字</strong>
                    </span>
                    @endif
                </div>

                <div class="col-lg-12 form-group">
                    <table width="100%">
                        <thead>
                            <tr class="bg-dark text-white" style="text-align:center">
                                <th class="px-2" width="5%">
                                <!-- <button type="button" onclick="addElementDiv('addItem')">+</button> -->
                                </th>
                                <th class="px-2" width="30%"> <label class="label-style col-form-label" for="content">品名</label></th>
                                <th class="px-2" width="10%"><label class="label-style col-form-label" for="quantity">數量</label></th>
                                <th class="px-2" width="25%"><label class="label-style col-form-label" for="price">單價</label></th>
                                <th class="px-2" width="30%"><label class="label-style col-form-label" for="amount">備註</label></th>
                            </tr>
                        </thead>
                        <tbody id="addItem">
                            <tr>
                                <th class="p-2"></th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="content-0" name="content-0" class="form-control{{ $errors->has('content-0') ? ' is-invalid' : '' }}" value="{{ old('content-0') }}" required>
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="quantity-0" name="quantity-0" class="form-control{{ $errors->has('quantity-0') ? ' is-invalid' : '' }}" value="{{ old('quantity-0') }}" required>
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="price-0" name="price-0" class="form-control{{ $errors->has('price-0') ? ' is-invalid' : '' }}" value="{{ old('price-0') }}" required>
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="note-0" name="note-0" class="form-control{{ $errors->has('note-0') ? ' is-invalid' : '' }}" value="{{ old('note-0') }}">
                                </th>
                            </tr>
                            <tr>
                                <th class="p-2"></th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="content-1" name="content-1" class="form-control{{ $errors->has('content-1') ? ' is-invalid' : '' }}" value="{{ old('content-1') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="quantity-1" name="quantity-1" class="form-control{{ $errors->has('quantity-1') ? ' is-invalid' : '' }}" value="{{ old('quantity-1') }}">

                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="price-1" name="price-1" class="form-control{{ $errors->has('price-1') ? ' is-invalid' : '' }}" value="{{ old('price-1') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="note-1" name="note-1" class="form-control{{ $errors->has('note-1') ? ' is-invalid' : '' }}" value="{{ old('note-1') }}">
                                </th>
                            </tr>
                            <tr>
                                <th class="p-2"></th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="content-2" name="content-2" class="form-control{{ $errors->has('content-2') ? ' is-invalid' : '' }}" value="{{ old('content-2') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="quantity-2" name="quantity-2" class="form-control{{ $errors->has('quantity-2') ? ' is-invalid' : '' }}" value="{{ old('quantity-2') }}">

                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="price-2" name="price-2" class="form-control{{ $errors->has('price-2') ? ' is-invalid' : '' }}" value="{{ old('price-2') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="note-2" name="note-2" class="form-control{{ $errors->has('note-2') ? ' is-invalid' : '' }}" value="{{ old('note-2') }}">
                                </th>
                            </tr>
                            <tr>
                                <th class="p-2"></th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="content-3" name="content-3" class="form-control{{ $errors->has('content-3') ? ' is-invalid' : '' }}" value="{{ old('content-3') }}">
                                </th>

                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="quantity-3" name="quantity-3" class="form-control{{ $errors->has('quantity-3') ? ' is-invalid' : '' }}" value="{{ old('quantity-3') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="price-3" name="price-3" class="form-control{{ $errors->has('price-3') ? ' is-invalid' : '' }}" value="{{ old('price-3') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="note-3" name="note-3" class="form-control{{ $errors->has('note-3') ? ' is-invalid' : '' }}" value="{{ old('note-3') }}">
                                </th>
                            </tr>
                            <tr>
                                <th class="p-2"></th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="content-4" name="content-4" class="form-control{{ $errors->has('content-4') ? ' is-invalid' : '' }}" value="{{ old('content-4') }}">
                                </th>

                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="quantity-4" name="quantity-4" class="form-control{{ $errors->has('quantity-4') ? ' is-invalid' : '' }}" value="{{ old('quantity-4') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="price-4" name="price-4" class="form-control{{ $errors->has('price-4') ? ' is-invalid' : '' }}" value="{{ old('price-4') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="note-4" name="note-4" class="form-control{{ $errors->has('note-4') ? ' is-invalid' : '' }}" value="{{ old('note-4') }}">
                                </th>
                            </tr>
                            <tr>
                                <th class="p-2"></th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="content-5" name="content-5" class="form-control{{ $errors->has('content-5') ? ' is-invalid' : '' }}" value="{{ old('content-5') }}">
                                </th>

                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="quantity-5" name="quantity-5" class="form-control{{ $errors->has('quantity-5') ? ' is-invalid' : '' }}" value="{{ old('quantity-5') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="price-5" name="price-5" class="form-control{{ $errors->has('price-5') ? ' is-invalid' : '' }}" value="{{ old('price-5') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="note-5" name="note-5" class="form-control{{ $errors->has('note-5') ? ' is-invalid' : '' }}" value="{{ old('note-5') }}">
                                </th>
                            </tr>
                            <tr>
                                <th class="p-2"></th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="content-6" name="content-6" class="form-control{{ $errors->has('content-6') ? ' is-invalid' : '' }}" value="{{ old('content-6') }}">
                                </th>

                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="quantity-6" name="quantity-6" class="form-control{{ $errors->has('quantity-6') ? ' is-invalid' : '' }}" value="{{ old('quantity-6') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="price-6" name="price-6" class="form-control{{ $errors->has('price-6') ? ' is-invalid' : '' }}" value="{{ old('price-6') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="note-6" name="note-6" class="form-control{{ $errors->has('note-6') ? ' is-invalid' : '' }}" value="{{ old('note-6') }}">
                                </th>
                            </tr>
                            <tr>
                                <th class="p-2"></th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="content-7" name="content-7" class="form-control{{ $errors->has('content-7') ? ' is-invalid' : '' }}" value="{{ old('content-7') }}">
                                </th>

                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="quantity-7" name="quantity-7" class="form-control{{ $errors->has('quantity-7') ? ' is-invalid' : '' }}" value="{{ old('quantity-7') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="price-7" name="price-7" class="form-control{{ $errors->has('price-7') ? ' is-invalid' : '' }}" value="{{ old('price-7') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="note-7" name="note-7" class="form-control{{ $errors->has('note-7') ? ' is-invalid' : '' }}" value="{{ old('note-7') }}">
                                </th>
                            </tr>
                            <tr>
                                <th class="p-2"></th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="content-8" name="content-8" class="form-control{{ $errors->has('content-8') ? ' is-invalid' : '' }}" value="{{ old('content-8') }}">
                                </th>

                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="quantity-8" name="quantity-8" class="form-control{{ $errors->has('quantity-8') ? ' is-invalid' : '' }}" value="{{ old('quantity-8') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="price-8" name="price-8" class="form-control{{ $errors->has('price-8') ? ' is-invalid' : '' }}" value="{{ old('price-8') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="note-8" name="note-8" class="form-control{{ $errors->has('note-8') ? ' is-invalid' : '' }}" value="{{ old('note-8') }}">
                                </th>
                            </tr>
                            <tr>
                                <th class="p-2"></th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="content-9" name="content-9" class="form-control{{ $errors->has('content-9') ? ' is-invalid' : '' }}" value="{{ old('content-9') }}">
                                </th>

                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="quantity-9" name="quantity-9" class="form-control{{ $errors->has('quantity-9') ? ' is-invalid' : '' }}" value="{{ old('quantity-9') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="price-9" name="price-9" class="form-control{{ $errors->has('price-9') ? ' is-invalid' : '' }}" value="{{ old('price-9') }}">
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="note-9" name="note-9" class="form-control{{ $errors->has('note-9') ? ' is-invalid' : '' }}" value="{{ old('note-9') }}">
                                </th>
                            </tr>
                        </tbody>
                    </table>

                </div>



            </div>
            <div class="md-5" style="float: right;">
                <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
            </div>


        </form>

    </div>
</div>
@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    var $i = 0;

    function addElementDiv(obj) {
        $i++;
        console.log($i)
        var parent = document.getElementById(obj);
        //新增 div
        var div = document.createElement("tr");
        //設定 div 屬性，如 id

        div.innerHTML = '<th class="p-2"></th>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="content-' + $i + '" name="content-' + $i + '" class="form-control{{ $errors->has("content") ? " is-invalid" : "" }}" value="{{ old("content") }}"></th>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="quantity-' + $i + '" name="quantity-' + $i + '" class="form-control{{ $errors->has("quantity") ? " is-invalid" : "" }}" value="{{ old("quantity") }}"></th>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="price-' + $i + '" name="price-' + $i + '" class="form-control{{ $errors->has("price") ? " is-invalid" : "" }}" value="{{ old("price") }}"></th>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="note-' + $i + '" name="note-' + $i + '" class="form-control{{ $errors->has("note") ? " is-invalid" : "" }}" value="{{ old("note") }}"></th>'
        parent.appendChild(div);
    }
</script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop