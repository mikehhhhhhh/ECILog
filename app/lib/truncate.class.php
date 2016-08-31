<?php

class truncate
{
	public function txtTruncate($string, $limit, $break=".", $pad="...")
	{
		if(false !== ($breakpoint = @strpos($string, $break, $limit)))
		{
			if($breakpoint < strlen($string) - 1)
			{
				$string = substr($string, 0, $breakpoint) . $pad;
			}
		} 
		
		return $string;
	}
}