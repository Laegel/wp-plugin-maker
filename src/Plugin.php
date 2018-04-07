<?php
namespace WP_Plugin_Maker;

abstract class Plugin {

	protected static $autoloader;
	protected static $dir;
    
    public static function init($dir) {
		static::$dir = $dir;

		$env = self::get_env();
		
		$require = require static::$dir . DIRECTORY_SEPARATOR . 'require-' . $env . '.php';
		static::$autoloader = function($class) use ($require) {
			if (isset($require[$class])) {
				require_once static::$dir . DIRECTORY_SEPARATOR . $require[$class]['path'];
			}
		};

		spl_autoload_register(static::$autoloader);

		// Adding filters/actions
		if (!empty($require)) {
			foreach ($require as $data) {
				if (!empty($data['actions'])) {
					foreach ($data['actions'] as $action) {
						add_filter(
							$action['name'], $action['callback'],
							$action['priority'], $action['args_count']
						);
					}
				}
			}
		}
	}
	
    public static function get_env() {
        $env = 'front';
        if (is_admin()) {
			$env = 'admin';
		} elseif (defined('WP_CLI') && WP_CLI) {
			$env = 'cli';
		} elseif ($is_rest) {
			$env = 'rest';
		}
        return $env;
    }
}