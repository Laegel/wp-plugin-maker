<?php
namespace WP_Plugin_Maker;

class Controller {
    protected static function remove_filter($name) {
        remove_filter($name, static::class . '::action_' . $name);
    }

	protected static function remove_action($name) {
		static::remove_filter($name);
	}

	protected static function sanitize($value) {
		if (is_array($value)) {
			foreach ($value as $key => $sub_value) {
				$value[$key] = self::sanitize($sub_value);
			}
		} elseif(is_object($value)) {
            foreach ($value as $key => $sub_value) {
				$value->$key = self::sanitize($sub_value);
			}
		} else {
			$value = sanitize_text_field($value);
		}
		return $value;
	}

	protected static function get_param($key) {
		if (isset($_GET[$key])) {
			return sanitize_text_field($_GET[$key]);
		}
	}

	protected static function die_json($data, $status = 200) {
		http_response_code($status);
		header('Content-Type: application/json');
		die(json_encode($data));
	}

	// When using metadata @transient(duration) or @cache(duration)
	// function bp_getset_transient($name, $callback, $expiration = HOUR_IN_SECONDS) {
	// 	if (!is_callable($callback)) {
	// 		throw new Exception('"' . $name . '" transient has no valid callback');
	// 	}
	// 	$transient = get_transient($name);
	// 	if (!$transient || isset($_GET['empty-' . $name])) {
	// 		$transient = $callback();
	// 		set_transient($name, $transient, $expiration);
	// 	}
	// 	return $transient;
	// }
}

