<?php
/* all logging and processing related functions */

// Start up the engine
class PA_Calculator_Logging
{
	/**
	 * Static property to hold our singleton instance
	 * @var PA_Calculator_Logging
	 */
	static $instance = false;

	/**
	 * @var post type name
	 */
	const POST_TYPE = 'pacalc_log';

	/**
	 * @var post type name
	 */
	const ARCHIVE_TYPE = 'pacalc_log_arch';

	/**
	 * @var meta prefix for calculator extra fields
	 */
	const EXTRA_FIELD_PREFIX = '_palog_extra_';

	/**
	 * This is our constructor, which is private to force the use of
	 * getInstance() to make this a Singleton
	 *
	 * @return PA_Calculator_Logging
	 */

	private function __construct() {
		add_action		( 'init',							array( $this, '_register_logs'	) 			);
		add_action		( 'admin_init', 					array( $this, 'export_init'		) 			);
		add_action		( 'wp_ajax_update_log',				array( $this, 'update_log'		)			);
		add_action		( 'wp_ajax_delete_log',				array( $this, 'delete_log'		)			);
		add_action		( 'wp_ajax_archive_log',			array( $this, 'archive_log'		)			);
	}


	/**
	 * If an instance exists, this returns it.  If not, it creates one and
	 * retuns it.
	 *
	 * @return PA_Calculator_Logging
	 */
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * query log file data
	 *
	 * @return PA_Calculator_Logging
	 */
	public function query_logs() {

		$args  = array(
			'fields'		=> 'ids',
			'post_type'		=> 'pacalc_log',
			'nopaging'		=> true,
			'meta_query'	=> array(
				array(
					'key'		=> '_pa_log_archived',
					'value'		=> '',
					'compare'	=> 'NOT EXISTS'
				),
			),
		);

		$logs = get_posts( $args );

		return $logs;

	}

	/**
	 * trigger our export function
	 *
	 * @return PA_Calculator_Logging
	 */
	public function export_init() {

		if ( ! empty( $_GET['page'] ) && 'calculator-log' === $_GET['page'] && ! empty( $_GET['export'] ) ) {
			$this->export();
		}

	}

	/**
	 * create the CSV data
	 *
	 * @return PA_Calculator_Logging
	 */
	public function csv_create( $logfile, $col_sep = ",", $row_sep = "\n", $qut = '"' ) {

		if ( empty( $logfile ) ) {
			return false;
		}

		$output = $this->build_export_header();

		// Data rows
		foreach ( $logfile as $log_id ) :

			$first		= get_post_meta( $log_id, '_palog_first', 		true );
			$last		= get_post_meta( $log_id, '_palog_last', 		true );
			$email		= get_post_meta( $log_id, '_palog_email', 		true );
			$phone		= get_post_meta( $log_id, '_palog_phone', 		true );
			$zipcode	= get_post_meta( $log_id, '_palog_zipcode', 	true );
			$site_id	= get_post_meta( $log_id, '_palog_site_id', 	true );
			$calc_id	= get_post_meta( $log_id, '_palog_calc_id', 	true );
			$user_id	= get_post_meta( $log_id, '_palog_user_id',		true );
			$treats		= get_post_meta( $log_id, '_palog_treatments',	true );
			$doc_ids	= get_post_meta( $log_id, '_palog_doc_ids',		true );
			$doctors	= get_post_meta( $log_id, '_palog_doctors',		true );
			$sms		= get_post_meta( $log_id, '_palog_sms',			true );
			$extras     = $this->get_log_extras( $log_id );
			$notes		= get_post_field( 'post_content', $log_id, 'raw' );

			// some stuff with the date
			$raw_date	= get_post_field( 'post_date', $log_id,	'raw' );
			$raw_stamp	= strtotime( $raw_date );
			$stamp		= pa_zone_adjust( $raw_stamp );
			$stamp		= date( 'M jS Y @ g:ia', $stamp );

			// a check for our special treat calcs
			$treatcalc	= get_post_meta( $log_id, '_pa_log_treatcalc', true );

			// handle calculations based on calculator type (standard or flow )
//			if ( ! empty( $calc_id ) && strpos( $calc_id, 'flow' ) !== false ) {
			if ( ! empty( $treatcalc ) ) {
				$items	= $this->get_item_cpt_data( $treats, 'cost' );
				$totals	= ! empty( $items ) ? array_sum( $items ) : '0';
			} else {
				$treat_ids	= array_values( $treats );
				$logdata	= get_post_meta( $calc_id, '_pacalc_data', true ); // Have to get calc data by CPT
				$totals		= $this->get_item_costs( $logdata, $treats );
			}

			// some cleanup
			$phone		= preg_replace( '/[^0-9]/', '', $phone );

			$doc_ids	= ! empty( $doc_ids ) ? implode( '|', $doc_ids ) : 'none in area';
			$doctors	= ! empty( $doctors ) ? implode( '|', $doctors ) : 'none in area';
			$sms		= $sms == true ? 'success' : $sms;

			$tmp = '';

			// set columns
			$tmp .= "$col_sep$qut$log_id$qut";		// plan ID (which is just log ID)
			$tmp .= "$col_sep$qut$first$qut";		// first name
			$tmp .= "$col_sep$qut$last$qut";		// last name
			$tmp .= "$col_sep$qut$email$qut";		// email
			$tmp .= "$col_sep$qut$phone$qut";		// phone
			$tmp .= "$col_sep$qut$totals$qut";		// total cost
			$tmp .= "$col_sep$qut$zipcode$qut";		// ZIP code
			$tmp .= "$col_sep$qut$site_id$qut";		// site ID
			$tmp .= "$col_sep$qut$calc_id$qut";		// calc ID
			$tmp .= "$col_sep$qut$user_id$qut";		// user ID
			$tmp .= "$col_sep$qut$stamp$qut";		// timestamp
			$tmp .= "$col_sep$qut$doc_ids$qut";		// doctor IDs
			$tmp .= "$col_sep$qut$doctors$qut";		// doctor names
			$tmp .= ! empty( $sms ) ? "$col_sep$qut$sms$qut" : "$col_sep"; // SMS status
			$tmp .= $this->build_export_extras_data_row( $extras, $col_sep, $qut );
			$tmp .= ! empty( $notes ) ? "$col_sep$qut$notes$qut" : "$col_sep";		// notes

			$output .= substr( $tmp, 1 ) . $row_sep;

		endforeach;

		return $output;
	}

	/**
	 * the actual export process
	 *
	 * @return PA_Calculator_Logging
	 */
	public function export() {

		$logfile  = $this->query_logs();
		$basename = 'pa_logfile_' . strftime( '%Y-%m-%d' );

		header( 'Pragma: public' );
		header( 'Cache-control: max-age=0' );
		header( "Content-Type: text/csv; charset=utf8" );
		header( 'Content-Disposition: attachment; filename=' . $basename . '.csv' );

		$create = $this->csv_create( $logfile );

		echo $create;

		exit();

	}

	/**
	 * run a balance check for Clockwork
	 *
	 * @return PA_Calculator_Logging
	 */
	public function sms_balance( $setup ) {

		$apikey = $setup['clockwork-api'];

		if ( ! isset( $apikey ) || isset( $apikey ) && empty( $apikey ) ) {
			return;
		}

		$clockwork	= new WordPressClockwork( $apikey, array( 'ssl' => false ) );
		$return		= $clockwork->checkBalance();

		$balance	= $return['balance'];

		return $balance;

	}


	/**
	 * update any log entries sent
	 *
	 * @return PA_Calculator_Logging
	 */
	public function update_log() {

		$items	= $_POST['items'];

		foreach ( $items as $key => $value ) :

			$update	= array(
				'ID'           => $key,
				'post_content' => esc_attr( $value )
			);

			wp_update_post( $update );

		endforeach;

		$ret['success'] = true;
		$ret['message'] = __( 'Notes updated successfully', 'pac' );
		echo json_encode( $ret );
		die();

	}

	/**
	 * delete any log entries sent
	 *
	 * @return PA_Calculator_Logging
	 */
	public function delete_log() {

		$purge_ids	= $_POST['items'];

		if ( empty( $purge_ids ) ) {
			$ret['success'] 	= false;
			$ret['message'] 	= __( 'No items selected', 'pac' );
			$ret['error']		= __( 'no selected items', 'pac' );
			$ret['errcode']		= 'NOSELECTED';
			echo json_encode( $ret );
			die();
		}

		$purge_ids	= explode( '|', $purge_ids, -1 );

		$logdata	= $this->query_logs();
		$original	= count( $logdata );
		$remove		= count( $purge_ids );
		$remain		= $original - $remove;

		foreach ( $purge_ids as $item_id ) :
			wp_delete_post( $item_id, true );
		endforeach;

		$ret['success'] 	= true;
		$ret['remain']		= $remain;
		$ret['message']		= sprintf( _n( '%d item successfully removed', '%d items successfully removed', $remove, 'pac' ), $remove );
		echo json_encode( $ret );
		die();

	}

	/**
	 * archive any log entries sent
	 *
	 * @return PA_Calculator_Logging
	 */
	public function archive_log() {

		$log_ids	= $_POST['items'];

		if ( empty( $log_ids ) ) {
			$ret['success'] 	= false;
			$ret['message'] 	= __( 'No items selected', 'pac' );
			$ret['error']		= __( 'no selected items', 'pac' );
			$ret['errcode']		= 'NOSELECTED';
			echo json_encode( $ret );
			die();
		}

		$log_ids	= explode( '|', $log_ids, -1 );

		$logdata	= $this->query_logs();
		$original	= count( $logdata );
		$remove		= count( $log_ids );
		$remain		= $original - $remove;

		foreach ( $log_ids as $log_id ) :
			$this->convert_log_to_arch( $log_id );
		endforeach;

		$ret['success'] 	= true;
		$ret['remain']		= $remain;
		$ret['message']		= sprintf( _n( '%d item successfully archived', '%d items successfully archived', $remove, 'pac' ), $remove );
		echo json_encode( $ret );
		die();

	}

	public function convert_log_to_arch( $log_id = 0 ) {

		$archive	= array(
			'ID'		=> $log_id,
			'post_type'	=> 'pacalc_log_arch'
		);

		wp_update_post( $archive );

	}

	/**
	 * take the submission values and log them
	 *
	 * @return PA_Calculator_Logging
	 */
	public function log_submission( $submit, $doctor_ids, $textmsg, $site_id ) {

		// create array of meta
		$user_id	= isset( $submit['user-id'] )		? esc_attr( $submit['user-id'] )					: 0;
		$first		= isset( $submit['first'] )			? esc_attr( $submit['first'] )						: '';
		$last		= isset( $submit['last'] )			? esc_attr( $submit['last'] )						: '';
		$email		= isset( $submit['email'] )			? sanitize_email( $submit['email'] )				: '';
		$phone		= isset( $submit['phone'] )			? preg_replace( '/[^0-9]/', '', $submit['phone'] )	: '';
		$zipcode	= isset( $submit['zip-code'] )		? $submit['zip-code']								: '';
		$condns		= isset( $submit['conditions'] )	? $submit['conditions']								: '';
		$treats		= isset( $submit['treatments'] )	? $submit['treatments']								: array();
		$textmsg	= isset( $textmsg )					? $textmsg											: '';
		$calc_id	= isset( $submit['calc_id'] )		? $submit['calc_id']								: '';
		$extras 	= isset( $submit['extras'] )		? $submit['extras']									: '';

		// get doctor data based on IDs passed
		if ( $doctor_ids ):

			$base	= PA_Calculator::getInstance();

			foreach ( $doctor_ids as $doctor_id ):
				$item	= $base->api_doctor_data( $doctor_id, $site_id );
				// grab user id first
				$doc_ids[]	= $item->UserId;
				$doctors[]	= $item->DisplayName;
			endforeach;

		// set fields for empty return to keep array in consistent order
		else:
			$doc_ids	= array();
			$doctors	= array();
		endif;

		$extras_meta	= array();

		// Build extra field meta
		if ( ! empty( $extras ) ) {
			$extras_meta = $this->build_log_extras_meta( $extras );
		}

		// some stuff with the date
		$stamp		= time();
		$adjust		= pa_zone_adjust( $stamp );
		$local		= date('Y-m-d H:i:s', $stamp );
		$gmt		= date('Y-m-d H:i:s', $adjust );

		// create entry data
		$log_args  = array(
			'post_type'     	=> self::POST_TYPE,
			'post_title'    	=> $stamp,
			'post_name'     	=> $stamp,
			'post_content'  	=> '',
			'post_status'   	=> 'publish',
			'comment_status'	=> 'closed',
			'post_date'     	=> $local,
			'post_date_gmt' 	=> $gmt,
			'menu_order'		=> 0
		);

		// create the new log entry item
		$logentry = wp_insert_post( $log_args, true );

		if ( ! is_wp_error( $logentry ) ) {

			update_post_meta( $logentry, '_palog_user_id',		$user_id	);
			update_post_meta( $logentry, '_palog_first',		$first		);
			update_post_meta( $logentry, '_palog_last',			$last		);
			update_post_meta( $logentry, '_palog_email',		$email		);
			update_post_meta( $logentry, '_palog_phone',		$phone		);
			update_post_meta( $logentry, '_palog_zipcode',		$zipcode	);
			update_post_meta( $logentry, '_palog_site_id',		$site_id	);
			update_post_meta( $logentry, '_palog_calc_id',		$calc_id	);
			update_post_meta( $logentry, '_palog_conditions',	$condns		);
			update_post_meta( $logentry, '_palog_treatments',	$treats		);
			update_post_meta( $logentry, '_palog_doc_ids',		$doc_ids	);
			update_post_meta( $logentry, '_palog_doctors',		$doctors	);
			update_post_meta( $logentry, '_palog_sms',			$textmsg	);

			if ( ! empty( $extras_meta ) ) {
				foreach ( $extras_meta as $extra_key => $extra_value ) {
					update_post_meta( $logentry, $extra_key, $extra_value );
				}
			}

		}

		return $logentry;

	}

	/**
	 * get total list cost
	 *
	 * @return PA_Calculator_Logging
	 */
	public function get_item_costs( $logdata, $treat_ids ) {

		if ( ! is_array( $treat_ids ) ) {
			return 0;
		}

		$item_costs	= array();

		foreach ( $treat_ids as $treat_id ) :
			$item_costs[] = $logdata['calc-fields'][ $treat_id]['calc-cost'];
		endforeach;

		$total_cost	= array_sum( $item_costs );

		return $total_cost;
	}

	/**
	 * get total list cost from the CPT
	 *
	 * @return PA_Calculator_Logging
	 */
	public function get_item_cpt_data( $treatments, $field = 'cost' ) {

		if ( ! is_array( $treatments ) || empty( $treatments ) ) {
			return 0;
		}

		$treatments	= call_user_func_array( 'array_merge_recursive', $treatments );

		$data		= wp_list_pluck( $treatments, $field );

		// return what we have
		return $data;

	}

	/**
	 * display the log table
	 *
	 * @return PA_Calculator_Logging
	 */
	public function log_table_display() {

		$setup		= get_option( 'pacalc_settings' );

		$logfile	= $this->query_logs();

		if ( empty ( $logfile ) ) :

			echo '<p>No data available at this time.</p>';
			return;

		endif;

		$totals	= count( $logfile );

		$bal_amt	= $this->sms_balance( $setup );
		$alert		= isset( $setup['sms-alert'] ) ? $setup['sms-alert'] : 10;
		$balance	= ! empty( $bal_amt ) && $bal_amt > $alert ? '<span class="balance-good">$' . esc_html( $bal_amt ) . '</span>' : '<span class="balance-low">$' . esc_html( $bal_amt ) . '</span>';
		?>
			<div class="action-row">
				<p class="log-counts log-data"><?php _e( 'Total Items Logged:', 'pac' ); ?> <span class="count-num"><?php echo $totals; ?></span></p>
				<p class="log-balance log-data"><?php _e( 'SMS Balance:', 'pac' ); ?> <?php echo $balance; ?></p>
				<p class="log-actions">
					<img class="ajax-process delete-process" src="<?php echo plugins_url( '/img/wpspin-light.gif', __FILE__ ); ?>" >
					<input type="button" class="button button-primary log-delete" value="Archive Checked Items">
					<a class="button button-secondary log-export" href="<?php echo add_query_arg( array( 'export' => 1 ), menu_page_url( 'calculator-log', false ) ); ?>"><?php _e( 'Export Log File', 'pac' ); ?></a>
					<img class="ajax-process update-process" src="<?php echo plugins_url( '/img/wpspin-light.gif', __FILE__ ); ?>" >
					<input type="button" class="button button-secondary log-update" value="Update Logs">
				</p>
			</div>
			<table id="pa-logfile-table" class="wp-list-table widefat fixed posts">
				<thead>
				<tr>
					<th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" class="log-all"></th>
					<th class="manage-column column-log-id" scope="col">ID</th>
					<th class="manage-column column-log-date" scope="col">Log Date</th>
					<th class="manage-column column-send-name" scope="col">Name</th>
					<th class="manage-column column-send-phone" scope="col">Phone</th>
					<th class="manage-column column-send-email" scope="col">Email</th>
					<th class="manage-column column-zip-code" scope="col">Zip Code</th>
					<th class="manage-column column-treatment-areas" scope="col">Treatments</th>
					<th class="manage-column column-treatment-costs" scope="col">Total Cost</th>
					<th class="manage-column column-docs" scope="col">Doctors</th>
					<th class="manage-column column-sms-status" scope="col">SMS</th>
					<th class="manage-column column-calc-id" scope="col">Calc ID</th>
					<th class="manage-column column-user-id" scope="col">User ID</th>
					<?php // $this->build_log_table_header_extras(); ?>
					<th class="manage-column column-notes" scope="col">Notes</th>
					<th class="manage-column column-extras" scope="col">Extras</th>
				</tr>
				</thead>

				<tfoot>
				<tr>
					<th class="manage-column column-cb check-column" scope="col"><input type="checkbox" class="log-all"></th>
					<th class="manage-column column-log-id" scope="col">ID</th>
					<th class="manage-column column-log-date" scope="col">Log Date</th>
					<th class="manage-column column-send-name" scope="col">Name</th>
					<th class="manage-column column-send-phone" scope="col">Phone</th>
					<th class="manage-column column-send-email" scope="col">Email</th>
					<th class="manage-column column-zip-code" scope="col">Zip Code</th>
					<th class="manage-column column-treatment-areas" scope="col">Treatments</th>
					<th class="manage-column column-treatment-costs" scope="col">Total Cost</th>
					<th class="manage-column column-docs" scope="col">Doctors</th>
					<th class="manage-column column-sms-status" scope="col">SMS</th>
					<th class="manage-column column-calc-id" scope="col">Calc ID</th>
					<th class="manage-column column-user-id" scope="col">User ID</th>
					<?php // $this->build_log_table_header_extras(); ?>
					<th class="manage-column column-notes" scope="col">Notes</th>
					<th class="manage-column column-extras" scope="col">Extras</th>
				</tr>
				</tfoot>

				<tbody id="the-list" class="pa-logging-table-list">
				<?php
				$i = 0;

				foreach ( $logfile as $item_id ):

					$user_id	= get_post_meta( $item_id, '_palog_user_id', 	true );
					$first		= get_post_meta( $item_id, '_palog_first', 		true );
					$last		= get_post_meta( $item_id, '_palog_last', 		true );
					$email		= get_post_meta( $item_id, '_palog_email', 		true );
					$phone		= get_post_meta( $item_id, '_palog_phone', 		true );
					$zipcode	= get_post_meta( $item_id, '_palog_zipcode', 	true );
					$site_id	= get_post_meta( $item_id, '_palog_site_id', 	true );
					$calc_id	= get_post_meta( $item_id, '_palog_calc_id', 	true );
					$treats		= get_post_meta( $item_id, '_palog_treatments',	true );
					$doc_ids	= get_post_meta( $item_id, '_palog_doc_ids',	true );
					$doctors	= get_post_meta( $item_id, '_palog_doctors',	true );
					$sms_stat	= get_post_meta( $item_id, '_palog_sms',		true );

					$notes		= get_post_field( 'post_content',	$item_id,	'raw' );

					// format our phone
					$phone		= ! empty( $phone ) && function_exists( 'pg_format_phone' ) ? pg_format_phone( $phone ) : $phone;

					// extras
					$extras = $this->get_log_extras( $item_id );

					// some stuff with the date
					$raw_date	= get_post_field( 'post_date', $item_id,	'raw' );
					$raw_stamp	= strtotime( $raw_date );
					$stamp		= pa_zone_adjust( $raw_stamp );
					$stampdate	= date( 'M jS Y', $stamp );
					$stamptime	= date( 'g:ia', $stamp );

					// some links
					$loglink	= home_url( '/match/?planID=' . $item_id );

					// a check for our special treat calcs
					$treatcalc	= get_post_meta( $item_id, '_pa_log_treatcalc', true );

					// handle calculations based on calculator type (standard or flow )
//					if ( ! empty( $calc_id ) && strpos( $calc_id, 'flow' ) !== false || ! empty( $treatcalc ) ) {
					if ( ! empty( $treatcalc ) ) {
						$item_costs	= $this->get_item_cpt_data( $treats, 'cost' );
						$treat_cost	= ! empty( $item_costs ) ? array_sum( $item_costs ) : '0';
					} else {
						$treat_ids	= array_values( $treats );
						$logdata	= get_post_meta( $calc_id, '_pacalc_data', true ); // Have to get calc data by CPT
						$treat_cost	= $this->get_item_costs( $logdata, $treat_ids );
					}

					// handle treatment listing based on calculator type (standard or flow )
//					if ( ! empty( $calc_id ) && strpos( $calc_id, 'flow' ) !== false || ! empty( $treatcalc )  ) {
					if ( ! empty( $treatcalc ) ) {
						$treat_area	= $this->get_item_cpt_data( $treats, 'title' );
					} else {
						$treat_area	= array_keys( $treats );
					}

					$doctors	= isset( $doctors ) && ! empty( $doctors ) ? formatList( array_values( $doctors ) ) : '<em>none in area</em>';
					$notes		= isset( $notes )	? esc_attr( $notes ) : '';

					// display for the SMS
					$sms		= $sms_stat == 'success' ? '<i class="dashicons dashicons-yes sms-yes"></i>' : $sms_stat;

					$side = empty( $side ) || $side == 'standard' ? 'alternate' : 'standard';

					echo '<tr class="pa-log-item ' . $side . '" valign="top" data-num="' . $item_id . '" >';
						echo '<th class="check-column">';
							echo '<input type="checkbox" class="log-check" name="cb-select-' . $item_id . '">';
						echo '</th>';
						echo '<td class="column-log-id"><a target="_blank" href="' . esc_url( $loglink ) . '">' . $item_id . '</a></td>';
						echo '<td class="column-log-date">' . $stampdate . '<br />' . $stamptime . '</td>';
						echo '<td class="column-send-name">' . $first . ' ' . $last . '</td>';
						echo '<td class="column-send-phone">' . $phone . '</td>';
						echo '<td class="column-send-email">' . $email . '</td>';
						echo '<td class="column-zip-code">' . $zipcode . '</td>';
						echo '<td class="column-treatment-areas">' . formatList( $treat_area ) . '</td>';
						echo '<td class="column-treatment-costs">$' . formatItems( $treat_cost ) . '</td>';
						echo '<td class="column-treatment-docs">' . $doctors . '</td>';
						echo '<td class="column-sms-status">' . $sms . '</td>';
						echo '<td class="column-calc-id">';
						if ( is_numeric( $calc_id ) ) {
							echo '<a title="Edit calculator" href="' . get_edit_post_link( $calc_id ) . '">' . $calc_id . '</a>';
						} else {
							echo $calc_id;
						}
						echo '</td>';

						echo '<td class="column-user-id">';
						if ( ! empty( $user_id ) ) {
							echo '<a title="Edit user profile" href="' . get_edit_user_link( $user_id ) . '">' . $user_id . '</a>';
						} else {
							echo 'visitor';
						}
						echo '</td>';

						echo '<td class="column-treatment-notes">';
							echo '<div><textarea tabindex="80' . esc_attr( $i ) . '" class="notes-input">' . esc_textarea( $notes ) . '</textarea></div>';
						echo '</td>';
						echo '<td class="column-extras">';
							echo '<span class="dashicons dashicons-download view-log-extras"></span>';
							echo '<div class="extras-display">';
							$this->build_log_table_data_extras_list( $extras );
							echo '</div>';
						echo '</td>';
					echo '</tr>';

				$i++;
				endforeach; ?>
				</tbody>
			</table>
		<?php
	}

	/**
	 * Build cells for Log Table Header Row
	 *
	 * @return void
	 */
	protected function build_log_table_header_extras() {
		$header_extras = $this->get_calcs_extra_fields();

		foreach ( $header_extras as $key => $field ) {
			$class = 'extra-' . str_replace( '_', '-', $key );
			echo '<th class="manage-column column-' . esc_attr( $class ) . '" scope="col">' . esc_html( $field['label'] ) . '</th>';
		}
	}

	/**
	 * Build cells for Log Table Data Rows
	 *
	 * @param  array $extras
	 * @return void
	 */
	protected function build_log_table_data_extras( $extras ) {
		$sitewide_extras = $this->get_calcs_extra_fields();

		foreach ( $sitewide_extras as $key => $field ) {
			$class = 'extra-' . str_replace( '_', '-', $key );
			if ( ! empty( $extras[ self::EXTRA_FIELD_PREFIX . $key ] ) ) {
				$value = $extras[ self::EXTRA_FIELD_PREFIX . $key ];
				echo '<td class="column-' . esc_attr( $class ) . '">';
				if ( is_array( $value ) ) {
					echo formatList( $value );
				} else {
					echo $value;
				}
				echo '</td>';
			} else {
				echo '<td class="column-' . esc_attr( $class ) . '"></td>';
			}
		}
	}

	/**
	 * Build list items for Log Table Data Rows
	 *
	 * @param  array $extras
	 * @return void
	 */
	protected function build_log_table_data_extras_list( $extras ) {
		$sitewide_extras = $this->get_calcs_extra_fields();

		echo '<table><tbody>';
			echo '<tr class="extras-title-row">';
				echo '<td class="extras-item-label">Question</td>';
				echo '<td class="extras-item-data">Response</td>';
			echo '</tr>';
			if ( $sitewide_extras ) {
				foreach ( $sitewide_extras as $key => $field ) {

					// stripe the display
					$stripe = empty( $stripe ) || $stripe == 'extras-item-standard' ? 'extras-item-alternate' : 'extras-item-standard';
					// check for some keys
					if ( ! empty( $extras[ self::EXTRA_FIELD_PREFIX . $key ] ) ) {
						// pull the value
						$value = $extras[ self::EXTRA_FIELD_PREFIX . $key ];
						// don't display unless a value is present
						if ( empty( $value ) ) {
							continue;
						}
						// set up the table row
						echo '<tr class="extras-item-row ' . $stripe . '">';
							echo '<td class="extras-item-label">' . esc_html( $field['label'] ) . '</td>';
							echo '<td class="extras-item-data">';
							// display based on type
							if ( is_array( $value ) ) {
								echo formatList( $value );
							} else {
								echo $value;
							}
							echo '</td>';
						echo '</tr>';
					}
				}
			}
		echo '</tbody></table>';
	}

	/**
	 * Sanitize extra keys for use as post meta keys
	 *
	 * @param  string $key
	 * @return string
	 */
	protected function sanitze_extra_meta_key( $key ) {
		return str_replace( '-', '_', $key );
	}

	/**
	 * Build an array of post meta keys and values based on the extras inputs
	 *
	 * @param  array $extras
	 * @return array
	 */
	protected function build_log_extras_meta( $extras ) {
		$meta = array();

		foreach ( $extras as $key => $value ) {
			$sanitized_key = self::EXTRA_FIELD_PREFIX . $this->sanitze_extra_meta_key( $key );
			$meta[ $sanitized_key ] = $value;
		}

		return $meta;
	}

	/**
	 * Get the extra fields for each log item
	 *
	 * Stored as post meta, unseralize multiple items as necessary
	 *
	 * @param  int $log_id
	 * @return array
	 */
	protected function get_log_extras( $log_id ) {
		$meta = get_post_custom( $log_id );

		if ( ! $meta ) {
			return array();
		}

		$extras = array();

		// Slice off any "extras" meta keys into a separate array
		// if the value is an array it may be serialized
		foreach ( $meta as $key => $value ) {
			if ( false !== strpos( $key, self::EXTRA_FIELD_PREFIX ) ) {
				$single_value = $value[0];
				$extras[ $key ] = maybe_unserialize( $single_value );
			}
		}

		return $extras;
	}

	/**
	 * Get all extra fields from all of a site's calculators
	 *
	 * @return array
	 */
	public function get_calcs_extra_fields() {

		if ( false === get_transient( 'pg_all_extra_fields' ) ) {

			// Get all calculator ids
			$calcs = PA_Calculator_Calc::get_all_ids();

			// set empty arrays
			$extras = array();

			// Get calculator extra fields
			foreach ( $calcs as $calc_id ) {
				$calc_data		= get_post_meta( $calc_id, '_pacalc_data', true );
				// Sanitize the extra field key and add to our list if it doesn't already exist
				if ( isset( $calc_data['extras'] ) && ! empty( $calc_data['extras'] ) ) {
					foreach ( $calc_data['extras'] as $extra ) {
						$sanitized_key = $this->sanitze_extra_meta_key( $extra['extra-key'] );
						if ( ! in_array( $sanitized_key, $extras ) ) {
							$extras[ $sanitized_key ] = array(
								'label' => $extra['extra-label'],
							);
						}
					}
				}
			}

			// filter to allow add ons
			$extras	= apply_filters( 'pa_calc_extra_fields', $extras );

			set_transient( 'pg_all_extra_fields', $extras, WEEK_IN_SECONDS );
		}

		$extras = get_transient( 'pg_all_extra_fields' );

		return $extras;
	}

	/**
	 * Format Header title for an extra field
	 *
	 * @param  string $label
	 * @return string
	 */
	protected function format_extra_field_export_header( $label ) {
		return preg_replace( '/[^a-z0-9_-]/i', '', ucwords( $label ) );
	}

	/**
	 * Build the header row for a CSV export
	 *
	 * @return string
	 */
	protected function build_export_header() {
		$fields = $this->get_calcs_extra_fields();

		foreach ( $fields as $key => $field ) {
			$extras[] = '"' . $this->format_extra_field_export_header( $field['label'] ) . '"';
		}

		// Header row
		$output = '"PlanID",FirstName","LastName","Email","Phone","TotalCost","ZIP","SiteID","CalcID","UserID","Timestamp","DoctorIDs","DoctorNames","SMS",' . join( ',', $extras ) . ',"Notes"'."\n";
		return $output;
	}

	/**
	 * Build data row columns for all extra fields
	 *
	 * @param  array $extras
	 * @param  string $col_sep
	 * @param  string $qut
	 * @return string
	 */
	protected function build_export_extras_data_row( $extras, $col_sep = ",", $qut = '"' ) {
		$sitewide_extras = $this->get_calcs_extra_fields();
		$output = '';

		foreach ( $sitewide_extras as $key => $field ) {
			if ( ! empty( $extras[ self::EXTRA_FIELD_PREFIX . $key ] ) ) {
				$value = $extras[ self::EXTRA_FIELD_PREFIX . $key ];

				if ( is_array( $value ) ) {
					$output .= ! empty( $value ) ? $col_sep . $qut . implode( '|', $value ) . $qut : "$col_sep";
				} else {
					$output .= "$col_sep$qut$value$qut";
				}
			} else {
				$output .= "$col_sep";
			}
		}

		return $output;
	}

	/**
	 * build out post type for log files
	 *
	 * @return PA_Calculator_Logging
	 */
	public function _register_logs() {

		register_post_type( self::POST_TYPE,
			array(
				'label'					=> 'Calculator Logs',
				'public'				=> false,
				'show_in_nav_menus'		=> false,
				'show_ui'				=> false,
				'publicly_queryable'	=> false,
				'exclude_from_search'	=> true,
				'hierarchical'			=> false,
				'menu_position'			=> null,
				'capability_type'		=> 'post',
				'query_var'				=> true,
				'rewrite'				=> false,
				'has_archive'			=> false,
				'supports'				=> false
			)
		);

		register_post_type( self::ARCHIVE_TYPE,
			array(
				'label'					=> 'Calculator Logs Archives',
				'public'				=> false,
				'show_in_nav_menus'		=> false,
				'show_ui'				=> false,
				'publicly_queryable'	=> false,
				'exclude_from_search'	=> true,
				'hierarchical'			=> false,
				'menu_position'			=> null,
				'capability_type'		=> 'post',
				'query_var'				=> false,
				'rewrite'				=> false,
				'has_archive'			=> false,
				'supports'				=> false
			)
		);



	}

} /// end class


// Instantiate our class
$PA_Calculator_Logging = PA_Calculator_Logging::getInstance();
