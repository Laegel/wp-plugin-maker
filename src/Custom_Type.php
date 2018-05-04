<?php
namespace WP_Plugin_Maker;
use \WP_Query;

abstract class Custom_Type extends Controller {

	public static $type;
	public static $posts_per_page;
	public static $metas = [];

	abstract public static function action_init();

	protected static function get_default_args() {
		$args = [
			'post_type' => static::$type,
		];

		if (!empty(static::$posts_per_page)) {
			$args['posts_per_page'] = static::$posts_per_page;
		}

		return $args;
	}

	protected static function wrap($object) {
		$instance = new static();
		$instance->on_construct($object);
		return $instance;
	}

	protected function on_construct($object) {
		foreach ($object as $key => $value) {
			$this->$key = $value;
		}
	}

	public static function get() {
		$args = static::get_default_args();
		return new WP_Query($args);
	}

	public static function get_by_tax($taxonomy, $terms, $field = 'slug', $operator = 'IN') {
		$args = static::get_default_args();

		$args['tax_query'] = [
			[
				'taxonomy' => $taxonomy,
				'field'    => $field,
				'terms'    => $terms,
				'operator' => $operator,
			]
		];

		return new WP_Query($args);
	}

	public static function get_by_meta($key, $value, $compare = '=') {
		$args = static::get_default_args();

		$args['meta_query'] = [
			[
				'meta_key'     => $taxonomy,
				'meta_value'   => $value,
				'meta_compare' => $compare,
			]
		];

		return new WP_Query($args);
	}

	public static function get_by_id($id) {
		$args = static::get_default_args();
		$args['posts_per_page'] = 1;
		$args['post__in'] = [$id];
		$query = new WP_Query($args);
		return static::wrap($query->post);
	}
}
