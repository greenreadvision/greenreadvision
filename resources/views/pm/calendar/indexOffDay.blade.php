@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1>{{__('customize.OffDay')}}</h1>
                    <button class="btn btn-primary" onclick="location.href='{{route('offDay.create')}}'">{{__('customize.Add')}}</button>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>@lang('customize.User')</th>
                                <!-- <th>@lang('customize.status')</th> -->
                                <th>@lang('customize.start')@lang('customize.time')</th>
                                <th>@lang('customize.end')@lang('customize.time')</th>
                                <th>@lang('customize.status')</th>
                                <th></th>
                                <th>@lang('customize.created_at')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($off_days as $off_day)
                                <tr>
                                    <td>{{$off_day->user['nickname']}}</td>
                                    <!-- <td>@lang('customize.'.$off_day['type'])</td> -->
                                    @if($off_day['type']!='hours')
                                        <td>{{substr( $off_day['start_datetime'] ,0 , 10)}}</td>
                                        <td>{{substr( $off_day['end_datetime'] ,0 , 10)}}</td>
                                    @else
                                    <td>{{substr( $off_day['start_datetime'] ,0 , 16)}}</td>
                                        <td>{{substr( $off_day['end_datetime'] ,0 , 16)}}</td>
                                    @endif
                                    <td><span class="badge badge-{{$off_day->status=='waiting' ? 'danger' : 'success'}}">@lang('customize.'.$off_day['status'])</span></td>
                                    <td>
                                        @if(($off_day['status']=='waiting' && \Auth::user()->role=='manager' && $off_day['type']=='days')||($off_day['status']=='waiting' && \Auth::user()->role=='accountant' && $off_day['type']!='days'))
                                            <form action="offDay/{{$off_day->off_day_id}}/match" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">{{__('customize.Permit')}}</button>
                                            </form>
                                        @endif
                                        @if($off_day['user_id']==\Auth::user()->user_id || \Auth::user()->role=='manager')
                                            <form action="offDay/{{$off_day->off_day_id}}/delete" method="POST">
                                                @method("DELETE")
                                                @csrf
                                                <button class="btn btn-outline-danger btn-sm">@lang('customize.Delete')</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>{{$off_day->updated_at->format('Y-m-d')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <ol>
                        @foreach ($off_days as $off_day)
                        <li class="mb-1">
                            <div class="row justify-content-center">
                                <div class="col d-flex align-items-center">
                                    <span>{{$off_day->user['nickname']}} @lang('customize.'.$off_day['type'])</span>
                                    <div>
                                        <span>@lang('customize.start')@lang('customize.time') : {{$off_day['start_datetime']}}</span><br />
                                        <span>@lang('customize.end')@lang('customize.time') : {{$off_day['end_datetime']}}</span>
                                    </div>
                                    @switch($off_day->status)
                                        @case('managed')
                                            <span class="badge badge-success">@lang('customize.'.$off_day['status']) </span>
                                            @break
                                        @case('waiting')
                                            <span class="badge badge-warning">@lang('customize.'.$off_day['status']) </span>
                                            @break
                                        @default
                                            @break
                                    @endswitch
                                    @if($off_day['status']=='waiting'&&\Auth::user()->role=='manager')
                                        <form action="offDay/{{$off_day->off_day_id}}/match" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">{{__('customize.Permit')}}</button>
                                        </form>
                                    @endif
                                    <form action="offDay/{{$off_day->off_day_id}}/destroy" method="POST" class="ml-auto">
                                        <button class="btn btn-outline-danger btn-sm">@lang('customize.Delete')</button>
                                    </form>
                                </div>
                                <div class="col-auto">
                                    <span>{{$off_day->updated_at->format('Y-m-d')}}</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ol> --}}

                    {{-- @if ($key + 1 < count($off_day_groups))
                        <hr>
                    @endif
                    @endforeach --}}
                </div>
            </div>
        </div>
        {{--
        <div class="col-md-12 col-lg-10 col-xl-8">
            <hr>
        </div> --}}
    </div>

@stop
