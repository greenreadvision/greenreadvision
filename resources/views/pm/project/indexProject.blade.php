@extends('layouts.app')
@section('content')

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3">
            <!-- <h2>{{__('customize.Project')}}</h2> -->
        </div>
        <div class="col-lg-6 mb-3">
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('project.create')}}'"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span> </button>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        @foreach($data as $project)
        @if($project->receiver == \Auth::user()->user_id )
        <div class="col-lg-12 py-3 receive-choose" style="cursor: pointer;" data-toggle="modal" data-target="#receive-{{$project->project_id}}">
            <span>是否接收此標案 - {{$project->name}}</span>
        </div>
        <div class="modal fade" id="receive-{{$project->project_id}}" tabindex="-1" role="dialog" aria-labelledby="receive-{{$project->project_id}}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        是否接收
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">否</button>
                        <form action="project/{{$project->project_id}}/receive" method="POST" >
                            @method('PUT')
                            @csrf        
                                <button type="submit" class="btn btn-primary">是</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card card-style">
            <div class="card-body ">
                <div class="col-lg-12">
                    <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="type1" id="type1" onchange="changeType(0)" autocomplete="off" checked> {{__('customize.grv')}}
                        </label>
                        <label class="btn btn-secondary ">
                            <input type="radio" name="type2" id="type2" onchange="changeType(1)" autocomplete="off"> {{__('customize.rv')}}
                        </label>
                    </div>
                </div>
                <div id="tr-grv" class="col-lg-12 table-style">
                    @foreach($years as $year)
                    <div class="col-lg-12 collapse-style py-3 border-bottom" data-toggle="collapse" data-target="#multiCollapse{{$year}}" aria-expanded="false" aria-controls="multiCollapse{{$year}}">{{$year}}年</div>
                    <div class="collapse multi-collapse" id="multiCollapse{{$year}}">
                        <table>
                            <tr>
                                <th></th>
                                <th>標案名稱</th>
                                <th>標案負責人</th>
                                <th>截標日期</th>
                                <th>開標日期</th>
                                <th>結案日期</th>
                                <th></th>
                            </tr>


                            @foreach ($data as $project)
                            @if($project->project_id == "h9CtkzcXSLR")
                            @if($project->company_name=='grv'&&$project->name!='其他' && substr($project->beginning_date,0,4)==$year)

                            <tr class="tr-choose" onclick="location.href='{{route('project.review', $project->project_id)}}/'">
                                <td>
                                    <span style="background-color:{{$project->color}}; border-radius: 100rem; width: 10px; height: 10px; display: inline-block;box-shadow:0 0 5px {{$project->color}};"></span>
                                </td>
                                <td style="white-space:normal;">
                                    {{$project->name}}
                                </td>
                                <td>{{$project->user->nickname}}</td>
                                <td>{{$project->deadline_date}}</td>
                                <td>{{$project->open_date}}</td>
                                <td>{{$project->closing_date}}</td>
                                @if($project->finished==1)
                                <td style="background-color:rgba(255,0,0,.2);"></td>
                                @else
                                <td></td>
                                @endif
                            </tr>
                            @endif
                            @else
                            @if($project->company_name=='grv'&&$project->name!='其他' && substr($project->open_date,0,4)==$year)

                            <tr class="tr-choose" onclick="location.href='{{route('project.review', $project->project_id)}}/'">
                                <td>
                                    <span style="background-color:{{$project->color}}; border-radius: 100rem; width: 10px; height: 10px; display: inline-block;box-shadow:0 0 5px {{$project->color}};"></span>
                                </td>
                                <td style="white-space:normal;">
                                    {{$project->name}}
                                </td>
                                <td>{{$project->user->nickname}}</td>
                                <td>{{$project->deadline_date}}</td>
                                <td>{{$project->open_date}}</td>
                                <td>{{$project->closing_date}}</td>
                                @if($project->finished==1)
                                <td style="background-color:rgba(255,0,0,.2);"></td>
                                @else
                                <td></td>
                                @endif
                            </tr>
                            @endif
                            @endif

                            @endforeach
                        </table>
                    </div>
                    @endforeach

                </div>
                <div id="tr-rv" class="col-lg-12 table-style">
                    @foreach($years as $year)
                    <div class="col-lg-12 collapse-style py-3 border-bottom" data-toggle="collapse" data-target="#RVmultiCollapse{{$year}}" aria-expanded="false" aria-controls="multiCollapse{{$year}}">{{$year}}年</div>
                    <div class="collapse multi-collapse" id="RVmultiCollapse{{$year}}">
                        <table>
                            <tr>
                                <th></th>
                                <th>標案名稱</th>
                                <th>標案負責人</th>
                                <th>截標日期</th>
                                <th>開標日期</th>
                                <th>結案日期</th>
                            </tr>
                            @foreach ($data as $project)
                            @if($project->company_name=='rv'&&$project->name!='其他' && substr($project->open_date,0,4)==$year)
                            <tr class="tr-choose" onclick="location.href='{{route('project.review', $project->project_id)}}/'">
                                <td>
                                    <span style="background-color:{{$project->color}}; border-radius: 100rem; width: 10px; height: 10px; display: inline-block;box-shadow:0 0 5px {{$project->color}};"></span>
                                </td>
                                <td style="white-space:normal;">
                                    {{$project->name}}
                                </td>
                                <td>{{$project->user->nickname}}</td>
                                <td>{{$project->deadline_date}}</td>
                                <td>{{$project->open_date}}</td>
                                <td>{{$project->closing_date}}</td>
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </div>
                    @endforeach
                </div>

            </div>

        </div>
    </div>
</div>


@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    function changeType(i) {
        if (i == 0) {
            document.getElementById('tr-grv').style.display = "block"
            document.getElementById('tr-rv').style.display = "none"

        } else {
            document.getElementById('tr-rv').style.display = "block"
            document.getElementById('tr-grv').style.display = "none"
        }

    }
</script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop