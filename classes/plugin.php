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

		// This plugin's internal sanitization filters
		$this->hook( 'cws_tc_sanitize_title', 'uncontraction' );
		$this->hook( 'cws_tc_sanitize_title', 'percentify' );
		$this->hook( 'cws_tc_sanitize_title', 'unprependify' );
		$this->hook( 'cws_tc_sanitize_title', 'rangerific' );
	}

	/**
	 * Initializes the plugin, registers textdomain, etc
	 */
	public function init() {
		$this->load_textdomain( 'cws-slug-control', '/languages' );
	}

	public function uncontraction( $title ) {
		$apos = "['’]";
		$contractions = array(
			"(it|that|s?he|who)${apos}s" => '%s is',
			"(they|we|you|what|who)${apos}re" => '%s are',
			"(it|that|s?he|i|you|we|what|who|why)${apos}s" => '%s will',
			"(were|is|[cw]ould|should|might|must|had|has|have|do|ca)n${apos}t" => '%s not',
			"([cw]ould|should|might|must|we|you|i|they|what|where)${apos}ve" => '%s have',
		);
		foreach ( $contractions as $from => $to ) {
			$from = '#\b' . $from . '\b#i';
			$to = sprintf( $to, '$1' );
			// echo "Replacing $from, with $to<br />";
			$title = preg_replace( $from, $to, $title );
		}
		return $title;
	}

	public function percentify( $title ) {
		return preg_replace( '#\b(\d+)%(\s|$)#', '$1 percent$2', $title );
	}

	public function unprependify( $title ) {
		return preg_replace( '#^((developing|breaking)( news)?|update(s|ed)?):\s#i', '', $title );
	}

	public function rangerific( $title ) {
		return preg_replace( '#(\s|^)(\d+)([-–—]+)(\d+)(\s|$)#', '$1$2 to $4$5', $title );
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
			$title = apply_filters( 'cws_tc_sanitize_title', $title, $raw, $context );
		}
		return $title;
	}
}
