@extends('layouts.app')
@section('content')

@if(session()->has('Alert'))
    <script>
        alert({{ session()->get('Alert') }});
    </script>
@endif

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('question.create')}}'"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span> </button>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <div class="col-lg-8">
        <div class="card card-style">
            <div class="card-body">
                <div class="col-lg-12 table-style">
                    @foreach ($type as $item)
                    <div class="col-lg-12 collapse-style py-3 border-bottom" style="border-top-left-radius:10px;border-top-right-radius:10px; background-color: #C4E1FF" data-toggle="collapse" aria-expanded="false" data-target="#collapse{{$item}}">
                        {{__('customize.'.$item)}}
                    </div>
                        <div class="collapse multi-collapse" id="collapse{{$item}}">
                            <table>
                                <tr>
                                    <th style="width: 20%">編號</th>
                                    <th style="width: 35%">題目</th>
                                    <th style="text-align: left;width: 35%">選項</th>
                                    <th style="width: 10%">建立者<th>
                                </tr>
                                @foreach ($question as $data)
                                @if($data->type == $item)
                                <tr class="tr-choose" style="align-items: center" onclick="location.href='{{route('question.edit', $data->question_id)}}/'">
                                    <td>{{$data->question_id}}</td>
                                    <td>{{$data->title}}</td>
                                    <td style="text-align: left;">
                                        <span style="{{ $data->answer == 'option_1' ? ' background-color: #02DF82' : '' }}"> (A) {{$data->option_1}}</span><br>
                                        <span style="{{ $data->answer == 'option_2' ? ' background-color: #02DF82' : '' }}"> (B) {{$data->option_2}}</span><br>
                                        <span style="{{ $data->answer == 'option_3' ? ' background-color: #02DF82' : '' }}"> (C) {{$data->option_3}}</span><br>
                                        <span style="{{ $data->answer == 'option_4' ? ' background-color: #02DF82' : '' }}"> (D) {{$data->option_4}}</span><br>
                                    </td>
                                    <td>{{$data->user->nickname}}</td>
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


@stop