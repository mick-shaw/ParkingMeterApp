<?php

$user  = 'username-1';
$password =  'password';
$api_id =  'Key1';
$to = $_REQUEST['to'];
$text = $_REQUEST['text'];
$baseURL = "https://api.clickatell.com/http/sendmsg?";
$balURL = "https://api.clickatell.com/http/getbalance?";
$date = new DateTime();
$catchfile = 'sms_send.log';

# SMS Send script
# Version 2.0
# Maintainer: Mick Shaw (mshaw@potomacintegration.com)
# Date: 05/01/2012
#
# Version 2 Release Notes: 
#              The SMS script now checks SMS message credits. 
#              This is done prior to executing a message delivery to the respective API account.
#              If the API account has less than 5 credits, it's not used.
#			   The next API account is checked.
#			   The check will cycle through all five API accounts.	
#			   The first API account with more then 5 credits will be used.


// Typically, an + is used to indicate that you must dial the international access code.
// For example, somebody calling you from the UK would dial 00-1-areacode-number. 
// From South Africa they would dial 09-1-areacode-number. You would publish your number as +1-areacode-number.
// Unfortunately, the clickatell API rejects requests if the number of the SMS recipient is prefixed with an + 
// Here we remove the + from the variable responsible for storing the phone number of the SMS recepient.

$to = str_replace("+","","$to");

// The clickatell API requires that all spaces in the body of the text message be replaced with the + character.
// Here we replace all spaces with + in the variable responsible for storing the text message body.

$text = str_replace(" ","+","$text");


// We intialize the balance inquiry URL variable with the first API credintials
// We intialize the sms_send URL variable with the same API credintials

$balancerequestURL =$balURL . "user=" . $user . "&" . "password=" . $password . "&" . "api_id=" . $api_id;
$sms_sendURL =$baseURL . "user=" . $user . "&" . "password=" . $password . "&" . "api_id=" . $api_id . "&" . "to=" . $to . "&" . "text=" . $text;

// Execute a cURL against the API's to query the balance
   	
  $ch = curl_init($balancerequestURL);
  $timeout = 9;
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
  $balance_response = curl_exec($ch);
  $balanceresponseCode= curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

$balance_response = str_replace("Credit: ","","$balance_response");

	
	if($balance_response <= '5' or $balanceresponseCode != '200'){
	    
	    $date = new DateTime();
		file_put_contents($catchfile, "\n" . $date->format('Y-m-d H:i:s') . " " . "API ID " . $api_id . " balance is " .  $balance_response . " Next API ID we'll try is 3373935" . "\n", FILE_APPEND | LOCK_EX);
	
		$user = 'username-2';
		$password =  'password';
		$api_id =  'Key2';
		
		$balancerequestURL =$balURL . "user=" . $user . "&" . "password=" . $password . "&" . "api_id=" . $api_id;
		$sms_sendURL =$baseURL . "user=" . $user . "&" . "password=" . $password . "&" . "api_id=" . $api_id . "&" . "to=" . $to . "&" . "text=" . $text;
		
		$ch = curl_init($balancerequestURL);
		$timeout = 9;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
		$balance_response = curl_exec($ch);
		$balanceresponseCode= curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		$date = new DateTime();
		$balance_response = str_replace("Credit: ","","$balance_response");
		
		if($balance_response <= '5' or $balanceresponseCode != '200'){
			
			$date = new DateTime();
			file_put_contents($catchfile, $date->format('Y-m-d H:i:s') . " " . "API ID " . $api_id . " balance is " .  $balance_response . " Next API ID we'll try is 3373937" . "\n", FILE_APPEND | LOCK_EX);
		
			$user = 'username3';
			$password =  'password';
			$api_id =  'Key3';
			
			$balancerequestURL =$balURL . "user=" . $user . "&" . "password=" . $password . "&" . "api_id=" . $api_id;
			$sms_sendURL =$baseURL . "user=" . $user . "&" . "password=" . $password . "&" . "api_id=" . $api_id . "&" . "to=" . $to . "&" . "text=" . $text;
			
			$ch = curl_init($balancerequestURL);
			$timeout = 9;
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
			$balance_response = curl_exec($ch);
			$balanceresponseCode= curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			$balance_response = str_replace("Credit: ","","$balance_response");
			
			if($balance_response <= '5' or $balanceresponseCode != '200'){
				
				$date = new DateTime();
				file_put_contents($catchfile, $date->format('Y-m-d H:i:s') . " " . "API ID " . $api_id . " balance is " .  $balance_response . " Next API ID we'll try is 3373938" . "\n", FILE_APPEND | LOCK_EX);
			
				$user = 'username-4';
				$password =  'password';
				$api_id =  'Key4';
				
				$balancerequestURL =$balURL . "user=" . $user . "&" . "password=" . $password . "&" . "api_id=" . $api_id;
				$sms_sendURL =$baseURL . "user=" . $user . "&" . "password=" . $password . "&" . "api_id=" . $api_id . "&" . "to=" . $to . "&" . "text=" . $text;
				
				$ch = curl_init($balancerequestURL);
				$timeout = 9;
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
				$balance_response = curl_exec($ch);
				$balanceresponseCode= curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				
				$balance_response = str_replace("Credit: ","","$balance_response");
			
				if($balance_response <= '5' or $balanceresponseCode != '200'){
					
					$date = new DateTime();
					file_put_contents($catchfile, $date->format('Y-m-d H:i:s') . " " . "API ID " . $api_id . " balance is " .  $balance_response . " Next API ID we'll try is 3373939" . "\n", FILE_APPEND | LOCK_EX);
				
					$user = 'username-5';
					$password =  'password';
					$api_id =  'Key5';
					
					$balancerequestURL =$balURL . "user=" . $user . "&" . "password=" . $password . "&" . "api_id=" . $api_id;
					$sms_sendURL =$baseURL . "user=" . $user . "&" . "password=" . $password . "&" . "api_id=" . $api_id . "&" . "to=" . $to . "&" . "text=" . $text;
					
					$ch = curl_init($balancerequestURL);
					$timeout = 9;
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
					curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
					$balance_response = curl_exec($ch);
					$balanceresponseCode= curl_getinfo($ch, CURLINFO_HTTP_CODE);
					curl_close($ch);
					
					$balance_response = str_replace("Credit: ","","$balance_response");
				
				}	
			}
		}
	}
		
	
 $sms_sendURL =$baseURL . "user=" . $user . "&" . "password=" . $password . "&" . "api_id=" . $api_id . "&" . "to=" . $to . "&" . "text=" . $text;


file_put_contents($catchfile, "\n" . $date->format('Y-m-d H:i:s') . " " . $sms_sendURL . "\n", FILE_APPEND | LOCK_EX);

  $ch = curl_init($sms_sendURL);
  $timeout = 9;
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
  $sms_response = curl_exec($ch);
  $responseCode= curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
 
 $date = new DateTime();
 file_put_contents($catchfile, $date->format('Y-m-d H:i:s') . " " . $sms_response . "\n", FILE_APPEND | LOCK_EX);
 
?>