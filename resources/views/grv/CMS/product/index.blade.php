@extends('grv.CMS.app')
@section('content')

<div class="col-lg-12 d-flex justify-content-between mb-3">
    <button id="selectMultiple" onclick="multiple()" class="btn btn-blue rounded-pill"><span class="mx-2">選取多個</span> </button>

    <button class="btn btn-green rounded-pill" data-toggle="modal" data-target="#addModal"><span class="mx-2">{{__('customize.Add')}}</span> </button>
</div>
<form action="product/multipleDestroy" method="POST">
    @method('DELETE')
    @csrf
    <div class="col-lg-12">
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 mb-2">
                <div class="">
                    <img class="shadow product-img" style="cursor:pointer" data-toggle="modal" data-target="#Modal{{$product['products_id']}}" src="{{route('download', $product['path'])}}" width="100%" height="100%">
                    <input hidden class="form-check-input" type="checkbox" name="checkbox[]" value="{{$product['order']}}" id="check-{{$product['order']}}">
                </div>
                <div id='div-{{$product->order}}' class="w-100 h-100 position-absolute" style="left: 0;top:0">
                    <div class="col-lg-12 w-100 h-100">
                        <div class="w-100 h-100 img-check" onclick="check('{{$product->order}}')"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalModalLabel">刪除</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center" id="delete-modal-body">

                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-red rounded-pill" data-dismiss="modal">否</button>

                    <button type="submit" class="btn btn-blue rounded-pill">是</button>

                </div>
            </div>
        </div>
    </div>
</form>
<div class="position-fixed" style="right:24px;bottom:24px">
    <button id="btn-delete" class="btn btn-red rounded-pill" data-toggle="modal" data-target="#deleteModal"><i class='fas fa-trash-alt'></i></button>
</div>
@foreach($products as $product)
<div class="modal fade" id="Modal{{$product['products_id']}}" tabindex="-1" role="dialog" aria-labelledby="Modal{{$product['products_id']}}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Modal{{$product['products_id']}}Label">編輯</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="product/{{$product['order']}}/{{$product['products_id']}}/update" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="order_{{$product['order']}}">排序</label>
                            <select class="rounded-pill form-control{{ $errors->has('order') ? ' is-invalid' : '' }}" type="text" id="order_{{$product['order']}}" name="order_{{$product['order']}}" class="form-control" autofocus>
                                @for($i = 1 ; $i < count($products) + 1 ; $i++) <option value="{{$i}}" {{$i == $product->order ? 'selected':''}}>{{$i}}</option>
                                    @endfor
                            </select>

                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="name">商品名稱</label>
                            <input autocomplete="off" type="text" id="name_{{$product['order']}}" name="name_{{$product['order']}}" class="rounded-pill form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{$product['name']}}" required>
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="url">網址</label>
                            <input autocomplete="off" type="text" id="url_{{$product['order']}}" name="url_{{$product['order']}}" class="rounded-pill form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" value="{{$product['url']}}">
                        </div>
                        <div class="col-lg-12 form-grounp p-0 mb-2">
                            <div class="col-lg-6 d-flex justify-content-center">
                                <button type="button" style="width:300px" class="btn btn-blue" onclick="editImg('{{$product['order']}}')">上傳商品照</button>

                            </div>
                        </div>
                        <div class="col-lg-6 form-group d-flex justify-content-center">
                            <div class="d-flex justify-content-center align-items-center" style="width:300px;height:300px">
                                <img id="product_{{$product['order']}}" width="100%" src="{{route('download', $product['path'])}}">
                                <input style="display: none" type="file" name="path_{{$product['order']}}" accept="image/*" id="imgReader_{{$product['order']}}" value="{{$product['path'][1]}}">
                                <img style="display: none" id="cropImg_{{$product['order']}}">

                            </div>

                        </div>
                        <div class="col-lg-6 form-group d-flex  align-items-end">
                            <div class="previewBox_{{$product['order']}}" style=" box-shadow: 0 0 5px #adadad;width: 200px;height: 200px;background: rgb(250, 250, 250);overflow: hidden;">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <small>預覽圖</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md-5" style="float: right;">
                        <button type="submit" onclick="setImageUp('{{$product['order']}}')" class="btn btn-green rounded-pill"><span class="mx-2">儲存</span></button>
                    </div>
                    <input type="text" name="product_photo_{{$product['order']}}" id="product_photo_{{$product['order']}}" hidden>
                </form>
                <form action="/product/{{$product->products_id}}/delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-red rounded-pill"><span class="mx-2">刪除</span></button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalModalLabel">新增文創商品</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="product/create/review" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="name">商品名稱</label>
                            <input autocomplete="off" type="text" id="name" name="name" class="rounded-pill form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="url">網址</label>
                            <input autocomplete="off" type="text" id="url" name="url" class="rounded-pill form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" value="{{old('url')}}">
                        </div>
                        <div class="col-lg-12 form-grounp p-0 mb-2">
                            <div class="col-lg-6 d-flex justify-content-center">
                                <button type="button" style="width:300px" class="btn btn-blue" onclick="uploadImg()">上傳商品照</button>

                            </div>
                        </div>
                        <div class="col-lg-6 form-group d-flex justify-content-center">
                            <div class="d-flex justify-content-center align-items-center" style="width:300px;height:300px">
                                <label onclick="uploadImg()" id="product_lable" class="label-style col-form-label input-photo-label w-100 h-100">
                                    <small>上傳商品照</small>
                                </label>
                                <input type="file" name="path" accept="image/*" id="imgReader">
                                <img id="cropImg" style="width: 100%;">

                            </div>

                        </div>
                        <div class="col-lg-6 form-group d-flex  align-items-end">
                            <div class="previewBox">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <small>預覽圖</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md-5" style="float: right;">
                        <button type="submit" onclick="setImage()" class="btn btn-green rounded-pill"><span class="mx-2">{{__('customize.Add')}}</span></button>
                    </div>
                    <input type="text" name="product_photo" id="product_photo" hidden>

                </form>
            </div>
        </div>
    </div>
</div>


@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<style>
    #imgReader {
        display: none;

    }

    .img-check {
        cursor: pointer;
        background-color: white;
        opacity: .8;
        transition: all .2s;
    }

    .img-check-show {

        opacity: 0;
        transition: all .2s;
    }


    .previewBox {
        box-shadow: 0 0 5px #adadad;
        width: 200px;
        height: 200px;
        background: rgb(250, 250, 250);
        overflow: hidden;
    }
</style>
<script>
    var data = '{{$products}}'
    data = data.replace(/[\n\r]/g, "")
    data = JSON.parse(data.replace(/&quot;/g, '"'));
    var names = []

    function multiple() {
        var count = '{{$count}}'

        if ($('#selectMultiple').html() == '<span class="mx-2">選取多個</span>') {
            $('#btn-delete').show()
            $('#selectMultiple').html('<span class="mx-2">　取消　</span>')
            $('#selectMultiple').removeClass('btn-blue')
            $('#selectMultiple').addClass('btn-red')
            for (i = 1; i <= count; i++) {
                $('#div-' + i).show()
            }

        } else {
            $('#btn-delete').hide()
            $('#selectMultiple').html('<span class="mx-2">選取多個</span>')
            $('#selectMultiple').removeClass('btn-red')
            $('#selectMultiple').addClass('btn-blue')
            for (i = 1; i <= count; i++) {
                $('#div-' + i).hide()
            }
        }
    }

    function check(i) {
        document.querySelector('#check-' + i).click()
        if ($("input[name='checkbox[]']")[i - 1]['checked'] == true) {
            $('#div-' + i + ' .img-check').addClass('img-check-show')
            names.push(data[i - 1]['name'])

        } else {
            $('#div-' + i + ' .img-check').removeClass('img-check-show')

            names.splice(names.indexOf(data[i - 1]['name']), 1)

        }
        var content = ''
        for (i = 0; i < names.length; i++) {
            if (i == 0) {
                content = names[i]
            } else {
                content = content + '、' + names[i]

            }
        }
        $('#delete-modal-body').html("是否刪除  <br> \"" + content + "\"<br> 以上商品？")
        if ($("input[name='checkbox[]']:checked").length == 0) {
            $('#btn-delete').attr("disabled", true);

        } else {
            $('#btn-delete').attr("disabled", false);
        }
    }

    function setImage() {
        $('#product_photo').val(CROPPER.getCroppedCanvas().toDataURL('image/jpeg', 0.4))
    }

    function setImageUp(i) {
        $('#product_photo_' + i).val(CROPPER.getCroppedCanvas().toDataURL('image/jpeg', 0.4))
    }

    function editImg(i) {
        document.querySelector('#imgReader_' + i).click()
        if (CROPPER) {
            CROPPER.destroy()
        }
    }

    function uploadImg() {
        document.querySelector('#imgReader').click()
        if (CROPPER) {
            CROPPER.destroy()
        }
    }
    $(document).ready(function() {
        var count = '{{$count}}'
        $('#btn-delete').attr("disabled", true);

        $('#btn-delete').hide()
        for (i = 1; i <= count; i++) {
            $('#div-' + i).hide()
        }
        document.getElementById('cropImg').style.display = 'none';
        $('input[type="file"]').on('change', function(e) {
            if (e.target.id == 'imgReader') {
                //讀取上傳文件
                document.getElementById('product_lable').style.display = 'none';
                let reader = new FileReader();
                if (e.target.files[0]) {
                    //readAsDataURL方法可以将File对象转化为data:URL格式的字符串（base64编码）
                    reader.readAsDataURL(e.target.files[0]);
                    reader.onload = (e) => {
                        let dataURL = reader.result;
                        //将img的src改为刚上传的文件的转换格式
                        document.querySelector('#cropImg').src = dataURL;

                        const image = document.getElementById('cropImg');


                        //创建cropper实例-----------------------------------------
                        CROPPER = new Cropper(image, {
                            aspectRatio: 16 / 16,
                            viewMode: 2,
                            minContainerWidth: 100,
                            minContainerHeight: 100,
                            dragMode: 'move',
                            preview: [document.querySelector('.previewBox')]
                        })
                    }
                }

            } else {
                order = e.target.id.split("_")[1]
                document.getElementById('product_' + order).style.display = 'none';
                let reader = new FileReader();
                if (e.target.files[0]) {
                    //readAsDataURL方法可以将File对象转化为data:URL格式的字符串（base64编码）
                    reader.readAsDataURL(e.target.files[0]);
                    reader.onload = (e) => {
                        let dataURL = reader.result;
                        //将img的src改为刚上传的文件的转换格式
                        document.querySelector('#cropImg_' + order).src = dataURL;

                        const image = document.getElementById('cropImg_' + order);


                        //创建cropper实例-----------------------------------------
                        CROPPER = new Cropper(image, {
                            aspectRatio: 16 / 16,
                            viewMode: 2,
                            minContainerWidth: 100,
                            minContainerHeight: 100,
                            dragMode: 'move',
                            preview: [document.querySelector('.previewBox_' + order)]
                        })
                    }
                }
            }
        });
    });
</script>

@stop