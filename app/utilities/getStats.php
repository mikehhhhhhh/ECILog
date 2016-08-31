<?php
// Mike Hughes - http://mikehugh.es
require_once('../lib/core.class.php');
$debug = false;
$core = new core(true);

$modem = new ECI_BFocusV2FUb_R;
$modem->Login();
$modem->ReadAll();
$modem->closeModem();

$modem->ProcessAll();

if( $debug == true )
{
	foreach( $modem->data as $key => $data )
	{
		if( count($data) < 12 )
		{
			echo $key .': ';
			var_dump($data);
		}
	}

	var_dump( array_keys($modem->data));
}

$db = new db;

$sql = "INSERT INTO entries (`date`, line_status, profile, down_sync, down_attainable, down_power, up_sync, up_attainable, up_power, ".
			"down_snr_0, down_snr_1, down_snr_2, down_snr_3, down_snr_4, down_snr_5, ".
			"up_snr_0, up_snr_1, up_snr_2, up_snr_3, up_snr_4, up_snr_5, ".
			"down_latn_0, down_latn_1, down_latn_2, down_latn_3, down_latn_4, down_latn_5, ".
			"up_latn_0, up_latn_1, up_latn_2, up_latn_3, up_latn_4, up_latn_5, ".
			"down_satn_0, down_satn_1, down_satn_2, down_satn_3, down_satn_4, down_satn_5, ".
			"up_satn_0, up_satn_1, up_satn_2, up_satn_3, up_satn_4, up_satn_5) ".
		"VALUES( NOW(), :line_status, :profile, :down_sync, :down_attainable, :down_power, :up_sync, :up_attainable, :up_power, :".
			"down_snr_0, :down_snr_1, :down_snr_2, :down_snr_3, :down_snr_4, :down_snr_5, :".
			"up_snr_0, :up_snr_1, :up_snr_2, :up_snr_3, :up_snr_4, :up_snr_5, :".
			"down_latn_0, :down_latn_1, :down_latn_2, :down_latn_3, :down_latn_4, :down_latn_5, :".
			"up_latn_0, :up_latn_1, :up_latn_2, :up_latn_3, :up_latn_4, :up_latn_5, :".
			"down_satn_0, :down_satn_1, :down_satn_2, :down_satn_3, :down_satn_4, :down_satn_5, :".
			"up_satn_0, :up_satn_1, :up_satn_2, :up_satn_3, :up_satn_4, :up_satn_5) ";

$stmt = $db->prepare($sql);

$stmt->bindParam('line_status', $modem->data['lineStatus']);
$stmt->bindParam('profile', $modem->data['profile']);
$stmt->bindParam('down_sync', $modem->data['lineDataDown']['sync']);
$stmt->bindParam('down_attainable', $modem->data['lineDataDown']['attainable']);
$stmt->bindParam('down_power', $modem->data['lineDataDown']['power']);
$stmt->bindParam('up_sync', $modem->data['lineDataUp']['sync']);
$stmt->bindParam('up_attainable', $modem->data['lineDataUp']['attainable']);
$stmt->bindParam('up_power', $modem->data['lineDataUp']['power']);

$keys = array('snr','latn','satn');
for( $i=0;$i<=5; $i++ )
{
	foreach( $keys as $key )
	{
		$stmt->bindParam('up_'. $key .'_'. $i, $modem->data['bandDataUp'][$key][$i] );
		$stmt->bindParam('down_'. $key .'_'. $i, $modem->data['bandDataDown'][$key][$i] );
	}
}

$stmt->execute();
$entry_id = $db->lastInsertId();

multiInsert( $db, $modem->data['downSNR'], 'down_snr', $entry_id, 'carrier', 'snr' );
multiInsert( $db, $modem->data['upBit'], 'up_bit', $entry_id, 'carrier', 'bit' );
multiInsert( $db, $modem->data['downBit'], 'down_bit', $entry_id, 'carrier', 'bit' );
multiInsert( $db, $modem->data['upGain'], 'up_gain', $entry_id, 'carrier', 'gain' );
multiInsert( $db, $modem->data['downGain'], 'down_gain', $entry_id, 'carrier', 'gain' );
multiInsert( $db, $modem->data['hlog'], 'hlog', $entry_id, 'carrier', 'hlog' );




function multiInsert( &$db, $array, $table, $entry_id, $xAxis, $yAxis )
{
	$binds = array();
	$sql = 'INSERT INTO '. $table .' ( entries_id, '. $xAxis .', '.$yAxis .') '.
			'VALUES ';
	foreach( $array as $row )
	{
		$sql .= '('. $entry_id;
		foreach( $row as $val )
		{
			$sql .= ',?';
			$binds[] = $val;
		}
		$sql .= '),';
	} 
	$sql = trim($sql, ',');

	$stmt = $db->prepare( $sql );
	$stmt->execute($binds);
	return $sql;

}

echo 'Done.' . PHP_EOL;







