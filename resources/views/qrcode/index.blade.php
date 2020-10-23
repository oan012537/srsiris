
@include('inc_script')
    
    <!-- Page header -->
    <!--<div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <i class="icon-arrow-left52 position-left"></i>
                    <span class="text-semibold">Home</span> - Dashboard
                </h4>
            </div>
        </div>
    </div>-->
    <!-- /page header -->
    <style>
        video {
            max-width: 100%;
            /*height: auto!important;*/
            border:1px solid;
        }
    </style>
    

    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Vertical form -->
                        <!-- <div class="panel panel-flat"> -->
                            <!-- <div class="panel-heading"> -->
                            <!-- </div> -->
                            <!-- <div class="panel-body"> -->
                                <!-- <div class="container"> -->
                                    <div class="col-md-6 col-md-offset-3" style="margin-bottom: 10px;">
                                        <video autoplay id="video" height="100%" width="100%"></video>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 col-sm-4">
                                            <button id="start" class="btn btn-primary col-md-12 col-sm-12" style="padding: 20px 0px;">เปิดกล้อง</button>
                                        </div>
                                        <div class="col-4 col-sm-4">
                                            <button id="capture" class="btn btn-success col-md-12 col-sm-12" style="padding: 20px 0px;">สแกน</button>
                                        </div>
                                        <div class="col-4 col-sm-4">
                                            <button id="flip-btn" class="btn btn-danger col-md-12 col-sm-12" style="padding: 20px 0px;">สลับกล้อง</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <textarea name="" id="myText" class="form-control" rows="3" cols="3" readonly></textarea>
                                    </div>
                                <!-- </div> -->
                            <!-- </div> -->
                            <!-- /vertical form -->
                        <!-- </div> -->
                    </div>
                </div>

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/grid.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/version.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/detector.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/formatinf.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/errorlevel.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/bitmat.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/datablock.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/bmparser.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/datamask.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/rsdecoder.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/gf256poly.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/gf256.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/decoder.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/qrcode.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/findpat.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/alignpat.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jsqrcode-master/src/databr.js')}}"></script>

    <script type="text/javascript">
        navigator.getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
        canvas = document.createElement("canvas");
        ctx = canvas.getContext("2d");

        qrcode.callback = function (data) {
           window.parent.postMessage(data, "*");
           // console.log(data)
           document.getElementById("myText").value = data;
        };

        var video = document.querySelector("video");
        var streams = null;
        var defaultsOpts = { audio: false, video: true }
        var shouldFaceUser = true;
        // setting up start button
        var start = document.querySelector("#start");
        start.addEventListener("click", function (e) {

            defaultsOpts.video = { facingMode: shouldFaceUser ? 'user' : 'environment' }
            if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                // Not adding `{ audio: true }` since we only want video now
                navigator.mediaDevices.getUserMedia(defaultsOpts).then(function(stream) {
                    // video.src = window.URL.createObjectURL(stream);
                    streams = stream;
                    video.srcObject = stream;
                    // video.play();
                });
            }
        //     navigator.getUserMedia({"video":true}, function (stream) {
        //         video.src = window.URL.createObjectURL(stream);
        //     }); 
        }, false);

        // setting up capture button
        var capture = document.querySelector("#capture");
        capture.addEventListener("click", function (e) {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            data_url = canvas.toDataURL('image/png');
            // console.log(data_url);
            qrcode.decode(data_url);
        }, false);

        var flipBtn = document.querySelector('#flip-btn');
        
        flipBtn.addEventListener('click', function(){
            if( streams == null ) return
            // we need to flip, stop everything
            streams.getTracks().forEach(t => {
                t.stop();
            });
            // toggle / flip
            shouldFaceUser = !shouldFaceUser;
            start.click();
        });
        $("#video").css('height', (parseFloat($(window).height())-parseFloat($(window).height())/3)+'px')
        $(".panel-body").css('height', (parseFloat($(window).height())-150)+'px');
        console.log($(window).height())
        console.log((parseFloat($(window).height())-parseFloat($(window).height())/2))

    </script>
