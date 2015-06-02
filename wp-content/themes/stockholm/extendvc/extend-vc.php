<?php
/*** Removing shortcodes ***/
vc_remove_element("vc_widget_sidebar");
vc_remove_element("vc_wp_search");
vc_remove_element("vc_wp_meta");
vc_remove_element("vc_wp_recentcomments");
vc_remove_element("vc_wp_calendar");
vc_remove_element("vc_wp_pages");
vc_remove_element("vc_wp_tagcloud");
vc_remove_element("vc_wp_custommenu");
vc_remove_element("vc_wp_text");
vc_remove_element("vc_wp_posts");
vc_remove_element("vc_wp_links");
vc_remove_element("vc_wp_categories");
vc_remove_element("vc_wp_archives");
vc_remove_element("vc_wp_rss");
vc_remove_element("vc_teaser_grid");
vc_remove_element("vc_button");
vc_remove_element("vc_button2");
vc_remove_element("vc_cta_button");
vc_remove_element("vc_cta_button2");
vc_remove_element("vc_message");
vc_remove_element("vc_tour");
vc_remove_element("vc_progress_bar");
vc_remove_element("vc_pie");
vc_remove_element("vc_posts_slider");
vc_remove_element("vc_toggle");
vc_remove_element("vc_images_carousel");
vc_remove_element("vc_posts_grid");
vc_remove_element("vc_carousel");
vc_remove_element("vc_custom_heading");

/*** Remove unused parameters ***/
if (function_exists('vc_remove_param')) {
	vc_remove_param('vc_single_image', 'css_animation');
	vc_remove_param('vc_single_image', 'title');
	vc_remove_param('vc_gallery', 'title');
	vc_remove_param('vc_column_text', 'css_animation');
	vc_remove_param('vc_row', 'bg_image');
	vc_remove_param('vc_row', 'bg_color');
	vc_remove_param('vc_row', 'font_color');
	vc_remove_param('vc_row', 'margin_bottom');
	vc_remove_param('vc_row', 'bg_image_repeat');
	vc_remove_param('vc_tabs', 'interval');
	vc_remove_param('vc_tabs', 'title');
	vc_remove_param('vc_separator', 'style');
	vc_remove_param('vc_separator', 'color');
	vc_remove_param('vc_separator', 'accent_color');
	vc_remove_param('vc_separator', 'el_width');
	vc_remove_param('vc_text_separator', 'style');
	vc_remove_param('vc_text_separator', 'color');
	vc_remove_param('vc_text_separator', 'accent_color');
	vc_remove_param('vc_text_separator', 'el_width');
	vc_remove_param('vc_text_separator', 'title_align');
	vc_remove_param('vc_accordion', 'title');
}

/*** Remove frontend editor ***/
if(function_exists('vc_disable_frontend')){
	vc_disable_frontend();
}

$font_awesome_icons = qode_font_awesome_icon_array();
$fa_icons = array();
$fa_icons[""] = "";
foreach ($font_awesome_icons as $key => $value) {
	$fa_icons[$key] = $key;
}

$fe_icons = qode_font_elegant_icon_array();

$carousel_sliders = getCarouselSliderArray();

$animations = array(
	"" => "",
	"Elements Shows From Left Side" => "element_from_left",
	"Elements Shows From Right Side" => "element_from_right",
	"Elements Shows From Top Side" => "element_from_top",
	"Elements Shows From Bottom Side" => "element_from_bottom",
	"Elements Shows From Fade" => "element_from_fade"
);

$font_weight_array = array(
	"Default" => "",
	"Thin 100" => "100",
	"Extra-Light 200" => "200",
	"Light 300" => "300",
	"Regular 400" => "400",
	"Medium 500" => "500",
	"Semi-Bold 600" => "600",
	"Bold 700" => "700",
	"Extra-Bold 800" => "800",
	"Ultra-Bold 900" => "900"
);

$social_icons_array = array(
	"" => "",
	"ADN"            => "fa-adn",
	"Android"        => "fa-android",
	"Apple"          => "fa-apple",
	"Bitbucket"      => "fa-bitbucket",	
	"Bitbucket-Sign" => "fa-bitbucket-sign",	
	"Bitcoin"        => "fa-bitcoin",	
	"BTC"            => "fa-btc",	
	"CSS3"           => "fa-css3",	
	"Dribbble"       => "fa-dribbble",	
	"Dropbox"        => "fa-dropbox",
	"E-mail"         => "fa-envelope",
	"Facebook"       => "fa-facebook",
	"Facebook Official" => "fa-facebook-official",
	"Facebook-Sign"  => "fa-facebook-sign",	
	"Flickr"         => "fa-flickr",
	"Forumbee"       => "fa-forumbee",
	"Foursquare"     => "fa-foursquare",	
	"GitHub"         => "fa-github",	
	"GitHub-Alt"     => "fa-github-alt",	
	"GitHub-Sign"    => "fa-github-sign",	
	"Gittip"         => "fa-gittip",	
	"Google Plus"    => "fa-google-plus",	
	"Google Plus-Sign" => "fa-google-plus-sign",	
	"HTML5"          => "fa-html5",	
	"Instagram"      => "fa-instagram",	
	"LinkedIn"       => "fa-linkedin",	
	"LinkedIn-Sign"  => "fa-linkedin-sign",	
	"Linux"          => "fa-linux",	
	"MaxCDN"         => "fa-maxcdn",
	"Paypal"         => "fa-paypal",
	"Pinterest"      => "fa-pinterest",
	"Pinterest-P"    => "fa-pinterest-p",
	"Pinterest-Sign" => "fa-pinterest-sign",	
	"Renren"         => "fa-renren",	
	"Skype"          => "fa-skype",	
	"StackExchange"  => "fa-stackexchange",	
	"Trello"         => "fa-trello",	
	"Tumblr"         => "fa-tumblr",	
	"Tumblr-Sign"    => "fa-tumblr-sign",	
	"Twitter"        => "fa-twitter",	
	"Twitter-Sign"   => "fa-twitter-sign",	
	"VK"             => "fa-vk",
	"WhatsApp"       => "fa-whatsapp",	
	"Weibo"          => "fa-weibo",	
	"Windows"        => "fa-windows",	
	"Xing"           => "fa-xing",	
	"Xing-Sign"      => "fa-xing-sign",	
	"Yelp"           => "fa-yelp", 
	"YouTube"        => "fa-youtube",	
	"YouTube Play"   => "fa-youtube-play",	
	"YouTube-Sign"   => "fa-youtube-sign"
);

/*** Accordion ***/
vc_add_param("vc_accordion", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Style",
	"param_name" => "style",
	"value" => array(
		"Accordion"             => "accordion",
		"Toggle"                => "toggle",
        "Boxed Accordion"       => "boxed_accordion",
        "Boxed Toggle"          => "boxed_toggle"
	),
	"description" => ""
));

vc_add_param("vc_accordion", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Accordion Mark Border Radius",
	"param_name" => "accordion_border_radius",
	"value" => "",
	"description" => "",
	"dependency" => Array('element' => "style", 'value' => array('accordion', 'toggle'))
));

vc_add_param("vc_accordion_tab", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Title Color",
	"param_name" => "title_color",
	"value" => "",
	"description" => ""
));

vc_add_param("vc_accordion_tab", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Background Color",
	"param_name" => "background_color",
	"value" => "",
	"description" => ""
));

vc_add_param("vc_accordion_tab", array(
	"type" => "dropdown",
    "class" => "",
    "heading" => "Title Tag",
    "param_name" => "title_tag",
    "value" => array(
        ""   => "",
        "h2" => "h2",
        "h3" => "h3",
        "h4" => "h4",	
        "h5" => "h5",
        "h6" => "h6",
    ),
    "description" => ""
));

/*** Tabs ***/

vc_add_param("vc_tabs", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Style",
	"param_name" => "style",
	"value" => array(
		"Horizontal Center" => "horizontal",
		"Horizontal Left" => "horizontal_left",
		"Horizontal Right" => "horizontal_right",
		"Boxed" => "boxed",
		"Vertical Left" => "vertical_left",
		"Vertical Right" => "vertical_right"
	),
	"description" => ""
));

/*** Gallery ***/

vc_add_param("vc_gallery", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Column Number",
	"param_name" => "column_number",
	 "value" => array(2, 3, 4, 5, "Disable" => 0),
	 "dependency" => Array('element' => "type", 'value' => array('image_grid'))
));

vc_add_param("vc_gallery", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => "Grayscale Images",
    "param_name" => "grayscale",
    "value" => array('No' => 'no', 'Yes' => 'yes'),
    "dependency" => Array('element' => "type", 'value' => array('image_grid'))
));

vc_add_param("vc_gallery", array(
    "type" => "dropdown",
    "class" => "",
    "heading" => "Frame",
    "param_name" => "frame",
	"value" => array("Use frame?" => "use_frame"),
	"value" => array(
		'' => '',
		'Yes' => 'use_frame',
		'No' => 'no'
	),
    "description" => "",
    "dependency" => Array('element' => "type", 'value' => array('flexslider_slide'))
));

vc_add_param("vc_gallery", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Choose Frame",
	"param_name" => "choose_frame",
	"value" => array('Default' => 'default', 'Frame 1' => 'frame1', 'Frame 2' => 'frame2', 'Frame 3' => 'frame3'),
	"dependency" => Array('element' => "frame", 'value' => array('use_frame'))
));
/*** Row ***/

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"show_settings_on_create"=>true,
	"heading" => "Row Type",
	"param_name" => "row_type",
	"value" => array(
		"Row" => "row",
		"Parallax" => "parallax",
		"Expandable" => "expandable",
		"Content menu" => "content_menu"
	)
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"show_settings_on_create"=>true,
	"heading" => "Use Row as Full Screen Section",
	"param_name" => "use_row_as_full_screen_section",
	"value" => array(
		"No" => "no",
		"Yes" => "yes"
	),
	"description" => "This option works only for Full Screen Sections Template",
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Type",
	"param_name" => "type",
	"value" => array(
		"Full Width" => "full_width",
		"In Grid" => "grid"		
	),
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Anchor ID (Example home)",
	"param_name" => "anchor",
	"value" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row','parallax','expandable'))
));
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Row in content menu",
	"value" => array("Use row for content menu?" => "in_content_menu"),
	"param_name" => "in_content_menu",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row','parallax','expandable', 'expandable_with_background'))
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Content menu title",
	"value" => "",
	"param_name" => "content_menu_title",
	"description" => "",
	"dependency" => Array('element' => "in_content_menu", 'value' => array('in_content_menu'))
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Content menu icon pack",
	"param_name" => "icon_pack",
	"value" => array(
		"Font Awesome" => "font_awesome",
		"Font Elegant" => "font_elegant"
	),
	"description" => "",
	"dependency" => Array('element' => "in_content_menu", 'value' => array('in_content_menu'))
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Content menu icon",
	"param_name" => "content_menu_fa_icon",
	"value" => $fa_icons,
	"description" => "",
	"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
));
vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Content menu icon",
	"param_name" => "content_menu_fe_icon",
	"value" => $fe_icons,
	"description" => "",
	"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
));
vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Text Align",
	"param_name" => "text_align",
	"value" => array(
		"Left" => "left",
		"Center" => "center",
		"Right" => "right"
	),
	"dependency" => Array('element' => "row_type", 'value' => array('row','parallax','expandable'))
));
vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Video background",
	"value" => array(
		"No" => "",
		"Yes" => "show_video"
	),
	"param_name" => "video",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));
vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Video overlay",
	"value" => array(
		"No" => "",
		"Yes" => "show_video_overlay"
	),
	"param_name" => "video_overlay",
	"description" => "",
	"dependency" => Array('element' => "video", 'value' => array('show_video'))
));
vc_add_param("vc_row", array(
	"type" => "attach_image",
	"class" => "",
	"heading" => "Video overlay image (pattern)",
	"value" => "",
	"param_name" => "video_overlay_image",
	"description" => "",
	"dependency" => Array('element' => "video_overlay", 'value' => array('show_video_overlay'))
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Video background (webm) file url",
	"value" => "",
	"param_name" => "video_webm",
	"description" => "",
	"dependency" => Array('element' => "video", 'value' => array('show_video'))
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Video background (mp4) file url",
	"value" => "",
	"param_name" => "video_mp4",
	"description" => "",
	"dependency" => Array('element' => "video", 'value' => array('show_video'))
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Video background (ogv) file url",
	"value" => "",
	"param_name" => "video_ogv",
	"description" => "",
	"dependency" => Array('element' => "video", 'value' => array('show_video'))
));
vc_add_param("vc_row", array(
	"type" => "attach_image",
	"class" => "",
	"heading" => "Video preview image",
	"value" => "",
	"param_name" => "video_image",
	"description" => "",
	"dependency" => Array('element' => "video", 'value' => array('show_video'))
));
vc_add_param("vc_row", array(
	"type" => "attach_image",
	"class" => "",
	"heading" => "Background image",
	"value" => "",
	"param_name" => "background_image",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('parallax', 'row'))
));

vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Pattern background",
	"value" => array("Use background image as pattern?" => "pattern_background"),
	"param_name" => "pattern_background",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Section height",
	"param_name" => "section_height",
	"value" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('parallax'))
));
vc_add_param("vc_row", array(
    "type" => "textfield",
    "class" => "",
    "heading" => "Parallax speed",
    "param_name" => "parallax_speed",
    "value" => "",
    "dependency" => Array('element' => "row_type", 'value' => array('parallax'))
));
vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Background color",
	"param_name" => "background_color",
	"value" => "",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row','expandable','content_menu'))
));
vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Border bottom color",
	"param_name" => "border_color",
	"value" => "",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Padding",
	"value" => "",
	"param_name" => "side_padding",
	"description" => "Padding (left/right in pixels)",
	"dependency" => Array('element' => "type", 'value' => array('full_width'))
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Padding Top (px)",
	"value" => "",
	"param_name" => "padding_top",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Padding Bottom (px)",
	"value" => "",
	"param_name" => "padding_bottom",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));
vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Label Color",
	"param_name" => "color",
	"value" => "",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('expandable'))
));
vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Label Hover Color",
	"param_name" => "hover_color",
	"value" => "",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('expandable'))
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "More Label",
	"param_name" => "more_button_label",
	"value" =>  "",
	"description" => "Default label is More Facts",
	"dependency" => Array('element' => "row_type", 'value' => array('expandable'))
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Less Label",
	"param_name" => "less_button_label",
	"value" =>  "",
	"description" => "Default label is Less Facts",
	"dependency" => Array('element' => "row_type", 'value' => array('expandable'))
));
vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Label Position",
	"param_name" => "button_position",
	"value" => array(
		"" => "",
		"Left" => "left",
		"Right" => "right",
		"Center" => "center"
	),
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('expandable'))
));
vc_add_param("vc_row",  array(
  "type" => "dropdown",
  "heading" => "CSS Animation",
  "param_name" => "css_animation",
  "admin_label" => true,
  "value" => $animations,
  "description" => "",
  "dependency" => Array('element' => "row_type", 'value' => array('row'))
  
));
vc_add_param("vc_row",  array(
  "type" => "textfield",
  "heading" => "Transition delay (ms)",
  "param_name" => "transition_delay",
  "admin_label" => true,
  "value" => "",
  "description" => "",
  "dependency" => Array('element' => "row_type", 'value' => array('row'))
  
));

/*** Row Inner ***/

vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "",
	"show_settings_on_create"=>true,
	"heading" => "Row Type",
	"param_name" => "row_type",
	"value" => array(
		"Row" => "row",
		"Parallax" => "parallax",
		"Expandable" => "expandable"
	)
));

vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Type",
	"param_name" => "type",
	"value" => array(
		"Full Width" => "full_width",
		"In Grid" => "grid"
	),
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));

vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Use Row as Full Screen Section Slide",
	"param_name" => "use_row_as_full_screen_section_slide",
	"value" => array(
		"No" => "no",
		"Yes" => "yes"
	),
	"description" => "This option works only for Full Screen Sections Template",
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));

vc_add_param("vc_row_inner", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Use as box",
	"value" => array("Use row as box" => "use_row_as_box" ),
	"param_name" => "use_as_box",
	"description" => '',
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));

vc_add_param("vc_row_inner", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Anchor ID",
	"param_name" => "anchor",
	"value" => ""
));
vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Text Align",
	"param_name" => "text_align",
	"value" => array(
		"Left" => "left",
		"Center" => "center",
		"Right" => "right"
	)
));
vc_add_param("vc_row_inner", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Background color",
	"param_name" => "background_color",
	"value" => "",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row','expandable'))
));
vc_add_param("vc_row_inner", array(
	"type" => "attach_image",
	"class" => "",
	"heading" => "Background image",
	"value" => "",
	"param_name" => "background_image",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('parallax'))
));
vc_add_param("vc_row_inner", array(
	"type" => "attach_image",
	"class" => "",
	"heading" => "Slide Background image",
	"value" => "",
	"param_name" => "slide_background_image",
	"description" => "",
	"dependency" => Array('element' => "use_row_as_full_screen_section_slide", 'value' => array('yes'))
));
vc_add_param("vc_row_inner", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Section height",
	"param_name" => "section_height",
	"value" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('parallax'))
));
vc_add_param("vc_row_inner", array(
    "type" => "textfield",
    "class" => "",
    "heading" => "Parallax speed",
    "param_name" => "parallax_speed",
    "value" => "",
    "dependency" => Array('element' => "row_type", 'value' => array('parallax'))
));
vc_add_param("vc_row_inner", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Border color",
	"param_name" => "border_color",
	"value" => "",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row','expandable'))
));

vc_add_param("vc_row_inner", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Padding",
	"value" => "",
	"param_name" => "side_padding",
	"description" => "Left and right spacing in pixels",
	"dependency" => Array('element' => "type", 'value' => array('full_width'))
));

vc_add_param("vc_row_inner", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Padding Top",
	"value" => "",
	"param_name" => "padding_top",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));
vc_add_param("vc_row_inner", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Padding Bottom",
	"value" => "",
	"param_name" => "padding_bottom",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));
vc_add_param("vc_row_inner", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "More Button Label",
	"param_name" => "more_button_label",
	"value" =>  "",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('expandable'))
));
vc_add_param("vc_row_inner", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Less Button Label",
	"param_name" => "less_button_label",
	"value" =>  "",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('expandable'))
));
vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Button Position",
	"param_name" => "button_position",
	"value" => array(
		"" => "",
		"Left" => "left",
		"Right" => "right",
		"Center" => "center"	
	),
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('expandable'))
));
vc_add_param("vc_row_inner", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Color",
	"param_name" => "color",
	"value" => "",
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('expandable'))
));
vc_add_param("vc_row_inner",  array(
	"type" => "dropdown",
	"heading" => "CSS Animation",
	"param_name" => "css_animation",
	"admin_label" => true,
	"value" => $animations,
	"description" => "",
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
  
));
vc_add_param("vc_row_inner",  array(
  "type" => "textfield",
  "heading" => "Transition delay (ms)",
  "param_name" => "transition_delay",
  "admin_label" => true,
  "value" => "",
  "description" => "",
  "dependency" => Array('element' => "row_type", 'value' => array('row'))
  
));

/*** Separator ***/


$separator_setting = array (
  'show_settings_on_create' => true,
  "controls"	=> '',
);
vc_map_update('vc_separator', $separator_setting);


vc_add_param("vc_separator", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Type",
	"param_name" => "type",
	"value" => array(
		"Normal"		=>	"normal",
		"Transparent"	=>	"transparent",
		"Full width"	=>	"full_width",
		"Small"			=>	"small"
	),
	"description" => ""
));

vc_add_param("vc_separator", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Position",
	"param_name" => "position",
	"value" => array(
		"Center" => "center",
		"Left" => "left",
		"Right" => "right"
	),
    "dependency" => array("element" => "type", "value" => array("small")),
	"description" => ""
));

vc_add_param("vc_separator", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Color",
	"param_name" => "color",
	"value" => "",
	"description" => ""
));

vc_add_param("vc_separator", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Border Style",
	"param_name" => "border_style",
	"value" => array(
		"" => "",
		"Dashed" => "dashed",
		"Solid" => "solid"
	),
	"description" => ""
));

vc_add_param("vc_separator", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Thickness",
	"param_name" => "thickness",
	"value" => "",
	"description" => ""
));

vc_add_param("vc_separator", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Width",
	"param_name" => "width",
	"value" => "",
	"dependency" => array("element" => "type", "value" => array("small")),
	"description" => ""
));

vc_add_param("vc_separator", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Top Margin",
	"param_name" => "up",
	"value" => "",
	"description" => ""
));
vc_add_param("vc_separator", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Bottom Margin",
	"param_name" => "down",
	"value" => "",
	"description" => ""
));

/*** Separator With Text ***/

vc_add_param("vc_text_separator", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Border Color",
	"param_name" => "border_color"
));

vc_add_param("vc_text_separator", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Background Color",
	"param_name" => "background_color",	
));

vc_add_param("vc_text_separator", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Title Color",
	"param_name" => "title_color",
));

/*** Single Image ***/

vc_add_param("vc_single_image",  array(
  "type" => "dropdown",
  "heading" => "CSS Animation",
  "param_name" => "qode_css_animation",
  "admin_label" => true,
  "value" => $animations,
  "description" => ""
  
));
vc_add_param("vc_single_image",  array(
  "type" => "textfield",
  "heading" => "Transition delay (s)",
  "param_name" => "transition_delay",
  "admin_label" => true,
  "value" => "",
  "description" => ""
  
));

/*** Blockquote  ***/

vc_map( array(
		"name" => "Blockquote",
		"base" => "blockquote",
		"category" => 'by SELECT',
		"icon" => "icon-wpb-blockquote",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => "Text",
				"param_name" => "text",
				"value" => "Blockquote text"
			),
            array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Color",
				"param_name" => "text_color",
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Tag",
				"param_name" => "title_tag",
				"value" => array(
					""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",
					"h5" => "h5",
					"h6" => "h6",
				),
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Width",
				"param_name" => "width",
				"description" => "Width (%)"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Line Height",
				"param_name" => "line_height",
				"description" => "Line Height (px)"
			),
            array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Background Color",
				"param_name" => "background_color",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Border Color",
				"param_name" => "border_color",
				"description" => ""
			),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Show Quote Icon",
                "param_name" => "show_quote_icon",
                "value" => array(
                    "Yes" => "yes",
                    "No" => "no"
                ),
                "description" => ""
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Quote Icon Color",
                "param_name" => "quote_icon_color",
                "description" => "",
                "dependency" => array('element' => "show_quote_icon", 'value' => 'yes'),
            ),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Quote Icon Size (px)",
				"param_name" => "quote_icon_size",
			)
		)
) );

/*** Button shortcode ***/

vc_map( array(
		"name" => "Button",
		"base" => "qbutton",
		"category" => 'by SELECT',
		"icon" => "icon-wpb-button",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Size",
				"param_name" => "size",
				"value" => array(
					"Default" => "",
                    "Small" => "small",
					"Medium" => "medium",	
					"Large" => "large",
					"Extra Large" => "big_large",
					"Extra Large Full Width" => "big_large_full_width"
				)
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Style",
				"param_name" => "style",
				"value" => array(
					"Default" => "",
					"White" => "white"
				)
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Text",
				"param_name" => "text"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon Pack",
				"param_name" => "icon_pack",
				"value" => array(
					"No Icon" => "",
					"Font Awesome" => "font_awesome",
					"Font Elegant" => "font_elegant"
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "fa_icon",
				"value" => $fa_icons,
				"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "fe_icon",
				"value" => $fe_icons,
				"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Icon Color",
				"param_name" => "icon_color",
				"dependency" => Array('element' => "icon", 'not_empty' => true)
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Link",
				"param_name" => "link"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Link Target",
				"param_name" => "target",
				"value" => array(
					"Self" => "_self",
					"Blank" => "_blank"
				)
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Color",
				"param_name" => "color"
			),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Hover Color",
                "param_name" => "hover_color"
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Background Color",
                "param_name" => "background_color"
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Hover Background Color",
                "param_name" => "hover_background_color"
            ),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Border Color",
				"param_name" => "border_color"
			),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Hover Border Color",
                "param_name" => "hover_border_color"
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Font Style",
				"param_name" => "font_style",
				"value" => array(
					"" => "",
					"Normal" => "normal",	
					"Italic" => "italic"
				)
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Font Weight",
				"param_name" => "font_weight",
				"value" => $font_weight_array
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Margin",
				"param_name" => "margin",
				"description" => __("Please insert margin in format: 0px 0px 1px 0px", 'qode')
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Border radius",
				"param_name" => "border_radius",
				"description" => __("Please insert border radius(Rounded corners) in px. For example: 4 ", 'qode')
			)
		)
) );

/*** Call To Action ***/

vc_map( array(
		"name" => "Call to Action",
		"base" => "call_to_action",
		"category" => 'by SELECT',
		"icon" => "icon-wpb-action",
		"allowed_container_element" => 'vc_row',
		"params" => array(
            array(
                "type"          => "dropdown",
                "holder"        => "div",
                "class"         => "",
                "heading"       => "Full Width",
                "param_name"    => "full_width",
                "value"         => array(
                    "Yes"       => "yes",
                    "No"        => "no"
                ),
                "description"   => ""
            ),
            array(
                "type"          => "dropdown",
                "holder"        => "div",
                "class"         => "",
                "heading"       => "Content in grid",
                "param_name"    => "content_in_grid",
                "value"         => array(
                    "Yes"       => "yes",
                    "No"        => "no"
                ),
                "description"   => "",
                "dependency"    => array("element" => "full_width", "value" => "yes")
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Type",
				"param_name" => "type",
				"value" => array(
					"Normal" => "normal",
					"With Icon" => "with_icon"	
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon Pack",
				"param_name" => "icon_pack",
				"value" => array(
					"No Icon" => "",
					"Font Awesome" => "font_awesome",
					"Font Elegant" => "font_elegant"
				),
				"description" => "",
				"dependency" => Array('element' => "type", 'value' => array('with_icon'))
			),array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "fa_icon",
				"value" => $fa_icons,
				"description" => "",
				"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
			),array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "fe_icon",
				"value" => $fe_icons,
				"description" => "",
				"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Icon Size (px)",
				"param_name" => "icon_size",
				"description" => "",
				"dependency" => Array('element' => "type", 'value' => array('with_icon'))
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => "Icon Color",
				"param_name" => "icon_color",
				"description" => "",
				"dependency" => Array('element' => "type", 'value' => array('with_icon'))
				),
			array(
				"type" => "attach_image",
				"holder" => "div",
				"class" => "",
				"heading" => "Custom Icon",
				"param_name" => "custom_icon",
				"dependency" => Array('element' => "type", 'value' => array('with_icon'))
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Background Color",
				"param_name" => "background_color",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Border Color",
				"param_name" => "border_color",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Box Padding (top right bottom left) px",
				"param_name" => "box_padding",
				"description" => "Default padding is 60px 0 60px 0"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Default Text Font Size (px)",
				"param_name" => "text_size",
				"description" => "Font size for p tag"
			),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Show Button",
                "param_name" => "show_button",
                "value" => array(
                    "Yes" => "yes",
                    "No" => "no"
                ),
                "description" => ""
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Button Size",
				"param_name" => "button_size",
				"value" => array(
					"Default" => "",
					"Small" => "small",
					"Medium" => "medium",
					"Large" => "large",
					"Huge" => "big_large"
				),
				"description" => "",
				"dependency" => array('element' => 'show_button', 'value' => array('yes'))
			),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Button Text",
                "param_name" => "button_text",
                "description" => "",
                "dependency" => array('element' => 'show_button', 'value' => array('yes'))
            ),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Button Link",
				"param_name" => "button_link",
				"description" => "",
                "dependency" => array('element' => 'show_button', 'value' => array('yes'))
			),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Button Target",
                "param_name" => "button_target",
                "value" => array(
                    "" => "",
                    "Self" => "_self",
                    "Blank" => "_blank"
                ),
                "description" => "",
                "dependency" => array('element' => 'show_button', 'value' => array('yes'))
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Button text color",
                "param_name" => "button_text_color",
                "description" => "",
                "dependency" => array('element' => 'show_button', 'value' => array('yes'))
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Button hover text color",
                "param_name" => "button_hover_text_color",
                "description" => "",
                "dependency" => array('element' => 'show_button', 'value' => array('yes'))
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Button Background Color",
                "param_name" => "button_background_color",
                "description" => "",
                "dependency" => array('element' => 'show_button', 'value' => array('yes'))
            ),
             array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Button Hover Background Color",
                "param_name" => "button_hover_background_color",
                "dependency" => array('element' => 'show_button', 'value' => array('yes'))
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Button Border Color",
                "param_name" => "button_border_color",
                "description" => "",
                "dependency" => array('element' => 'show_button', 'value' => array('yes'))
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Button Hover Border Color",
                "param_name" => "button_hover_border_color",
                "description" => "",
                "dependency" => array('element' => 'show_button', 'value' => array('yes'))
            ),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => "Content",
				"param_name" => "content",
				"value" => "<p>"."I am test text for Call to action."."</p>",
				"description" => ""
			)
		)
) );

/*** Counter ***/

vc_map( array(
		"name" => "Counter",
		"base" => "counter",
		"category" => 'by SELECT',
		'admin_enqueue_css' => array(get_template_directory_uri().'/css/admin/vc-extend.css'),
		"icon" => "icon-wpb-counter",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Type",
				"param_name" => "type",
				"value" => array(
					"Zero Counter" => "zero",
					"Random Counter" => "random"	
				),
				"description" => ""
			),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Box",
                "param_name" => "box",
                "value" => array(
					"" => "",
                    "Yes" => "yes",
                    "No" => "no"
                ),
                "description" => ""
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Box Border Color",
                "param_name" => "box_border_color",
                "description" => "",
                "dependency" => array('element' => "box", 'value' => array('yes'))
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Position",
				"param_name" => "position",
				"value" => array(
					"Left" => "left",
					"Right" => "right",	
					"Center" => "center"
				),
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Digit",
				"param_name" => "digit",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Font size (px)",
				"param_name" => "font_size",
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Font weight",
				"param_name" => "font_weight",
				"value" => array(
					"Default" 			=> "",
					"Thin 100"			=> "100",
					"Extra-Light 200" 	=> "200",
					"Light 300"			=> "300",
					"Regular 400"		=> "400",
					"Medium 500"		=> "500",
					"Semi-Bold 600"		=> "600",
					"Bold 700"			=> "700",
					"Extra-Bold 800"	=> "800",
					"Ultra-Bold 900"	=> "900"
				),
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Font Color",
				"param_name" => "font_color",
				"description" => ""
			),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Text",
                "param_name" => "text",
                "description" => ""
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Text Size (px)",
                "param_name" => "text_size",
                "description" => ""
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Font Weight",
				"param_name" => "text_font_weight",
				"value" => array(
					"Default" => "",
					"Thin 100" => "100",
					"Extra-Light 200" => "200",
					"Light 300" => "300",
					"Regular 400" => "400",
					"Medium 500" => "500",
					"Semi-Bold 600" => "600",
					"Bold 700" => "700",
					"Extra-Bold 800" => "800",
					"Ultra-Bold 900" => "900"
				)
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Transform",
				"param_name" => "text_transform",
				"value" => array(
					"Default" 			=> "",
					"None"				=> "none",
					"Capitalize" 		=> "capitalize",
					"Uppercase"			=> "uppercase",
					"Lowercase"			=> "lowercase"
				),
				"description" => ""
			),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Text Color",
                "param_name" => "text_color",
                "description" => ""
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Separator",
                "param_name" => "separator",
                "value" => array(
                    "Yes" => "yes",
                    "No" => "no"
                ),
                "description" => ""
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Separator Color",
                "param_name" => "separator_color",
                "description" => "",
                "dependency" => array('element' => "separator", 'value' => array('yes'))
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Separator Border Style",
				"param_name" => "separator_border_style",
				"value" => array(
					"" => "",
					"Dashed" => "dashed",
					"Solid" => "solid"
				),
				"description" => "",
				"dependency" => array('element' => "separator", 'value' => array('yes'))
			)
		)
) );

/*** Cover Boxes ***/

vc_map( array(
		"name" => "Cover Boxes",
		"base" => "cover_boxes",
		'admin_enqueue_css' => array(get_template_directory_uri().'/css/admin/vc-extend.css'),
		"icon" => "icon-wpb-cover_boxes",
		"category" => 'by SELECT',
		"allowed_container_element" => 'vc_row',
		"params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Active element",
                "param_name" => "active_element",
                "value" => ""
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Title tag",
				"param_name" => "title_tag",
				"value" => array(
					""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",
					"h5" => "h5",
					"h6" => "h6",
				),
				"description" => "Choose with heading tag to display for titles"
			),
			array(
				"type" => "attach_image",
				"holder" => "div",
				"class" => "",
				"heading" => "Image 1",
				"param_name" => "image1"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title 1",
				"param_name" => "title1",
				"value" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Color 1",
				"param_name" => "title_color1",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Text 1",
				"param_name" => "text1",
				"value" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Color 1",
				"param_name" => "text_color1",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Link 1",
				"param_name" => "link1",
				"value" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Link label 1",
				"param_name" => "link_label1",
				"value" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Target 1",
				"param_name" => "target1",
				"value" => array(
					"Self" => "_self",
					"Blank" => "_blank"
				),
				"description" => ""
			),
			array(
				"type" => "attach_image",
				"holder" => "div",
				"class" => "",
				"heading" => "Image 2",
				"param_name" => "image2"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title 2",
				"param_name" => "title2",
				"value" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Color 2",
				"param_name" => "title_color2",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Text 2",
				"param_name" => "text2",
				"value" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Color 2",
				"param_name" => "text_color2",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Link 2",
				"param_name" => "link2",
				"value" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Link label 2",
				"param_name" => "link_label2",
				"value" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Target 2",
				"param_name" => "target2",
				"value" => array(
					"Self" => "_self",
					"Blank" => "_blank"
				),
				"description" => ""
			),
			array(
				"type" => "attach_image",
				"holder" => "div",
				"class" => "",
				"heading" => "Image 3",
				"param_name" => "image3"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title 3",
				"param_name" => "title3",
				"value" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Color 3",
				"param_name" => "title_color3",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Text 3",
				"param_name" => "text3",
				"value" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Color 3",
				"param_name" => "text_color3",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Link 3",
				"param_name" => "link3",
				"value" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Link label 3",
				"param_name" => "link_label3",
				"value" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Target 3",
				"param_name" => "target3",
				"value" => array(
					"Self" => "_self",
					"Blank" => "_blank"
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Read More Button Style",
				"param_name" => "read_more_button_style",
				"value" => array(
					"Default" => "",
					"No" => "no",
					"Yes" => "yes"
				),
				"description" => ""
			)
		)
) );

/*** Custom Font ***/

vc_map( array(
		"name" => "Custom Font",
		"base" => "custom_font",
		"icon" => "icon-wpb-custom_font",
		"category" => 'by SELECT',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Font Family",
				"param_name" => "font_family",
				"value" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Font Size(px)",
				"param_name" => "font_size",
				"value" => "15"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Line Height(px)",
				"param_name" => "line_height",
				"value" => "26"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Font Style",
				"param_name" => "font_style",
				"value" => array(
					"Normal" => "normal",
					"Italic" => "italic"	
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Align",
				"param_name" => "text_align",
				"value" => array(
					"Left" => "left",
					"Center" => "center",
					"Right" => "right"	
				),
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Font Weight",
				"param_name" => "font_weight",
				"value" => "300"
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Color",
				"param_name" => "color",
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Decoration",
				"param_name" => "text_decoration",
				"value" => array(
					"None" => "none",
					"Underline" => "underline",
					"Overline" => "overline",
					"Line Through" => "line-through"	
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Shadow",
				"param_name" => "text_shadow",
				"value" => array(
					"No" => "no",
					"Yes" => "yes"
				),
				"description" => ""
			),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Letter Spacing (px)",
                "param_name" => "letter_spacing",
                "value" => ""
            ),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Background Color",
				"param_name" => "background_color",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Padding (px)",
				"param_name" => "padding",
				"value" => "0"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Margin (px)",
				"param_name" => "margin",
				"value" => "0"
			),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => "Content",
				"param_name" => "content",
				"value" => "<p>content content content</p>",
				"description" => ""
			)
		)
) );

/*** Icon ***/

vc_map( array(
	"name" => "Icon",
	"base" => "icons",
	"category" => 'by SELECT',
	"icon" => "icon-wpb-icons",
	"allowed_container_element" => 'vc_row',
	"params" => array(
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Pack",
			"param_name" => "icon_pack",
			"value" => array(
				"Font Awesome" => "font_awesome",
				"Font Elegant" => "font_elegant"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fa_icon",
			"value" => $fa_icons,
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fe_icon",
			"value" => $fe_icons,
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Size",
			"param_name" => 'fa_size',
			"value" => array(
				"Tiny" => "fa-lg",
				"Small" => "fa-2x",
				"Medium" => "fa-3x",
				"Large" => "fa-4x",
				"Very Large" => "fa-5x"
			),
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Custom Size (px)",
			"param_name" => "custom_size",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Type",
			"param_name" => "type",
			"value" => array(
				"Normal" => "normal",
				"Circle" => "circle",
				"Square" => "square"
			),
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Color",
			"param_name" => "icon_color",
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Position",
			"param_name" => "position",
			"value" => array(
				"Normal" => "",
				"Left" => "left",
				"Center" => "center",
				"Right" => "right"
			),
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Border Color",
			"param_name" => "border_color",
			"dependency" => Array('element' => "type", 'value' => array('circle','square'))
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Border Width",
			"param_name" => "border_width",
			"description" => "Enter just number. Omit pixels",
			"dependency" => Array('element' => "type", 'value' => array('circle','square'))
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Background Color",
			"param_name" => "background_color",
			"description" => "",
			"dependency" => Array('element' => "type", 'value' => array('circle','square'))
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Margin",
			"param_name" => "margin",
			"description" => "Margin (top right bottom left)"
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Animation",
			"param_name" => "icon_animation",
			"value" => array(
				"No" => "",
				"Yes" => "q_icon_animation"
			),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Animation Delay (ms)",
			"param_name" => "icon_animation_delay",
			"value" => "",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Link",
			"param_name" => "link",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Target",
			"param_name" => "target",
			"value" => array(
				"Self" => "_self",
				"Blank" => "_blank"
			),
			"description" => ""
		)
	)
) );

/*** Icon List Item ***/

vc_map( array(
	"name" => "Icon List Item",
	"base" => "icon_list_item",
	"icon" => "icon-wpb-icon_list_item",
	"category" => 'by SELECT',
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon pack",
			"param_name" => "icon_pack",
			"value" => array(
				"Font Awesome" => "font_awesome",
				"Font Elegant" => "font_elegant"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fa_icon",
			"value" => $fa_icons,
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fe_icon",
			"value" => $fe_icons,
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon Type",
			"param_name" => "icon_type",
			"value" => array(
				"Normal"  => "normal_icon_list",
				"Small"   => "small_icon_list"
			),
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Color",
			"param_name" => "icon_color",
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Border Type",
			"param_name" => "border_type",
			"value" => array(
				"" => "",
				"Circle"  => "circle",
				"Square"   => "square"
			),
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Border Color",
			"param_name" => "border_color",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Title",
			"param_name" => "title",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Title Color",
			"param_name" => "title_color",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Title size (px)",
			"param_name" => "title_size",
			"description" => ""
		),
	)
) );

/*** Icon With Text ***/

vc_map( array(
	"name" => "Icon With Text",
	"base" => "icon_text",
	"icon" => "icon-wpb-icon_text",
	"category" => 'by SELECT',
	"allowed_container_element" => 'vc_row',
	"params" => array(
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Box Type",
			"param_name" => "box_type",
			"value" => array(
				"Normal" => "normal",
				"Icon in a box" => "icon_in_a_box"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Box Border",
			"param_name" => "box_border",
			"value" => array(
				"Yes" => "yes",
				"No" => "no"
			),
			"description" => "",
			"dependency" => Array('element' => "box_type", 'value' => array('icon_in_a_box'))
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Box Border Color",
			"param_name" => "box_border_color",
			"description" => "",
			"dependency" => Array('element' => "box_type", 'value' => array('icon_in_a_box'))
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Box Background Color",
			"param_name" => "box_background_color",
			"description" => "",
			"dependency" => Array('element' => "box_type", 'value' => array('icon_in_a_box'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon Pack",
			"param_name" => "icon_pack",
			"value" => array(
				"Font Awesome" => "font_awesome",
				"Font Elegant" => "font_elegant"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fa_icon",
			"value" => $fa_icons,
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fe_icon",
			"value" => $fe_icons,
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Type",
			"param_name" => "icon_type",
			"value" => array(
				"Normal" => "normal",
				"Circle" => "circle",
				"Square" => "square"
			),
			"description" => "This attribute doesn't work when Icon Position is Top With Title Over. In This case Icon Type is Normal",
			"dependency" => Array('element' => "icon", 'not_empty' => true)
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Icon Border Width (px)",
			"param_name" => "icon_border_width",
			"description" => "Enter just number, omit pixels",
			"dependency" => array('element' => 'icon_type' , 'value' => array('circle', 'square'))
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "",
			"value" => array("Without Outer Border on Icon?" => "yes"),
			"param_name" => "without_double_border_icon",
			"description" => "",
			"dependency" => array('element' => 'icon_type' , 'value' => array('circle', 'square'))
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Size / Icon Space From Text",
			"param_name" => "icon_size",
			"value" => array(
				"Tiny" => "fa-lg",
				"Small" => "fa-2x",
				"Medium" => "fa-3x",
				"Large" => "fa-4x",
				"Very Large" => "fa-5x"
			),
			"description" => "This attribute doesn't work when Icon Position is Top With Title Over",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Custom Icon Size (px)",
			"param_name" => "custom_icon_size",
			"description" => "Default value is 20",
			"dependency" => Array('element' => "fe_icon", 'not_empty' => true)
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Text Left Padding (px)",
			"param_name" => "text_left_padding",
			"description" => "Default value is 86. Only when Icon Position is Left",
			"dependency" => Array('element' => "fe_icon", 'not_empty' => true)
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Animation",
			"param_name" => "icon_animation",
			"value" => array(
				"No" => "",
				"Yes" => "q_icon_animation"
			),
			"dependency" => Array('element' => "icon", 'not_empty' => true)
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Animation Delay (ms)",
			"param_name" => "icon_animation_delay",
			"value" => "",
			"description" => "",
			"dependency" => Array('element' => "icon_animation", 'value' => array('q_icon_animation'))
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Position",
			"param_name" => "icon_position",
			"value" => array(
				"Top" => "top",
				"Left" => "left",
				"Left From Title" => "left_from_title"
			),
			"description" => "Icon Position (only for normal box type)",
			"dependency" => Array('element' => "box_type", 'value' => array('normal'))
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Margin",
			"param_name" => "icon_margin",
			"value" => "",
			"description" => "Margin should be set in a top right bottom left format"
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Border Color",
			"param_name" => "icon_border_color",
			"description" => "Only for Square and Circle type",
			"dependency" => Array('element' => "icon_type", 'value' => array('square','circle'))
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Color",
			"param_name" => "icon_color",
			"dependency" => Array('element' => "icon", 'not_empty' => true)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Background Color",
			"param_name" => "icon_background_color",
			"description" => "Icon Background Color (only for square and circle icon type)",
			"dependency" => Array('element' => "icon_type", 'value' => array('square','circle'))
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Title",
			"param_name" => "title",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Title Tag",
			"param_name" => "title_tag",
			"value" => array(
				""   => "",
				"h2" => "h2",
				"h3" => "h3",
				"h4" => "h4",
				"h5" => "h5",
				"h6" => "h6",
			),
			"dependency" => Array('element' => "title", 'not_empty' => true)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Title Color",
			"param_name" => "title_color",
			"dependency" => Array('element' => "title", 'not_empty' => true)
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Title Top Padding (px)",
			"param_name" => "title_padding",
			"value" => "",
			"description" => "This attribute is used for boxed type",
			"dependency" => Array('element' => "box_type", 'value' => array('icon_in_a_box'))
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Text",
			"param_name" => "text",
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Text Color",
			"param_name" => "text_color",
			"dependency" => Array('element' => "text", 'not_empty' => true)
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Link",
			"param_name" => "link",
			"value" => "",
			"dependency" => Array('element' => "box_type", 'value' => array('normal'))
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Link Text",
			"param_name" => "link_text",
			"description" => "Default value is READ MORE",
			"dependency" => Array('element' => "link", 'not_empty' => true)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Link Color",
			"param_name" => "link_color",
			"description" => "",
			"dependency" => Array('element' => "link_text", 'not_empty' => true)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Target",
			"param_name" => "target",
			"value" => array(
				""   => "",
				"Self" => "_self",
				"Blank" => "_blank"
			),
			"dependency" => Array('element' => "link", 'not_empty' => true)
		)
	)
) );

/*** Image Hover ***/

vc_map( array(
		"name" => "Image Hover",
		"base" => "image_hover",
		"category" => 'by SELECT',
		"icon" => "icon-wpb-image_hover",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "attach_image",
				"holder" => "div",
				"class" => "",
				"heading" => "Image",
				"param_name" => "image"
			),
			array(
				"type" => "attach_image",
				"holder" => "div",
				"class" => "",
				"heading" => "Hover Image",
				"param_name" => "hover_image"
			),
            array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Link",
				"param_name" => "link",
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Target",
				"param_name" => "target",
				"description" => "",
                "value" => array(
                    "Self" => "_self",
                    "Blank" => "_blank"
                )
			),
            array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Animation",
				"param_name" => "animation",
				"description" => "",
                "value" => array(
                    "" => "",
                    "Yes" => "yes",
                    "No" => "no"
                )
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Animation Speed (in s)",
				"param_name" => "animation_speed",
				"dependency" => array('element' => "animation", 'value' => array("yes"))
			),
            array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Transition Delay(s)",
				"param_name" => "transition_delay",
				"description" => "",
                "dependency" => array('element' => "animation", 'value' => array("yes"))
			)
		)
) );

/*** Image With Text ***/

vc_map( array(
		"name" => "Image With Text",
		"base" => "image_with_text",
		"category" => 'by SELECT',
		"icon" => "icon-wpb-image_with_text",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "attach_image",
				"holder" => "div",
				"class" => "",
				"heading" => "Image",
				"param_name" => "image"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title",
				"param_name" => "title",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Color",
				"param_name" => "title_color",
				"description" => ""
			),
            array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Title Tag",
				"param_name" => "title_tag",
				"value" => array(
                    ""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"description" => ""
            ),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => "Content",
				"param_name" => "content",
				"value" => "<p>"."I am test text for Image with text shortcode."."</p>",
				"description" => ""
			)
		)
) );

/*** Interactive Banners ***/

vc_map( array(
		"name" => "Interactive Banners",
		"base" => "interactive_banners",
		"category" => 'by SELECT',
		"icon" => "icon-wpb-image_with_text_over",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Width",
				"param_name" => "layout_width",
				"value" => array(
                    ""   => "",
                    "1/2" => "one_half",
					"1/3" => "one_third",
					"1/4" => "one_fourth",
				),
				"description" => ""
            ),
			array(
				"type" => "attach_image",
				"holder" => "div",
				"class" => "",
				"heading" => "Image",
				"param_name" => "image"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon Pack",
				"param_name" => "icon_pack",
				"value" => array(
					"No Icon" => "",
					"Font Awesome" => "font_awesome",
					"Font Elegant" => "font_elegant"
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "fa_icon",
				"value" => $fa_icons,
				"description" => "",
				"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "fe_icon",
				"value" => $fe_icons,
				"description" => "",
				"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Custom Size (px)",
				"param_name" => "icon_custom_size",
				"value" => "",
				"description" => "Defaul value is 45",
				"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome','font_elegant'))
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Icon Color",
				"param_name" => "icon_color",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title",
				"param_name" => "title",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Color",
				"param_name" => "title_color",
				"dependency" => Array('element' => "title", 'not_empty' => true)
			),
            array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Size (px)",
				"param_name" => "title_size",
				"description" => "Defaul value is 21",
				"dependency" => Array('element' => "title", 'not_empty' => true)
			),
            array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Title Tag",
				"param_name" => "title_tag",
				"value" => array(
                    ""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"dependency" => Array('element' => "title", 'not_empty' => true)
            ),
            array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Subtitle",
				"param_name" => "subtitle",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Subtitle Color",
				"param_name" => "subtitle_color",
				"dependency" => Array('element' => "subtitle", 'not_empty' => true)
			),
            array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Subtitle Size (px)",
				"param_name" => "subtitle_size",
				"description" => "Defaul value is 17",
				"dependency" => Array('element' => "subtitle", 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Subtitle Tag",
				"param_name" => "subtitle_tag",
				"value" => array(
                    ""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"dependency" => Array('element' => "subtitle", 'not_empty' => true)
            ),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => "Content",
				"param_name" => "content",
				"value" => "<p>"."I am test text for Image with text shortcode."."</p>",
				"description" => ""
			)
		)
) );

/*** Latest Posts ***/

vc_map( array(
		"name" => "Latest Posts",
		"base" => "latest_post",
		"icon" => "icon-wpb-latest_post",
		"category" => 'by SELECT',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __("Type", 'qode'),
				"param_name" => "type",
				"value" => array(
					"Image in left box" => "image_in_box",
					"Boxes" => "boxes"
				),
				"description" => ""
			),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Number of Posts",
                "param_name" => "number_of_posts",
                "description" => "",
                "dependency" => Array('element' => "type", 'value' => array('image_in_box'))
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Number of Columns",
                "param_name" => "number_of_columns",
                "value" => array(
					"One" => "1",
					"Two" => "2",
					"Three" => "3",
					"Four" => "4"
				),
                "description" => "",
                "dependency" => Array('element' => "type", 'value' => array('boxes'))
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Number of Rows",
                "param_name" => "number_of_rows",
                "value" => array(
					"One"   => "1",
					"Two"   => "2",
					"Three" => "3",
					"Four"  => "4",
					"Five"  => "5"
				),
                "description" => "",
                "dependency" => Array('element' => "type", 'value' => array('boxes'))
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order By",
				"param_name" => "order_by",
				"value" => array(
					"Title" => "title",
					"Date" => "date"
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order",
				"param_name" => "order",
				"value" => array(
					"ASC" => "ASC",
					"DESC" => "DESC"
				),
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Category Slug",
				"param_name" => "category",
				"description" => "Leave empty for all or use comma for list"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Length",
				"param_name" => "text_length",
				"description" => "Number of characters",
                "description" => "",
                "dependency" => Array('element' => "type", 'value' => array('boxes'))
            ),
            array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Title Tag",
				"param_name" => "title_tag",
				"value" => array(
                    ""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"description" => ""
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Display Category",
				"param_name" => "display_category",
				"value" => array(
					"Default" => "",
					"Yes" => "1",
					"No" => "0"
				),
				"description" => ''
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Display Date",
				"param_name" => "display_date",
				"value" => array(
				    "Default" => "",
					"Yes" => "1",
					"No" => "0"
				),
				"description" => ''
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Display Author",
				"param_name" => "display_author",
				"value" => array(
					"Default" => "",
					"Yes" => "1",
					"No" => "0"
				)
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Box Background Color",
				"param_name" => "background_color",
				"dependency" => Array('element' => "type", 'value' => array('boxes'))
			)
		)
) );

/*** Line Graph shortcode ***/

vc_map( array(
		"name" => "Line Graph",
		"base" => "line_graph",
		"icon" => "icon-wpb-line_graph",
		"category" => 'by SELECT',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Type",
				"param_name" => "type",
				"value" => array(
					"" => "",
					"Rounded edges" => "rounded",
					"Sharp edges" => "sharp"	
				),
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Width",
				"param_name" => "width",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Height",
				"param_name" => "height",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Custom Color",
				"param_name" => "custom_color",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Scale steps",
				"param_name" => "scale_steps",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Scale step width",
				"param_name" => "scale_step_width",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Labels",
				"param_name" => "labels",
				"value" => "Label 1, Label 2, Label 3"
			),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => "Content",
				"param_name" => "content",
				"value" => "#e6ae48,Legend One,1,5,10;#f5b94d,Legend Two,3,7,20;#fdc050,Legend Three,10,2,34"
			)
		)
) );

/*** Message ***/

vc_map( array(
	"name" => "Message",
	"base" => "message",
	"category" => 'by SELECT',
	"icon" => "icon-wpb-message",
	"allowed_container_element" => 'vc_row',
	"params" => array(
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Type",
			"param_name" => "type",
			"value" => array(
				"Normal" => "normal",
				"With Icon" => "with_icon"
			)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon pack",
			"param_name" => "icon_pack",
			"value" => array(
				"Font Awesome" => "font_awesome",
				"Font Elegant" => "font_elegant"
			),
			"description" => "",
			"dependency" => Array('element' => "type", 'value' => array('with_icon'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fa_icon",
			"value" => $fa_icons,
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fe_icon",
			"value" => $fe_icons,
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Size",
			"param_name" => "icon_size",
			"value" => array(
				"Small" => "fa-lg",
				"Medium" => "fa-2x",
				"Large" => "fa-3x"
			),
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Custom Size (px)",
			"param_name" => "icon_custom_size",
			"value" => "",
			"dependency" => Array('element' => "type", 'value' => array('with_icon'))
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Icon Color",
			"param_name" => "icon_color",
			"description" => "",
			"dependency" => Array('element' => "type", 'value' => array('with_icon'))
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Icon Background Color",
			"param_name" => "icon_background_color",
			"description" => "",
			"dependency" => Array('element' => "type", 'value' => array('with_icon'))
		),
		array(
			"type" => "attach_image",
			"holder" => "div",
			"class" => "",
			"heading" => "Custom Icon",
			"param_name" => "custom_icon",
			"dependency" => Array('element' => "type", 'value' => array('with_icon'))
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Background Color",
			"param_name" => "background_color",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Border Color",
			"param_name" => "border_color",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Border Width (px)",
			"param_name" => "border_width",
			"description" => "Default value is 2"
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Close Button Color",
			"param_name" => "close_button_color",
			"description" => "Default color is #fff"
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => "Content",
			"param_name" => "content",
			"value" => "<p>"."I am test text for Message shortcode."."</p>",
			"description" => ""
		)
	)
) );

/*** Ordered List ***/

vc_map( array(
		"name" => "List - Ordered",
		"base" => "ordered_list",
		"icon" => "icon-wpb-ordered_list",
		"category" => 'by SELECT',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => "Content",
				"param_name" => "content",
				"value" => "<ol><li>Lorem Ipsum</li><li>Lorem Ipsum</li><li>Lorem Ipsum</li></ol>",
				"description" => ""
			)

		)
) );

/*** Pie Chart ***/

vc_map( array(
		"name" => "Pie Chart",
		"base" => "pie_chart",
		"icon" => "icon-wpb-pie_chart",
		"category" => 'by SELECT',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Percentage",
				"param_name" => "percent",
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Show Percentage Mark",
				"param_name" => "show_percent_mark",
				"value" => array(
					"Yes" => "with_mark",
					"No"  => "without_mark"	
				),
				"dependency" => Array('element' => "percent", 'not_empty' => true)
            ),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Percentage Color",
				"param_name" => "percentage_color",
				"dependency" => Array('element' => "percent", 'not_empty' => true)
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Percentage Font Size",
				"param_name" => "percent_font_size",
				"dependency" => Array('element' => "percent", 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Percentage Font weight",
				"param_name" => "percent_font_weight",
				"value" => array(
					"Default" 			=> "",
					"Thin 100"			=> "100",
					"Extra-Light 200" 	=> "200",
					"Light 300"			=> "300",
					"Regular 400"		=> "400",
					"Medium 500"		=> "500",
					"Semi-Bold 600"		=> "600",
					"Bold 700"			=> "700",
					"Extra-Bold 800"	=> "800",
					"Ultra-Bold 900"	=> "900"
				),
				"dependency" => Array('element' => "percent", 'not_empty' => true)
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Bar Active Color",
				"param_name" => "active_color",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Bar Noactive Color",
				"param_name" => "noactive_color",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Pie Chart Line Width (px)",
				"param_name" => "line_width",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title",
				"param_name" => "title",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Color",
				"param_name" => "title_color",
				"description" => ""
			),
            array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Title Tag",
				"param_name" => "title_tag",
				"value" => array(
                    ""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"description" => ""
            ),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Text",
				"param_name" => "text",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Color",
				"param_name" => "text_color",
				"description" => ""
			)
		)
) );

/*** Pie Chart With Icon ***/

vc_map( array(
	"name" => "Pie Chart With Icon",
	"base" => "pie_chart_with_icon",
	"icon" => "icon-wpb-pie_chart_with_icon",
	"category" => 'by SELECT',
	"allowed_container_element" => 'vc_row',
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Percentage",
			"param_name" => "percent",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Bar Active Color",
			"param_name" => "active_color",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Bar Inactive Color",
			"param_name" => "noactive_color",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Pie Chart Line Width (px)",
			"param_name" => "line_width",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Title",
			"param_name" => "title",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Title Color",
			"param_name" => "title_color",
			"dependency" => array('element' => "title", 'not_empty' => true)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Title Tag",
			"param_name" => "title_tag",
			"value" => array(
				""   => "",
				"h2" => "h2",
				"h3" => "h3",
				"h4" => "h4",
				"h5" => "h5",
				"h6" => "h6",
			),
			"dependency" => array('element' => "title", 'not_empty' => true)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon pack",
			"param_name" => "icon_pack",
			"value" => array(
				"No Icon" => "",
				"Font Awesome" => "font_awesome",
				"Font Elegant" => "font_elegant"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fa_icon",
			"value" => $fa_icons,
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fe_icon",
			"value" => $fe_icons,
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Color",
			"param_name" => "icon_color",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome','font_elegant'))
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Text",
			"param_name" => "text",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Text Color",
			"param_name" => "text_color",
			"dependency" => array('element' => "text", 'not_empty' => true)
		)
	)
) );

/*** Pie Chart 2 (Pie) ***/

vc_map( array(
		"name" => "Pie Chart 2 (Pie)",
		"base" => "pie_chart2",
		"icon" => "icon-wpb-pie_chart2",
		"category" => 'by SELECT',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Width",
				"param_name" => "width",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Height",
				"param_name" => "height",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Legend Text Color",
				"param_name" => "color",
				"description" => ""
			),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => "Content",
				"param_name" => "content",
				"value" => "15,#e6ae48,Legend One; 35,#f5b94d,Legend Two; 50,#fdc050,Legend Three",
				"description" => ""
			)

		)
) );

/*** Pie Chart 3 (Doughnut) ***/

vc_map( array(
		"name" => "Pie Chart 3 (Doughnut)",
		"base" => "pie_chart3",
		"category" => 'by SELECT',
		"icon" => "icon-wpb-pie_chart3",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Width",
				"param_name" => "width",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Height",
				"param_name" => "height",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Legend Text Color",
				"param_name" => "color",
				"description" => ""
			),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => "Content",
				"param_name" => "content",
				"value" => "15,#e6ae48,Legend One; 35,#f5b94d,Legend Two; 50,#fdc050,Legend Three",
				"description" => ""
			)

		)
) );

/*** Portfolio List ***/

vc_map( array(
		"name" => "Portfolio List",
		"base" => "portfolio_list",
		"category" => 'by SELECT',
		"icon" => "icon-wpb-portfolio",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Type",
				"param_name" => "type",
				"value" => array(
					"Standard" => "standard",
					"Standard No Space" => "standard_no_space",
					"Gallery Text" => "hover_text",
					"Gallery No Space" => "hover_text_no_space",
					"Masonry Without Space" => "masonry",
                    "Pinterest" => "masonry_with_space"
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Hover Type",
				"param_name" => "hover_type",
				"value" => array(
					"Default" => "default_hover",
					"Standard" => "standard_hover",
					"Elegant Without Icons" => "elegant_hover"
				),
				"dependency" => array('element' => "type", 'value' => array('hover_text','hover_text_no_space','masonry'))
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Box Background Color",
				"param_name" => "box_background_color",
				"value" => "",
				"description" => "",
				"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space', 'masonry_with_space'))
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Box Border",
				"param_name" => "box_border",
				"value" => array(
					"Default" => "",
					"No" => "no",
					"Yes" => "yes"
				),
				"description" => "",
				"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space', 'masonry_with_space'))
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Box Border Width (px)",
				"param_name" => "box_border_width",
				"value" => "",
				"description" => "",
				"dependency" => array('element' => "box_border", 'value' => array('yes'))
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Box Border Color",
				"param_name" => "box_border_color",
				"value" => "",
				"description" => "",
				"dependency" => array('element' => "box_border", 'value' => array('yes'))
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Columns",
				"param_name" => "columns",
				"value" => array(
					"" => "",
					"2" => "2",
					"3" => "3",	
					"4" => "4",	
					"5" => "5",	
					"6" => "6"	
				),
				"description" => "",
				"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space','hover_text','hover_text_no_space','masonry_with_space'))
			),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Image size",
                "param_name" => "image_size",
                "value" => array(
                    "Default" => "",
                    "Original Size" => "full",
                    "Square" => "square",
                    "Landscape" => "landscape",
                    "Portrait" => "portrait"
                ),
                "description" => "",
				"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space','hover_text','hover_text_no_space'))
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order By",
				"param_name" => "order_by",
				"value" => array(
					"" => "",
					"Menu Order" => "menu_order",
					"Title" => "title",	
					"Date" => "date"
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order",
				"param_name" => "order",
				"value" => array(
					"" => "",
					"ASC" => "ASC",
					"DESC" => "DESC",	
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Filter",
				"param_name" => "filter",
				"value" => array(
					"" => "",
					"Yes" => "yes",
					"No" => "no"	
				),
				"description" => "Default value is No"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Filter Order By",
				"param_name" => "filter_order_by",
				"value" => array(
					"Name"  => "name",
					"Count" => "count",
					"Id"    => "id",	
					"Slug"  => "slug"
				),
				"description" => "Default value is Name",
				"dependency" => array('element' => "filter", 'value' => array('yes'))
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Disable Filter Title",
				"param_name" => "disable_filter_title",
				"value" => array(
					"" => "",
					"Yes" => "yes",
					"No" => "no"	
				),
				"description" => "Default value is No",
				"dependency" => array('element' => "filter", 'value' => array('yes'))
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Filter Align",
				"param_name" => "filter_align",
				"value" => array(
					"Left" => "left_align",
					"Center" => "center_align",
					"Right" => "right_align"	
				),
				"dependency" => array('element' => "filter", 'value' => array('yes'))
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Disable Portfolio Link",
				"param_name" => "disable_link",
				"value" => array(
					"" => "",
					"Yes" => "yes",
					"No" => "no"	
				),
				"description" => "Default value is No"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Show Lightbox",
				"param_name" => "lightbox",
				"value" => array(
					"" => "",
					"Yes" => "yes",
					"No" => "no"	
				),
				"description" => "Default value is Yes"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Show Like",
				"param_name" => "show_like",
				"value" => array(
					"" => "",
					"Yes" => "yes",
					"No" => "no"	
				),
				"description" => "Default value is Yes"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Show Load More",
				"param_name" => "show_load_more",
				"value" => array(
					"" => "",
					"Yes" => "yes",
					"No" => "no"	
				),
				"description" => "Default value is Yes",
				"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space','hover_text','hover_text_no_space', 'masonry_with_space'))
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Number",
				"param_name" => "number",
				"value" => "-1",
				"description" => "Number of portolios on page (-1 is all)",
				"dependency" => array('element' => "type", 'value' => array('standard','standard_no_space','hover_text','hover_text_no_space','masonry','masonry_with_space'))
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Category",
				"param_name" => "category",
				"value" => "",
				"description" => "Category Slug (leave empty for all)"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Selected Projects",
				"param_name" => "selected_projects",
				"value" => "",
				"description" => "Selected Projects (leave empty for all, delimit by comma)"
			),
            array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Title Tag",
				"param_name" => "title_tag",
				"value" => array(
                    ""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"description" => ""
            ),
            array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Custom Font Size (px)",
				"param_name" => "title_font_size",
				"value" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Text align",
				"param_name" => "text_align",
				"value" => array(
					""   => "",
					"Left" => "left",
					"Center" => "center",
					"Right" => "right"
				),
				"description" => "",
				"dependency" => array('element' => 'type', 'value' => array('standard', 'standard_no_space', 'masonry_with_space'))
			)
		)
) );

/*** Portfolio Slider ***/

vc_map( array(
		"name" => "Portfolio Slider",
		"base" => "portfolio_slider",
		"category" => 'by SELECT',
		"icon" => "icon-wpb-portfolio_slider",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order By",
				"param_name" => "order_by",
				"value" => array(
					"" => "",
					"Menu Order" => "menu_order",
					"Title" => "title",	
					"Date" => "date"
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order",
				"param_name" => "order",
				"value" => array(
					"" => "",
					"ASC" => "ASC",
					"DESC" => "DESC",	
				),
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Number",
				"param_name" => "number",
				"value" => "-1",
				"description" => "Number of portolios on page (-1 is all)"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Category",
				"param_name" => "category",
				"value" => "",
				"description" => "Category Slug (leave empty for all)"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Selected Projects",
				"param_name" => "selected_projects",
				"value" => "",
				"description" => "Selected Projects (leave empty for all, delimit by comma)"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Disable Portfolio Link",
				"param_name" => "disable_link",
				"value" => array(
					"" => "",
					"Yes" => "yes",
					"No" => "no"	
				),
				"description" => "Default value is No"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Show Lightbox",
				"param_name" => "lightbox",
				"value" => array(
					"" => "",
					"Yes" => "yes",
					"No" => "no"	
				),
				"description" => "Default value is Yes"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Show Like",
				"param_name" => "show_like",
				"value" => array(
					"" => "",
					"Yes" => "yes",
					"No" => "no"	
				),
				"description" => "Default value is Yes"
			),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => "Title Tag",
                "param_name" => "title_tag",
                "value" => array(
                    ""   => "",
                    "h2" => "h2",
                    "h3" => "h3",
                    "h4" => "h4",
                    "h5" => "h5",
                    "h6" => "h6",
                ),
                "description" => ""
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Image size",
                "param_name" => "image_size",
                "value" => array(
					"Default" => "",
					"Original Size" => "full",
					"Square" => "square",
					"Landscape" => "landscape",
					"Portrait" => "portrait"
                ),
                "description" => ""
            ),
            array(
                "type" => "checkbox",
                "class" => "",
                "heading" => "Prev/Next navigation",
                "value" => array("Enable prev/next navigation?" => "enable_navigation"),
                "param_name" => "enable_navigation"
            )
		)
) );

/*** Progress Bar Horizontal ***/

vc_map( array(
		"name" => "Progress Bar - Horizontal",
		"base" => "progress_bar",
		"icon" => "icon-wpb-progress_bar",
		"category" => 'by SELECT',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title",
				"param_name" => "title",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Color",
				"param_name" => "title_color",
				"description" => ""
			),
            array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Title Tag",
				"param_name" => "title_tag",
				"value" => array(
                    ""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"description" => ""
            ),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Custom Size (px)",
				"param_name" => "title_custom_size",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Percentage",
				"param_name" => "percent",
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Show Percentage Mark",
				"param_name" => "show_percent_mark",
				"value" => array(
					"Yes" => "with_mark",
					"No"  => "without_mark"	
				),
				"dependency" => Array('element' => "percent", 'not_empty' => true)
            ),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Percentage Color",
				"param_name" => "percent_color",
				"dependency" => Array('element' => "percent", 'not_empty' => true)
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Percentage Font Size",
				"param_name" => "percent_font_size",
				"dependency" => Array('element' => "percent", 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Percentage Font weight",
				"param_name" => "percent_font_weight",
				"value" => array(
					"Default" 			=> "",
					"Thin 100"			=> "100",
					"Extra-Light 200" 	=> "200",
					"Light 300"			=> "300",
					"Regular 400"		=> "400",
					"Medium 500"		=> "500",
					"Semi-Bold 600"		=> "600",
					"Bold 700"			=> "700",
					"Extra-Bold 800"	=> "800",
					"Ultra-Bold 900"	=> "900"
				),
				"dependency" => Array('element' => "percent", 'not_empty' => true)
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Active Background Color",
				"param_name" => "active_background_color",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Active Border Color",
				"param_name" => "active_border_color",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Inactive Background Color",
				"param_name" => "noactive_background_color",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Progress Bar Height (px)",
				"param_name" => "height",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Progress Bar Border Radius",
				"param_name" => "border_radius",
				"description" => ""
			)
		)
) );

/*** Progress Bar Icon ***/

vc_map( array(
	"name" => "Progress Bar - Icon",
	"base" => "progress_bar_icon",
	"icon" => "icon-wpb-progress_bar_icon",
	"category" => 'by SELECT',
	"allowed_container_element" => 'vc_row',
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Number of Icons",
			"param_name" => "icons_number",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Number of Active Icons",
			"param_name" => "active_number",
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Type",
			"param_name" => "type",
			"value" => array(
				"Normal" => "normal",
				"Circle" => "circle",
				"Square" => "square"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon Pack",
			"param_name" => "icon_pack",
			"value" => array(
				"Font Awesome" => "font_awesome",
				"Font Elegant" => "font_elegant"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fa_icon",
			"value" => $fa_icons,
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fe_icon",
			"value" => $fe_icons,
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Size",
			"param_name" => "size",
			"value" => array(
				"Tiny" => "tiny",
				"Small" => "small",
				"Medium" => "medium",
				"Large" => "large",
				"Very Large" => "very_large",
			),
			"description" => "",
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Color",
			"param_name" => "icon_color",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Active Color",
			"param_name" => "icon_active_color",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Background Color",
			"param_name" => "background_color",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Background Active Color",
			"param_name" => "background_active_color",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Border Color",
			"param_name" => "border_color",
			"description" => "Only for Square and Circle type",
			"dependency" => array('element' => "type", 'value' => array('square', 'circle'))
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Border Active Color",
			"param_name" => "border_active_color",
			"description" => "Only for Square and Circle type",
			"dependency" => array('element' => "type", 'value' => array('square', 'circle'))
		)
	)
) );

/*** Progress Bar Vertical ***/

vc_map( array(
		"name" => "Progress Bar - Vertical",
		"base" => "progress_bar_vertical",
		"icon" => "icon-wpb-vertical_progress_bar",
		"category" => 'by SELECT',
		"allowed_container_element" => 'vc_row',
		"params" => array(
            array (
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title",
				"param_name" => "title",
				"description" => ""
			),
            array (
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Color",
				"param_name" => "title_color",
				"description" => ""
			),
            array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Title Tag",
				"param_name" => "title_tag",
				"value" => array(
                    ""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"description" => ""
            ),
            array (
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Size (px)",
				"param_name" => "title_size",
				"description" => ""
			),
            array (
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Bar Color",
                "param_name" => "bar_color",
                "description" => ""
            ),
            array (
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Bar Border Color",
                "param_name" => "bar_border_color",
                "description" => ""
            ),
			array (
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Bar Background Color",
				"param_name" => "background_color",
				"description" => ""
			),
			array (
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Top Border Radius",
				"param_name" => "border_radius",
				"description" => ""
			),
            array (
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Percent",
				"param_name" => "percent",
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Show Percentage Mark",
				"param_name" => "show_percent_mark",
				"value" => array(
					"Yes" => "with_mark",
					"No"  => "without_mark"	
				),
				"dependency" => Array('element' => "percent", 'not_empty' => true)
            ),
            array (
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Percentage Text Size(px)",
				"param_name" => "percentage_text_size",
				"dependency" => Array('element' => "percent", 'not_empty' => true)
			),
            array (
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Percentage Color",
				"param_name" => "percent_color",
				"dependency" => Array('element' => "percent", 'not_empty' => true)
			),
            array(
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => "Text",
				"param_name" => "text",
				"value" => "",
				"description" => ""
			)
		)
) );

/*** Select Carousel ***/

vc_map( array(
		"name" => "Select Carousel",
		"base" => "qode_carousel",
		"category" => 'by SELECT',
		"icon" => "icon-wpb-qode_carousel",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Carousel Slider",
				"param_name" => "carousel",
				"value" => $carousel_sliders,
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order By",
				"param_name" => "order_by",
				"value" => array(
					"" => "",
					"Menu Order" => "menu_order",
					"Title" => "title",	
					"Date" => "date"
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order",
				"param_name" => "order",
				"value" => array(
					"" => "",
					"ASC" => "ASC",
					"DESC" => "DESC",	
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Show navigation?",
				"param_name" => "show_navigation",
				"value" => array(
					"Yes" => "yes",
					"No" => "no",
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Show Items In Two Rows?",
				"param_name" => "show_in_two_rows",
				"value" => array(
					"No" => "",
					"Yes" => "yes",
				),
				"description" => ""
			)
		)
) );

/*** Select Image Slider ***/

vc_map( array(
    "name" => "Select Image Slider",
    "base" => "image_slider_no_space",
    "category" => 'by SELECT',
    "icon" => "icon-wpb-images-stack",
    "allowed_container_element" => 'vc_row',
    "params" => array(
        array(
            "type" => "attach_images",
            "holder" => "div",
            "class" => "",
            "heading" => "Images",
            "param_name" => "images"
        ),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "On Click",
			"param_name" => "on_click",
			"value" => array(
				"Do Nothing"       			 	=> "",
				"Open Image in Prettyphoto"     => "prettyphoto",
				"Open Image in New Tab"			=> "new_tab",
				"Use Custom Links"				=> "use_custom_links"
			),
			"description" => ""
		),
		array(
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => "Custom Links",
			"param_name" => "custom_links",
			"value" => "",
			"dependency" => array('element' => 'on_click', 'value' => 'use_custom_links'),
			"description" => "Enter links for each image here. Divide links with comma."
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Custom Links Target",
			"param_name" => "custom_links_target",
			"value" => array(
				"" => "",
				"Same Window" => "_self",
				"New Window" => "_blank"
			),
			"dependency" => array('element' => 'on_click', 'value' => 'use_custom_links'),
			"description" => ""
		),
        array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => "Slider Height (px)",
            "param_name" => "height",
            "value" => "",
            "dependency" => ""
        ),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Navigation Style",
			"param_name" => "navigation_style",
			"value" => array(
				"" => "",
				"Light" => "light",
				"Dark" => "dark"
			)
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Highlight Active Image",
			"param_name" => "highlight_active_image",
			"value" => array(
				"" => "",
				"Yes" => "yes",
				"No" => "no"
			)
		)
    )
) );

/*** Service Table ***/

vc_map( array(
        "name" => "Service Table",
        "base" => "service_table",
        "icon" => "icon-wpb-service_table",
        "category" => 'by SELECT',
        "allowed_container_element" => 'vc_row',
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Title",
                "param_name" => "title",
                "value" => ""
            ),
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => "Title Tag",
                "param_name" => "title_tag",
                "value" => array(
                    ""   => "",
                    "h2" => "h2",
                    "h3" => "h3",
                    "h4" => "h4",   
                    "h5" => "h5",   
                    "h6" => "h6",   
                ),
                "description" => ""
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Title/Title Icon Color",
                "param_name" => "title_color",
                "description" => ""
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Title Background Type",
                "param_name" => "title_background_type",
                "value" => array(
                    "Background Color" => "background_color_type",
                    "Background Image" => "background_image_type"
                ),
                "description" => ""
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Title Background Color",
                "param_name" => "title_background_color",
                "description" => "",
                "dependency" => array('element' => "title_background_type", 'value' => array('background_color_type'))
            ),
            array(
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => "Background Image",
                "param_name" => "background_image",
                "dependency" => array('element' => "title_background_type", 'value' => array('background_image_type'))
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Background Image Height (px)",
                "param_name" => "background_image_height",
                "value" => "",
                "dependency" => array('element' => "title_background_type", 'value' => array('background_image_type'))
            ),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon Pack",
				"param_name" => "icon_pack",
				"value" => array(
					"Font Awesome" => "font_awesome",
					"Font Elegant" => "font_elegant"
				)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "fa_icon",
				"value" => $fa_icons,
				"description" => "",
				"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "fe_icon",
				"value" => $fe_icons,
				"description" => "",
				"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
			),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Custom Size (px)",
                "param_name" => "custom_size",
                "value" => ""
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Content Background Color",
                "param_name" => "content_background_color",
                "description" => ""
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Border Around",
				"param_name" => "border",
				"value" => array(
					"Default" => "",
					"No" => "no",
					"Yes" => "yes"
				),
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Border Width (px)",
				"param_name" => "border_width",
				"value" => "",
				"dependency" => array('element' => "border", 'value' => array('yes'))
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Border Color",
				"param_name" => "border_color",
				"value" => "",
				"dependency" => array('element' => "border", 'value' => array('yes'))
			),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "class" => "",
                "heading" => "Content",
                "param_name" => "content",
                "value" => "<li>content content content</li><li>content content content</li><li>content content content</li>",
                "description" => ""
            )
        )
) );

/*** Social Icon ***/

vc_map( array(
	"name" => "Social Icons",
	"base" => "social_icons",
	"icon" => "icon-wpb-social_icons",
	"category" => 'by SELECT',
	"allowed_container_element" => 'vc_row',
	"params" => array(
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Type",
			"param_name" => "type",
			"value" => array(
				"Normal" => "normal_social",
				"Circle" => "circle_social",
				"Square" => "square_social"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon pack",
			"param_name" => "icon_pack",
			"value" => array(
				"Font Awesome" => "font_awesome",
				"Font Elegant" => "font_elegant"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fa_icon",
			"value" => qode_font_awesome_social_vc(),
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon",
			"param_name" => "fe_icon",
			"value" => qode_font_elegant_social_vc(),
			"description" => "",
			"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Size",
			"param_name" => "size",
			"value" => array(
				"Tiny"   => "tiny",
				"Small"  => "small",
				"Medium" => "medium",
				"Large"  => "large",
				"Huge"   => "huge"
			),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Link",
			"param_name" => "link",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Target",
			"param_name" => "target",
			"value" => array(
				"Self" => "_self",
				"Blank" => "_blank"
			)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Icon Color",
			"param_name" => "icon_color"
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Background Color",
			"param_name" => "background_color",
			"description" =>"",
			"dependency" => Array('element' => "type", 'value' => array('circle_social', 'square_social'))
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => "Border Color",
			"param_name" => "border_color",
			"description" =>"",
			"dependency" => Array('element' => "type", 'value' => array('circle_social', 'square_social'))
		),
		array(
            "type"              => "colorpicker",
            "holder"            => "div",
            "class"             => "",
            "heading"           => "Icon Hover Color",
            "param_name"        => "icon_hover_color",
            "description"       => ""
        ),
		array(
            "type"              => "colorpicker",
            "holder"            => "div",
            "class"             => "",
            "heading"           => "Background Hover Color",
            "param_name"        => "background_hover_color",
            "dependency" => Array('element' => "type", 'value' => array('circle_social', 'square_social'))
        ),
		array(
            "type"              => "colorpicker",
            "holder"            => "div",
            "class"             => "",
            "heading"           => "Border Hover Color",
            "param_name"        => "border_hover_color",
            "dependency" => Array('element' => "type", 'value' => array('circle_social', 'square_social'))
        )
	)
) );

/*** Social Share ***/

vc_map( array(
	"name" => "Social Share",
	"base" => "social_share",
	"icon" => "icon-wpb-social_share",
	"category" => 'by SELECT',
	"allowed_container_element" => 'vc_row',
	"show_settings_on_create" => false
) );

/*** Social Share List ***/

vc_map( array(
	"name" => "Social Share List",
	"base" => "social_share_list",
	"icon" => "icon-wpb-social_share",
	"category" => 'by SELECT',
	"allowed_container_element" => 'vc_row',
	"show_settings_on_create" => false
) );

/*** Team ***/

vc_map( array(
		"name" => "Team",
		"base" => "q_team",
		"category" => 'by SELECT',
		"icon" => "icon-wpb-q_team",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "attach_image",
				"holder" => "div",
				"class" => "",
				"heading" => "Image",
				"param_name" => "team_image"
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Image Hover Color",
				"param_name" => "team_image_hover_color"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Name",
				"param_name" => "team_name"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Name Tag",
				"param_name" => "team_name_tag",
				"value" => array(
                    ""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"dependency" => array('element' => 'team_name', 'not_empty' => true)
            ),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Name Font Size(px)",
				"param_name" => "team_name_font_size",
				"dependency" => array('element' => 'team_name', 'not_empty' => true)
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Name Color",
				"param_name" => "team_name_color",
				"dependency" => array('element' => 'team_name', 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Name Font Weight",
				"param_name" => "team_name_font_weight",
				"value" => $font_weight_array,
				"description" => "",
				"dependency" => array('element' => 'team_name', 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Name Text Transform",
				"param_name" => "team_name_text_transform",
				"value" => array(
					"Default" => "",
					"None" => "none",
					"Capitalize" => "capitalize",
					"Uppercase" => "uppercase",
					"Lowercase" => "lowercase"
				),
				"dependency" => array('element' => 'team_name', 'not_empty' => true)
			),
            array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Position",
				"param_name" => "team_position"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Position Font Size(px)",
				"param_name" => "team_position_font_size",
				"dependency" => array('element' => 'team_position', 'not_empty' => true)
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Position Color",
				"param_name" => "team_position_color",
				"dependency" => array('element' => 'team_position', 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Position Font Weight",
				"param_name" => "team_position_font_weight",
				"value" => $font_weight_array,
				"description" => "",
				"dependency" => array('element' => 'team_position', 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Position Text Transform",
				"param_name" => "team_position_text_transform",
				"value" => array(
					"Default" => "",
					"None" => "none",
					"Capitalize" => "capitalize",
					"Uppercase" => "uppercase",
					"Lowercase" => "lowercase"
				),
				"dependency" => array('element' => 'team_position', 'not_empty' => true)
			),
			array(
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => "Description",
				"param_name" => "team_description"
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Description Color",
				"param_name" => "team_description_color",
				"dependency" => array('element' => 'team_description', 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Align",
				"param_name" => "text_align",
				"value" => array(
					"Default" => "",
					"Left" => "left_align",
					"Center" => "center_align",
					"Right" => "right_align"
				)
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Background Color",
				"param_name" => "background_color",
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Box Border",
				"param_name" => "box_border",
				"value" => array(
					"Default" => "",
					"No" => "no",
					"Yes" => "yes"
				),
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Box Border Width",
				"param_name" => "box_border_width",
				"value" => "",
				"description" => "",
				"dependency" => array('element' => "box_border", 'value' => array('yes'))
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Box Border Color",
				"param_name" => "box_border_color",
				"value" => "",
				"description" => "",
				"dependency" => array('element' => "box_border", 'value' => array('yes'))
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icon Pack",
				"param_name" => "team_social_icon_pack",
				"value" => array(
					"Font Awesome" => "font_awesome",
					"Font Elegant" => "font_elegant"
				)
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icons Type",
				"param_name" => "team_social_icon_type",
				"value" => array(
					"Normal" => "normal_social",
					"Circle" => "circle_social",
					"Square" => "square_social"
				)
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icons Color",
				"param_name" => "team_social_icon_color"
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icons Background Color",
				"param_name" => "team_social_icon_background_color",
				"dependency" => array('team_social_icon_type' => 'team_position', 'value' => array('circle_social', 'square_social'))
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icons Border Color",
				"param_name" => "team_social_icon_border_color",
				"dependency" => array('team_social_icon_type' => 'team_position', 'value' => array('circle_social', 'square_social'))
			),
			array(
	            "type"              => "colorpicker",
	            "holder"            => "div",
	            "class"             => "",
	            "heading"           => "Social Icons Hover Color",
	            "param_name"        => "team_social_icon_hover_color",
	            "description"       => ""
	        ),
			array(
	            "type"              => "colorpicker",
	            "holder"            => "div",
	            "class"             => "",
	            "heading"           => "Social Icons Background Hover Color",
	            "param_name"        => "team_social_background_hover_color",
	            "dependency" => array('team_social_icon_type' => 'team_position', 'value' => array('circle_social', 'square_social'))
	        ),
			array(
	            "type"              => "colorpicker",
	            "holder"            => "div",
	            "class"             => "",
	            "heading"           => "Social Icons Border Hover Color",
	            "param_name"        => "team_social_border_hover_color",
	            "dependency" => array('team_social_icon_type' => 'team_position', 'value' => array('circle_social', 'square_social'))
	        ),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Social Icon 1",
				"param_name" => "team_social_fa_icon_1",
				"value" => qode_font_awesome_social_vc(),
				"dependency" => Array('element' => "team_social_icon_pack", 'value' => array('font_awesome'))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Social Icon 1",
				"param_name" => "team_social_fe_icon_1",
				"value" => qode_font_elegant_social_vc(),
				"dependency" => Array('element' => "team_social_icon_pack", 'value' => array('font_elegant'))
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icon 1 Link",
				"param_name" => "team_social_icon_1_link",
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icon 1 Target",
				"param_name" => "team_social_icon_1_target",
				"value" => array(
					"" => "",
					"Self" => "_self",
					"Blank" => "_blank"
				),
				"dependency" => Array('element' => "team_social_icon_1_link", 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Social Icon 2",
				"param_name" => "team_social_fa_icon_2",
				"value" => qode_font_awesome_social_vc(),
				"dependency" => Array('element' => "team_social_icon_pack", 'value' => array('font_awesome'))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Social Icon 2",
				"param_name" => "team_social_fe_icon_2",
				"value" => qode_font_elegant_social_vc(),
				"dependency" => Array('element' => "team_social_icon_pack", 'value' => array('font_elegant'))
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icon 2 Link",
				"param_name" => "team_social_icon_2_link",
				"description" => "This is enabled only if you are using social icon"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icon 2 Target",
				"param_name" => "team_social_icon_2_target",
				"value" => array(
					"" => "",
					"Self" => "_self",
					"Blank" => "_blank"
				),
				"dependency" => Array('element' => "team_social_icon_2_link", 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Social Icon 3",
				"param_name" => "team_social_fa_icon_3",
				"value" => qode_font_awesome_social_vc(),
				"dependency" => Array('element' => "team_social_icon_pack", 'value' => array('font_awesome'))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Social Icon 3",
				"param_name" => "team_social_fe_icon_3",
				"value" => qode_font_elegant_social_vc(),
				"dependency" => Array('element' => "team_social_icon_pack", 'value' => array('font_elegant'))
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icon 3 Link",
				"param_name" => "team_social_icon_3_link",
				"description" => "This is enabled only if you are using social icon"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icon 3 Target",
				"param_name" => "team_social_icon_3_target",
				"value" => array(
					"" => "",
					"Self" => "_self",
					"Blank" => "_blank"
				),
				"dependency" => Array('element' => "team_social_icon_3_link", 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Social Icon 4",
				"param_name" => "team_social_fa_icon_4",
				"value" => qode_font_awesome_social_vc(),
				"dependency" => Array('element' => "team_social_icon_pack", 'value' => array('font_awesome'))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Social Icon 4",
				"param_name" => "team_social_fe_icon_4",
				"value" => qode_font_elegant_social_vc(),
				"dependency" => Array('element' => "team_social_icon_pack", 'value' => array('font_elegant'))
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icon 4 Link",
				"param_name" => "team_social_icon_4_link",
				"description" => "This is enabled only if you are using social icon"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icon 4 Target",
				"param_name" => "team_social_icon_4_target",
				"value" => array(
					"" => "",
					"Self" => "_self",
					"Blank" => "_blank"
				),
				"dependency" => Array('element' => "team_social_icon_4_link", 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Social Icon 5",
				"param_name" => "team_social_fa_icon_5",
				"value" => qode_font_awesome_social_vc(),
				"dependency" => Array('element' => "team_social_icon_pack", 'value' => array('font_awesome'))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Social Icon 5",
				"param_name" => "team_social_fe_icon_5",
				"value" => qode_font_elegant_social_vc(),
				"dependency" => Array('element' => "team_social_icon_pack", 'value' => array('font_elegant'))
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icon 5 Link",
				"param_name" => "team_social_icon_5_link",
				"description" => "This is enabled only if you are using social icon"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Social Icon 5 Target",
				"param_name" => "team_social_icon_5_target",
				"value" => array(
					"" => "",
					"Self" => "_self",
					"Blank" => "_blank"
				),
				"dependency" => Array('element' => "team_social_icon_5_link", 'not_empty' => true)
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => "Team Member Skills",
				"value" => array("Show Team Member Skills?" => "yes"),
				"param_name" => "show_skills",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Skills Title Size",
				"param_name" => "skills_title_size",
				"dependency" => array("element" => "show_skills", "value" => "yes")
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "First Skill Title",
				"param_name" => "skill_title_1",
				"description" => "For example Web design",
				"dependency" => array("element" => "show_skills", "value" => "yes")
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "First Skill Percentage",
				"param_name" => "skill_percentage_1",
				"description" => "Enter just number, without %",
				"dependency" => array("element" => "show_skills", "value" => "yes")
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Second Skill Title",
				"param_name" => "skill_title_2",
				"description" => "For example Web design",
				"dependency" => array("element" => "show_skills", "value" => "yes")
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Second Skill Percentage",
				"param_name" => "skill_percentage_2",
				"description" => "Enter just number, without %",
				"dependency" => array("element" => "show_skills", "value" => "yes")
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Third Skill Title",
				"param_name" => "skill_title_3",
				"description" => "For example Web design",
				"dependency" => array("element" => "show_skills", "value" => "yes")
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Third Skill Percentage",
				"param_name" => "skill_percentage_3",
				"description" => "Enter just number, without %",
				"dependency" => array("element" => "show_skills", "value" => "yes")
			)
		)
) );

/*** Testimonials ***/

vc_map( array(
		"name" => "Testimonials",
		"base" => "testimonials",
		"category" => 'by SELECT',
		"icon" => "icon-wpb-testimonials",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Category",
				"param_name" => "category",
				"value" => "",
				"description" => "Category Slug (leave empty for all)"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Number",
				"param_name" => "number",
				"value" => "",
				"description" => "Number of Testimonials"
			),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Text Color",
                "param_name" => "text_color",
                "description" => ""
            ),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Font Size",
				"param_name" => "text_font_size",
				"description" => ""
			),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Author Text Color",
                "param_name" => "author_text_color",
                "description" => ""
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Text Align",
                "param_name" => "text_align",
                "value" => array(
                    "Left"   => "left_align",
                    "Center" => "center_align",
                    "Right"  => "right_align"
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Show navigation",
                "param_name" => "show_navigation",
                "value" => array(
                    "Yes" => "yes",
                    "No" => "no"
                ),
                "description" => ""
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Navigation Style",
                "param_name" => "navigation_style",
                "value" => array(
                    "Dark" => "dark",
                    "Light" => "light"
                ),
                "description" => "",
                "dependency" => array("element" => "show_navigation", "value" => array("yes"))
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Auto rotate slides",
                "param_name" => "auto_rotate_slides",
                "value" => array(
                    "3"         => "3",
                    "5"         => "5",
                    "10"        => "10",
                    "15"        => "15",
                    "Disable"   => "0"
                ),
                "description" => ""
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Animation type",
                "param_name" => "animation_type",
                "value" => array(
                    "Fade"   => "fade",
                    "Slide"  => "slide"
                ),
                "description" => ""
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Animation speed",
                "param_name" => "animation_speed",
                "value" => "",
                "description" => "Speed of slide animation in miliseconds"
            )
		)
) );

/*** Unordered List ***/

vc_map( array(
		"name" => "List - Unordered",
		"base" => "unordered_list",
		"icon" => "icon-wpb-unordered_list",
		"category" => 'by SELECT',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Style",
				"param_name" => "style",
				"value" => array(
					"Circle" => "circle",
					"Number" => "number"
				),
				"description" => ""
			),
            array(
                "type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Number Type",
				"param_name" => "number_type",
				"value" => array(
					"Circle" => "circle_number",
					"Transparent" => "transparent_number"
				),
				"description" => "",
                "dependency" => array('element' => "style", 'value' => array('number'))
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Animate List",
				"param_name" => "animate",
				"value" => array(
					"No" => "no",
					"Yes" => "yes"
				),
				"description" => ""
			),
            array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Font Weight",
				"param_name" => "font_weight",
				"value" => array(
                    "Default" => "",
					"Light" => "light",
					"Normal" => "normal",
                    "Bold" => "bold"
				),
				"description" => ""
			),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => "Content",
				"param_name" => "content",
				"value" => "<ul><li>Lorem Ipsum</li><li>Lorem Ipsum</li><li>Lorem Ipsum</li></ul>",
				"description" => ""
			)
		)
) );

class WPBakeryShortCode_Qode_Pricing_Tables  extends WPBakeryShortCodesContainer {}
vc_map( array(
    "name" => "Select Pricing Tables", "qode",
    "base" => "qode_pricing_tables",
    "as_parent" => array('only' => 'qode_pricing_table'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "category" => 'by SELECT',
    "icon" => "icon-wpb-pricing_column",
    "show_settings_on_create" => true,
    "params" => array(
        array(
            "type" => "dropdown",
            "holder" => "div",
            "class" => "",
            "heading" => "Columns",
            "param_name" => "columns",
            "value" => array(
                "Two"       => "two_columns",
                "Three"     => "three_columns",
                "Four"      => "four_columns",
            ),
            "description" => ""
        )
    ),
    "js_view" => 'VcColumnView'
) );

class WPBakeryShortCode_Qode_Pricing_Table  extends WPBakeryShortCode {}
// Pricing table shortcode
vc_map( array(
		"name" => "Pricing Table",
		"base" => "qode_pricing_table",
		"icon" => "icon-wpb-pricing_column",
		"category" => 'by SELECT',
		"allowed_container_element" => 'vc_row',
        "as_child" => array('only' => 'qode_pricing_tables'), // Use only|except attributes to limit parent (separate multiple values with comma)
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title",
				"param_name" => "title",
				"value" => "Basic Plan",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Color",
				"param_name" => "title_color",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Background Color",
				"param_name" => "title_background_color",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Price",
				"param_name" => "price",
				"description" => "Default value is 100"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Price Font Weight",
				"param_name" => "price_font_weight",
				"value" => $font_weight_array,
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Currency",
				"param_name" => "currency",
				"description" => "Default mark is $"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Price Period",
				"param_name" => "price_period",
				"description" => "Default label is monthly"
			),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Button Text",
                "param_name" => "button_text",
                "description" => ""
            ),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Button Link",
				"param_name" => "link",
				"dependency" => array('element' => 'button_text', 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Button Target",
				"param_name" => "target",
				"value" => array(
					"" => "",
					"Self" => "_self",
					"Blank" => "_blank"
				),
				"dependency" => array('element' => 'link', 'not_empty' => true)
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Button Color",
				"param_name" => "button_color",
				"dependency" => array('element' => 'button_text', 'not_empty' => true)
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Button Background Color",
				"param_name" => "button_background_color",
				"dependency" => array('element' => 'button_text', 'not_empty' => true)
			),
			array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => "Content Background Color",
                "param_name" => "content_background_color",
                "description" => ""
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Active",
				"param_name" => "active",
				"value" => array(
					"No" => "no",
					"Yes" => "yes"	
				),
				"description" => ""
			),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Active text",
                "param_name" => "active_text",
                "description" => "Best choice",
                "dependency" => array('element' => 'active', 'value' => 'yes')
            ),
            array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Active Text Color",
				"param_name" => "active_text_color",
				"dependency" => array('element' => 'active', 'value' => 'yes')
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Active Text Background Color",
				"param_name" => "active_text_background_color",
				"dependency" => array('element' => 'active', 'value' => 'yes')
			),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => "Content",
				"param_name" => "content",
				"value" => "<li>content content content</li><li>content content content</li><li>content content content</li>",
				"description" => ""
			)
		)
) );

class WPBakeryShortCode_Animated_Icons_With_Text  extends WPBakeryShortCodesContainer {}
//Register "container" content element. It will hold all your inner (child) content elements
vc_map( array(
        "name" => "Animated Icons With Text", "qode",
        "base" => "animated_icons_with_text",
        "as_parent" => array('only' => 'animated_icon_with_text'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
        "content_element" => true,
		"category" => 'by SELECT',
		"icon" => "icon-wpb-animated_icons_with_text",
        "show_settings_on_create" => true,
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Columns",
                "param_name" => "columns",
                "value" => array(
                    "Two"       => "two_columns",
                    "Three"     => "three_columns",
                    "Four"      => "four_columns",
                    "Five"      => "five_columns"
                ),
                "description" => ""
            )
        ),
        "js_view" => 'VcColumnView'
) );

class WPBakeryShortCode_Animated_Icon_With_Text extends WPBakeryShortCode {}
vc_map( array(
        "name" => "Animated Icon With Text", "qode",
        "base" => "animated_icon_with_text",
		"icon" => "icon-wpb-animated_icon_with_text",
        "content_element" => true,
        "as_child" => array('only' => 'animated_icons_with_text'), // Use only|except attributes to limit parent (separate multiple values with comma)
        "params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title",
				"param_name" => "title",
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Title Tag",
				"param_name" => "title_tag",
				"value" => array(
                    ""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"description" => ""
            ),
			array(
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => "Text",
				"param_name" => "text",
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon Pack",
				"param_name" => "icon_pack",
				"value" => array(
					"No Icon" => "",
					"Font Awesome" => "font_awesome",
					"Font Elegant" => "font_elegant"
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "fa_icon",
				"value" => $fa_icons,
				"description" => "",
				"dependency" => Array('element' => "icon_pack", 'value' => array('font_awesome'))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "fe_icon",
				"value" => $fe_icons,
				"description" => "",
				"dependency" => Array('element' => "icon_pack", 'value' => array('font_elegant'))
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Icon Size",
				"param_name" => "size",
				"description" => "Put number in px, ex.25"
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Icon Color",
				"param_name" => "icon_color",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Icon Background Color",
				"param_name" => "icon_background_color",
				"description" =>""
			),
            array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Border Color",
				"param_name" => "border_color",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Icon Color On Hover",
				"param_name" => "icon_color_hover",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Icon Background Color On Hover",
				"param_name" => "icon_background_color_hover",
				"description" =>""
			),
            array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Border Color On Hover",
				"param_name" => "border_color_hover",
				"description" => ""
			)
        )
) );

class WPBakeryShortCode_Qode_Circles  extends WPBakeryShortCodesContainer {}
//Register "container" content element. It will hold all your inner (child) content elements
vc_map( array(
        "name" => "Select Process Holder", "qode",
        "base" => "qode_circles",
        "as_parent" => array('only' => 'qode_circle'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
        "content_element" => true,
		"category" => 'by SELECT',
		"icon" => "icon-wpb-qode_circles",
        "show_settings_on_create" => true,
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Columns",
                "param_name" => "columns",
                "value" => array(
                    "Three"     => "three_columns",
                    "Four"      => "four_columns",
                    "Five"      => "five_columns"
                ),
                "description" => ""
            ),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Lines Between Items?",
				"param_name" => "lines_between",
				"description" => "",
				"value" => array(
					"Default"     => "",
					"No"      => "no",
					"Yes"      => "yes"
				),
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Line Color",
				"param_name" => "line_color",
				"description" => ""
			)
        ),
        "js_view" => 'VcColumnView'
) );

class WPBakeryShortCode_Qode_Circle extends WPBakeryShortCode {}
vc_map( array(
        "name" => "Select Process", "qode",
        "base" => "qode_circle",
        "content_element" => true,
		"icon" => "icon-wpb-qode_circle",
        "as_child" => array('only' => 'qode_circles'), // Use only|except attributes to limit parent (separate multiple values with comma)
        "params" => array(
        	array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Type",
				"param_name" => "type",
				"value" => array(
					"Icon in Process" => "icon_type",
					"Image" => "image_type",	
					"Text in Process" => "text_type"
				)
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Background Process Color",
				"param_name" => "background_color",
				"description" => ""
			),
			array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Background Process Transparency",
                "param_name" => "background_transparency",
                "description" => "Insert value between 0 and 1"
            ),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => "",
				"value" => array("Without outer border?" => "yes"),
				"param_name" => "without_double_border",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Border Process Color",
				"param_name" => "border_color",
				"description" => ""
			),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Border Process Width",
                "param_name" => "border_width",
                "description" => ""
            ),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon Pack",
				"param_name" => "icon_pack",
				"value" => array(
					"Font Awesome" => "font_awesome",
					"Font Elegant" => "font_elegant"
				),
				"description" => "",
				"dependency" => array('element' => "type", 'value' => array("icon_type"))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "fa_icon",
				"value" => $fa_icons,
				"dependency" => array('element' => "icon_pack", 'value' => array("font_awesome"))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "fe_icon",
				"value" => $fe_icons,
				"dependency" => array('element' => "icon_pack", 'value' => array("font_elegant"))
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Size",
				"param_name" => "size",
				"description" => "Enter just number. Omit px",
				"dependency" => array('element' => "type", 'value' => array("icon_type"))
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Icon Color",
				"param_name" => "icon_color",
				"dependency" => array('element' => "type", 'value' => array("icon_type"))
			),
            array(
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => "Image",
                "param_name" => "image",
                "dependency" => array('element' => "type", 'value' => array("image_type"))
            ),
            array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Text in Process",
				"param_name" => "text_in_circle",
				"dependency" => array('element' => "type", 'value' => array("text_type"))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Text in Process Tag",
				"param_name" => "text_in_circle_tag",
				"value" => array(
                    ""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"description" => "",
				"dependency" => array('element' => "text_in_circle", 'not_empty' => true)
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Text in Process Size (px)",
                "param_name" => "font_size",
                "dependency" => array('element' => "text_in_circle", 'not_empty' => true)
            ),
            array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Text in Process Color",
				"param_name" => "text_in_circle_color",
				"description" => "",
				"dependency" => array('element' => "text_in_circle", 'not_empty' => true)
			),
			array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => "Link",
                "param_name" => "link",
                "description" => ""
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => "Link Target",
                "param_name" => "link_target",
                "value" => array(
                    "" => "",
                    "Self" => "_self",
                    "Blank" => "_blank"
                ),
                "description" => "",
                "dependency" => array('element' => "link", 'not_empty' => true)
            ),
            array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title",
				"param_name" => "title",
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Title Tag",
				"param_name" => "title_tag",
				"value" => array(
                    ""   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"description" => "",
				"dependency" => array('element' => "title", 'not_empty' => true)
            ),
            array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Title Color",
				"param_name" => "title_color",
				"description" => "",
				"dependency" => array('element' => "title", 'not_empty' => true)
			),
			array(
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => "Text",
				"param_name" => "text",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => "Text Color",
				"param_name" => "text_color",
				"description" => "",
				"dependency" => array('element' => "text", 'not_empty' => true)
			)
        )
) );

/***************** Woocommerce Shortcodes *********************/

if(function_exists("is_woocommerce")){

/**** Order Tracking ***/

vc_map( array(
		"name" => "Order Tracking",
		"base" => "woocommerce_order_tracking",
		"icon" => "icon-wpb-woocommerce_order_tracking",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		 "show_settings_on_create" => false
));

/*** Product price/cart button ***/
	
vc_map( array(
		"name" => "Product price/cart button",
		"base" => "add_to_cart",
		"icon" => "icon-wpb-add_to_cart",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "ID",
				"param_name" => "id",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "SKU",
				"param_name" => "sku",
				"description" => ""
			)
		)
) );

/*** Product by SKU/ID ***/
	
vc_map( array(
		"name" => "Product by SKU/ID",
		"base" => "product",
		"icon" => "icon-wpb-product",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "ID",
				"param_name" => "id",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "SKU",
				"param_name" => "sku",
				"description" => ""
			)
		)
) );


/*** Products by SKU/ID ***/
	
vc_map( array(
		"name" => "Products by SKU/ID",
		"base" => "products",
		"icon" => "icon-wpb-products",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "IDS",
				"param_name" => "ids",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "SKUS",
				"param_name" => "skus",
				"description" => ""
			)
		)
) );

/*** Product categories ***/
	
vc_map( array(
		"name" => "Product categories",
		"base" => "product_categories",
		"icon" => "icon-wpb-product_categories",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Number",
				"param_name" => "number",
				"description" => ""
			)
		)
) );

/*** Products by category slug ***/
	
vc_map( array(
		"name" => "Products by category slug",
		"base" => "product_category",
		"icon" => "icon-wpb-product_category",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Category",
				"param_name" => "category",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Per Page",
				"param_name" => "per_page",
				"value" => "12"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Columns",
				"param_name" => "columns",
				"value" => "4"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order By",
				"param_name" => "order_by",
				"value" => array(
					"Date" => "date",
					"Title" => "title",
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order",
				"param_name" => "order",
				"value" => array(
					"DESC" => "desc",
					"ASC" => "asc"
				),
				"description" => ""
			)
		)
) );

/*** Recent products ***/
	
vc_map( array(
		"name" => "Recent products",
		"base" => "recent_products",
		"icon" => "icon-wpb-recent_products",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Per Page",
				"param_name" => "per_page",
				"value" => "12"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Columns",
				"param_name" => "columns",
				"value" => "4"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order By",
				"param_name" => "order_by",
				"value" => array(
					"Date" => "date",
					"Title" => "title",
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order",
				"param_name" => "order",
				"value" => array(
					"DESC" => "desc",
					"ASC" => "asc"
				),
				"description" => ""
			),
		)
) );

/*** Featured products ***/
	
vc_map( array(
		"name" => "Featured products",
		"base" => "featured_products",
		"icon" => "icon-wpb-featured_products",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Per Page",
				"param_name" => "per_page",
				"value" => "12"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Columns",
				"param_name" => "columns",
				"value" => "4"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order By",
				"param_name" => "order_by",
				"value" => array(
					"Date" => "date",
					"Title" => "title",
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Order",
				"param_name" => "order",
				"value" => array(
					"DESC" => "desc",
					"ASC" => "asc"
				),
				"description" => ""
			),
		)
) );

/**** Shop Messages ***/

vc_map( array(
		"name" => "Shop Messages",
		"base" => "woocommerce_messages",
		"icon" => "icon-wpb-woocommerce_messages",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		 "show_settings_on_create" => false
));

/**** Cart ***/

vc_map( array(
		"name" => "Pages - Cart",
		"base" => "woocommerce_cart",
		"icon" => "icon-wpb-woocommerce_cart",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		 "show_settings_on_create" => false
));

/**** Checkout ***/

vc_map( array(
		"name" => "Pages - Checkout",
		"base" => "woocommerce_checkout",
		"icon" => "icon-wpb-woocommerce_checkout",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		 "show_settings_on_create" => false
));

/**** My Account ***/

vc_map( array(
		"name" => "Pages - My Account",
		"base" => "woocommerce_my_account",
		"icon" => "icon-wpb-woocommerce_my_account",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		 "show_settings_on_create" => false
));

/**** Edit Address ***/

vc_map( array(
		"name" => "Pages - Edit Address",
		"base" => "woocommerce_edit_address",
		"icon" => "icon-wpb-woocommerce_edit_address",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		 "show_settings_on_create" => false
));

/**** Change Password ***/

vc_map( array(
		"name" => "Pages - Change Password",
		"base" => "woocommerce_change_password",
		"icon" => "icon-wpb-woocommerce_change_password",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		 "show_settings_on_create" => false
));

/**** View Order ***/

vc_map( array(
		"name" => "Pages - View Order",
		"base" => "woocommerce_view_order",
		"icon" => "icon-wpb-woocommerce_view_order",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		 "show_settings_on_create" => false
));

/**** Pay ***/

vc_map( array(
		"name" => "Pages - Pay",
		"base" => "woocommerce_pay",
		"icon" => "icon-wpb-woocommerce_pay",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		 "show_settings_on_create" => false
));

/**** Thankyou ***/

vc_map( array(
		"name" => "Pages - Thankyou",
		"base" => "woocommerce_thankyou",
		"icon" => "icon-wpb-woocommerce_thankyou",
		"category" => 'Woocommerce',
		"allowed_container_element" => 'vc_row',
		 "show_settings_on_create" => false
));

}
?>