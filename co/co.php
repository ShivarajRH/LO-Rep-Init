<?php 
        $fname="";
        $lname='';
        $gid = '';
        
	$metatitle='LyfeOn - About Company and People';
	$metadescription='LyfeOn - About Company, Investor Relations, Incorporation, People Management and Internal Management';
	$metaabstract='LyfeOn - About Company and Internal Management';
	$metasubject='LyfeOn - About Company and Internal Management';
	$metapagename='LyfeOn - About Company and Internal Management';
	$metasubtitle='LyfeOn - Internal Management';
	$metacopyright='LyfeOn';
        
        $robots_index='index';
        $robots_follow='follow';
?>

<?php include_once '../head.php'; ?>

<!-- Google+ Signin -->
<script type="text/javascript">
  (function() {
   var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
   po.src = 'https://apis.google.com/js/client:plusone.js';
   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
 })();
</script>
	
<body>
	<?php include_once '../header.php'; ?>
	</br>
	<div class="center">
		</br>

		<div id="wrapper" style="max-width:1400px"> <!-- http://cssdeck.com/labs/css-only-pinterest-style-columns-layout -->
			<ul id="columns">
				<li class="pin single_note_card">
					<a href="/co/services/company">
						<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fabout_rep_427x640.png" />
						<h1>About Company</h1>
					</a>
				</li>
				<li class="pin single_note_card">
					<a href="/co/investors/investors">
						<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Finvestors_rep_427x640.png" />
						<h1>Investors</h1>
					</a>
				</li>
				<li class="pin single_note_card">
					<a href="/co/people/people">
						<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fteam_rep_427x640.png" />
						<h1>People</h1>
					</a>
				</li>
				<li class="pin single_note_card">
					<a href="/co/analytics/analytics">
						<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fanalytics_rep_427x640.png" />
						<h1>Analytics</h1>
					</a>
				</li>
				<li class="pin single_note_card" style="text-align:center;width:100%;"><!-- Google+ Signin --> <!-- Insert Client ID-->
						</br>
						<?php include_once '../google_plus_signin_button.php'; ?>
						</br></br>
				</li>
			</ul>
		</div>
		<div style="max-width: 45em;margin: 0 auto;">
			<p><a href="http://lyfeon.com">LyfeOn</a> uses the <strong>lyfeon.co</strong> domain as part of a service to protect users from harmful activity, to provide company information and for facilitating internal management.</p>
			<a class="back" href="http://lyfeon.com"><button class="button" style="border-radius: .3em;padding-bottom: 5%;margin-right:5%;">Back to LyfeOn</button></a>
		</div>
	</div>
	<?php include_once '../footer_reg.php'; ?>
</body>