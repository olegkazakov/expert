<?php
namespace expert\linker;
use expert\linker\SocialLinker as SocialLinker;

class GpLinker extends SocialLinker{
	private static $instance;
	private function __construct(){
	}
	public static function getInstance(){
		if (is_null(self::$instance)){
			self::$instance=new GpLinker;
		}
		return self::$instance;
	}
	public function link ($url){
		return rand(0,10000000);
	}
}
?>