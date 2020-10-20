@extends('layouts.app')

@section('content')
<!-- <div class="d-flex align-items-center mb-3">
    <h2>{{__('customize.Edit')}}{{__('customize.Invoice')}}</h2>
</div> -->

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        @if($data['invoice']['status']=="waiting-fix" || $data['invoice']['status']=="check-fix")
        @if(strpos(URL::full(),'other'))
        <form action="../fix/other" method="POST" enctype="multipart/form-data">
            @else
            <form action="fix" method="POST" enctype="multipart/form-data">
                @endif
                @method('PUT')
                @csrf
                <div class="form-group row">
                    <div class="col-lg-6 form_group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="label-style col-form-label" for="company_name">&nbsp;</label>
                                <select type="text" id="company_name" name="company_name" class="form-control" autofocus>
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
                        <input id="purchase_id" autocomplete="off" type="text" name="purchase_id" class="form-control{{ $errors->has('purchase_id') ? ' is-invalid' : '' }}" value="{{$errors->has('purchase_id')? old('purchase_id'): $data['invoice']['purchase_id']}}" >
                    </div>
                    <div class="col-lg-6 form-group">
                        @if(strpos(URL::full(),'other'))
                        <label class="label-style col-form-label" for="type">類型</label>
                        <select type="text" id="type" name="type" class="form-control" autofocus>
                            @foreach ($data['type'] as $key)
                            <option value="{{$key}}" {{$data['types'][$key]['selected']}}>{{__('customize.'.$key)}}</option>
                            @endforeach
                        </select>
                        @else
                        <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                        <select type="text" id="project_id" name="project_id" class="form-control" autofocus>
                            @foreach ($data['projects'] as $project)

                            @if($project['name']!='其他'&&$project['finished']==0)
                            <option value="{{$project['project_id']}}" {{$project['selected']}}>{{$project['name']}}</option>

                            @endif
                            @endforeach
                        </select>
                        @endif

                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="company">{{__('customize.company')}}</label>
                        <input autocomplete="off" type="text" id="company-" name="company" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" value="{{$errors->has('company')? old('company'): $data['invoice']['company']}}" required>
                        @if ($errors->has('company'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="label-style col-form-label" for="content">{{__('customize.content')}}(50字以內)</label>
                        <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" required>{{$errors->has('content')? old('content'): $data['invoice']['content']}}</textarea>
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
                        <input autocomplete="off" type="text" id="bank" name="bank" class="form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{$errors->has('bank')? old('bank'): $data['invoice']['bank']}}" required>
                        @if ($errors->has('bank'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('bank') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="bank_branch">{{__('customize.bank_branch')}}</label>
                        <input autocomplete="off" type="text" id="bank_branch" name="bank_branch" class="form-control{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{$errors->has('bank_branch')? old('bank_branch'): $data['invoice']['bank_branch']}}" required>
                        @if ($errors->has('bank_branch'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('bank_branch') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="bank_account_number">{{__('customize.bank_account_number')}}</label>
                        <input autocomplete="off" type="text" id="bank_account_number" name="bank_account_number" class="form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{$errors->has('bank_account_number')? old('bank_account_number'): $data['invoice']['bank_account_number']}}" required>
                        @if ($errors->has('bank_account_number'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('bank_account_number') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="bank_account_name">{{__('customize.bank_account_name')}}</label>
                        <input autocomplete="off" type="text" id="bank_account_name" name="bank_account_name" class="form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" value="{{$errors->has('bank_account_name')? old('bank_account_name'): $data['invoice']['bank_account_name']}}" required>
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
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="receipt_date">{{__('customize.receipt_date')}}</label>
                        <input type="date" id="receipt_date" name="receipt_date" class="form-control{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}" value="{{$data['invoice']['receipt_date']}}" required>
                        @if ($errors->has('receipt_date'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('receipt_date') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="remuneration">{{__('customize.remuneration')}}(張數)</label>
                        <input autocomplete="off" type="text" id="remuneration" name="remuneration" class="form-control{{ $errors->has('remuneration') ? ' is-invalid' : '' }}" value="{{$errors->has('remuneration')? old('remuneration'): $data['invoice']['remuneration']}}" required>
                        @if ($errors->has('remuneration'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('remuneration') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6">
                        <label class="label-style col-form-label" for="price">{{__('customize.price')}}</label>
                        <input autocomplete="off" type="text" id="price" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{$errors->has('price')? old('price'): $data['invoice']['price']}}" required>
                        @if ($errors->has('price'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="receipt_file">{{__('customize.receipt_file')}}</label>
                        <input type="file" id="receipt_file" name="receipt_file" class="form-control{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}" value="$data['invoice']['receipt_file']}}">
                        @if ($errors->has('receipt_file'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('receipt_file') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="detail_file">{{__('customize.detail_file')}}</label>
                        <input type="file" id="detail_file" name="detail_file" class="form-control{{ $errors->has('detail_file') ? ' is-invalid' : '' }}" value="$data['invoice']['detail_file']}}">
                        @if ($errors->has('detail_file'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('detail_file') }}</strong>
                        </span> @endif
                    </div>
                </div>
                <div style="float: left;">
                    <button type="button" class="btn btn-danger btn-danger-style" data-toggle="modal" data-target="#deleteModal">
                        <i class='fas fa-trash-alt'></i><span class="ml-3">{{__('customize.Delete')}}</span>
                    </button>
                </div>
                <div style="float: right;">
                    <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
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
                    <div class="col-lg-6 form_group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="label-style col-form-label" for="company_name">&nbsp;</label>
                                <select type="text" id="company_name" name="company_name" class="form-control" autofocus>
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
                        <input autocomplete="off" type="text" id="company-" name="company" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" value="{{$errors->has('company')? old('company'): $data['invoice']['company']}}" required>
                        @if ($errors->has('company'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company') }}</strong>
                        </span> @endif
                    </div>

                    

                    <div class="col-lg-6 form-group">
                        @if(strpos(URL::full(),'other'))
                        <label class="label-style col-form-label" for="type">類型</label>
                        <select type="text" id="type" name="type" class="form-control" autofocus>
                            @foreach ($data['type'] as $key)
                            <option value="{{$key}}" {{$data['types'][$key]['selected']}}>{{__('customize.'.$key)}}</option>
                            @endforeach
                        </select>
                        @else
                        <label class="label-style col-form-label" for="project_id">{{__('customize.Project')}}</label>
                        <select type="text" id="project_id" name="project_id" class="form-control" autofocus>
                            @foreach ($data['projects'] as $project)

                            @if($project['name']!='其他'&&$project['finished']==0)
                            <option value="{{$project['project_id']}}" {{$project['selected']}}>{{$project['name']}}</option>

                            @endif
                            @endforeach
                        </select>
                        @endif

                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="purchase_id">採購單號</label>
                        <input id="purchase_id" autocomplete="off" type="text" name="purchase_id" class="form-control{{ $errors->has('purchase_id') ? ' is-invalid' : '' }}" value="{{$errors->has('purchase_id')? old('purchase_id'): $data['invoice']['purchase_id']}}" >
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="title">請款項目</label>
                        <input id="title" autocomplete="off" type="text" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{$errors->has('title')? old('title'): $data['invoice']['title']}}" >
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="label-style col-form-label" for="content">請款事項(100字以內)</label>
                        <textarea id="content" name="content" rows="5" style="resize:none;" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" required>{{$errors->has('content')? old('content'): $data['invoice']['content']}}</textarea>
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
                        <input autocomplete="off" type="text" id="bank" name="bank" class="form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{$errors->has('bank')? old('bank'): $data['invoice']['bank']}}" required>
                        @if ($errors->has('bank'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('bank') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="bank_branch">{{__('customize.bank_branch')}}</label>
                        <input autocomplete="off" type="text" id="bank_branch" name="bank_branch" class="form-control{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{$errors->has('bank_branch')? old('bank_branch'): $data['invoice']['bank_branch']}}" required>
                        @if ($errors->has('bank_branch'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('bank_branch') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="bank_account_number">{{__('customize.bank_account_number')}}</label>
                        <input autocomplete="off" type="text" id="bank_account_number" name="bank_account_number" class="form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{$errors->has('bank_account_number')? old('bank_account_number'): $data['invoice']['bank_account_number']}}" required>
                        @if ($errors->has('bank_account_number'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('bank_account_number') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="bank_account_name">{{__('customize.bank_account_name')}}</label>
                        <input autocomplete="off" type="text" id="bank_account_name" name="bank_account_name" class="form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" value="{{$errors->has('bank_account_name')? old('bank_account_name'): $data['invoice']['bank_account_name']}}" required>
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
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="receipt_date">{{__('customize.receipt_date')}}</label>
                        <input type="date" id="receipt_date" name="receipt_date" class="form-control{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}" value="{{$data['invoice']['receipt_date']}}" required>
                        @if ($errors->has('receipt_date'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('receipt_date') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="remuneration">{{__('customize.remuneration')}}(張數)</label>
                        <input autocomplete="off" type="text" id="remuneration" name="remuneration" class="form-control{{ $errors->has('remuneration') ? ' is-invalid' : '' }}" value="{{$errors->has('remuneration')? old('remuneration'): $data['invoice']['remuneration']}}" required>
                        @if ($errors->has('remuneration'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('remuneration') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6">
                        <label class="label-style col-form-label" for="price">{{__('customize.price')}}</label>
                        <input autocomplete="off" type="text" id="price" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{$errors->has('price')? old('price'): $data['invoice']['price']}}" required>
                        @if ($errors->has('price'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="receipt_file">{{__('customize.receipt_file')}}</label>
                        <input type="file" id="receipt_file" name="receipt_file" class="form-control{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}" value="$data['invoice']['receipt_file']}}">
                        @if ($errors->has('receipt_file'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('receipt_file') }}</strong>
                        </span> @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="label-style col-form-label" for="detail_file">{{__('customize.detail_file')}}</label>
                        <input type="file" id="detail_file" name="detail_file" class="form-control{{ $errors->has('detail_file') ? ' is-invalid' : '' }}" value="$data['invoice']['detail_file']}}">
                        @if ($errors->has('detail_file'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('detail_file') }}</strong>
                        </span> @endif
                    </div>
                </div>
                <div style="float: left;">
                    <button type="button" class="btn btn-danger btn-danger-style" data-toggle="modal" data-target="#deleteModal">
                        <i class='fas fa-trash-alt'></i><span class="ml-3">{{__('customize.Delete')}}</span>
                    </button>
                </div>
                <div style="float: right;">
                    <button type="submit" class="btn btn-primary btn-primary-style">{{__('customize.Save')}}</button>
                </div>
            </form>
        @endif
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">否</button>
                @if(strpos(URL::full(),'other'))
                <form action="../delete/other" method="POST">
                    @else
                    <form action="delete" method="POST">
                        @endif
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-primary">是</button>
                    </form>
            </div>
        </div>
    </div>
</div>
@stop