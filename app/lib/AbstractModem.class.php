<?php
class AbstractModem
{
	abstract protected function login();
	abstract protected function readDownSNRData();
	abstract protected function readUpBitData();
	abstract protected function readDownBitData();
}