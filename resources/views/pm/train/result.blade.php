@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center">
    <div class="col-lg-6">
        <div class="col-lg-12 form-group">
            <div class="card border-0 shadow">
                <div class="card-header text-center {{ $grade >= 80 ? 'correct' : 'mistake'}}">
                    <label class="label-style col-form-label" style="font-size: 24px;"> 分數：{{round($grade,2)}}</label>
                </div>
                <div class="card-body" style="color: black; text-align:center;">
                    <label class="label-style col-form-label" style="font-size: 20px;{{$grade >= 100 ?'display:block' : 'display:none'}}">恭喜!完全正確!</label>
                    <label class="label-style col-form-label" style="font-size: 20px;{{$grade >=80&&$grade<100 ?'display:block' : 'display:none'}}">雖然還是有點小錯，以後多加注意。</label>
                    <label class="label-style col-form-label" style="font-size: 20px;{{$grade <80 ?'display:block' : 'display:none'}}">錯得有點多喔!回去再多看一次介紹。</label>
                    <!-- <label class="label-style col-form-label" style="font-size: 26px;">分數： {{round($grade,2)}}</label> -->
                </div>
            </div>
        </div>
        @foreach($fail as $item)
        <div class="col-lg-12 form-group">
            <div class="card border-0 shadow">
                <div class="card-header mistake">
                    <label class="label-style col-form-label" for="{{$item[0]->question_id}}"> {{$item[0]->title}}</label>
                    <!-- <button type="button" style="{{$item[0]->content != null ? 'display:block' :'display:none'}} ;float:right;" class="btn btn-secondary" data-trigger="focus" data-toggle="popover" title="註解" data-placement="right" data-content="{{$item[0]->content}}">
                        解釋
                    </button> -->
                </div>
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{$item[0]->question_id}}" {{$item[1] == 'option_1' ? 'checked' : 'disabled'}}>
                        <label class="form-check-label">
                            <span class="{{ $item[1] == 'option_1' ? 'px-2 mistake' : '' }} {{ $item[0]->answer == 'option_1' ? 'px-2 correct' : '' }}"> (A) {{$item[0]->option_1}}</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{$item[0]->question_id}}" {{$item[1] == 'option_2' ? 'checked' : 'disabled'}}>
                        <label class="form-check-label">
                            <span class="{{ $item[1] == 'option_2' ? 'px-2 mistake' : '' }} {{ $item[0]->answer == 'option_2' ? 'px-2 correct' : '' }}"> (B) {{$item[0]->option_2}}</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{$item[0]->question_id}}" {{$item[1] == 'option_3' ? 'checked' : 'disabled'}}>
                        <label class="form-check-label">
                            <span class="{{ $item[1] == 'option_3' ? 'px-2 mistake' : '' }} {{ $item[0]->answer == 'option_3' ? 'px-2 correct' : '' }}"> (C) {{$item[0]->option_3}}</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{$item[0]->question_id}}" {{$item[1] == 'option_4' ? 'checked' : 'disabled'}}>
                        <label class="form-check-label">
                            <span class="{{ $item[1] == 'option_4' ? 'px-2 mistake' : '' }} {{ $item[0]->answer == 'option_4' ? 'px-2 correct' : '' }}"> (D) {{$item[0]->option_4}}</span>
                        </label>
                    </div>
                </div>
                @if($item[0]->content != '')
                <div class="card-footer">
                    <div>
                        <label class="col-form-label">
                            <span> 正解：({{$item[0]->answer ==  'option_1' ? 'A' : ''}}{{$item[0]->answer ==  'option_2' ? 'B' : ''}}{{$item[0]->answer ==  'option_3' ? 'C' : ''}}{{$item[0]->answer ==  'option_4' ? 'D' : ''}}) {{$item[0][$item[0]->answer]}}</span>
                        </label>
                    </div>
                    <div>
                        <label class="col-form-label">
                            <span> 解釋：{{$item[0]->content}}</span>
                        </label>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach

        @foreach($corrects as $correct)
        <div class="col-lg-12 form-group">
            <div class="card border-0 shadow">
                <div class="card-header correct">
                    <label class="label-style col-form-label" for="{{$correct->question_id}}"> {{$correct->title}}</label>
                </div>
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{$correct->question_id}}" {{$correct->answer == 'option_1' ? 'checked' : 'disabled'}}>
                        <label class="form-check-label">
                            <span class="{{$correct->answer == 'option_1' ? 'px-2 correct' : '' }}"> (A) {{$correct->option_1}}</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{$correct->question_id}}" {{$correct->answer == 'option_2' ? 'checked' : 'disabled'}}>
                        <label class="form-check-label">
                            <span class="{{ $correct == 'option_2' ? 'px-2 mistake' : '' }} {{ $correct->answer == 'option_2' ? 'px-2 correct' : '' }}"> (B) {{$correct->option_2}}</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{$correct->question_id}}" {{$correct->answer == 'option_3' ? 'checked' : 'disabled'}}>
                        <label class="form-check-label">
                            <span class="{{ $correct == 'option_3' ? 'px-2 mistake' : '' }} {{ $correct->answer == 'option_3' ? 'px-2 correct' : '' }}"> (C) {{$correct->option_3}}</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{$correct->question_id}}" {{$correct->answer == 'option_4' ? 'checked' : 'disabled'}}>
                        <label class="form-check-label">
                            <span class="{{ $correct == 'option_4' ? 'px-2 mistake' : '' }} {{ $correct->answer == 'option_4' ? 'px-2 correct' : '' }}"> (D) {{$correct->option_4}}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class=" d-flex justify-content-center">
            @if($href =="active")
            @if($grade>80 )
            <div class="col-lg-12 form-group">
                <button type="button" class="btn btn-green rounded-pill w-100" onclick="window.location='{{route('pmTrain')}}'">下一頁</button>
            </div>
            @else
            <div class="col-lg-12 form-group">
                <button type="button" class="btn btn-red rounded-pill w-100" onclick="window.location='{{route('activeTrain')}}'">返回</button>
            </div>
            @endif
            @elseif($href == "pm")
            @if($grade>80)
            <div class="col-lg-12 form-group">
                <form action="{{ route('train.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <button type="submit" class="btn btn-green rounded-pill w-100">下一頁</button>
                </form>
            </div>
            @else
            <div class="col-lg-12 form-group">
            <button type="button" class="btn btn-red rounded-pill w-100" onclick="window.location='{{route('pmTrain')}}'">返回</button>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>



@stop