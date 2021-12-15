@extends('layouts.app')
@section('content')
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">新增帳戶</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="bank/create" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="name">名稱</label>
                            <input autocomplete="off" type="text" id="name" name="name" class="rounded-pill form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="bank">銀行名稱</label>
                            <input autocomplete="off" type="text" id="bank" name="bank" class="rounded-pill form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{ old('bank') }}" required>
                            @if ($errors->has('bank'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="bank_branch">分行</label>
                            <input autocomplete="off" type="text" id="bank_branch" name="bank_branch" class="rounded-pill form-control{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{ old('bank_branch') }}" required>
                            @if ($errors->has('bank_branch'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_branch') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="bank_account_number">銀行帳號</label>
                            <input autocomplete="off" type="text" id="bank_account_number" name="bank_account_number" class="rounded-pill form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{ old('bank_account_number') }}" required>
                            @if ($errors->has('bank_account_number'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_account_number') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="bank_account_name">銀行戶名</label>
                            <input autocomplete="off" type="text" id="bank_account_name" name="bank_account_name" class="rounded-pill form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" value="{{ old('bank_account_name') }}" required>
                            @if ($errors->has('emabank_account_nameil'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_account_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="md-5" style="float: right;">
                        <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card card-style">
            <div class="card-body ">
                <div class="col-lg-12 ">
                </div>
                <div class="col-lg-12 d-flex justify-content-between">
                    <div class=" col-lg-4">
                        <input type="text" name="search" id="search" class="mb-2 form-control  rounded-pill" placeholder="帳戶名稱" autocomplete="off" onkeyup="search()">
                    </div>
                    <button data-toggle="modal" data-target="#createModal" class="mb-2 btn btn-green rounded-pill"><span class="mx-2">{{__('customize.Add')}}</span> </button>
                </div>
                <div class="col-lg-12">
                    <div id="bank-page" class="d-flex align-items-end">
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
                </div>
                <div class="col-lg-12 table-style-invoice">
                    <table id="show-bank">

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@foreach($data as $bank)
<div class="modal fade" id="{{$bank->bank_id}}_Modal" tabindex="-1" role="dialog" aria-labelledby="{{$bank->bank_id}}_Modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="bank/{{$bank->bank_id}}/update" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="name">名稱</label>
                            <input autocomplete="off" type="text" id="name-{{$bank->bank_id}}" name="name" class="rounded-pill form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{$bank->name}}" required>
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="bank">銀行名稱</label>
                            <input autocomplete="off" type="text" id="bank-{{$bank->bank_id}}" name="bank" class="rounded-pill form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" value="{{$bank->bank}}" required>
                            @if ($errors->has('bank'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="bank_branch">分行</label>
                            <input autocomplete="off" type="text" id="bank_branch-{{$bank->bank_id}}" name="bank_branch" class="rounded-pill form-control{{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{ $bank->bank_branch }}" required>
                            @if ($errors->has('bank_branch'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_branch') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="bank_account_number">銀行帳號</label>
                            <input autocomplete="off" type="text" id="bank_account_number-{{$bank->bank_id}}" name="bank_account_number" class="rounded-pill form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" value="{{ $bank->bank_account_number}}" required>
                            @if ($errors->has('bank_account_number'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_account_number') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="bank_account_name">銀行戶名</label>
                            <input autocomplete="off" type="text" id="bank_account_name-{{$bank->bank_id}}" name="bank_account_name" class="rounded-pill form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" value="{{ $bank->bank_account_name }}" required>
                            @if ($errors->has('emabank_account_nameil'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bank_account_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="md-5" style="float: right;">
                        <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                    </div>

                </form>
                <div class="md-5" style="float: left">
                    <form action="bank/{{$bank->bank_id}}/delete" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-red rounded-pill">
                            <span class="mx-2">{{__('customize.Delete')}}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@stop

@section('script')
<script ctype="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    var banks = []
    var temp = ''
    var nowPage = 1
    $(document).ready(function() {
        reset()
    });

    function search() {
        temp = document.getElementById('search').value
        nowPage = 1
        setBank()
        listBank()
        listPage()
    }

    function setBank() {
        banks = getNewBank()
        for (var i = 0; i < banks.length; i++) {
            if (temp != '') {
                if (banks[i]['name'] == null || banks[i]['name'].indexOf(temp) == -1) {
                    banks.splice(i, 1)
                    i--
                    continue
                }
            }
        }

        banks.sort(function(a, b) {
            return a.name.length - b.name.length;
        });
    }


    function getNewBank() {
        data = "{{$data}}"
        data = data.replace(/[\n\r]/g, "")
        data = JSON.parse(data.replace(/&quot;/g, '"'));
        return data
    }

    function listBank() {
        $("#show-bank").empty();
        var parent = document.getElementById('show-bank');
        var table = document.createElement("tbody");
        table.innerHTML = '<tr class="text-white">' +
            '<th>帳戶名稱</th>' +
            '</tr>'
        var tr, span, name, a

        for (var i = 0; i < banks.length; i++) {
            if (i >= (nowPage - 1) * 13 && i < nowPage * 13) {
            table.innerHTML = table.innerHTML + setData(i)
            } else if (i >= nowPage * 13) {
                break
            }
        }

        parent.appendChild(table);
    }


    function setData(i) {

        tr = "<tr style='cursor: pointer;' class='modal-style' data-toggle='modal' data-target=#" + banks[i].bank_id + "_Modal>" +
            "<td class='text-left'>" + banks[i].name + "</td>" +
            "</tr>"
        return tr
    }



    function reset() {
        banks = getNewBank()
        setBank()
        nowPage = 1
        listBank()
        listPage()
    }




    function setSearch() {
        temp = ''
        document.getElementById('search').value = temp
    }

    function nextPage() {
        var number = Math.ceil(banks.length / 13)

        if (nowPage < number) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage++
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listBank()
        }

    }

    function changePage(index) {

        var temp = document.getElementsByClassName('page-item')

        $(".page-" + String(nowPage)).removeClass('active')
        nowPage = index
        $(".page-" + String(nowPage)).addClass('active')

        listPage()
        listBank()

    }

    function previousPage() {
        var number = Math.ceil(banks.length / 13)

        if (nowPage > 1) {
            var temp = document.getElementsByClassName('page-item')
            $(".page-" + String(nowPage)).removeClass('active')
            nowPage--
            $(".page-" + String(nowPage)).addClass('active')
            listPage()
            listBank()
        }
    }

    function listPage() {
        $("#bank-page").empty();
        var parent = document.getElementById('bank-page');
        var div = document.createElement("div");
        var number = Math.ceil(banks.length / 13)
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