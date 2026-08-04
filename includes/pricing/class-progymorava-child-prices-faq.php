<?php
/**
 * Prices page FAQ validation and parsing.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

class Progymorava_Child_Prices_FAQ {
	/**
	 * Register WordPress hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_filter( 'acf/validate_value/name=prices_faq_content', array( __CLASS__, 'validate' ), 10, 4 );
	}

	/**
	 * Validate the structured Prices FAQ textarea.
	 *
	 * @param bool|string         $valid Current validation result.
	 * @param string              $value Submitted value.
	 * @param array<string,mixed> $field ACF field settings.
	 * @param string              $input Input name.
	 * @return bool|string
	 */
	public static function validate( $valid, $value, $field, $input ) {
		$value = wp_unslash( $value );

		if ( true !== $valid || '' === trim( (string) $value ) ) {
			return $valid;
		}

		$state       = 'start';
		$line_number = 0;

		foreach ( preg_split( '/\R/', (string) $value ) as $line ) {
			$line_number++;
			$line = trim( $line );

			if ( '' === $line ) {
				continue;
			}

			if ( ! preg_match( '/^([TQA])\s*:\s*"([^"]+)"\s*$/u', $line, $matches ) ) {
				return 'Line ' . $line_number . ' must use T: "title", Q: "question", or A: "answer".';
			}

			$type = $matches[1];
			if ( 'T' === $type && ! in_array( $state, array( 'start', 'after_answer' ), true ) ) {
				return 'Line ' . $line_number . ' cannot contain T here. Finish the previous question with A first.';
			}
			if ( 'Q' === $type && ! in_array( $state, array( 'after_title', 'after_answer' ), true ) ) {
				return 'Line ' . $line_number . ' cannot contain Q here. Add T first, and do not repeat Q before A.';
			}
			if ( 'A' === $type && 'after_question' !== $state ) {
				return 'Line ' . $line_number . ' cannot contain A here. Every answer must directly follow Q.';
			}

			$state = 'T' === $type ? 'after_title' : ( 'Q' === $type ? 'after_question' : 'after_answer' );
		}

		return 'after_question' === $state ? 'The final Q must be followed by A.' : $valid;
	}

	/**
	 * Parse the structured Prices FAQ textarea into titled groups.
	 *
	 * @param string $content Structured textarea content.
	 * @return array<int,array{title:string,items:array<int,array{question:string,answer:string}>}>
	 */
	public static function parse( $content ) {
		$groups           = array();
		$current_group    = null;
		$current_question = null;

		foreach ( preg_split( '/\R/', (string) $content ) as $line ) {
			if ( ! preg_match( '/^([TQA])\s*:\s*"([^"]+)"\s*$/u', trim( $line ), $matches ) ) {
				continue;
			}

			$type = $matches[1];
			$text = $matches[2];

			if ( 'T' === $type ) {
				$groups[]        = array(
					'title' => $text,
					'items' => array(),
				);
				$current_group    = count( $groups ) - 1;
				$current_question = null;
			} elseif ( 'Q' === $type && null !== $current_group ) {
				$current_question = $text;
			} elseif ( 'A' === $type && null !== $current_group && null !== $current_question ) {
				$groups[ $current_group ]['items'][] = array(
					'question' => $current_question,
					'answer'   => $text,
				);
				$current_question = null;
			}
		}

		return $groups;
	}
}

Progymorava_Child_Prices_FAQ::init();
