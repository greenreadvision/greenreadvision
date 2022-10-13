@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">硬體管理</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/reserve/index" class="page_title_a" >倉儲查詢</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">新增物品</span>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    <form action="create/store" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="signer">登記者</label>
                                <select required name="signer" type="text" class="rounded-pill form-control mb-2" onchange="internInput(this.options[this.options.selectedIndex].value)">
                                    <option value=""></option>
                                    @foreach($users as $user)
                                    @if( $user->role != 'manager' && $user->status == 'general' && $user->user_id !='GRV00000')
                                    <option value="{{$user['name']}}">{{$user['name']}}({{$user['nickname']}})</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 form-group" id="space"></div>
                            <div class="col-lg-6 form-group" id="intern" hidden>
                                <label class="label-style col-form-label" for="intern">實習生</label>
                                <select id="intern" name="intern" type="text" class="rounded-pill form-control mb-2">
                                    <option value=""></option>
                                    @foreach($interns as $intern)
                                    <option value="{{$intern['nickname']}}">{{$intern['name']}}({{$intern['nickname']}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="name">物品名稱</label>
                                <input required id="name" autocomplete="off" type="text" name="name" class="rounded-pill form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="stock">物品數量</label>
                                <input required id="stock" autocomplete="off" type="number" min="0" name="stock" class="rounded-pill form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}" value="{{ old('stock') }}">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="category">物品分類</label>
                                <input required id="category" autocomplete="off" type="text" name="category" class="rounded-pill form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" value="{{ old('category') }}">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="location">存放位置</label>
                                <select required id="location" autocomplete="off" type="text" name="location" class="rounded-pill form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" value="{{ old('location') }}">
                                    <optgroup>
                                        <option value="largeInventory">大型雜物</option>
                                        <option value="eventInventory">活動器具</option>
                                        <option value="XinWuAndHakaInventory">農博及客家器材道具</option>
                                        <option value="eventSpareAndClothes">活動常用備品及衣服</option>
                                        <option value="lotteryPrizeAndAppliance">抽獎品/活動器具</option>
                                        <option value="Appliance1">器材櫃1</option>
                                        <option value="Appliance2">器材櫃2</option>
                                        <option value="historyDocument">歷年教案</option>
                                        <option value="historyAccountingData">歷年會計資料</option>
                                        <option value="historyProject">歷年專案歸檔</option>
                                        <option value="stationery">文具</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="note">備註</label>
                                <input id="note" placeholder="非必填" autocomplete="off" type="text" name="note" class="rounded-pill form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" value="{{ old('note') }}">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-style col-form-label" for="project_id">專案單號</label>
                                <input id="project_id" placeholder="非必填" autocomplete="off" type="text" name="project_id" class="rounded-pill form-control{{ $errors->has('project_id') ? ' is-invalid' : '' }}" value="{{ old('project_id') }}">
                            </div>
                        </div>
                        <div class="md-5" style="float: right;">
                            <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">{{__('customize.Add')}}</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
function internInput(signer) {
    if(signer == '實習生'){
        document.getElementById('intern').hidden = false;
        document.getElementById('space').hidden = true;
        document.getElementById('intern').setAttribute('required','');
    }
    else{
        document.getElementById('intern').hidden = true;
        document.getElementById('space').hidden = false;
        document.getElementById('intern').removeAttribute('required');
    }
}
</script>
@stop