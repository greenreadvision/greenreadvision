@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">公司文案</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/seal" class="page_title_a" >用印申請單</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">建立用印單</span>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center" >
    <div class="col-lg-8">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <form name="activityForm" action="create/review" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="col-lg-12">
                    <div class="row">
                        <div class='col-lg-4'>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">隸屬標案</label>
                                    <select type="text" id="select_project" name="select_project"  class="rounded-pill form-control mb-2" required>
                                        <option value=""></option>
                                        <optgroup id="select-project-grv_2" label="綠雷德">
                                            @foreach ($grv2 as $item)
                                            <option value="{{$item->project_id}}">{{$item->name}}</option>
                                            @endforeach
                                        <optgroup id="select-project-rv" label="閱野">
                                            @foreach ($rv as $item)
                                            <option value="{{$item->project_id}}">{{$item->name}}</option>
                                            @endforeach
                                        <optgroup id="select-project-other" label="其他">
                                            <option value="other-grv_2">其他-綠雷德</option>
                                            <option value="other-rv">其他-閱野</option>
                                            <option value="other-grv">其他-綠雷德(舊)</option>
                                        <optgroup id="select-project-grv" label="綠雷德(舊)">
                                            @foreach ($grv as $item)
                                            <option value="{{$item->project_id}}">{{$item->name}}</option>
                                            @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class='col-lg-4'>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">用印對象</label>
                                <input type="text" name="object" id="object" class="form-control rounded-pill" required>
                            </div>
                        </div>
                        <div class='col-lg-4'>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">用印人</label>
                                <select type="text" id="select_user" name="select_user" class="rounded-pill form-control mb-2" required>
                                    <option value=""></option>
                                    @foreach ($users as $user)
                                    @if($user->user_id == \Auth::user()->user_id)
                                        <option value="{{$user->user_id}}" selected>{{$user->name}}({{$user->nickname}})</option>
                                    @else
                                        <option value="{{$user->user_id}}">{{$user->name}}({{$user->nickname}})</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">用印章別</label>
                                <select type="text" id="select_seal" name="select_seal" class="rounded-pill form-control mb-2" required>
                                    <option value=""></option>
                                    <option value="牛角大小章">牛角大小章</option>
                                    <option value="連續大小章">連續大小章</option>
                                    <option value="銀行大章">銀行大章</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6" id="select_file_div">
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">文章類別</label>
                                <select type="text" id="select_file" name="select_file" onchange="select(this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2" required>
                                    <option value=""></option>
                                    <option value="合約/契約">合約/契約</option>
                                    <option value="標案文件">標案文件</option>
                                    <option value="銀行文件">銀行文件</option>
                                    <option value="政府文件">政府文件</option>
                                    <option value="其他">其他</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3" id="file_other_div" hidden>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">文章類別，其他內容填寫區</label>
                                <input type="text" name="file_other" id="file_other" class="form-control rounded-pill" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">申請日期樣式</label>
                                <select type="text" name="date_type" id="date_type" onchange="changeDate(this.options[this.options.selectedIndex].value)" class="form-control rounded-pill" required>
                                    <option value="onedate" selected>單日</option>
                                    <option value="manydate">多日</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3" id="oneday_input">
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">日期</label>
                                <input type='date' name="one_date" id="one_date" class="form-control rounded-pill" required>
                            </div>
                        </div>
                        <div id="manyday_input" class = "col-lg-6 row" hidden>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-lg-12 col-form-label">開始日期</label>
                                    <input type='date' name="first_date" id="first_date" class="form-control rounded-pill">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-lg-12 col-form-label">結束日期</label>
                                    <input type='date' name="end_date" id="end_date" class="form-control rounded-pill">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">申請說明</label>
                                <input type="text" name="content" id="content" style="height: 10vh" class="form-control rounded-pill" required>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-top: 20px;text-align: end">
                            <button type="submit" class="w-15 btn btn-green rounded-pill">{{__('customize.Add')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script ctype="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>


    function select(val){
        file_other = document.getElementById("file_other_div")
        select_file = document.getElementById("select_file_div")
        console.log(val)
        if(val =="其他"){
            file_other.hidden = false;
            select_file.className = "col-lg-3"
        }else{
            file_other.hidden = true;
            select_file.className = "col-lg-6"
        }
    }

    function changeDate(val){
        date_type = document.getElementById('date_type')

        oneday_input = document.getElementById('oneday_input')
        manyday_input = document.getElementById('manyday_input')

        one_date = document.getElementById('one_date')
        first_date = document.getElementById('first_date')
        end_date = document.getElementById('end_date')

        var today = new Date()
        var month,day;
        if((today.getMonth() +1)<10){
            month = "0"+(today.getMonth() +1)
        }
        else{
            month = (today.getMonth() +1)
        }
        if((today.getDay() +1)<10){
            day = "0"+(today.getDay() +1)
        }else{
            day = (today.getDay() +1)
        }
        if(val =="onedate"){
            oneday_input.hidden = false;
            manyday_input.hidden = true;
            one_date.value = today.getFullYear() + "-" + month + "-" + day;
            first_date.value = ""
            end_date.value = ""
        }else if(val == "manydate"){
            oneday_input.hidden = true;
            manyday_input.hidden = false;
            one_date.value = ""
            first_date.value = today.getFullYear() + "-" + month + "-" + day;
            end_date.value = ""
        }

    }
</script>
@stop