<?php

/*
  Plugin Name: PA Calculator
  Plugin URI: http://reaktivstudios.com/plugins/
  Description: Creates a customizable cost estimate calculator
  Version: 1.3
  Author: Reaktiv Studios
  Author URI: http://reaktivstudios.com

  Copyright 2013 Reaktiv Studios

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

if (!defined('PAC_BASE')) {
    define('PAC_BASE', plugin_basename(__FILE__));
}

if (!defined('PAC_DIR')) {
    define('PAC_DIR', plugin_dir_path(__FILE__));
}

if (!defined('PAC_VER')) {
    define('PAC_VER', '1.2.2');
}

if (!defined('AMM_API_KEY')) {
    define('AMM_API_KEY', 'TOpjEBEgReZD8gZabkkYL9lIaEEHF2MaV5-LT7KovbulH0yArgVsKg2');
}

if (!defined('AMM_API_URL')) {
    define('AMM_API_URL', 'http://api.patientsguide.com');
}

if (!defined('AMM_USE_CACHE')) {
    define('AMM_USE_CACHE', 'false');
}

// Start up the engine
class PA_Calculator {

    /**
     * Static property to hold our singleton instance
     * @var PA_Calculator
     */
    static $instance = false;

    /**
     * This is our constructor, which is private to force the use of
     * getInstance() to make this a Singleton
     *
     * @return PA_Calculator
     */
    private function __construct() {
        add_action('plugins_loaded', array($this, 'textdomain'));
        add_action('plugins_loaded', array($this, 'load_files'));
        add_action('wp_enqueue_scripts', array($this, 'front_scripts'));
        add_shortcode('pacalc', array($this, 'shortcode'));
    }

    /**
     * If an instance exists, this returns it.  If not, it creates one and
     * retuns it.
     *
     * @return PA_Calculator
     */
    public static function getInstance() {
        if (!self::$instance)
            self::$instance = new self;
        return self::$instance;
    }

    public function disable_cache() {
        header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
        header('Pragma: no-cache'); // HTTP 1.0.
        header('Expires: 0'); // Proxies.
        print nocache_headers();
    }

    public function modify_query() {
        
    }

    /**
     * load textdomain
     *
     * @return PA_Calculator
     */
    public function textdomain() {

        load_plugin_textdomain('pac', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * load our secondary files
     * @return [type] [description]
     */
    public function load_files() {
// include our admin panel and helper file
        require( PAC_DIR . 'lib/admin.php' );
        require( PAC_DIR . 'lib/types.php' );
        require( PAC_DIR . 'lib/logging.php' );
        require( PAC_DIR . 'lib/helpers.php' );
        require( PAC_DIR . 'lib/clockwork/class-Clockwork.php' );
        require( PAC_DIR . 'lib/clockwork/class-WordPressClockwork.php' );
    }

    /**
     * the API call to grab and return array based on zip code
     *
     * @return PA_Calculator
     */
    public function api_doctor_search($zipcode, $site_id, $procedure_id = -1) {

// predefined values
        $amm_url = AMM_API_URL;
        $amm_key = AMM_API_KEY;
        $use_cache = AMM_USE_CACHE;

        if (substr($amm_url, -1) == '/')
            $amm_url = substr($amm_url, 0, -1);


        if (false == get_transient('amm_doctor_array_' . $zipcode . $procedure_id)) :

            $args = array(
                'sslverify' => false,
            );
            $procedure = '';
            if ($procedure_id != -1) {
                $procedure = "&procedureId=$procedure_id";
            }
            $endpoint = $amm_url . '/search/zip2/?zip=' . $zipcode . '&radiusinmiles=30' . $procedure . '&useCache=' . $use_cache . '&key=' . $amm_key;

            $response = wp_remote_get($endpoint, $args);

// Save a transient to the database for 1 hour
            set_transient('amm_doctor_array_' . $zipcode . $procedure_id, $response, 60 * 60 * 1);

        endif;

        $response = get_transient('amm_doctor_array_' . $zipcode . $procedure_id);

// error. bail.
        if (is_wp_error($response))
            return;

// parse values
        $return = json_decode($response['body']);

// extract items from return body
        $data_array = $return->Items;
        if (empty($data_array))
            return false;

        $doctor_array = $this->array_sort($data_array);
        $doctor_ids = wp_list_pluck($doctor_array, 'UserId');

        return $doctor_ids;
    }

    /**
     * the API call to grab and return individual doctor info
     *
     * @return PA_Calculator
     */
    public function api_doctor_data($user_id, $site_id) {

// predefined values
        $amm_url = AMM_API_URL;
        $amm_key = AMM_API_KEY;
        $use_cache = AMM_USE_CACHE;

        if (substr($amm_url, -1) == '/')
            $amm_url = substr($amm_url, 0, -1);

        $site_id = '';

        if (false == get_transient('amm_doctor_single_' . $user_id)) :

            $args = array(
                'sslverify' => false,
            );

            $endpoint = $amm_url . '/search/profile/?userId=' . $user_id . '&siteid=' . $site_id . '&useCache=' . $use_cache . '&key=' . $amm_key;

            $response = wp_remote_get($endpoint, $args);

// Save a transient to the database for 1 week
            set_transient('amm_doctor_single_' . $user_id, $response, 60 * 60 * 168);

        endif;

        $response = get_transient('amm_doctor_single_' . $user_id);

// error. bail.
        if (is_wp_error($response))
            return;

// parse values
        $return = json_decode($response['body']);

// extract items from return body
        $doctor = $return->Listing;

// check for null return
        if (empty($doctor))
            return false;

        return $doctor;
    }

    /**
     * the API call to grab and return individual doctor info
     *
     * @return PA_Calculator
     */
    public function api_doctor_data_all($user_id, $site_id) {

// predefined values
        $amm_url = AMM_API_URL;
        $amm_key = AMM_API_KEY;
        $use_cache = AMM_USE_CACHE;

        if (substr($amm_url, -1) == '/')
            $amm_url = substr($amm_url, 0, -1);

        $site_id = '';

        if (false == get_transient('amm_doctor_single_' . $user_id)) :

            $args = array(
                'sslverify' => false,
            );

            $endpoint = $amm_url . '/search/profile/?userId=' . $user_id . '&siteid=' . $site_id . '&useCache=' . $use_cache . '&key=' . $amm_key;

            $response = wp_remote_get($endpoint, $args);

// Save a transient to the database for 1 week
            set_transient('amm_doctor_single_' . $user_id, $response, 60 * 60 * 168);

        endif;

        $response = get_transient('amm_doctor_single_' . $user_id);

// error. bail.
        if (is_wp_error($response))
            return;

// parse values
        $return = json_decode($response['body']);


        if (empty($return))
            return false;

        return $return;
    }

    /**
     * Get an object of procedures
     *
     * @return object
     * @author Aaron Brazell
     */
    public function get_procedures() {
        $amm_url = AMM_API_URL;
        $amm_key = AMM_API_KEY;
        $use_cache = AMM_USE_CACHE;
        $url = "";
// if ($siteid == -1) {
        $url = $amm_url . '/listing/procedureswp?key=' . $amm_key;
// } else {
//   $url = $amm_url . '/procedure/forsitewp?siteId=' . $siteid . '&key=' . $amm_key;
// }
        $url = esc_url_raw($url);
        $data = wp_remote_get($url);
        $result = wp_remote_retrieve_body($data);
        $return = json_decode($result);
        return $return;
    }

    /**
     * the API call to submit leads for doctors
     *
     * @return PA_Calculator
     */
    public function api_submit_lead($first, $last, $lead_phone, $lead_email, $lead_zip, $doctor_ids, $site_id, $procedure_id) {
// predefined values
        $amm_url = AMM_API_URL;
        $amm_key = AMM_API_KEY;
        $use_cache = AMM_USE_CACHE;
        if (!isset($doctor_ids) || empty($doctor_ids))
            return;
// loop through each provider
        $array = array();
        foreach ($doctor_ids as $doctor_id) {
            $provider = $this->api_doctor_data($doctor_id, $site_id);
            if (!$provider) {
                return false;
            }
            $details = "Automatic";
            $userid = $provider->UserId;
            $listingid = $provider->ListingId;
            if (substr($amm_url, -1) == '/')
                $amm_url = substr($amm_url, 0, -1);
            $args = array(
                'sslverify' => false,
            );

            $endpoint = $amm_url . "/weblead/capture/?first=$first&last=$last&email=$lead_email&phone=$lead_phone&zip=$lead_zip&userId=$userid"
                    . "&listingId=$listingid&websiteId=$site_id&details=$details&procedureId=$procedure_id&useCache=" . $use_cache . '&key=' . $amm_key;
            $response = wp_remote_get($endpoint, $args);

// error. bail.
            if (is_wp_error($response))
                return;
            if (!$response) {
                return false;
            }
// parse values
            $return = json_decode($response['body']);
            $array[] = $return;
        }

        return $array;
    }

    /**
     * the API call to submit leads for doctors
     *
     * @return PA_Calculator
     */
    public function api_submit_lead_cake($ckm_campaign_id, $ckm_key, $first_name, $last_name, $address, $zip_code, $email_address, $phone_home, $phone_cell, $treatment_area, $treatment, $extra_pram = array()) {
        try {
            $extrapram = '';
            if (count($extra_pram) > 0) {
                foreach ($extra_pram as $key => $value) {
                    $value = urlencode($value);
                    $extrapram.= $extrapram == '' ? "$key=$value" : "&$key=$value";
                }
            }
            $args = array(
                'sslverify' => false,
            );
            $treatment_area = urlencode($treatment_area);
            $treatment = urlencode($treatment);
            $first_name = urlencode($first_name);
            $last_name = urlencode($last_name);
            if ($address != '')
                $address = urlencode($address);
            $endpoint = "http://pgtrk.com/d.ashx?ckm_campaign_id=$ckm_campaign_id&ckm_key=$ckm_key&first_name=$first_name&last_name=$last_name&address=$address&zip_code=$zip_code"
                    . "&email_address=$email_address&phone_home=$phone_home&phone_cell=$phone_cell&treatment_area=$treatment_area&treatment=$treatment&$extrapram";
            $response = wp_remote_get($endpoint, $args);

// error. bail.
            if (is_wp_error($response))
                return;
            if (!$response) {
                return false;
            }
            return $response;
        } catch (Exception $exp) {
            
        }
    }

    /**
     * filter and clean up our return values
     *
     * @return PA_Calculator
     */
    public function array_dupes($array, $key) {

        $temp_array = array();

        foreach ($array as $v) :

            if (!isset($temp_array[$v->$key]))
                $temp_array[$v->$key] = $v;

        endforeach;

        $array = array_values($temp_array);

        return $array;
    }

    public function array_sort($array) {

        if (!isset($array) || empty($array))
            return;

        foreach ($array as $key => $row) :

            $type[$key] = $row->Coupons;

        endforeach;

        array_multisort($type, SORT_DESC, $array);


        $array = $this->array_dupes($array, 'UserId');

        return $array;
    }

    public function rating_build($rating) {

        $num = round($rating * 2) / 2;
        $rate = str_replace('.', '', $num);

        $layout = '<p class="rating"><span>Ratings:</span><i class="pa-starlg pa-starlg-' . $rate . '"></i></p>';

        return $layout;
    }

    /**
     * send SMS using Clockwork SMS API
     *
     * @return PA_Calculator
     */
    public function send_sms($submit, $setup, $procedure_id) {

        if (!isset($submit) || empty($submit))
            return;

        if (!isset($submit['phone']) || !isset($submit['zip-code']))
            return;

        $apikey = $setup['clockwork-api'];
        if (!isset($apikey) || isset($apikey) && empty($apikey))
            return;

// load the Clockwork class
        try {
            $clockwork = new WordPressClockwork($apikey, array('ssl' => false));

// clean up number and add the 1 for US
            $clean_num = preg_replace('/[^0-9]/', '', trim($submit['phone']));

// count my digits and do some checks
            $digit_num = strlen($clean_num);

// less than 10 or more than 11? bail
            if ($digit_num < 10) :
                $smsresult = 'Error: not enough digits in number ';
                return $smsresult;
            endif;

            if ($digit_num > 11) :
                $smsresult = 'Error: too many digits in number ';
                return $smsresult;
            endif;

// now check and add the 1 if need be
            $phonenum = $digit_num == 10 ? '1' . $clean_num : $clean_num;
            $message = 'Thank you for your interest, a doctor will contact you shortly. Visit http://www.patientsguide.com/find/zip/' . $submit['zip-code'] . '/ to see a full list of doctors in your area.';
            if ($procedure_id != -1) {
                $message = 'Thank you for your interest, a doctor will contact you shortly. Visit http://www.patientsguide.com/find/zip/' . $submit['zip-code'] . '/?tid=' . $procedure_id . ' to see a full list of doctors in your area.';
            }
// Setup and send a message
            $textbody = array(
                'to' => $phonenum,
                'message' => $message
            );

// process SMS call
            $smsprocess = $clockwork->send($textbody);

// return setup
            $smsresult = false;
            if (isset($smsprocess['error_message'])) :
                $smsresult = 'Error: ' . $smsprocess['error_message'];
            else:
                $smsresult = 'success';
            endif;
        } catch (ClockworkException $e) {
            $smsresult = 'Error: ' . $e->getMessage();
        }

        return $smsresult;
    }

    /**
     * display step progress masthead
     *
     * @return PA_Calculator
     */
    public function step_masthead($step = 'two') {

        $extra = $step == 'three' ? ' - <strong>FINISHED!</strong>' : '';

        $mast = '';
        $mast .= '<div class="progress-masthead masthead-step-' . $step . '">';

        $mast .= '<div class="progress-column progress-one">';
        $mast .= '<p class="step-title">Step 1</p>';
        $mast .= '<p class="step-desc">Treatment Details</p>';
        $mast .= '</div>';

        $mast .= '<div class="progress-column progress-two">';
        $mast .= '<p class="step-title">Step 2</p>';
        $mast .= '<p class="step-desc">Get Competitive Offers</p>';
        $mast .= '</div>';

        $mast .= '<div class="progress-column progress-three">';
        $mast .= '<p class="step-title">Step 3</p>';
        $mast .= '<p class="step-desc">Get Calculated Cost' . $extra . '</p>';
        $mast .= '</div>';


        $mast .= '<div class="progress-bar">';
        $mast .= '</div>';

        $mast .= '</div>';

        return $mast;
    }

    /**
     * individual doctor display loop
     *
     * @return PA_Calculator
     */
    public function doctor_display($doctor_ids, $showlinks = false, $checkbox = true, $site_id) {

        if (!isset($doctor_ids) || empty($doctor_ids))
            return;
        $doctors = '';
        $doctors .= '<div class="provider-list">';
// loop through each provider
        foreach ($doctor_ids as $doctor_id) :
            $provider_all = $this->api_doctor_data_all($doctor_id, $site_id);
// provider details
            $provider = $provider_all->Listing;
            $media = $provider_all->Media;
            $profile_path = $media->Headshot['0']->Url != '' ? $media->Headshot['0']->Url : 'http://api.patientsguide.com/Image/User/' . $doctor_id;
            $userid = $provider->UserId;
            $name = $provider->DisplayName;
            $website = $provider->WebsiteUrl;
            $profile = !empty($provider->ProfileUrl) ? 'http://patientsguide.com' . $provider->ProfileUrl : '';
            $rating = $provider->Rating;
            $phone = $provider->PhoneNumber;
            $status = $provider->ListingType;
// provider address
            $street_1 = $provider->StreetAddress;
            $street_2 = $provider->StreetAddress2;
            $city = $provider->City;
            $state = $provider->State;
            $zip = $provider->Zip;
// headshot details
            // $image = 'http://api.patientsguide.com/Image/User/' . $doctor_id;

            $doctors .= '<div class="provider-single provider-' . $status . '" data-docid="' . $userid . '">';

            if ($checkbox === true)
                $doctors .= '<div class="provider-checkbox"><input type="checkbox" name="provider-choice[]" class="provider-choice" value="' . $userid . '" checked="yes"></div>';

            $doctors .= '<div class="provider-image">';
            $doctors .= '<div class="headshot">';
            $doctors .= '<img alt="' . $name . '" src="' . $profile_path . '">';
            $doctors .= '</div>';
            $doctors .= '</div>';
            $doctors .= '<div class="provider-details">';

            $doctors .= '<h6>' . $name . '</h6>';

            if (!empty($rating) || $rating !== 0)
                $doctors .= $this->rating_build($rating);


            if (!empty($phone))
                $doctors .= '<p class="phone"><a href="tel:' . $phone . '">' . $phone . '</a></p>';

            if ($showlinks === true) :
                $doctors .= '<p class="provider-links">';
                if (!empty($profile))
                    $doctors .= '<a class="provider-profile" href="' . addhttp($profile) . '">Profile</a>';
                if (!empty($website))
                    $doctors .= '<a class="provider-website" href="' . addhttp($website) . '">Website</a>';
                $doctors .= '</p>';
            endif;
            $doctors .= '<p class="address">';
            $doctors .= $street_1 . '<br />';

            if (!empty($street_2))
                $doctors .= $street_2 . '<br />';

            if (!empty($city))
                $doctors .= $city . ', ';

            if (!empty($state))
                $doctors .= $state;

            if (!empty($zip))
                $doctors .= ' ' . $zip;
            if (!empty($provider->Coupons)):
                foreach ($provider->Coupons as $coupons):
                    $doctors .= '<br/><a target="_blank" style=" font-size:13px; text-decoration: underline;font-weight: bold;color: rgb(165, 32, 35);" href="' . addhttp($coupons->DealUrl) . '">' . $coupons->Title . '</a>';
                endforeach;
            endif;
            $doctors .= '</p>';

            $doctors .= '</div>';

            $doctors .= '</div>';
        endforeach; // end individual provider display loop

        $doctors .= '</div>'; // end wrapping div around providers

        return $doctors;
    }

    /**
     * calculate financing range
     *
     * @return PA_Calculator
     */
    public function finance_range($total) {

// check our floor and ceiling amounts first
        if ($total <= 2000) :
            $finance = 41;
            return $finance;
        endif;

// or over our ceiling
        if ($total >= 25000) :
            $finance = 507;
            return $finance;
        endif;

// round down to the nearest thousands
        $round_cost = floor($total / 1000);
        $reset_cost = round($round_cost, 0, PHP_ROUND_HALF_DOWN) * 1000;

// get the increate amounts
        $base_cost = 2000;
        $inc_amts = ( $reset_cost - $base_cost ) / 1000;

        $base_amt = 41;
        $cost_add = 20;

        $finance = $base_amt + ( $inc_amts * $cost_add );


        return $finance;
    }

    /**
     * split out treatments into a nice list
     *
     * @return PA_Calculator
     */
    public function treatment_table($treat_data, $data) {

// handle calculations
        foreach ($treat_data as $data_id):
            $treat_costs[] = $data['calc-fields'][$data_id]['calc-cost'];
        endforeach;

        $total_cost = array_sum($treat_costs);

// an empty to keep it clean
        $table = '';

// now display it
        $table .= '<div class="pa-treatment-table">';
        $table .= '<p>Without payment plans, your upfront cash estimate for this procedure would be about <span class="cost-amt">$' . $total_cost . '</span></p>';

        $table .= '<ul class="treatment-line-items">';
        foreach ($treat_data as $data_id):

            if (!isset($data['calc-fields'][$data_id]['calc-desc'])) :

                $desc = 'Treatment for ' . $data['calc-fields'][$data_id]['calc-title'];

            else:

                $desc = $data['calc-fields'][$data_id]['calc-desc'];

                if (isset($data['calc-fields'][$data_id]['calc-sugst']))
                    $desc = '<a href="' . $data['calc-fields'][$data_id]['calc-sugst'] . '">' . $data['calc-fields'][$data_id]['calc-desc'] . '</a>';

            endif;

            $value = $data['calc-fields'][$data_id]['calc-cost'];

// split the array into line items
            $table .= '<li class="line-item">';
            $table .= '<span class="item-text">' . $desc . '</span>';
            $table .= '<span class="item-cost">$' . $value . '</span>';
            $table .= '</li>';

        endforeach;

        $table .= '<li class="line-total">';
        $table .= '<span class="item-text">Total without payment plans</span>';
        $table .= '<span class="item-cost">$' . $total_cost . '</span>';
        $table .= '</li>';

        $table .= '</ul>';
        $table .= '</div>';

        return $table;
    }

    public function set_html_content_type() {

        return 'text/html';
    }

    /**
     * send the lead emails to doctors
     *
     * @return PA_Calculator
     */
    public function email_lead_outbound($submit, $return, $api_count) {

// bail without having a return of doctors, since there are none to email
        if (!$return)
            return;

        $providers = array_slice($return, 0, $api_count);
        $email_arr = wp_list_pluck($providers, 'Email');

        foreach ($email_arr as $email_obj):

            $email_list = explode(';', $email_obj);
            $emails[] = $email_list[0];

        endforeach;

// switch to HTML format
        add_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

        foreach ($emails as $email) :

            $headers = 'From: Patients Guide <info@patientsguide.com>' . "\r\n";
            $message = "

			Name: " . $submit['name'] . "
			Email: " . $submit['email'] . "
			Phone: " . $submit['phone'] . "
			Zip Code: " . $submit['zip-code'] . "

			Treatment Areas: " . formatItems(array_keys($submit['treatments'])) . "

			Date Submitted: " . date('M jS Y @ g:ia', pa_zone_adjust(time())) . "

			Source Calculator: #" . $calc_id . ": " . $calc_title . "

			";

            wp_mail($email, "Patients Guide Lead", $message, $headers);

        endforeach;

// reset content-type
        remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));
    }

    /**
     * send the lead emails to internal
     *
     * @return PA_Calculator
     */
    public function email_lead_inbound($submit, $doc_ids, $data, $sendto, $site_id) {

        if ($doc_ids):

            foreach ($doc_ids as $doctor_id):
                $doctor = $this->api_doctor_data($doctor_id, $site_id);

                $email_list = $doctor->Email;
                $pieces = explode(';', $email_list);
                $doc_email = $pieces[0];

                $merge[] = $doctor->DisplayName . ' - ' . $doc_email;

            endforeach;

            $doc_string = implode('||', $merge);
            $provider_list = str_replace('||', '<br />', $doc_string);

        else:

            $provider_list = '(none in area)';

        endif;

// get stored treatments for labeling
        $treats = $data['calc-fields'];
        $treat_array = $submit['treatments'];
        foreach ($treat_array as $treat_id):
            $treat_types[] = $treats[$treat_id]['calc-title'];
        endforeach;

// get calculator form title
        $calc_id = $submit['calc_id'];
        $calc_title = get_the_title($calc_id);

// switch to HTML format
        add_filter('wp_mail_content_type', array($this, 'set_html_content_type'));

// name setup
        $first = isset($submit['first']) ? esc_attr($submit['first']) : '';
        $last = isset($submit['last']) ? esc_attr($submit['last']) : '';

// build output for extra fields
        $extras_output = $this->build_extra_fields_for_email($submit, $data);

// email
        $headers = 'From: Patients Guide <info@patientsguide.com>' . "\r\n";
        $message = "
		<html>
		<body>
		<h4><u>Submitted Lead Information:</u></h4>
		<table cellpadding='0' cellspacing='0' border='0'>

			<tr>
				<th width='150' align='left' valign='top'>Name:&nbsp;</th>
				<td width='600' valign='top'>" . $first . " " . $last . "</td>
			</tr>

			<tr>
				<th width='150' align='left' valign='top'>Email:&nbsp;</th>
				<td width='600' valign='top'>" . $submit['email'] . "</td>
			</tr>

			<tr>
				<th width='150' align='left' valign='top'>Phone:&nbsp;</th>
				<td width='600' valign='top'>" . $submit['phone'] . "</td>
			</tr>

			<tr>
				<th width='150' align='left' valign='top'>Zip Code:&nbsp;</th>
				<td width='600' valign='top'>" . $submit['zip-code'] . "</td>
			</tr>

			<tr>
				<th width='150' align='left' valign='top'>Treatment Areas:&nbsp;</th>
				<td width='600' valign='top'>" . formatItems($treat_types) . "</td>
			</tr>" .
                $extras_output
                . "<tr>
				<th width='150' align='left' valign='top'>Date Submitted:&nbsp;</th>
				<td width='600' valign='top'>" . date('M jS Y @ g:ia', pa_zone_adjust(time())) . "</td>
			</tr>

			<tr>
				<th width='150' align='left' valign='top'>Source Calculator:</th>
				<td width='600' valign='top'>#" . $calc_id . ": " . $calc_title . "</td>
			</tr>

		</table>
		<h4><u>Providers Returned:</u></h4>

		<p>" . $provider_list . "</p>
		";

        wp_mail($sendto, "Patients Guide Lead", $message, $headers);
// reset content-type
        remove_filter('wp_mail_content_type', array($this, 'set_html_content_type'));
    }

    /**
     * Build HTML for extra fields in email
     *
     * @param  array $submit [description]
     * @param  array $data   [description]
     * @return [type]         [description]
     */
    protected function build_extra_fields_for_email($submit, $data) {
        $extras_output = '';
        $extras = $submit['extras'];

        if ($extras) {
            $extras_output .= "<tr>";
            $extras_output .= "<th>&nbsp;</th><td>&nbsp;</td>";
            $extras_output .= "</tr>";
            foreach ($extras as $key => $value) {
                $extra = pa_get_extra_field_by_key($key, $data);
                if ($extra) {
                    $extras_output .= "<tr>";
                    $extras_output .= "<th width='150' align='left' valign='top'>" . $extra['extra-label'] . ":&nbsp;</th>";
                    if (is_array($value)) {
                        $extras_output .= "<td width='600' valign='top'>" . implode(', ', $value) . "</td>";
                    } else {
                        $extras_output .= "<td width='600' valign='top'>" . $value . "</td>";
                    }
                    $extras_output .= "</tr>";
                }
            }
            $extras_output .= "<tr>";
            $extras_output .= "<th>&nbsp;</th><td>&nbsp;</td>";
            $extras_output .= "</tr>";
        }

        return $extras_output;
    }

    /**
     * grab all the data, fields, etc for the initial step in the form
     *
     * @return PA_Calculator
     */
    public function form_step_one($data, $link, $site_id) {

// an empty to keep it clean
        $form = '';

// build form
        $form .= '<div id="pa-calc" class="pa-calc-step1 pa-form-wrap pa-form-step-one">';
        $form .= '<form class="pa-form-setup pa-form-group pa-form-group-one" action="' . $link . '?step=two" method="post">';

        if (!empty($data['form-title']))
            $form .= '<h2>' . $data['form-title'] . '</h2>';

        if (!empty($data['form-desc']))
            $form .= wpautop($data['form-desc']);


        $form .= '<div class="step-one-inner pa-form-inner">';

        if (!empty($data['questions-head']))
            $form .= '<div class="section-title"><h3>' . $data['questions-head'] . '</h3></div>';

// build out checkboxes
        if (!empty($data['calc-fields'])) :

            $form .= '<div class="calc-fields pa-form-fields">';

            $form .= '<div class="pa-field-group pa-checkbox-group">';

            if (!empty($data['fields-title']))
                $form .= '<h4>' . $data['fields-title'] . '</h4>';

            $form .= '<ul class="calc-field-group">';

            $calc_fields = $data['calc-fields'];

            foreach ($calc_fields as $key => $field):

                $title = $field['calc-title'];
                $name = strtolower(str_replace(array(' ', ','), array('-'), $title));
                $cost = $field['calc-cost'];

                $form .= '<li>';
                $form .= '<label for="' . $name . '">';

                $form .= '<input type="checkbox" name="pa-form-option[treatment-areas][' . $name . ']" id="' . $name . '" value="' . $key . '" />';
                $form .= ' ' . $title . '</label>';

// run check for thumbnails
                if ($data['fields-thumb'] == true && isset($field['calc-thumb']) && !empty($field['calc-thumb']))
                    $form .= '<img class="calc-thumb" src="' . $field['calc-thumb'] . '">';

                $form .= '</li>';

            endforeach;

            $form .= '</ul>';
            $form .= '</div>';

            $form .= '</div>';

        endif;

// build out extra fields
        if (!empty($data['extras'])) :

            $form .= '<div class="extra-fields pa-form-fields">';

            $extra_fields = $data['extras'];

            foreach ($extra_fields as $extra):

// Render a field based on the type
                $type = $extra['extra-type'];
                $render_function = "pa_render_{$type}_field";
                if (is_callable($render_function)) {
                    $form = call_user_func($render_function, $extra, $form);
                }

            endforeach;
            $zipCode = "";
            //if (isset($ammapi))
            {
                $location_info = $this->locate_by_ip_calculator();
                $zipCode = $location_info->ZipCode != '' ? $location_info->ZipCode : '';
            }
            $form .= '<div class="pa-field-group pa-zip-group">';
            $form .= '<h4>Zip Code</h4>';
            $form .= '<ul>';
            $form .= '<li><input type="text" name="pa-form-option[zip-code]" value="' . $zipCode . '" placeholder="Enter zip or postal code" /></li>';
            $form .= '</ul>';
            $form .= '</div>';

            $form .= '</div>';

        endif;

// submit button
        $form .= '<p class="pa-form-button">';
        $form .= '<input type="submit" value="' . $data['submit-text'] . '" id="pa-submit" class="submit-form pa-calc-button">';
        $form .= '</p>';

// hidden field for site ID
        $form .= '<input type="hidden" value="' . $site_id . '" name="pa-form-option[site-id]">';

// end form markup
        $form .= '</form>';

// end form inner wrapper
        $form .= '</div>';

// end entire form wrapper
        $form .= '</div>';

        return $form;
    }

    /**
     * parse the entered data and doctor info return for step two
     *
     * @return PA_Calculator
     */
    public function form_step_two($submit, $doc_ids, $link, $data, $site_id, $api_count) {
        if (!session_start()) {
            session_start();
        }
        ?>
        <script src="jquery.maskedinput.js" type="text/javascript"></script>
        <script>
            jQuery(function () {
                jQuery("#cost-submit-phone").mask("(999) 999-9999");

            });

        </script>
        <?php

        $_SESSION['nation_deal_info'] = $data;
// an empty to keep it clean
        $display = '';

// wrap the entire return
        $display .= '<div id="pa-calc" class="pa-calc-step2 pa-return-block">';

// put our progress masthead on top
        $display .= $this->step_masthead('two');

// get stored treatmets for labeling
        $treats = $data['calc-fields'];

// filter down values
        $areas = $submit['treatment-areas'];
        $extras = $submit['extras'];

// parse out submitted values to display
        $display .= '<div class="column-submitted-data pa-return-column">';

        $display .= '<div class="pa-column-inner-wrap">';

        $display .= '<div class="pa-column-details">';
// first hit treatment areas
        $display .= '<h4>Areas</h4>';
        $display .= '<ul class="treatment-items">';
        foreach ($areas as $key => $value):

            $display .= '<li class="' . $key . '">' . $treats[$value]['calc-title'] . '</li>';

        endforeach;
        $display .= '</ul>';
        $display .= '</div>';

// now check for any extras
        if (!empty($extras)) : foreach ($extras as $key => $value):

                $label = str_replace('-', ' ', $key);
                $label = ucwords($label);

                $display .= '<div class="pa-column-details">';
                $display .= '<h4>' . $label . '</h4>';
                $display .= '<ul class="treatment-items">';
                if (is_array($value)) {
                    foreach ($value as $treatment_item) {
                        $display .= '<li>' . $treatment_item . '</li>';
                    }
                } else {
                    $display .= '<li>' . $value . '</li>';
                }
                $display .= '</ul>';
                $display .= '</div>';

            endforeach;
        endif;

        $display .= '</div>';

        $display .= '</div>';

// parse out api return value
        $display .= '<div class="column-providers-return pa-return-column">';

        $display .= '<div class="pa-column-inner-wrap">';

        if (!empty($doc_ids)) :

            $count = !empty($api_count) ? $api_count : 3;

// just pull 3 (by default)
            $doctor_ids = array_slice($doc_ids, 0, $count);

        endif;

// display form
        $display .= '<div class="pa-column-details pa-cost-form">';

        $display .= '<h5>The local specialists displayed will send you competitive quotes so you can get the best deal.</h5>';

        $display .= '<form class="pa-cost-submit pa-form-group" action="' . $link . '?step=three" method="post">';

        $display .= '<div class="cost-form-field pa-field-group" data-type="text">';
        $display .= '<input type="text" placeholder="First Name" class="cost-field-input" name="cost-submit[first]" id="cost-submit-first">';
        $display .= '</div>';

        $display .= '<div class="cost-form-field pa-field-group" data-type="text">';
        $display .= '<input type="text" placeholder="Last Name" class="cost-field-input" name="cost-submit[last]" id="cost-submit-last">';
        $display .= '</div>';

        $display .= '<div class="cost-form-field pa-field-group" data-type="email">';
        $display .= '<input type="text" placeholder="Email" class="cost-field-input" name="cost-submit[email]" id="cost-submit-email">';
        $display .= '</div>';

        $display .= '<div class="cost-form-field pa-field-group" data-type="text">';
        $display .= '<input type="text" placeholder="Phone Number" class="cost-field-input" name="cost-submit[phone]" id="cost-submit-phone">';
        $display .= '</div>';

        $display .= '<p class="cost-form-submit">';
        $display .= '<input type="submit" class="cost-submit submit-form" value="Get My Calculated Cost!" id="pa-calculate" >';
        $display .= '</p>';

// hidden fields for the data already submitted
        foreach ($areas as $key => $value):

            $treat_type = str_replace(',', '', $key);
            $display .= '<input type="hidden" name="cost-submit[treatments][' . $treat_type . ']" value="' . $value . '" >';

        endforeach;

// Add hidden fields for the extra fields
        foreach ($extras as $key => $value) :

            if (is_array($value)) {
                foreach ($value as $sub_key => $sub_value) {
                    $display .= '<input type="hidden" name="cost-submit[extras][' . $key . '][' . $sub_key . ']" value="' . $sub_value . '" >';
                }
            } else {
                $display .= '<input type="hidden" name="cost-submit[extras][' . $key . ']" value="' . $value . '" >';
            }

        endforeach;

// include site ID zip code for secondary lookup
        $display .= '<input type="hidden" name="cost-submit[zip-code]" value="' . $submit['zip-code'] . '" >';
        $display .= '<input type="hidden" name="cost-submit[site-id]" value="' . $site_id . '" >';

// include a hidden field for each doctor ID to handle the exclusions
        if (!empty($doctor_ids)) : foreach ($doctor_ids as $doc_id):
                $display .= '<input type="hidden" data-docid="' . $doc_id . '" name="cost-submit[doc-id][]" value="' . $doc_id . '" >';
            endforeach;
        endif;
// add our blank notes

        $display .= '</form>'; // end form
        if (!empty($data['disclaimer'])) :

            $display .= '<div class="fine-print">';
            $display .= wpautop($data['disclaimer']);
            $display .= '</div>';

        endif;
        $display .= '</div>'; // end form block to the left of provider list

        $display .= '<div class="pa-column-details pa-doctors-details">';

// display list if we have doctors
        if (!empty($doctor_ids)):

            $display .= '<h5>Send my information to these local specialists.</h5>';

            $doctor_display = $this->doctor_display($doctor_ids, false, true, $site_id);

            $display .= $doctor_display;

        else: // display for potential empty return from API

            $display .= '<div class="no-doctors-nearby">';
            $display .= wpautop(stripslashes($data['nodoc-text-a']));
            $display .= '</div>'; // end missing doctor content

        endif;

        $display .= '</div>'; // end block of providers

        $display .= '</div>'; // end internal wrapper

        $display .= '</div>'; // end large middle column
// small 3rd column
        $display .= '<div class="column-almost-done pa-return-column">';

        $display .= '<div class="pa-column-inner-wrap">';

        $display .= '<div class="pa-column-details">';
        $display .= '<h4>Almost There!</h4>';
        $display .= '<p>Your calculated cost &amp; getting the best deal.</p>';
        $display .= '</div>';

        $display .= '</div>';

        $display .= '</div>'; // end small right column
// close up the entire thing
        $display .= '</div>';

        return $display;
    }

    /**
     * parse out final step of the form
     *
     * @return PA_Calculator
     */
    public function form_step_three($submit, $doc_ids, $data, $setup, $site_id) {

        if (!session_id()) {
            session_start();
        }
        $_SESSION['step_2_info'] = $_POST['cost-submit'];
        $procedure_id = isset($data['procedure-id']) ? $data['procedure-id'] : 0;
        $_SESSION['procedure_id'] = $procedure_id;
//// grab prosper details
        $widgeet = do_shortcode('[widget id="office_deals_plugin-3"]');

// parse and calculate the treatments
        $zipcode = $submit['zip-code'];
        $treat_data = $submit['treatments'];

// get stored treatments for labeling
        $treats = $data['calc-fields'];

        foreach ($treat_data as $key => $value):

// split the array in two for use later
            $treat_type[] = $treats[$value]['calc-title'];
            $treat_cost[] = $treats[$value]['calc-cost'];

        endforeach;

        $treat_list = formatItems($treat_type);
        $treat_table = $this->treatment_table($treat_data, $data);

        $finance_amt = $this->finance_range(array_sum($treat_cost));

// an empty to keep it clean
        $display = '';

// wrap the entire return
        $display .= '<div id="pa-calc" class="pa-calc-step3 pa-return-block pa-final-steps">';

// put our progress masthead on top
        $display .= $this->step_masthead('three');

// calculation display column
        $display .= '<div class="column-cost-info pa-return-column">';

        $display .= '<div class="pa-column-header">';
        $display .= '<h3>Cost Information:</h3>';
        $display .= '</div>';

        $display .= '<div class="pa-column-details">';
        $display .= '<div class="pa-column-inner-wrap">';
        $display .= '<h5>For ' . $treat_list . ' in ' . $zipcode . ':</h5>';

        /*
          $display .= '<div class="pa-prosper-amount">';

          $display .= '<p class="pbox-top">As little as</p>';
          $display .= '<p class="pbox-main">$'.$finance_amt.'</p>';
          $display .= '<p class="pbox-bottom">per month</p>';

          $display .= '</div>';
         */

        /*
          $display .= '<div class="pa-prosper-info">';

          $display .= '<a class="prosper-img-link" href="'.$prosper_url.'" target="_blank">';
          $display .= '<img class="prosper-logo-lg" src="'.plugins_url('/lib/img/prosper-logo-lg.png', __FILE__).'">';
          $display .= '</a>';

          $display .= '<p class="prosper-link">';
          $display .= '<a href="'.$prosper_url.'" target="_blank">'.$prosper_anchor.'</a>';
          $display .= '</p>';

          $display .= '</div>';
         */

        $display .= $treat_table;
        $display .= '<div class="pa-prosper-approval">';
        $display .= '<h5>Register For Savings Now</h5>';
// $display .= '<p>Use your Prosper Payment Plans at any office.</p>';

        global $ammapi;
        $prosper_url = '';
        if (isset($ammapi)) {
            $location_deals = $ammapi->search_Location_Deals($zipcode, $procedure_id);
        }
        if (!empty($location_deals)) {
            foreach ($location_deals as $value) {
                $prosper_url = $value->DealUrl;
                break;
            }
        }
        $prosper_url = $prosper_url == '' ? esc_url($data['nation-deal-url']) : $prosper_url;

        $array_data = $_SESSION['step_2_info'];
        // print_r($array_data);
        // first_name, last_name, email,phone_number,zip_code
        $first_name = $array_data['first'];
        $last_name = $array_data['last'];
        $email = $array_data['email'];
        $phone_number = $array_data['phone'];
        $dealurl_zip_code = $array_data['zip-code'];

        $prosper_url = $prosper_url != '' ? $prosper_url . '/?first_name=' . $first_name . '&last_name=' . $last_name . '&email=' . $email . '&phone_number=' . $phone_number . '&zip_code=' . $dealurl_zip_code : '';
        if ($prosper_url != '')
            $display .= '<a class="prosper-button" href="' . $prosper_url . '" target="_blank">See Discount Details</a>';

        $display .= '</div>';

        $display .= '</div>';
        $display .= '</div>';

        $display .= '</div>'; // end calculation display column
// next steps column
        $display .= '<div class="column-next-steps pa-return-column">';



        $display .= '<div class="pa-column-details">';
        $display .= '<div class="pa-column-inner-wrap">';

// display list if we have doctors
        //if (!empty($doc_ids)):
        $display .= '<div style="width:100%">';
        $display .= $widgeet;
        $display .= '</div>';
        //else: // display for potential empty return from API
        //  $display .= '<div class="no-doctors-nearby">';
        //$display .= wpautop(stripslashes($data['nodoc-text-b']));
        //$display .= '</div>'; // end missing doctor content
        //endif;
// last Prosper CTA
        $prosper_text = str_replace('{finance}', '$' . $finance_amt, $prosper_text);
        $display .= '<div class="pa-prosper-final">';
        $display .= '<p>' . $prosper_text . ' <a href="' . $prosper_url . '" target="_blank"></a></p>';
        $display .= '</div>'; // end final prosper cta
        $display .= '</div>'; // end block of providers
        $display .= '</div>'; // end inner wrap
        $display .= '</div>'; // end calculation display column
// close up the entire thing
        $display .= '</div>';
//$ab.= " echo do_shortcode('[widget id="office_deals_plugin-3"]');";
        return $display;
    }

    /**
     * load form display shortcode
     *
     * @return PA_Calculator
     */
    public function shortcode($atts, $content = null) {

        extract(shortcode_atts(array(
            'id' => 0,
                        ), $atts, 'pacalc'));

        $calc_id = $id;
// get variables
        $setup = get_option('pacalc_settings');
        $data = get_post_meta($calc_id, '_pacalc_data', true);

        $site_id = $setup['site-id'];
        $api_count = isset($setup['return-num']) ? $setup['return-num'] : 3;
        $sendto = $setup['send-to'];

// bail if the data is missing
        if (empty($data)) {
// back-compat check for options key
            $data = get_option('pacalc');

// If no old options key then bail
            if (empty($data)) {
                return;
            }
        }


// check for site ID. pretty much useless without it
        if (empty($setup['site-id']))
            return;

// get permalink of current page, so we can use it on our form submission
        $link = get_permalink(get_the_ID());

        $fields = null;

// step one setup
        if (!isset($_GET['step']) || isset($_GET['step']) && $_GET['step'] == 'one') {
            $fields = $this->form_step_one($data, $link, $site_id);
        }

// step two setup
        if (isset($_GET['step']) && $_GET['step'] == 'two') {

            $submit = isset($_POST['pa-form-option']) ? $_POST['pa-form-option'] : false;
            $zipcode = $submit['zip-code'];
            $_SESSION['zipcode'] = $zipcode;
            $procedure_id = !empty($data['procedure-id']) ? $data['procedure-id'] : -1;
            $_SESSION['procedureId'] = $procedure_id;
            $doctors = $this->api_doctor_search($zipcode, $site_id, $procedure_id);
            $doc_ids = !empty($doctors) ? $doctors : false;
            $fields = $this->form_step_two($submit, $doc_ids, $link, $data, $site_id, $api_count);
        }

// step three setup
        if (isset($_GET['step']) && $_GET['step'] == 'three') {

            $submit = isset($_POST['cost-submit']) ? $_POST['cost-submit'] : false;
            $doc_ids = !empty($submit['doc-id']) ? $submit['doc-id'] : false;
            $fields = $this->form_step_three($submit, $doc_ids, $data, $setup, $site_id);

// Add the calculator id into the submit array, so we don't have to change the function signatures
            $submit['calc_id'] = $calc_id;

            $procedure_id = !empty($data['procedure-id']) ? $data['procedure-id'] : -1;
// send emails
            $this->email_lead_inbound($submit, $doc_ids, $data, $sendto, $site_id);
//	$this->email_lead_outbound( $submit, $doc_ids );
// send SMS
            $textmsg = $this->send_sms($submit, $setup, $procedure_id);


            if ($textmsg == "success") {
                $leadsubmit = $this->api_submit_lead($submit['first'], $submit['last'], $submit['phone'], $submit['email'], $submit['zip-code'], $doc_ids, $site_id, $procedure_id);
                $ckm_campaign_id = !empty($data['ckm-campaign-id']) ? $data['ckm-campaign-id'] : '';
                $ckm_key = !empty($data['ckm-key']) ? $data['ckm-key'] : '';
                if ($ckm_campaign_id != '' && $ckm_key != '') {
// parse and calculate the treatments
                    $zipcode = $submit['zip-code'];
                    $treat_data = $submit['treatments'];

// get stored treatments
                    $treats = $data['calc-fields'];
                    $treatment_area = '';
                    foreach ($treat_data as $key => $value) {
                        $treatment_area .= $treatment_area == '' ? $treats[$value]['calc-title'] : "," . $treats[$value]['calc-title'];
                    }
                    $cake_fields = !empty($data['cake-fields']) ? $data['cake-fields'] : '';
                    $extra_pram = array();
                    if ($cake_fields != '') {
                        foreach ($cake_fields as $item) {
                            $key = $item['cake-field-name'];
                            $extra_pram[$key] = $item['cake-field-value'];
                        }
                    }
                    $procedures = $this->get_procedures();
                    $treatment = '';
                    foreach ($procedures as $item) {
                        if ($item->Id == $procedure_id) {
                            $treatment = $item->Name;
                            break;
                        }
                    }
                    $leadsubmitcake = $this->api_submit_lead_cake($ckm_campaign_id, $ckm_key, $submit['first'], $submit['last'], '', $submit['zip-code'], $submit['email'], $submit['phone'], $submit['phone'], $treatment_area, $treatment, $extra_pram);
                }
            }
// write to log file
            $logging = PA_Calculator_Logging::getInstance();
            $logged = $logging->log_submission($submit, $doc_ids, $textmsg, $site_id);
        }

// now send it all back
        return $fields;
    }

    /**
     * load front-end CSS if shortcode is present
     *
     * @return PA_Calculator
     */
    public function front_scripts() {

        global $post;

        if (!isset($post)) {
            return;
        }

        if (has_shortcode($post->post_content, 'pacalc')) :

// Allow styles to be turned on/off
            if (apply_filters('pa_calc_load_front_end_styles', true)) {
                wp_enqueue_style('pac-style', plugins_url('lib/css/pac.style.css', __FILE__), array(), PAC_VER, 'all');
            }

// Allow JS to be turned on/off
            if (apply_filters('pa_calc_load_front_end_scripts', true)) {
                wp_enqueue_script('pac-init', plugins_url('lib/js/pac.init.js', __FILE__), array('jquery'), PAC_VER, true);
            }

        endif;
    }

    /**
     * Wrapper method to locate user by IP Address
     *
     * @return void
     * @author Aaron Brazell
     */
    function locate_by_ip_calculator() {
        try {
            $amm_url = AMM_API_URL;
            $amm_key = AMM_API_KEY;
            if ($_SERVER['REMOTE_ADDR']) {
                $ip = (string) $_SERVER['REMOTE_ADDR'];
            }
            if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
                $ip = (string) $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            $url = esc_url_raw($amm_url . '/locate/ip/' . $ip . '?key=' . $amm_key . '&cache=false');
            $data = wp_remote_get($url);
            if (is_wp_error($data))
                return $data->get_error_message();
            //_save_cookie($data);
            $location = $this->_save_location_cookie($data);
            return $location;
        } catch (Exception $exc) {
            error_log($exc);
            echo $exc->getTraceAsString();
        }
    }

    /**
     * Saves location object for reuse in a session
     *
     * @param string $response
     * @param boolean $body_only
     * @return object
     * @author Aaron Brazell
     */
    function _save_location_cookie($response, $body_only = true) {
        $json = ( $body_only ) ? json_decode(wp_remote_retrieve_body($response)) : json_decode($response);
        $_SESSION['pg_locale_info'] = $json;
        return $json;
    }

    /**
     * Wrapper method to locate user by Zip/Postal code
     *
     * @param string $zip
     * @return void
     * @author Aaron Brazell
     */
//function locate_by_zip($zip) {
//    $url = esc_url_raw($this->api_url . '/locate/zip/' . $zip . '/?key=' . $this->api_key);
//    if (class_exists('AB_API_Logger')) {
//        global $ab_api_logger;
//        $ab_api_logger->log_api_call($ab_api_logger->api_calls, $url);
//    }
//    $data = wp_remote_get($url, $this->headers);
//    if (is_wp_error($data))
//        return $data->get_error_message();
//    //$this->_save_cookie( $data, true );
//    $location = _save_location_cookie($data);
//    return $location;
//}

    /**
     * Saves header cookie that is to be sent with subsequent API request
     *
     * @param string $response
     * @return string
     * @author Aaron Brazell
     */
    function _save_cookie($response, $override = false) {
        if ($override && !$response['headers']['set-cookie'])
            return false;

        $exp = time() + 86400;
        $domain = str_replace(array('https://', 'http://'), '', get_option('siteurl'));
        $cookie = str_replace('pg_loc=', '', $response['headers']['set-cookie']);
        $_SESSION['pg_loc'] = $cookie;
        setcookie('pg_loc', $cookie, $exp, '/', $domain, false, false);
        return $cookie;
    }

/// end class
}

// Instantiate our class
$PA_Calculator = PA_Calculator::getInstance();
