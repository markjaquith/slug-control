<?php
defined( 'WPINC' ) or die;

class CWS_Slug_Control_Plugin extends WP_Stack_Plugin2 {

	protected static $instance;

	/**
	 * Constructs the object, hooks in to 'plugins_loaded'
	 */
	protected function __construct() {
		$this->hook( 'plugins_loaded', 'add_hooks' );
	}

	/**
	 * Adds hooks
	 */
	public function add_hooks() {
		$this->hook( 'init' );
		$this->hook( 'sanitize_title', 9 );
	}

	/**
	 * Initializes the plugin, registers textdomain, etc
	 */
	public function init() {
		$this->load_textdomain( 'cws-slug-control', '/languages' );
	}

	protected function uncontraction( $title ) {
		$apos = "['’]";
		$contractions = array(
			"(it|that|s?he|who)${apos}s" => '%s-is',
			"(they|we|you|what|who)${apos}re" => '%s-are',
			"(it|that|s?he|i|you|we|what|who|why)${apos}s" => '%s-will',
			"(were|is|[cw]ould|should|might|must|had|has|have|do|ca)n${apos}t" => '%s-not',
			"([cw]ould|should|might|must|we|you|i|they|what|where)${apos}ve" => '%s-have',
		);
		foreach ( $contractions as $from => $to ) {
			$from = '#\b' . $from . '\b#i';
			$to = sprintf( $to, '$1' );
			// echo "Replacing $from, with $to<br />";
			$title = preg_replace( $from, $to, $title );
		}
		return $title;
	}

	/**
	 * Callback for sanitize_title filter
	 *
	 * @param string $title The post title
	 * @param string $raw_title The original post title
	 * @param string $context The context
	 * @return string The modified title
	 */
	public function sanitize_title( $title, $raw_title, $context ) {
		if ( 'display' === $context || 'save' === $context ) {
			$title = $this->uncontraction( $title );
		}
		return $title;
	}
}
