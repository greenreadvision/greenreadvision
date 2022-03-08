@extends('layouts.app')

@section('content')

<div class="col-lg-12" style="position: relative;" id="sex" tabindex="-1" role="dialog" aria-labelledby="sex" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">性別</h5>
            </div>
            <div class="modal-body">
                <div class="form-group row justify-content-center" >
                    <div class="row">

                            <button type="button" class="btn btn-primary rounded-pill" value="男" onclick="changeWindows('sex','male')">男</button>

                            <button type="button" class="btn btn-primary rounded-pill" value="女" onclick="changeWindows('sex','female')">女</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12" style="position: relative;" id="area" tabindex="-1" role="dialog" aria-labelledby="area" aria-hidden="false" hidden>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">地區</h5>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="row">
                         @foreach($areas as $area)
                         <button type="button" class="btn btn-primary" onclick="changeWindows('area','{{$area}}')">{{__('customize.'.$area)}}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12" style="position: relative;" id="age" tabindex="-1" role="dialog" aria-labelledby="age" aria-hidden="false" hidden>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">年齡</h5>
            </div>
            <div class="modal-body">
                 <div class="form-group row">
                    <div class="row">
                        @foreach($ages as $age)
                        <button type="button" class="btn btn-primary" onclick="changeWindows('age','{{$age}}')">{{__('customize.'.$age)}}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12" style="position: relative;" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="false" hidden>
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
                            <select name="select_sex" id="select_sex">
                                <option id='male' value="male">男</option>
                                <option id='female' value="female">女</option>
                            </select>
                        </div>
                        <div class="col">
                            <select name="select_age" id="select_age">
                                @foreach($ages as $age)
                                <option id="{{$age}}" value="{{$age}}">{{__('customize.'.$age)}}</option>
                                @endforeach
                            </select>
                            
                        </div>
                        <div class="col">
                            <select  name="select_area" id="select_area">
                                @foreach($areas as $area)
                                <option id="{{$area}}" value="{{$area}}">{{__('customize.'.$area)}}</option>
                                @endforeach
                            </select>
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
    var sex = ""
    var age = ""
    var area = ""
    
    $(document).ready(function(){
        
    });

    function changeWindows(option,value){
        switch (option){
            case 'sex':
                document.getElementById('sex').hidden = true;
                document.getElementById('area').hidden = false;
                sex = value;
                break
            case 'area':
                document.getElementById('area').hidden = true;
                document.getElementById('age').hidden = false;
                area = value;
                break
            case 'age':
                document.getElementById('age').hidden = true;
                age = value
                getResult();
                document.getElementById('confirm').hidden = false;
                
            default:
        }
    }

    function getResult(){
        console.log('sex = ' + sex)
        console.log('area = ' + area)
        console.log('age = ' + age)
        document.getElementById(sex).setAttribute('selected',true);
        document.getElementById(area).setAttribute('selected',true);
        document.getElementById(age).setAttribute('selected',true);

    }
</script>
@stop