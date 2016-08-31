<?php
// Mike Hughes - http://mikehugh.es

class ECI_BFocusV2FUb_R 
{
	public $modem;
	public $rawData;
	public $data;
	private $modemConf;

	public function __construct()
	{
		$this->modemConf = core::$config['modem'];

		$this->modem = new Modem( $this->modemConf['ip'] );
	}

	public function Login()
	{
		$this->modem->WaitFor('login:');
		$this->modem->SendAndWait( "admin", 'Password:');
		$this->modem->SendAndWait( "admin", '#');
	}


	/*
		Read Data
	*/
	public function ReadAll()
	{
		$this->ReadDownSNRData();
		$this->ReadUpBitData();
		$this->ReadDownBitData();
		$this->ReadUpGainData();
		$this->ReadDownGainData();
		$this->ReadLineStatus();
		$this->ReadBandStatus();
		$this->ReadBandDataUp();
		$this->ReadLineDataUp();
		$this->ReadConnectionDataUp();
		$this->ReadBandDataDown();
		$this->ReadLineDataDown();
		$this->ReadConnectionDataDown();
		$this->ReadHlogData();
	}

	public function ReadDownSNRData()
	{
		$this->modem->SendAndWait( "echo \"g997sang 1\" > /tmp/pipe/dsl_cpe0_cmd", '#');
		$result = $this->modem->SendAndWait( "cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['downSNRRaw'] = $this->modem->GetBetween( $result, 'nData="', '"');
		return $this->rawData['downSNRRaw'];
	}

	public function ReadUpBitData()
	{
		$this->modem->SendAndWait( "echo \"g997bang 0\" > /tmp/pipe/dsl_cpe0_cmd", '#');
		$result = $this->modem->SendAndWait( "cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['upBitRaw'] = $this->modem->GetBetween( $result, 'nData="', '"');
		return $this->rawData['upBitRaw'];
	}

	public function ReadDownBitData()
	{
		$this->modem->SendAndWait("echo \"g997bang 1\" > /tmp/pipe/dsl_cpe0_cmd", "#");
		$result = $this->modem->SendAndWait("cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['downBitRaw'] = $this->modem->GetBetween( $result, "nData=\"", "\"");
		return $this->rawData['downBitRaw'];
	}

	public function ReadUpGainData()
	{
		$this->modem->SendAndWait("echo \"g997gang 0\" > /tmp/pipe/dsl_cpe0_cmd", "#");
		$result = $this->modem->SendAndWait("cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['upGainRaw'] = $this->modem->GetBetween($result, "nData=\"", "\"");
		return $this->rawData['upGainRaw'];
	}

	public function ReadDownGainData()
	{
		$this->modem->SendAndWait("echo \"g997gang 1\" > /tmp/pipe/dsl_cpe0_cmd", "#");
		$result = $this->modem->SendAndWait("cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['downGainRaw'] = $this->modem->GetBetween($result, "nData=\"", "\"");
		return $this->rawData['downGainRaw'];
	}

	public function ReadLineStatus()
	{
		$this->modem->SendAndWait("echo \"lsg\" > /tmp/pipe/dsl_cpe0_cmd", "#");
		$result = $this->modem->SendAndWait("cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['lineStatusRaw'] = $this->modem->GetBetween($result, "nLineState=", "\r\n");
		return $this->rawData['lineStatusRaw'];
	}

	public function ReadBandStatus()
	{
		$this->modem->SendAndWait("echo \"bpstg\" > /tmp/pipe/dsl_cpe0_cmd", "#");
		$result = $this->modem->SendAndWait("cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['bandStatusRaw'] = $this->modem->GetBetween($result, "nProfile=", "\r\n");
		return $this->rawData['bandStatusRaw'];
	}

	public function ReadBandDataUp()
	{
		$this->modem->SendAndWait("echo \"g997lspbg 0\" > /tmp/pipe/dsl_cpe0_cmd", "#");
		$result = $this->modem->SendAndWait("cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['bandDataUpRaw'] = $this->modem->GetBetween($result, "nDirection=", "\r\n");
		return $this->rawData['bandDataUpRaw'];
	}

	public function ReadLineDataUp()
	{
		$this->modem->SendAndWait("echo \"g997lsg 0 1\" > /tmp/pipe/dsl_cpe0_cmd", "#");
		$result = $this->modem->SendAndWait("cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['lineDataUpRaw'] = $this->modem->GetBetween($result, "nDirection=", "\r\n");
		return $this->rawData['lineDataUpRaw'];
	}

	public function ReadConnectionDataUp()
	{
		$this->modem->SendAndWait("echo \"g997csg 0 0\" > /tmp/pipe/dsl_cpe0_cmd", "#");
		$result = $this->modem->SendAndWait("cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['syncUp'] = $this->modem->GetBetween($result, "ActualDataRate=", " PreviousDataRate="); 
		return $this->rawData['syncUp'];
	}

	public function ReadBandDataDown()
	{
		$this->modem->SendAndWait("echo \"g997lspbg 1\" > /tmp/pipe/dsl_cpe0_cmd", "#");
		$result = $this->modem->SendAndWait("cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['bandDataDownRaw'] = $this->modem->GetBetween($result, "nDirection=", "\r\n");
		return $this->rawData['bandDataDownRaw'];
	}

	public function ReadLineDataDown()
	{
		$this->modem->SendAndWait("echo \"g997lsg 1 1\" > /tmp/pipe/dsl_cpe0_cmd", "#");
		$result = $this->modem->SendAndWait("cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['lineDataDownRaw'] = $this->modem->GetBetween($result, "nDirection=", "\r\n");
		return $this->rawData['lineDataDownRaw'];
	}

	public function ReadConnectionDataDown()
	{
		$this->modem->SendAndWait("echo \"g997csg 0 1\" > /tmp/pipe/dsl_cpe0_cmd", "#");
		$result = $this->modem->SendAndWait("cat /tmp/pipe/dsl_cpe0_ack", "#");
		$this->rawData['syncDown'] = $this->modem->GetBetween($result, "ActualDataRate=", " PreviousDataRate="); 
		return $this->rawData['syncDown'];
	}

	public function ReadHlogData()
	{
		$this->modem->SendAndWait('echo "g997dhlogg 1 1" > /tmp/pipe/dsl_cpe0_cmd', '#');
		$result = $this->modem->SendAndWait('cat /tmp/pipe/dsl_cpe0_ack','#');
		$this->rawData['hlog'] = $this->modem->GetBetween($result, "nData=\"\r\n","\"\r\n");
	}

	public function CloseModem()
	{
		$this->modem->close();
	}

	/*
		Process Data
	*/

	public function processAll()
	{
		$this->ProcessDownSNRData();
		$this->ProcessUpBitData();
		$this->ProcessDownBitData();
		$this->ProcessUpGainData();
		$this->ProcessDownGainData();
		$this->ProcessLineStatus();
		$this->processBandStatus();
		$this->processBandDataUp();
		$this->processLineDataUp();
		$this->processConnectionDataUp();
		$this->processBandDataDown();
		$this->processLineDataDown();
		$this->processConnectionDataDown();
		$this->ProcessHlognData();
	}

	public function ProcessDownSNRData()
	{
		if( $this->rawData['downSNRRaw'] )
		{
			$downSNRRaw = $this->modem->ReturnToCSV( $this->rawData['downSNRRaw'] );
			$downSNRSplit = explode("\n", $downSNRRaw);
			$downSNR = array();
			foreach( $downSNRSplit as $row )
			{
				if( $row !== "" )
				{
					$temp = explode(',', $row );
					$this->data['downSNR'][] = array( (int)trim($temp[0]), (float)(hexdec(trim($temp[1]))/2 - 32));
				}
			}
		}
	}

	public function ProcessUpBitData()
	{
		if( $this->rawData['upBitRaw'] )
		{
			$upBitRaw = $this->modem->ReturnToCSV( $this->rawData['upBitRaw']);
			$upBitSplit = explode("\n", $upBitRaw);
			$upBit = array();
			foreach( $upBitSplit as $row )
			{
				if( $row !== "" )
				{
					$temp = explode(',', $row );
					$this->data['upBit'][] = array( (int)trim($temp[0]), (float)hexdec(trim($temp[1])) );
				}
			}
		}
	}

	public function ProcessDownBitData()
	{
		if( $this->rawData['downBitRaw'] )
		{
			$downBitRaw = $this->modem->ReturnToCSV( $this->rawData['downBitRaw']);
			$downBitSplit = explode("\n", $downBitRaw);
			$downBit = array();
			foreach( $downBitSplit as $row )
			{
				if( $row !== "" )
				{
					$temp = explode(',', $row );
					$this->data['downBit'][] = array( (int)trim($temp[0]), (float)hexdec(trim($temp[1])) );
				}
			}
		}
	}

	public function ProcessUpGainData()
	{
		if( $this->rawData['upGainRaw'] )
		{
			$upGainRaw = $this->modem->ReturnToCSV( $this->rawData['upGainRaw']);
			$upGainSplit = explode("\n", $upGainRaw );
			$upGain = array();
			foreach( $upGainSplit as $row )
			{
				if( $row !== "" )
				{
					$temp = explode(',', $row );
					$this->data['upGain'][] = array( (int)trim($temp[0]), (float)hexdec(trim($temp[1]))/512 );
				}
			}
		}
	}

	public function ProcessDownGainData()
	{
		if( $this->rawData['downGainRaw'] )
		{
			$downGainRaw = $this->modem->ReturnToCSV( $this->rawData['downGainRaw']);
			$downGainSplit = explode("\n", $downGainRaw );
			$downGain = array();
			foreach( $downGainSplit as $row )
			{
				if( $row !== "" )
				{
					$temp = explode(',', $row );
					$this->data['downGain'][] = array( (int)trim($temp[0]), (float)hexdec(trim($temp[1]))/512 );
				}
			}
		}
	}

	public function ProcessLineStatus()
	{
		if( $this->rawData['lineStatusRaw'] )
		{
			switch ($this->rawData['lineStatusRaw'])
			{
				case "0x0":
					$status = "Not Initialized";
					break;
				case "0x1":
					$status = "Exception";
					break;
				case "0x10":
					$status = "Not Updated";
					break;
				case "0xFF":
					$status = "Idle Request";
					break;
				case "0x100":
					$status = "Idle";
					break;
				case "0x1FF":
					$status = "Silent Request";
					break;
				case "0x200":
					$status = "Silent";
					break;
				case "0x300":
					$status = "Handshake";
					break;
				case "0x380":
					$status = "Full Init";
					break;
				case "0x400":
					$status = "Discovery";
					break;
				case "0x500":
					$status = "Training";
					break;
				case "0x600":
					$status = "Analysis";
					break;
				case "0x700":
					$status = "Exchange";
					break;
				case "0x800":
					$status = "Showtime - No Sync";
					break;
				case "0x801":
					$status = "Showtime";
					break;
				case "0x900":
					$status = "Fast Retrain";
					break;
				case "0xa00":
					$status = "Low Power 12";
					break;
				case "0xb00":
					$status = "Loop Diagnostic Active";
					break;
				case "0xb10":
					$status = "Loop Diagnostic Data Exchange";
					break;
				case "0xb20":
					$status = "Loop Diagnostic Data Request";
					break;
				case "0xc00":
					$status = "Loop Diagnostic Complete";
					break;
				case "0x1000000":
					$status = "Test";
					break;
				case "0xd00":
					$status = "Resync";
					break;
				case "0x3c0":
					$status = "Short Init Entry";
					break;
				default:
					$status = "Unknown";
					break;
			}

			$this->data['lineStatus'] = $status;
		}
	}

	public function processBandStatus()
	{
		if( $this->rawData['bandStatusRaw'] )
		{
			switch ($this->rawData['bandStatusRaw'])
			{
				case "0":
					$profile = "Profile 8a";
					break;
				case "1":
					$profile = "Profile 8b";
					break;
				case "2":
					$profile = "Profile 8c";
					break;
				case "3":
					$profile = "Profile 8d";
					break;
				case "4":
					$profile = "Profile 12a";
					break;
				case "5":
					$profile = "Profile 12b";
					break;
				case "6":
					$profile = "Profile 17a";
					break;
				case "7":
					$profile = "Profile 30a";
					break;
				default:
					$profile = "Unknown";
					break;
			}
			$this->data['profile'] = $profile;
		}
	}

	public function processBandDataUp()
	{
		if( $this->rawData['bandDataUpRaw'] )
		{
			$split = explode(" ", $this->rawData['bandDataUpRaw']);
			$bandDataUp['snr'] = array();
			$bandDataUp['latn'] = array();
			$bandDataUp['satn'] = array();

			foreach( $split as $pair )
			{
				$splitPair = explode('=',$pair);
				if( isset($pair[0]) )
				{
					if( $pair[0] == 'L' )
					{
						$bandDataUp['latn'][$pair[5]] = (float)$splitPair[1] / 10;
					}
					elseif( $pair[0] == 'S' && $pair[1] == 'A' )
					{
						$bandDataUp['satn'][$pair[5]] = (float)$splitPair[1] / 10;
					}
					elseif( $pair[0] == 'S' && $pair[1] == 'N' )
					{
						$bandDataUp['snr'][$pair[4]] = (float)$splitPair[1] / 10;
					}
				}
			}
			$this->data['bandDataUp'] = $bandDataUp;
		}
	}

	public function processLineDataUp()
	{
		if( $this->rawData['lineDataUpRaw'] )
		{
			$lineData = array();
			$split = explode(" ", $this->rawData['lineDataUpRaw']);
			foreach( $split as $pair )
			{
				$splitPair = explode('=',$pair);
				if( isset($pair[0]) )
				{
					if( $pair[0] == 'L' )
						$this->data['bandDataUp']['latn'][5] = (float)$splitPair[1] / 10;
					elseif( $pair[0] == 'S' && $pair[1] == 'A' )
						$this->data['bandDataUp']['satn'][5] = (float)$splitPair[1] / 10;
					elseif( $pair[0] == 'S' && $pair[1] == 'N' )
						$this->data['bandDataUp']['snr'][5] = (float)$splitPair[1] / 10;
					elseif( $pair[0] == 'A' && $pair[1] == 'T' )
						$this->data['lineDataUp']['attainable'] = $splitPair[1];
					elseif( $pair[0] == 'A' && $pair[1] == 'C' )
						$this->data['lineDataUp']['power'] = $splitPair[1];
				}
			}
		}
	}

	public function processConnectionDataUp()
	{
		$this->data['lineDataUp']['sync'] = $this->rawData['syncUp'];
	}

	public function processBandDataDown()
	{
		if( $this->rawData['bandDataDownRaw'] )
		{
			$split = explode(" ", $this->rawData['bandDataDownRaw']);
			$bandDataDown['snr'] = array();
			$bandDataDown['latn'] = array();
			$bandDataDown['satn'] = array();

			foreach( $split as $pair )
			{
				$splitPair = explode('=',$pair);
				if( isset($pair[0]) )
				{
					if( $pair[0] == 'L' )
					{
						$bandDataDown['latn'][$pair[5]] = (float)$splitPair[1] / 10;
					}
					elseif( $pair[0] == 'S' && $pair[1] == 'A' )
					{
						$bandDataDown['satn'][$pair[5]] = (float)$splitPair[1] / 10;
					}
					elseif( $pair[0] == 'S' && $pair[1] == 'N' )
					{
						$bandDataDown['snr'][$pair[4]] = (float)$splitPair[1] / 10;
					}
				}
			}
			$this->data['bandDataDown'] = $bandDataDown;
		}
	}

	public function processLineDataDown()
	{
		if( $this->rawData['lineDataDownRaw'] )
		{
			$lineData = array();
			$split = explode(" ", $this->rawData['lineDataDownRaw']);
			foreach( $split as $pair )
			{
				$splitPair = explode('=',$pair);
				if( isset($pair[0]) )
				{
					if( $pair[0] == 'L' )
						$this->data['bandDataDown']['latn'][5] = (float)$splitPair[1] / 10;
					elseif( $pair[0] == 'S' && $pair[1] == 'A' )
						$this->data['bandDataDown']['satn'][5] = (float)$splitPair[1] / 10;
					elseif( $pair[0] == 'S' && $pair[1] == 'N' )
						$this->data['bandDataDown']['snr'][5] = (float)$splitPair[1] / 10;
					elseif( $pair[0] == 'A' && $pair[1] == 'T' )
						$this->data['lineDataDown']['attainable'] = $splitPair[1];
					elseif( $pair[0] == 'A' && $pair[1] == 'C' )
						$this->data['lineDataDown']['power'] = $splitPair[1];
				}
			}
		}
	}

	public function processConnectionDataDown()
	{
		$this->data['lineDataDown']['sync'] = $this->rawData['syncDown'];
	}

	public function ProcessHlognData()
	{
		if( $this->rawData['hlog'] )
		{
			$hlogRaw = $this->modem->ReturnToCSV( $this->rawData['hlog']);
			$hlogSplit = explode("\n", $hlogRaw );
			$this->data['hlog'] = array();
			foreach( $hlogSplit as $row )
			{
				if( $row !== "" )
				{
					$temp = explode(',', $row );
					$this->data['hlog'][] = array( (int)trim($temp[0]) * 8, (float)(6 - ($temp[1] / 10)));
				}
			}
		}
	}


}