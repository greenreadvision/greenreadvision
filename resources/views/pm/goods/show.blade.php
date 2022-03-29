@extends('layouts.app')
@section('content')

<div class="modal fade" id="signerModal" tabindex="-1" role="dialog" aria-labelledby="signerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signerModalLabel">編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 form-group">
          <form action="{{$good->goods_id}}/update/signer" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-lg-12 form-group">
              <label class="label-style col-form-label" for="signer">簽收人</label>
              <select required name="signer" type="text" class="form-control rounded-pill">
                <option value=""></option>
                @foreach($users as $user)
                @if($user->name == $good->signer)
                <option value="{{$user['name']}}" selected>{{$user['name']}}({{$user['nickname']}})</option>
                @else
                <option value="{{$user['name']}}">{{$user['name']}}({{$user['nickname']}})</option>
                @endif
                @endforeach
              </select>
            </div>

            <div class="col-lg-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="freightNameModal" tabindex="-1" role="dialog" aria-labelledby="freightNameModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="freightNameModalLabel">編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 form-group">
          <form action="{{$good->goods_id}}/update/freightName" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-lg-12 form-group">
              <label class="label-style col-form-label" for="freight_name">貨運公司</label>
              <input required id="freight_name" autocomplete="off" type="text" name="freight_name" class="rounded-pill form-control{{ $errors->has('freight_name') ? ' is-invalid' : '' }}" value="{{ $good->freight_name }}">

            </div>

            <div class="col-lg-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="deliveryNumberModal" tabindex="-1" role="dialog" aria-labelledby="deliveryNumberModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deliveryNumberModalLabel">編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 form-group">
          <form action="{{$good->goods_id}}/update/deliveryNumber" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-lg-12 form-group">
              <label class="label-style col-form-label" for="delivery_number">貨運單號</label>
              <input required id="delivery_number" autocomplete="off" type="text" name="delivery_number" class="rounded-pill form-control{{ $errors->has('delivery_number') ? ' is-invalid' : '' }}" value="{{ $good->delivery_number }}">

            </div>

            <div class="col-lg-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="quantityModal" tabindex="-1" role="dialog" aria-labelledby="quantityModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="quantityModalLabel">編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 form-group">
          <form action="{{$good->goods_id}}/update/quantity" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-lg-12 form-group">
              <label class="label-style col-form-label" for="inventory_name">清點人</label>
              <input id="inventory_name" autocomplete="off" type="text" name="inventory_name" class="rounded-pill form-control{{ $errors->has('inventory_name') ? ' is-invalid' : '' }}" value="{{ $good->inventory_name }}">
            </div>
            <div class="col-lg-12 form-group">
              <label class="label-style col-form-label" for="quantity">總數量</label>
              <input id="quantity" autocomplete="off" type="text" name="quantity" class="rounded-pill form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ $good->quantity }}">
            </div>
            <div class="col-lg-12 form-group">
              <label class="label-style col-form-label" for="random_inspection">抽檢數量</label>
              <input id="random_inspection" autocomplete="off" type="text" name="random_inspection" class="rounded-pill form-control{{ $errors->has('random_inspection') ? ' is-invalid' : '' }}" value="{{ $good->random_inspection }}">
            </div>
            <div class="col-lg-12 form-group">
              <label class="label-style col-form-label" for="defect">瑕疵數量</label>
              <input id="defect" autocomplete="off" type="text" name="defect" class="rounded-pill form-control{{ $errors->has('defect') ? ' is-invalid' : '' }}" value="{{$good->defect}}">
            </div>
            <div class="col-lg-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="goodNameModal" tabindex="-1" role="dialog" aria-labelledby="goodNameModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="quantityModalLabel">編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 form-group">
          <form action="{{$good->goods_id}}/update/goodName" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-lg-12 form-group">
              <label class="label-style col-form-label" for="good_name">項目名稱</label>
              <input required id="good_name" autocomplete="off" type="text" name="good_name" class="rounded-pill form-control{{ $errors->has('good_name') ? ' is-invalid' : '' }}" value="{{ $good->good_name }}">
            </div>
            <div class="col-lg-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="remarkModal" tabindex="-1" role="dialog" aria-labelledby="remarkModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="remarkModalLabel">編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 form-group">
          <form action="{{$good->goods_id}}/update/remark" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-lg-12 form-group">
              <label class="label-style col-form-label" for="remark">備註</label>
              <input id="remark" autocomplete="off" type="text" name="remark" class="rounded-pill form-control{{ $errors->has('remark') ? ' is-invalid' : '' }}" value="{{ $good->remark }}">

            </div>
            <div class="col-lg-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
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
                            <form action="{{$good->goods_id}}/update/purchase" method="post" enctype="multipart/form-data">
                              @method('PUT')
                              @csrf
                              <div class="col-lg-12 form-group">
                                <label class="label-style col-form-label" for="freight_name">採購單號</label>
                                <div class="input-group mb-3">
                                  <input readonly style="border-top-left-radius: 25px;border-bottom-left-radius: 25px" id="purchase_id" autocomplete="off" type="text" name="purchase_id" class="form-control {{ $errors->has('purchase_id') ? ' is-invalid' : '' }}" value="{{$good->purchases['id']}}">
                                  <div class="input-group-append">
                                      <button type="submit" class="btn btn-green" id="button-addon2" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px"><span class="mx-2">{{__('customize.Save')}}</span></button>
                                  </div>
                              </div>
                              </div>
                            </form>
                          </div>
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
                                      @foreach($users as $user)
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
<div class="modal fade" id="allGoodModal" tabindex="-1" role="dialog" aria-labelledby="allGoodModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="allGoodModalLabel">編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 form-group">
          <form action="{{$good->goods_id}}/update/allGood" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-lg-12">
              <button type="button" class="btn btn-green w-100 mb-2" onclick="uploadImg('allGood')">上傳照片</button>
              <input type="file" name="allGood" accept="image/*" id="allGood" style="display: none">
              @if($good->all_goods != null)

              <img src="{{route('invoicedownload', $good->all_goods)}}" alt="" id="allGoodImg" class="mb-2" width="100%">
              @else
              <img src="" alt="" id="allGoodImg" class="mb-2" width="100%">

              @endif
            </div>
            <div class="col-lg-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="singleGoodModal" tabindex="-1" role="dialog" aria-labelledby="singleGoodModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="singleGoodModalLabel">編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 form-group">
          <form action="{{$good->goods_id}}/update/singleGood" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-lg-12">
              <button type="button" class="btn btn-green w-100 mb-2" onclick="uploadImg('singleGood')">上傳照片</button>
              <input type="file" name="singleGood" accept="image/*" id="singleGood" style="display: none">
              @if($good->single_good != null)
              <img src="{{route('invoicedownload', $good->single_good)}}" alt="" id="singleGoodImg" class="mb-2" width="100%">
              @else
              <img src="" alt="" id="singleGoodImg" class="mb-2" width="100%">

              @endif
            </div>
            <div class="col-lg-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="defectGoodModal" tabindex="-1" role="dialog" aria-labelledby="defectGoodModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="defectGoodModalLabel">編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 form-group">
          <form action="{{$good->goods_id}}/update/defectGood" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-lg-12">
              <button type="button" class="btn btn-green w-100 mb-2" onclick="uploadImg('defectGood')">上傳照片</button>
              <input type="file" name="defectGood" accept="image/*" id="defectGood" style="display: none">
              @if($good->defect_goods != null)

              <img src="{{route('invoicedownload', $good->defect_goods)}}" alt="" id="defectGoodImg" class="mb-2" width="100%">
              @else
              <img src="" alt="" id="defectGoodImg" class="mb-2" width="100%">

              @endif
            </div>
            <div class="col-lg-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="freightExteriorModal" tabindex="-1" role="dialog" aria-labelledby="freightExteriorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="freightExteriorModalLabel">編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 form-group">
          <form action="{{$good->goods_id}}/update/freightExterior" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-lg-12">
              <button type="button" class="btn btn-green w-100 mb-2" onclick="uploadImg('freightExterior')">上傳照片</button>
              <input type="file" name="freightExterior" accept="image/*" id="freightExterior" style="display: none">
              @if($good->freight_exterior != null)

              <img src="{{route('invoicedownload', $good->freight_exterior)}}" alt="" id="freightExteriorImg" class="mb-2" width="100%">
              @else
              <img src="" alt="" id="freightExteriorImg" class="mb-2" width="100%">

              @endif
            </div>
            <div class="col-lg-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="freightBillModal" tabindex="-1" role="dialog" aria-labelledby="freightBillModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="freightBillModalLabel">編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 form-group">
          <form action="{{$good->goods_id}}/update/freightBill" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-lg-12">
              <button type="button" class="btn btn-green w-100 mb-2" onclick="uploadImg('freightBill')">上傳照片</button>
              <input type="file" name="freightBill" accept="image/*" id="freightBill" style="display: none">
              @if($good->freight_bill != null)

              <img src="{{route('invoicedownload', $good->freight_bill)}}" alt="" id="freightBillImg" class="mb-2" width="100%">
              @else
              <img src="" alt="" id="freightBillImg" class="mb-2" width="100%">

              @endif
            </div>
            <div class="col-lg-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
            </div>
          </form>
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
              <form action="{{$good->goods_id }}/delete" method="POST">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-blue rounded-pill">是</button>
              </form>
          </div>
      </div>
  </div>
</div>
<div class="page_level">
  <div class="page_show">
      <div class="page_title" id="page_title">
          <span class="page_title_span">硬體管理</span>
          <i class="fas fa-chevron-right page_title_arrow"></i>
          <a  href="/goods" class="page_title_a" >貨單</a>
          <i class="fas fa-chevron-right page_title_arrow"></i>
          <span class="page_title_span">{{$good->good_name}}</span>
      </div>
  </div>
</div>
<div class="row justify-content-center">
  <div class="col-lg-12 mb-3" style="text-align: right">
    @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
      <button type="button" class="btn btn-red rounded-pill" data-toggle="modal" data-target="#deleteModal">
        <i class='ml-2 fas fa-trash-alt'></i><span class="ml-3 mr-2">{{__('customize.Delete')}}</span>
      </button>
    @endif
  </div>
  <div class="col-lg-9">
    <div class="row">
      <div class="col-lg-4 mb-3">
        <div class="card border-0 shadow h-100">
          <div class="card-body">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#signerModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#signerModal"  hidden></i>
              @endif
            </div>
            <div class="col-lg-12">
              簽收人
            </div>
            <div class="col-lg-12 text-center">
              <h3>{{$good->signer}}</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4  mb-3">
        <div class="card border-0 shadow  h-100">
          <div class="card-body">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#goodNameModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#goodNameModal"  hidden></i>
              @endif
            </div>
            <div class="col-lg-12">
              項目名稱
            </div>
            <div class="col-lg-12 text-center">
              <h3>{{$good->good_name}}</h3>
              
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4  mb-3">
        <div class="card border-0 shadow  h-100">
          <div class="card-body">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#remarkModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#remarkModal"  hidden></i>
              @endif
            </div>
            <div class="col-lg-12">
              備註
            </div>
            <div class="col-lg-12 text-center">
              <h3>{{$good->remark}}</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-3">
        <div class="card border-0 shadow h-100">
          <div class="card-body">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#purchaseModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#purchaseModal"  hidden></i>
              @endif
            </div>
            <div class="col-lg-12">
              採購單號
            </div>
            <div class="col-lg-12 text-center">
              @if($good->purchase_id !=null)
              <h3>{{$good->purchases['id']}}</h3>
              @else
              <h3>-未填寫-<h3>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-3">
        <div class="card border-0 shadow h-100">
          <div class="card-body">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#freightNameModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#freightNameModal"  hidden></i>
              @endif
            </div>
            <div class="col-lg-12">
              貨運公司
            </div>
            <div class="col-lg-12 text-center">
              <h3>{{$good->freight_name}}</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-3">
        <div class="card border-0 shadow h-100">
          <div class="card-body">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#deliveryNumberModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#deliveryNumberModal"  hidden></i>
              @endif
            </div>
            <div class="col-lg-12">
              貨運單號
            </div>
            <div class="col-lg-12 text-center">
              <h3>{{$good->delivery_number}}</h3>
            </div>

          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-3 ">
        <div class="card border-0 shadow mb-3 " style="height:100%;max-height:100%">
          <div class="card-body" style="height:100%;max-height:100%">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#quantityModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#quantityModal"  hidden></i>
              @endif
            </div>
            <div class="col-lg-12">
              清點人
            </div>
            <div class="col-lg-12 text-center">
              <h3>{{$good->inventory_name}}</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9 mb-3">
        <div class="card border-0 shadow mb-3 " style="height:100%;max-height:100%">
          <div class="card-body" style="height:100%;max-height:100%">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#quantityModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#quantityModal"  hidden></i>
              @endif
            </div>
            <div class="row">
              <div class="col-lg-4 ">
                <div class="col-lg-12">
                  總數量
                </div>
                <div class="col-lg-12 text-center border-bottom border-success" style="border-width:9px !important;">
                  <h3>{{$good->quantity}}</h3>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="col-lg-12">
                  抽檢數
                </div>
                <div class="col-lg-12 text-center border-bottom border-warning" style="border-width:9px !important;">
                  <h3>{{$good->random_inspection}}</h3>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="col-lg-12">
                  瑕疵數
                </div>
                <div class="col-lg-12 text-center border-bottom border-danger" style="border-width:9px !important;">
                  <h3>{{$good->defect}}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-3">
        <div class="card border-0 shadow mb-3 " style="height:100%;max-height:100%">
          <div class="card-body" style="height:100%;max-height:100%">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#allGoodModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#allGoodModal"  hidden></i>
              @endif
            </div>
            <div class="col-lg-12">
              全體照
            </div>
            <div class="col-lg-12 text-center">
              @if($good->all_goods != null)
              <img src="{{route('invoicedownload', $good->all_goods)}}" alt="" id="allGoodImg" class="mb-2" width="100%">
              @else
              <img src="" alt="" id="allGoodImg" class="mb-2" width="100%">
              @endif

            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-3">
        <div class="card border-0 shadow mb-3 " style="height:100%;max-height:100%">
          <div class="card-body" style="height:100%;max-height:100%">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#singleGoodModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#singleGoodModal"  hidden></i>
              @endif
            </div>
            <div class="col-lg-12">
              單一照
            </div>
            <div class="col-lg-12 text-center">
              @if($good->single_good != null)
              <img src="{{route('invoicedownload', $good->single_good)}}" alt="" id="singleGoodImg" class="mb-2" width="100%">
              @else
              <img src="" alt="" id="singleGoodImg" class="mb-2" width="100%">
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-3">
        <div class="card border-0 shadow mb-3 " style="height:100%;max-height:100%">
          <div class="card-body" style="height:100%;max-height:100%">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#defectGoodModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#defectGoodModal"  hidden></i>
              @endif
            </div>
            <div class="col-lg-12">
              瑕疵照
            </div>
            <div class="col-lg-12 text-center">
              @if($good->defect_goods != null)
              <img src="{{route('invoicedownload', $good->defect_goods)}}" alt="" id="defectGoodImg" class="mb-2" width="100%">
              @else
              <img src="" alt="" id="defectGoodImg" class="mb-2" width="100%">
              @endif
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="col-lg-3">
    <div class="row">
      <div class="col-lg-12 mb-3">
        <div class="card border-0 shadow mb-3 " style="height:100%;max-height:100%">
          <div class="card-body" style="height:100%;max-height:100%">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#freightBillModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#freightBillModal"  hidden></i>
              @endif
            </div>
            <div class="col-lg-12">
              貨單照
            </div>
            <div class="col-lg-12 text-center">
              @if($good->freight_bill != null)
              <img src="{{route('invoicedownload', $good->freight_bill)}}" alt="" id="freightBillImg" class="mb-2" width="100%">
              @else
              <img src="" alt="" id="freightBillImg" class="mb-2" width="100%">
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12 mb-3">
        <div class="card border-0 shadow mb-3 " style="height:100%;max-height:100%">
          <div class="card-body" style="height:100%;max-height:100%">
            <div class="col-lg-12 d-flex justify-content-end p-0">
              @if(\Auth::user()->user_id == $good->user_id ||  \Auth::user()->role == 'intern'|| \Auth::user()->user_id == $good->purchases['user_id']|| \Auth::user()->name == $good->signer)
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#freightExteriorModal"></i>
              @else
              <i class='fas fa-edit icon-gray' data-toggle="modal" data-target="#freightExteriorModal"  hidden></i>
              @endif
            </div>
            <div class="col-lg-12">
              外觀照
            </div>
            <div class="col-lg-12 text-center">
              @if($good->freight_exterior != null)
              <img src="{{route('invoicedownload', $good->freight_exterior)}}" alt="" id="freightExteriorImg" class="mb-2" width="100%">
              @else
              <img src="" alt="" id="freightExteriorImg" class="mb-2" width="100%">
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>


@stop
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
  function uploadImg(temp) {
    document.querySelector('#' + temp).click()

  }
  $(document).ready(function() {
    $('input').on('change', function(e) {
      id = e.target.id
      img = document.querySelector('#' + id + 'Img')
      const file = this.files[0];
      const fr = new FileReader();
      fr.onload = function(e) {
        img.src = e.target.result
      };

      // 使用 readAsDataURL 將圖片轉成 Base64
      fr.readAsDataURL(file);
    });
    var purchases = '{{$purchases}}'
      purchases = purchases.replace(/[\n\r]/g, "")
      purchases = JSON.parse(purchases.replace(/&quot;/g, '"'));
      reset()
  });
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
      data = "{{$purchases}}"
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