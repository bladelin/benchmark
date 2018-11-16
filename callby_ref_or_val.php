<?php
$originalString = generateRandomString(100); // 1000 pseudo-random digits
$iteration_cnt = 1000000;

test('val', $originalString, $iteration_cnt);
test('ref', $originalString, $iteration_cnt);


function test($case, $originalString, $cnt=10000) 
{
	echo "\n call by ".$case ." case test:\n";
	$output = '';
	/* set start time */
	$mtime = microtime();
	$mtime = explode(" ", $mtime);
	$mtime = $mtime[1] + $mtime[0];
	$tstart = $mtime;
	set_time_limit(0);

	for ($i = 0; $i < 10; $i++ ) {
		for ($j = 0; $j < $cnt; $j++) {
			$string = $originalString;
			if ($case == 'ref') {
				replaceByRef($string);
			} else {
				$string = replaceBYVal($string);
			}
		}
	}

	/* report how long it took */
	$mtime = microtime();
	$mtime = explode(" ", $mtime);
	$mtime = $mtime[1] + $mtime[0];
	$tend = $mtime;
	$totalTime = ($tend - $tstart);
	$totalTime = sprintf("%2.4f s", $totalTime);
	$output .= "\n" . 'Total Time' .
		': ' . $totalTime;
	$output .= "\n" . $string;
	echo $output;
	echo "\nmemory using:".convert(memory_get_usage(true)); 
}

function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

function generateRandomString($length = 10) {
    $characters = '01';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function replaceByRef(&$string) {
    $string = str_replace('1', 'x',$string);
}

function replaceByVal($string) {
    return str_replace('1', 'x',$string);
}
