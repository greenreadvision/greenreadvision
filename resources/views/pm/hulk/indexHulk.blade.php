@extends('layouts.hulk')

@section('content')
<button type="button" class="btn btn-blue rounded-pill" onclick='tableToExcel()'><span class="mx-2">匯出 Excel</span></button>
<div class="col-lg-12" style="position: relative" id="sex" tabindex="-1" role="dialog" aria-labelledby="sex" aria-hidden="false">
    <div class="modal-dialog containerr" role="document" >
        <div class="modal-content" style="height:450px">
            <div class="modal-header" >
                <h5 class="modal-title" >性別</h5>
            </div>
            <div class="modal-body row " style="margin-top:15vh;">
                <div class="col-6 justify-content-center d-flex " >
                    <button type="button" class="btn male buttons" value="男" onclick="changeWindows('sex','male')">男</button>
                </div>
                <div class="col-6 justify-content-center d-flex " >
                    <button type="button" class="btn female buttons" value="女" onclick="changeWindows('sex','female')">女</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12" style="position: relative;" id="area" tabindex="-1" role="dialog" aria-labelledby="area" aria-hidden="false" hidden>
    <div class="modal-dialog containerr" role="document">
        <div class="modal-content" style="height:450px">
            <div class="modal-header">
                <h5 class="modal-title">地區</h5>
            </div>
            <div class="modal-body row" style="margin-top:15vh;">
                @foreach($areas as $area)
                <div class="col-2 justify-content-center d-flex">
                    <button type="button" class="btn buttons area" onclick="changeWindows('area','{{$area}}')">{{__('customize.'.$area)}}</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12" style="position: relative;" id="age" tabindex="-1" role="dialog" aria-labelledby="age" aria-hidden="false" hidden>
    <div class="modal-dialog containerr" role="document">
        <div class="modal-content" style="height:450px">
            <div class="modal-header">
                <h5 class="modal-title">年齡</h5>
            </div>
            <div class="modal-body row" style="margin-top:15vh;">
                @foreach($ages as $age)
                <div class="col-3 justify-content-center d-flex">
                    <button type="button" class="btn buttons age" onclick="changeWindows('age','{{$age}}')">{{__('customize.'.$age)}}</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12" style="position: relative;" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="false" hidden>
    <div class="modal-dialog containerr" role="document">
        <div class="modal-content" style="height:450px">
            <div class="modal-header">
                <h5 class="modal-title">確認資料</h5>
            </div>
            <div class="modal-body">
                <form action="hulk/store" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row" >
                        <div class="col-4 justify-content-center d-flex">
                            <select name="select_sex" id="select_sex" class="rounded-pill form-control confirm-sel">
                                <option id='male' value="male">男</option>
                                <option id='female' value="female">女</option>
                            </select>
                        </div>
                        <div class="col-4 justify-content-center d-flex">
                            <select name="select_area" id="select_area" class="rounded-pill form-control confirm-sel">
                                @foreach($areas as $area)
                                <option id="{{$area}}" value="{{$area}}">{{__('customize.'.$area)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4 justify-content-center d-flex">
                            <select name="select_age" id="select_age" class="rounded-pill form-control confirm-sel">
                                @foreach($ages as $age)
                                <option id="{{$age}}" value="{{$age}}">{{__('customize.'.$age)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col justify-content-center d-flex" style="margin-top:20%">
                            <button class="btn btn-red rounded-pill" type="submit" onclick="alert('已提交資料，謝謝您~!')"><span class="mx-2">確認</span></button>
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
    
    function submit(){
        alert("已提交資料，謝謝~!");
    }
</script>

<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js">
    function getData(){
        data = "{{$datas}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function tableToExcel(){
        console.log('test')
         /*var excel=[
            ['資料提交日期', '性別', '地區', '年齡']
        ];
        var data = getData();
        var submitDate = ''
        for(var i=0; i<data.length; i++){
            submitDate = data[i]['created_at'].substring(0,10);
            excel.push([submitDate, data[i]['sex'], data[i]['area'], data[i]['age']])
        }

       var filename = "農博資料.xlsx";
        var ws_name = "工作表1";
        var wb = XLSX.utils.book_new(),
            ws = XLSX.utils.aoa_to_sheet(excel);
        XLSX.utils.book_append_sheet(wb, ws, ws_name);
        XLSX.writeFile(wb, filename);*/
    }
    
</script>
@stop