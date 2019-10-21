
@extends('layouts.app')
@section('stylesheet')
<link href="{{url('assets/css/select-project.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/css/confirm.css')}}" rel="stylesheet" type="text/css" />

<link href="{{url('assets/css/chat-box.css')}}" rel="stylesheet" type="text/css">
<style type="text/css">
.row {
    margin-left: initial;
    margin-right: initial;
}
.btn-fb {
    border: 1px solid #3b5998;
    color: white;
    background-color: #5A73AA;
    border-radius: 2px;
    float: left;
}
.btn-mini.border-btn {
    padding: 2px 12px;
    font-size: 13px;
}
.btn-wishlist {
    padding: 2px 7px !important;
    font-size: 14px;
    padding: 5px;
    -moz-transition: 0.8s;
    -webkit-transition: 0.8s;
    -o-transition: 0.8s;
    transition: 0.8s;
    opacity: 0.85;
    margin-top: 15px;
    margin-left: 4px;
    font-size: 12px

}
.head-lines {
    position: absolute;
    /* bottom: 0; */
    /* left: 0; */
    display: block;
    width: 50px;
    height: 3px;
    background-color: #00c402;
    margin: 0;
}
hr {
    margin-top: 10px;
    margin-bottom: 10px;
    }

    @media screen and (max-width: 500px) /* Mobile */ {
  .extra-paddingright {
    padding-right: 0px;
    padding-left: 0px;
}
.course-overall {
    border: none;
}
.wigt-content{
  margin-top: 20px;
  padding-right: 0px;
    padding-left: 0px;
}

}
.yt-live-chat-message{
          width: 100%;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -ms-flex-direction: row;
        -webkit-flex-direction: row;
        flex-direction: row;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        position: relative;
        border-radius: inherit;
            margin: 0;
            padding: 10px 16px;
                background-color: hsl(0, 0%, 93.3%);
        }
        .yt-live-chat-messages{
          width: 100%;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -ms-flex-direction: row;
        -webkit-flex-direction: row;
        flex-direction: row;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        position: relative;
        border-radius: inherit;
            margin: 0;
            padding: 5px 16px;
            color: hsla(0, 0%, 6.7%, .6);
        }
        .popup-box .popup-messages {
    background: #fff none repeat scroll 0 0;
    height: 410px;
    overflow: auto;
}
.popup-box {
    background-color: #ffffff;
    border: 1px solid #b0b0b0;
    bottom: 0;
    height: 515px;
    font-family: 'Open Sans', sans-serif;
}
.realtimeuserscounter__attr{
  display: none!important;
}
</style>

@stop('stylesheet')
@section('content')

<?php
function DateThai($strDate)
{
$strYear = date("Y",strtotime($strDate))+543;
$strMonth= date("n",strtotime($strDate));
$strDay= date("j",strtotime($strDate));
$strHour= date("H",strtotime($strDate));
$strMinute= date("i",strtotime($strDate));
$strSeconds= date("s",strtotime($strDate));
$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$strMonthThai=$strMonthCut[$strMonth];
return "$strDay $strMonthThai $strYear";
}
 ?>

<div class="content-section-a" style="padding: 25px 0;">
<div class="container" >


    <div class="row">


      <div class="col-md-8">

        <iframe style="width:100%" height="400" src="{{$course->url_youtube}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        <h4>{{$course->title_course}}</h4>
        <p style="font-size: 13px;">
          {{$course->detail_course}}
        </p>
        <h5><i class="fa fa-user"></i> จำนวนนักเรียนที่ดู <span id="count_user"></span></h5>

        @if($course->live_stream_status == 1)
        <h4 class="text-danger"><i class="fa fa-youtube-play"></i> กำลัง Live Streamming</h4>
        @else
        <h4 class="text-muted"><i class="fa fa-youtube-play"></i> ปิด Live Streamming</h4>
        @endif



      </div>


      <div class="col-md-4">
          <div class="popup-box chat-popup" id="qnimate">

            <div class="popup-messages">
            <div class="direct-chat-messages" id="messages_show">


              </div>
            </div>



              <form id="cutproduct1" onsubmit="return false">


                  <div id="login-chat-on2">

                    <div class="popup-messages-footer" id="login-chat-on">


                          <form id="cutproduct1" onsubmit="return false">


                                <input id="message_in" placeholder="Type your message here..." />
                                <div class="btn-footer">

                              <!--  <button class="bg_none"><i class="glyphicon glyphicon-film"></i> </button>
                                <button class="bg_none"><i class="glyphicon glyphicon-camera"></i> </button>
                                <button class="bg_none"><i class="glyphicon glyphicon-paperclip"></i> </button> -->

                                <button class="tooltip_flip tooltip-effect-1 bg_none pull-right"><i class="fa fa-paper-plane-o"></i> </button>
                                </div>

                          </form>



                        </div>

                  </div>


              </form>

</div>


<br />

<style>
ul.simple-user-list {
    list-style: none;
    padding: 0;
}
ul.simple-user-list li {
    margin: 0 0 20px;
}
ul.simple-user-list li .image {
    float: left;
    margin: 0 10px 0 0;
    height: 35px;
    width: 35px;
}
.img-circle {
    border-radius: 50%;
}
ul.simple-user-list li .title {
    color: #000011;
    display: block;
        padding-top: 8px;
    line-height: 1.334;
}
ul.simple-user-list li .message {
    display: block;
    font-size: 1.1rem;
    line-height: 1.334;
}
</style>

<div class="popup-box " id="qnimate" style="padding:20px; height: auto;">


  <ul class="simple-user-list" id="message-tbody">

    @if($get_user_active)
      @foreach($get_user_active as $u)

        @if($u->provider == 'email')
                    <li>
                      <figure class="image rounded">
                        <img src="{{url('assets/images/avatar/'.$u->avatar)}}" style="height: 35px;" class="img-circle">
                      </figure>
                      <span class="title">{{$u->name}}</span>

                    </li>
        @else

                    <li>
                      <figure class="image rounded">
                        <img src="//{{$u->avatar}}" style="height: 35px;" class="img-circle">
                      </figure>
                      <span class="title">{{$u->name}}</span>

                    </li>

        @endif

      @endforeach
    @endif


										</ul>
</div>




                    </div>



    </div>



</div>
</div>
@endsection


@section('scripts')

<script src="{{url('node_modules/socket.io-client/dist/socket.io.js')}}"></script>

<script>
var socket = io.connect( 'https://'+window.location.hostname+':3000' ,{secure: true});


socket.on('connect',function(){


//  client.join('room1');
console.log("connect");
});

$(document).ready(function(){


  if({{Auth::user()->id}} === 1 ){


    var dataString2 = {
           user_id : {{Auth::user()->id}},
           _token : '{{ csrf_token() }}'
         };

    $.ajax({
        type: "POST",
        url: "{{url('chat_room_get_user')}}",
        data: dataString2,
        dataType: "json",
        cache : false,
        success: function(data){

          if(data.success == true){

          socket.emit('adduser', {
            name: data.name,
            count_user: data.count_user,
            avatar: data.avatar,
            room_id:{{$channel}},
            provider: data.provider,
            chat_user_id: data.chat_user_id,
            type: 1,
            message_in: data.message_in
          });

          } else if(data.success == false){

            alert("ไม่ต้องกดก็ได้");


          }

        } ,error: function(xhr, status, error) {
          alert(error);
        },

    });

  }





$("#messages_show").scrollTop($("#messages_show")[0].scrollHeight);

$('.tooltip_flip.tooltip-effect-1').click(function(e){

e.preventDefault();

  var $form = $(this).closest("form#cutproduct1");

  if($form.find("#message_in").val().length == 0){
    return;
  }

  var formData =  $form.serializeArray();
   var dataString = {
          message_in : $form.find("#message_in").val(),
          _token : '{{ csrf_token() }}'
        };



    $.ajax({
        type: "POST",
        url: "{{url('user_ans/message_sender1')}}",
        data: dataString,
        dataType: "json",
        cache : false,
        success: function(data){

          $("#message_in").val('');

          if(data.success == true){



          //  $("#notif").html(data.notif);

          socket.emit('new_message_room', {
            name: data.name,
            avatar: data.avatar,
            provider: data.provider,
            chat_user_id: data.chat_user_id,
            channel_id:{{$channel}},
            message_in: data.message_in
          });

          } else if(data.success == false){

            alert("ไม่ต้องกดก็ได้");


          }

        } ,error: function(xhr, status, error) {
          alert(error);
        },

    });


});
});


var $chat = $('.popup-messages');

//var bottom = true;

$chat.bind('scroll', function () {
  var $scrollTop = $(this).scrollTop();
  var $innerHeight = $(this).innerHeight();
  var $scrollHeight = this.scrollHeight;
  //bottom = $scrollTop + $innerHeight >= $scrollHeight ? true : false;
});



socket.on( 'new_message_room', function( data ) {

  var now = new Date();
    if(data.provider === 'email'){
      $( "#messages_show" ).append('<div class="direct-chat-msg doted-border" id="m-list"><p class="direct-chat-detail"><img alt="message user image" src="{{url('assets/images/avatar/')}}/'+data.avatar+'" class="direct-chat-img"><span class="name-ms pull-left">'+ data.name +' </span> '+ data.message_in +'</p></div>');
    }else{
      $( "#messages_show" ).append('<div class="direct-chat-msg doted-border" id="m-list"><p class="direct-chat-detail"><img alt="message user image" src="//'+data.avatar+'" class="direct-chat-img"><span class="name-ms pull-left">'+ data.name +' </span> '+ data.message_in +'</p></div>');
    }


    $chat.animate({scrollTop: $chat.prop("scrollHeight")}, 500);
  //}

});

socket.on( 'adduser', function( data ) {

  var now = new Date();
    if(data.provider === 'email'){
      $( "#messages_show" ).append('<div class="direct-chat-msg doted-border" id="m-list"><p class="direct-chat-detail"><img alt="message user image" src="{{url('assets/images/avatar/')}}/'+data.avatar+'" class="direct-chat-img"><span class="name-ms pull-left">'+ data.name +' </span> '+ data.message_in +' </p></div>');
    }else{
      $( "#messages_show" ).append('<div class="direct-chat-msg doted-border" id="m-list"><p class="direct-chat-detail"><img alt="message user image" src="//'+data.avatar+'" class="direct-chat-img"><span class="name-ms pull-left">'+ data.name +' </span> '+ data.message_in +'</p></div>');
    }
    $('#count_user').html('');
    $("#count_user").append(data.count_user);

    if(data.type === 1){

      if(data.provider === 'email'){
      $("#message-tbody").append('<li id="user_'+data.chat_user_id+'"><figure class="image rounded"><img style="height: 35px;" src="{{url('assets/images/avatar/')}}/'+data.avatar+'" alt="'+ data.name +' " class="img-circle"></figure><span class="title">'+ data.name +' </span></li>');
      }else{
      $("#message-tbody").append('<li id="user_'+data.chat_user_id+'"><figure class="image rounded"><img style="height: 35px;" src="//'+data.avatar+'" alt="'+ data.name +' " class="img-circle"></figure><span class="title">'+ data.name +' </span></li>');
      }
    }else{
      $('#user_'+data.chat_user_id+'').remove();
    }



  });









</script>


@stop('scripts')
