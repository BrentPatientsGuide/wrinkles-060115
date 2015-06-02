<?php
/*
some basic helper functions used throughout the plugin
*/

function addhttp($url) {

	if (!preg_match("~^(?:f|ht)tps?://~i", $url))
		$url = "http://" . $url;

	$url = esc_url( $url );

	return $url;
}


function href_title($title) {

	$title	= str_replace( array('<br />', '<br>', '<br/>'), array(' ', ' ', ' '), $title);
	$title	= esc_attr( strip_tags($title) );

	return $title;
}
/**
 * This function will take a string in the format of a single item or
 * multiple items in the format 1,2,3,4,5 or an array of items.
 * The output will be a readable set of items with the last two items
 * separated by " and ".
 *
 * originally found here: http://www.hashbangcode.com/blog/format-list-items-php-449.html
 *
 * @param  string|array $numbers The list of items as a string or array.
 * @return string                The formatted items.
 */
function formatItems($numbers) {

	// If numbers is an array then implode it into a comma separated string.
	if ( is_array( $numbers ) )
		$numbers = implode( ',', $numbers );

	if ( is_string( $numbers ) ) :
		/*
		Make sure all commas have a single space character after them and that
		there are no double commas in the string.
		*/
		$numbers = trim($numbers);

		$patterns[0] = '/\s*,\s*/';
		$patterns[1] = '/,{2,}/';
		$patterns[2] = '/,+$/';
		$patterns[3] = '/^,+/';
		$patterns[4] = '/,/';
		$replacements[0] = ',';
		$replacements[1] = ',';
		$replacements[2] = '';
		$replacements[3] = '';
		$replacements[4] = ', ';

		$numbers= preg_replace($patterns, $replacements, $numbers);

		// The string contains commas, find the last comma in the string.
		$lastCommaPos = strrpos($numbers, ',') - strlen($numbers);

		// Replace the last ocurrance of a comma with " and "
		$numbers = substr($numbers, 0, $lastCommaPos) . str_replace(',', ', and ', substr($numbers, $lastCommaPos));

	endif;

	return $numbers;
}

/**
 * helper function to create markup list from array
 *
 */

function formatList( $array ) {

	if ( ! is_array( $array ) )
		return;

	$data = array();
	$data[] = '<ul>';

	foreach ( $array as $item ):
		$data[] = '<li>'.$item.'</li>';
	endforeach;

	$data[] = '</ul>';

	$data = implode( '', $data );

	return $data;

}

/**
 * helper function to run checks on timestamps and adjust for timezones
 */
function pa_zone_adjust( $stamp ) {

	$string	= get_option( 'timezone_string' );

	if ( empty( $string ) ) :
		$utc	= get_option( 'gmt_offset' );
		$zone	= $utc * 3600;
	endif;

	if ( ! empty( $string ) ) :
		$zone	= new DateTimeZone( $string );
		$zone	= $zone->getOffset( new DateTime );
	endif;

	$zone	= $zone * -1;

	$adjusted = $stamp - $zone;

	return $adjusted;

}

/**
 * helper function to sort based on timestamp
 */
function pa_stamp_sort( $a, $b ) {
	return strcmp( $a['stamp'], $b['stamp'] );
}


/**
 * Form Field Helpers
 */

/**
 * Render radio field
 *
 * @param  array $field_data  extra field data
 * @param  string $form       form HTML
 * @return string             modified form HTML
 */
function pa_render_radio_field( $field_data, $form ) {
	$label	= $field_data['extra-label'];
	$values	= $field_data['extra-value'];
	$color	= isset( $field_data['extra-color'] ) ? $field_data['extra-color'] : '';

	$fields	= explode( ',', $values );
	$name	= pa_sanitize_extra_field_key( $label );

	$form .= '<div class="pa-field-group pa-radio-group">';
	$form .= '<h4>' . esc_html( $label ) . '</h4>';
	$form .= '<ul>';

	foreach ( $fields as $field ) :

		if ( ! empty( $color ) ) :

			$ccode	= preg_match( '/{(.*?)}/', $field, $hexcode );
			$strip	= preg_replace( '/{(.*?)}/', '', $field );
			$id	    = str_replace( ' ', '-', trim( $strip ) );

			$form .= '<li><label for="' . esc_attr( $id ) . '">';
			$form .= '<input type="radio" name="pa-form-option[extras][' . esc_attr( $name ) . ']" value="' . esc_attr( $strip ) . '" id="' . esc_attr( $id ) . '">';

			if ( ! empty( $ccode ) ) :
				$hex	= str_replace( array( '{', '}', '#' ), '', $hexcode[0] );
				$form .= '<span class="pa-color-block" style="background-color:#'.$hex.'">&nbsp;</span>';
			endif;

			$form .= '&nbsp;' . esc_html( $strip ) . '</label></li>';

		else:

			$id	= str_replace( ' ', '-', trim( $field ) );

			$form .= '<li><label for="' . esc_attr( $id ) . '">';
			$form .= '<input type="radio" name="pa-form-option[extras][' . esc_attr( $name ) . ']" value="' . esc_attr( $field ) . '" id="' . esc_attr( $id ) . '">';

			$form .= '&nbsp;' . esc_html( $field ) . '</label></li>';

		endif;

	endforeach;

	$form .= '</ul>';
	$form .= '</div>';

	return $form;
}

/**
 * Render a checkbox field
 *
 * @param  array $field_data  extra field data
 * @param  string $form       form HTML
 * @return string             modified form HTML
 */
function pa_render_checkbox_field( $field_data, $form ) {
	$label	= $field_data['extra-label'];
	$values	= $field_data['extra-value'];

	$fields	= explode( ',', $values );
	$name	= pa_sanitize_extra_field_key( $label );

	$form .= '<div class="pa-field-group pa-checkbox-group">';
	$form .= '<h4>' . esc_html( $label ) . '</h4>';
	$form .= '<ul>';

	foreach ( $fields as $field ):

		$id	= str_replace( ' ', '-', trim( $field ) );

		$form .= '<li><label for="' . esc_attr( $id ) . '">';
		$form .= '<input type="checkbox" name="pa-form-option[extras][' . esc_attr( $name ) . '][]" value="' . esc_attr( $field ) . '" id="' . esc_attr( $id ) . '"> ' . esc_html( $field ) . ' ';
		$form .= '</label></li>';

	endforeach;

	$form .= '</ul>';
	$form .= '</div>';

	return $form;
}

/**
 * Render dropdown field
 *
* @param  array $field_data  extra field data
* @param  string $form       form HTML
* @return string             modified form HTML
 */
function pa_render_dropdown_field( $field_data, $form ) {
	$label	= $field_data['extra-label'];
	$values	= $field_data['extra-value'];

	$fields	= explode( ',', $values );
	$name	= pa_sanitize_extra_field_key( $label );

	$form .= '<div class="pa-field-group pa-select-group">';
	$form .= '<h4>' . esc_html( $label ) . '</h4>';
	$form .= '<ul>';
	$form .= '<li><select class="dropdown" name="pa-form-option[extras][' . esc_attr( $name ) . ']" id="' . esc_attr( $name ) . '">';

	// empty value
	$form .= '<option value="none">(Select)</option>';

	foreach ( $fields as $field ) :

		$form .= '<option value="' . esc_attr( $field ) . '">' . esc_html( $field ) . '</option>';

	endforeach;

	$form .= '</select></li>';
	$form .= '</ul>';
	$form .= '</div>';

	return $form;
}

/**
 * Render text field
 *
 * @param  array $field_data  extra field data
 * @param  string $form       form HTML
 * @return string             modified form HTML
 */
function pa_render_textfield_field( $field_data, $form ) {
	$label	= $field_data['extra-label'];
	$name	= pa_sanitize_extra_field_key( $label );

	$form .= '<div class="pa-field-group pa-text-group">';
	$form .= '<h4>' . esc_html( $label ) . '</h4>';
	$form .= '<ul>';
		$form .= '<li><input type="text" name="pa-form-option[extras][' . esc_attr( $name ) . ']" value="" /></li>';
	$form .= '</ul>';
	$form .= '</div>';

	return $form;
}

/**
 * Sanitize extra field keys
 *
 * Replaces spaces with dashes and calls sanitize_key
 *
 * @param  string $key
 * @return string
 */
function pa_sanitize_extra_field_key( $key ) {
	return sanitize_key( str_replace( ' ', '-', $key ) );
}

/**
 * Get an extra field data array by key
 *
 * Used for getting extra field data from the submitted extra fields
 *
 * @param  string $key
 * @param  array  $calc_data
 * @param  int    $calc_id
 * @return array
 */
function pa_get_extra_field_by_key( $key, $calc_data = array(), $calc_id = null ) {

	// If no data is provided, try to get the data using the calc id
	if ( empty( $calc_data ) ) {
		if ( ! $calc_id ) {
			return array();
		}

		$calc_data = get_post_meta( $calc_id, '_pacalc_data', true );

		if ( ! $calc_data ) {
			return array();
		}
	}

	$extras = $calc_data['extras'];

	foreach ( $extras as $i => $extra ) {
		if ( $key === $extra['extra-key'] ) {
			return $extra;
		}
	}

	return array();
}
