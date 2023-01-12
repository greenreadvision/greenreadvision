@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">款項管理</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <a  href="/billPayment" class="page_title_a" >繳款單</a>
        </div>
    </div>
</div>
<div class="col-lg-12 " >
    <div class="row">
        <div id="loading">
            <img src="{{ URL::asset('gif/loadding.gif') }}" alt=""/>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons" hidden>
                    <label class="btn btn-secondary active w-50" style="border-top-left-radius: 25px;border-bottom-left-radius: 25px">
                        <input type="radio" name="options" onchange="changeBillPayment(0)" autocomplete="off" checked> 專案
                    </label>
                    <label class="btn btn-secondary w-50" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">
                        <input type="radio" name="options" onchange="changeBillPayment(1)" autocomplete="off"> 其他
                    </label>
                </div>
            </div>
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body show-project-billPayment">
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">繳款階段</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-review" name="select-review" onchange="select('review',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                                <option value='waiting'>待審核</option>
                                <option value='waiting-fix'>待修改</option>
                                <option value='managed'>已審核</option>
                                <option value='delete'>已刪除</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">繳款人</label>
                        <div class="col-lg-12">
                            <input placeholder="搜尋" type="text" list="list-account" id="search-remittancer" autocomplete="off" name="search-remittancer" class="rounded-pill form-control" onchange="selectRemittancer(this.value)">
                            <datalist id="list-account">
                            </datalist>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">負責人</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-user" name="select-user" onchange="select('user',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=""></option>
                                @foreach($users as $user)
                                <option value="{{$user['user_id']}}">{{$user['name']}}({{$user['nickname']}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">專案</label>
                        <div class="col-lg-12 mb-2">
                            <select type="text" id="select-project-year" name="select-project-year" onchange="selectProjectYears(this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <select type="text" id="select-project" name="select-project" onchange="select('project',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                                <optgroup id="select-project-grv_2" label="綠雷德">
                                <optgroup id="select-project-grv" label="綠雷德(舊)">
                                <optgroup id="select-project-rv" label="閱野">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">年份</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-year" name="select-year" onchange="select('year',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">月份</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-month" name="select-month" onchange="select('month',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                            </select>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <button class="w-100 btn btn-green rounded-pill" onclick="reset()"><span>重置</span> </button>
                    </div>
                </div>
                <div class="card-body show-other-billPayment">
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">繳款階段</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-other-review" name="select-other-review" onchange="selectOther('review',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                                <option value='waiting'>第一階段</option>
                                <option value='check'>第二階段</option>
                                <option value='complete'>繳款完成</option>
                                <option value='fix'>修改中</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">繳款人</label>
                        <div class="col-lg-12">
                            <input placeholder="搜尋" type="text" list="list-other-account" id="search-other-account" autocomplete="off" name="search-other-account" class="rounded-pill form-control" onchange="selectOtherRemittancer(this.value)">
                            <datalist id="list-other-account">
                            </datalist>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">負責人</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-other-user" name="select-other-user" onchange="selectOther('user',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=""></option>
                                @foreach($users as $user)
                                <option value="{{$user['user_id']}}">{{$user['name']}}({{$user['nickname']}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">類型</label>
                        <div class="col-lg-12 mb-2">
                            <select type="text" id="select-company" name="select-company" onchange="selectOther('company',this.options[this.options.selectedIndex].value)" class=" rounded-pill form-control">
                                <option value=''></option>
                                <option value="grv_2">綠雷德</option>
                                <option value="rv">閱野</option>
                                <option value="grv">綠雷德(舊)</option>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <select type="text" id="select-type" name="select-type" onchange="selectOther('type',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                                <option value='product'>商品</option>
                                <option value='event'>活動套裝</option>
                                <option value='other'>其他</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">年份</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-other-year" name="select-other-year" onchange="selectOther('year',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label ">月份</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-other-month" name="select-other-month" onchange="selectOther('month',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button class="w-100 btn btn-green rounded-pill" onclick="resetOther()"><span>重置</span> </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="card border-0 shadow" style="min-height: calc(100vh - 135px)">
                <div class="card-body show-project-billPayment">
                    @if(\Auth::user()->role == 'administrator' || \Auth::user()->role == 'supervisor' || \Auth::user()->role == 'proprietor')
                    <div class="form-group col-lg-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" onchange="reviewCheck('{{\Auth::user()->user_id}}')">
                            <label class="form-check-label" for="defaultCheck1">
                                審核主管
                            </label>
                        </div>
                    </div>
                    @endif
                    <div class="form-group col-lg-12">
                        <div class="row">
                            <div class="col-lg-2">
                                <input type="text" name="search-num" id="search-num" class="form-control  rounded-pill" placeholder="繳款單號" autocomplete="off" onkeyup="searchNum()">
                            </div>
                            <div class=" col-lg-4">
                                <input type="text" name="search" id="search" class="form-control  rounded-pill" placeholder="繳款事項" autocomplete="off" onkeyup="searchBillPayment()">
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end">
                                <button class="btn btn-green rounded-pill" onclick="location.href='{{route('billPayment.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>

                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 d-flex justify-content-between">
                        <div id="billPayment-page" class="d-flex align-items-end">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination mb-0">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div style="text-align: right">
                            @if(\Auth::user()->role == 'manager')
                            <button class="btn btn-black rounded-pill" data-toggle="modal" data-target="#deleteZipModal"><span class="mx-2">刪除多餘壓縮檔案：{{$ZipCount}}</span></button>
                            @endif
                            <button class="btn btn-red rounded-pill" data-toggle="modal" data-target="#downloadModal"><span class="mx-2">匯出資料</span></button>
                            <button class="btn btn-blue rounded-pill" onclick='tableToExcel()'><span class="mx-2">匯出 Excel</span></button>
                        </div>
                        

                    </div>
                    <div class="col-lg-12 table-style-invoice ">
                        <table id="search-billPayment">
                            
                        </table>
                    </div>

                </div>
                <div class="card-body show-other-billPayment">
                    <div class="form-group col-lg-12">
                        <button class=" btn btn-darkBlue rounded-pill" onclick="location.href='{{route('bank.index')}}'"><span class="mx-2">帳戶</span> </button>
                    </div>
                    @if(\Auth::user()->role == 'administrator' || \Auth::user()->role == 'supervisor' || \Auth::user()->role == 'proprietor')
                    <div class="form-group col-lg-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultOtherCheck1" onchange="reviewOtherCheck('{{\Auth::user()->user_id}}')">
                            <label class="form-check-label" for="defaultOtherCheck1">
                                審核主管
                            </label>
                        </div>
                    </div>
                    @endif
                    <div class="form-group col-lg-12">
                        <div class="row">
                            <div class="col-lg-2">
                                <input type="text" name="search-other-num" id="search-other-num" class="form-control  rounded-pill" placeholder="請款單號" autocomplete="off" onkeyup="searchOtherNum()">
                            </div>
                            <div class=" col-lg-4">
                                <input type="text" name="search-other" id="search-other" class="rounded-pill form-control" placeholder="請款事項" autocomplete="off" onkeyup="searchOtherBillPayment()">
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end">
                                <button class="btn btn-green rounded-pill" onclick="location.href='{{route('billPayment.create')}}'"><span class="mx-2">{{__('customize.Add')}}</span> </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 d-flex justify-content-between">
                        <div id="billPayment-other-page" class="d-flex align-items-end">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination mb-0">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div style="text-align: right">
                            @if(\Auth::user()->role == 'manager')
                            <button class="btn btn-black rounded-pill" data-toggle="modal" data-target="#deleteZipModal"><span class="mx-2">刪除多餘壓縮檔案：{{$ZipCount}}</span></button>
                            @endif
                            <button class="btn btn-red rounded-pill" data-toggle="modal" data-target="#downloadOtherModal"><span class="mx-2">匯出資料</span></button>
                            <button class="btn btn-blue rounded-pill" onclick='tableToExcelOther()'><span class="mx-2">匯出 Excel</span></button>
                        </div>
                    </div>

                    <div class="col-lg-12 table-style-invoice ">
                        <table id="search-other-billPayment">

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                確定要匯出?
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-red rounded-pill" data-dismiss="modal">否</button>
                <button class="btn btn-blue rounded-pill" onclick="FileToZip()" data-dismiss="modal">是</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="downloadOtherModal" tabindex="-1" role="dialog" aria-labelledby="downloadOtherModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                確定要匯出?
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-red rounded-pill" data-dismiss="modal">否</button>
                <button class="btn btn-blue rounded-pill" onclick="OtherFileToZip()" data-dismiss="modal">是</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteZipModal" tabindex="-1" role="dialog" aria-labelledby="deleteZipModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                刪除與否?
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-red rounded-pill" data-dismiss="modal">否</button>
                <button class="btn btn-blue rounded-pill" onclick="location.href = '/deleteZip'" data-dismiss="modal">是</button>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>


<script  type="text/javascript" charset="UTF-8">
    var url = window.location.href
    url = new URL(url)
    function ShowDiv() {
            $("#loading").show();
        }
    function HiddenDiv() {
            $("#loading").hide();
        }
    function FileToZip(){
        var file = JSON.stringify(billPayments)
        var path = ''
        $('#downloadModal').modal('hide')
        $.ajax({

            url:"/billPayment/Zip",
            type:'POST',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            data:{file:JSON.stringify(billPayments)},
            beforeSend: function () {
                ShowDiv();
            },
            success: function (data) {
                console.log(data)
                HiddenDiv();
                window.location = data
            },
            error: function(XMLHttpRequest, textStatus) { 
                console.log(XMLHttpRequest.status);
                console.log(XMLHttpRequest.readyState);
                console.log(textStatus);
                console.log(data);
            }
        })
    }

    function OtherFileToZip(){
        var file = JSON.stringify(other_billPayments)
        var path = ''
        $('#downloadOtherModal').modal('hide')
        $.ajax({

            url:"/billPayment/Zip",
            type:'POST',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            data:{file:JSON.stringify(other_billPayments)},
            beforeSend: function () {
                ShowDiv();
            },
            success: function (data) {
                console.log(data)
                HiddenDiv();
                window.location = data
            },
            error: function(XMLHttpRequest, textStatus) { 
                console.log(XMLHttpRequest.status);
                console.log(XMLHttpRequest.readyState);
                console.log(textStatus);
            
            }
        })
    }
    
</script>

<script type="text/javascript">
    function tableToExcel() {
        var isReceipt = ''
        var isComplete = ''
        var status = {
            'waiting': '審核中',
            'waiting-fix': '繳款被撤回',
            'managed': '審核通過',
            'delete': '已刪除'
        }
        var BillPaymentDate =''
        var BillPaymentBank =''
        var BillPaymentBankBranch =''
        var BillPaymentBankAccountNumber =''
        var BillPaymentBankAccountName =''
        var excel = [
            ['繳款單號', '繳款日期', '繳款人', '專案', '負責人', '繳款項目', '繳款事項', '繳款費用', '銀行名稱', '分行', '帳號', '戶名', '是否附上證明','匯款證明繳交日', '狀態']
        ];
        for (var i = 0; i < billPayments.length; i++) {
            isReceipt = ''
            if (billPayments[i]['receipt_file']) {
                isReceipt = '∨'
            }
            if (billPayments[i]['bank'] == '華南銀行') {
                BillPaymentBank ='華南銀行'
                BillPaymentBankBranch ='板橋分行'
                BillPaymentBankAccountNumber ='160-10-008-665-8'
                BillPaymentBankAccountName ='綠雷德創新股份有限公司'
                console.log('yes grv')
            }
            else if(billPayments[i]['bank'] == '第一銀行') {
                BillPaymentBank ='第一銀行'
                BillPaymentBankBranch ='雙和分行'
                BillPaymentBankAccountNumber ='23510036020'
                BillPaymentBankAccountName ='閱野文創股份有限公司'
                console.log('yes rv1')
            }
            else if(billPayments[i]['bank'] == '玉山銀行') {
                BillPaymentBank ='玉山銀行'
                BillPaymentBankBranch ='中和分行'
                BillPaymentBankAccountNumber ='0439-9400-03803'
                BillPaymentBankAccountName ='閱野文創股份有限公司'
                console.log('yes rv2')
            }
            else {
                console.log(billPayments[i]['bank'])
            }
            billPaymentDate = billPayments[i]['created_at'].substring(0,10);
            excel.push([billPayments[i]['finished_id'],billPaymentDate , billPayments[i]['remittancer'], billPayments[i].project['name'], billPayments[i].user['name'], billPayments[i]['title'], billPayments[i]['content'], billPayments[i]['price'], BillPaymentBank, BillPaymentBankBranch, BillPaymentBankAccountNumber, BillPaymentBankAccountName, isReceipt, billPayments[i]['receipt_date'], status[billPayments[i]['status']]])
        }
        var filename = "繳款表.xlsx";

        var ws_name = "工作表1";
        var wb = XLSX.utils.book_new(),
            ws = XLSX.utils.aoa_to_sheet(excel);
        XLSX.utils.book_append_sheet(wb, ws, ws_name);
        XLSX.writeFile(wb, filename);


    }
</script type="text/javascript">

<script type="text/javascript">
    function reviewCheck() {
        setBillPayment()
        listBillPayment() //列出符合條件的請款項目
        listPage()
    }

    function changeBillPayment(i) {
        if (i == 1) {
            document.getElementsByClassName('show-project-billPayment')[0].style.display = "none"
            document.getElementsByClassName('show-other-billPayment')[0].style.display = "inline"
            document.getElementsByClassName('show-project-billPayment')[1].style.display = "none"
            document.getElementsByClassName('show-other-billPayment')[1].style.display = "inline"
            reset()
        } else {
            document.getElementsByClassName('show-other-billPayment')[0].style.display = "none"
            document.getElementsByClassName('show-project-billPayment')[0].style.display = "inline"
            document.getElementsByClassName('show-other-billPayment')[1].style.display = "none"
            document.getElementsByClassName('show-project-billPayment')[1].style.display = "inline"
            resetOther()
        }
    }
    var user_id = '{{\Auth::user()->user_id}}'
    var user = ""
    var company = ""
    var project = ""
    var projectYear = ""
    var year = ""
    var month = ""
    var temp = ""
    var numTemp = ""
    var remittancerTemp = ""
    var remittancerName = ""
    var nowPage = 1
    var review = ""

    //帳務
    var remittancerNames = []
    var billPayments = []
    var projects = []
    $(document).ready(function() {
        resetOther()
        reset()

        setRemittancer()
        setOtherRemittancer()
        document.getElementsByClassName('show-other-billPayment')[0].style.display = "none"
        document.getElementsByClassName('show-other-billPayment')[1].style.display = "none"
    });

    function selectProjectYears(val) {
        projectYear = val
        project = ''
        $("#select-project-grv_2").empty();
        $("#select-project-grv").empty();
        $("#select-project-rv").empty();

        if (projectYear == '') {
            reset()
        } else {
            setBillPayment()
            projects = getNewProject()
            for (var i = 0; i < projects.length; i++) {
                if (projects[i]['name'] != "其他" && projects[i]['open_date'].substr(0, 4) == projectYear) {
                    if (projects[i]['company_name'] == "grv") {
                        $("#select-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    } else if (projects[i]['company_name'] == "rv") {
                        $("#select-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    } else if (projects[i]['company_name'] == "grv_2") {
                        $("#select-project-grv_2").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    }
                }
            }
            setYear()
        }
        setSearch()
        listBillPayment() //列出符合條件的請款項目
    }

    function select(type, id) {
        switch (type) {
            case 'user':
                user = id
                if (id == '') {
                    reset()
                } else {
                    projectYear = ''
                    company = ''
                    project = ''
                    year = ''
                    month = ''
                    nowPage = 1
                    setBillPayment()
                    setProject() //設置此人所屬專案
                    setYear()
                    setMonth()
                }
                break;
            case 'company':
                company = id
                if (id == '') {
                    reset()
                } else {
                    nowPage = 1
                    projectYear = ''
                    project = ''
                    year = ''
                    month = ''
                    setBillPayment()
                    setYear()
                    setMonth()
                }
                break;
            case 'project':
                project = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    nowPage = 1
                    year = ''
                    month = ''
                    setBillPayment()
                    setYear()
                    setMonth()
                }
                break;
            case 'year':
                year = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    nowPage = 1
                    month = ''
                    setBillPayment()
                    setMonth()
                }
                break;
            case 'month':
                month = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    nowPage = 1
                    setBillPayment()
                }
                break;
            default:
            case 'review':
                review = id
                if (id == '') {
                    reset()
                } else {
                    nowPage = 1
                    setBillPayment()
                }
        }
        if (id != '') {
            setSearchNum()
            setSearch()
            listBillPayment() //列出符合條件的請款項目
            listPage()
        }
    }

    function searchBillPayment() {
        temp = document.getElementById('search').value
        nowPage = 1
        setBillPayment()
        listBillPayment()
        listPage()
    }

    function searchNum() {
        numTemp = document.getElementById('search-num').value
        nowPage = 1
        setBillPayment()
        listBillPayment()
        listPage()
    }

    function selectRemittancer(id) {
        remittancerName = id
        if (id == '') {
            reset()
        } else {
            nowPage = 1
            year = ''
            month = ''
            setBillPayment()
            setYear()
            setMonth()
            setSearch()
            listBillPayment() //列出符合條件的請款項目
            listPage()
        }
    }

    function setBillPayment() {
        billPayments = getNewBillPayment()
        for (var i = 0; i < billPayments.length; i++) {
            if (user != '') {
                if (billPayments[i]['user_id'] != user) {
                    billPayments.splice(i, 1)
                    i--
                    continue
                }
            }
            if (company != '') {
                if (billPayments[i]['company_name'] != company) {
                    billPayments.splice(i, 1)
                    i--
                    continue
                }
            }
            if (project != '') {
                if (billPayments[i]['project_id'] != project) {
                    billPayments.splice(i, 1)
                    i--
                    continue
                } else {
                    $('#select-project-year').val(billPayments[i].project['open_date'].substr(0, 4))
                }
            }

            if (remittancerName != '') {
                if (billPayments[i]['remittancer'] != remittancerName) {
                    billPayments.splice(i, 1)
                    i--
                    continue
                }
            }
            if (year != '') {
                if (billPayments[i]['created_at'].substr(0, 4) != year) {
                    billPayments.splice(i, 1)
                    i--
                    continue
                }
            }

            if (month != '') {
                if (billPayments[i]['created_at'].substr(5, 2) != month) {
                    billPayments.splice(i, 1)
                    i--
                    continue
                }
            }

            if (temp != '') {
                if (billPayments[i]['content'] == null || billPayments[i]['content'].indexOf(temp) == -1) {
                    billPayments.splice(i, 1)
                    i--
                    continue
                }
            }

            if (numTemp != '') {
                if (billPayments[i]['finished_id'] == null || billPayments[i]['finished_id'].indexOf(numTemp) == -1) {
                    billPayments.splice(i, 1)
                    i--
                    continue
                }
            }
            if (review != '') {
                if (review != 'fix') {
                    if (billPayments[i]['status'] != review) {
                        billPayments.splice(i, 1)
                        i--
                        continue
                    }
                } else {
                    if (billPayments[i]['status'] != 'check-fix' && billPayments[i]['status'] != 'waiting-fix') {
                        billPayments.splice(i, 1)
                        i--
                        continue
                    }
                }
            }
            if ($('#defaultCheck1')[0] != null) {
                if ($('#defaultCheck1')[0].checked == true) {
                    if (billPayments[i]['reviewer'] != user_id) {
                        billPayments.splice(i, 1)
                        i--
                        continue
                    }
                }
            }
        }
    }

    function getNewBillPayment() {
        
        data = "{{$billPayments}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function getNewProject() {
        var temp = []
        var projectTemp = []
        for (var i = 0; i < billPayments.length; i++) {
            if (temp.indexOf(billPayments[i].project['name']) == -1) {
                temp.push(billPayments[i].project['name'])
                projectTemp.push(billPayments[i].project)
            }
        }
        return projectTemp
    }

    function changePage(index) {

        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listPage()
        listBillPayment()

    }

    function nextPage() {
        var number = Math.ceil(billPayments.length / 10)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listBillPayment()
        }

    }

    function previousPage() {
        var number = Math.ceil(billPayments.length / 10)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listBillPayment()
        }

    }

    function listPage() {
        $("#billPayment-page").empty();
        var parent = document.getElementById('billPayment-page');
        var table = document.createElement("div");
        var number = Math.ceil(billPayments.length / 10)
        var data = ''
        if (nowPage < 4) {
            for (var i = 0; i < number; i++) {
                if (i < 5) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (nowPage >= 4 && nowPage - 3 <= 2) {
            for (var i = 0; i < number; i++) {
                if (i < nowPage + 2) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (nowPage >= 4 && nowPage - 3 > 2 && number - nowPage > 5) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= nowPage - 3 && i <= nowPage + 1) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'

                } else if (i > nowPage + 1) {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + number + ')">' + number + '</a></li>'
                    break
                }


            }
        } else if (number - nowPage <= 5 && number - nowPage >= 4) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= nowPage - 3) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        } else if (number - nowPage < 4) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= number - 5) {
                    data = data + '<li class="page-item page-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        }
        var previous = "previous"
        var next = "next"
        table.innerHTML = '<nav aria-label="Page navigation example">' +
            '<ul class="pagination mb-0">' +
            '<li class="page-item">' +
            '<a class="page-link" href="javascript:void(0)" onclick="previousPage()" aria-label="Previous">' +
            '<span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>' +
            '</a>' +
            '</li>' +
            data +
            '<li class="page-item">' +
            '<a class="page-link" href="javascript:void(0)" onclick="nextPage()" aria-label="Next">' +
            '<span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>' +
            '</a>' +
            '</li>' +
            '</ul>' +
            '</nav>'

        parent.appendChild(table);

        $(".page-" + String(nowPage)).addClass('active')
    }

    function listBillPayment() {
        $("#search-billPayment").empty();
        var parent = document.getElementById('search-billPayment');
        var table = document.createElement("tbody");

        table.innerHTML = '<tr class="text-white">' +
            '<th>繳款單號</th>' +
            '<th>繳款人</th>' +
            '<th>專案</th>' +
            '<th>繳款項目</th>' +
            '<th>繳款金額</th>' +
            '<th>繳款日期</th>' +
            '<th>審核日期</th>' +
            '<th>狀態</th>' +
            '</tr>'
        var tr, span, name, a


        for (var i = 0; i < billPayments.length; i++) {
            if (i >= (nowPage - 1) * 10 && i < nowPage * 10) {
                table.innerHTML = table.innerHTML + setData(i)
            } else if (i >= nowPage * 10) {
                break
            }
        }
        parent.appendChild(table);
    }

    function setData(i) {
        if (billPayments[i].status == 'waiting') {
            span = "<div class='progress' data-toggle='tooltip' data-placement='top' title='等待審核中'>" +
                "<div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>" +
                "</div>" +
                "</div>";

        } else if (billPayments[i].status == 'waiting-fix') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='繳款被撤回，請修改'>" +
                "<div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (billPayments[i].status == 'managed') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='已審核'>" +
                "<div class='progress-bar bg-success' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if(billPayments[i].status == 'delete') {
            span = " <div title='已註銷'>" +
                "<img src='{{ URL::asset('gif/cancelled.png') }}' alt='' style='width:100%'/>" +
                "</div>"
        }

        var UserName = billPayments[i].user['name'] 

        if((billPayments[i].user['role']=='intern'||billPayments[i].user['role'] == 'manager')&&billPayments[i].intern_name != null){
            UserName = billPayments[i].intern_name
        }

        if(billPayments[i].review_date == null || billPayments[i].status != 'managed') {
            var reviewDate = '-未審核-'
        }else {
            var reviewDate = billPayments[i].review_date
        }
        a = "/billPayment/" + billPayments[i]['payment_id'] + "/review"
        tr = "<tr>" +
            "<td width='12%'><a href='" + a + "' target='_blank'>" + billPayments[i].finished_id + "</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + billPayments[i].remittancer + "</td>" +
            "<td width='20%'><a href='" + a + "' target='_blank'>" + billPayments[i].project['name'] + "</td>" +
            "<td width='19%'><a href='" + a + "' target='_blank'>" + billPayments[i].content + "</a></td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + commafy(billPayments[i].price) + "</td>" +
            "<td width='12%'> <a href='" + a + "' target='_blank'>" + billPayments[i].receipt_date + "</td>" +
            "<td width='12%'> <a href='" + a + "' target='_blank'>" + reviewDate + "</td>" +
            "<td width='5%'>" + span + "</td>" +
            "</tr>"


        return tr
    }

    function commafy(num) {
        num = num + "";
        var re = /(-?\d+)(\d{3})/
        while (re.test(num)) {
            num = num.replace(re, "$1,$2")
        }
        return num;
    }

    function reset() {
        if ($('#defaultCheck1')[0] != null) {

            $('#defaultCheck1')[0].checked = false
        }
        billPayments = getNewBillPayment()
        setUser()
        setCompany()
        projectYear = ''
        setProject()
        remittancerTemp = ''
        $("#search-remittancer").val("");
        remittancerName = ''
        setYear()
        setMonth()
        setSearch()
        setSearchNum()
        nowPage = 1
        $("#billPayment-page").empty();
        $("#select-review").val("");

        listBillPayment()
        listPage()
    }

    function setUser() {
        user = ''
        $("#select-user").val("");
    }

    function setCompany() {
        company = ''
        $("#select-company").val("");
    }

    function setProject() {
        projects = getNewProject()
        project = ''
        $("#select-project-grv_2").empty();
        $("#select-project-grv").empty();
        $("#select-project-rv").empty();

        var projectYears = [] //初始化

        for (var i = 0; i < projects.length; i++) {
            if (projectYears.indexOf(projects[i]['open_date'].substr(0, 4)) == -1) {
                projectYears.push(projects[i]['open_date'].substr(0, 4))
            }
            if (projects[i]['name'] != "綠雷德-其他") {
                if (projects[i]['company_name'] == "grv") {
                    $("#select-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                } else if (projects[i]['company_name'] == "rv") {
                    $("#select-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                } else if (projects[i]['company_name'] == "grv_2") {
                    $("#select-project-grv_2").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                }
            }
        }

        $("#select-project-year").val("");
        $("#select-project-year").empty();
        $("#select-project-year").append("<option value=''></option>");
        projectYears.sort()
        projectYears.reverse()
        for (var i = 0; i < projectYears.length; i++) {
            $("#select-project-year").append("<option value='" + projectYears[i] + "'>" + projectYears[i] + "</option>");
        }
    }

    function setRemittancer() {
        billPayments = getNewBillPayment()

        remittancerName = ''
        remittancerNames = [] //初始化

        for (var i = 0; i < billPayments.length; i++) {
            
            if (remittancerNames.indexOf(billPayments[i]['remittancer']) == -1) {
                if (remittancerTemp != '') {
                    if (billPayments[i]['remittancer'].indexOf(remittancerTemp) != -1) {
                        remittancerNames.push(billPayments[i]['remittancer'])
                    }
                } else {
                    remittancerNames.push(billPayments[i]['remittancer'])
                }
            }
        }
        remittancerNames.sort(function(a, b) {
            return a.length - b.length;
        });

        for (var i = 0; i < remittancerNames.length; i++) {
            $("#list-account").append("<option value='" + remittancerNames[i] + "'>" + remittancerNames[i] + "</option>");
        }
    }

    function setYear() {
        year = ''
        var years = [] //初始化
        $("#select-year").val("");  
        $("#select-year").empty();
        $("#select-year").append("<option value=''></option>");

        for (var i = 0; i < billPayments.length; i++) {
            if (years.indexOf(billPayments[i]['created_at'].substr(0, 4)) == -1) {
                years.push(billPayments[i]['created_at'].substr(0, 4))
                $("#select-year").append("<option value='" + billPayments[i]['created_at'].substr(0, 4) + "'>" + billPayments[i]['created_at'].substr(0, 4) + "</option>");
            }
        }
    }

    function setMonth() {
        month = ""
        $("#select-month").empty();
        $("#select-month").append("<option value=''></option>");
        for (var i = 0; i < 12; i++) {
            if (i < 9) {
                $("#select-month").append("<option value='0" + (i + 1) + "'>" + "0" + (i + 1) + "</option>");
            } else {
                $("#select-month").append("<option value='" + (i + 1) + "'>" + (i + 1) + "</option>");

            }
        }
    }

    function setSearch() {
        temp = ''
        document.getElementById('search').value = temp
    }

    function setSearchNum() {
        numTemp = ''
        document.getElementById('search-num').value = numTemp
    }
</script>

<script type="text/javascript">
    function tableToExcelOther() {
        var isReceipt = ''
        var isComplete = ''
        var status = {
            'waiting': '第一階段審核中',
            'waiting-fix': '請款被撤回',
            'check': '第二階段審核中',
            'check-fix': '請款被撤回',
            'complete': '匯款完成'
        }
        var otherBillPaymentDate =''
        var otherBillPaymentBank =''
        var otherBillPaymentBankBranch =''
        var otherBillPaymentBankAccountNumber =''
        var otherBillPaymentBankAccountName =''
        var excel = [
            ['繳款單號', '繳款日期', '繳款人', '類型', '負責人', '繳款項目', '繳款事項', '繳款費用', '銀行名稱', '分行', '帳號', '戶名', '是否附上發票', '是否匯款', '狀態']
        ];
        for (var i = 0; i < other_billPayments.length; i++) {
            isReceipt = ''
            isComplete = ''
            if (other_billPayments[i]['status'] == 'complete') {
                isComplete = '∨'
            }
            if (other_billPayments[i]['receipt'] == 1) {
                isReceipt = '∨'
            }
            if (other_billPayments[i]['bank'] == 'grv') {
                otherBillPaymentBank ='華南銀行'
                otherBillPaymentBankBranch ='板橋分行'
                otherBillPaymentBankAccountNumber ='160-10-008-665-8'
                otherBillPaymentBankAccountName ='綠雷德創新股份有限公司'
                console.log('yes grv')
            }
            else if(other_billPayments[i]['bank'] == 'rv1') {
                otherBillPaymentBank ='第一銀行'
                otherBillPaymentBankBranch ='雙和分行'
                otherBillPaymentBankAccountNumber ='23510036020'
                otherBillPaymentBankAccountName ='閱野文創股份有限公司'
                console.log('yes rv1')
            }
            else if(other_billPayments[i]['bank'] == 'rv2') {
                otherBillPaymentBank ='玉山銀行'
                otherBillPaymentBankBranch ='中和分行'
                otherBillPaymentBankAccountNumber ='0439-9400-03803'
                otherBillPaymentBankAccountName ='閱野文創股份有限公司'
                console.log('yes rv2')
            }
            else {
                console.log(other_billPayments[i]['bank'])
            }
            otherBillPaymentDate = other_billPayments[i]['created_at'].substring(0,10);
            excel.push([other_billPayments[i]['finished_id'], otherBillPaymentDate , other_billPayments[i]['remittancer'], other_billPayments[i]['type'], other_billPayments[i].user['name'], other_billPayments[i]['content'], other_billPayments[i]['content'], other_billPayments[i]['price'], otherBillPaymentBank, otherBillPaymentBankBranch, otherBillPaymentBankAccountNumber, otherBillPaymentBankAccountName, isReceipt, isComplete, status[other_billPayments[i]['status']]])
        }
        var filename = "繳款表.xlsx";

        var ws_name = "工作表1";
        var wb = XLSX.utils.book_new(),
            ws = XLSX.utils.aoa_to_sheet(excel);
        XLSX.utils.book_append_sheet(wb, ws, ws_name);
        XLSX.writeFile(wb, filename);


    }
</script>

<script type="text/javascript">
    function reviewOtherCheck() {
        setOtherBillPayment()
        listOtherBillPayment() //列出符合條件的請款項目
        listOtherPage()
    }
    var other_user = ""
    var company = ""
    var other_type = ""
    var other_year = ""
    var other_month = ""
    var other_temp = ""
    var other_num_temp = ""
    var nowOtherPage = 1
    var remittancerOtherTemp = ""
    var remittancerOtherName = ""
    var other_review = ""
    //帳務
    


    var remittancerOtherNames = []
    var chinese = {
        salary: "薪資-工讀生/農博駐場",
        insurance: "勞健保/勞退",
        rent: "房租-北科/利多萊",
        cash: "每月零用金",
        tax:"公司營業稅",
        accounting: '會計師記帳費',
        other: "其他",
        grv: "綠雷德(舊)",
        rv: "閱野",
        grv_2: "綠雷德"
    }

    //帳務
    var other_billPayments = []

    function selectOther(type, id) {
        switch (type) {
            case 'user':
                other_user = id
                if (id == '') {
                    resetOther()
                } else {
                    company = ''
                    other_type = ''
                    year = ''
                    month = ''
                    nowOtherPage = 1
                    setOtherBillPayment()
                    setOtherYear()
                    setOtherMonth()
                }
                break;
            case 'company':
                company = id
                if (id == '') {
                    resetOther()
                } else {
                    other_year = ''
                    other_month = ''
                    nowOtherPage = 1
                    setOtherBillPayment()
                    setOtherYear()
                    setOtherMonth()
                }
                break;
            case 'type':
                other_type = id
                if (id == '') {
                    resetOther()
                } else {
                    other_year = ''
                    other_month = ''
                    nowOtherPage = 1
                    setOtherBillPayment()
                    setOtherYear()
                    setOtherMonth()
                }
                break;
            case 'year':
                other_year = id
                if (id == '') {
                    resetOther()
                } else {
                    other_month = ''
                    nowOtherPage = 1
                    setOtherBillPayment()
                    setOtherMonth()
                }
                break;
            case 'month':
                other_month = id //傳入選取值
                if (id == '') {
                    resetOther()
                } else {
                    nowOtherPage = 1
                    setOtherBillPayment()
                }
                break;
            case 'review':
                other_review = id
                if (id == '') {
                    resetOther()
                } else {
                    nowOtherPage = 1
                    setOtherBillPayment()
                }
                break;
            default:

        }
        if (id != "") {
            setOtherNumSearch()
            setOtherSearch()
            listOtherBillPayment() //列出符合條件的請款項目
            listOtherPage()
        }
    }

    function selectOtherRemittancer(id) {
        remittancerOtherName = id
        if (id == '') {
            resetOther()
        } else {
            nowOtherPage = 1
            other_year = ''
            other_month = ''
            setOtherBillPayment()
            setOtherYear()
            setOtherMonth()
            setOtherSearch()
            listOtherBillPayment() //列出符合條件的請款項目
            listOtherPage()
        }
    }

    function searchOtherBillPayment() {
        other_temp = document.getElementById('search-other').value
        nowOtherPage = 1
        setOtherBillPayment()
        listOtherBillPayment()
        listOtherPage()
    }

    function searchOtherNum() {
        other_num_temp = document.getElementById('search-other-num').value
        nowOtherPage = 1
        setOtherBillPayment()
        listOtherBillPayment()
        listOtherPage()
    }

    function setOtherBillPayment() {
        other_billPayments = getNewOtherBillPayment()
        for (var i = 0; i < other_billPayments.length; i++) {
            if (other_user != '') {
                if (other_billPayments[i]['user_id'] != other_user) {
                    other_billPayments.splice(i, 1)
                    i--
                    continue
                }
            }
            if (company != '') {
                if (other_billPayments[i]['company_name'] != company) {
                    other_billPayments.splice(i, 1)
                    i--
                    continue
                }
            }
            if (other_type != '') {
                if (other_billPayments[i]['type'] != other_type) {
                    other_billPayments.splice(i, 1)
                    i--
                    continue
                }
            }
            if (remittancerOtherName != '') {
                if (other_billPayments[i]['remittancer'] != remittancerOtherName) {
                    other_billPayments.splice(i, 1)
                    i--
                    continue
                }
            }
            if (other_year != '') {
                if (other_billPayments[i]['created_at'].substr(0, 4) != other_year) {
                    other_billPayments.splice(i, 1)
                    i--
                    continue
                }
            }

            if (other_month != '') {
                if (other_billPayments[i]['created_at'].substr(5, 2) != other_month) {
                    other_billPayments.splice(i, 1)
                    i--
                    continue
                }
            }

            if (other_temp != '') {
                if (other_billPayments[i]['title'] == null || other_billPayments[i]['content'].indexOf(other_temp) == -1) {
                    other_billPayments.splice(i, 1)
                    i--
                    continue
                }
            }

            if (other_num_temp != '') {
                if (other_billPayments[i]['finished_id'] == null || other_billPayments[i]['finished_id'].indexOf(other_num_temp) == -1) {
                    other_billPayments.splice(i, 1)
                    i--
                    continue
                }
            }
            if (other_review != '') {
                if (other_review != 'fix') {
                    if (other_billPayments[i]['status'] != other_review) {
                        other_billPayments.splice(i, 1)
                        i--
                        continue
                    }
                } else {
                    if (other_billPayments[i]['status'] != 'check-fix' && other_billPayments[i]['status'] != 'waiting-fix') {
                        other_billPayments.splice(i, 1)
                        i--
                        continue
                    }
                }
            }
            if ($('#defaultOtherCheck1')[0] != null) {
            if ($('#defaultOtherCheck1')[0].checked == true) {
                if (other_billPayments[i]['reviewer'] != user_id) {
                    other_billPayments.splice(i, 1)
                    i--
                    continue
                }
            }
            }
        }


    }


    function getNewOtherBillPayment() {
        data = "{{$otherBillPayments}}"
        
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function changeOtherPage(index) {

        var temp = document.getElementsByClassName('page-other-item')

        $(".page-other-" + String(nowOtherPage)).removeClass('active')
        nowOtherPage = index
        $(".page-other-" + String(nowOtherPage)).addClass('active')

        listOtherPage()
        listOtherBillPayment()

    }

    function nextOtherPage() {
        var number = Math.ceil(other_billPayments.length / 10)

        if (nowOtherPage < number) {
            var temp = document.getElementsByClassName('page-other-item')
            $(".page-other-" + String(nowOtherPage)).removeClass('active')
            nowOtherPage++
            $(".page-other-" + String(nowOtherPage)).addClass('active')
            listOtherPage()
            listOtherBillPayment()
        }

    }

    function previousOtherPage() {
        var number = Math.ceil(other_billPayments.length / 10)

        if (nowOtherPage > 1) {
            var temp = document.getElementsByClassName('page-other-item')
            $(".page-other-" + String(nowOtherPage)).removeClass('active')
            nowOtherPage--
            $(".page-other-" + String(nowOtherPage)).addClass('active')
            listOtherPage()
            listOtherBillPayment()
        }

    }

    function listOtherPage() {
        $("#billPayment-other-page").empty();
        var parent = document.getElementById('billPayment-other-page');
        var table = document.createElement("div");
        var number = Math.ceil(other_billPayments.length / 10)
        var data = ''
        if (nowOtherPage < 4) {
            for (var i = 0; i < number; i++) {
                if (i < 5) {
                    data = data + '<li class="page-item page-other-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeOtherPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-other-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeOtherPage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (nowOtherPage >= 4 && nowOtherPage - 3 <= 2) {
            for (var i = 0; i < number; i++) {
                if (i < nowOtherPage + 2) {
                    data = data + '<li class="page-item page-other-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeOtherPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                } else {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-other-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeOtherPage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (nowOtherPage >= 4 && nowOtherPage - 3 > 2 && number - nowOtherPage > 5) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-other-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeOtherPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= nowOtherPage - 3 && i <= nowOtherPage + 1) {
                    data = data + '<li class="page-item page-other-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeOtherPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'

                } else if (i > nowOtherPage + 1) {
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                    data = data + '<li class="page-item page-other-' + number + '"><a class="page-link" href="javascript:void(0)" onclick="changeOtherPage(' + number + ')">' + number + '</a></li>'
                    break
                }
            }
        } else if (number - nowOtherPage <= 5 && number - nowOtherPage >= 4) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-other-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeOtherPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= nowOtherPage - 3) {
                    data = data + '<li class="page-item page-other-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeOtherPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        } else if (number - nowOtherPage < 4) {
            for (var i = 0; i < number; i++) {
                if (i == 0) {
                    data = data + '<li class="page-item page-other-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeOtherPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                    data = data + '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)" ">...</a></li>'
                } else if (i >= number - 5) {
                    data = data + '<li class="page-item page-other-' + (i + 1) + '"><a class="page-link" href="javascript:void(0)" onclick="changeOtherPage(' + (i + 1) + ')">' + (i + 1) + '</a></li>'
                }
            }
        }

        table.innerHTML = '<nav aria-label="Page navigation example">' +
            '<ul class="pagination mb-0">' +
            '<li class="page-item">' +
            '<a class="page-link" href="javascript:void(0)" onclick="previousOtherPage()" aria-label="Previous">' +
            '<span aria-hidden="true"><i class="fas fa-caret-left" style="width:14.4px"></i></span>' +
            '</a>' +
            '</li>' +
            data +
            '<li class="page-item">' +
            '<a class="page-link" href="javascript:void(0)" onclick="nextOtherPage()" aria-label="Next">' +
            '<span aria-hidden="true"><i class="fas fa-caret-right" style="width:14.4px"></i></span>' +
            '</a>' +
            '</li>' +
            '</ul>' +
            '</nav>'

        parent.appendChild(table);

        $(".page-other-" + String(nowOtherPage)).addClass('active')
    }

    function listOtherBillPayment() {

        $("#search-other-billPayment").empty();
        var parent = document.getElementById('search-other-billPayment');
        var table = document.createElement("tbody");

        table.innerHTML = '<tr class="text-white">' +
            '<th>繳款單號</th>' +
            '<th>繳款人</th>' +
            '<th>類型</th>' +
            '<th>繳款項目</th>' +
            '<th>繳款金額</th>' +
            '<th>繳款日期</th>' +
            '<th>審核日期</th>' +
            '<th>狀態</th>' +
            '</tr>'
        var tr, span, name, a


        for (var i = 0; i < other_billPayments.length; i++) {
            if (i >= (nowOtherPage - 1) * 10 && i < nowOtherPage * 10) {
                table.innerHTML = table.innerHTML + setOtherData(i)
            } else if (i >= nowOtherPage * 10) {
                break
            }
        }


        parent.appendChild(table);
    }

    function setOtherData(i) {
        if (other_billPayments[i].status == 'waiting') {
            span = "<div class='progress' data-toggle='tooltip' data-placement='top' title='尚未審核'>" +
                "<div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>" +
                "</div>" +
                "</div>";

        } else if (other_billPayments[i].status == 'waiting-fix') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='修改中'>" +
                "<div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (other_billPayments[i].status == 'check') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='等待主管審核'>" +
                "<div class='progress-bar bg-danger' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (other_billPayments[i].status == 'check-fix') {

            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='修改中'>" +
                "<div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"

        } else if (other_billPayments[i].status == 'complete'||other_billPayments[i].status == 'complete_petty') {
            span = " <div class='progress' data-toggle='tooltip' data-placement='top' title='已匯款'>" +
                "<div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>" +
                "</div>"
        } else if(other_billPayments[i].status == 'delete') {
            span = " <div title='已註銷'>" +
                "<img src='{{ URL::asset('gif/cancelled.png') }}' alt='' style='width:100%'/>" +
                "</div>"
        }
        if(other_billPayments[i]['remittance_date'] == null){
            var remittance_date = '-未審核完畢-'
        }else{
            var remittance_date = other_billPayments[i]['remittance_date'];
        }
        if(other_billPayments[i]['status'] == 'complete_petty'){
            var petty = '零-'
        }
        else{
            var petty = ''
        }

        var UserName2 = other_billPayments[i].user['name'] 

        if((other_billPayments[i].user['role']=='intern'||other_billPayments[i].user['role'] == 'manager')&&other_billPayments[i].intern_name != null){
            UserName2 = other_billPayments[i].intern_name
        }

        a = "/billPayment/" + other_billPayments[i]['other_payment_id'] + "/review/other"
        tr = "<tr>" +
            "<td width='11%'><a href='" + a + "' target='_blank'>" + other_billPayments[i].finished_id + "</td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + other_billPayments[i].remittancer + "</td>" +
            "<td width='19%'><a href='" + a + "' target='_blank'>" + chinese[other_billPayments[i].company_name] + "-" + chinese[other_billPayments[i].type] + "</a></td>" +
            "<td><a href='" + a + "' target='_blank'>" + other_billPayments[i].content + "</a></td>" +
            "<td width='10%'><a href='" + a + "' target='_blank'>" + commafy(other_billPayments[i].price) + "</td>" +
            "<td width='12%'><a href='" + a + "' target='_blank'>" + other_billPayments[i].created_at.substr(0, 10) + "</td>" +
            "<td width='12%'><a href='" + a + "' target='_blank'>" + remittance_date + "</td>" +
            "<td width='5%'>" + span + "</td>" +
            "</tr>"


        return tr
    }

    function resetOther() {
        if ($('#defaultOtherCheck1')[0] != null) {
        $('#defaultOtherCheck1')[0].checked = false
        }
        other_billPayments = getNewOtherBillPayment()
        setOtherUser()
        company = ''
        $("#select-company").val("");
        remittancerOtherTemp = ''
        $("#search-other-account").val("");
        remittancerOtherName = ''
        other_type = ''
        $("#select-type").val("");
        setOtherYear()
        setOtherMonth()
        setOtherSearch()
        setOtherNumSearch()
        nowOtherPage = 1
        $("#select-other-review").val("");

        $("#billPayment-other-page").empty();
        listOtherBillPayment()
        listOtherPage()
    }

    function setOtherUser() {
        other_user = ''
        $("#select-other-user").val("");
    }

    function setOtherRemittancer() {
        other_billPayments = getNewOtherBillPayment()
        remittancerOtherName = ''
        remittancerOtherNames = [] //初始化


        for (var i = 0; i < other_billPayments.length; i++) {
            if (remittancerOtherNames.indexOf(other_billPayments[i]['remittancer']) == -1) {
                if (remittancerOtherTemp != '') {
                    if (other_billPayments[i]['remittancer'].indexOf(remittancerOtherTemp) != -1) {
                        remittancerOtherNames.push(other_billPayments[i]['remittancer'])
                    }
                } else {
                    remittancerOtherNames.push(other_billPayments[i]['remittancer'])
                }
            }
        }
        remittancerOtherNames.sort(function(a, b) {
            return a.length - b.length;
        });
        for (var i = 0; i < remittancerOtherNames.length; i++) {
            $("#list-other-account").append("<option value='" + remittancerOtherNames[i] + "'>" + remittancerOtherNames[i] + "</option>");
        }
    }

    function setOtherYear() {
        other_year = ''
        var years = [] //初始化
        $("#select-other-year").val("");
        $("#select-other-year").empty();
        $("#select-other-year").append("<option value=''></option>");

        for (var i = 0; i < other_billPayments.length; i++) {
            if (years.indexOf(other_billPayments[i]['created_at'].substr(0, 4)) == -1) {
                years.push(other_billPayments[i]['created_at'].substr(0, 4))
                $("#select-other-year").append("<option value='" + other_billPayments[i]['created_at'].substr(0, 4) + "'>" + other_billPayments[i]['created_at'].substr(0, 4) + "</option>");
            }
        }
    }

    function setOtherMonth() {
        other_month = ""
        $("#select-other-month").empty();
        $("#select-other-month").append("<option value=''></option>");
        for (var i = 0; i < 12; i++) {
            if (i < 9) {
                $("#select-other-month").append("<option value='0" + (i + 1) + "'>" + "0" + (i + 1) + "</option>");
            } else {
                $("#select-other-month").append("<option value='" + (i + 1) + "'>" + (i + 1) + "</option>");

            }
        }
    }

    function setOtherSearch() {
        other_temp = ''
        document.getElementById('search-other').value = other_temp
    }

    function setOtherNumSearch() {
        other_num_temp = ''
        document.getElementById('search-other-num').value = other_num_temp
    }
</script>

@stop