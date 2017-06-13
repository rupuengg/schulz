<!DOCTYPE html>
<html lang="en">
    <title>
        ID CARD
    </title>
    <style>
        #header-image{
            background: #7B0002;
            padding-top: 0px;

        }
        #content-image{
            padding-bottom: 0px;
            background: #eeeeee;
            height: 367px;
            overflow: hidden;
        }
        #footer-image{
            background: #7B0002;
            height:40px;
            margin-bottom: 20px;

        }
        #powerd{
            text-align: center;
            color: wheat;
            padding-top: 10px;

        }
        .schoolname{
            font-family: 'Slabo 18px', serif;
            font-size: 100%;

        }
    </style>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />


    <div class="col-md-4">
        <div id="header-image">
            <div class="">
                <div  class="row" style="line-height: 0.1;">
                    <div class="myNewclass col-md-3" style="min-height: 10px; padding-left:20px; padding-top: 12px">
                        <img alt="" src="<?php echo base_url() . $schoolinfo['school_logo_path'] ?>" >   
                    </div>
                    <div class="col-md-9 text-center" style=" color:#fff; padding-left:0px; " >
                        <h1 class="schoolname"><b><?php echo $schoolinfo['school_name']; ?></b></h1> 
                        <p><b><?php echo $schoolinfo['school_address']; ?></b></p>
                        <h5><b>Ph : <span><?php echo $schoolinfo['school_phone']; ?></span></b></h5>
                        <h5><b>Email : <span><?php echo $schoolinfo['email_id']; ?></span></b></h5>
                    </div>
                </div>
            </div>
        </div>
        <div id="content-image">
            <div class="">
                <div  class="row">
                    <div class="col-md-8">
                        <div style="padding-left: 10px; padding-bottom: 5px;"><h4><b><?php echo $idcardinfo['stud_name'] ?></b></h4></div> 
                        <div><b><span class="col-md-4">F/Name: </span></b><span class="col-md-8 text-left"><?php echo $idcardinfo['g_name'] ?></span></div>
                        <div><br><b><span class="col-md-4">Adm.No.: </span></b><span class="col-md-8 text-left"><?php echo $idcardinfo['adm_no'] ?></span></div> 
                        <div><br><b><span class="col-md-4">Class:</span></b><span class="col-md-8 text-left"><?php echo $idcardinfo['class'] ?></span></div>                                                                
                        <div><br><b><span class="col-md-4">Address:</span></b><span class="col-md-8 text-left"><?php echo $idcardinfo['address'] ?></span></div> 
                        <div><br><b><span class="col-md-4">Phn.No:</span></b><span class="col-md-8 text-left"><?php echo $idcardinfo['contact_no'] ?></span></div> 
                        <div style="padding-left:10px;"><span class="col-md-12"></span></div>

                    </div>
                    <div class="myNewclass col-md-4"  style="width: 30%; min-height: 50px;">
                        <p><h5><b>2015-2016</b></h5></p>
                        <img alt="" src="<?php echo base_url(); ?>/index.php/staff/getstudphoto/<?php echo $idcardinfo['adm_no'] ?>/THUMB"
                             class="img-thumbnail">

                        <p><b>Principal Sign:</b></p>
                    </div>
                    <div class="myNewclass col-md-4"  style="width: 30%; min-height: 50px; margin-top: 280px; margin-left: -340px;">
                        <img alt="" src="<?php echo base_url(); ?>/files/idcards/<?php echo $idcardinfo['adm_no']; ?>.gif" class="">

                    </div>
                </div>
            </div>
        </div>

        <div id="footer-image">
            <div class="">
                <div  class="row">
                    <div class="col-md-12" id="powerd">
                        <p>Powered BY Invetech solutions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



