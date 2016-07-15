// this program reads the num(n) of movies to be sorted in the first line of input.
// next line reads the name of the 1st movie and the third line reads the year movie was released, upto n movies.
// Movies will be sorted according to the released year. If more than one movie has the same year, then the movie will be sorted in the increasing order of runtime of the movie.
// output will contain the IMDb id, Runtime & the Title of the movie.

<?php
	//*num of movies
	echo "Enter the num of movies: ";
	$n = trim(fgets(STDIN,4));
	$outer_array = array();


	function swap($in1,$in2)
	{
		//echo $in1.$in2;
		global $outer_array;
		$temp = @$outer_array[$in2];
		@$outer_array[$in2] = $outer_array[$in1];
		$outer_array[$in1] = $temp;
	}


	for ($i=0; $i < $n; $i++) { 
	
		echo "Entet the movie name and the year\n";

		// ***read the title in cmd from the user
		$movie_name = trim(fgets(STDIN,512));
		// ***read the year of the movie
		$year = trim(fgets(STDIN,8));
		
		// ***send a get request to http://omdbapi.com
		$link = str_replace(" ", "+", "http://www.omdbapi.com/?t=".$movie_name."&y=".$year);
		$got = file_get_contents($link);

		// ***decoding the json file
		$json_obj = json_decode($got,true);
		$outer_array[$i] = $json_obj;
		

		// ***extracting the runtime and reassigning
		$rtime = $outer_array[$i]['Runtime'];
		preg_match_all('!\d+!', $rtime, $minit);
		$minit1 = implode('', $minit[0]);
		$minit2 = (int)$minit1;

		$outer_array[$i]['Runtime'] = $minit2;

		// ***printing the data
		/*
		echo "Tittle : ".$json_obj["Title"]."\n";
		echo "IMDb id : ".$json_obj["imdbID"]."\n";
		echo "Run time : ".$json_obj["Runtime"]."\n";
		echo "lang : ".$json_obj["Language"]."\n";
		*/

	}




	// ***sorting according to year
	for ($yr1=0; $yr1 < $n; $yr1++) { 
		for ($yr=0; $yr < $n-$yr1; $yr++) { 
			if (@$outer_array[$yr]['Year'] > @$outer_array[$yr+1]['Year']) {
				//echo $yr.($yr+1)."/n";
				swap($yr,$yr+1);
			}
		}
	}

	// ***sorting according to runtime
	$lv1 = 0;
	while (@$outer_array[$lv1+1] != null) {
		//echo "im here \n";
		$lv1 = $lv1 + 1;
		while (@$outer_array[$lv1]['Year'] == @$outer_array[$lv1+1]['Year']) {
			//echo "im here too\n";
			if ($outer_array[$lv1]['Runtime'] > $outer_array[$lv1+1]['Runtime']) {
				//echo "hahaha final \n";
				swap($lv1,$lv1+1);
				$lv1 = $lv1 + 1;
			}
			else{
				break;
			}
		}

		//$lv1 = $lv1 + 1;
	}

	//echo $outer_array[1]['Title'];
	//print_r($outer_array);

	// ***printing the result
	echo "\nIMDb id   | Runtime | Title\n";
	echo "-----------------------------\n";
	foreach ($outer_array as $new1) {
		if ($new1 != null) {
			print $new1['imdbID'];
			echo " | ";
			print $new1['Runtime']. ' min';
			echo " | ";
			echo $new1['Title'];
			echo "\n";
		}
	}


?>
