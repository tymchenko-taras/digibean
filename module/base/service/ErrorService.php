<?php
class Base_ErrorService extends Base_Service{
	protected $exception = null;
	protected $errorType = null;

    public function handle($exception, $errorType){
		$this -> exception = $exception;
		$this -> errorType = $errorType;

		if ($this -> needToShowPretty()){
			$this -> logError();
			$this -> showPrettyOutput();
		} else {
			$this -> showRawOutput();
		}
	}

	protected function needToShowPretty(){
		return System::isProduction() || ($this -> exception -> getMessage() == 404);
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
		$action = System::app() -> config(array('system', 'errorAction'));
		$controller = System::app() -> config(array('system', 'errorController'));
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