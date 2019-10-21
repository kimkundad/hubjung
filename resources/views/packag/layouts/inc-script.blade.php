<!-- Bootstrap core JavaScript-->
      <script src="{{url('web_stream/vendor/jquery/jquery.min.js')}}"></script>
      <script src="{{url('web_stream/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <!-- Core plugin JavaScript-->
      <script src="{{url('web_stream/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
      <!-- Owl Carousel -->
      <script src="{{url('web_stream/vendor/owl-carousel/owl.carousel.js')}}"></script>
      <!-- Custom scripts for all pages-->
      <script src="{{url('web_stream/js/custom.js')}}"></script>

      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-146201425-1"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-146201425-1');
      </script>


      @if (Auth::guest())
      @else
      <script>

      $.ajax({
      type: "POST",
      headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      data: { "id" : {{Auth::user()->id}} },
      url: "{{url('get_noti/')}}",
      success: function(data) {
          $('#messages').html(data.data.html);
          $('#messages_count').html("");
          $('#messages_count').html(data.data.count_noti);


          get_option = 1;
      }
      });


      $.ajax({
      type: "POST",
      headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      data: { "id" : {{Auth::user()->id}} },
      url: "{{url('check_course_online/')}}",
      success: function(data) {

          console.log(data.data.html);

      }
      });
      </script>
      @endif
