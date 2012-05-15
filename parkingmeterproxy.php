<?php
$meterid  = $_REQUEST['meterid'];
$trouble =  $_REQUEST['trouble'];
$to = $_REQUEST['to'];
$baseURL = "Open311-webservice.aspx";
$apiKey = "Key1";
$date = new DateTime();
$catchfile = 'parkingmeterproxy.log';
$bogusString = '12-00000226';

# Parking Meter Proxy script
# Version 2.0
# Maintainer: Mick Shaw (mshaw@potomacintegration.com)
# Date: 05/01/2012
	
$requestURL =$baseURL . "MeterID=" . $meterid . "&" . "ServiceType=" . $trouble . "&" . $apiKey;

 file_put_contents($catchfile, "\n" . $date->format('Y-m-d H:i:s') . " " . $to . " " . $requestURL . "\n", FILE_APPEND | LOCK_EX);

  $ch = curl_init($requestURL);
  $timeout = 9;
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
  $returned_content = curl_exec($ch);
  $responseCode= curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  $date = new DateTime();
 
 file_put_contents($catchfile, $date->format('Y-m-d H:i:s') . " " . $returned_content . "\n", FILE_APPEND | LOCK_EX);
	
 if(((((((((($responseCode == '200' ) 
	&& ($returned_content != '""') 
	&& ($returned_content != '{"Invalid MeterID"}') 
	&& ($returned_content != '{"Access Denied"}')
	&& ($returned_content != '{"MeterID must be unique"}')
	&& ($returned_content != '{"Issue Validating Meter Location."}')
	&& ($returned_content != '{"One or more required parameters are non-existent."}')
	&& ($returned_content != '{"Cannot Process Request At This Time. ÊNo Service ID Returned."}')
	&& ($returned_content != '{"Cannot Process Request At This Time.  Open311 Request Failed."}')
	&& ($returned_content != '{"MeterID and ServiceType are both required. ÊRequest Terminated."}')
	&& ($returned_content != '{"Invalid MeterID or Meter Location Service Not Responding As Designed."}')))))))))){
 
  			
  					$jsonData = json_decode($returned_content); 
					print $obj->{'service_request_id'};
					$requestID=$jsonData->service_request_id;
					$requestID=str_replace("-","","$requestID");
						for ($i=0;$i<10;$i++) {
  						$num[$i] = substr($requestID,$i,1);
  						$myAwesomeString .= "$num[$i]";
 				}
 			
 			
echo '<serviceID>';
print "<value>" . $myAwesomeString . "</value>";
echo '</serviceID>';
} 

else {
echo '<serviceID>';
print "<value>badFetch</value>";
#print "<value>" . $bogusString . "</value>";
echo '</serviceID>';
}
?>