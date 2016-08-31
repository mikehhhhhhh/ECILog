<?php

class Module_ModemStats extends Module
{
	private $db;
	
	public function __construct()
	{
		$this->db = new db();
	}
	
	public function view( $uri )
	{
		core::$template->title = 'Home';
		
		$stmt = $this->db->prepare("SELECT * FROM entries ORDER BY id DESC LIMIT 1");
		$stmt->execute();
		$lineData = $stmt->fetchAll();
		$lineData = $lineData[0];

		//Get Down SNR Data
		$stmt = $this->db->prepare("SELECT carrier, snr FROM down_snr WHERE entries_id=:entries_id");
		$stmt->bindParam('entries_id',$lineData['id']);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach( $results as $result )
		{
			$snr[ $result['carrier'] ] = array('carrier'=>$result['carrier'], 'snr'=> $result['snr'] );
		}
		for( $i=0; $i<=4086; $i=$i+20)
		{
			if( !isset( $snr[$i] ) )
				$snr[$i] = array( 'carrier' => $i, 'snr' => 'null' );
		}
		ksort($snr);
		foreach( $snr as $result )
		{
			$ddata .= '['. $result['carrier'] .','. $result['snr'] .'],';
		}
		$ddata = trim($ddata,',');


		//Get Down HLOG Data
		$stmt = $this->db->prepare("SELECT carrier, hlog FROM hlog WHERE entries_id=:entries_id");
		$stmt->bindParam('entries_id',$lineData['id']);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach( $results as $result )
		{
			$hlog[ $result['carrier'] ] = array('carrier'=>$result['carrier'], 'hlog'=> $result['hlog'] );
		}
		/*for( $i=0; $i<=4086; $i=$i+20)
		{
			if( !isset( $hlog[$i] ) )
				$hlog[$i] = array( 'carrier' => $i, 'hlog' => 'null' );
		}
		ksort($hlog);*/
		foreach( $hlog as $result )
		{
			if( $result['hlog'] == '-96.3' ) $h = 'null';
			else $h = $result['hlog'];
			$hdata .= '['. $result['carrier'] .','. $h .'],';
		}
		$hdata = trim($hdata,',');

		//Get Bit Loading Data
		$stmt = $this->db->prepare("SELECT carrier, `bit` FROM down_bit WHERE entries_id=:entries_id");
		$stmt->bindParam('entries_id',$lineData['id']);
		$stmt->execute();
		$bit_down = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$stmt = $this->db->prepare("SELECT carrier, `bit` FROM up_bit WHERE entries_id=:entries_id");
		$stmt->bindParam('entries_id',$lineData['id']);
		$stmt->execute();
		$bit_up = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach( $bit_down as $row )
		{
			$bit_down_new[$row['carrier']] = $row;
		}

		foreach( $bit_up as $row )
		{
			$bit_up_new[$row['carrier']] = $row;
		}

		foreach( $bit_up as $row )
		{
			if( !isset( $bit_down_new[$row['carrier']] ) )
				$bit_down_new[ $row['carrier'] ] = array( 'carrier' => $row['carrier'], 'bit'=>'null');
		}

		foreach( $bit_down as $row )
		{
			if( !isset( $bit_up_new[$row['carrier']] ) )
				$bit_up_new[ $row['carrier'] ] = array( 'carrier' => $row['carrier'], 'bit'=>'null');
		}

		ksort($bit_down_new);
		foreach( $bit_down_new as $result )
		{
			$down_bit .= '['. $result['carrier'] .','. $result['bit'] .'],';
		}
		$down_bit = trim($down_bit,',');

		ksort($bit_up_new);
		foreach( $bit_up_new as $result )
		{
			$up_bit .= '['. $result['carrier'] .','. $result['bit'] .'],';
		}
		$up_bit = trim($up_bit,',');


		//Get Gain Loading Data
		$stmt = $this->db->prepare("SELECT carrier, `gain` FROM down_gain WHERE entries_id=:entries_id");
		$stmt->bindParam('entries_id',$lineData['id']);
		$stmt->execute();
		$gain_down = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$stmt = $this->db->prepare("SELECT carrier, `gain` FROM up_gain WHERE entries_id=:entries_id");
		$stmt->bindParam('entries_id',$lineData['id']);
		$stmt->execute();
		$gain_up = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach( $gain_down as $row )
		{
			$gain_down_new[$row['carrier']] = $row;
		}

		foreach( $gain_up as $row )
		{
			$gain_up_new[$row['carrier']] = $row;
		}

		foreach( $gain_up as $row )
		{
			if( !isset( $gain_down_new[$row['carrier']] ) )
				$gain_down_new[ $row['carrier'] ] = array( 'carrier' => $row['carrier'], 'gain'=>'null');
		}

		foreach( $gain_down as $row )
		{
			if( !isset( $gain_up_new[$row['carrier']] ) )
				$gain_up_new[ $row['carrier'] ] = array( 'carrier' => $row['carrier'], 'gain'=>'null');
		}

		ksort($gain_down_new);
		foreach( $gain_down_new as $result )
		{
			$down_gain .= '['. $result['carrier'] .','. $result['gain'] .'],';
		}
		$down_gain = trim($down_gain,',');

		ksort($gain_up_new);
		foreach( $gain_up_new as $result )
		{
			$up_gain .= '['. $result['carrier'] .','. $result['gain'] .'],';
		}
		$up_gain = trim($up_gain,',');
		

		// Get SYNC Graph data
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


		$stmt = $this->db->prepare("select DATE(`date`) AS date, AVG(down_attainable) AS down_attainable, AVG(down_sync) AS down_sync, ".
									"AVG(up_attainable) AS up_attainable, AVG(up_sync) AS up_sync ".
									"FROM entries ".
										"WHERE `date` >= NOW() - INTERVAL 1 MONTH ".
										"GROUP BY DATE(`date`)"
								);
		$stmt->execute();
		$sync_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$sync_types = array('down_attainable', 'down_sync', 'up_attainable','up_sync');
		foreach( $sync_data AS $sync_row )
		{
			$date = strtotime( $sync_row['date'] );
			$day = date('j', $date );
			$month = date('n',$date ) - 1;
			$year = date('Y', $date);
			foreach( $sync_types as $type )
			{
				$sync[$type] .= '[Date.UTC('. $year.','. $month .','. $day .'),'. $sync_row[$type] .'],';
			}
		}
		
		foreach( $sync_types as $type )
		{
			$sync[$type] = trim($sync[$type], ',');
		}
		
		// Get last 5 minutes ping data
		$stmt = $this->db->prepare("SELECT `date`, avg FROM ping WHERE `date` >= NOW() - INTERVAL 5 MINUTE ORDER BY `date` ASC");
		$stmt->execute();
		$ping_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach( $ping_data as $pd )
		{
			$date = strtotime( $pd['date'] ) * 1000;
			$ping .= '['. $date .','. $pd['avg'] .'],';
		}
		$ping = trim($ping, ',');
		
		core::$template->ping = $ping;		
		core::$template->sync = $sync;
		core::$template->down_bit = $down_bit;
		core::$template->up_bit = $up_bit;
		core::$template->down_gain = $down_gain;
		core::$template->up_gain = $up_gain;
		core::$template->downSnrX = $ddata;
		core::$template->hlog = $hdata;
		core::$template->lineData = $lineData;
		return core::$template->render('modemstats');

	}
	
	public function ajaxPing()
	{
		$stmt = $this->db->prepare("SELECT `date`, avg FROM ping ORDER BY `date` DESC LIMIT 1");
		$stmt->execute();
		$ping_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$ping = array( 'date' => strtotime( $ping_data[0]['date']) * 1000 , 'avg' => $ping_data[0]['avg'] );
		echo json_encode($ping);
		exit;
	}
	
	
}