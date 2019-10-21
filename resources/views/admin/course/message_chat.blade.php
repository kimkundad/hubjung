@extends('admin.layouts.template')
@section('admin.content')

        <section role="main" class="content-body">

          <header class="page-header">
            <h2>{{$datahead}}</h2>

            <div class="right-wrapper pull-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="dashboard.html">
                    <i class="fa fa-home"></i>
                  </a>
                </li>

                <li><span>{{$datahead}}</span></li>
              </ol>

              <a class="sidebar-right-toggle" data-open="sidebar-right" ><i class="fa fa-chevron-left"></i></a>
            </div>
          </header>


          <!-- start: page -->


          <!-- start: page -->
          <div class="timeline timeline-simple changelog">
            <div class="tm-body">
              <ol class="tm-items">



                @if($data2)
                @foreach($data2 as $u)

                <li>
                  <div class="tm-box">
                    <h4>Live วันที่</h4> – <span class="release-date">{{$u->created_at}}</span>
                    <ul class="list-unstyled">

                      @if($u->option)
                      @foreach($u->option as $j)
                      <li>
                        @if($j->provider == 'email')
                        <img data-view="user_avatar_1980" alt="" src="{{url('assets/images/avatar/'.$j->avatar)}}"
                        class="avatar avatar-32 photo" width="32" height="32" data-pin-nopin="true">
                        @else
                        <img data-view="user_avatar_1980" alt="" src="//{{$j->avatar}}"
                        class="avatar avatar-32 photo" width="32" height="32" data-pin-nopin="true">
                        @endif

                      <b style="color: #000;">{{$j->name}}</b> - {{$j->message}}
                        </li>
                        @endforeach
                      @endif

                    </ul>
                  </div>
                </li>
                @endforeach
                @endif

              </ol>
            </div>
          </div>
          <!-- end: page -->






</section>
@stop



@section('scripts')







@if ($message = Session::get('success_course'))
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
