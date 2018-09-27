<html>
<head>
	<title>BoogieMan | Are you being tracked by big companies?</title>
</head>
<body>
	<p>example: bill.gates@microsoft.com</p>
	<p>Note: so far this can only load prfile pictures from twitter. </p>
	<form method='POST'>
		<label>Email: </label><input type='text' name='input_email'>
		<input type='submit' name='submit', value='search'>
	</form>
	<?php
		error_reporting(E_ALL ^ E_NOTICE);
		error_reporting(E_ERROR | E_PARSE);	
		$target_email =  $_POST['input_email'];
		$handle = curl_init();
		$base = "X-FullContact-APIKey:";
		$key = "knDxYtUR8VAUcycRwJX3KBm0znwHxmSp";
		$url = "https://api.fullcontact.com/v2/person.json?email=".$target_email;
		
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
		$buffer1 = preg_split(':(ProfileAvatar-image):', $output_twitter);
		$buffer2 = preg_split(':(alt):',$buffer1[1]);
		if($buffer2[0] == NULL){
				echo"<b>Unable to pull profile picture.</b>";
			}
		echo("<img ".$buffer2[0].">");
	
	?>
</body>
</html>
