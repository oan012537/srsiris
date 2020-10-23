<head>
  <meta charset="utf-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- <title>@yield('title')</title> --}}
  <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.5/flatly/bootstrap.min.css" rel="stylesheet">
  <link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
</head>
{{-- @section('content') --}}
      <div class="container-fluid header_se">
      <div class="col-md-2">
      </div>
      <div class="col-md-8">
      {{-- @if(!Sentinel::getUser()) --}}
          <div class="row">
            <div id="reader" class="center-block" style="width:300px;height:250px;background-color: getorderdata;">
            </div>
          </div>
          <div class="row">
            <div id="message" class="text-center">
            </div>
          </div>
      {{-- @else --}}
        {{-- <h1>Hallo! {{Sentinel::getUser()->first_name}}</h1> --}}
      {{-- @endif --}}
       </div>
      <div class="col-md-2">
      </div>
      
    </div>
{{-- @endsection --}}
{{-- @if( !Sentinel::getUser()) --}}
{{-- @section('scripts') --}}
<script src="{{asset('assets/qr_login/jsqrcode-combined.min.js')}}"></script>
<script src="{{asset('assets/qr_login/html5-qrcode.min.js')}}"></script>
<script type="text/javascript">
   $('#reader').html5_qrcode(function(data){
    console.log(data)
        $('#message').html('<span class="text-success send-true">Scanning now....</span>');
        if (data!='') {
                 $.ajax({
                    type: "POST",
                    cache: false,
                    url : "{{action('QrLoginController@checkUser')}}",
                    data: {"_token": "{{ csrf_token() }}",data:data},
                        success: function(data) {
                          console.log(data);
                          if (data==1) {
                            //location.reload()
                            $(location).attr('href', '{{url('/')}}');
                          }else{
                           return confirm('There is no user with this qr code'); 
                          }
                          // 
                        }
                    })
        }else{return confirm('There is no  data');}
    },
    function(error){
       $('#message').html('Scaning now ....'  );
    }, function(videoError){
       $('#message').html('<span class="text-danger camera_problem"> there was a problem with your camera </span>');
    }
);
</script>

{{-- @endsection --}}
{{-- @endif --}}