<?php 

  // The program rotates the given string clockwise or anti-clockwise
  // first line conrains the legnth of the string and the number of queries can be performed. ex: 5 3 (legnth is 5 and no of queries is 3)
  // next line contains the word. ex: "hello"
  // next line contains the word to be rotated. ex: "llohe"
  // following lines contain each query. ex: R 2 (this will rotate the string 'llohe' twise towards the right side and print "YES" if it matches the first string.)
  
  
	$nq = trim(fgets(STDIN,1024)); 
	
	preg_match_all('!\d+!', $nq, $matches);
	$n = $matches[0][0];
	$q = $matches[0][1];

	$n = (int)$n;
	$q = (int)$q;

	$s1 = trim(fgets(STDIN,128));
	//var_dump($s1);

	$s2 = trim(fgets(STDIN,128));
	//var_dump($s2);

	for ($i=0; $i<$q; $i++) { 
		$query = trim(fgets(STDIN,1024));
		$LR = substr($query, 0, 1);

		$lines = trim(substr($query, 1));
		$times = (int)$lines;

		if ($LR == 'R') {
			$rotated = rotate_right($s2, $times);
			if ($rotated == $s1) {
				print ("YES \n");
			}else{
				print ("NO \n");
			}
		}elseif($LR == 'L'){
			$rotated = rotate_left($s2, $times);
			if ($rotated == $s1) {
				print ("YES \n");
			}else{
				print ("NO \n"); 
			}
		}
	}

	function rotate_right($origin, $times){
		$i = 0;
		$rotated = $origin;
		while ($i < $times) {
			$rotated = substr($rotated, -1). substr($rotated, 0, -1);
			$i = $i + 1;
		}
		return $rotated;
	}

	function rotate_left($origin, $times){
		$i = 0;
		$rotated = $origin;
		while ($i < $times) {
			$rotated = substr($rotated, 1). substr($rotated, 0, 1);
			$i = $i + 1;
		}
		return $rotated;
	}

?>
