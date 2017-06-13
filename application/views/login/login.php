<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">

    <title><?php echo appName; ?></title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Mera School Portal,School Management Online Portal,SAMS">
    <meta name="description" content="Mera School Portal is web based school automation sytstem to handle all type of school activity">
    <!-- END META -->

    <?php $this->load->view('include/headcss');?>
    <style type="text/css"></style>

</head>






<body ng-app="login" ng-controller="loginController" class="menubar-hoverable header-fixed " style="background-color: white">

    <!-- BEGIN LOGIN SECTION -->
    <section class="section-account" >
        <div class="img-backdrop" style="background-image: url('<?php echo base_url(); ?>assets/img/modules/materialadmin/img16.jpg')"></div>
        <div class="spacer"></div>
        <div class="card contain-sm style-transparent">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-8">
                        <img src="<?php echo  base_url().appLogo; ?>"/>
                        <br><br>
                        <form name="myForm" class="form floating-label"  accept-charset="utf-8" novalidate>
                            <div class="form-group">
                                <input ng-enter="loginMe()"  required ng-model="username" type="text" class="form-control" id="username" name="username">
                                <label for="username" class="heavyfont">Username</label>
                            </div>
                            <div class="form-group">
                                <input ng-enter="loginMe()" required ng-model="password" type="password" class="form-control" id="password" name="password">
                                <label for="password" class="heavyfont">Password</label>
                                <p class="help-block"><a href="#">Forgotten?</a></p>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-6 text-left">
                                    <div class="checkbox checkbox-inline checkbox-styled">
                                        <label>
                                            <input  type="checkbox"> <span>Remember Me</span>
                                        </label>
                                    </div>
                                </div><!--end .col -->
                                <div class="col-xs-6 text-right">
                                    <button ng-click="loginMe()" class="btn btn-primary btn-raised" type="submit">Login</button>
                                </div><!--end .col -->
                            </div><!--end .row -->
                        </form>
                    </div><!--end .col -->
<!--                    <div class="col-sm-5 col-sm-offset-1 text-center">
                        <br><br>
                        <h3 class="text-light">
                            No account yet?
                        </h3>
                        <a class="btn btn-block btn-raised btn-primary" href="#">Sign up here</a> 
                        <br><br>
                        <h3 class="text-light">
                            or
                        </h3>
                        <p>
                            <a href="#" class="btn btn-block btn-raised btn-info"><i class="fa fa-facebook pull-left"></i>Login with Facebook</a>
                        </p>
                        <p>
                            <a href="#" class="btn btn-block btn-raised btn-info"><i class="fa fa-twitter pull-left"></i>Login with Twitter</a>

                    </div>end .col -->
                </div><!--end .row -->
            </div><!--end .card-body -->
        </div><!--end .card -->
    </section>
    <!-- END LOGIN SECTION -->
    <!-- BEGIN JAVASCRIPT -->
    <?php $this->load->view('include/headjs');?>
    <script src="<?php echo base_url(); ?>assets/myjs/login.js?v=<?php echo rand(); ?>"></script>
    <script>var myUrl = "<?php echo base_url(); ?>";</script>
    <div id="device-breakpoints"><div class="device-xs visible-xs" data-breakpoint="xs"></div><div class="device-sm visible-sm" data-breakpoint="sm"></div><div class="device-md visible-md" data-breakpoint="md"></div><div class="device-lg visible-lg" data-breakpoint="lg"></div></div></body></html>
