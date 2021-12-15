@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center">
    <div class="col-lg-6">
        
        <form action="{{preg_match("/pmTest/i",$_SERVER['REQUEST_URI']) == 1 ? 'pmTest':'activeTest'}}/review" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-12 form-group">
                @foreach($data as $item)
                <div class="card border-0 mb-3 shadow">
                    <div class="card-header">
                        <label class="label-style col-form-label" style="color: black" for="{{$item->question_id}}"> {{$item->title}}</label>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="{{$item->question_id}}" id="{{$item->question_id}}1" value="option_1">
                            <label class="form-check-label" for="{{$item->question_id}}1">
                                (A) {{$item->option_1}}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="{{$item->question_id}}" id="{{$item->question_id}}2" value="option_2">
                            <label class="form-check-label" for="{{$item->question_id}}2">
                                (B) {{$item->option_2}}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="{{$item->question_id}}" id="{{$item->question_id}}3" value="option_3">
                            <label class="form-check-label" for="{{$item->question_id}}3">
                                (C) {{$item->option_3}}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="{{$item->question_id}}" id="{{$item->question_id}}4" value="option_4">
                            <label class="form-check-label" for="{{$item->question_id}}4">
                                (D) {{$item->option_4}}
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-12 form-group">
                <button data-toggle="modal" data-target="#submitModal" type="button" class="btn btn-green rounded-pill w-100">提交</button>
            </div>
            <div class="modal fade" id="submitModal" tabindex="-1" role="dialog" aria-labelledby="submitModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="submitModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            是否送出答案
                        </div>
                        <div class="modal-footer border-0 d-flex justify-content-center">
                            <div>
                            <button type="button" class="btn btn-red" data-dismiss="modal">否</button>
                            <button type="submit" class="btn btn-blue">是</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


@stop