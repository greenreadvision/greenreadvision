@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <span class="page_title_span">款項管理</span>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">建立勞務單</span>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-3 mb-2">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">專案負責人</label>
                        <div class="col-lg-12">
                            <select type="text" id="select-project-user" name="select-project-user" onchange="select('user',this.options[this.options.selectedIndex].value)" class="form-control mb-2 rounded-pill">
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
                            <select type="text" id="select-project-year" name="select--project-year" onchange="selectProjectYears(this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <select type="text" id="select-project" name="select-project" onchange="select('project',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                <option value=''></option>
                                <optgroup id="select-project-grv_2" label="綠雷德">
                                <optgroup id="select-project-rv" label="閱野">
                                <optgroup id="select-project-grv" label="綠雷德(舊)">
                                <optgroup id="select-project-other" label="其他">
                                    <option value='實習/工讀生'>實習/工讀生</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-12 col-form-label">活動日期</label>
                        <div class="col-lg-12 mb-2">
                            <input class="rounded-pill form-control" id="date" type="date" onchange="selectEventDate(event)"/>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button id="print_button" class="w-100 btn btn-green rounded-pill print_button" disabled="disabled">{{__('customize.Print')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card border-0 shadow" style="min-height: calc(100vh - 135px)">
                <div class="card-body">
                    <div id="print_box">
                        <table class="mb-3" style="margin-left: auto;margin-right: auto;" width="90%">
                            <tbody>
                                <tr>
                                    <td style="text-align: left">
                                        <img id="project_img" width="100px" height="100px" src=""/>
                                    </td>
                                    <td style="text-align: end;margin:0px;padding:0px;">
                                        <div id="company_ID" style="font-weight:bold;font-size:16pt"></div>
                                        <div style=" font-size:12pt">台北市大安區忠孝東路三段1號光華館310室</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr style="border:1px dashed#000"/>
                        <table class="mb-3" style="margin-left: auto;margin-right: auto;" width="90%">
                            <tbody>
                                <tr>
                                    <td>
                                        <span style="text-align: center;font-size:20pt;border-bottom: 5px double #000"><strong>勞 務 報 酬 單</strong></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="" style="margin: auto; border: 5px #000 double;padding:5px;" rules="all" cellpadding='5'; width="90%">
                            <tbody>
                                <tr>
                                    <td style="text-align: center;font-size: 14pt;" width="20%" colspan="4">領款人</td>
                                    <td style="text-align: end;font-size: 14pt;" width="45%" colspan="9">(親簽)</td>
                                    <td style="text-align: center;font-size: 14pt;" width="15%" colspan="3">身分證字號</td>
                                    <td width="20%" colspan="4"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size: 14pt;" width="20%" colspan="4">戶籍地址</td>
                                    <td width="45%" colspan="9"></td>
                                    <td style="text-align: center;font-size: 14pt;" width="15%" colspan="3">通訊電話</td>
                                    <td width="20%" colspan="4"></td>
                                </tr>
                                <tr >
                                    <td style="text-align: left;font-size: 16pt;" width="100%"  colspan="20">於中華民國<b id="year"></b> 年　<b id="month"></b>　月　<b id="day"></b>　日茲收到 <b id="companyName"></b>下列款項：</td>
                                </tr>
                                <tr>
                                    <td rowspan="4"  style="text-align: center" width="5%" colspan="1">領 款 金 額</td>
                                    <td style="text-align: left;margin:0px;padding:0px;font-size:10.5pt" width=15% colspan="3" rowspan="1">　
                                        <div>□非固定薪資(50)</div>
                                        <div>(攝影師/工作人員/工讀生/車馬費等)</div>
                                    </td>
                                    <td style="text-align: left" width="80%"colspan="16" rowspan="1">
                                        <div>領款總額：新台幣<u>　　　　　</u>元</div>
                                        <div>所得總額超過86,001元，需代扣5％所得稅，新台幣<u>　　　　　　</u>元。</div>
                                        <div>所得總額超過25,250元，需代扣2.11％二代健保補充保費，新台幣<u>　　　　　</u>元。</div>
                                        <div>領款淨額：新台幣<u>　　　　　</u>元</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;margin:0px;padding:0px;font-size:10.5pt" width="15%" colspan="3" rowspan="1">　
                                        <div>□競技競賽及機會中獎獎金(91)</div>
                                    </td>
                                    <td style="text-align: left;font-size:10pt" width="80%" colspan="16" rowspan="1">
                                        <div>□獎金：新台幣<u>　　　　　</u>元</div>
                                        <div>□獎品：<u>　　　　　</u>(填列品名)，市值<u>　　　　　</u>元</div>
                                        <div>註：所得總額超過20,010元，需代扣10％所得稅。</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;margin:0px;padding:0px;font-size:10.5pt" width="15%" colspan="3" rowspan="1">　
                                        <div>執行業務報酬(9A)</div>
                                        <div>□70表演人</div>
                                        <div>□90其他(護理師)</div>
                                        <div>□<u>　　　　　</u></div>
                                    </td>
                                    <td style="text-align: left;font-size:10pt" width="80%" colspan="16" rowspan="2">
                                        <div>提供勞務內容<u>　　　　　</u></div>
                                        <div>領款總額：新台幣<u>　　　　　</u>元 </div>
                                        <div>所得總額超過20,010元，需代扣10％所得稅，新台幣<u>　　　　　</u>元。</div>
                                        <div>所得總額達20,000元，需代扣2.11％二代健保補充保費，新台幣<u>　　　　　</u>元。(註)</div>
                                        <div>領款淨額：新台幣<u>　　　　　</u>元</div>
                                        <div style="font-size: 8pt">註：以執行業務所得為投保金額者，包括：專門職業及技術人員自行執者 (第 1類 第 5目被保險人)或自營作業且在職工會加保者（第 2類第 1目被保險人）免扣，請檢附投保證明文件。</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;margin:0px;padding:0px;font-size:10.5pt" width="15%" colspan="3" rowspan="1">
                                        <div>稿費所得(9B)</div>
                                        <div>□98非自行出版</div>
                                        <div>□99自行出版</div>
                                        <div>Ex.稿費/演講費/導覽老師</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center" width="50%" colspan="11">身分證正面</td>
                                    <td style="text-align: center" width="50%" colspan="9">身分證背面</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center" height="300px" width="50%" colspan="11"></td>
                                    <td style="text-align: center" height="300px" width="50%" colspan="9"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size: 12pt" width="15%" colspan="3">專案名稱</td>
                                    <td style="text-align: center;font-size: 12pt" width="45%" colspan="9"><b id="projectName"></b></td>
                                    <td style="text-align: center;font-size: 12pt" width="20%" colspan="4">專案負責人</td>
                                    <td style="text-align: center;font-size: 12pt" width="20%" colspan="4"><b id="projectUser"></b></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;font-size: 8pt" colspan="20">
                                        <div>注意事項：</div>
                                        <div>　　壹、領款人需填寫上下方<u>框內相關資料</u>，並附上<u>身分證正反面影本</u>方能生效，繳回此份文件之<u>正本</u>。</div>
                                        <div>　　貳、領款金額若超過下限，其領款人符合免扣取補充保費身分者【低收入/大學生(需符合無專職工作)/職業工會/執行業務所得投保.. ..等】務必附上證明文件。</div>
                                        <div>　　參、領款人與簽單人同為一人，如有冒領或偽造，應負法律之責。</div>
                                        <div>　　肆、此項金額將於年度收入，綠雷德文創有責給予扣繳憑單。</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
@section('script')
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    //選單參數
    var user=""
    var projectYear=""
    var project = ""
    //其他參數
    var date=""
    var year=""
    var month=""
    var day=""
    //
    var alluser = []
    var projects = []
    var company = ""
    var projectUser=""
    var projectName=""

    //列印
    var print_box = document.getElementsByClassName("print_button");
    $(document).ready(() => {
        $('#print_button').click(() => {
            let html = document.getElementById('print_box').innerHTML
            console.log(html)
            let bodyHtml = document.body.innerHTML
            document.body.innerHTML = html
            window.print()
            document.body.innerHTML = bodyHtml
            window.location.reload() //列印輸出後更新頁面
        })
    })
    function selectProjectYears(val)//選單專案年分
    {
        projectYear=val
        project = ''
        $("#select-project-grv").empty();
        $("#select-project-rv").empty();
        $("#select-project-grv_2").empty();

        if(projectYear == '')
        {
            reset()
        }
        else
        {
            for (var i = 0; i < projects.length; i++) {
                if (projects[i]['open_date'].substr(0, 4) == projectYear) {
                    if (projects[i]['company_name'] == "grv") {
                        $("#select-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    } else if (projects[i]['company_name'] == "rv") {
                        $("#select-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    } else if (projects[i]['company_name'] == "grv_2") {
                        $("#select-project-grv_2").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    }
                }
            }
        }
    }
    

    function select(type,id)
    {
        switch(type)
        {
            case 'user':
                user = id
                if(id == '')
                {
                    reset()
                }
                else 
                {
                    projectYear=""
                    project=""
                    setProject()
                    setProjectUser()
                }
                break
            case 'project':
                project = id
                if(id == '')
                {
                    reset()
                }
                else
                {
                    setProjectName()
                    setCompany()
                }
                break
            default:
        }  
        checkPrintButton()
    }
    
    function getNewProject() {
        data = "{{$projects}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    //重製--------------------------------------------------------

    function reset() {
        projects = getNewProject()
        ResetProject()
        ResetProjectYear()
        ResetCompany()
        ResetDate()
        ResetProjectName()
        ResetUser()
        
        
    }

    function ResetDate(){
        document.getElementById('year').textContent = ""
        document.getElementById('month').textContent = ""
        document.getElementById('day').textContent = ""
        $("#date").val("YYYY-MM-DD");
    }

    function ResetProjectName(){
        projectName = ''
        document.getElementById('projectName').textContent = ''
    }

    function ResetCompany(){
        company = ''
        document.getElementById('project_img').src = ""
        document.getElementById('company_ID').textContent = ""
    }
    
    function ResetUser() {
        user = ''
        $("#select-project-user").val("");
        document.getElementById("projectUser").textContent = ""
    }

    function ResetProject(){
        project = ''
        $("#select-project-grv").empty();
        $("#select-project-rv").empty();
        $("#select-project-grv_2").empty();
    }

    function ResetProjectYear() {
        projectYear = ''
        var years = [] //初始化
        $("#select-project-year").val("");
        $("#select-project-year").empty();
        $("#select-project-year").append("<option value=''></option>");
    }

    //重製結束--------------------------------------------------------
    
    function setProject() {//專案選單
        projects = getNewProject()
        project = ''
        $("#select-project-grv").empty();
        $("#select-project-rv").empty();
        $("#select-project-grv_2").empty();

        var projectYears = [] //初始化
        for (var i = 0; i < projects.length; i++) {
            if (user != '') {
                if (projects[i]['user_id'] != user) {
                    projects.splice(i, 1)
                    i--
                }
            }
        }

        for (var i = 0; i < projects.length; i++) {
            if (projectYears.indexOf(projects[i]['open_date'].substr(0, 4)) == -1) {
                projectYears.push(projects[i]['open_date'].substr(0, 4))
            }
            if (projects[i]['company_name'] == "grv") {
                $("#select-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
            } else if (projects[i]['company_name'] == "rv") {
                $("#select-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
            }
            else if (projects[i]['company_name'] == "grv_2") {
                $("#select-project-grv_2").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
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

    function setProjectName(){//表格專案名稱
        var Notother = 0;
        for (var i = 0; i < projects.length; i++) {
            if(projects[i]['project_id']==project){
                projectName = projects[i]['name']
                Notother=1;
            }
        }
        if(Notother == 0){
            projectName = project
        }
        document.getElementById('projectName').textContent = projectName
        
    }
    
    function setCompany(){//表格專案公司
        var Logo = document.getElementById('project_img')
        var company_ID = document.getElementById('company_ID')
        var companyName =  document.getElementById('companyName')
        for (var i = 0; i < projects.length; i++) {
            if(projects[i]['project_id']==project){
                company = projects[i]['company_name']
            }
        }
        if(company == 'grv'){
            Logo.src = "{{ URL::asset('img/綠雷德LOGO.png') }}"
            Logo.style.width = "100px"
            company_ID.textContent = "綠雷德文創股份有限公司"
            document.getElementById('companyName').textContent = "綠雷德文創股份有限公司"
        }
        else if(company == "rv"){
            Logo.src = "{{ URL::asset('img/閱野LOGO.png') }}"
            Logo.style.width = "150px"
            company_ID.textContent = "閱野文創股份有限公司"
            document.getElementById('companyName').textContent = "閱野文創股份有限公司"
        }else if(company == "grv_2"){
            Logo.src = "{{ URL::asset('img/綠雷德創新logo.png') }}"
            Logo.style.width = "150px"
            company_ID.textContent = "綠雷德創新股份有限公司"
            document.getElementById('companyName').textContent = "綠雷德創新股份有限公司"
        } 
        
    }

    function setProjectUser(){//表格專案負責人
        data = "{{$users}}"
        data = data.replace(/[\n\r]/g, "")
        alluser = JSON.parse(data.replace(/&quot;/g, '"'));

        for(var i = 0 ; i< alluser.length;i++){
            if(alluser[i]['user_id']==user){
                projectUser = alluser[i]['name']
                document.getElementById("projectUser").textContent = alluser[i]['name']
            }
        }
        
    }
    function selectEventDate(e){//表格日期設定
        date = e.target.value
        var str = new Array
        str = date.split("-")
        year = parseInt(str[0])-1911
        month = str[1]
        day = str[2]

        document.getElementById('year').textContent = year
        document.getElementById('month').textContent = month
        document.getElementById('day').textContent = day
        checkPrintButton()
    }

    function checkPrintButton(){
        if(projectUser== '' || company == '' || projectName == ''||date==''){
            document.getElementById('print_button').disabled = true
        }
        else{
            document.getElementById('print_button').disabled = false
        }
    }
</script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop