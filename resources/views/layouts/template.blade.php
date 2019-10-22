<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="author" content="TechyDevs">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Aduca - Learning & Online Education HTML Template</title>


    @include('layouts.inc-style')
    @yield('stylesheet')








<body>

<!-- start cssload-loader -->

<!-- end cssload-loader -->







@include('layouts.inc-header')





@yield('content')








<!-- ================================
         END FOOTER AREA
================================= -->



@include('layouts.inc-footer')



<!-- ================================
          END FOOTER AREA
================================= -->

<!-- start scroll top -->
<div id="scroll-top">
    <i class="fa fa-angle-up" title="Go top"></i>
</div>
<!-- end scroll top -->



<!-- theme js files -->


@include('layouts.inc-script')
@yield('scripts')

</body>
</html>
