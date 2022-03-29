@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">公司文案</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/projectSOP/index" class="page_title_a" >公司資料庫</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            @if($projectSOP->SOPtype == 'project')
            <span class="page_title_span">{{$projectSOP->project->name}}</span>
            @elseif($projectSOP->SOPtype == 'other')
            <span class="page_title_span">{{$projectSOP->type}}</span>
            @endif
        </div>
    </div>
</div>
<div class="col-lg-12" style="margin: auto" >
    <div class="row" style="text-align: center">
        <div class="col-lg-3">
            <div class="card card-style col-lg-12">
                @if($projectSOP->SOPtype == 'project')
                <div class="px-3">
                    <div class="card-header bg-white">
                        <i class='fas fa-book' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label ">專案名稱</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center"><label class="content-label-style col-form-label">({{__('customize.'.$projectSOP->project->company_name)}})&nbsp;{{$projectSOP->project->name}}</label></div>
                </div>
                @elseif($projectSOP->SOPtype == 'other')
                <div class="px-3">
                    <div class="card-header bg-white">
                        <i class='fas fa-book' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label ">隸屬名稱</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center"><label class="content-label-style col-form-label">({{__('customize.'.$projectSOP->company_name)}})-{{$projectSOP->type}}</label></div>
                </div>
                @endif
            </div>
            <div class="card card-style col-lg-12">
                <div class="px-3">
                    <div class="card-header bg-white">
                        <i class='fas fa-user-circle' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label ">檔案建立人</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center"><label class="content-label-style col-form-label">{{$projectSOP->user->name}}({{$projectSOP->user->nickname}})</label></div>
                </div>
            </div>
            <div class="card card-style col-lg-12">
                <div class="px-3">
                    <div class="card-header bg-white">
                        <i class='fas fa-eye' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label ">檔案組簡介</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center"><label class="content-label-style col-form-label">{{$projectSOP->content}}</label></div>
                </div>
            </div>
        </div>
        <div class="card card-style col-lg-7">
            <div class="px-3">
                <div class="card-header bg-white">
                    <i class='fas fa-database' style="font-size:1.5rem;"></i><label class="ml-2 col-form-label ">資料區</label>
                </div>
            </div>
            <div class="col-lg-12  card-body">
                <div class="table-style-invoice">
                    <table id="file_table" class="tableSOP" style="table-layout: fixed;border:1px #000 solid;" bgcolor="white"  >
                        <tbody>
                            <tr class="text-white">
                                <th style="width:5%">編號</th>
                                <th style="width:30%">名稱</th>
                                <th style="width:50%">檔案簡介</th>
                                <th style="width:15%">下載</th>
                            </tr>
                            @foreach($projectSOP_items as $item)
                            <tr>
                                <td>{{$item->no}}</td>
                                <td style="text-align: left">{{$item->name}}</td>
                                <td style="text-align: left">{{$item->content}}</td>
                                <td><a class="btn btn-blue rounded-pill" style="color: #FFF" href="{{route('threedownload', $item['file_address'])}}">下載</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if(\Auth::user()->user_id == $projectSOP->user_id|| \Auth::user()->role == 'manager' || \Auth::user()->role == 'supervisor' || \Auth::user()->role == 'proprietor')
        <div class="col-lg-2">
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('projectSOP.edit', $projectSOP->projectSOP_id)}}'"><i class='fas fa-edit'></i><span class="ml-3"> {{__('customize.Edit')}}</span></button>
        </div>
        @endif
    </div>
</div>


@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        data ="{{$projectSOP}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        console.log(data)
    });
</script>

@stop