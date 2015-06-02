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

	if ( !is_array( $array ) )
		return;

	foreach ( $array as $item ):
		$data[] = '<li>'.$item.'</li>';
	endforeach;

	$data = implode( '', $data );

	return $data;

}

/**
 * helper function to run checks on timestamps and adjust for timezones
 *
 */
function pa_zone_adjust($stamp) {

	$string	= get_option('timezone_string');

	if ( empty( $string ) ) :
		$utc	= get_option('gmt_offset');
		$zone	= $utc * 3600;
	endif;

	if ( !empty( $string ) ) :
		$zone	= new DateTimeZone($string);
		$zone	= $zone->getOffset(new DateTime);
	endif;

	$zone	= $zone * -1;

	$adjusted = $stamp - $zone;

	return $adjusted;

}

/**
 * helper function to sort based on timestamp
 *
 */
function pa_stamp_sort($a, $b) {
	return strcmp( $a['stamp'], $b['stamp'] );
}