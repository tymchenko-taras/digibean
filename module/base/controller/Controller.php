<?php
class Base_Controller{
    protected $viewPath = '';
    protected $mainLayout = 'layout/main';

    public function __construct(){
		//TODO remove derevbud from path
        $this -> viewPath = BEAN_PROJECT_DIR .'/module/derevbud/view/';
    }

    protected function renderPartial($view, $params = array(), $return = false){
        extract($params, EXTR_OVERWRITE);
        ob_start();
		require $this -> viewPath. $view . '.php';
		if ($return){
            return ob_get_clean();
        } else {
            echo ob_get_clean();
        }
    }

    protected function render($view, $params = array()){
		$content = $this -> renderPartial($view, $params, true);
		$this -> renderPartial($this -> mainLayout, array('content' => $content));
    }

	public function __call($name, $arguments){
		if (substr($name, 0, 6) == 'action'){
			switch ($_SERVER['REQUEST_METHOD']){
				case 'POST':
					$name .= 'Post';
					break;
				case 'GET':
					$name .= 'Get';
					break;
			}
			call_user_func_array(array($this, $name), $arguments);
		} else {
			throw new Exception();
		}
	}
}