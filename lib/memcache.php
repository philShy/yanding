<?php
class Mem
{
	private $type = "Memcache";
	private $m;
	private $time = 0;
	private $error;
	public function addServer($arr){
		$this->m->addServer();
	}
	public function s($key,$value='',$time=0){
		$number = func_num_args();
		if($number == 1){
			$this->get($key);
		}else if($number>=2){
			if ($value === null) {
				$this->delete($key);
			}else {
				$this->set($key,$value,$bool,$time);
			}
			
		}
	}
	public function getError(){
		if ($this->error) {
			return $this->error;
		}else {
			return 0;
		}
	}
}
































