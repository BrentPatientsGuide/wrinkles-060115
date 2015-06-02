<?php

/**
 * Plugin Name: Office Deals
 * Description: A custom Widgets plugin built that gives call to an Api and return Coupons Array information.
 * Version: 1.0
 * Author: BLSSOL
 * 
 */
class office_deals_plugin extends WP_Widget {

// constructor
    function office_deals_plugin() {
        parent::WP_Widget(false, $name = __('Nearby Office Deals', 'wp_widget_plugin'));
    }

    function deals_scripts_styles() {
        // Register the script like this for a plugin:
        wp_register_script('custom-script', plugins_url('/js/custom.js', __FILE__));
        wp_register_style('custom-style', plugins_url('/css/style.css', __FILE__), array(), '20120208', 'all');

        // For either a plugin or a theme, you can then enqueue the script:
        wp_enqueue_script('custom-script');
        wp_enqueue_style('custom-style');
    }

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

// widget form creation
    function form($instance) {

// Check values
        if ($instance) {
            $title = esc_attr($instance['title']);
            $Procedure = esc_attr($instance['procedure']);
            $textarea = $instance['textarea'];
        } else {
            $title = '';
            $textarea = '';
            $Procedure = '';
        }
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('procedure'); ?>"><?php _e('Procedure', 'wp_widget_plugin'); ?></label>
            <select id="<?php echo $this->get_field_id('procedure'); ?>" name="<?php echo $this->get_field_name('procedure'); ?>" class="widefat" style="width:100%;">
                <option value="0"></option>
                <?php foreach ($this->get_procedures() as $term) { ?>
                    <option <?php selected($instance['procedure'], $term->Id); ?> value="<?php echo $term->Id; ?>"><?php echo $term->ShortName; ?></option>
                <?php } ?>      
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Description:', 'wp_widget_plugin'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>" rows="7" cols="20" ><?php echo $textarea; ?></textarea>
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
// Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['procedure'] = strip_tags($new_instance['procedure']);
        $instance['textarea'] = strip_tags($new_instance['textarea']);
        return $instance;
    }

// display widget
    function widget($args, $instance) {

        global $ammapi;
        $Procedureid = $instance['procedure'];
        if (!isset($Procedureid)) {
            $Procedureid = 0;
        }
        $location_info = $this->locate_by_ip_office();
        $Zip = $location_info->ZipCode != '' ? $location_info->ZipCode : '';
        $ZipCode = $Zip;
        if (isset($_SESSION['zipcode']) && $_SESSION['zipcode'] != null) {
            if ($Zip != $_SESSION['zipcode']) {
                $ZipCode = $_SESSION['zipcode'];
            }
            $_SESSION['zipcode'] = null;
            unset($_SESSION['zipcode']);
        }

        if (isset($_SESSION['procedure_id'])) {
            $Procedureid = $_SESSION['procedure_id'];
            unset($_SESSION['procedure_id']);
        }

        $location_deals = $ammapi->search_Location_Deals($ZipCode, $Procedureid);

        if (isset($location_deals) && count($location_deals) > 0 && isset($location_deals[0]->Title)) {
            $this->deals_scripts_styles();
            extract($args);

            // these are the widget options
            $title = apply_filters('widget_title', $instance['title']);
            //$textarea = $instance['textarea'];
            echo $before_widget;
            // Display the widget
            echo '<div class="widget-text wp_widget_plugin_box deal-home">';
            echo '<div class="titlee">';
            // Check if title is set
            if ($title) {
                echo $before_title . $title . $after_title;
            }
            echo '</div>';
            $isFirst = true;
            $counter = 1;
            foreach ($location_deals as $value) {
                if ($counter > 3) {
                    break;
                }

                $Dealtitle = $value->Title;
                $Dealdescription = $value->Description;
                $Dealurl = $value->DealUrl;
                $DealStandardimageurl = $value->StandarsImageUrl;
                $Dealthumbnailurl = $value->ThumbnailUrl;
                // $Dealenddate = $value->EndDate;
                $DealStartdate = $value->StartDate;
                if (!preg_match('/http/', $Dealurl)) {
                    $Dealurl = 'http://' . $Dealurl;
                }
                // print_r($_SESSION['nation_deal_info']);
                if (isset($_SESSION['step_2_info'])) {
                    $array_data = $_SESSION['step_2_info'];
                    // first_name, last_name, email,phone_number,zip_code 
                    $first_name = $array_data['first'];
                    $last_name = $array_data['last'];
                    $email = $array_data['email'];
                    $phone_number = $array_data['phone'];
                    $dealurl_zip_code = $array_data['zip-code'];

                    $Dealurl = $Dealurl . '/?first_name=' . $first_name . '&last_name=' . $last_name . '&email=' . $email . '&phone_number=' . $phone_number . '&zip_code=' . $dealurl_zip_code;
                }


                $opentime = preg_replace("/[^0-9]/", '', $value->EndDate);
                preg_match('/[0-9]+/', $opentime, $matches);
                $Dealenddate = date('m/d', $matches[0] / 1000);

                // http://api.patientsguide.com//Media/84b67ceb7ef156bfc5808398116fe9a2.jpg
                echo '<div class="deal-item">';
                if ($Dealthumbnailurl != '') {
                    echo '<div class="deal-image">';
                    echo '<img src="' . $Dealthumbnailurl . '" alt="" />';
                    echo '</div>';
                }
                echo '<div class="widgdeals">';
                echo '<span class="Dealstitle">' . $Dealtitle . '</span>';
                echo '<br>';
                echo '<span class="Deals" style="color:#F00;">Sale End ' . $Dealenddate . '</span>';
                echo '<br>';
                echo '<a href="' . $Dealurl . '" title="Coupons" target="_blank"><span class="Coupons" style="color:#e6ae48;  font-size: 14px; text-decoration: underline;">Click Here for Offer</span></a>';

                echo '</div>';
                echo '</div>';

                echo '<br>';
                $counter++;
            }
            // 
            echo '</div>';

            echo $after_widget;
        } else {
            if (isset($_SESSION['nation_deal_info'])) {

                $title = apply_filters('widget_title', $instance['title']);

                echo $before_widget;
                // Display the widget
                echo '<div class="widget-text wp_widget_plugin_box deal-home">';
                echo '<div class="titlee">';
                // Check if title is set
                if ($title) {
                    echo '<h2 class="widg">' . $title . '</h2>';
                }
                echo '</div>';
                $national = $_SESSION['nation_deal_info'];
                $nationaldealurl = $national['nation-deal-url'];
                $nationaldealtext = $national['nation-deal-text'];
                $nationaldealimageurl = $national['nation-deal-image-url'];
                echo '<div class="deal-item">';
                if ($nationaldealimageurl != '') {
                    echo '<div class="deal-image" style="float: left;">';
                    echo '<img src="' . $nationaldealimageurl . '" alt="" />';
                    echo '</div>';
                }
                echo '<div class="widgdeals" style="  width: 75%; float: right;">';
                echo '<span class="Dealstitle">' . $nationaldealtext . '</span>';
                echo '<br>';

                echo '<a href="' . $nationaldealurl . '" title="Coupons" target="_blank"><span class="Coupons" style="color:#e6ae48;  font-size: 14px; text-decoration: underline;">Click Here for Offer</span></a>';

                echo '</div>';
                echo '</div>';
                echo $after_widget;
            }
        }
    }

    function locate_by_ip_office() {
        try {
            $amm_url = AMM_API_URL;
            $amm_key = AMM_API_KEY;
            if ($_SERVER['REMOTE_ADDR'])
                $ip = (string) $_SERVER['REMOTE_ADDR'];
            if ($_SERVER['HTTP_X_FORWARDED_FOR'])
                $ip = (string) $_SERVER['HTTP_X_FORWARDED_FOR'];
            $url = esc_url_raw($amm_url . '/locate/ip/' . $ip . '/?key=' . $amm_key . '&cache=false');
            $data = wp_remote_get($url);
            if (is_wp_error($data))
                return $data->get_error_message();
            //$this->_save_cookie($data);
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

}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("office_deals_plugin");'));
add_action('wp_enqueue_scripts', 'deals_scripts_styles');
?>