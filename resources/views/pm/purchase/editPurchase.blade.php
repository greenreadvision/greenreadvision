@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <form action="update" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group row">
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="id">採購單號</label>
                    <input autocomplete="off" type="text" id="id" name="id" class="form-control{{ $errors->has('id') ? ' is-invalid' : '' }}" value="{{$purchase->id}}" required readOnly>
                </div>

                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="applicant">採購人</label>
                    <input autocomplete="off" type="text" id="applicant" name="applicant" class="form-control{{ $errors->has('applicant') ? ' is-invalid' : '' }}" value="{{$purchase->applicant}}" required>
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
                        <option value="{{$project['project_id']}}" {{$project['selected']}}>{{$project['name']}}</option>
                        @endif
                        @endforeach
                        @foreach ($projects as $project)
                        @if($project['name']=='其他')
                        <option value="qs8dXg88gPm"  {{$project['selected']}}>其他</option>
                        @endif
                        @endforeach
                       
                    </select>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="purchase_date">採購日期</label>
                    <input type="date" id="purchase_date" name="purchase_date" class="form-control{{ $errors->has('purchase_date') ? ' is-invalid' : '' }}" value="{{ $purchase->purchase_date }}" required>
                    @if ($errors->has('purchase_date'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('purchase_date') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="company1">廠商名稱</label>
                    <input autocomplete="off" type="text" id="company1" name="company" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" value="{{ $purchase->company }}" required>
                    @if ($errors->has('company'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('company') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="delivery_date">交貨日期</label>
                    <input type="date" id="delivery_date" name="delivery_date" class="form-control{{ $errors->has('delivery_date') ? ' is-invalid' : '' }}" value="{{ $purchase->delivery_date}}" required>
                    @if ($errors->has('delivery_date'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('delivery_date') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="contact_person">聯絡人</label>
                    <input autocomplete="off" type="text" id="contact_person" name="contact_person" class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" value="{{ $purchase->contact_person }}" required>
                    @if ($errors->has('contact_person'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('contact_person') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="address">送貨地址</label>
                    <input autocomplete="off" type="text" id="address" name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ $purchase->address }}" required>
                    @if ($errors->has('address'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-lg-6 form-group">
                    <div class=" form-group">
                        <label class="label-style col-form-label" for="phone">電話 <span style="font-size:.9rem">例 : 0287726321</span></label>
                        <input autocomplete="off" type="text" id="phone" name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ $purchase->phone }}" required>
                        @if ($errors->has('phone'))
                        <span class="invalid-feedback" role="alert">
                            <strong>請照範例填寫</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="label-style col-form-label" for="fax">傳真</label>
                        <input autocomplete="off" type="text" id="fax" name="fax" class="form-control{{ $errors->has('fax') ? ' is-invalid' : '' }}" value="{{ $purchase->fax }}" required>
                        @if ($errors->has('fax'))
                        <span class="invalid-feedback" role="alert">
                            <strong>請照範例填寫</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 form-group">
                    <label class="label-style col-form-label" for="note">備註(50字以內)</label>
                    <textarea id="note" name="note" rows="5" style="resize:none;" class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}">{{ $purchase->note}}</textarea>
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
                                <th class="px-2" width="5%"><button type="button" onclick="addElementDiv('addItem')">+</button></th>
                                <th class="px-2" width="30%"> <label class="label-style col-form-label" for="content">品名</label></th>
                                <th class="px-2" width="10%"><label class="label-style col-form-label" for="quantity">數量</label></th>
                                <th class="px-2" width="25%"><label class="label-style col-form-label" for="price">單價</label></th>
                                <th class="px-2" width="30%"><label class="label-style col-form-label" for="amount">備註</label></th>
                            </tr>
                        </thead>
                        <tbody id="addItem">
                            @foreach($purchase_item as $item)
                            <tr>
                                <th class="px-2" width="5%">
<!-- 
                                    <button type="button" data-toggle="modal" data-target="#deleteModal{{$item->id}}">
                                        -
                                    </button> -->
                                </th>

                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="content{{$item->no}}" name="content{{$item->no}}" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" value="{{ $item->content }}" required>
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="quantity{{$item->no}}" name="quantity{{$item->no}}" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ $item->quantity }}" required>
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="price{{$item->no}}" name="price{{$item->no}}" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ $item->price }}" required>
                                </th>
                                <th class="p-2">
                                    <input autocomplete="off" type="text" id="note{{$item->no}}" name="note{{$item->no}}" class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" value="{{ $item->note }}">
                                </th>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>


                </div>



            </div>
            <div style="float: left;">
                <button type="button" class="btn btn-danger btn-danger-style" data-toggle="modal" data-target="#deleteModal">
                    <i class='fas fa-trash-alt'></i><span class="ml-3">{{__('customize.Delete')}}</span>
                </button>
            </div>
            <div class="md-5" style="float: right;">
                <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
            </div>


        </form>


    </div>
</div>

<!-- @foreach($purchase_item as $item)
<div class="modal fade" id="deleteModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$item->id}}" aria-hidden="true">
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
                <form action="delete/{{$item->id}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">是</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach -->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                <form action="delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">是</button>
                </form>
            </div>
        </div>
    </div>
</div>




@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    var $i = 0;

    function addElementDiv(obj) {

        console.log($i)
        var parent = document.getElementById(obj);
        //新增 div
        var div = document.createElement("tr");
        //設定 div 屬性，如 id

        div.innerHTML = '<th></th>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="content-' + $i + '" name="content-' + $i + '" class="form-control{{ $errors->has("content") ? " is-invalid" : "" }}" value="{{ old("content") }}"></th>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="quantity-' + $i + '" name="quantity-' + $i + '" class="form-control{{ $errors->has("quantity") ? " is-invalid" : "" }}" value="{{ old("quantity") }}"></th>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="price-' + $i + '" name="price-' + $i + '" class="form-control{{ $errors->has("price") ? " is-invalid" : "" }}" value="{{ old("price") }}"></th>' +
            '<th class="p-2"><input autocomplete="off" type="text" id="note-' + $i + '" name="note-' + $i + '" class="form-control{{ $errors->has("note") ? " is-invalid" : "" }}" value="{{ old("note") }}"></th>'
        parent.appendChild(div);
        $i++;
    }
</script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop