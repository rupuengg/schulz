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
                    <div class="row">			
                        <div class="col-lg-12 small-padding">

                            <!-- BEGIN BLOG MASONRY -->
                            <div class="card card-type-blog-masonry style-default-bright">
                                <div class="row">
                                    <div class="col-md-4">
                                        <article>
                                            <div class="blog-image">
                                                <img src="../../assets/img/modules/materialadmin/img2bf67.jpg?1422538637" alt="" />
                                            </div>
                                            <div class="card-body blog-text">
                                                <div class="opacity-50">Held on February 20, 2015 by at School Premises</div>
                                                <h3><a class="link-default" href="post.html">AlTA National Ranking Tennis Tournament</a></h3>
                                                <p>All India Tennis Association National Ranking Talent Series Tennis Tournament was held at Bhagat Hansraj Tennis academy at Gohana, Sonipat from 30th March to 01 April 2015. Kavya Khirwar of 7B secured 1st position in girls U/12 age category and 2nd position in girls U/16 age category. She was awarded a trophy, a certificate and a T-shirt.</p>
                                            </div>
                                        </article><!-- end /article -->
                                    </div><!--end .col -->
                                    <div class="col-md-4">
                                        <article>
                                            <div class="card-body style-primary-dark blog-text">
                                                <div class="opacity-50">Held on April 6, 2015 by at School Premises</div>
                                                <h3><a class="link-default" href="post.html">Students Welcome Assembly</a></h3>
                                                <p>A special assembly was conducted on April 6, 2015 to welcome the students and teachers to the new academic session 2015-2016. Mrs. Howell, the Principal addressed the assembly challenging the students and staff from the life of Daniel in the Bible. She said that Daniel displayed certain qualities which as young students desirous of success, we need to inculcate. She presented the keys for success - trustworthiness ...</p>
                                            </div>
                                            <div class="blog-image">
                                                <img class="img-responsive" src="../../assets/img/modules/materialadmin/img5c73a.jpg?1422538639" alt="" />
                                            </div>
                                        </article><!-- end /article -->

                                    </div><!--end .col -->
                                    <div class="col-md-4">
                                        <article>
                                            <div class="blog-image">
                                                <img class="img-responsive" src="../../assets/img/modules/materialadmin/img3bf67.jpg?1422538637" alt="" />
                                            </div>
                                            <div class="card-body blog-text">
                                                <div class="opacity-50">Held on April 17, 2015 by at Eternal Gandhi Multimedia Museum</div>
                                                <h3><a class="link-default" href="post.html">Educational Trip To Eternal Gandhi Multimedia Museum</a></h3>
                                                <p>The students of classes IV and V went for a field trip to Eternal Gandhi Multimedia Museum, one of the world’s first digital multimedia museums, on 17th and 21st April 2015. The museum not only showcases the events of Gandhiji’s life but also presents Gandhian ...</p>
                                               
                                            </div>
                                        </article><!-- end /article -->

                                    </div>


                                </div><!--end .row -->
                            </div><!--end .card -->
                            <!-- END BLOG MASONRY -->
                            <!-- BEGIN PAGINATION -->
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <ul class="pagination pagination-lg">
                                        <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#">5</a></li>
                                    </ul>
                                </div><!--end .col -->
                            </div><!--end .row -->
                            <!-- END PAGINATION -->

                        </div><!--end .col -->
                    </div><!--end .row -->
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