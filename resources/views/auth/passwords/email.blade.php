

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
                    <h2 class="breadcrumb__title">Recover password</h2>

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
                    <div class="form-heading">
                        <h3 class="form__title">Reset Password!</h3>
                        <p class="form__desc reset__desc">
                            Enter the email of your account to reset password.
                            Then you will receive a link to email to reset the
                            password.If you have any issue about reset password <a href="#">contact us</a>
                        </p>
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <!--Contact Form-->
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Enter email address">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <span class="la la-envelope-o input-icon"></span>
                            </div><!-- end col-md-12 -->
                            <div class="col-lg-12 col-sm-12 col-xs-12 form-group">
                                <button class="theme-btn" type="submit">reset password</button>
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
