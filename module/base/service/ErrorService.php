<?php
class Base_ErrorService extends Base_Service{
	protected $output = '';

    public function handle($exception){
        $this -> clearOutputBuffer();
		$this -> logException($exception);

		if (System::isProduction()){
			$this -> showPrettyOutput($exception);
		} else {
			$this -> showRawOutput($exception);
		}

		$this -> shutdown();
    }

	protected function tryToShowPageAnyway(){
		return (error_reporting() === 0);
	}

	protected function logException($exception){

	}

	protected function clearOutputBuffer(){
		while (ob_get_level()){
			$this -> output .= ob_get_clean();
		}
	}

	protected function showPrettyOutput($exception){
		$action = System::config(array('system', 'errorAction'));
		$controller = System::config(array('system', 'errorController'));
		$controller = Factory::controller($controller);

		call_user_func_array(array($controller, $action), array($exception));
	}

	protected function showRawOutput($exception){
		echo '<pre>';
		echo 'Error Service<br>';
		echo $exception -> getMessage(), '<br>';
		echo '----------------<br>';
		echo $exception -> getTraceAsString(), '<br>';
		echo '----------------<br>';
	}

	protected function shutdown(){
		exit;
	}
}