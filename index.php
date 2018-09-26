<html>
<head>
	<title>BoogieMan | Are you being tracked by big companies?</title>
</head>
<body>
	<p>example: bart@fullcontact.com</p>
	<p>Note: so far this can only load prfile pictures from twitter. </p>
	<form method='POST'>
		<label>Email: </label><input type='text' name='input_email'>
		<input type='submit' name='submit', value='search'>
	</form>
	<?php
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
		
		$twitter_buffer1 = preg_split(':(Twitter):', $output);
		$twitter_buffer2 = preg_split(':(,):', $twitter_buffer1[1]);
		$twitter_buffer3 = preg_split(':("):', $twitter_buffer2[1]);
		//$twitter_buffer4 = preg_replace("url", "", $twitter_buffer2[1]);
		
		
		curl_setopt($twitter_handler, CURLOPT_URL, $twitter_buffer3[3]/*"https://twitter.com/_siinclaiir_"*/);
		curl_setopt($twitter_handler, CURLOPT_RETURNTRANSFER, true);
		
		$output_twitter = curl_exec($twitter_handler);
		$buffer1 = preg_split(':(ProfileAvatar-image):', $output_twitter);
		$buffer2 = preg_split(':(alt):',$buffer1[1]);
		//echo $output;
		//echo ;
		echo("<img ".$buffer2[0].">");
	
	?>
</body>
</html>
