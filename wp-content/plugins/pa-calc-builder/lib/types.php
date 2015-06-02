<?php
if (!defined('PAC_BASE'))
    define('PAC_BASE', plugin_basename(__FILE__));

if (!defined('PAC_VER'))
    define('PAC_VER', '1.1.1');

if (!defined('AMM_API_KEY'))
    define('AMM_API_KEY', 'TOpjEBEgReZD8gZabkkYL9lIaEEHF2MaV5-LT7KovbulH0yArgVsKg2');

if (!defined('AMM_API_URL'))
    define('AMM_API_URL', 'http://api.patientsguide.com');

if (!defined('AMM_USE_CACHE'))
    define('AMM_USE_CACHE', 'false');
/*
  Custom Post Type for calculators and related functions
 */

// Start up the engine
class PA_Calculator_Calc {

    /**
     * Static property to hold our singleton instance
     * @var PA_Calculator_Calc
     */
    static $instance = false;

    /**
     * @var post type name
     */
    const POST_TYPE = 'pa-calc';

    /**
     * This is our constructor, which is private to force the use of
     * getInstance() to make this a Singleton
     *
     * @return PA_Calculator_Calc
     */
    private function __construct() {
        add_action('init', array($this, '_register_calc'));
        add_action('add_meta_boxes', array($this, 'calc_metabox'));
        add_action('save_post', array($this, 'form_store'));

        // Remove quick editing from the pa-calc post type row actions.
        add_filter('post_row_actions', array($this, 'row_actions'));

        // Manage post type columns.
        add_filter('manage_edit-pa-calc_columns', array($this, 'calc_columns'));
        add_filter('manage_pa-calc_posts_custom_column', array($this, 'calc_custom_columns'), 10, 2);

        add_filter('wp_insert_post_data', array($this, 'map_form_title_to_post_title'), 10, 2);

        // Flush cache
        add_action('save_post', array($this, 'flush_cache'), 10, 2);
    }

    /**
     * If an instance exists, this returns it.  If not, it creates one and
     * retuns it.
     *
     * @return PA_Calculator_Calc
     */
    public static function getInstance() {
        if (!self::$instance)
            self::$instance = new self;
        return self::$instance;
    }

    public function _register_calc() {
        register_post_type(self::POST_TYPE, array(
            'labels' => array(
                'menu_name' => __('Cost Calculators'),
                'name' => __('Cost Calculators'),
                'singular_name' => __('Cost Calculator'),
                'add_new' => __('Add New'),
                'add_new_item' => __('Add New Cost Calculator'),
                'edit' => __('Edit'),
                'edit_item' => __('Edit Cost Calculator'),
                'new_item' => __('New Cost Calculator'),
                'view' => __('View Cost Calculator'),
                'view_item' => __('View Cost Calculator'),
                'search_items' => __('Search Cost Calculators'),
                'not_found' => __('No Cost Calculators found'),
                'not_found_in_trash' => __('No Cost Calculators found in Trash'),
            ),
            'public' => false,
            'show_ui' => true,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => 'calculator', // Puts it under the Calculator menu item
            'description' => 'Customizable cost calculators',
            'hierarchical' => false,
            'menu_position' => 88,
            'capability_type' => 'post',
            'menu_icon' => null,
            'query_var' => false,
            'rewrite' => false,
            'has_archive' => false,
            'supports' => false
                )
        );
    }

    public function calc_metabox() {
        add_meta_box(
                'pa-calc-fields', __('Calculator Settings', 'pac'), array($this, 'output_calc_metabox'), self::POST_TYPE
        );
    }

    public function output_calc_metabox($post) {
        if (!current_user_can('manage_options'))
            return;
        $procedures = $this->get_procedures();
        ?>
        <div class="inner-form-text">
            <p><?php _e('The available form items', 'pac') ?></p>
            <?php if ('publish' == $post->post_status) { ?>
                <strong><?php _e('To display the form, use the following shortcode', 'pac') ?></strong>  <code>[pacalc id="<?php echo $post->ID; ?>"]</code>
            <?php } else { ?>
                <strong><?php _e('The shortcode will be shown here once the calculator is published.', 'pac') ?></strong>
            <?php } ?>
        </div>
        <div class="inner-form-options">
            <?php
            // Add an nonce for security
            wp_nonce_field('pacalc_metabox', 'pacalc_metabox_nonce');

            $data = get_post_meta($post->ID, '_pacalc_data', true);

            $form_title = !empty($data['form-title']) ? $data['form-title'] : '';
            $form_desc = !empty($data['form-desc']) ? $data['form-desc'] : '';
            $questions_head = !empty($data['questions-head']) ? $data['questions-head'] : '';
            $fields_title = !empty($data['fields-title']) ? $data['fields-title'] : '';
            $fields_thumb = !empty($data['fields-thumb']) ? $data['fields-thumb'] : '';
            $submit_text = !empty($data['submit-text']) ? $data['submit-text'] : 'Submit';
            $procedure_id = !empty($data['procedure-id']) ? $data['procedure-id'] : '';
            $disclaimer = !empty($data['disclaimer']) ? $data['disclaimer'] : '';
            $nodoctext_a = !empty($data['nodoc-text-a']) ? $data['nodoc-text-a'] : '';
            $nodoctext_b = !empty($data['nodoc-text-b']) ? $data['nodoc-text-b'] : '';
            $ckm_campaign_id = !empty($data['ckm-campaign-id']) ? $data['ckm-campaign-id'] : '';
            $ckm_key = !empty($data['ckm-key']) ? $data['ckm-key'] : '';

            $nation_deal_text = !empty($data['nation-deal-text']) ? $data['nation-deal-text'] : '';
            $nation_deal_url = !empty($data['nation-deal-url']) ? $data['nation-deal-url'] : '';
            $nation_deal_image_url = !empty($data['nation-deal-image-url']) ? $data['nation-deal-image-url'] : '';
            ?>

            <div id="form-details-static" class="form-table pa-calc-table">
                <h2><?php _e('Freeform Fields', 'pac') ?></h2>
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
                                'media_buttons' => false,
                                'teeny' => true,
                                'textarea_rows' => 7,
                                'textarea_name' => 'form-desc'
                            );
                            wp_editor(stripslashes($form_desc), 'formdesc', $args);
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
                        <span class="label"><label for="procedure"><?php _e('Calculator Procedure', 'pac'); ?></label></span>
                        <span class="input">
                            <select name="procedure" id="procedure">
                                <?php
                                foreach ($procedures as $item) {
                                    ?>
                                    <option <?php echo $item->Id == $procedure_id ? "selected" : ""; ?> value="<?php echo $item->Id; ?>"><?php echo $item->Name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </span>
                    </li>
                    <li>
                        <span class="label"><label for="disclaimer"><?php _e('Disclaimer Text', 'pac'); ?></label></span>
                        <span class="input">
                            <input type="text" class="widefat" id="disclaimer" name="disclaimer" value="<?php echo esc_attr($disclaimer); ?>" />
                        </span>
                        <p class="disclaimer"><?php _e('Disclaimer text to display below the submit button.', 'pac'); ?></p>
                    </li>
                    <li>
                        <span class="label"><label for="ckm_campaign_id"><?php _e('CKM Campaign Id', 'pac'); ?></label></span>
                        <span class="input">
                            <input type="text" class="widefat" id="ckm_compaign_id" name="ckm_campaign_id" value="<?php echo esc_attr($ckm_campaign_id); ?>" />
                        </span>
                        <p class="disclaimer"><?php _e('Cake API campaign id.', 'pac'); ?></p>
                    </li>
                    <li>
                        <span class="label"><label for="ckm_key"><?php _e('CKM API Key', 'pac'); ?></label></span>
                        <span class="input">
                            <input type="text" class="widefat" id="ckm_key" name="ckm_key" value="<?php echo esc_attr($ckm_key); ?>" />
                        </span>
                        <p class="disclaimer"><?php _e('Cake API key.', 'pac'); ?></p>
                    </li>
                    <li>
                        <span class="label"><label for="nation_deal_text"><?php _e('Nation deal text', 'pac'); ?></label></span>
                        <span class="input">
                            <input type="text" class="widefat" id="ckm_compaign_id" name="nation_deal_text" value="<?php echo esc_attr($nation_deal_text); ?>" />
                        </span>
                        <p class="disclaimer"><?php _e('Nation deal text.', 'pac'); ?></p>
                    </li>
                    <li>
                        <span class="label"><label for="nation_deal_url"><?php _e('Nation deal URL', 'pac'); ?></label></span>
                        <span class="input">
                            <input type="text" class="widefat" id="ckm_compaign_id" name="nation_deal_url" value="<?php echo esc_attr($nation_deal_url); ?>" />
                        </span>
                        <p class="disclaimer"><?php _e('Nation deal url.', 'pac'); ?></p>
                    </li>
                    <li>
                        <span class="label"><label for="ckm_campaign_image"><?php _e('Nation deal image path', 'pac'); ?></label></span>
                        <span class="input">
                            <input type="text" class="widefat" id="ckm_compaign_id" name="nation_deal_image_url" value="<?php echo esc_attr($nation_deal_image_url); ?>" />
                        </span>
                        <p class="disclaimer"><?php _e('Nation deal image url.', 'pac'); ?></p>
                    </li>
                </ul>
            </div>

            <div id="cake-fields" class="form-table pa-calc-table">
                <h3><?php _e('Cake Extra Parameters', 'pac') ?></h3>
                <ul>
                    <li class="calc-field-titles">
                        <span class="icon calc-head calc-remove-head">&nbsp;</span>
                        <span class="pthumb calc-head calc-thumb-head"><?php _e('Parameter Name', 'pac'); ?></span>
                        <span class="desc calc-head calc-desc-head"><?php _e('Parameter Value', 'pac'); ?></span>
                    </li>
                    <?php
                    $calcs = isset($data['cake-fields']) ? $data['cake-fields'] : '';
                    $fields = $this->calc_cake_extra_fields($calcs);
                    echo $fields;
                    ?>
                </ul>
                <p class="calc-field-button-row">
                    <input type="button" id="cake-clone" class="button button-secondary field-clone" value="Add Option">
                </p>
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
                    <?php if (apply_filters('pa_calc_show_thumbs_option', true)) { ?>
                        <li>
                            <span class="label"><label for="fields-thumb"><?php _e('Thumbnails', 'pac'); ?></label></span>
                            <span class="input">
                                <input type="checkbox" class="fields-thumb" id="fields-thumb" name="fields-thumb" value="1" <?php checked($fields_thumb, 1); ?> />
                                <span class="description"> <?php _e('check this box to use thumbnail images, 60px by 60px', 'pac'); ?></span>
                            </span>
                        </li>
                    <?php } ?>
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
                    $calcs = isset($data['calc-fields']) ? $data['calc-fields'] : '';
                    $fields = $this->calc_fields($calcs);
                    echo $fields;
                    ?>
                </ul>
                <p class="calc-field-button-row">
                    <input type="button" id="calc-clone" class="button button-secondary field-clone" value="Add Option">
                </p>
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
                    $extras = isset($data['extras']) ? $data['extras'] : '';
                    $fields = $this->extra_fields($extras);
                    echo $fields;
                    ?>
                </ul>
                <p class="calc-field-button-row">
                    <input type="button" id="extra-clone" class="button button-secondary field-clone" value="Add Form Field">
                </p>

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
                                'media_buttons' => true,
                                'teeny' => true,
                                'textarea_rows' => 7,
                                'textarea_name' => 'nodoc-text-a'
                            );
                            wp_editor(stripslashes($nodoctext_a), 'nodoctexta', $args);
                            ?>
                        </span>
                        <p class="disclaimer"><?php _e('Text for display when no doctors are returned in the zip code', 'pac'); ?></p>
                    </li>
                    <li>
                        <span class="label"><label for="nodoctextb"><?php _e('Step 3 Text', 'pac'); ?></label></span>
                        <span class="input">
                            <?php
                            $args = array(
                                'media_buttons' => true,
                                'teeny' => true,
                                'textarea_rows' => 7,
                                'textarea_name' => 'nodoc-text-b'
                            );
                            wp_editor(stripslashes($nodoctext_b), 'nodoctextb', $args);
                            ?>
                        </span>
                        <p class="disclaimer"><?php _e('Text for display when no doctors are returned in the zip code', 'pac'); ?></p>
                    </li>
                </ul>
            </div>

        </div>
        <?php
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
     * Grab repeating fields for calculator
     *
     * @return PA_Calculator_Calc
     */
    public function calc_cake_extra_fields($data) {

        $fields = '';

        // grab our data array and filter through
        if (!empty($data)) : foreach ($data as $item) :

                $cake_field_name = !empty($item['cake-field-name']) ? $item['cake-field-name'] : '';
                $cake_field_value = !empty($item['cake-field-value']) ? $item['cake-field-value'] : '';


                $fields .= '<li class="calc-field-row calc-cake-row">';
                $fields .= '<span class="icon">';
                $fields .= '<i class="dashicons dashicons-no-alt calc-row-remove" title="Remove ' . $cake_field_name . '"></i>';
//				$fields .= '<input type="button" title="Remove '.$title.'" class="calc-row-remove" value="'. __('Remove', 'pac') .'" />';
                $fields .= '</span>';

                $fields .= '<span class="pthumb">';
                $fields .= '<input type="text" class="regular-text cake-field-name" name="cake-field-name[]" value="' . $cake_field_name . '" />';
                $fields .= '</span>';

                $fields .= '<span class="pthumb">';
                $fields .= '<input type="text" class="small-text cake-field-value" name="cake-field-value[]" value="' . $cake_field_value . '" />';
                $fields .= '</span>';

                // Add a filter so the mobile version can edit this field group
                $fields = apply_filters('pa_calc_field_inputs', $fields, $item);

                $fields .= '</li>';

            endforeach;
        endif;

        // display an empty fieldset if we don't have any data saved yet
        if (empty($data)) :
            $fields .= '<li class="calc-field-row calc-cake-row">';
            $fields .= '<span class="icon">';
            $fields .= '&nbsp;';
            $fields .= '</span>';

            $fields .= '<span class="pthumb">';
            $fields .= '<input type="text" class="regular-text cake-field-name" name="cake-field-name[]" value="" />';
            $fields .= '</span>';

            $fields .= '<span class="pthumb">';
            $fields .= '<input type="text" class="small-text cake-field-value" name="cake-field-value[]" value="" />';
            $fields .= '</span>';

            // Add a filter so the mobile version can edit this field group
            $fields = apply_filters('pa_calc_field_inputs', $fields, null);

            $fields .= '</li>';
        endif;

        // our hidden field for repeating magic
        $fields .= '<li class="cake-empty-row screen-reader-text">';
        $fields .= '<span class="icon">';
        $fields .= '<i class="dashicons dashicons-no-alt calc-row-remove" title="Remove"></i>';
//				$fields .= '<input type="button" class="calc-row-remove" value="'. __('Remove', 'pac') .'" />';
        $fields .= '</span>';

        $fields .= '<span class="pthumb">';
        $fields .= '<input type="text" class="regular-text cake-field-name" name="cake-field-name[]" value="" />';
        $fields .= '</span>';

        $fields .= '<span class="pthumb">';
        $fields .= '<input type="text" class="small-text cake-field-value" name="cake-field-value[]" value="" />';
        $fields .= '</span>';

        // Add a filter so the mobile version can edit this hidden field group
        $fields = apply_filters('pa_calc_hidden_fields', $fields, null);

        $fields .= '</li>';

        return $fields;
    }

    /**
     * Grab repeating fields for calculator
     *
     * @return PA_Calculator_Calc
     */
    public function calc_fields($data) {

        $fields = '';

        // grab our data array and filter through
        if (!empty($data)) : foreach ($data as $item) :

                $title = !empty($item['calc-title']) ? $item['calc-title'] : '';
                $cost = !empty($item['calc-cost']) ? $item['calc-cost'] : '';
                $thumb = !empty($item['calc-thumb']) ? $item['calc-thumb'] : '';
                $desc = !empty($item['calc-desc']) ? $item['calc-desc'] : '';
                $sugst = !empty($item['calc-sugst']) ? $item['calc-sugst'] : '';


                $fields .= '<li class="calc-field-row">';
                $fields .= '<span class="icon">';
                $fields .= '<i class="dashicons dashicons-no-alt calc-row-remove" title="Remove ' . $title . '"></i>';
//				$fields .= '<input type="button" title="Remove '.$title.'" class="calc-row-remove" value="'. __('Remove', 'pac') .'" />';
                $fields .= '</span>';

                $fields .= '<span class="title">';
                $fields .= '<input type="text" class="regular-text calc-title" name="calc-title[]" value="' . $title . '" />';
                $fields .= '</span>';

                $fields .= '<span class="cost">';
                $fields .= '<input type="text" class="small-text calc-cost" name="calc-cost[]" value="' . $cost . '" />';
                $fields .= '</span>';

                $fields .= '<span class="pthumb">';
                $fields .= '<input type="url" class="regular-text calc-thumb" name="calc-thumb[]" value="' . esc_url($thumb) . '" />';
                $fields .= '</span>';

                $fields .= '<span class="desc">';
                $fields .= '<input type="text" class="regular-text calc-desc" name="calc-desc[]" value="' . $desc . '" />';
                $fields .= '</span>';

                $fields .= '<span class="sugst">';
                $fields .= '<input type="url" class="regular-text calc-sugst" name="calc-sugst[]" value="' . $sugst . '" />';
                $fields .= '</span>';

                // Add a filter so the mobile version can edit this field group
                $fields = apply_filters('pa_calc_field_inputs', $fields, $item);

                $fields .= '</li>';

            endforeach;
        endif;

        // display an empty fieldset if we don't have any data saved yet
        if (empty($data)) :
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

            // Add a filter so the mobile version can edit this field group
            $fields = apply_filters('pa_calc_field_inputs', $fields, null);

            $fields .= '</li>';
        endif;

        // our hidden field for repeating magic
        $fields .= '<li class="calc-empty-row screen-reader-text">';
        $fields .= '<span class="icon">';
        $fields .= '<i class="dashicons dashicons-no-alt calc-row-remove" title="Remove"></i>';
//				$fields .= '<input type="button" class="calc-row-remove" value="'. __('Remove', 'pac') .'" />';
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

        // Add a filter so the mobile version can edit this hidden field group
        $fields = apply_filters('pa_calc_hidden_fields', $fields, null);

        $fields .= '</li>';

        return $fields;
    }

    /**
     * Grab repeating fields for additional fields
     *
     * @return PA_Calculator_Calc
     */
    public function extra_fields($data) {

        $fields = '';

        // grab our data array and filter through
        if (!empty($data)) : foreach ($data as $item) :

                $label = !empty($item['extra-label']) ? $item['extra-label'] : '';
                $type = !empty($item['extra-type']) ? $item['extra-type'] : '';
                $value = !empty($item['extra-value']) ? $item['extra-value'] : '';
                $color = !empty($item['extra-color']) ? $item['extra-color'] : '';

                $fields .= '<li class="extra-field-row">';
                $fields .= '<span class="icon">';
                $fields .= '<i class="dashicons dashicons-no-alt extra-row-remove" title="Remove ' . $label . '"></i>';
//				$fields .= '<input type="button" title="Remove '.$label.'" class="extra-row-remove" value="'. __('Remove', 'pac') .'" />';
                $fields .= '</span>';

                $fields .= '<span class="type">';
                $fields .= '<select class="extra-type" name="extra-type[]">';
                $fields .= '<option value="" >(Select)</option>';
                $fields .= '<option value="dropdown" ' . selected($type, 'dropdown', false) . ' >Dropdown</option>';
                $fields .= '<option value="textfield" ' . selected($type, 'textfield', false) . ' >Text Field</option>';
                $fields .= '<option value="radio" ' . selected($type, 'radio', false) . ' >Radio</option>';
                $fields .= '<option value="checkbox" ' . selected($type, 'checkbox', false) . ' >Checkboxes</option>';
                $fields .= '</select>';
                $fields .= '</span>';

                $fields .= '<span class="title">';
                $fields .= '<input type="text" class="regular-text extra-label" name="extra-label[]" value="' . $label . '" />';
                $fields .= '</span>';

                $fields .= '<span class="value">';
                $fields .= '<input type="text" class="regular-text extra-value" name="extra-value[]" value="' . $value . '" />';
                $fields .= '</span>';

                $fields .= '<span class="color">';
                $fields .= '<input type="checkbox" class="extra-color" name="extra-color[]" value="on" ' . checked($color, 'on', false) . '>';
                $fields .= '</span>';

                $fields .= '</li>';

            endforeach;
        endif;

        // display an empty fieldset if we don't have any data saved yet
        if (empty($data)) :
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
        $fields .= '<i class="dashicons dashicons-no-alt extra-row-remove" title="Remove"></i>';
//				$fields .= '<input type="button" class="extra-row-remove" value="'. __('Remove', 'pac') .'" />';
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
     * store array of form data
     *
     * @return PA_Calculator_Calc
     */
    public function form_store($post_id) {

        // Check if our nonce is set.
        if (!isset($_POST['pacalc_metabox_nonce']))
            return $post_id;

        $nonce = $_POST['pacalc_metabox_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'pacalc_metabox'))
            return $post_id;

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (self::POST_TYPE != $_POST['post_type']) {
            return $post_id;
        }

        // Check caps
        if (!current_user_can('manage_options'))
            return $post_id;

        // we made it through, clean up the array
        $current = get_post_meta($post_id, '_pacalc_data', true);
        $updates = array();

        /* set up statics first */
        $form_title = $_POST['form-title'];
        $form_desc = $_POST['form-desc'];
        $questions_head = $_POST['questions-head'];
        $fields_title = $_POST['fields-title'];
        $fields_thumb = isset($_POST['fields-thumb']) ? $_POST['fields-thumb'] : '';
        $submit_text = $_POST['submit-text'];
        $procedure_id = $_POST['procedure'];
        $disclaimer = $_POST['disclaimer'];
        $nodoctext_a = $_POST['nodoc-text-a'];
        $nodoctext_b = $_POST['nodoc-text-b'];
        $ckm_key = $_POST['ckm_key'];
        $ckm_campaign_id = $_POST['ckm_campaign_id'];

        $nation_deal_text = $_POST['nation_deal_text'];
        $nation_deal_url = $_POST['nation_deal_url'];
        $nation_deal_image_url = $_POST['nation_deal_image_url'];


        $updates['form-title'] = $form_title;
        $updates['form-desc'] = $form_desc;
        $updates['questions-head'] = $questions_head;
        $updates['fields-title'] = $fields_title;
        $updates['fields-thumb'] = $fields_thumb;
        $updates['submit-text'] = $submit_text;
        $updates['procedure-id'] = $procedure_id;
        $updates['disclaimer'] = $disclaimer;
        $updates['nodoc-text-a'] = $nodoctext_a;
        $updates['nodoc-text-b'] = $nodoctext_b;
        $updates['ckm-key'] = $ckm_key;
        $updates['ckm-campaign-id'] = $ckm_campaign_id;

        $updates['nation-deal-url'] = $nation_deal_url;
        $updates['nation-deal-text'] = $nation_deal_text;
        $updates['nation-deal-image-url'] = $nation_deal_image_url;

        /* hit my repeating cake fields */
        $cake_field_names = $_POST['cake-field-name'];
        $cake_field_values = $_POST['cake-field-value'];

        $count = count($cake_field_names);

        for ($i = 0; $i < $count; $i++) {

            if ($cake_field_names[$i] != '') :
                $updates['cake-fields'][$i]['cake-field-name'] = stripslashes(strip_tags($cake_field_names[$i]));

                if ($cake_field_values[$i] != '')
                    $updates['cake-fields'][$i]['cake-field-value'] = stripslashes($cake_field_values[$i]);
                // Allow the field values to be filtered (add/edit/remove)
                $updates = apply_filters('pa_calc_save_cake_repeating_field_values', $updates, $i);

            endif;
        }

        /* hit my repeating calc fields */
        $calc_titles = $_POST['calc-title'];
        $calc_costs = $_POST['calc-cost'];
        $calc_thumb = $_POST['calc-thumb'];
        $calc_desc = $_POST['calc-desc'];
        $calc_sugst = $_POST['calc-sugst'];

        $count = count($calc_titles);

        for ($i = 0; $i < $count; $i++) {

            if ($calc_titles[$i] != '') :
                $updates['calc-fields'][$i]['calc-title'] = stripslashes(strip_tags($calc_titles[$i]));

                if ($calc_costs[$i] != '')
                    $updates['calc-fields'][$i]['calc-cost'] = stripslashes($calc_costs[$i]);

                if ($calc_thumb[$i] != '')
                    $updates['calc-fields'][$i]['calc-thumb'] = stripslashes($calc_thumb[$i]);

                if ($calc_desc[$i] != '')
                    $updates['calc-fields'][$i]['calc-desc'] = stripslashes($calc_desc[$i]);

                if ($calc_sugst[$i] != '')
                    $updates['calc-fields'][$i]['calc-sugst'] = stripslashes($calc_sugst[$i]);

                // Allow the field values to be filtered (add/edit/remove)
                $updates = apply_filters('pa_calc_save_repeating_field_values', $updates, $i);

            endif;
        }

        /* hit my repeating extra fields */
        $extra_label = $_POST['extra-label'];
        $extra_type = $_POST['extra-type'];
        $extra_value = $_POST['extra-value'];
        $extra_color = isset($_POST['extra-color']) ? $_POST['extra-color'] : '';

        $count = count($extra_label);

        for ($i = 0; $i < $count; $i++) {

            if ($extra_label[$i] != '') :
                $updates['extras'][$i]['extra-key'] = pa_sanitize_extra_field_key(stripslashes(strip_tags($extra_label[$i])));
                $updates['extras'][$i]['extra-label'] = stripslashes(strip_tags($extra_label[$i]));

                if ($extra_type[$i] != '')
                    $updates['extras'][$i]['extra-type'] = stripslashes($extra_type[$i]);

                if ($extra_value[$i] != '')
                    $updates['extras'][$i]['extra-value'] = stripslashes($extra_value[$i]);

                if ('' != $extra_color && !empty($extra_color[$i]))
                    $updates['extras'][$i]['extra-color'] = stripslashes($extra_color[$i]);

            endif;
        }

        // Allow the field values to be filtered (add/edit/remove)
        $updates = apply_filters('pa_calc_pre_save_field_values', $updates);

        if (!empty($updates) && $updates != $current) {
            update_post_meta($post_id, '_pacalc_data', $updates);
        } elseif (empty($updates) && $current) {
            // this is currently never run, need to re-evaluate empty($updates)
            delete_post_meta($post_id, '_pacalc_data');
        }

        // end repeatable stuff
    }

    /**
     * Map form-title field to actual post title for pa-calcs
     *
     * @param  [type] $data    [description]
     * @param  [type] $postarr [description]
     * @return [type]          [description]
     */
    function map_form_title_to_post_title($data, $postarr) {

        // Check if we've set a title and use it for the post title
        if (isset($postarr['form-title']) && !empty($postarr['form-title'])) {
            $data['post_title'] = sanitize_text_field($postarr['form-title']);
        }

        return $data;
    }

    /**
     * Customize the post columns for the pa-calc post type.
     *
     * @param array $columns  The default columns.
     * @return array $columns Amended columns.
     */
    public function calc_columns($columns) {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'pac'),
            'shortcode' => __('Shortcode', 'pac'),
            'modified' => __('Last Modified', 'pac'),
            'date' => __('Date', 'pac')
        );

        return $columns;
    }

    /**
     * Add data to the custom columns added to the pa-calc post type.
     *
     *
     * @global object $post  The current post object
     * @param string $column The name of the custom column
     * @param int $post_id   The current post ID
     */
    public function calc_custom_columns($column, $post_id) {

        global $post;

        switch ($column) {
            case 'shortcode' :
                echo '<code>[pacalc id="' . $post_id . '"]</code>';
                break;

            case 'modified' :
                the_modified_date('Y/m/d');
                break;
        }
    }

    /**
     * Filter out unnecessary row actions from the pa-calc post table.
     *
     *
     * @param array $actions  Default row actions.
     * @return array $actions Amended row actions.
     */
    public function row_actions($actions) {

        if (isset(get_current_screen()->post_type) && self::POST_TYPE == get_current_screen()->post_type) {
            unset($actions['inline hide-if-no-js']);
        }

        return $actions;
    }

    /**
     * Get all Calculator IDs
     *
     * Return all post IDs of cost calculators
     * @return array
     */
    public static function get_all_ids() {

        if (false === $all_ids = get_transient('pg_all_calcs')) {
            $args = array(
                'post_type' => self::POST_TYPE,
                'nopaging' => true,
                'fields' => 'ids',
                'post_status' => 'publish',
            );

            $all_ids = get_posts($args);
            set_transient('pg_all_calcs', $all_ids, WEEK_IN_SECONDS);
        }

        return $all_ids;
    }

    /**
     * Flush post type related caches
     *
     * @param  int $post_id
     * @param  object $post
     * @return void
     */
    public function flush_cache($post_id, $post) {

        // Bail if we're autosaving
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Bail if there's no post data
        if (empty($post)) {
            return;
        }

        // Bail if we're not saving a calculator
        if (self::POST_TYPE !== $post->post_type) {
            return;
        }

        // Flush calculator-related caches
        delete_transient('pg_all_calcs');
        delete_transient('pg_all_extra_fields');
    }

}

// Instantiate our class
$PA_Calculator_Calc = PA_Calculator_Calc::getInstance();
