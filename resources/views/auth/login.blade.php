@extends('layouts.template')
@section('stylesheet')


@stop('stylesheet')
@section('content')

<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content">
                    <h2 class="breadcrumb__title">login</h2>

                </div><!-- end breadcrumb-content -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->


<!-- ================================
       START FORM AREA
================================= -->
<section class="form-shared">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="contact-form-action">
                    <div class="form-heading text-center">
                        <h3 class="form__title">Login to your account!</h3>
                        <p class="form__desc">with your social network.</p>
                    </div>
                    <!--Contact Form-->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-12 form-group">
                                <button class="theme-btn sign-btn btn__google" >
                                    <i class="fa fa-google"></i> Google
                                </button>
                            </div><!-- end col-lg-4 -->
                            <div class="col-lg-6 col-sm-6 col-xs-12 form-group">
                                <button class="theme-btn sign-btn btn__facebook" >
                                    <i class="fa fa-facebook"></i> Facebook
                                </button>
                            </div><!-- end col-lg-4 -->

                            <div class="col-lg-12 col-sm-12 col-xs-12 account-assist text-center">
                                <p class="account__desc account__desc2">or</p>
                            </div><!-- end col-md-12 -->
                            <div class="col-lg-12 col-sm-12 form-group">
                                <input class="form-control" type="text" name="email" placeholder="Email">
                                @if ($errors->has('email'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif
                                <span class="la la-user input-icon"></span>
                            </div><!-- end col-md-12 -->
                            <div class="col-lg-12 col-sm-12 form-group">
                                <input class="form-control" type="text" name="password" placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <span class="la la-lock input-icon"></span>
                            </div><!-- end col-md-12 -->
                            <div class="col-lg-12 col-sm-12 col-xs-12 form-condition">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="chb1">
                                    <label for="chb1">Remember Me</label>
                                    <a href="{{url('password/reset')}}" class="pass__desc"> Forgot my password?.</a>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-xs-12 form-group">
                                <button class="theme-btn" type="submit">login now</button>
                            </div><!-- end col-md-12 -->
                            <div class="col-lg-12 col-sm-12 col-xs-12 account-assist">
                                <p class="account__desc">Not a member?<a href="{{url('register')}}"> Register now</a></p>
                            </div><!-- end col-md-12 -->
                        </div><!-- end row -->
                    </form>
                </div><!-- end contact-form -->
            </div><!-- end col-md-7 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end form-shared -->
<!-- ================================
       START FORM AREA
================================= -->

@endsection

@section('scripts')

@stop('scripts')
