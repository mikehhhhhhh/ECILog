<?php
$start = time();
$end = 0;
// Mike Hughes - http://mikehugh.es
require_once('../lib/core.class.php');
$debug = false;
$core = new core(true);

$hosts = array('bbc.co.uk','goscomb.net','thinkbroadband.com');
$db = new db();

while( $end < $start + 60 )
{
	$results = array();
	foreach( $hosts as $host )
	{
		$ping = shell_exec('ping -q -c2 -W1 '. $host);		
		preg_match('/ved, (.*?)% packet loss,(.*\n.*= (.*?)\/(.*?)\/(.*)\/(.*) ms)?/', $ping, $matches );
		
		$results[] = array(
						'packet_loss_percent'	=>	(int)(isset($matches[1])) ? $matches[1] : 100,
						'min'					=>	(float)(isset($matches[2])) ? $matches[3] : 99999,
						'avg'					=> 	(float)(isset($matches[3])) ? $matches[4] : 99999,
						'max'					=>	(float)(isset($matches[4])) ? $matches[5] : 99999,
						'mdev'					=>	(float)(isset($matches[5])) ? $matches[6] : 99999,
					);
	}
	
	$lowest = array(
						'packet_loss_percent'	=>	99999,
						'min'					=>	99999,
						'avg'					=> 	99999,
						'max'					=>	99999,
						'mdev'					=>	99999
					);					
					
	foreach( $results as $result )
	{
		if( $result['avg'] < $lowest['avg'] )
		{
			$lowest = $result;
		}	
	}
				
									
	$stmt = $db->prepare("INSERT INTO ping(`date`, loss_percent, min, avg, max, mdev) VALUES( NOW(), :packet_loss_percent, :min, :avg, :max, :mdev )");
	$stmt->execute($lowest);
	sleep(3);
	$end = time();
}
echo 'Done' . PHP_EOL;
exit;
