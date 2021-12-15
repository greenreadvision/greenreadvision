@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3">
        </div>
        <div class="col-lg-6 mb-3">
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('photo.create')}}'"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span> </button>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card card-style">
            <div class="card-body ">
                @foreach($type as $data)
                <div>
                    <h4 class="my-3">{{$data['name']}}</h4>
                </div>
                <div class="row box">
                    @foreach($photos as $photo)
                    @if($photo['type'] == $data['type'])
                    <div class="col-lg-2 " style="text-align:center;">

                        <a href="{{route('photo.review', $photo->photo_id)}}">

                            <span class="mb-2" style="text-align:center">{{$photo->name}} </span>

                        </a>

                    </div>

                    @endif
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- <div>
    <label class="label-style col-form-label" for="company_name">&nbsp;</label>
    <select type="text" id="company_name" name="company_name" class="form-control" autofocus>
        <option value="grv">客家活動</option>
        <option value="rv">閱讀</option>
        <option value="rv">親子活動</option>
        <option value="rv">營運類</option>

    </select>
</div> -->
<!-- <div class="row justify-content-center">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card" style="margin: 10px 0px;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>Image</h1>
                <button class="btn btn-primary" onclick="location.href='{{route('photo.create')}}'">{{__('customize.Add')}}</button>
            </div>
            <div class="card-body">
                @foreach($type as $data)
                <div>
                    <h4 class="my-3">{{$data['name']}}</h4>
                </div>
                <div class="row box">
                    @foreach($photos as $photo)
                    @if($photo['type'] == $data['type'])
                    <div class="col-md-3 col-lg-3 " style="text-align:center;">

                        <a href="{{route('photo.review', $photo->photo_id)}}"><img class="mb-2" src="{{route('download', $photo['path'])}}" width="50%" alt=""></a>

                        <h4 class="mb-2" style="text-align:center">{{$photo->name}} </h4>
                    </div>

                    @endif
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
    {{--
        <div class="col-md-12 col-lg-10 col-xl-8">
            <hr>
        </div> --}}
</div> -->

@stop
@section('script')
<script src="{{ URL::asset('js/html5-qrcode.min.js') }}"></script>
<!-- <script type="module">
    import QrScanner from "{{ URL::asset('js/qr-scanner.min.js') }}";
    QrScanner.WORKER_PATH = "{{ URL::asset('js/qr-scanner-worker.min.js') }}";

    const video = document.getElementById('qr-video');
    const camHasCamera = document.getElementById('cam-has-camera');
    const camQrResult = document.getElementById('cam-qr-result');
    const camQrResultTimestamp = document.getElementById('cam-qr-result-timestamp');
    const fileSelector = document.getElementById('file-selector');
    const fileQrResult = document.getElementById('file-qr-result');

    function setResult(label, result) {
        label.textContent = result;
        camQrResultTimestamp.textContent = new Date().toString();
        label.style.color = 'teal';
        clearTimeout(label.highlightTimeout);
        label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
    }

    // ####### Web Cam Scanning #######

    QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);

    const scanner = new QrScanner(video, result => setResult(camQrResult, result));
    scanner.start();

    document.getElementById('inversion-mode-select').addEventListener('change', event => {
        scanner.setInversionMode(event.target.value);
    });

    // ####### File Scanning #######

    fileSelector.addEventListener('change', event => {
        const file = fileSelector.files[0];
        if (!file) {
            return;
        }
        QrScanner.scanImage(file)
            .then(result => setResult(fileQrResult, result))
            .catch(e => setResult(fileQrResult, e || 'No QR code found.'));
    });

</script> -->
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>

@stop