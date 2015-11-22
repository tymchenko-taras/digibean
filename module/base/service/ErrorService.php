<?php
class Base_ErrorService extends Base_Service{
	protected $exception = null;
	protected $errorType = null;

    public function handle($exception, $errorType){
		$this -> exception = $exception;
		$this -> errorType = $errorType;

		if (System::isProduction()){
			$this -> logError();
			$this -> showPrettyOutput();
		} else {
			$this -> showRawOutput();
		}
	}


	protected function isCritical(){
		return !in_array($this -> errorType, array(E_USER_NOTICE, E_NOTICE));
	}

	protected function logError(){

	}

	protected function clearOutputBuffer(){
		while (ob_get_level()){
			ob_end_clean();
		}
	}

	protected function callPrettyController(){
		$action = System::config(array('system', 'errorAction'));
		$controller = System::config(array('system', 'errorController'));
		$controller = Factory::controller($controller);
		call_user_func_array(array($controller, $action), array($this -> exception));
	}

	protected function showPrettyOutput(){
		if ($this -> isCritical()){
			$this -> clearOutputBuffer();
			$this -> callPrettyController();
			$this -> shutdown();
		}
	}

	protected function showRawOutput(){
		$this -> clearOutputBuffer();
		echo '<pre>';
		echo 'Error Service<br>';
		echo $this -> exception -> getMessage(), '<br>';
		echo '----------------<br>';
		echo $this -> exception -> getTraceAsString(), '<br>';
		echo '----------------<br>';

		$this -> shutdown();
	}

	protected function shutdown(){
		exit;
	}
}