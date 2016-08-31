<?php
// Mike Hughes - http://mikehugh.es

class Modem
{
	public $sock;
	public $status;

	public function __construct ($modem_ip)
	{
		$this->sock = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP );
		if( $this->sock )
		{
			socket_set_option ($this->sock, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 30, "usec" =>0));
			if( socket_connect( $this->sock, $modem_ip, 23 ) )
			{
				$this->status = 'Connected';
			}

		}
	}

	public function __destruct()
	{
		$this->close();
	}

	public function close()
	{
		if( $this->sock )
		{
			socket_close( $this->sock );
			$this->sock = null;
		}
	}

	public function SendAndWait( $send, $wait )
	{
		socket_write( $this->sock, $send . PHP_EOL );
		$return = $this->WaitFor( $wait );
		$return = str_replace( " ".$send."\r\n", '', $return );
		return $return;
	}

	public function WaitFor( $wait )
	{
		$buffer = '';
		while( !preg_match('/'. $wait .'$/', $buffer ) )
		{
			$buffer .= socket_read( $this->sock, 64 );
		}
		$return = str_replace( "\r\n".$wait, '', $buffer );
		return $return;
	}

	public function ReturnToCSV( $data )
	{
		$data = str_replace(") (", "\n", $data);
		$data = str_replace(")", "", $data);
		$data = str_replace("(", "", $data);
		$data = str_replace("\r", "", $data);
		return $data;
	}

	public function GetBetween($content,$start,$end)
	{
	    $r = explode($start, $content);
	    if (isset($r[1])){
	        $r = explode($end, $r[1]);
	        return $r[0];
	    }
	    return '';
	}
}