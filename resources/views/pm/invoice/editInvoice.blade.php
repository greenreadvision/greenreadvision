@extends('layouts.app')

@section('content')
<div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-labelledby="purchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:90vw" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>選取採購單</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input type="text" name="search-num" id="search-num" class="form-control  rounded-pill" placeholder="採購單號" autocomplete="off" onkeyup="searchNum()">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input type="text" name="search-purchase" id="search-purchase" class="form-control rounded-pill " placeholder="搜尋" autocomplete="off" onkeyup="searchPurchase()">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">採購人</label>
                                <div class="col-lg-12">
                                    <select type="text" id="select-purchase-user" name="select-purchase-user" onchange="select('user',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control mb-2">
                                        <option value=""></option>
                                        @foreach($data['users'] as $user)
                                        <option value="{{$user['user_id']}}">{{$user['name']}}({{$user['nickname']}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">專案</label>
                                <div class="col-lg-12 mb-2">
                                    <select type="text" id="select-purchase-project-year" name="select-purchase-project-year" onchange="selectProjectYears(this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                        <option value=''></option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <select type="text" id="select-purchase-project" name="select-purchase-project" onchange="select('project',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                        <option value=''></option>
                                        <optgroup id="select-purchase-project-grv" label="綠雷德">
                                        <optgroup id="select-purchase-project-rv" label="閱野">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-lg-12 col-form-label">年份</label>
                                <div class="col-lg-12">
                                    <select type="text" id="select-purchase-year" name="select-purchase-year" onchange="select('year',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                        <option value=''></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-12 col-form-label">月份</label>
                                <div class="col-lg-12">
                                    <select type="text" id="select-purchase-month" name="select-purchase-month" onchange="select('month',this.options[this.options.selectedIndex].value)" class="rounded-pill form-control">
                                        <option value=''></option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <button class="w-100 btn btn-green rounded-pill" onclick="reset()"><span>重置</span> </button>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div id="page-navigation" class="col-lg-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
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
                        <div class="col-lg-12 table-style-invoice ">
                            <table id="show-purchase">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    @if($data['invoice']['status']=="waiting-fix" || $data['invoice']['status']=="check-fix")
                    @if(strpos(URL::full(),'other'))
                    <form action="../fix/other" method="POST" enctype="multipart/form-data">
                        @else
                        <form action="fix" method="POST" enctype="multipart/form-data">
                            @endif
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                @if(\Auth::user()->role =='manager')
                                    <div id = "intern_name" class="col-lg-12 form-group" style="padding :10px">
                                        <label class="label-style col-form-label" for="intern_name">實習生姓名</label>
                                        <select type="text" id="intern_name" name="intern_name" class="form-control rounded-pill" autofocus>
                                            <option value="">請選擇實習生姓名</option>
                                            <option>柴犬</option>
                                            <option>貓頭鷹</option>
                                            <option>比目魚</option>
                                            <option>北極熊</option>
                                            <option>刺蝟</option>
                                            <option>花貓</option>
                                            <option>河馬</option>
                                        </select>
                                    </div>
                                    @endif
                                <div class="col-lg-6 form_group">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="label-style col-form-label" for="company_name">公司</label>
                                            <select type="text" id="company_name_fix" name="company_name" class="form-control rounded-pill" autofocus>
                                                @foreach ($data['company_name'] as $key)
                                                @if($data['invoice']['company_name']==$key)
                                                <option value="{{$key}}" selected>{{__('customize.'.$key)}}</option>
                                                @else
                                                <option value="{{$key}}">{{__('customize.'.$key)}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="purchase_id">採購單號</label>

                                    <div class="input-group mb-3">
                                        <input readonly style="border-top-left-radius: 25px;border-bottom-left-radius: 25px" id="purchase_id" autocomplete="off" type="text" name="purchase_id" class="form-control {{ $errors->has('purchase_id') ? ' is-invalid' : '' }}" value="{{$errors->has('purchase_id')? old('purchase_id'): $data['invoice']['purchase_id']}}">

                                        <div class="input-group-append">
                                            <button onclick="showPurchase()" class="btn btn-green" type="button" id="button-addon2" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">採購單</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 form-group">
                                    @if(strpos(URL::full(),'other'))
                                    <div class="row">
                                        <div class="col-lg-12 form-group">
                                            <label class="label-style col-form-label" for="type">類型</label>
                                            <select type="text" id="type_fix" name="type" class="form-control rounded-pill" autofocus onchange="checkPrice()">
                                                @foreach ($data['type'] as $key)
                                                <option value="{{$key}}" {{$data['types'][$key]['selected']}}>{{__('customize.'.$key)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @else
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                                            <select type="text" id="project_id" name="project_id" class="form-control rounded-pill" autofocus>
                                                
                                                <optgroup label="綠雷德">
                                                    @foreach($data['grv2'] as $gr2)
                                                    @if($gr2['name']!='其他' )
                                                    @if($data['invoice']['project_id'] == $gr2['project_id'])
                                                    <option value="{{$gr2['project_id']}}" selected>{{$gr2->name}}</option>
                                                    @else
                                                    <option value="{{$gr2['project_id']}}">{{$gr2->name}}</option>
                                                    @endif
                                                    @endif

                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="綠雷德(舊))">
                                                    @foreach($data['grv'] as $gr)
                                                    @if($gr['name']!='其他' )
                                                    @if($data['invoice']['project_id'] == $gr['project_id'])
                                                    <option value="{{$gr['project_id']}}" selected>{{$gr->name}}</option>
                                                    @else
                                                    <option value="{{$gr['project_id']}}">{{$gr->name}}</option>
                                                    @endif
                                                    @endif

                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="閱野">
                                                    @foreach($data['rv'] as $r)

                                                    @if($data['invoice']['project_id'] == $r['project_id'])
                                                    <option value="{{$r['project_id']}}" selected>{{$r->name}}</option>

                                                    @else
                                                    <option value="{{$r['project_id']}}">{{$r->name}}</option>
                                                    @endif

                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="company">{{__('customize.company')}}</label>
                                    <input autocomplete="off" type="text" id="company-" name="company" class="form-control rounded-pill{{ $errors->has('company') ? ' is-invalid' : '' }}" value="{{$errors->has('company')? old('company'): $data['invoice']['company']}}" required>
                                    @if ($errors->has('company'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="title">請款項目</label>
                                    <input id="title" autocomplete="off" type="text" name="title" class="form-control rounded-pill{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{$errors->has('title')? old('title'): $data['invoice']['title']}}">
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label class="label-style col-form-label" for="content">{{__('customize.content')}}(50字以內)</label>
                                    <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control rounded-pill{{ $errors->has('content') ? ' is-invalid' : '' }}" required>{{$errors->has('content')? old('content'): $data['invoice']['content']}}</textarea>
                                    @if ($errors->has('content'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>超出50個字</strong>
                                    </span> @endif
                                </div>
                                <!-- <div class="col-lg-12">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary">
                                            <input type="radio" name="options" id="option1" onchange="changeBankData(0)" autocomplete="off"> 個人帳戶
                                        </label>
                                        <label class="btn btn-secondary active">
                                            <input type="radio" name="options" id="option2" onchange="changeBankData(1)" autocomplete="off" checked> 其他
                                        </label>
                                    </div>
                                </div> -->
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="bank">{{__('customize.bank')}}</label>
                                    <input autocomplete="off" type="text" id="bank" name="bank" class="form-control rounded-pill{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{$errors->has('bank')? old('bank'): $data['invoice']['bank']}}" required>
                                    @if ($errors->has('bank'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="bank_branch">{{__('customize.bank_branch')}}</label>
                                    <input autocomplete="off" type="text" id="bank_branch" name="bank_branch" class="form-control rounded-pill{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{$errors->has('bank_branch')? old('bank_branch'): $data['invoice']['bank_branch']}}" required>
                                    @if ($errors->has('bank_branch'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_branch') }}</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="bank_account_number">{{__('customize.bank_account_number')}}</label>
                                    <input autocomplete="off" type="text" id="bank_account_number" name="bank_account_number" class="form-control rounded-pill{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{$errors->has('bank_account_number')? old('bank_account_number'): $data['invoice']['bank_account_number']}}" required>
                                    @if ($errors->has('bank_account_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_account_number') }}</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="bank_account_name">{{__('customize.bank_account_name')}}</label>
                                    <input autocomplete="off" type="text" id="bank_account_name" name="bank_account_name" class="form-control rounded-pill{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" value="{{$errors->has('bank_account_name')? old('bank_account_name'): $data['invoice']['bank_account_name']}}" required>
                                    @if ($errors->has('bank_account_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank_account_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="row col-lg-6 form-group" style="margin:auto;">

                                    <label class="label-style col-12">{{__('customize.receipt')}}</label>
                                    <label class="label-style col-6 col-form-label" for="receipt_true"><input type="radio" id="receipt_true" name="receipt" value="1" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{$data['invoice']['receipt']? 'checked': ''}} required>有</label>
                                    <label class="label-style col-6 col-form-label" for="receipt_false"><input type="radio" id="receipt_false" name="receipt" value="0" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{$data['invoice']['receipt']? '': 'checked'}}>沒有，待補</label>
                                    @if ($errors->has('receipt'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('receipt') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div  class=" form-group ">
                                    <label class="label-style col-form-label" for="receipt_date">{{__('customize.receipt_date')}}</label>
                                    <input type="date" id="receipt_date" name="receipt_date" class="form-control rounded-pill{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}" value="{{$data['invoice']['receipt_date']}}" required>
                                    @if ($errors->has('receipt_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('receipt_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label class="label-style col-form-label" for="remuneration">{{__('customize.remuneration')}}(張數)</label>
                                    <input oninput="value=value.replace(/[^\d]/g,'')" autocomplete="off" type="text" id="remuneration" name="remuneration" class="form-control rounded-pill{{ $errors->has('remuneration') ? ' is-invalid' : '' }}" value="{{$errors->has('remuneration')? old('remuneration'): $data['invoice']['remuneration']}}" required>
                                    @if ($errors->has('remuneration'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('remuneration') }}</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-4">
                                    <label class="label-style col-form-label" for="price">{{__('customize.price')}}</label>
                                    <input oninput="value=value.replace(/[^\d]/g,'')" onkeyup="checkPrice()" autocomplete="off" type="text" id="price" name="price" class="form-control rounded-pill{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{$errors->has('price')? old('price'): $data['invoice']['price']}}" required>
                                    @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label class="label-style col-form-label" for="reviewer">審核主管</label>
                                    <select type="text" id="reviewer" name="reviewer" class="form-control rounded-pill" required>
                                        <option value=""></option>
                                        <optgroup id="optgroup-1" label="3000元以下">
                                            <option value="GRV00002" id="GRV00002" {{$data['invoice']['reviewer']=='GRV00002'? 'selected' : ''}}>蔡貴瑄</option>
                                        </optgroup>
                                        <optgroup id="optgroup-2" label="3000~10000元">
                                            @foreach($data['reviewers'] as $reviewer)
                                            <option value="{{$reviewer['user_id']}}" id="{{$reviewer['user_id']}}" {{$data['invoice']['reviewer']==$reviewer['user_id']? 'selected' : ''}}>{{$reviewer->name}}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup id="optgroup-3" label="10000元以上">
                                            <option value="GRV00001" id="GRV00001" {{$data['invoice']['reviewer']=='GRV00001'? 'selected' : ''}}>吳奇靜</option>
                                        </optgroup>

                                    </select>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="receipt_file">{{__('customize.receipt_file')}}</label>
                                    <input type="file" id="receipt_file" name="receipt_file" class="form-control rounded-pill{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}" value="$data['invoice']['receipt_file']}}">
                                    @if ($errors->has('receipt_file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('receipt_file') }}</strong>
                                    </span> @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-style col-form-label" for="detail_file">{{__('customize.detail_file')}}</label>
                                    <input type="file" id="detail_file" name="detail_file" class="form-control rounded-pill{{ $errors->has('detail_file') ? ' is-invalid' : '' }}" value="$data['invoice']['detail_file']}}">
                                    @if ($errors->has('detail_file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('detail_file') }}</strong>
                                    </span> @endif
                                </div>
                            </div>
                            <div style="float: left;">
                                <button type="button" class="btn btn-red rounded-pill" data-toggle="modal" data-target="#deleteModal">
                                    <i class='ml-2 fas fa-trash-alt'></i><span class="ml-1 mr-2">{{__('customize.Delete')}}</span>
                                </button>
                            </div>
                            <div style="float: right;">
                                <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                            </div>
                        </form>
                        @else
                        @if(strpos(URL::full(),'other'))
                        <form action="../update/other" method="POST" enctype="multipart/form-data">
                            @else
                            <form action="update" method="POST" enctype="multipart/form-data">
                                @endif
                                @method('PUT')
                                @csrf
                                <div class="form-group row">
<<<<<<< Updated upstream
                                @if(\Auth::user()->role =='manager')
                                    <div id = "intern_name" class="col-lg-12 form-group" style="padding :10px">
                                        <label class="label-style col-form-label" for="intern_name">實習生姓名</label>
                                        <select type="text" id="intern_name" name="intern_name" class="form-control rounded-pill" autofocus>
                                            <option value="">請選擇實習生姓名</option>
                                            <option>柴犬</option>
                                            <option>貓頭鷹</option>
                                            <option>比目魚</option>
                                            <option>北極熊</option>
                                            <option>刺蝟</option>
                                            <option>花貓</option>
                                            <option>河馬</option>
                                        </select>
                                    </div>
=======
                                    @if(\Auth::user()->role =='intern'||\Auth::user()->role =='manager')
                                    <div class="col-lg-12 col-form-label" style="padding-left: 0px">
                                        <div id = "intern_name" class="col-lg-6 form-group" >
                                            <label class="label-style col-form-label" for="intern_name">實習生姓名</label>
                                            <select type="text" id="intern_name" name="intern_name" class="form-control rounded-pill" autofocus>
                                                <option value="">請選擇實習生姓名</option>
                                                <option {{$data['invoice']['intern_name'] == '柴犬'? 'selected':''}}>柴犬</option>
                                                <option {{$data['invoice']['intern_name'] == '貓頭鷹'? 'selected':''}}>貓頭鷹</option>
                                                <option {{$data['invoice']['intern_name'] == '比目魚'? 'selected':''}}>比目魚</option>
                                                <option {{$data['invoice']['intern_name'] == '北極熊'? 'selected':''}}>北極熊</option>
                                                <option {{$data['invoice']['intern_name'] == '刺蝟'? 'selected':''}}>刺蝟</option>
                                                <option {{$data['invoice']['intern_name'] == '花貓'? 'selected':''}}>花貓</option>
                                                <option {{$data['invoice']['intern_name'] == '河馬'? 'selected':''}}>河馬</option>
                                            </select>
                                        </div>
                                    </div>
                                    
>>>>>>> Stashed changes
                                    @endif
                                    <div class="col-lg-6 form_group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label class="label-style col-form-label" for="company_name">公司</label>
                                                <select type="text" id="company_name" name="company_name" class="form-control rounded-pill" autofocus>
                                                    @foreach ($data['company_name'] as $key)
                                                    @if($data['invoice']['company_name']==$key)
                                                    <option value="{{$key}}" selected>{{__('customize.'.$key)}}</option>
                                                    @else
                                                    <option value="{{$key}}">{{__('customize.'.$key)}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="company">{{__('customize.company')}}</label>
                                        <input autocomplete="off" type="text" id="company-" name="company" class="form-control rounded-pill{{ $errors->has('company') ? ' is-invalid' : '' }}" value="{{$errors->has('company')? old('company'): $data['invoice']['company']}}" required>
                                        @if ($errors->has('company'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('company') }}</strong>
                                        </span> @endif
                                    </div>



                                    <div class="col-lg-6 form-group">
                                        @if(strpos(URL::full(),'other'))
                                        <label class="label-style col-form-label" for="type">類型</label>
                                        <select type="text" id="type" name="type" class="form-control rounded-pill" autofocus onchange="checkPrice()">
                                            @foreach ($data['type'] as $key)
                                            <option value="{{$key}}" {{$data['types'][$key]['selected']}}>{{__('customize.'.$key)}}</option>
                                            @endforeach
                                        </select>
                                        @else
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                                                <select type="text" id="project_id" name="project_id" class="form-control rounded-pill" autofocus>
                                                    <!-- @foreach ($data['projects'] as $project)

                                            @if($project['name']!='其他'&&$project['status']=='running')
                                            <option value="{{$project['project_id']}}" {{$project['selected']}}>{{$project['name']}}</option>

                                            @endif
                                            @endforeach -->
                                                    <optgroup label="綠雷德">
                                                        @foreach($data['grv2'] as $gr2)
                                                        @if($gr2['name']!='其他' )
                                                        @if($data['invoice']['project_id'] == $gr2['project_id'])
                                                        <option value="{{$gr2['project_id']}}" selected>{{$gr2->name}}</option>
                                                        @else
                                                        <option value="{{$gr2['project_id']}}">{{$gr2->name}}</option>
                                                        @endif
                                                        @endif

                                                        @endforeach
                                                    </optgroup>
                                                    <optgroup label="綠雷德(舊)">
                                                        @foreach($data['grv'] as $gr)
                                                        @if($gr['name']!='其他' )
                                                        @if($data['invoice']['project_id'] == $gr['project_id'])
                                                        <option value="{{$gr['project_id']}}" selected>{{$gr->name}}</option>
                                                        @else
                                                        <option value="{{$gr['project_id']}}">{{$gr->name}}</option>
                                                        @endif
                                                        @endif

                                                        @endforeach
                                                    </optgroup>
                                                    <optgroup label="閱野">
                                                        @foreach($data['rv'] as $r)

                                                        @if($data['invoice']['project_id'] == $r['project_id'])
                                                        <option value="{{$r['project_id']}}" selected>{{$r->name}}</option>

                                                        @else
                                                        <option value="{{$r['project_id']}}">{{$r->name}}</option>
                                                        @endif

                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="purchase_id">採購單號</label>
                                        <div class="input-group mb-3">
                                            <input readonly style="border-top-left-radius: 25px;border-bottom-left-radius: 25px" id="purchase_id" autocomplete="off" type="text" name="purchase_id" class="form-control {{ $errors->has('purchase_id') ? ' is-invalid' : '' }}" value="{{$errors->has('purchase_id')? old('purchase_id'): $data['invoice']['purchase_id']}}">

                                            <div class="input-group-append">
                                                <button onclick="showPurchase()" class="btn btn-green" type="button" id="button-addon2" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px">採購單</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="title">請款項目</label>
                                        <input id="title" autocomplete="off" type="text" name="title" class="form-control rounded-pill{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{$errors->has('title')? old('title'): $data['invoice']['title']}}">
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label class="label-style col-form-label" for="content">請款事項(100字以內)</label>
                                        <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control rounded-pill{{ $errors->has('content') ? ' is-invalid' : '' }}" required>{{$errors->has('content')? old('content'): $data['invoice']['content']}}</textarea>
                                        @if ($errors->has('content'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>超出100個字</strong>
                                        </span> @endif
                                    </div>
                                    <!-- <div class="col-lg-12">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="options" id="option1" onchange="changeBankData(0)" autocomplete="off"> 個人帳戶
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="options" id="option2" onchange="changeBankData(1)" autocomplete="off" checked> 其他
                        </label>
                    </div>
                </div> -->
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="bank">{{__('customize.bank')}}</label>
                                        <input autocomplete="off" type="text" id="bank" name="bank" class="form-control rounded-pill{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{$errors->has('bank')? old('bank'): $data['invoice']['bank']}}" required>
                                        @if ($errors->has('bank'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="bank_branch">{{__('customize.bank_branch')}}</label>
                                        <input autocomplete="off" type="text" id="bank_branch" name="bank_branch" class="form-control rounded-pill{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{$errors->has('bank_branch')? old('bank_branch'): $data['invoice']['bank_branch']}}" required>
                                        @if ($errors->has('bank_branch'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank_branch') }}</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="bank_account_number">{{__('customize.bank_account_number')}}</label>
                                        <input autocomplete="off" type="text" id="bank_account_number" name="bank_account_number" class="form-control rounded-pill{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{$errors->has('bank_account_number')? old('bank_account_number'): $data['invoice']['bank_account_number']}}" required>
                                        @if ($errors->has('bank_account_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank_account_number') }}</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="bank_account_name">{{__('customize.bank_account_name')}}</label>
                                        <input autocomplete="off" type="text" id="bank_account_name" name="bank_account_name" class="form-control rounded-pill{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" value="{{$errors->has('bank_account_name')? old('bank_account_name'): $data['invoice']['bank_account_name']}}" required>
                                        @if ($errors->has('bank_account_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank_account_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="row col-lg-6 form-group" style="margin:auto;">

                                        <label class="label-style col-12">{{__('customize.receipt')}}</label>
                                        <label class="label-style col-6 col-form-label" for="receipt_true"><input type="radio" id="receipt_true" name="receipt" value="1" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{$data['invoice']['receipt']? 'checked': ''}} required>有</label>
                                        <label class="label-style col-6 col-form-label" for="receipt_false"><input type="radio" id="receipt_false" name="receipt" value="0" class="{{ $errors->has('receipt') ? 'is-invalid' : '' }}" {{$data['invoice']['receipt']? '': 'checked'}}>沒有，待補</label>
                                        @if ($errors->has('receipt'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('receipt') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="{{$data['invoice']['status'] !='complete' ? 'col-lg-6' : 'col-lg-3'}} form-group ">
                                        <label class="label-style col-form-label" for="receipt_date">{{__('customize.receipt_date')}}</label>
                                        <input type="date" id="receipt_date" name="receipt_date" class="form-control rounded-pill{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}" value="{{$data['invoice']['receipt_date']}}" required>
                                        @if ($errors->has('receipt_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('receipt_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-3 form-group " {{$data['invoice']['status'] !='complete' ? 'hidden' : ''}}>
                                        <label class="label-style col-form-label" for="remittance_date">匯款日期</label>
                                        <input type="date" id="remittance_date" name="remittance_date" class="form-control rounded-pill{{ $errors->has('remittance_date') ? ' is-invalid' : '' }}" value="{{$data['invoice']['remittance_date']}}">
                                        @if ($errors->has('remittance_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('remittance_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="label-style col-form-label" for="remuneration">{{__('customize.remuneration')}}(張數)</label>
                                        <input oninput="value=value.replace(/[^\d]/g,'')" autocomplete="off" type="text" id="remuneration" name="remuneration" class="form-control rounded-pill{{ $errors->has('remuneration') ? ' is-invalid' : '' }}" value="{{$errors->has('remuneration')? old('remuneration'): $data['invoice']['remuneration']}}" required>
                                        @if ($errors->has('remuneration'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('remuneration') }}</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="label-style col-form-label" for="price">{{__('customize.price')}}</label>
                                        <input oninput="value=value.replace(/[^\d]/g,'')" onkeyup="checkPrice()" autocomplete="off" type="text" id="price" name="price" class="form-control rounded-pill{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{$errors->has('price')? old('price'): $data['invoice']['price']}}" required>
                                        @if ($errors->has('price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="label-style col-form-label" for="reviewer">審核主管</label>
                                        <select type="text" id="reviewer" name="reviewer" class="form-control rounded-pill" required>
                                            <option value=""></option>
                                            <optgroup id="optgroup-1" label="3000元以下">
                                                <option value="GRV00002" id="GRV00002" {{$data['invoice']['reviewer']=='GRV00002'? 'selected' : ''}}>蔡貴瑄</option>
                                            </optgroup>
                                            <optgroup id="optgroup-2" label="3000~10000元">
                                                <!--@foreach($data['reviewers'] as $reviewer)
                                                <option value="{{$reviewer['user_id']}}" id="{{$reviewer['user_id']}}" {{$data['invoice']['reviewer']==$reviewer['user_id']? 'selected' : ''}}>{{$reviewer->name}}</option>
                                                @endforeach-->
                                                <option value="GRV00001" id="GRV00001" {{$data['invoice']['reviewer']=='GRV00001'? 'selected' : ''}}>吳奇靜</option>
                                            </optgroup>
                                            <optgroup id="optgroup-3" label="10000元以上">
                                                <option value="GRV00001" id="GRV00001" {{$data['invoice']['reviewer']=='GRV00001'? 'selected' : ''}}>吳奇靜</option>
                                            </optgroup>

                                        </select>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="receipt_file">{{__('customize.receipt_file')}}</label>
                                        <input type="file" id="receipt_file" name="receipt_file" class="form-control rounded-pill{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}" value="$data['invoice']['receipt_file']}}">
                                        @if ($errors->has('receipt_file'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('receipt_file') }}</strong>
                                        </span> @endif
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="label-style col-form-label" for="detail_file">{{__('customize.detail_file')}}</label>
                                        <input type="file" id="detail_file" name="detail_file" class="form-control rounded-pill{{ $errors->has('detail_file') ? ' is-invalid' : '' }}" value="$data['invoice']['detail_file']}}">
                                        @if ($errors->has('detail_file'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('detail_file') }}</strong>
                                        </span> @endif
                                    </div>
                                </div>
                                <div style="float: left;">
                                    <button type="button" class="btn btn-red rounded-pill" data-toggle="modal" data-target="#deleteModal">
                                        <i class='ml-2 fas fa-trash-alt'></i><span class="ml-3 mr-2">{{__('customize.Delete')}}</span>
                                    </button>
                                </div>
                                <div style="float: right;">
                                    <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                                </div>
                            </form>
                            @endif
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center ">
                是否刪除?

            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-red rounded-pill" data-dismiss="modal">否</button>
                @if(strpos(URL::full(),'other'))
                <form action="../delete/other" method="POST">
                    @else
                    <form action="delete" method="POST">
                        @endif
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-blue rounded-pill">是</button>
                    </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script ctype="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        checkPrice()
    });

    function checkPrice() {

        var p = $('#price').val()
        if ("{{strpos(URL::full(),'other')}}") {
            console.log($('#type').val())
            if ($('#type').val() == 'other') {
                
                if (p < 3000) {
                    $('#optgroup-1').show()
                    $('#optgroup-2').hide()
                    $('#optgroup-3').hide()
                } else if (p >= 3000 && p < 10000) {
                    $('#optgroup-1').hide()
                    $('#optgroup-2').show()
                    $('#optgroup-3').hide()
                } else {
                    $('#optgroup-1').hide()
                    $('#optgroup-2').hide()
                    $('#optgroup-3').show()
                }
            } else {
                $('#optgroup-1').show()
                $('#optgroup-2').hide()
                $('#optgroup-3').hide()
            }
        } else {
           
            if (p < 3000) {
                $('#optgroup-1').show()
                $('#optgroup-2').hide()
                $('#optgroup-3').hide()
            } else if (p >= 3000 && p < 10000) {
                $('#optgroup-1').hide()
                $('#optgroup-2').show()
                $('#optgroup-3').hide()
            } else {
                $('#optgroup-1').hide()
                $('#optgroup-2').hide()
                $('#optgroup-3').show()
            }
        }

    }

    function showPurchase() {
        $('#purchaseModal').modal('show')
    }
</script>
<script>
    var user = ""
    var project = ""
    var projectYear = ""
    var year = ""
    var month = ""
    var temp = ""
    var numTemp = ""
    var nowPage = 1
    //帳務
    var purchases = []
    var projects = []
    $(document).ready(function() {
        reset()
    });

    function selectProjectYears(val) {
        projectYear = val
        project = ''
        $("#select-purchase-project-grv").empty();
        $("#select-purchase-project-rv").empty();

        if (projectYear == '') {
            reset()
        } else {
            setPurchase()
            projects = getNewProject()
            for (var i = 0; i < projects.length; i++) {
                if (projects[i]['open_date'].substr(0, 4) == projectYear) {
                    if (projects[i]['company_name'] == "grv") {
                        $("#select-purchase-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    } else if (projects[i]['company_name'] == "rv") {
                        $("#select-purchase-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
                    }
                }
            }
            setYear()
        }
        setSearch()
        listPurchase() //列出符合條件的請款項目
    }

    function select(type, id) {
        switch (type) {
            case 'user':
                user = id
                if (id == '') {
                    reset()
                } else {
                    projectYear = ''
                    project = ''
                    year = ''
                    month = ''
                    setPurchase()
                    setProject() //設置此人所屬專案
                    setYear()
                    setMonth()
                }
                break;
            case 'project':
                project = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    year = ''
                    month = ''
                    setPurchase()
                    setYear()
                    setMonth()
                }
                break;
            case 'year':
                year = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    month = ''
                    setPurchase()
                    setMonth()
                }
                break;
            case 'month':
                month = id //傳入選取值
                if (id == '') {
                    reset()
                } else {
                    setPurchase()
                }
                break;
            default:

        }
        setSearchNum()
        setSearch()
        listPurchase() //列出符合條件的請款項目
        listPage()
    }

    function searchPurchase() {
        temp = document.getElementById('search-purchase').value
        nowPage = 1
        setPurchase()
        listPurchase()
        listPage()
    }

    function searchNum() {
        numTemp = document.getElementById('search-num').value
        nowPage = 1
        setPurchase()
        listPurchase()
        listPage()
    }

    function setPurchase() {
        purchases = getNewPurchase()
        for (var i = 0; i < purchases.length; i++) {
            if (user != '') {
                if (purchases[i]['user_id'] != user) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
            if (project != '') {
                if (purchases[i]['project_id'] != project) {
                    purchases.splice(i, 1)
                    i--
                    continue
                } else {
                    $('#select-purchase-project-year').val(purchases[i].project['open_date'].substr(0, 4))
                }
            }
            if (year != '') {
                if (purchases[i]['created_at'].substr(0, 4) != year) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
            if (month != '') {
                if (purchases[i]['created_at'].substr(5, 2) != month) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
            if (temp != '') {
                if (purchases[i]['title'] == null || purchases[i]['title'].indexOf(temp) == -1) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
            if (numTemp != '') {
                if (purchases[i]['id'] == null || purchases[i]['id'].indexOf(numTemp) == -1) {
                    purchases.splice(i, 1)
                    i--
                    continue
                }
            }
        }
    }


    function getNewPurchase() {
        data = "{{$data['purchases']}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function getNewProject() {
        var temp = []
        var projectTemp = []
        for (var i = 0; i < purchases.length; i++) {
            if (temp.indexOf(purchases[i].project['name']) == -1) {
                temp.push(purchases[i].project['name'])
                projectTemp.push(purchases[i].project)
            }
        }
        return projectTemp
    }

    function listPurchase() {
        $("#show-purchase").empty();
        var parent = document.getElementById('show-purchase');
        var table = document.createElement("tbody");
        table.innerHTML = '<tr class="text-white">' +
            '<th>採購單號</th>' +
            '<th>採購人</th>' +
            '<th>專案</th>' +
            '<th>採購項目</th>' +
            '<th>採購費用</th>' +
            '<th>採購日期</th>' +
            '</tr>'
        var tr, span, name, a


        for (var i = 0; i < purchases.length; i++) {
            if (i >= (nowPage - 1) * 13 && i < nowPage * 13) {
                table.innerHTML = table.innerHTML + setData(i)
            } else if (i >= nowPage * 13) {
                break
            }
        }

        parent.appendChild(table);
    }

    function inputPurchase(i) {
        $('#purchase_id').val(purchases[i].id)
        $('#purchaseModal').modal('hide')
    }

    function setData(i) {

        a = "/purchase/" + purchases[i]['purchase_id'] + "/review"
        tr = "<tr style='cursor: pointer;' class='modal-style' onclick='inputPurchase(" + i + ")'>" +
            "<td>" + purchases[i].id + "</td>" +
            "<td>" + purchases[i].user['name'] + "(" + purchases[i].user['nickname'] + ")" + "</td>" +
            "<td>" + purchases[i].project['name'] + "</td>" +
            "<td>" + purchases[i].title + "</a></td>" +
            "<td>" + commafy(purchases[i].total_amount) + "</td>" +
            "<td>" + purchases[i].purchase_date.substr(0, 10) + "</td>" +
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
        purchases = getNewPurchase()
        nowPage = 1
        setUser()
        projectYear = ''
        setProject()
        setYear()
        setMonth()
        setSearch()
        setSearchNum()
        listPurchase()
        listPage()
    }

    function setUser() {
        user = ''
        $("#select-purchase-user").val("");
    }

    function setProject() {
        projects = getNewProject()
        project = ''
        $("#select-purchase-project-grv").empty();
        $("#select-purchase-project-rv").empty();

        var projectYears = [] //初始化

        for (var i = 0; i < projects.length; i++) {
            if (projectYears.indexOf(projects[i]['open_date'].substr(0, 4)) == -1) {
                projectYears.push(projects[i]['open_date'].substr(0, 4))
            }
            if (projects[i]['company_name'] == "grv") {
                $("#select-purchase-project-grv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
            } else if (projects[i]['company_name'] == "rv") {
                $("#select-purchase-project-rv").append("<option value='" + projects[i]['project_id'] + "'>" + projects[i]['name'] + "</option>");
            }
        }

        $("#select-purchase-project-year").val("");
        $("#select-purchase-project-year").empty();
        $("#select-purchase-project-year").append("<option value=''></option>");
        projectYears.sort()
        projectYears.reverse()
        for (var i = 0; i < projectYears.length; i++) {
            $("#select-purchase-project-year").append("<option value='" + projectYears[i] + "'>" + projectYears[i] + "</option>");
        }
    }

    function setYear() {
        year = ''
        var years = [] //初始化
        $("#select-purchase-year").val("");
        $("#select-purchase-year").empty();
        $("#select-purchase-year").append("<option value=''></option>");

        for (var i = 0; i < purchases.length; i++) {
            if (years.indexOf(purchases[i]['purchase_date'].substr(0, 4)) == -1) {
                years.push(purchases[i]['purchase_date'].substr(0, 4))
                $("#select-purchase-year").append("<option value='" + purchases[i]['purchase_date'].substr(0, 4) + "'>" + purchases[i]['purchase_date'].substr(0, 4) + "</option>");
            }
        }
    }

    function setMonth() {
        month = ''
        $("#select-purchase-month").empty();
        $("#select-purchase-month").append("<option value=''></option>");
        for (var i = 0; i < 12; i++) {
            if (i < 9) {
                $("#select-purchase-month").append("<option value='0" + (i + 1) + "'>" + "0" + (i + 1) + "</option>");
            } else {
                $("#select-purchase-month").append("<option value='" + (i + 1) + "'>" + (i + 1) + "</option>");

            }
        }
    }

    function setSearch() {
        temp = ''
        document.getElementById('search-purchase').value = temp
    }

    function setSearchNum() {
        numTemp = ''
        document.getElementById('search-num').value = numTemp
    }

    function nextPage() {
        var number = Math.ceil(purchases.length / 13)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listPurchase()
        }

    }

    function changePage(index) {

        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listPage()
        listPurchase()

    }

    function previousPage() {
        var number = Math.ceil(purchases.length / 13)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listPurchase()
        }

    }

    function listPage() {
        $("#page-navigation").empty();
        var parent = document.getElementById('page-navigation');
        var div = document.createElement("div");
        var number = Math.ceil(purchases.length / 13)
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
        div.innerHTML = '<nav aria-label="Page navigation example">' +
            '<ul class="pagination">' +
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

        parent.appendChild(div);

        $(".page-" + String(nowPage)).addClass('active')
    }
</script>
@stop