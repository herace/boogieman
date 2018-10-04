<html>
<head>
	<title>BoogieMan | Are you being tracked by big companies?</title>
	
	<script src='js/jquery-3.3.1.min.js'></script>
	<script src='js/bootstrap.bundle.min.js'></script>
	
	<link rel='stylesheet' href='css/bootstrap.min.css'>
	<link rel='stylesheet' href='css.css'>
	
	
</head>
<body>
	<div class='jumbotron' style='background:rgba(0, 0, 0, 0.5)'>
		<h2>BoogieMan</h2>
	</div>
	<div>
	<p>example: bill.gates@microsoft.com</p>
	<form method='POST'>
		<label>Email: </label><input type='text' name='input_email'>
		<input type='submit' name='submit', value='search'>
	</form>
	</div>
	<?php
		error_reporting(E_ALL ^ E_NOTICE);
		error_reporting(E_ERROR | E_PARSE);	
		$target_email =  $_POST['input_email'];
		$handle = curl_init();
		$base = "X-FullContact-APIKey:";
		$key = "knDxYtUR8VAUcycRwJX3KBm0znwHxmSp";
		$url = "https://api.fullcontact.com/v2/person.json?email=".$target_email;
		
		//i know this looks barbaric, but i just did this for the sake of complete this within an hour
		
		//sets http header, urls and all that jazz
		curl_setopt($handle, CURLOPT_HTTPHEADER, array($base.$key));
		curl_setopt($handle, CURLOPT_URL, $url);
		//set the result output to be a string.
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		
		$output = curl_exec($handle);
		curl_close($handle);
		$json = json_decode($output);
		
		$layer1 =  $json->{'socialProfiles'};
		$social_media =  $json->{'socialProfiles'};
		$contactInfo = $json->{'contactInfo'};
		$age = $json->{'age'};
		$photos = $json->{'photos'};
		$demographics = $json->{'demographics'};
		
		//TWITTER
		/*
		 * This is has a fixed url, couldn't test it since i ran out of reuqests, WIll replace url when request is refilled....
		 * */
		$twitter_handler = curl_init();
		curl_setopt($twitter_handler, CURLOPT_URL, "https://twitter.com/BillGates" /*$twitter_buffer3*/);
		curl_setopt($twitter_handler, CURLOPT_RETURNTRANSFER, true);
		
		$output_twitter =curl_exec($twitter_handler);
		$dom_twitter = new DOMDocument;
		$dom_twitter->loadHTML($output_twitter);
		$xpath_twitter = new DOMXPath($dom_twitter);
		$query_twitter = $xpath_twitter->query("//*[@class='js-tweet-text-container']");
		
		echo "<div class='accordion'>";
		
		echo"
				<div class='card bg-dark'>
					<div class='card-header'>
						<a class='card-link' data-toggle='collapse' href='#collapseOne'>View Tweets</a>
					</div>
			";
			
		echo"<div id='collapseOne'><ul>";
		for($i = 0; $i < 10; $i++){
			echo $result_twitter = "<li style='color:#eee'>".$query_twitter->item($i)->nodeValue."</li>";
		}
		echo"</ul></div></div>";
		
		//Instagram
		/*
		 * TODO: Need to grab site  / filter. Doesnt work yet.
		 * */
		$instagram_handler = curl_init();
		curl_setopt($instagram_handler, CURLOPT_URL, "https://www.instagram.com/thisisbillgates");
		curl_setopt($instagram_handler, CURLOPT_RETURNTRANSFER, true);
		
		
		$output_instagram = curl_exec($instagram_handler);
		$dom_instagram = new DOMDocument;
		$dom_instagram -> loadHTML($output_instagram);
		$xpath_instagram = new DOMXPath($dom_instagram);
		$query_instagram = $xpath_instagram->query("//*[@class='FFVAD']");
		
		//echo $result_instagram = "<p>".$query_instagram->item(0)->nodeValue."</p>";
	
		echo($output_instagram);
		var_dump($query_instagram->item(0)->nodeValue);
		echo"<div class='card bg-dark'>
				<div class='card-header'>
					<a class='card-link' data-toggle='collapse' href='#collapseTwo'>View Instagram Posts</a>
				</div>
			</div>";
		
		echo"</div>";
		
		echo("<br><br><br><br><br>");
		
		if($json->{'status'} != '200'){
				
				echo"<b>Unable to find target.</b>";
			}
		else{
			
		echo("<span class='badge badge-pill badge-success'>Status: 200 Here's Johny!.</span>");
		echo("<div class='card bg-dark' style='width:400px'>
			<img class='card-img-top thumbnail' src='".($photos[0]->{'url'})."' alt='Card image'>
			<div class='card-body'>
				<h4 class='card-title'>".$contactInfo->{'fullName'}."</h4>
				<p class='card-text'>
					<b>Gender</b>: ".$demographics->{'gender'}."<br>
					<b>Age</b>: ".$demographics->{'age'}."<br>
					<b>Location</b>: ".$demographics->{'locationGeneral'}."
				</p>
				<a hred='#' class='btn btn-primary'>See Profile</a>
			</div>
		</div>");
	}
		for( $i = 0; $i < sizeof($social_media); $i++){
			echo"<a href='".$social_media[$i]->{'url'}."'>".$social_media[$i]->{'type'}."</a><br>";
			
			}

	?>
</body>
</html>
