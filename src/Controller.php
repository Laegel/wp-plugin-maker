<?php
namespace WP_Plugin_Maker;

class Controller {
    protected static function remove_filter($name) {
        remove_filter($name, get_called_class() . '::action_' . $name);
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
}

