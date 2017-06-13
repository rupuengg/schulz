<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/angular-block-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/angular-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ng-img-crop.js?v=<?php echo rand(); ?>"></script>
<script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/spin.js/spin.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/autosize/jquery.autosize.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/toastr/toastr.js"></script>
<script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/core/cache/63d0445130d69b2868a8d28c93309746.js"></script>
<script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/core/demo/Demo.js"></script>
<script type="text/javascript">
    var currentURL = '<?php echo base_url(uri_string()); ?>';
    var siteURL = '<?php echo base_url(); ?>';
    if (currentURL != siteURL) {
        function CheckSession() {
            setInterval(function () {
                $.ajax({
                    url: siteURL + "index.php/checkislogin",
                    success: function (data) {
                        if (data == 'TIMEOUT') {
                            window.location.href = siteURL;
                        } 
                    }
                });

            }, 300000);
        }
        CheckSession();
    }


</script>