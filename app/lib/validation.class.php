<?php
// Mike Hughes - http://mikehugh.es

class validation
{
	public function jdiDateInput( $date )
	{
		//validates date in dd/mm/yyyy mm:hh format
		if( date("d/m/Y H:i", strtotime( str_replace('/','-', $date ) ) ) != trim( $date ) )
			return false;
		else return true;
	}
	
	public function timeNotGreater( $earlier, $later )
	{
		if( strtotime( str_replace('/','-', $earlier ) ) >  strtotime( str_replace('/','-', $later ) ) )
			return false;
		else
			return true;
	}
	
	public function required( $val=null )
	{
		if( $val )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}