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
	 * This is our constructor, which is private to force the use of
	 * getInstance() to make this a Singleton
	 *
	 * @return PA_Calculator_Logging
	 */

	private function __construct() {
		add_action		( 'init',							array( $this, '_register_log'	) 			);
		add_action		( 'admin_init', 					array( $this, 'export_init'		) 			);
		add_action		( 'wp_ajax_update_log',				array( $this, 'update_log'		)			);
		add_action		( 'wp_ajax_delete_log',				array( $this, 'delete_log'		)			);
	}


	/**
	 * If an instance exists, this returns it.  If not, it creates one and
	 * retuns it.
	 *
	 * @return PA_Calculator_Logging
	 */

	public static function getInstance() {
		if ( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}

	/**
	 * query log file data
	 *
	 * @return PA_Calculator_Logging
	 */

	public function query_logs() {

		$args  = array(
			'fields'	=> 'ids',
			'post_type'	=> 'pacalc_log',
			'nopaging'	=> true
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

		if( !empty($_GET['page']) && $_GET['page'] === 'calculator-log' && !empty( $_GET['export'] ) )

		$this->export();

	}

	/**
	 * create the CSV data
	 *
	 * @return PA_Calculator_Logging
	 */

	public function csv_create( $logfile, $col_sep = ",", $row_sep = "\n", $qut = '"') {

		if ( empty( $logfile ) )
			return false;

		// settings data to grab cost info
		$logdata	= get_option('pacalc');

		//Header row.
		$output = '"FirstName","LastName","Email","Phone","TotalCost","ZIP","SiteID","Timestamp","DoctorIDs","DoctorNames","SMS","Notes"'."\n";

		//Data rows.
		foreach ( $logfile as $log_id ) :

			$first		= get_post_meta( $log_id, '_palog_first', 		true );
			$last		= get_post_meta( $log_id, '_palog_last', 		true );
			$email		= get_post_meta( $log_id, '_palog_email', 		true );
			$phone		= get_post_meta( $log_id, '_palog_phone', 		true );
			$zipcode	= get_post_meta( $log_id, '_palog_zipcode', 	true );
			$site_id	= get_post_meta( $log_id, '_palog_site_id', 	true );
			$treats		= get_post_meta( $log_id, '_palog_treatments',	true );
			$doc_ids	= get_post_meta( $log_id, '_palog_doc_ids',		true );
			$doctors	= get_post_meta( $log_id, '_palog_doctors',		true );
			$sms		= get_post_meta( $log_id, '_palog_sms',			true );

			$notes		= get_post_field( 'post_content',	$log_id,	'raw' );

			// some stuff with the date
			$raw_date	= get_post_field( 'post_date',		$log_id,	'raw' );
			$raw_stamp	= strtotime( $raw_date );
			$stamp		= pa_zone_adjust( $raw_stamp );
			$stamp		= date( 'M jS Y @ g:ia', $stamp );


			// some cleanup
			$phone		= preg_replace( '/[^0-9]/', '', $phone );

			$totals		= $this->get_item_costs( $logdata, $treats );
			$doc_ids	= !empty( $doc_ids ) ? implode( '|', $doc_ids ) : 'none in area';
			$doctors	= !empty( $doctors ) ? implode( '|', $doctors ) : 'none in area';
			$sms		= $sms == true? 'success' : $sms;

			$tmp = '';

			// set columns
			$tmp .= "$col_sep$qut$first$qut";		// first name
			$tmp .= "$col_sep$qut$last$qut";		// last name
			$tmp .= "$col_sep$qut$email$qut";		// email
			$tmp .= "$col_sep$qut$phone$qut";		// phone
			$tmp .= "$col_sep$qut$totals$qut";		// total cost
			$tmp .= "$col_sep$qut$zipcode$qut";		// ZIP code
			$tmp .= "$col_sep$qut$site_id$qut";		// site ID
			$tmp .= "$col_sep$qut$stamp$qut";		// timestamp
			$tmp .= "$col_sep$qut$doc_ids$qut";		// doctor IDs
			$tmp .= "$col_sep$qut$doctors$qut";		// doctor names
			$tmp .= "$col_sep$qut$sms$qut";			// SMS status
			$tmp .= "$col_sep$qut$notes$qut";		// notes

			$output .= substr($tmp, 1).$row_sep;

		endforeach;

	return $output;
	}

	/**
	 * the actual export process
	 *
	 * @return PA_Calculator_Logging
	 */

	public function export() {

		$logfile	= $this->query_logs();

	    $basename	= ('pa_logfile_'.strftime('%Y-%m-%d'));

	    header('Pragma: public');
	    header('Cache-control: max-age=0');
	    header("Content-Type: text/csv; charset=utf8");
	    header('Content-Disposition: attachment; filename='.$basename.'.csv');

	    $create		= $this->csv_create( $logfile );

	    echo $create;

		exit();

	}

	/**
	 * run a balance check for Clockwork
	 *
	 * @return PA_Calculator_Logging
	 */

	public function sms_balance( $setup ) {

		$apikey		= $setup['clockwork-api'];

		if ( !isset( $apikey ) || isset( $apikey ) && empty( $apikey ) )
			return;

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

		$ret['success'] 	= true;
		$ret['message']		= __('Notes updated successfully', 'pac');
		echo json_encode($ret);
		die();

	}

	/**
	 * delete any log entries sent
	 *
	 * @return PA_Calculator_Logging
	 */

	public function delete_log() {

		$purge_ids	= $_POST['items'];

		if( empty( $purge_ids ) ) {
			$ret['success'] 	= false;
			$ret['message'] 	= __('No items selected', 'pac');
			$ret['error']		= __('no selected items', 'pac');
			$ret['errcode']		= 'NOSELECTED';
			echo json_encode($ret);
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
		$ret['message']		= sprintf( _n('%d item successfully removed', '%d items successfully removed', $remove, 'pac'), $remove );
		echo json_encode($ret);
		die();

	}


	/**
	 * take the submission values and log them
	 *
	 * @return PA_Calculator_Logging
	 */

	public function log_submission( $submit, $doctor_ids, $textmsg, $site_id ) {

		// create array of meta
		$first		= isset( $submit['first'] )			? esc_attr( $submit['first'] )						: '';
		$last		= isset( $submit['last'] )			? esc_attr( $submit['last'] )						: '';
		$email		= isset( $submit['email'] )			? sanitize_email( $submit['email'] )				: '';
		$phone		= isset( $submit['phone'] )			? preg_replace( '/[^0-9]/', '', $submit['phone'] )	: '';
		$zipcode	= isset( $submit['zip-code'] )		? $submit['zip-code']								: '';
		$treats		= isset( $submit['treatments'] )	? $submit['treatments']								: array();
		$textmsg	= isset( $textmsg )					? $textmsg											: '';

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

		// some stuff with the date
		$stamp		= time();
		$adjust		= pa_zone_adjust( $stamp );
		$local		= date('Y-m-d H:i:s', $stamp );
		$gmt		= date('Y-m-d H:i:s', $adjust );

		// create entry data
		$log_args  = array(
			'post_type'     	=> 'pacalc_log',
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

		if ( !is_wp_error( $logentry ) ) {

			update_post_meta( $logentry, '_palog_first',		$first		);
			update_post_meta( $logentry, '_palog_last',			$last		);
			update_post_meta( $logentry, '_palog_email',		$email		);
			update_post_meta( $logentry, '_palog_phone',		$phone		);
			update_post_meta( $logentry, '_palog_zipcode',		$zipcode	);
			update_post_meta( $logentry, '_palog_site_id',		$site_id	);
			update_post_meta( $logentry, '_palog_treatments',	$treats		);
			update_post_meta( $logentry, '_palog_doc_ids',		$doc_ids	);
			update_post_meta( $logentry, '_palog_doctors',		$doctors	);
			update_post_meta( $logentry, '_palog_sms',			$textmsg	);

		}

		return;

	}

	/**
	 * get total list cost
	 *
	 * @return PA_Calculator_Logging
	 */

	public function get_item_costs( $logdata, $treat_ids ) {

		if ( !is_array( $treat_ids ) )
			return 0;

		foreach ( $treat_ids as $treat_id ):
			$item_costs[] = $logdata['calc-fields'][$treat_id]['calc-cost'];
		endforeach;

		$total_cost	= array_sum( $item_costs );

		return $total_cost;
	}

	/**
	 * display the log table
	 *
	 * @return PA_Calculator_Logging
	 */

	public function log_table_display() {

		$setup		= get_option('pacalc_settings');

		$logdata	= get_option('pacalc');
		$logfile	= $this->query_logs();

		if ( empty ( $logfile ) ) :

			echo '<p>No data available at this time.</p>';
			return;

		endif;

		$totals	= count( $logfile );

		$bal_amt	= $this->sms_balance( $setup );
		$alert		= isset( $setup['sms-alert'] ) ? $setup['sms-alert'] : 10;
		$balance	= !empty( $bal_amt ) && $bal_amt > $alert ? '<span class="balance-good">$'.$bal_amt.'</span>' : '<span class="balance-low">$'.$bal_amt.'</span>';

		?>
			<div class="action-row">
				<p class="log-counts log-data"><?php _e('Total Items Logged:', 'pac') ?> <span class="count-num"><?php echo $totals; ?></span></p>
				<p class="log-balance log-data"><?php _e('SMS Balance:', 'pac') ?> <?php echo $balance; ?></p>
				<p class="log-actions">
					<img class="ajax-process delete-process" src="<?php echo plugins_url('/img/wpspin-light.gif', __FILE__); ?>" >
					<input type="button" class="button button-primary log-delete" value="Delete Checked Items">
					<a class="button button-secondary log-export" href="<?php menu_page_url( 'calculator-log' ); ?>&amp;export=1"><?php _e('Export Log File', 'pac') ?></a>
					<img class="ajax-process update-process" src="<?php echo plugins_url('/img/wpspin-light.gif', __FILE__); ?>" >
					<input type="button" class="button button-secondary log-update" value="Update Logs">
				</p>
			</div>
			<table id="pa-logfile-table" class="wp-list-table widefat fixed posts">
				<thead>
				<tr>
					<th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" class="log-all"></th>
					<th class="manage-column column-log-id" scope="col">ID</th>
					<th class="manage-column column-proc-date" scope="col">Processed Date</th>
					<th class="manage-column column-send-name" scope="col">Name</th>
					<th class="manage-column column-send-phone" scope="col">Phone</th>
					<th class="manage-column column-send-email" scope="col">Email</th>
					<th class="manage-column column-zip-code" scope="col">Zip Code</th>
					<th class="manage-column column-treatment-areas" scope="col">Treatment Areas</th>
					<th class="manage-column column-treatment-costs" scope="col">Treatment Cost</th>
					<th class="manage-column column-docs" scope="col">Doctors</th>
					<th class="manage-column column-sms-status" scope="col">SMS</th>
					<th class="manage-column column-notes" scope="col">Notes</th>
				</tr>
				</thead>

				<tfoot>
				<tr>
					<th class="manage-column column-cb check-column" scope="col"><input type="checkbox" class="log-all"></th>
					<th class="manage-column column-log-id" scope="col">ID</th>
					<th class="manage-column column-proc-date" scope="col">Processed Date</th>
					<th class="manage-column column-send-name" scope="col">Name</th>
					<th class="manage-column column-send-phone" scope="col">Phone</th>
					<th class="manage-column column-send-email" scope="col">Email</th>
					<th class="manage-column column-zip-code" scope="col">Zip Code</th>
					<th class="manage-column column-treatment-areas" scope="col">Treatment Areas</th>
					<th class="manage-column column-treatment-costs" scope="col">Treatment Cost</th>
					<th class="manage-column column-docs" scope="col">Doctors</th>
					<th class="manage-column column-sms-status" scope="col">SMS</th>
					<th class="manage-column column-docs" scope="col">Notes</th>
				</tr>
				</tfoot>

				<tbody id="the-list">
				<?php
				$i = 0;
				foreach ( $logfile as $item_id ):

					$first		= get_post_meta( $item_id, '_palog_first', 		true );
					$last		= get_post_meta( $item_id, '_palog_last', 		true );
					$email		= get_post_meta( $item_id, '_palog_email', 		true );
					$phone		= get_post_meta( $item_id, '_palog_phone', 		true );
					$zipcode	= get_post_meta( $item_id, '_palog_zipcode', 	true );
					$site_id	= get_post_meta( $item_id, '_palog_site_id', 	true );
					$treats		= get_post_meta( $item_id, '_palog_treatments',	true );
					$doc_ids	= get_post_meta( $item_id, '_palog_doc_ids',	true );
					$doctors	= get_post_meta( $item_id, '_palog_doctors',	true );
					$sms_stat	= get_post_meta( $item_id, '_palog_sms',		true );

					$notes		= get_post_field( 'post_content',	$item_id,	'raw' );

					// some stuff with the date
					$raw_date	= get_post_field( 'post_date',		$item_id,	'raw' );
					$raw_stamp	= strtotime( $raw_date );
					$stamp		= pa_zone_adjust( $raw_stamp );
					$stamp		= date( 'M jS Y @ g:ia', $stamp );

					// handle calculations
					$treat_ids	= array_values( $treats );
					$treat_cost	= $this->get_item_costs( $logdata, $treat_ids );

					$treat_area	= array_keys( $treats );

					$doctors	= isset( $doctors ) && !empty( $doctors ) ? formatList( array_values( $doctors ) ) : '<em>none in area</em>';
					$notes		= isset( $notes )	? esc_attr( $notes ) : '';

					// display for the SMS
					$sms		= $sms_stat == 'success' ? '<img class="sms-yes" src="'.plugins_url('img/meta-yes.png', __FILE__).'">' : $sms_stat;

					$side = empty($side) || $side == 'standard' ? 'alternate' : 'standard';

					echo '<tr class="pa-log-item '.$side.'" valign="top" data-num="'.$item_id.'" >';
						echo '<th class="check-column">';
							echo '<input type="checkbox" class="log-check" name="cb-select-'.$item_id.'">';
						echo '</th>';
						echo '<td class="column-log-id">'.$item_id.'</td>';
						echo '<td class="column-proc-date">'.$stamp.'</td>';
						echo '<td class="column-send-name">'.$first.' '.$last.'</td>';
						echo '<td class="column-send-phone">'.preg_replace( '/[^0-9]/', '', $phone ).'</td>';
						echo '<td class="column-send-email">'.$email.'</td>';
						echo '<td class="column-zip-code">'.$zipcode.'</td>';
						echo '<td class="column-treatment-areas">'.formatList( $treat_area ).'</td>';
						echo '<td class="column-treatment-costs">$'.formatItems( $treat_cost ).'</td>';
						echo '<td class="column-treatment-docs">'.$doctors.'</td>';
						echo '<td class="column-sms-status">'.$sms.'</td>';
						echo '<td class="column-treatment-notes">';
							echo '<div><textarea tabindex="80'.$i.'" class="notes-input">'.$notes.'</textarea></div>';
						echo '</td>';
					echo '</tr>';

				$i++;
				endforeach;
				?>
				</tbody>
			</table>
		<?php
	}

/**
	 * build out post type for log files
	 *
	 * @return PA_Calculator_Logging
	 */

	public function _register_log() {

		register_post_type( 'pacalc_log',
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
	}

/// end class
}


// Instantiate our class
$PA_Calculator_Logging = PA_Calculator_Logging::getInstance();
