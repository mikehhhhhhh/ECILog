<?php
/*
	Function courtesy of John Galt on PHP.net - http://www.php.net/manual/en/function.time.php#99393
*/

class timefuncs
{
	function rel_time($from, $to = null, $disableSuffix=null)
	{
		$to = (($to === null) ? (time()) : ($to));
		$to = ((is_int($to)) ? ($to) : (strtotime($to)));
		$from = ((is_int($from)) ? ($from) : (strtotime($from)));
	  
		$units = array
		(
		 "year"   => 29030400, // seconds in a year   (12 months)
		 "month"  => 2419200,  // seconds in a month  (4 weeks)
		 "week"   => 604800,   // seconds in a week   (7 days)
		 "day"    => 86400,    // seconds in a day    (24 hours)
		 "hour"   => 3600,     // seconds in an hour  (60 minutes)
		 "minute" => 60,       // seconds in a minute (60 seconds)
		 "second" => 1         // 1 second
		);
	  
		$diff = abs($from - $to);
		if( !$disableSuffix )
			$suffix = (($from > $to) ? ("from now") : ("ago"));
	  
		foreach($units as $unit => $mult)
		 if($diff >= $mult)
		 {
		  $and = (($mult != 1) ? ("") : ("and "));
		  $output .= ", ".$and.intval($diff / $mult)." ".$unit.((intval($diff / $mult) == 1) ? ("") : ("s"));
		  $diff -= intval($diff / $mult) * $mult;
		 }
		$output .= " ".$suffix;
		$output = substr($output, strlen(", "));
	  
		return $output;
	}
}

