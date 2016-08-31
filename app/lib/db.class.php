<?php

class db
{
	public $DBH;
	
	public function __construct()
	{
		$dbConf = core::$config['db'];
		try
		{
			$this->DBH = new PDO('mysql:host='. $dbConf['host'] .';dbname='. $dbConf['database'], $dbConf['user'], $dbConf['pass']);
		} catch( PDOException $e ) {
			echo $e->getMessage();
		}
	}
	
	public function __call( $func, $args )
	{
		return call_user_func_array( array( $this->DBH, $func ), $args );
	}
	
	
	public function dateConvert( $phpDate )
	{
		return date( 'Y-m-d H:i:s', $phpDate );
	}

}




