//The script takes the city as the first input and the method of prayer time calculation as the second input. And outputs the 
//prayer time for the current day.
<?php

	echo "enter the city :";
	$city_entered = trim(fgets(STDIN,128));

	$result = file_get_contents(str_replace(" ", "+", "https://maps.googleapis.com/maps/api/geocode/json?&address=".$city_entered));

	$json_res = json_decode($result, true);

	$c = count($json_res['results'][0]['address_components']);

	for ($i=0; $i<$c; $i++) { 
		if (in_array("locality", $json_res['results'][0]['address_components'][$i]['types'])) {
			$city = $json_res['results'][0]['address_components'][$i]['long_name'];
		}
	}

	for ($i=0; $i<$c; $i++) { 
		if (in_array("country", $json_res['results'][0]['address_components'][$i]['types'])) {
			$country = $json_res['results'][0]['address_components'][$i]['long_name'];
		}
	}

	//$city
	//$country
	$latitude = $json_res['results'][0]['geometry']['location']['lat'];
	$longitude = $json_res['results'][0]['geometry']['location']['lng'];


	// testing 1 ****
	//echo "first request: ";
	//echo "city: ".$city;
	//echo "country: ".$country;
	//echo "lat: ".$latitude;
	//echo "lng: ".$longitude;


	//   *** "http://api.aladhan.com/cityInfo?city=Dubai&country=AE" find the timeZone from this uri by passing city and country
	$result_TZ = file_get_contents(str_replace(" ", "+", "http://api.aladhan.com/cityInfo?city=".$city."&country=".$country));
	$json_result_TZ = json_decode($result_TZ,true);
	$timeZone = $json_result_TZ['data']['timezone'];

	// testing 2 ****
	//echo "second request: ";
	//echo "timeZone: ".$timeZone;

	// *** "http://api.aladhan.com/currentTimestamp?zone=Europe/London" find the timeStamp from this uri.

	$result_TS = file_get_contents("http://api.aladhan.com/currentTimestamp?zone=".$timeZone);
	$json_result_TS = json_decode($result_TS,true);
	$timeStamp = $json_result_TS['data'];

	// testing 3 ****
	//echo "third request: ";
	//echo "timeStamp: ".$timeStamp;


	// select the method of timing

	echo "
0 - Shia Ithna-Ashari
1 - University of Islamic Sciences, Karachi
2 - Islamic Society of North America (ISNA)
3 - Muslim World League (MWL)
4 - Umm al-Qura, Makkah
5 - Egyptian General Authority of Survey
7 - Institute of Geophysics, University of Tehran
";
	echo "select a method of calculation: ";
	$method = trim(fgets(STDIN,4));

	$final_result = file_get_contents(str_replace(" ", "+", "http://api.aladhan.com/timings/".$timeStamp."?latitude=".$latitude."&longitude=".$longitude."&timezonestring=".$timeZone."&method=".$method));

	$json_final_result = json_decode($final_result, true);

	print_r($json_final_result['data']['timings']); // this will print the prayer times and also the mid night time.

?>
