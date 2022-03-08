@extends('layouts.app')

@section('content')

<div class="col-lg-12" style="position: relative;" id="sex" tabindex="-1" role="dialog" aria-labelledby="sex" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">性別</h5>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="row">
                        <input type="button" class="btn btn-primary" id="male" value="男" onclick="changeWindows('sex')">
                        <input type="button" class="btn btn-primary" id="female" value="女" onclick="changeWindows('sex')">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12" style="position: relative;" id="area" tabindex="-1" role="dialog" aria-labelledby="area" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">地區</h5>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="row">
                         @foreach($areas as $area)
                         <input type="button" class="btn btn-primary" id="areaa" value="{{__('customize.'.$area)}}" onclick="changeWindows('area')">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12" style="position: relative;" id="age" tabindex="-1" role="dialog" aria-labelledby="age" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">年齡</h5>
            </div>
            <div class="modal-body">
                 <div class="form-group row">
                    <div class="row">
                        @foreach($ages as $age)
                        <input type="button" class="btn btn-primary" id="agee" value="{{__('customize.'.$age)}}" onclick="changeWindows('age')">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12" style="position: relative;" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">確認資料</h5>
            </div>
            <div class="modal-body">
                <form action="confirm" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group row">
                        <div class="col">
                            <select>
                                <option>test</option>
                            </select>
                            <p id="valueSex"></p>
                        </div>
                        <div class="col">
                            @foreach($ages as $age)
                            <input type="button" class="btn btn-primary" id="confirm" value="{{__('customize.'.$age)}}" onclick="changeWindows('age')">
                            @endforeach
                        </div>
                        <div class="col">
                            @foreach($ages as $age)
                            <input type="button" class="btn btn-primary" id="confirm" value="{{__('customize.'.$age)}}" onclick="changeWindows('age')">
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>

<script>
    $(document).ready(function(){
        var sex = document.getElementById('sex')
        var area = document.getElementById('area')
        var age = document.getElementById('age')
        var confirm = document.getElementById('confirm')
        area.hidden = true
        age.hidden = true
        confirm.hidden = true
    });

    function changeWindows(option){
        switch (option){
            case 'sex':
                document.getElementById('sex').hidden = true;
                document.getElementById('area').hidden = false;
                break
            case 'area':
                document.getElementById('area').hidden = true;
                document.getElementById('age').hidden = false;
                break
            case 'age':
                document.getElementById('age').hidden = true;
                getResult();
                document.getElementById('confirm').hidden = false;
            default:
        }
    }

    function getResult(){
        var inputSex = document.getElementById("male").value;
        document.getElementById("valueSex").innerHTML = inputSex;
    }
</script>
@stop