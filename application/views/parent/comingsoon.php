<!DOCTYPE html>
<?php
$teacher = array(
    'Amit Pratap',
    'Sunil Kumar',
    'Manoj Pandey',
    'Adarsh Kumar',
    'Manish Kumar',
    'Ravi Kumar Shastri');
$studentlist = array(
    '4323.Akhilesh Malhotra',
    '2312.Gaurav Rajput',
    '3422.Vishal Singh',
    '1249.Mayank Kumar',
    '1243.Abhinav Kumar',
    '1658.Manav Singh');
$starttime = 1427839200;
$endtime = 1436738400;
$arraySubject = array('English', 'Hindi', 'Math', 'Science', 'Social Studies');
$ccelist = array(
    "Self Awareness",
    "Problem Solving",
    "Decision Making",
    " Critical Thinking",
    "Creative Thinking",
    "Interpersonal Relationship",
    "Effective Communication",
    "Empathy",
    " Managing Emotions",
    "Dealing with Stress",
    "Work Education",
    "Visual and Performing Arts",
    "Attitude Toward Teachers",
    "School-Mates",
    "School Programme and Enviroment",
    "Value Systems",
    "Literary and Creative Skills",
    "Scientific Skills",
    "Sports",
    " First Aid",
    "Club"
);
$ccegrades = array(
    'A', 'A+', 'B', 'C', 'D', 'E'
);
$ccedilist = array(
    "Very talkative but get along well with students. He takes criticism positively.",
    "Takes time to think...But has shown a lot of improvement recently.",
    "Thinks beyond the textbook",
    "Takes criticism in the right spirit",
    "Shows respect and courtesy to all inside and outside the classroom",
    "Shows a high degree of scientific awareness",
    "He analyzes situations, interprets & acts accordingly",
    "Shares a healthy rapport with peers and mates"
);
$atendancereason = array(
    "due to fever",
    "due to stomach pain",
    "Went for school trip",
    "Reason not specified"
);
$tardydetails = array(
    "Bus did not came",
    "Gone to hospital",
    "Wake up late",
    "Traffic jam"
);
$eventslist = array(
    "Quiz Competition",
    "Independence Day Celebration",
    "Web Page Designing",
    "Nukkad Natak",
    "Inter House Celebration"
);
$noticelist = array(
    "Mahashivratri Holiday",
    "Scheduled for PTM",
    "Weekly Tests (8th to 11th) Term 2 (2014-2015)",
    "Math Practice Register",
    "Holiday home work in science",
    "Get the page 14 of your diary signed by your parents positively by tomorrow",
    "Recommended Reading List for Summer",
    "Non submission of science practical file",
    "Submit Disaster Mngmt Project & Assignmt. Notebook",
    "Dress code for Monday and Friday",
    "Non submission of PPT in science"
);
$cardstheory = array(
    "blue" => array('Good responce in the class.', 'Good Anchoring of the Christmas Program'),
    "yellow" => array('Misbehaving,irregular in submitting biology home work and does not bring practical record regulary.', 'For not bringing prop  for practice inspite of several reminders')
);
?>
<html lang="en">
    <head>

        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin">
        <!-- BEGIN HEADER-->
        <?php
        $this->load->view('include_parent/header');
        ?>

        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body">

                        <div class="text-center text-warning" style="margin-top: 16%;">
                            <i class="fa fa-wrench fa-15x"></i><br/>
                            <p class="text-xxxl text-ultra-bold">Coming Soon...</p> 
                        </div>


                    </div><!--end .section-body -->
                </section>
            </div><!--end #content-->		
            <!-- END CONTENT -->

            <!-- BEGIN MENUBAR-->
            <div id="menubar" class="menubar-inverse">
                <div class="menubar-fixed-panel">
                    <div>
                        <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="expanded">
                        <a href="dashboard.html">
                            <span class="text-lg text-bold text-primary ">Mera School Portal</span>
                        </a>
                    </div>
                </div>
                <div class="menubar-scroll-panel">
                    <!-- BEGIN MAIN MENU -->
                    <?php
                    $this->load->view('include_parent/sidemenu.php');
                    ?>
                    <!-- END MAIN MENU -->

                    <div class="menubar-foot-panel">
                        <small class="no-linebreak hidden-folded">
                            <span class="opacity-75">Copyright &copy; <?php echo date('Y'); ?></span> <strong>Mera School Portal</strong>
                        </small>
                    </div>
                </div><!--end .menubar-scroll-panel-->
            </div><!--end #menubar-->
            <!-- END MENUBAR -->



        </div><!--end #base-->	
        <!-- END BASE -->


        <!-- BEGIN JAVASCRIPT -->

        <?php
        $this->load->view('include_parent/headjs');
        ?>

        <!-- END JAVASCRIPT -->



    </body>
</html>