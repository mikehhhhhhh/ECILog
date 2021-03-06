<?php
class template
{
	private $vars  = array();
	private $templatePath;
	private $siteTemplate;
	
	public function __construct( $templatePath, $siteTemplate )
	{
		$this->templatePath = $templatePath;
		$this->siteTemplate = $siteTemplate;
	}
	public function __get($name)
	{
		return $this->vars[$name];
	}
	
	public function __set($name, $value)
	{
		$this->vars[$name] = $value;
	}
	
	public function render( $tpl )
	{
		extract($this->vars);
		ob_start();
			include( $this->templatePath . $this->siteTemplate .'/'. $tpl .'.tpl.php' );
		return ob_get_clean();
	}
	
	public function clean()
	{
		unset( $this->vars );
	}
}