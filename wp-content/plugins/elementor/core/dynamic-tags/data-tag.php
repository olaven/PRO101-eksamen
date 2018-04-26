<?php
namespace Elementor\Core\DynamicTags;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

abstract class Data_Tag extends Base_Tag {

	/**
	 * @since 2.0.0
	 * @access protected
	 * @abstract
	 */
	abstract protected function get_value( array $options = [] );

	/**
	 * @since 2.0.0
	 * @access public
	 */
	final public function get_content_type() {
		return 'plain';
	}

	/**
	 * @since 2.0.0
	 * @access public
	 */
	public function get_content( array $options = [] ) {
		return $this->get_value( $options );
	}
}
