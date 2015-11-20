<?php
/**
 * Created by JetBrains PhpStorm.
 * User: t.tymchenko
 * Date: 29.10.14
 * Time: 14:54
 * To change this template use File | Settings | File Templates.
 */
class SpeedUtil{

	function sizeOfVar($var) {
		$start_memory = memory_get_usage();
		$tmp = unserialize(serialize($var));
		return memory_get_usage() - $start_memory;
	}

	static private $startedTimers = array();
	static private $timers = array();
	static public $files = array();

	static public function StartTimer($name) {
		if (array_key_exists($name, static::$startedTimers)) return;
		static::$startedTimers[$name] = microtime(true);
	}

	static public function StopTimer($name) {
		$now = microtime(true);
		if (!array_key_exists($name, static::$startedTimers)) return;
		@static::$timers[$name] += ($now - static::$startedTimers[$name]);
		unset(static::$startedTimers[$name]);
	}

	static public function GetTimers() {
		$now = microtime(true);
		$timers = static::$timers;
		foreach (static::$startedTimers as $name => $value) {
			@$timers[$name] += ($now - $value);
		}
		$result = array(
			'php.max_execution_time' => ini_get('max_execution_time'),
			'script.execution_time' => ($now - BEAN_LOG_START_TIME),
		);
		if (count($timers) > 0) {
			$result['log.timers'] = $timers;
		}
		return $result;
	}
}