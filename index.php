<html>
<head>
	<title>BoogieMan | Are you being tracked by big companies?</title>
	<link rel='stylesheet' href='css/bootstrap.min.css'>
	
</head>
<body style='background-color:#eee'>
	<div class='jumbotron' style='background-color:#C293C2'>
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
		
		

//		$curl_twitter = curl_init();
//		curl_setopt($curl_twitter, CURLOPT_HTTPHEADER, array());
		
		$twitter_handler = curl_init();
		
		
		
		
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
		//$location = $demographics->{'locationDeduced'};
		
		//var_dump($contactInfo->{'fullName'});
		//echo"<h3>Name: ".$fullname."</h3>";
		
		for($i = 0; $i < (sizeof($layer1) - 1);$i++){
			$target = json_encode($layer1[$i]);
			preg_match('/twitter/', $target, $matches);
			if($matches != null){
				$twitter_buffer3 = $layer1[$i]->{"url"};
			}
		}
		
		curl_setopt($twitter_handler, CURLOPT_URL, $twitter_buffer3);
		curl_setopt($twitter_handler, CURLOPT_RETURNTRANSFER, true);
		
		$output_twitter = curl_exec($twitter_handler);
		$buffer1 = preg_split(':(tweet-text):', $output_twitter);
		$buffer2 = preg_split(':(alt):',$buffer1[1]);
		if($json->{'status'} != '200'){
				echo"<b>Unable to find target.</b>";
			}
		else{
			
		echo("<span class='badge badge-pill badge-success'>200 : Succeess Target Found.</span>");
		echo("<div class='card' style='width:400px'>
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
		//var_dump($photos[0]->{'url'});echo"<br><br><br><br>";
		
		//var_dump($social_media[0]->{'type'});echo"<br><br><br><br>";
	//	echo"<br><br><br>";
	//	echo $output;
	?>
</body>
</html>
