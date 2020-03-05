<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

    require_once("function.php"); // Include header to the page

	echo makePageStart("ImaSuperFan - Homepage");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>

  <div class="slider">
    <div class="img-responsive">
      <ul class="bxslider">
        <li><img src="img/slide1.jpg" alt="Talk2us Logo" /></li>
        <li><img src="img/slide2.jpg" alt="Work Stress" /></li>
        <li><img src="img/slide3.jpg" alt="Work" /></li>
      </ul>
    </div>
  </div>

  <div class="jumbotron">
    <h1>Talk2Us</h1>
    <p>Stressed due to work related issues? Talk2Us is here to help you through.</p>
  </div>

  <div class="container">
    <div class="col-md-6">
      <img src="img/work.gif" alt="Man working" class="img-responsive spaceBottom centerImage" />
    </div>
	
    <div class="col-md-6">
      <p>
		 Work related stress leads to problems to their work performance as the stress and the pressure will cause workers to lose the ability to concentrate and ultimately cause a job burnout. Work stress can problems emotionally such as anger issues and anxiety to physically such as cholesterol level increasing, blood pressure being unstable, diabetes and many other to an indvidual.
	  </p>
	  <p>
		Talk2Us provide services such as blogs, forums and group supports for people dealing with work stress. Talk2Us allows users to have a place to talk about their problems and other users to listen to them. Users can be assured about their privacy as only an email will be required to register o the website and it will not be displayed to the public.
	  </p>
    </div>
  </div>
  
  <section class="box">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="0.4s">
            <div class="services">
              <div class="icons">
                <i class="fa fa-pencil-square-o fa-3x"></i>
              </div>
              <h4>Forum</h4>
              <p>
                Create topics where you can share your problems.
              </p>
            </div>
          </div>
          <hr>
        </div>

        <div class="col-md-4">
          <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="0.8s">
            <div class="services">
              <div class="icons">
                <i class="fa fa-comments fa-3x"></i>
              </div>
              <h4>Chat</h4>
              <p>
                Chat with other users about your problems.
              </p>
            </div>
          </div>
          <hr>
        </div>

        <div class="col-md-4">
          <div class="wow bounceIn" data-wow-offset="0" data-wow-delay="1.2s">
            <div class="services">
              <div class="icons">
                <i class="fa fa-book fa-3x"></i>
              </div>
              <h4>Blog</h4>
              <p>
                Read and share about experiences dealing with work stress.
              </p>
            </div>
          </div>
          <hr>
        </div>

      </div>
    </div>
  </section>
<?php
	echo makeFooter();
  ?>

