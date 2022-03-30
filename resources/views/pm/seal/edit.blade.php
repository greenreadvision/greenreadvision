@extends('layouts.app')
@section('content')
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
                <button type="button" class="btn btn-red rounded-pill" data-dismiss="modal">否</button>
                    <form action="delete" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-blue rounded-pill">是</button>
                    </form>
            </div>
        </div>
    </div>
</div>
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">公司文案</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/seal" class="page_title_a" >用印申請單</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/seal/{{$seal->seal_id}}/show" class="page_title_a" >{{$seal->final_id}}</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">編輯用印單</span>

        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                @if($seal->status == 'waiting')
                <form name="activityForm" action="edit/update" method="POST" enctype="multipart/form-data">
                @elseif($seal->status == 'waiting-fix')
                <form name="activityForm" action="edit/fix" method="POST" enctype="multipart/form-data">
                @endif
                @method('PUT')
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
                                            <option value="{{$item->project_id}}" {{$seal->project_id == $item->project_id ? 'selected' : ''}}>{{$item->name}}</option>
                                            @endforeach
                                        <optgroup id="select-project-rv" label="閱野">
                                            @foreach ($rv as $item)
                                            <option value="{{$item->project_id}}" {{$seal->project_id == $item->project_id ? 'selected' : ''}}>{{$item->name}}</option>
                                            @endforeach
                                        <optgroup id="select-project-other" label="其他">
                                            <option value="other-grv_2" {{$seal->project_id == "other-grv_2" ? 'selected' : ''}}>其他-綠雷德</option>
                                            <option value="other-rv" {{$seal->project_id == "other-rv" ? 'selected' : ''}}>其他-閱野</option>
                                            <option value="other-grv" {{$seal->project_id == "other-grv" ? 'selected' : ''}}>其他-綠雷德(舊)</option>
                                        <optgroup id="select-project-grv" label="綠雷德(舊)">
                                            @foreach ($grv as $item)
                                            <option value="{{$item->project_id}}" {{$seal->project_id == $item->project_id ? 'selected' : ''}}>{{$item->name}}</option>
                                            @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class='col-lg-4'>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">用印對象</label>
                                <input type="text" name="object" id="object" value="{{$seal->object}}" class="form-control rounded-pill" required>
                            </div>
                        </div>
                        <div class='col-lg-4'>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">用印人</label>
                                <select type="text" id="select_user" name="select_user" class="rounded-pill form-control mb-2" required>
                                    <option value=""></option>
                                    @foreach ($users as $user)
                                    @if($user->user_id == $seal->seal_user_id)
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
                                    <option value="牛角大小章" {{$seal->seal_type == '牛角大小章' ? 'selected' : ''}}>牛角大小章</option>
                                    <option value="連續大小章" {{$seal->seal_type == '連續大小章' ? 'selected' : ''}}>連續大小章</option>
                                    <option value="銀行大章" {{$seal->seal_type == '銀行大章' ? 'selected' : ''}}>銀行大章</option>
                                </select>
                            </div>
                        </div>
                        <div class="{{$seal->file_type == '其他' ? "col-lg-3" : 'col-lg-6'}}" id="select_file_div">
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">文章類別</label>
                                <select type="text" id="select_file" name="select_file" onchange="select(this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2" required>
                                    <option value="合約/契約" {{$seal->file_type == '合約/契約' ? 'selected' : ''}}>合約/契約</option>
                                    <option value="標案文件" {{$seal->file_type == '標案文件' ? 'selected' : ''}}>標案文件</option>
                                    <option value="銀行文件" {{$seal->file_type == '銀行文件' ? 'selected' : ''}}>銀行文件</option>
                                    <option value="政府文件" {{$seal->file_type == '政府文件' ? 'selected' : ''}}>政府文件</option>
                                    <option value="其他" {{$seal->file_type == '其他' ? 'selected' : ''}}>其他</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3" id="file_other_div" {{$seal->file_type == '其他' ? "" : 'hidden'}}>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">文章類別，其他內容填寫區</label>
                                <input type="text" name="file_other" id="file_other" class="form-control rounded-pill" value="{{$seal->file_other_content}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">申請日期樣式</label>
                                <select type="text" name="date_type" id="date_type" onchange="changeDate(this.options[this.options.selectedIndex].value)" class="form-control rounded-pill" required>
                                    <option value="onedate" {{$seal->contract_end_date == null? 'selected' : ""}}>單日</option>
                                    <option value="manydate" {{$seal->contract_end_date != null? 'selected' : ""}}>多日</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3" id="oneday_input" {{$seal->contract_end_date != null? 'hidden' : ""}}>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">日期</label>
                                <input type='date' name="one_date" id="one_date" value="{{$seal->contract_first_date}}" class="form-control rounded-pill" >
                            </div>
                        </div>
                        <div id="manyday_input" class = "col-lg-6 row" {{$seal->contract_end_date == null? 'hidden' : ""}}>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-lg-12 col-form-label">開始日期</label>
                                    <input type='date' name="first_date" id="first_date" value="{{$seal->contract_first_date}}" class="form-control rounded-pill" >
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-lg-12 col-form-label">結束日期</label>
                                    <input type='date' name="end_date" id="end_date" value="{{$seal->contract_end_date}}" class="form-control rounded-pill" >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">申請說明</label>
                                <input type="text" name="content" id="content" style="height: 10vh" value="{{$seal->content}}" class="form-control rounded-pill" required>
                            </div>
                        </div>
                    </div>
                    <div style="float: left;padding-top: 20px;">
                        <button type="button" class="btn btn-red rounded-pill" data-toggle="modal" data-target="#deleteModal">
                            <i class='ml-2 fas fa-trash-alt'></i><span class="ml-1 mr-2">{{__('customize.Delete')}}</span>
                        </button>
                    </div>
                    <div style="padding-top: 20px;float: right;">
                        <button type="submit" class="w-15 btn btn-green rounded-pill">{{__('customize.Save')}}</button>
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
        
        if(val =="onedate"){
            oneday_input.hidden = false;
            manyday_input.hidden = true;
            one_date.value = '';
            first_date.value = ""
            end_date.value = ""
        }else if(val == "manydate"){
            oneday_input.hidden = true;
            manyday_input.hidden = false;
            one_date.value = ""
            first_date.value = '';
            end_date.value = ""
        }

    }
</script>
@stop