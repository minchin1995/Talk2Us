<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

    require_once("function.php"); // Include header to the page

	echo makePageStart("ImaSuperFan - Resources");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
		<h1><strong>Resources</strong></h1>
		<p>Talk2Us may be limited as it is based on users and depend on users to grow as a community.</p>
		<p>For more resources such as website or articles regarding work related stress:</p>
		<ul>
			<li>http://www.apa.org/helpcenter/work-stress.aspx</li>
			<li>https://www.helpguide.org/articles/stress/stress-in-the-workplace.htm</li>
			<li>https://www.stress.org/workplace-stress/</li>
			<li>https://greatist.com/happiness/manage-workplace-office-stress</li>
			<li>https://www.headsup.org.au/</li>
		</ul>
		<p>If you are dealing with other issues in life, visit:</p>
		<ul>
			<li>https://www.7cups.com/</li>
			<li>http://blahtherapy.com/</li>
			<li>https://www.iprevail.com/</li>
			<li>http://www.healthfulchat.org/</li>
			<li>https://turn2me.org/</li>
		</ul>
	</div>
</section>
 
<?php
	echo makeFooter();
  ?>