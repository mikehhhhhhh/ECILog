<?php
/* Mike Hughes - http://mike-hughes.net */


class core
{ 
	public static $config = array();
	public $db;
	public static $siteTemplate;
	public static $template;
	public static $memcache;
	
	public function __construct($cli=false)
	{
		require( dirname(dirname(__FILE__)) .'/config/config.inc.php' );
		require( dirname(dirname(__FILE__)) .'/config/local.inc.php' );
		$_config = array_merge( $_config, $_localConfig );
		self::$config = $_config;
		spl_autoload_register('core::loadClass');
		
		$this->db = new db;
		
		if(!$cli)
		{
			self::$siteTemplate = 'modemstats';
			self::$template = new template( $_config['paths']['templates'], self::$siteTemplate );
			self::$template->_thisTemplate	= self::$siteTemplate; 
			
			try {
				$router = new router( self::$config['router_ini'] );
				self::$template->content = $router->route( $_SERVER['REQUEST_URI'] );
			} catch ( preg_router_error $e ) {
				echo 'Routing error: '. $e->getMessage();
				exit();
			}
			echo self::$template->render('layout');
		}
	}
	
	public static function loadClass( $className )
	{
		try
		{
			if( file_exists( self::$config['paths']['app'] . "classes/class." . strtolower( $className ) .".php" ) )
				require_once( self::$config['paths']['app']  . "classes/class." . strtolower( $className ) . ".php" );
			elseif( file_exists( self::$config['paths']['app']  . "lib/". $className . ".class.php" ) )
				require_once( self::$config['paths']['app']  . "lib/". $className . ".class.php" );
			elseif( file_exists( self::$config['paths']['app']  . "lib/modems/". $className . ".class.php" ) )
				require_once( self::$config['paths']['app']  . "lib/modems/". $className . ".class.php" );
			elseif( preg_match('/^Module_/', $className ) && file_exists( self::$config['paths']['app'] . 'modules/'. preg_replace('/^Module_/', '', $className ) .'.module.php' ) )
				require_once( self::$config['paths']['app'] . 'modules/'. preg_replace('/^Module_/', '', $className ) .'.module.php' );
			else
			{
				throw new Exception('Could not find class: '. $className .':'. self::$config['paths']['app'] . 'modules/'. preg_replace('/^Module_/', '', $className ) .'.module.php'.self::$config['paths']['app']  . "lib/". $className . ".class.php");	
			}
		} catch ( Exception $e ) {
			echo $e->getMessage();
			exit();
		}
	}
	
	public static function startMemcache()
	{
		try
		{
			self::$memcache = new Memcache;
			self::$memcache->connect( self::$config['memcache']['host'], self::$config['memcache']['port'] );
			return self::$memcache;
		} catch( Exception $e ) {
			echo $e->getMessage();
		}
	}
	
	
}

