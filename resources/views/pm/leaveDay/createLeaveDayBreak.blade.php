@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">人事管理</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="{{ route('leaveDay.show',[\Auth::user()->leaveDay->leave_day_id,date('Y').'-apply']) }}" class="page_title_a" >請/補假</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">申請請假</span>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center" >
    <div class="col-lg-8">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    <form action="/leaveDayBreak/{{$leaveDayId}}/create/review" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="type" class=" col-form-label">請假類別</label>
                                    <select type="text" id="types" name="types" class="form-control rounded-pill" onchange="changeType(this.options[this.options.selectedIndex].value)">
                                        @foreach($types as $type)
                                        <option value="{{$type}}" {{old('type')==$type?'selected':''}}>{{__('customize.'.$type)}}</option>
                                        @endforeach
                                     </select>
                                </div>
                                <div class="form-group">
                                    <label for="lengths" class="col-form-label">時間長度</label>
                                    <select type="text" id="length_long" name="length_long" class="form-control rounded-pill" onchange="changeLength(this.options[this.options.selectedIndex].value)">
                                        @foreach($selects as $select)
                                        <option value="{{$select}}" {{old('select')==$select?'selected':''}}>{{__('customize.'.$select)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="from-group">
                                    <label for="lengths" class="col-form-label">事由</label>
                                    <input autocomplete="off" type="text" name="content" id="content" class="form-control rounded-pill {{ $errors->has('content') ? ' is-invalid' : '' }}" required value="{{ old('content') }}">
                                </div>
                                <div class="form-group" id="bereavement_leave" hidden>
                                    <label class="col-form-label">請假證明</label>
                                    <label id="prove" class="input-photo-label label-style col-form-label" for="prove_path">
                                        <small>上傳</small>
                                        <input accept="image/*" type="file" name="prove_path" id="prove_path" class="input-photo-input py-0 form-control{{ $errors->has('prove_path') ? ' is-invalid' : '' }}">
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="days">
                                    <div class="form-group">
                                        <label for="start_day" class="col-form-label">開始日期</label>
                                        <input autocomplete="off" onchange="calculation('days')" type="date" name="start_day" id="start_day" class="form-control rounded-pill" value="{{old('start_day')}}">
                                    </div>
                                    <div class="form-group ">
                                        <label for="end_day" class="col-form-label ">結束日期</label>
                                        <input autocomplete="off" onchange="calculation('days')" type="date" name="end_day" id="end_day" class="form-control rounded-pill" value="{{old('end_day')}}" >
                                    </div>
                                </div>
                                <div id="day" hidden>
                                    <div class="form-group ">
                                        <label for="another_day" class="col-form-label ">日期</label>
                                        <input autocomplete="off" onchange="calculation('day')" type="date" name="another_day" id="another_day" class="form-control rounded-pill" value="{{old('another_day')}}">
                                        <input autocomplete="off" type="date" name="end_another_day" id="end_another_day" class="form-control rounded-pill" value="{{ old('end_another_day') }}" hidden>
                                    </div>
                                    <div id="hours" hidden>
                                        <div class="form-group ">
                                            <label for="start_time" class=" col-form-label ">開始時間(分鐘只能選擇0/15/30/45)</label>
                                            <input autocomplete="off" onchange="calculation('hours')" type="time" step="900" name="start_time" id="start_time" class="form-control rounded-pill"  value="{{old('start_time')}}"/>
                                        </div>
                                        <div class="form-group ">
                                            <label for="end_time" class="col-form-label ">結束時間(分鐘只能選擇0/15/30/45)</label>
                                            <input autocomplete="off" onchange="calculation('hours')" type="time" step="900" name="end_time" id="end_time" class="form-control rounded-pill"  value="{{old('end_time')}}"/>
                                        </div>
                                    </div>
                                </div>
                                <div id="day_long">
                                    <div class="form-group ">
                                        <label for="day_long" class="col-form-label ">天數</label>
                                        <input autocomplete="off" type="text" name="days_long" id="days_long" class="form-control rounded-pill {{ $errors->has('days_long') ? ' is-invalid' : '' }}" required value="{{ old('days_long') }}" readonly>
                                        @if($errors->has('days_long'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>請填寫數字</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">新增</span> </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('script')
<script ctype="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var bereavement_leave = document.getElementById('bereavement_leave')
        var days = document.getElementById('days')
        var twoDays = document.getElementById('twoDays')
        var day = document.getElementById('day')
        var hours = document.getElementById('hours')
        var old_length_long = "{{old('length_long')}}"
        if (old_length_long == '') {
            old_length_long = 'days'
        }
        $('#days_long').val(0)
        
        $('#prove_path').on('change', function(e) {
            id = e.target.id

            const file = this.files[0];

            const fr = new FileReader();
            fr.onload = function(e) {
                $("#prove").css("background-image", "url(" + e.target.result + ")");
                $("#prove small").css("display", "none");

            };

            // 使用 readAsDataURL 將圖片轉成 Base64
            fr.readAsDataURL(file);
        });
        //setFifteenMinute();
        changeLength(old_length_long)
    });
    window.onresize = (function() {
        $('#prove').height($('#prove').width() * 11 / 17)
    })
    
    function changeType(type) {
        switch (type) {
            case 'compensatory_leave_break':
                bereavement_leave.hidden = true
                break
            case 'bereavement_leave':
                bereavement_leave.hidden = false
                $('#prove').height($('#prove').width() * 11 / 17)
                break
            default:

        }
    }


    function changeLength(length) {
        
        switch (length) {
            case 'days':
                days.hidden = false
                day.hidden = true
                hours.hidden = true
                $('#days_long').val(0)
                resetRequire()
                document.getElementById('start_day').required = true;
                document.getElementById('end_day').required = true;
                document.getElementById('start_day').setAttribute('onchange',"calculation('days')");
                document.getElementById('start_day').value = ""
                document.getElementById('end_day').removeAttribute('readonly')
                document.getElementById('end_day').value = ""
                break
            case 'twoDays':
                var start = document.getElementById('start_day');
                
                days.hidden = false
                day.hidden = true
                hours.hidden = true
                document.getElementById('start_day').setAttribute('onchange',"calculation('twoDays')");
                document.getElementById('start_day').value = ""
                document.getElementById('end_day').setAttribute('readonly',true)
                document.getElementById('end_day').value = ""
                $('#days_long').val(2)
                resetRequire()
                break
            case 'day':
                days.hidden = true
                day.hidden = false
                hours.hidden = true
                another_day.setAttribute('oninput',"calculation('day')")
                $('#days_long').val(1)
                document.getElementById('another_day').required = true;
                resetRequire()
                break
            case 'half':
                days.hidden = true
                day.hidden = false
                hours.hidden = true
                another_day.setAttribute('oninput',"calculation('day')")
                $('#days_long').val(0.5)
                document.getElementById('another_day').required = true;
                resetRequire()
                break
            case 'hours':
                days.hidden = true
                day.hidden = false
                hours.hidden = false
                another_day.setAttribute('oninput',"calculation('hours')")
                $('#days_long').val(0)
                document.getElementById('another_day').required = true;
                document.getElementById('start_time').required = true;
                document.getElementById('end_time').required = true;
                resetRequire()

                break
            default:
        }
    }

    function resetRequire(){
        document.getElementById('start_day').required = false;
        document.getElementById('end_day').required = false;
        document.getElementById('another_day').required = false;
        document.getElementById('start_time').required = false;
        document.getElementById('end_time').required = false;
    }

    function DateDiff(sDate1, sDate2, type) { // sDate1 和 sDate2 是 2016-06-18 格式
        if (type == 'd') {
            var aDate, oDate1, oDate2, iDays
            oDate1 = new Date(sDate1) // 轉換為 06/18/2016 格式
            oDate2 = new Date(sDate2)
            iDays = parseInt(Math.abs(oDate1 - oDate2) / 1000 / 60 / 60 / 24) // 把相差的毫秒數轉換為天數
        } else if (type == 'h') {
            var aDate, oDate1, oDate2, iDays
            oDate1 = new Date(sDate1) // 轉換為 06/18/2016 格式
            oDate2 = new Date(sDate2)
            temp = Math.abs(oDate1 - oDate2) / 1000 / 60 / 60
            temp = temp.toFixed(2)

            iDays = temp
            console.log(iDays)
        }
        return iDays;
    };
    
    function DateAddDays(_date, days){
        var result = new Date(_date);
        result.setDate(result.getDate() + days);
        return result;
    };

    function calculation(type) {
        var start_day = document.getElementById('start_day').value
        var end_day = document.getElementById('end_day').value
        var start_time = document.getElementById('start_time').value
        var end_time = document.getElementById('end_time').value
        var another_day = document.getElementById('another_day').value
        var end_another_day = document.getElementById('end_another_day')
        switch (type) {
            case 'days':
                if (start_day != '' && end_day != '') {
                    $('#days_long').val(DateDiff(start_day, end_day, 'd') + 1)
                }
                break
                case 'twoDays':
                if (length_long.value == 'twoDays') {
                    $('#days_long').val(2)
                    //因怕過日會有跨月份情況發生，所以採取new Date方式來做AddDays

                    //產生 new Date，擷取start_day的value來做分割，分割成年分、月份(數值:0 ~ 11 -> 1月~12月)、日期
                    var end_time_twoDays = new Date(start_day.substr(0,4), start_day.substr(5,2) - 1, start_day.substr(8,2));
                    //使用DateAddDay，產生下一天的值
                    end_time_twoDays = DateAddDays(end_time_twoDays, 1);
                    console.log(end_time_twoDays.getMonth());
                    console.log(end_time_twoDays);
                    //確定月份是否小於10，若是的話，字串前面增加 0
                    var end_time_month = end_time_twoDays.getMonth()
                    end_time_month = end_time_month + 1;
                    if(end_time_month < 10){
                        end_time_month = "0" + end_time_month
                    }
                    //確定日期是否小於10，若是的話，字串前面增加 0
                    var end_time_date = end_time_twoDays.getDate()
                    if(end_time_date < 10){
                        end_time_date = "0" + end_time_date
                    }

                    
                    //統整上述字串，讓字串改變成input(type="date")會吃的形式(yyyy-mm-dd)
                    end_time_twoDays = end_time_twoDays.getFullYear() + "-" + end_time_month + "-" + end_time_date
                    //回傳第二天的值以做顯示
                    document.getElementById('end_day').value = end_time_twoDays
                }
                break
            case 'day':
                if (length_long.value == 'day') {
                    $('#days_long').val(1)
                } else if (length_long.value == 'half') {
                    $('#days_long').val(0.5)
                }
                break
            case 'hours':
            if (another_day != '' && start_time != '' && end_time != '') {
                hour_diff= DateDiff(another_day + ' ' + start_time, another_day + " " + end_time, 'h')
                if(start_time > end_time){
                    console.log(another_day)
                    iDays = 24 - hour_diff
                    var endDate = new Date(another_day)
                    endDate.setDate(endDate.getDate() + 1)
                    console.log(endDate.getFullYear() + '-' + (endDate.getMonth()+1) + '-' +  endDate.getDate())
                    var end_another_day_month = endDate.getMonth()+1
                    var end_another_day_Date = endDate.getDate()
                    if(end_another_day_month<10){
                        end_another_day_month = '0'+end_another_day_month
                    }
                    if(end_another_day_Date<10){
                        end_another_day_Date = '0'+end_another_day_Date
                    }
                    end_another_day.value = endDate.getFullYear() + '-' + end_another_day_month + '-' +  end_another_day_Date
                    console.log(end_another_day.value)
                    
                }else if(start_time < end_time){
                    end_another_day.value = another_day
                    iDays = hour_diff
                }
                iDays = iDays / 8
                $('#days_long').val(iDays)
            }
                break
            default:
        }
    }
</script>
@stop