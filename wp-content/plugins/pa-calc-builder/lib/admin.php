<?php
/* all admin related functions */

// Start up the engine
class PA_Calculator_Admin
{
	/**
	 * Static property to hold our singleton instance
	 * @var PA_Calculator_Admin
	 */
	static $instance = false;


	/**
	 * This is our constructor, which is private to force the use of
	 * getInstance() to make this a Singleton
	 *
	 * @return PA_Calculator_Admin
	 */

	private function __construct() {
		add_action		( 'admin_enqueue_scripts',			array( $this, 'scripts_styles'			),	10		);
		add_action		( 'admin_menu',						array( $this, 'menu_items'				)			);
		// add_action		( 'admin_menu',						array( $this, 'edit_labels'				)			);
		add_action		( 'admin_init',						array( $this, 'reg_settings'			)			);
		// add_action		( 'admin_init',						array( $this, 'form_store'				)			);
		add_action		( 'admin_init',						array( $this, 'general_store'			)			);
		// add_action		( 'admin_notices',					array( $this, 'form_message'			)			);
		add_action		( 'admin_notices',					array( $this, 'general_message'			)			);

		add_filter		( 'plugin_action_links',			array( $this, 'quick_link'				),	10,	2	);

	}

	/**
	 * If an instance exists, this returns it.  If not, it creates one and
	 * retuns it.
	 *
	 * @return PA_Calculator_Admin
	 */

	public static function getInstance() {
		if ( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}


	/**
	 * show settings link on plugins page
	 *
	 * @return PA_Calculator_Admin
	 */

	public function quick_link( $links, $file ) {

		static $this_plugin;

		if ( ! $this_plugin ) {
			$this_plugin = PAC_BASE;
		}

		// check to make sure we are on the correct plugin
		if ( $file == $this_plugin ) {

			$settings_link	= '<a href="' . admin_url( 'edit.php?post_type=' . PA_Calculator_Calc::POST_TYPE ) . '">' . __( 'Calculators', 'pac' ) . '</a>';

			array_unshift( $links, $settings_link );
		}

		return $links;

	}

	/**
	 * Scripts and stylesheets
	 *
	 * @return PA_Calculator_Admin
	 */

	public function scripts_styles( $hook ) {

		$screen = get_current_screen();

		if (	$hook == 'toplevel_page_calculator' ||
				$hook == 'calculator_page_calculator-log' ||
				$hook == 'calculator_page_calculator-settings' ||
				( isset( $screen ) && PA_Calculator_Calc::POST_TYPE == $screen->post_type )
			) :
			wp_enqueue_style( 'pa-calc', plugins_url('lib/css/pac.admin.css', dirname(__FILE__) ), array(), PAC_VER, 'all' );
			wp_enqueue_script( 'pa-calc',	plugins_url('lib/js/pac.admin.js', dirname(__FILE__) ) , array( 'jquery' ), PAC_VER, true );

		endif;

	}

	/**
	 * store array of form data
	 *
	 * @return PA_Calculator_Admin
	 */

	public function form_store() {

		if ( !current_user_can('manage_options' ) )
			return;

		if ( !isset( $_POST['option_page'] ) )
			return;

		if ( $_POST['option_page'] !== 'pacalc' )
			return;

		// we are in the form builder page, clean up the array
		if ( $_POST['action'] == 'update' ) :

			$current	= get_option('pacalc');
			$updates	= array();

			/* set up statics first */
			$form_title			= $_POST['form-title'];
			$form_desc			= $_POST['form-desc'];
			$questions_head		= $_POST['questions-head'];
			$fields_title		= $_POST['fields-title'];
			$fields_thumb		= $_POST['fields-thumb'];
			$submit_text		= $_POST['submit-text'];
			$disclaimer			= $_POST['disclaimer'];
			$nodoctext_a		= $_POST['nodoc-text-a'];
			$nodoctext_b		= $_POST['nodoc-text-b'];


			$updates['form-title']		= $form_title;
			$updates['form-desc']		= $form_desc;
			$updates['questions-head']	= $questions_head;
			$updates['fields-title']	= $fields_title;
			$updates['fields-thumb']	= $fields_thumb;
			$updates['submit-text']		= $submit_text;
			$updates['disclaimer']		= $disclaimer;
			$updates['nodoc-text-a']	= $nodoctext_a;
			$updates['nodoc-text-b']	= $nodoctext_b;

			/* hit my repeating calc fields */
			$calc_titles	= $_POST['calc-title'];
			$calc_costs		= $_POST['calc-cost'];
			$calc_thumb		= $_POST['calc-thumb'];
			$calc_desc		= $_POST['calc-desc'];
			$calc_sugst		= $_POST['calc-sugst'];

			$count			= count( $calc_titles );

			for ( $i = 0; $i < $count; $i++ ) {

				if ( $calc_titles[$i] != '' ) :
					$updates['calc-fields'][$i]['calc-title'] = stripslashes( strip_tags( $calc_titles[$i] ) );

					if ( $calc_costs[$i] != '' )
						$updates['calc-fields'][$i]['calc-cost'] = stripslashes( $calc_costs[$i] );

					if ( $calc_thumb[$i] != '' )
						$updates['calc-fields'][$i]['calc-thumb'] = stripslashes( $calc_thumb[$i] );

					if ( $calc_desc[$i] != '' )
						$updates['calc-fields'][$i]['calc-desc'] = stripslashes( $calc_desc[$i] );

					if ( $calc_sugst[$i] != '' )
						$updates['calc-fields'][$i]['calc-sugst'] = stripslashes( $calc_sugst[$i] );

				endif;
			}

			/* hit my repeating extra fields */
			$extra_label	= $_POST['extra-label'];
			$extra_type		= $_POST['extra-type'];
			$extra_value	= $_POST['extra-value'];
			$extra_color	= $_POST['extra-color'];

			$count		= count( $extra_label );

			for ( $i = 0; $i < $count; $i++ ) {

				if ( $extra_label[$i] != '' ) :
					$updates['extras'][$i]['extra-label'] = stripslashes( strip_tags( $extra_label[$i] ) );

					if ( $extra_type[$i] != '' )
						$updates['extras'][$i]['extra-type'] = stripslashes( $extra_type[$i] );

					if ( $extra_value[$i] != '' )
						$updates['extras'][$i]['extra-value'] = stripslashes( $extra_value[$i] );

					if ( $extra_color[$i] != '' )
						$updates['extras'][$i]['extra-color'] = stripslashes( $extra_color[$i] );

				endif;
			}

			if ( !empty( $updates ) && $updates != $current )
				update_option( 'pacalc', $updates );

			elseif ( empty($updates) && $current )
				delete_option( 'pacalc' );


			// reload page to clear _POST values
			$url = menu_page_url( 'calculator', 0 );
			wp_redirect( esc_url_raw( $url.'&saved=true' ), 301 );
			exit();

		// end repeatable stuff
		endif;

	}


	/**
	 * store array of general data
	 *
	 * @return PA_Calculator_Admin
	 */

	public function general_store() {

		if ( !current_user_can('manage_options' ) )
			return;

		if ( !isset( $_POST['option_page'] ) )
			return;

		if ( $_POST['option_page'] !== 'pacalc_settings' )
			return;

		// Run our migration
		if ( isset( $_POST['migrate-form-builder'] ) ) {

			$this->migrate_to_cpt();

			// reload page to clear _POST values
			$url = menu_page_url( 'calculator-settings', 0 );
			wp_redirect( esc_url_raw( $url.'&saved=true' ), 301 );
			exit();
		}

		// we are in the form builder page, clean up the array
		if ( $_POST['action'] == 'update' ) :

			$updates	= array();

			$site_id			= $_POST['site-id'];
			$return_num			= $_POST['return-num'];
			$send_to			= $_POST['send-to'];
			$clockwork			= $_POST['clockwork-api'];
			$sms_alert			= $_POST['sms-alert'];
			$prosper_url		= $_POST['prosper-url'];
			$prosper_anchor		= $_POST['prosper-anchor'];
			$prosper_text		= $_POST['prosper-text'];

			$updates['site-id']			= $site_id;
			$updates['return-num']		= $return_num;
			$updates['send-to']			= $send_to;
			$updates['clockwork-api']	= $clockwork;
			$updates['sms-alert']		= $sms_alert;
			$updates['prosper-url']		= $prosper_url;
			$updates['prosper-anchor']	= $prosper_anchor;
			$updates['prosper-text']	= $prosper_text;

			// Allow addons to save general settings
			$updates = apply_filters( 'pa_calc_save_general_settings', $updates );

			update_option( 'pacalc_settings', $updates );

			// reload page to clear _POST values
			$url = menu_page_url( 'calculator-settings', 0 );
			wp_redirect( esc_url_raw( $url.'&saved=true' ), 301 );
			exit();

		endif;

	}

	public function migrate_to_cpt() {

		if ( !current_user_can('manage_options' ) )
			return;

		if ( !isset( $_POST['option_page'] ) )
			return;

		if ( $_POST['option_page'] !== 'pacalc_settings' )
			return;

		// Get settings
		$setup	= get_option( 'pacalc_settings' );

		// Check if it's already been migrated
		$migrated = get_option( 'pacalc_migrated_to_cpt' );
		if ( $migrated ) {
			return;
		}

		// Get the old data
		$data = get_option( 'pacalc' );

		// Get the title
		$form_title			= !empty( $data['form-title'] ) 		? $data['form-title']		: '';

		// create entry data
		$log_args  = array(
			'post_type'     	=> PA_Calculator_Calc::POST_TYPE,
			'post_title'    	=> $form_title,
			'post_status'   	=> 'publish',
			'comment_status'	=> 'closed',
		);

		// create the new CPT calc
		$calc_cpt = wp_insert_post( $log_args, true );

		if ( !is_wp_error( $calc_cpt ) ) {
			update_post_meta( $calc_cpt, '_pacalc_data',		$data		);

			// Set migrated flag
			update_option( 'pacalc_migrated_to_cpt', $calc_cpt );
		}

	}

	/**
	 * tweak my labels for better UI
	 *
	 * @return PA_Calculator_Admin
	 */

	public function edit_labels() {
		global $submenu;

		$submenu['calculator'][0][0] = 'Form Builder';
	}


	/**
	 * display saved messages if applicable
	 *
	 * @return PA_Calculator_Admin
	 */
	public function form_message() {

		// first check to make sure we're on our calc page
		if ( !isset( $_GET['page'] ) )
			return;

		// now make sure we're actually doing our save function
		if ( !isset( $_GET['saved'] ) )
			return;

		if ( $_GET['page'] !== 'calculator' || $_GET['saved'] !== 'true' )
			return;

		// checks passed, display the message
		echo '<div class="updated">';
			echo '<p>'.__( 'The form builder has been updated', 'pac' ).'</p>';
		echo '</div>';

		return;

	}

	public function general_message() {

		// first check to make sure we're on our calc page
		if ( !isset( $_GET['page'] ) )
			return;

		// now make sure we're actually doing our save function
		if ( !isset( $_GET['saved'] ) )
			return;

		if ( $_GET['page'] !== 'calculator-settings' || $_GET['saved'] !== 'true' )
			return;

		// checks passed, display the message
		echo '<div class="updated">';
			echo '<p>'.__( 'The settings have been updated', 'pac' ).'</p>';
		echo '</div>';

		return;

	}

	/**
	 * Register settings
	 *
	 * @return PA_Calculator_Admin
	 */

	public function reg_settings() {
		register_setting( 'pacalc', 'pacalc');
		register_setting( 'pacalc_settings', 'pacalc_settings');
	}

	/**
	 * build out admin pages
	 *
	 * @return PA_Calculator_Admin
	 */

	public function menu_items() {

		add_menu_page( __('Calculator', 'pac'), __('Calculator', 'pac'), 'manage_options', 'calculator', array( $this, 'pa_calc_main' ), 'dashicons-forms', '88.8');

		add_submenu_page( 'calculator', __('Settings', 'pac'), __('Settings', 'pac'), 'manage_options', 'calculator-settings', array( $this, 'pa_calc_settings' ));

		add_submenu_page( 'calculator', __('Logging', 'pac'), __('Logging', 'pac'), 'manage_options', 'calculator-log', array( $this, 'pa_calc_logging' ));

	}

	/**
	 * Grab repeating fields for calculator
	 *
	 * @return PA_Calculator_Admin
	 */

	public function calc_fields( $data ) {

		$fields = '';

		// grab our data array and filter through
		if ( !empty( $data ) ) : foreach ($data as $item) :

			$title	= !empty($item['calc-title'])	? $item['calc-title']	: '';
			$cost	= !empty($item['calc-cost'])	? $item['calc-cost']	: '';
			$thumb	= !empty($item['calc-thumb'])	? $item['calc-thumb']	: '';
			$desc	= !empty($item['calc-desc'])	? $item['calc-desc']	: '';
			$sugst	= !empty($item['calc-sugst'])	? $item['calc-sugst']	: '';


			$fields .= '<li class="calc-field-row">';
				$fields .= '<span class="icon">';
				$fields .= '<input type="button" title="Remove '.$title.'" class="calc-row-remove" value="'. __('Remove', 'pac') .'" />';
				$fields .= '</span>';

				$fields .= '<span class="title">';
				$fields .= '<input type="text" class="regular-text calc-title" name="calc-title[]" value="'.$title.'" />';
				$fields .= '</span>';

				$fields .= '<span class="cost">';
				$fields .= '<input type="text" class="small-text calc-cost" name="calc-cost[]" value="'.$cost.'" />';
				$fields .= '</span>';

				$fields .= '<span class="pthumb">';
				$fields .= '<input type="url" class="regular-text calc-thumb" name="calc-thumb[]" value="'.esc_url( $thumb ).'" />';
				$fields .= '</span>';

				$fields .= '<span class="desc">';
				$fields .= '<input type="text" class="regular-text calc-desc" name="calc-desc[]" value="'.$desc.'" />';
				$fields .= '</span>';

				$fields .= '<span class="sugst">';
				$fields .= '<input type="url" class="regular-text calc-sugst" name="calc-sugst[]" value="'.$sugst.'" />';
				$fields .= '</span>';

			$fields .= '</li>';

		endforeach; endif;

		// display an empty fieldset if we don't have any data saved yet
		if ( empty( $data ) ) :
			$fields .= '<li class="calc-field-row">';
				$fields .= '<span class="icon">';
				$fields .= '&nbsp;';
				$fields .= '</span>';

				$fields .= '<span class="title">';
				$fields .= '<input type="text" class="regular-text calc-title" name="calc-title[]" value="" />';
				$fields .= '</span>';

				$fields .= '<span class="cost">';
				$fields .= '<input type="text" class="small-text calc-cost" name="calc-cost[]" value="" />';
				$fields .= '</span>';

				$fields .= '<span class="pthumb">';
				$fields .= '<input type="text" class="regular-text calc-thumb" name="calc-thumb[]" value="" />';
				$fields .= '</span>';

				$fields .= '<span class="desc">';
				$fields .= '<input type="text" class="regular-text calc-desc" name="calc-desc[]" value="" />';
				$fields .= '</span>';

				$fields .= '<span class="sugst">';
				$fields .= '<input type="url" class="regular-text calc-sugst" name="calc-sugst[]" value="" />';
				$fields .= '</span>';

			$fields .= '</li>';
		endif;

		// our hidden field for repeating magic
			$fields .= '<li class="calc-empty-row screen-reader-text">';
				$fields .= '<span class="icon">';
				$fields .= '<input type="button" class="calc-row-remove" value="'. __('Remove', 'pac') .'" />';
				$fields .= '</span>';

				$fields .= '<span class="title">';
				$fields .= '<input type="text" class="regular-text calc-title" name="calc-title[]" value="" />';
				$fields .= '</span>';

				$fields .= '<span class="cost">';
				$fields .= '<input type="text" class="small-text calc-cost" name="calc-cost[]" value="" />';
				$fields .= '</span>';

				$fields .= '<span class="pthumb">';
				$fields .= '<input type="text" class="regular-text calc-thumb" name="calc-thumb[]" value="" />';
				$fields .= '</span>';

				$fields .= '<span class="desc">';
				$fields .= '<input type="text" class="regular-text calc-desc" name="calc-desc[]" value="" />';
				$fields .= '</span>';

				$fields .= '<span class="sugst">';
				$fields .= '<input type="url" class="regular-text calc-sugst" name="calc-sugst[]" value="" />';
				$fields .= '</span>';

			$fields .= '</li>';

		return $fields;
	}

	/**
	 * Grab repeating fields for additional fields
	 *
	 * @return PA_Calculator_Admin
	 */

	public function extra_fields( $data ) {

		$fields = '';

		// grab our data array and filter through
		if ( !empty( $data ) ) : foreach ($data as $item) :

			$label	= !empty($item['extra-label'])	? $item['extra-label']	: '';
			$type	= !empty($item['extra-type'])	? $item['extra-type']	: '';
			$value	= !empty($item['extra-value'])	? $item['extra-value']	: '';
			$color	= !empty($item['extra-color'])	? $item['extra-color']	: '';

			$fields .= '<li class="extra-field-row">';
				$fields .= '<span class="icon">';
				$fields .= '<input type="button" title="Remove '.$label.'" class="extra-row-remove" value="'. __('Remove', 'pac') .'" />';
				$fields .= '</span>';

				$fields .= '<span class="type">';
				$fields .= '<select class="extra-type" name="extra-type[]">';
					$fields .= '<option value="" >(Select)</option>';
					$fields .= '<option value="dropdown" '.selected( $type, 'dropdown', false).' >Dropdown</option>';
					$fields .= '<option value="textfield" '.selected( $type, 'textfield', false).' >Text Field</option>';
					$fields .= '<option value="radio" '.selected( $type, 'radio', false).' >Radio</option>';
					$fields .= '<option value="checkbox" '.selected( $type, 'checkbox', false).' >Checkboxes</option>';
				$fields .= '</select>';
				$fields .= '</span>';

				$fields .= '<span class="title">';
				$fields .= '<input type="text" class="regular-text extra-label" name="extra-label[]" value="'.$label.'" />';
				$fields .= '</span>';

				$fields .= '<span class="value">';
				$fields .= '<input type="text" class="regular-text extra-value" name="extra-value[]" value="'.$value.'" />';
				$fields .= '</span>';

				$fields .= '<span class="color">';
				$fields .= '<input type="checkbox" class="extra-color" name="extra-color[]" value="on" '.checked( $color, 'on', false).'>';
				$fields .= '</span>';

			$fields .= '</li>';

		endforeach; endif;

		// display an empty fieldset if we don't have any data saved yet
		if ( empty( $data ) ) :
			// an empty one
			$fields .= '<li class="extra-field-row">';
				$fields .= '<span class="icon">';
				$fields .= '&nbsp;';
				$fields .= '</span>';

				$fields .= '<span class="type">';
				$fields .= '<select class="extra-type" name="extra-type[]">';
					$fields .= '<option value="" >(Select)</option>';
					$fields .= '<option value="dropdown">Dropdown</option>';
					$fields .= '<option value="textfield">Text Field</option>';
					$fields .= '<option value="radio">Radio</option>';
					$fields .= '<option value="checkbox">Checkboxes</option>';
					$fields .= '</select>';
				$fields .= '</span>';

				$fields .= '<span class="title">';
				$fields .= '<input type="text" class="regular-text extra-label" name="extra-label[]" value="" />';
				$fields .= '</span>';

				$fields .= '<span class="value">';
				$fields .= '<input type="text" class="regular-text extra-value" name="extra-value[]" value="" />';
				$fields .= '</span>';

				$fields .= '<span class="color">';
				$fields .= '<input type="checkbox" class="extra-color" name="extra-color[]" value="on">';
				$fields .= '</span>';

			$fields .= '</li>';
		endif;

			// our hidden field for repeating magic
			$fields .= '<li class="extra-empty-row screen-reader-text">';
				$fields .= '<span class="icon">';
				$fields .= '<input type="button" class="extra-row-remove" value="'. __('Remove', 'pac') .'" />';
				$fields .= '</span>';

				$fields .= '<span class="type">';
				$fields .= '<select class="extra-type" name="extra-type[]">';
					$fields .= '<option value="" >(Select)</option>';
					$fields .= '<option value="dropdown">Dropdown</option>';
					$fields .= '<option value="textfield">Text Field</option>';
					$fields .= '<option value="radio">Radio</option>';
					$fields .= '<option value="checkbox">Checkboxes</option>';
					$fields .= '</select>';
				$fields .= '</span>';

				$fields .= '<span class="title">';
				$fields .= '<input type="text" class="regular-text extra-label" name="extra-label[]" value="" />';
				$fields .= '</span>';

				$fields .= '<span class="value">';
				$fields .= '<input type="text" class="regular-text extra-value" name="extra-value[]" value="" />';
				$fields .= '</span>';

				$fields .= '<span class="color">';
				$fields .= '<input type="checkbox" class="extra-color" name="extra-color[]" value="on">';
				$fields .= '</span>';

			$fields .= '</li>';

		return $fields;
	}

	/**
	 * Display main options page structure
	 *
	 * @return PA_Calculator_Admin
	 */

	public function pa_calc_main() {
		if (!current_user_can('manage_options') )
			return;
		?>

		<div class="wrap">
		<div class="icon32" id="icon-pa-builder"><br></div>
		<h1>This page is deprecated, please use the <a href="<?php echo admin_url( 'edit.php?post_type=' . PA_Calculator_Calc::POST_TYPE ); ?>">Cost Calculators</a> page instead.</h1>
		<h2><?php _e('Calculator Builder', 'pac') ?></h2>

			<div class="inner-form-text">
			<p><?php _e('The available form items', 'pac') ?></p>
			<h4><?php _e('To display the form, use the following shortcode', 'pac') ?>  <code>[pacalc]</code></h4>
			</div>
			<div class="inner-form-options">
				<form method="post">
				<?php
					settings_fields( 'pacalc' );

					$data	= get_option('pacalc');

					$form_title			= !empty( $data['form-title'] ) 		? $data['form-title']		: '';
					$form_desc			= !empty( $data['form-desc'] )			? $data['form-desc']		: '';
					$questions_head		= !empty( $data['questions-head'] )		? $data['questions-head']	: '';
					$fields_title		= !empty( $data['fields-title'] )		? $data['fields-title']		: '';
					$fields_thumb		= !empty( $data['fields-thumb'] )		? $data['fields-thumb']		: '';
					$submit_text		= !empty( $data['submit-text'] )		? $data['submit-text']		: 'Submit';
					$disclaimer			= !empty( $data['disclaimer'] )			? $data['disclaimer']		: '';
					$nodoctext_a		= !empty( $data['nodoc-text-a'] )		? $data['nodoc-text-a'] 	: '';
					$nodoctext_b		= !empty( $data['nodoc-text-b'] )		? $data['nodoc-text-b'] 	: '';
				?>

				<div id="form-details-static" class="form-table pa-calc-table">
				<h3><?php _e('Freeform Fields', 'pac') ?></h3>
				<ul>
					<li>
						<span class="label"><label for="form-title"><?php _e('Calculator Title', 'pac'); ?></label></span>
						<span class="input">
							<input type="text" class="widefat" id="form-title" name="form-title" value="<?php echo $form_title; ?>" />
						</span>
					</li>
					<li>
						<span class="label"><label for="formdesc"><?php _e('Calculator Description', 'pac'); ?></label></span>
						<span class="input">
						<?php
							$args = array(
								'media_buttons'	=> false,
								'teeny'			=> true,
								'textarea_rows'	=> 7,
								'textarea_name'	=> 'form-desc'
							);
							wp_editor( stripslashes($form_desc), 'formdesc', $args );
						?>
						</span>
					</li>
					<li>
						<span class="label"><label for="questions-head"><?php _e('Questions Header', 'pac'); ?></label></span>
						<span class="input">
							<input type="text" class="widefat" id="questions-head" name="questions-head" value="<?php echo $questions_head; ?>" />
						</span>
					</li>
					<li>
						<span class="label"><label for="submit-text"><?php _e('Submit Button text', 'pac'); ?></label></span>
						<span class="input">
							<input type="text" class="widefat" id="submit-text" name="submit-text" value="<?php echo $submit_text; ?>" />
						</span>
					</li>
					<li>
						<span class="label"><label for="disclaimer"><?php _e('Disclaimer Text', 'pac'); ?></label></span>
						<span class="input">
							<input type="text" class="widefat" id="disclaimer" name="disclaimer" value="<?php echo esc_attr( $disclaimer ); ?>" />
						</span>
						<p class="disclaimer"><?php _e('Disclaimer text to display below the submit button.', 'pac'); ?></p>
					</li>
				</ul>
				</div>


				<div id="calc-field-static" class="form-table pa-calc-table">
				<h3><?php _e('Calculation Fields', 'pac') ?></h3>
				<ul>
					<li>
						<span class="label"><label for="fields-title"><?php _e('Title', 'pac'); ?></label></span>
						<span class="input">
							<input type="text" class="widefat" id="fields-title" name="fields-title" value="<?php echo $fields_title; ?>" />
						</span>
					</li>
					<li>
						<span class="label"><label for="fields-thumb"><?php _e('Thumbnails', 'pac'); ?></label></span>
						<span class="input">
							<input type="checkbox" class="fields-thumb" id="fields-thumb" name="fields-thumb" value="1" <?php checked( $fields_thumb, 1); ?> />
							<span class="description"> <?php _e('check this box to use thumbnail images, 60px by 60px', 'pac'); ?></span>
						</span>
					</li>
				</ul>
				</div>

				<div id="calc-field-rows" class="form-table pa-calc-table">
				<h4><?php _e('Calculation Field Options', 'pac') ?></h4>
					<ul>
						<li class="calc-field-titles">
							<span class="icon calc-head calc-remove-head">&nbsp;</span>
							<span class="title calc-head calc-label-head"><?php _e('Label', 'pac'); ?></span>
							<span class="cost calc-head calc-cost-head"><?php _e('Cost', 'pac'); ?></span>
							<span class="pthumb calc-head calc-thumb-head"><?php _e('Thumbnail', 'pac'); ?></span>
							<span class="desc calc-head calc-desc-head"><?php _e('Description', 'pac'); ?></span>
							<span class="sugst calc-head calc-sugst-head"><?php _e('Description URL', 'pac'); ?></span>
						</li>

						<?php
						$calcs	= isset( $data['calc-fields'] ) ? $data['calc-fields'] : '';
						$fields	= $this->calc_fields( $calcs );
						echo $fields;
						?>
					</ul>
					<p><input type="button" id="calc-clone" class="button button-secondary field-clone" value="Add Option"></p>
				</div>

				<div id="calc-field-extras" class="form-table pa-calc-table">
				<h3><?php _e('Additional Calculation Fields', 'pac') ?></h3>
					<ul>
						<li class="extra-field-titles">
							<span class="icon">&nbsp;</span>
							<span class="type"><?php _e('Field Type', 'pac'); ?></span>
							<span class="title"><?php _e('Label', 'pac'); ?></span>
							<span class="value"><?php _e('Values', 'pac'); ?></span>
							<span class="color"><?php _e('Color', 'pac'); ?></span>
						</li>
						<?php
						$extras	= isset( $data['extras'] ) ? $data['extras'] : '';
						$fields	= $this->extra_fields( $extras );
						echo $fields;
						?>
					</ul>
					<p><input type="button" id="extra-clone" class="button button-secondary field-clone" value="Add Form Field"></p>

				<p class="description"><?php _e('For field types with multiple options, separate items with a comma.', 'pac') ?></p>
				</div>

				<div id="missing-field-extras" class="form-table pa-calc-table">
				<h3><?php _e('Empty Doctor Return', 'pac') ?></h3>
				<ul>

					<li>
						<span class="label"><label for="nodoctexta"><?php _e('Step 2 Text', 'pac'); ?></label></span>
						<span class="input">
						<?php
							$args = array(
								'media_buttons'	=> true,
								'teeny'			=> true,
								'textarea_rows'	=> 7,
								'textarea_name'	=> 'nodoc-text-a'
							);
							wp_editor( stripslashes($nodoctext_a), 'nodoctexta', $args );
						?>
						</span>
						<p class="disclaimer"><?php _e('Text for display when no doctors are returned in the zip code', 'pac'); ?></p>
					</li>

					<li>
						<span class="label"><label for="nodoctextb"><?php _e('Step 3 Text', 'pac'); ?></label></span>
						<span class="input">
						<?php
							$args = array(
								'media_buttons'	=> true,
								'teeny'			=> true,
								'textarea_rows'	=> 7,
								'textarea_name'	=> 'nodoc-text-b'
							);
							wp_editor( stripslashes($nodoctext_b), 'nodoctextb', $args );
						?>
						</span>
						<p class="disclaimer"><?php _e('Text for display when no doctors are returned in the zip code', 'pac'); ?></p>
					</li>

				</ul>
				</div>


				<p><input type="submit" class="button-primary save-fields" value="<?php _e('Save Form', 'pac'); ?>" /></p>
				</form>

			</div>


		</div>

	<?php }


	/**
	 * Display general settings page
	 *
	 * @return PA_Calculator_Admin
	 */

	public function pa_calc_settings() {
		if (!current_user_can('manage_options') )
			return;
		?>

		<div class="wrap">
		<div class="icon32" id="icon-pa-builder"><br></div>
		<h2><?php _e('PA Calculator Settings', 'pac') ?></h2>


			<div class="inner-form-text">
			<p><?php _e('All the extra settings related to the calculator.', 'pac') ?></p>
			</div>
			<div class="inner-form-options">
				<form method="post">
				<?php
					settings_fields( 'pacalc_settings' );

					$data	= get_option('pacalc_settings');

					$site_id			= !empty( $data['site-id'] ) 		? $data['site-id']			: '';
					$return_num			= !empty( $data['return-num'] )		? $data['return-num']		: '3';
					$send_to			= !empty( $data['send-to'] )		? $data['send-to']			: 'info@patientsguide.com';
					$clockwork			= !empty( $data['clockwork-api'] )	? $data['clockwork-api']	: '';
					$sms_alert			= !empty( $data['sms-alert'] )		? $data['sms-alert']		: '5';
					$prosper_url		= !empty( $data['prosper-url'] )	? $data['prosper-url']		: '';
					$prosper_anchor		= !empty( $data['prosper-anchor'] )	? $data['prosper-anchor']	: '';
					$prosper_text		= !empty( $data['prosper-text'] )	? $data['prosper-text']		: '';
					$migrated_to_cpt	= get_option( 'pacalc_migrated_to_cpt' );

				?>
				<div id="api-details-static" class="form-table pa-calc-table">
				<h3><?php _e('API Details', 'pac') ?></h3>
				<ul>
					<li>
						<span class="label"><label for="site-id"><?php _e('Site ID', 'pac') ?></label></span>
						<span class="input">
							<input type="text" class="small-text" id="site-id" name="site-id" value="<?php echo $site_id; ?>" required />
						</span>
					</li>
					<li>
						<span class="label"><label for="return-num"><?php _e('Return Count', 'pac') ?></label></span>
						<span class="input">
							<input type="text" class="small-text" id="return-num" name="return-num" value="<?php echo $return_num; ?>" required />
						</span>
					</li>
					<li>
						<span class="label"><label for="send-to"><?php _e('Internal Email', 'pac') ?></label></span>
						<span class="input">
							<input type="text" class="regular-text" id="send-to" name="send-to" value="<?php echo $send_to; ?>" required />
						</span>
					</li>
				</ul>
				</div>

				<div id="sms-details-static" class="form-table pa-calc-table">
				<h3><?php _e('Clockwork SMS Setup', 'pac') ?></h3>
				<ul>
					<li>
						<span class="label"><label for="clockwork-api"><?php _e('API Key', 'pac') ?></label></span>
						<span class="input">
							<input type="password" class="widefat" id="clockwork-api" name="clockwork-api" value="<?php echo $clockwork; ?>" />
						</span>
					</li>
					<li>
						<span class="label"><label for="sms-alert"><?php _e('Balance Alert', 'pac') ?></label></span>
						<span class="input">
							<input type="text" class="small-text" id="sms-alert" name="sms-alert" value="<?php echo $sms_alert; ?>" required />
						</span>
					</li>
				</ul>
				</div>

				<div id="prosper-details-static" class="form-table pa-calc-table">
				<h3><?php _e('Prosper Setup', 'pac') ?></h3>
				<ul>

					<li>
						<span class="label"><label for="prosper-url"><?php _e('Affiliate Link', 'pac') ?></label></span>
						<span class="input">
							<input type="url" class="widefat" id="prosper-url" name="prosper-url" value="<?php echo esc_url($prosper_url); ?>" required />
						</span>
					</li>
					<li>
						<span class="label"><label for="prosper-anchor"><?php _e('Anchor Text', 'pac') ?></label></span>
						<span class="input">
							<input type="text" class="widefat" id="prosper-anchor" name="prosper-anchor" value="<?php echo stripslashes($prosper_anchor); ?>" />
						</span>
					</li>
					<li>
						<span class="label"><label for="prosper-text"><?php _e('Listing Text', 'pac') ?></label></span>
						<span class="input">
							<textarea name="prosper-text" id="prosper-text" class="large-text" rows="5"><?php echo stripslashes( $prosper_text ); ?></textarea>
						</span>
						<p class="disclaimer">Use the word <strong><code>{finance}</code></strong> to have the amount inserted automatically.<br /> <strong>Note:</strong> the 'apply now' will appear automatically.</p>
					</li>

				</ul>
				</div>


					<div id="pa-calc-migrate-static" class="form-table pa-calc-table">
					<h3><?php _e('Migrate Form Builder', 'pac') ?></h3>
					<ul>
					<?php if ( ! $migrated_to_cpt ): ?>
						<li>
							<span class="label"><label for="migrate-form-builder">Migrate to new Calculator format</label></span>
							<span class="input">
								<input type="submit" class="button-primary save-fields" name="migrate-form-builder" value="<?php _e('Migrate', 'pac'); ?>">
								<p class="description">Press this to migrate your old form builder (one form) into the new post type to support multiple calculators. The old settings will then be deleted.<br /> <strong>Note:</strong> This cannot be undone.</p>
							</span>
						</li>
					<?php else: ?>
						<li>
							<span class="label"><label for="migrate-form-builder">Migrate to new Calculator format</label></span>
							<span class="input">
							<p><a href="<?php echo esc_url( admin_url( 'post.php?post=' . $migrated_to_cpt . '&action=edit' ) ); ?>">Already Migrated</a></p>
							</span>
						</li>
					<?php endif; ?>
					</ul>

					</div>


				<?php
				// Allow add-ons to add their own settings
				do_action( 'pa_calc_settings_fields' );
				?>

				<p><input type="submit" class="button-primary save-fields" value="<?php _e('Save Settings', 'pac') ?>" /></p>
				</form>

			</div>


		</div>

	<?php }

	/**
	 * Display the log page
	 *
	 * @return PA_Calculator_Admin
	 */

	public function pa_calc_logging() {
		if (!current_user_can('manage_options') )
			return;
		?>

		<div class="wrap">
		<div class="icon32" id="icon-pa-builder"><br></div>
		<h2><?php _e('PA Calculator Logging', 'pac') ?></h2>

			<div class="pa-logtable-wrap">
			<?php
			$display	= PA_Calculator_Logging::getInstance();
			$display->log_table_display();
			?>
			</div>

		</div>

	<?php }


/// end class
}


// Instantiate our class
$PA_Calculator_Admin = PA_Calculator_Admin::getInstance();
