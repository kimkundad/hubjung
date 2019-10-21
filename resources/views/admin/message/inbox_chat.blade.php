@extends('admin.layouts.template')
@section('admin.stylesheet')
<link href="{{url('assets/css/chat-box.css')}}" rel="stylesheet" type="text/css">
@stop('admin.stylesheet')
@section('admin.content')






        <section role="main" class="content-body">

          <header class="page-header">
            <h2>{{$student_data->name}}</h2>

            <div class="right-wrapper pull-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="dashboard.html">
                    <i class="fa fa-home"></i>
                  </a>
                </li>

                <li><span>{{$student_data->name}}</span></li>
              </ol>

              <a class="sidebar-right-toggle" data-open="sidebar-right" ><i class="fa fa-chevron-left"></i></a>
            </div>
          </header>


          <!-- start: page -->
<style>

</style>
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
return "$strDay $strMonthThai $strYear $strHour:$strMinute";
}
 ?>

<div class="row">
              <div class="row">
              <div class="col-xs-12">

            <section class="panel">

              <div >

                <div class="col-md-2">
                </div>
                <div class="col-md-8">


















                  <div >

      <div class="popup-box chat-popup" id="qnimate">


        <div class="popup-messages">
          <div class="direct-chat-messages " id="messages_show">
            <div class="infinite-scroll">

              @if(isset($message_history))
              @foreach($message_history as $u)


            @if($u->provider == 'email')

            <div class="direct-chat-msg doted-border" id="m-list">
              <p class="direct-chat-detail">
                <img alt="message user image" src="{{url('assets/images/avatar/'.$u->avatar)}}" class="direct-chat-img">
                <span class="name-ms pull-left">{{$u->name}}</span>
                {{$u->message}}
              </p>
            </div>

            @else

            <div class="direct-chat-msg doted-border" id="m-list">
              <p class="direct-chat-detail">
                <img alt="message user image" src="//{{$u->avatar}}" class="direct-chat-img">
                <span class="name-ms pull-left">{{$u->name}}</span>
                {{$u->message}}
              </p>
            </div>

            @endif



            @endforeach



            @endif


          </div>
            </div>
        </div>










        <div id="login-chat-on2">

          <div class="popup-messages-footer" id="login-chat-on">

      <style>
      .popup-messages-footer-input {
          border-bottom: 1px solid #b2b2b2 !important;
          height: 34px !important;
          margin: 7px;
          padding: 5px !important;
          border: medium none;
          width: 95% !important;
      }
      </style>

        <form id="cutproduct1" onsubmit="return false">
                <input id="message_in" class="popup-messages-footer-input" placeholder="Type your message here..." />
                <input type="hidden" id="studen_user" name="studen_user" value="{{$student_data->id}}" />
                <div class="btn-footer">
              <!--  <button class="bg_none"><i class="glyphicon glyphicon-film"></i> </button>
            <button class="bg_none"><i class="glyphicon glyphicon-paperclip"></i> </button>
          -->

                <button class="bg_none"><i class="glyphicon glyphicon-camera"></i> </button>

                <button class="tooltip_flip tooltip-effect-1 bg_none pull-right"><i class="fa fa-paper-plane-o"></i> </button>
                </div>
        </form>

              </div>

        </div>







      </div>







                  <br>


                </div>


                </div>


                <div class="col-md-2">
                </div>

              </div>
            </section>

              </div>
            </div>
        </div>
</section>
@stop



@section('scripts')

<script type="text/javascript">
//$("#").scrollTop($("#messages_show")[0].scrollHeight);

var $chat = $('.popup-messages');

//var bottom = true;

$chat.bind('scroll', function () {
  var $scrollTop = $(this).scrollTop();
  var $innerHeight = $(this).innerHeight();
  var $scrollHeight = this.scrollHeight;
  //bottom = $scrollTop + $innerHeight >= $scrollHeight ? true : false;
});
$chat.animate({scrollTop: $chat.prop("scrollHeight")}, 500);


    </script>



<script>


$(document).ready(function(){

//$("#messages_show").scrollTop($("#messages_show")[0].scrollHeight);
$("#").scrollTop($("#messages_show")[0].scrollHeight);

$('.tooltip_flip.tooltip-effect-1').click(function(e){
e.preventDefault();

  var $form = $(this).closest("form#cutproduct1");
            var formData =  $form.serializeArray();
   var dataString = {
          message_in : $form.find("#message_in").val(),
          studen_user : $form.find("#studen_user").val(),
          _token : '{{ csrf_token() }}'
        };

    $.ajax({
        type: "POST",
        url: "{{url('admin/admin_message_sender')}}",
        data: dataString,
        dataType: "json",
        cache : false,
        success: function(data){

          $("#message_in").val('');

          if(data.success == true){


            socket.emit('new_count_message', {
                new_count_message: data.new_count_message
              });

          //  $("#notif").html(data.notif);

          socket.emit('new_message', {
            timer: data.timer,
            name: data.name,
            avatar: data.avatar,
            provider: data.provider,
            check_noti: data.check_noti,
            chat_user_id: data.chat_user_id,
            message_in: data.message_in,
            agent_id: data.agent_id,
            playerid:data.playerid
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


$('#cutproduct1').keyup(function(e){
  e.preventDefault();
  if (e.which === 13) {
    $('.tooltip_flip.tooltip-effect-1').trigger('click');
  }
});







socket.on( 'new_count_message', function( data ) {

$( "#new_count_message" ).html( data.new_count_message );
  console.log(data.new_count_message);
});


$("#messages_show").scrollTop($("#messages_show")[0].scrollHeight);
socket.on( 'new_message', function( data ) {
  console.log(data.message_in);

  if(data.chat_user_id == {{$student_data->id}}){


    if(data.provider === 'email'){
      $( "#messages_show" ).append('<div class="direct-chat-msg doted-border" id="m-list"><p class="direct-chat-detail"><img alt="message user image" src="{{url('assets/images/avatar/')}}/'+data.avatar+'" class="direct-chat-img"><span class="name-ms pull-left">'+ data.name +' </span> '+ data.message_in +'</p></div>');
    }else{
      $( "#messages_show" ).append('<div class="direct-chat-msg doted-border" id="m-list"><p class="direct-chat-detail"><img alt="message user image" src="//'+data.avatar+'" class="direct-chat-img"><span class="name-ms pull-left">'+ data.name +' </span> '+ data.message_in +'</p></div>');
    }


  }
  if(data.chat_user_id == {{Auth::user()->id}}){

    if(data.provider === 'email'){
      $( "#messages_show" ).append('<div class="direct-chat-msg doted-border" id="m-list"><p class="direct-chat-detail"><img alt="message user image" src="{{url('assets/images/avatar/')}}/'+data.avatar+'" class="direct-chat-img"><span class="name-ms pull-left">'+ data.name +' </span> '+ data.message_in +'</p></div>');
    }else{
      $( "#messages_show" ).append('<div class="direct-chat-msg doted-border" id="m-list"><p class="direct-chat-detail"><img alt="message user image" src="//'+data.avatar+'" class="direct-chat-img"><span class="name-ms pull-left">'+ data.name +' </span> '+ data.message_in +'</p></div>');
    }

  }

  console.log(data.chat_user_id);
  if(data.check_noti === 0 && data.chat_user_id != {{$student_data->id}}){

    if(data.provider === 'email'){
      $( "#messages_noti" ).append('<li><a href="{{url('admin/inbox_chat/')}}/'+ data.chat_user_id +'" class="clearfix"><figure class="image"><img src="{{url('assets/images/avatar/')}}/'+data.avatar+'" width="35" height="35" class="img-circle"></figure><span class="title">'+ data.name +'</span><span class="message">มีข้อความมาใหม่ถึงคุณ</span></a></li>');

    }else{
      $( "#messages_noti" ).append('<li><a href="{{url('admin/inbox_chat/')}}/'+ data.chat_user_id +'" class="clearfix"><figure class="image"><img src="//'+data.avatar+'" width="35" height="35" class="img-circle"></figure><span class="title">'+ data.name +'</span><span class="message">มีข้อความมาใหม่ถึงคุณ</span></a></li>');

    }


  }






  console.log(data.check_noti);
  var $chat = $('.popup-messages');
  $chat.bind('scroll', function () {
    var $scrollTop = $(this).scrollTop();
    var $innerHeight = $(this).innerHeight();
    var $scrollHeight = this.scrollHeight;
    //bottom = $scrollTop + $innerHeight >= $scrollHeight ? true : false;
  });
  $chat.animate({scrollTop: $chat.prop("scrollHeight")}, 500);
  $('#notif_audio')[0].play();
});

</script>
@if ($message = Session::get('success'))
<script type="text/javascript">
var stack_bar_top = {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0};
var notice = new PNotify({
      title: 'ยินดีด้วยค่ะ',
      text: '{{$message}}',
      type: 'success',
      addclass: 'stack-bar-top',
      stack: stack_bar_top,
      width: "100%"
    });
</script>
@endif


@if ($message = Session::get('delete'))
<script type="text/javascript">
var stack_bar_top = {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0};
var notice = new PNotify({
      title: 'ยินดีด้วยค่ะ',
      text: '{{$message}}',
      type: 'success',
      addclass: 'stack-bar-top',
      stack: stack_bar_top,
      width: "100%"
    });
</script>
@endif

@stop('scripts')
