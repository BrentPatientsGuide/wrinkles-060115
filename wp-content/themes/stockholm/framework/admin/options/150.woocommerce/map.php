<?php

$woocommercePage = new QodeAdminPage("16", "WooCommerce");
$qodeFramework->qodeOptions->addAdminPage("woocommerce",$woocommercePage);

// General
$panel3 = new QodePanel("General","general_panel");
$woocommercePage->addChild("panel3",$panel3);

	$group1 = new QodeGroup("Input Fields Style","Define styles for Input Fields");
	$panel3->addChild("group1",$group1);
		$row1 = new QodeRow();
		$group1->addChild("row1",$row1);

			$woo_input_text_color = new QodeField("colorsimple","woo_input_text_color","","Text Color","This is some description");
			$row1->addChild("woo_input_text_color",$woo_input_text_color);		

			$woo_input_focus_text_color = new QodeField("colorsimple","woo_input_focus_text_color","","Focus Text Color","This is some description");
			$row1->addChild("woo_input_focus_text_color",$woo_input_focus_text_color);

			$woo_input_background_color = new QodeField("colorsimple","woo_input_background_color","","Background Color","This is some description");
			$row1->addChild("woo_input_background_color",$woo_input_background_color);

			$woo_input_focus_background_color = new QodeField("colorsimple","woo_input_focus_background_color","","Focus Background Color","This is some description");
			$row1->addChild("woo_input_focus_background_color",$woo_input_focus_background_color);

		$row2 = new QodeRow(true);
		$group1->addChild("row2",$row2);

			$woo_input_border_color = new QodeField("colorsimple","woo_input_border_color","","Border Color","This is some description");
			$row2->addChild("woo_input_border_color",$woo_input_border_color);

			$woo_input_focus_border_color = new QodeField("colorsimple","woo_input_focus_border_color","","Focus Border Color","This is some description");
			$row2->addChild("woo_input_focus_border_color",$woo_input_focus_border_color);

			$woo_input_border_width = new QodeField("textsimple","woo_input_border_width","","Border Width (px)","This is some description");
			$row2->addChild("woo_input_border_width",$woo_input_border_width);

	//Button

	$group8 = new QodeGroup("Button Style","Define button styles for all shop pages");
	$panel3->addChild("group8",$group8);	

		$row1 = new QodeRow();
		$group8->addChild("row1",$row1);	

			$woo_products_list_add_to_cart_color = new QodeField("colorsimple","woo_products_list_add_to_cart_color","","Text Color","This is some description");
			$row1->addChild("woo_products_list_add_to_cart_color",$woo_products_list_add_to_cart_color);

			$woo_products_list_add_to_cart_font_size = new QodeField("textsimple","woo_products_list_add_to_cart_font_size","","Font Size (px)","This is some description");
			$row1->addChild("woo_products_list_add_to_cart_font_size",$woo_products_list_add_to_cart_font_size);

			$woo_products_list_add_to_cart_line_height = new QodeField("textsimple","woo_products_list_add_to_cart_line_height","","Line Height (px)","This is some description");
			$row1->addChild("woo_products_list_add_to_cart_line_height",$woo_products_list_add_to_cart_line_height);

			$woo_products_list_add_to_cart_text_transform = new QodeField("selectblanksimple","woo_products_list_add_to_cart_text_transform","","Text Transform","This is some description",$options_texttransform);
			$row1->addChild("woo_products_list_add_to_cart_text_transform",$woo_products_list_add_to_cart_text_transform);

		$row2 = new QodeRow(true);
		$group8->addChild("row2",$row2);

			$woo_products_list_add_to_cart_font_family = new QodeField("Fontsimple","woo_products_list_add_to_cart_font_family","-1","Font Family","This is some description");
			$row2->addChild("woo_products_list_add_to_cart_font_family",$woo_products_list_add_to_cart_font_family);

			$woo_products_list_add_to_cart_font_style = new QodeField("selectblanksimple","woo_products_list_add_to_cart_font_style","","Font Style","This is some description",$options_fontstyle);
			$row2->addChild("woo_products_list_add_to_cart_font_style",$woo_products_list_add_to_cart_font_style);

			$woo_products_list_add_to_cart_font_weight = new QodeField("selectblanksimple","woo_products_list_add_to_cart_font_weight","","Font Weight","This is some description",$options_fontweight);
			$row2->addChild("woo_products_list_add_to_cart_font_weight",$woo_products_list_add_to_cart_font_weight);

			$woo_products_list_add_to_cart_letter_spacing = new QodeField("textsimple","woo_products_list_add_to_cart_letter_spacing","","Letter Spacing (px)","This is some description");
			$row2->addChild("woo_products_list_add_to_cart_letter_spacing",$woo_products_list_add_to_cart_letter_spacing);
		
		$row3 = new QodeRow(true);
		$group8->addChild("row3",$row3);
		
			$woo_products_list_add_to_cart_hover_color = new QodeField("colorsimple","woo_products_list_add_to_cart_hover_color","","Hover Color","This is some description");
			$row3->addChild("woo_products_list_add_to_cart_hover_color",$woo_products_list_add_to_cart_hover_color);

			$woo_products_list_add_to_cart_background_color = new QodeField("colorsimple","woo_products_list_add_to_cart_background_color","","Background Color","This is some description");
			$row3->addChild("woo_products_list_add_to_cart_background_color",$woo_products_list_add_to_cart_background_color);

			$woo_products_list_add_to_cart_background_hover_color = new QodeField("colorsimple","woo_products_list_add_to_cart_background_hover_color","","Hover Background Color","This is some description");
			$row3->addChild("woo_products_list_add_to_cart_background_hover_color",$woo_products_list_add_to_cart_background_hover_color);										
		
		$row4 = new QodeRow(true);
		$group8->addChild("row4",$row4);

			$woo_products_list_add_to_cart_border_color = new QodeField("colorsimple","woo_products_list_add_to_cart_border_color","","Border Color","This is some description");
			$row4->addChild("woo_products_list_add_to_cart_border_color",$woo_products_list_add_to_cart_border_color);

			$woo_products_list_add_to_cart_border_hover_color = new QodeField("colorsimple","woo_products_list_add_to_cart_border_hover_color","","Border Hover Color","This is some description");
			$row4->addChild("woo_products_list_add_to_cart_border_hover_color",$woo_products_list_add_to_cart_border_hover_color);	

			$woo_products_list_add_to_cart_border_width = new QodeField("textsimple","woo_products_list_add_to_cart_border_width","","Border Width (px)","This is some description");
			$row4->addChild("woo_products_list_add_to_cart_border_width",$woo_products_list_add_to_cart_border_width);

			$woo_products_list_add_to_cart_border_radius = new QodeField("textsimple","woo_products_list_add_to_cart_border_radius","","Border radius (px)","This is some description");
			$row4->addChild("woo_products_list_add_to_cart_border_radius",$woo_products_list_add_to_cart_border_radius);

//Product list styles

$panel1 = new QodePanel("Product List","product_list_panel");
$woocommercePage->addChild("panel1",$panel1);
	
	//Product per page

	$woo_products_per_page = new QodeField("text","woo_products_per_page","","Number Of Product Per Page", "Set number of products on shop page.");
	$panel1->addChild("woo_products_per_page",$woo_products_per_page);	

	//Product box

	$group1 = new QodeGroup("Product Box Style","Define Product Box Style");
	$panel1->addChild("group1",$group1);			

		$woo_products_disable_box = new QodeField("yesno","woo_products_disable_box","no","Disable Text Box","Enabling this option will disable box around products text.", array(), array("dependence" => true, "dependence_hide_on_yes" => "#qodef_woo_products_disable_box_container", "dependence_show_on_yes" => ""));
		$group1->addChild("woo_products_disable_box",$woo_products_disable_box);

			$woo_products_disable_box_container = new QodeContainer("woo_products_disable_box_container","woo_products_disable_box","yes");
			$group1->addChild("woo_products_disable_box_container",$woo_products_disable_box_container);

				$woo_products_box_background_color = new QodeField("color","woo_products_box_background_color","","Background Color","This is some description");
				$woo_products_disable_box_container->addChild("woo_products_box_background_color",$woo_products_box_background_color);

		$woo_products_box_text_align = new QodeField("select","woo_products_box_text_align","left","Products Text Align","Specify Products text alignment", array( 
			"left" => "Left",
			"center" => "Center",
			"right" => "Right"
			     ));
		$group1->addChild("woo_products_box_text_align",$woo_products_box_text_align);	

		$woo_products_box_border_color = new QodeField("color","woo_products_box_border_color","","Border Color","This is some description");
		$group1->addChild("woo_products_box_border_color",$woo_products_box_border_color);

	//Product category

	$group2 = new QodeGroup("Product Category Style","Define Product Category Style");
	$panel1->addChild("group2",$group2);			

		$woo_products_category_hide_category = new QodeField("yesno","woo_products_category_hide_category","no","Disable Product Category","Enabling this option will hide product category.", array(), array("dependence" => true, "dependence_hide_on_yes" => "#qodef_woo_products_hide_category_container", "dependence_show_on_yes" => ""));
		$group2->addChild("woo_products_category_hide_category",$woo_products_category_hide_category);

			$woo_products_hide_category_container = new QodeContainer("woo_products_hide_category_container","woo_products_category_hide_category","yes");
			$group2->addChild("woo_products_hide_category_container",$woo_products_hide_category_container);

				$row1 = new QodeRow(true);
				$group2->addChild("row1",$row1);		

					$woo_products_category_color = new QodeField("colorsimple","woo_products_category_color","","Text Color","This is some description");
					$row1->addChild("woo_products_category_color",$woo_products_category_color);

					$woo_products_category_font_size = new QodeField("textsimple","woo_products_category_font_size","","Font Size (px)","This is some description");
					$row1->addChild("woo_products_category_font_size",$woo_products_category_font_size);

					$woo_products_category_line_height = new QodeField("textsimple","woo_products_category_line_height","","Line Height (px)","This is some description");
					$row1->addChild("woo_products_category_line_height",$woo_products_category_line_height);

					$woo_products_category_text_transform = new QodeField("selectblanksimple","woo_products_category_text_transform","","Text Transform","This is some description",$options_texttransform);
					$row1->addChild("woo_products_category_text_transform",$woo_products_category_text_transform);

				$row2 = new QodeRow(true);
				$group2->addChild("row2",$row2);	

					$woo_products_category_font_family = new QodeField("Fontsimple","woo_products_category_font_family","-1","Font Family","This is some description");
					$row2->addChild("woo_products_category_font_family",$woo_products_category_font_family);

					$woo_products_category_font_style = new QodeField("selectblanksimple","woo_products_category_font_style","","Font Style","This is some description",$options_fontstyle);
					$row2->addChild("woo_products_category_font_style",$woo_products_category_font_style);

					$woo_products_category_font_weight = new QodeField("selectblanksimple","woo_products_category_font_weight","","Font Weight","This is some description",$options_fontweight);
					$row2->addChild("woo_products_category_font_weight",$woo_products_category_font_weight);

					$woo_products_category_letter_spacing = new QodeField("textsimple","woo_products_category_letter_spacing","","Letter Spacing (px)","This is some description");
					$row2->addChild("woo_products_category_letter_spacing",$woo_products_category_letter_spacing);	

	//Product title

	$group3 = new QodeGroup("Product Title Style","Define Product Title Style");
	$panel1->addChild("group3",$group3);	

		$row1 = new QodeRow();
		$group3->addChild("row1",$row1);	

			$woo_products_title_color = new QodeField("colorsimple","woo_products_title_color","","Text Color","This is some description");
			$row1->addChild("woo_products_title_color",$woo_products_title_color);

			$woo_products_title_font_size = new QodeField("textsimple","woo_products_title_font_size","","Font Size (px)","This is some description");
			$row1->addChild("woo_products_title_font_size",$woo_products_title_font_size);

			$woo_products_title_line_height = new QodeField("textsimple","woo_products_title_line_height","","Line Height (px)","This is some description");
			$row1->addChild("woo_products_title_line_height",$woo_products_title_line_height);

			$woo_products_title_text_transform = new QodeField("selectblanksimple","woo_products_title_text_transform","","Text Transform","This is some description",$options_texttransform);
			$row1->addChild("woo_products_title_text_transform",$woo_products_title_text_transform);

		$row2 = new QodeRow(true);
		$group3->addChild("row2",$row2);

			$woo_products_title_font_family = new QodeField("Fontsimple","woo_products_title_font_family","-1","Font Family","This is some description");
			$row2->addChild("woo_products_title_font_family",$woo_products_title_font_family);

			$woo_products_title_font_style = new QodeField("selectblanksimple","woo_products_title_font_style","","Font Style","This is some description",$options_fontstyle);
			$row2->addChild("woo_products_title_font_style",$woo_products_title_font_style);

			$woo_products_title_font_weight = new QodeField("selectblanksimple","woo_products_title_font_weight","","Font Weight","This is some description",$options_fontweight);
			$row2->addChild("woo_products_title_font_weight",$woo_products_title_font_weight);

			$woo_products_title_letter_spacing = new QodeField("textsimple","woo_products_title_letter_spacing","","Letter Spacing (px)","This is some description");
			$row2->addChild("woo_products_title_letter_spacing",$woo_products_title_letter_spacing);

		$row3 = new QodeRow(true);
		$group3->addChild("row3",$row3);

			$woo_products_title_hover_color = new QodeField("colorsimple","woo_products_title_hover_color","","Hover Color","This is some description");
			$row3->addChild("woo_products_title_hover_color",$woo_products_title_hover_color);

	//Product price	

	$group4 = new QodeGroup("Product Price Style","Define Product Price Style");
	$panel1->addChild("group4",$group4);	

		$row1 = new QodeRow();
		$group4->addChild("row1",$row1);	

			$woo_products_price_color = new QodeField("colorsimple","woo_products_price_color","","Text Color","This is some description");
			$row1->addChild("woo_products_price_color",$woo_products_price_color);

			$woo_products_price_font_size = new QodeField("textsimple","woo_products_price_font_size","","Font Size (px)","This is some description");
			$row1->addChild("woo_products_price_font_size",$woo_products_price_font_size);

			$woo_products_price_line_height = new QodeField("textsimple","woo_products_price_line_height","","Line Height (px)","This is some description");
			$row1->addChild("woo_products_price_line_height",$woo_products_price_line_height);

			$woo_products_price_text_transform = new QodeField("selectblanksimple","woo_products_price_text_transform","","Text Transform","This is some description",$options_texttransform);
			$row1->addChild("woo_products_price_text_transform",$woo_products_price_text_transform);

		$row2 = new QodeRow(true);
		$group4->addChild("row2",$row2);

			$woo_products_price_font_family = new QodeField("Fontsimple","woo_products_price_font_family","-1","Font Family","This is some description");
			$row2->addChild("woo_products_price_font_family",$woo_products_price_font_family);

			$woo_products_price_font_style = new QodeField("selectblanksimple","woo_products_price_font_style","","Font Style","This is some description",$options_fontstyle);
			$row2->addChild("woo_products_price_font_style",$woo_products_price_font_style);

			$woo_products_price_font_weight = new QodeField("selectblanksimple","woo_products_price_font_weight","","Font Weight","This is some description",$options_fontweight);
			$row2->addChild("woo_products_price_font_weight",$woo_products_price_font_weight);

			$woo_products_price_letter_spacing = new QodeField("textsimple","woo_products_price_letter_spacing","","Letter Spacing (px)","This is some description");
			$row2->addChild("woo_products_price_letter_spacing",$woo_products_price_letter_spacing);

		$row3 = new QodeRow(true);
		$group4->addChild("row3",$row3);	

			$woo_products_price_old_color = new QodeField("colorsimple","woo_products_price_old_color","","Old Color","This is some description");
			$row3->addChild("woo_products_price_old_color",$woo_products_price_old_color);

	//Product sale

	$group5 = new QodeGroup("Product Sale Style","Define Product Sale Style");
	$panel1->addChild("group5",$group5);	

		$row1 = new QodeRow();
		$group5->addChild("row1",$row1);	

			$woo_products_sale_color = new QodeField("colorsimple","woo_products_sale_color","","Text Color","This is some description");
			$row1->addChild("woo_products_sale_color",$woo_products_sale_color);

			$woo_products_sale_font_size = new QodeField("textsimple","woo_products_sale_font_size","","Font Size (px)","This is some description");
			$row1->addChild("woo_products_sale_font_size",$woo_products_sale_font_size);

			$woo_products_sale_line_height = new QodeField("textsimple","woo_products_sale_line_height","","Line Height (px)","This is some description");
			$row1->addChild("woo_products_sale_line_height",$woo_products_sale_line_height);

			$woo_products_sale_text_transform = new QodeField("selectblanksimple","woo_products_sale_text_transform","","Text Transform","This is some description",$options_texttransform);
			$row1->addChild("woo_products_sale_text_transform",$woo_products_sale_text_transform);

		$row2 = new QodeRow(true);
		$group5->addChild("row2",$row2);

			$woo_products_sale_font_family = new QodeField("Fontsimple","woo_products_sale_font_family","-1","Font Family","This is some description");
			$row2->addChild("woo_products_sale_font_family",$woo_products_sale_font_family);

			$woo_products_sale_font_style = new QodeField("selectblanksimple","woo_products_sale_font_style","","Font Style","This is some description",$options_fontstyle);
			$row2->addChild("woo_products_sale_font_style",$woo_products_sale_font_style);

			$woo_products_sale_font_weight = new QodeField("selectblanksimple","woo_products_sale_font_weight","","Font Weight","This is some description",$options_fontweight);
			$row2->addChild("woo_products_sale_font_weight",$woo_products_sale_font_weight);

			$woo_products_sale_letter_spacing = new QodeField("textsimple","woo_products_sale_letter_spacing","","Letter Spacing (px)","This is some description");
			$row2->addChild("woo_products_sale_letter_spacing",$woo_products_sale_letter_spacing);
		
		$row3 = new QodeRow(true);
		$group5->addChild("row3",$row3);
		
			$woo_products_sale_background_color = new QodeField("colorsimple","woo_products_sale_background_color","","Background Color","This is some description");
			$row3->addChild("woo_products_sale_background_color",$woo_products_sale_background_color);

	//Product out of stock

	$group6 = new QodeGroup("Product Out Of Stock Style","Define Out Of Stock Product Style");
	$panel1->addChild("group6",$group6);	

		$row1 = new QodeRow();
		$group6->addChild("row1",$row1);	

			$woo_products_out_of_stock_color = new QodeField("colorsimple","woo_products_out_of_stock_color","","Text Color","This is some description");
			$row1->addChild("woo_products_out_of_stock_color",$woo_products_out_of_stock_color);

			$woo_products_out_of_stock_font_size = new QodeField("textsimple","woo_products_out_of_stock_font_size","","Font Size (px)","This is some description");
			$row1->addChild("woo_products_out_of_stock_font_size",$woo_products_out_of_stock_font_size);

			$woo_products_out_of_stock_line_height = new QodeField("textsimple","woo_products_out_of_stock_line_height","","Line Height (px)","This is some description");
			$row1->addChild("woo_products_out_of_stock_line_height",$woo_products_out_of_stock_line_height);

			$woo_products_out_of_stock_text_transform = new QodeField("selectblanksimple","woo_products_out_of_stock_text_transform","","Text Transform","This is some description",$options_texttransform);
			$row1->addChild("woo_products_out_of_stock_text_transform",$woo_products_out_of_stock_text_transform);

		$row2 = new QodeRow(true);
		$group6->addChild("row2",$row2);

			$woo_products_out_of_stock_font_family = new QodeField("Fontsimple","woo_products_out_of_stock_font_family","-1","Font Family","This is some description");
			$row2->addChild("woo_products_out_of_stock_font_family",$woo_products_out_of_stock_font_family);

			$woo_products_out_of_stock_font_style = new QodeField("selectblanksimple","woo_products_out_of_stock_font_style","","Font Style","This is some description",$options_fontstyle);
			$row2->addChild("woo_products_out_of_stock_font_style",$woo_products_out_of_stock_font_style);

			$woo_products_out_of_stock_font_weight = new QodeField("selectblanksimple","woo_products_out_of_stock_font_weight","","Font Weight","This is some description",$options_fontweight);
			$row2->addChild("woo_products_out_of_stock_font_weight",$woo_products_out_of_stock_font_weight);

			$woo_products_out_of_stock_letter_spacing = new QodeField("textsimple","woo_products_out_of_stock_letter_spacing","","Letter Spacing (px)","This is some description");
			$row2->addChild("woo_products_out_of_stock_letter_spacing",$woo_products_out_of_stock_letter_spacing);
		
		$row3 = new QodeRow(true);
		$group6->addChild("row3",$row3);
		
			$woo_products_out_of_stock_background_color = new QodeField("colorsimple","woo_products_out_of_stock_background_color","","Background Color","This is some description");
			$row3->addChild("woo_products_out_of_stock_background_color",$woo_products_out_of_stock_background_color);							
	
	//Sorting

	$group8 = new QodeGroup("Product Sorting Style","Define Sorting Style");
	$panel1->addChild("group8",$group8);	

		$row1 = new QodeRow();
		$group8->addChild("row1",$row1);	

			$woo_products_sorting_color = new QodeField("colorsimple","woo_products_sorting_color","","Text Color","This is some description");
			$row1->addChild("woo_products_sorting_color",$woo_products_sorting_color);

			$woo_products_sorting_hover_color = new QodeField("colorsimple","woo_products_sorting_hover_color","","Text Hover Color","This is some description");
			$row1->addChild("woo_products_sorting_hover_color",$woo_products_sorting_hover_color);

			$woo_products_sorting_background_color = new QodeField("colorsimple","woo_products_sorting_background_color","","Box Background Color","This is some description");
			$row1->addChild("woo_products_sorting_background_color",$woo_products_sorting_background_color);

			$woo_products_sorting_border_color = new QodeField("colorsimple","woo_products_sorting_border_color","","Box Border Color","This is some description");
			$row1->addChild("woo_products_sorting_border_color",$woo_products_sorting_border_color);

		$row2 = new QodeRow(true);
		$group8->addChild("row2",$row2);

			$woo_products_sorting_border_width = new QodeField("textsimple","woo_products_sorting_border_width","","Box Border Width (px)","This is some description");
			$row1->addChild("woo_products_sorting_border_width",$woo_products_sorting_border_width);	

			$woo_products_sorting_dropdown_background_color = new QodeField("colorsimple","woo_products_sorting_dropdown_background_color","","Dropdown Background Color","This is some description");
			$row1->addChild("woo_products_sorting_dropdown_background_color",$woo_products_sorting_dropdown_background_color);

	//Sorting Result

	$group7 = new QodeGroup("Product Sorting Result Style","Define Sorting Result Text Style");
	$panel1->addChild("group7",$group7);	

		$row1 = new QodeRow();
		$group7->addChild("row1",$row1);	

			$woo_products_sorting_result_color = new QodeField("colorsimple","woo_products_sorting_result_color","","Text Color","This is some description");
			$row1->addChild("woo_products_sorting_result_color",$woo_products_sorting_result_color);

			$woo_products_sorting_result_font_size = new QodeField("textsimple","woo_products_sorting_result_font_size","","Font Size (px)","This is some description");
			$row1->addChild("woo_products_sorting_result_font_size",$woo_products_sorting_result_font_size);

			$woo_products_sorting_result_line_height = new QodeField("textsimple","woo_products_sorting_result_line_height","","Line Height (px)","This is some description");
			$row1->addChild("woo_products_sorting_result_line_height",$woo_products_sorting_result_line_height);

			$woo_products_sorting_result_text_transform = new QodeField("selectblanksimple","woo_products_sorting_result_text_transform","","Text Transform","This is some description",$options_texttransform);
			$row1->addChild("woo_products_sorting_result_text_transform",$woo_products_sorting_result_text_transform);

		$row2 = new QodeRow(true);
		$group7->addChild("row2",$row2);

			$woo_products_sorting_result_font_family = new QodeField("Fontsimple","woo_products_sorting_result_font_family","-1","Font Family","This is some description");
			$row2->addChild("woo_products_sorting_result_font_family",$woo_products_sorting_result_font_family);

			$woo_products_sorting_result_font_style = new QodeField("selectblanksimple","woo_products_sorting_result_font_style","","Font Style","This is some description",$options_fontstyle);
			$row2->addChild("woo_products_sorting_result_font_style",$woo_products_sorting_result_font_style);

			$woo_products_sorting_result_font_weight = new QodeField("selectblanksimple","woo_products_sorting_result_font_weight","","Font Weight","This is some description",$options_fontweight);
			$row2->addChild("woo_products_sorting_result_font_weight",$woo_products_sorting_result_font_weight);

			$woo_products_sorting_result_letter_spacing = new QodeField("textsimple","woo_products_sorting_result_letter_spacing","","Letter Spacing (px)","This is some description");
			$row2->addChild("woo_products_sorting_result_letter_spacing",$woo_products_sorting_result_letter_spacing);

	//Pricing Filter 

	$group9 = new QodeGroup("Filter Price Style","Define Filter Price Style");
	$panel1->addChild("group9",$group9);

			$woo_products_price_filter_background_color = new QodeField("colorsimple","woo_products_price_filter_background_color","","Slider Color","This is some description");
			$group9->addChild("woo_products_price_filter_background_color",$woo_products_price_filter_background_color);

			$woo_products_price_filter_background_active_color = new QodeField("colorsimple","woo_products_price_filter_background_active_color","","Active Slider Color","This is some description");
			$group9->addChild("woo_products_price_filter_background_active_color",$woo_products_price_filter_background_active_color);		

			$woo_products_price_filter_arrows_color = new QodeField("colorsimple","woo_products_price_filter_arrows_color","","Arrows Color","This is some description");
			$group9->addChild("woo_products_price_filter_arrows_color",$woo_products_price_filter_arrows_color);	


//Product single styles

$panel2 = new QodePanel("Product Single","product_single_panel");
$woocommercePage->addChild("panel2",$panel2);	

	//Product single title

	$group1 = new QodeGroup("Product Single Title Style","Define Product Single Title Style");
	$panel2->addChild("group1",$group1);	

		$row1 = new QodeRow();
		$group1->addChild("row1",$row1);	

			$woo_product_single_title_color = new QodeField("colorsimple","woo_product_single_title_color","","Text Color","This is some description");
			$row1->addChild("woo_product_single_title_color",$woo_product_single_title_color);

			$woo_product_single_title_font_size = new QodeField("textsimple","woo_product_single_title_font_size","","Font Size (px)","This is some description");
			$row1->addChild("woo_product_single_title_font_size",$woo_product_single_title_font_size);

			$woo_product_single_title_line_height = new QodeField("textsimple","woo_product_single_title_line_height","","Line Height (px)","This is some description");
			$row1->addChild("woo_product_single_title_line_height",$woo_product_single_title_line_height);

			$woo_product_single_title_text_transform = new QodeField("selectblanksimple","woo_product_single_title_text_transform","","Text Transform","This is some description",$options_texttransform);
			$row1->addChild("woo_product_single_title_text_transform",$woo_product_single_title_text_transform);

		$row2 = new QodeRow(true);
		$group1->addChild("row2",$row2);

			$woo_product_single_title_font_family = new QodeField("Fontsimple","woo_product_single_title_font_family","-1","Font Family","This is some description");
			$row2->addChild("woo_product_single_title_font_family",$woo_product_single_title_font_family);

			$woo_product_single_title_font_style = new QodeField("selectblanksimple","woo_product_single_title_font_style","","Font Style","This is some description",$options_fontstyle);
			$row2->addChild("woo_product_single_title_font_style",$woo_product_single_title_font_style);

			$woo_product_single_title_font_weight = new QodeField("selectblanksimple","woo_product_single_title_font_weight","","Font Weight","This is some description",$options_fontweight);
			$row2->addChild("woo_product_single_title_font_weight",$woo_product_single_title_font_weight);

			$woo_product_single_title_letter_spacing = new QodeField("textsimple","woo_product_single_title_letter_spacing","","Letter Spacing (px)","This is some description");
			$row2->addChild("woo_product_single_title_letter_spacing",$woo_product_single_title_letter_spacing);

		$row3 = new QodeRow(true);
		$group1->addChild("row3",$row3);

			$woo_product_single_title_hover_color = new QodeField("colorsimple","woo_product_single_title_hover_color","","Hover Color","This is some description");
			$row3->addChild("woo_product_single_title_hover_color",$woo_product_single_title_hover_color);	

	//Product single meta title

	$group2 = new QodeGroup("Product Single Meta Title Style","Define Product Single Meta Title Style");
	$panel2->addChild("group2",$group2);	

		$row1 = new QodeRow();
		$group2->addChild("row1",$row1);	

			$woo_product_single_meta_title_color = new QodeField("colorsimple","woo_product_single_meta_title_color","","Text Color","This is some description");
			$row1->addChild("woo_product_single_meta_title_color",$woo_product_single_meta_title_color);

			$woo_product_single_meta_title_font_size = new QodeField("textsimple","woo_product_single_meta_title_font_size","","Font Size (px)","This is some description");
			$row1->addChild("woo_product_single_meta_title_font_size",$woo_product_single_meta_title_font_size);

			$woo_product_single_meta_title_line_height = new QodeField("textsimple","woo_product_single_meta_title_line_height","","Line Height (px)","This is some description");
			$row1->addChild("woo_product_single_meta_title_line_height",$woo_product_single_meta_title_line_height);

			$woo_product_single_meta_title_text_transform = new QodeField("selectblanksimple","woo_product_single_meta_title_text_transform","","Text Transform","This is some description",$options_texttransform);
			$row1->addChild("woo_product_single_meta_title_text_transform",$woo_product_single_meta_title_text_transform);

		$row2 = new QodeRow(true);
		$group2->addChild("row2",$row2);

			$woo_product_single_meta_title_font_family = new QodeField("Fontsimple","woo_product_single_meta_title_font_family","-1","Font Family","This is some description");
			$row2->addChild("woo_product_single_meta_title_font_family",$woo_product_single_meta_title_font_family);

			$woo_product_single_meta_title_font_style = new QodeField("selectblanksimple","woo_product_single_meta_title_font_style","","Font Style","This is some description",$options_fontstyle);
			$row2->addChild("woo_product_single_meta_title_font_style",$woo_product_single_meta_title_font_style);

			$woo_product_single_meta_title_font_weight = new QodeField("selectblanksimple","woo_product_single_meta_title_font_weight","","Font Weight","This is some description",$options_fontweight);
			$row2->addChild("woo_product_single_meta_title_font_weight",$woo_product_single_meta_title_font_weight);

			$woo_product_single_meta_title_letter_spacing = new QodeField("textsimple","woo_product_single_meta_title_letter_spacing","","Letter Spacing (px)","This is some description");
			$row2->addChild("woo_product_single_meta_title_letter_spacing",$woo_product_single_meta_title_letter_spacing);

	//Product single meta title
	
	$group3 = new QodeGroup("Product Single Meta Info Style","Define Product Single Meta Info Style");
	$panel2->addChild("group3",$group3);	

		$row1 = new QodeRow();
		$group3->addChild("row1",$row1);	

			$woo_product_single_meta_info_color = new QodeField("colorsimple","woo_product_single_meta_info_color","","Text Color","This is some description");
			$row1->addChild("woo_product_single_meta_info_color",$woo_product_single_meta_info_color);

			$woo_product_single_meta_info_font_size = new QodeField("textsimple","woo_product_single_meta_info_font_size","","Font Size (px)","This is some description");
			$row1->addChild("woo_product_single_meta_info_font_size",$woo_product_single_meta_info_font_size);

			$woo_product_single_meta_info_line_height = new QodeField("textsimple","woo_product_single_meta_info_line_height","","Line Height (px)","This is some description");
			$row1->addChild("woo_product_single_meta_info_line_height",$woo_product_single_meta_info_line_height);

			$woo_product_single_meta_info_text_transform = new QodeField("selectblanksimple","woo_product_single_meta_info_text_transform","","Text Transform","This is some description",$options_texttransform);
			$row1->addChild("woo_product_single_meta_info_text_transform",$woo_product_single_meta_info_text_transform);

		$row2 = new QodeRow(true);
		$group3->addChild("row2",$row2);

			$woo_product_single_meta_info_font_family = new QodeField("Fontsimple","woo_product_single_meta_info_font_family","-1","Font Family","This is some description");
			$row2->addChild("woo_product_single_meta_info_font_family",$woo_product_single_meta_info_font_family);

			$woo_product_single_meta_info_font_style = new QodeField("selectblanksimple","woo_product_single_meta_info_font_style","","Font Style","This is some description",$options_fontstyle);
			$row2->addChild("woo_product_single_meta_info_font_style",$woo_product_single_meta_info_font_style);

			$woo_product_single_meta_info_font_weight = new QodeField("selectblanksimple","woo_product_single_meta_info_font_weight","","Font Weight","This is some description",$options_fontweight);
			$row2->addChild("woo_product_single_meta_info_font_weight",$woo_product_single_meta_info_font_weight);

			$woo_product_single_meta_info_letter_spacing = new QodeField("textsimple","woo_product_single_meta_info_letter_spacing","","Letter Spacing (px)","This is some description");
			$row2->addChild("woo_product_single_meta_info_letter_spacing",$woo_product_single_meta_info_letter_spacing);

	//Product single price 

	$group4 = new QodeGroup("Product Single Price Style","Define Product Single Price Style");
	$panel2->addChild("group4",$group4);	

		$row1 = new QodeRow();
		$group4->addChild("row1",$row1);	

			$woo_product_single_price_color = new QodeField("colorsimple","woo_product_single_price_color","","Text Color","This is some description");
			$row1->addChild("woo_product_single_price_color",$woo_product_single_price_color);

			$woo_product_single_price_font_size = new QodeField("textsimple","woo_product_single_price_font_size","","Font Size (px)","This is some description");
			$row1->addChild("woo_product_single_price_font_size",$woo_product_single_price_font_size);

			$woo_product_single_price_line_height = new QodeField("textsimple","woo_product_single_price_line_height","","Line Height (px)","This is some description");
			$row1->addChild("woo_product_single_price_line_height",$woo_product_single_price_line_height);

			$woo_product_single_price_text_transform = new QodeField("selectblanksimple","woo_product_single_price_text_transform","","Text Transform","This is some description",$options_texttransform);
			$row1->addChild("woo_product_single_price_text_transform",$woo_product_single_price_text_transform);

		$row2 = new QodeRow(true);
		$group4->addChild("row2",$row2);

			$woo_product_single_price_font_family = new QodeField("Fontsimple","woo_product_single_price_font_family","-1","Font Family","This is some description");
			$row2->addChild("woo_product_single_price_font_family",$woo_product_single_price_font_family);

			$woo_product_single_price_font_style = new QodeField("selectblanksimple","woo_product_single_price_font_style","","Font Style","This is some description",$options_fontstyle);
			$row2->addChild("woo_product_single_price_font_style",$woo_product_single_price_font_style);

			$woo_product_single_price_font_weight = new QodeField("selectblanksimple","woo_product_single_price_font_weight","","Font Weight","This is some description",$options_fontweight);
			$row2->addChild("woo_product_single_price_font_weight",$woo_product_single_price_font_weight);

			$woo_product_single_price_letter_spacing = new QodeField("textsimple","woo_product_single_price_letter_spacing","","Letter Spacing (px)","This is some description");
			$row2->addChild("woo_product_single_price_letter_spacing",$woo_product_single_price_letter_spacing);

		$row3 = new QodeRow(true);
		$group4->addChild("row3",$row3);

			$woo_product_single_price_old_color = new QodeField("colorsimple","woo_product_single_price_old_color","","Old Price Color","This is some description");
			$row3->addChild("woo_product_single_price_old_color",$woo_product_single_price_old_color);

	//Related Products Title
			
	$group5 = new QodeGroup("Related Products Title Style","Define Related Products Title Style");
	$panel2->addChild("group5",$group5);	

		$row1 = new QodeRow();
		$group5->addChild("row1",$row1);	

			$woo_product_single_related_color = new QodeField("colorsimple","woo_product_single_related_color","","Text Color","This is some description");
			$row1->addChild("woo_product_single_related_color",$woo_product_single_related_color);

			$woo_product_single_related_font_size = new QodeField("textsimple","woo_product_single_related_font_size","","Font Size (px)","This is some description");
			$row1->addChild("woo_product_single_related_font_size",$woo_product_single_related_font_size);

			$woo_product_single_related_line_height = new QodeField("textsimple","woo_product_single_related_line_height","","Line Height (px)","This is some description");
			$row1->addChild("woo_product_single_related_line_height",$woo_product_single_related_line_height);

			$woo_product_single_related_text_transform = new QodeField("selectblanksimple","woo_product_single_related_text_transform","","Text Transform","This is some description",$options_texttransform);
			$row1->addChild("woo_product_single_related_text_transform",$woo_product_single_related_text_transform);

		$row2 = new QodeRow(true);
		$group5->addChild("row2",$row2);

			$woo_product_single_related_font_family = new QodeField("Fontsimple","woo_product_single_related_font_family","-1","Font Family","This is some description");
			$row2->addChild("woo_product_single_related_font_family",$woo_product_single_related_font_family);

			$woo_product_single_related_font_style = new QodeField("selectblanksimple","woo_product_single_related_font_style","","Font Style","This is some description",$options_fontstyle);
			$row2->addChild("woo_product_single_related_font_style",$woo_product_single_related_font_style);

			$woo_product_single_related_font_weight = new QodeField("selectblanksimple","woo_product_single_related_font_weight","","Font Weight","This is some description",$options_fontweight);
			$row2->addChild("woo_product_single_related_font_weight",$woo_product_single_related_font_weight);

			$woo_product_single_related_letter_spacing = new QodeField("textsimple","woo_product_single_related_letter_spacing","","Letter Spacing (px)","This is some description");
			$row2->addChild("woo_product_single_related_letter_spacing",$woo_product_single_related_letter_spacing);										
		
	//Add to cart button

	$group6 = new QodeGroup("Add To Cart Button Style","Define Add To Cart Button Style");
	$panel2->addChild("group6",$group6);	

		$row1 = new QodeRow();
		$group6->addChild("row1",$row1);	

			$woo_products_single_add_to_cart_color = new QodeField("colorsimple","woo_products_single_add_to_cart_color","","Text Color","This is some description");
			$row1->addChild("woo_products_single_add_to_cart_color",$woo_products_single_add_to_cart_color);

			$woo_products_single_add_to_cart_font_size = new QodeField("textsimple","woo_products_single_add_to_cart_font_size","","Font Size (px)","This is some description");
			$row1->addChild("woo_products_single_add_to_cart_font_size",$woo_products_single_add_to_cart_font_size);

			$woo_products_single_add_to_cart_line_height = new QodeField("textsimple","woo_products_single_add_to_cart_line_height","","Line Height (px)","This is some description");
			$row1->addChild("woo_products_single_add_to_cart_line_height",$woo_products_single_add_to_cart_line_height);

			$woo_products_single_add_to_cart_text_transform = new QodeField("selectblanksimple","woo_products_single_add_to_cart_text_transform","","Text Transform","This is some description",$options_texttransform);
			$row1->addChild("woo_products_single_add_to_cart_text_transform",$woo_products_single_add_to_cart_text_transform);

		$row2 = new QodeRow(true);
		$group6->addChild("row2",$row2);

			$woo_products_single_add_to_cart_font_family = new QodeField("Fontsimple","woo_products_single_add_to_cart_font_family","-1","Font Family","This is some description");
			$row2->addChild("woo_products_single_add_to_cart_font_family",$woo_products_single_add_to_cart_font_family);

			$woo_products_single_add_to_cart_font_style = new QodeField("selectblanksimple","woo_products_single_add_to_cart_font_style","","Font Style","This is some description",$options_fontstyle);
			$row2->addChild("woo_products_single_add_to_cart_font_style",$woo_products_single_add_to_cart_font_style);

			$woo_products_single_add_to_cart_font_weight = new QodeField("selectblanksimple","woo_products_single_add_to_cart_font_weight","","Font Weight","This is some description",$options_fontweight);
			$row2->addChild("woo_products_single_add_to_cart_font_weight",$woo_products_single_add_to_cart_font_weight);

			$woo_products_single_add_to_cart_letter_spacing = new QodeField("textsimple","woo_products_single_add_to_cart_letter_spacing","","Letter Spacing (px)","This is some description");
			$row2->addChild("woo_products_single_add_to_cart_letter_spacing",$woo_products_single_add_to_cart_letter_spacing);
		
		$row3 = new QodeRow(true);
		$group6->addChild("row3",$row3);
		
			$woo_products_single_add_to_cart_hover_color = new QodeField("colorsimple","woo_products_single_add_to_cart_hover_color","","Hover Color","This is some description");
			$row3->addChild("woo_products_single_add_to_cart_hover_color",$woo_products_single_add_to_cart_hover_color);

			$woo_products_single_add_to_cart_background_color = new QodeField("colorsimple","woo_products_single_add_to_cart_background_color","","Background Color","This is some description");
			$row3->addChild("woo_products_single_add_to_cart_background_color",$woo_products_single_add_to_cart_background_color);

			$woo_products_single_add_to_cart_background_hover_color = new QodeField("colorsimple","woo_products_single_add_to_cart_background_hover_color","","Hover Background Color","This is some description");
			$row3->addChild("woo_products_single_add_to_cart_background_hover_color",$woo_products_single_add_to_cart_background_hover_color);										
		
		$row4 = new QodeRow(true);
		$group6->addChild("row4",$row4);

			$woo_products_single_add_to_cart_border_color = new QodeField("colorsimple","woo_products_single_add_to_cart_border_color","","Border Color","This is some description");
			$row4->addChild("woo_products_single_add_to_cart_border_color",$woo_products_single_add_to_cart_border_color);

			$woo_products_single_add_to_cart_border_hover_color = new QodeField("colorsimple","woo_products_single_add_to_cart_border_hover_color","","Border Hover Color","This is some description");
			$row4->addChild("woo_products_single_add_to_cart_border_hover_color",$woo_products_single_add_to_cart_border_hover_color);	

			$woo_products_single_add_to_cart_border_width = new QodeField("textsimple","woo_products_single_add_to_cart_border_width","","Border Width (px)","This is some description");
			$row4->addChild("woo_products_single_add_to_cart_border_width",$woo_products_single_add_to_cart_border_width);

			$woo_products_single_add_to_cart_border_radius = new QodeField("textsimple","woo_products_single_add_to_cart_border_radius","","Border radius (px)","This is some description");
			$row4->addChild("woo_products_single_add_to_cart_border_radius",$woo_products_single_add_to_cart_border_radius);	

	//Woocommerce tabs

	$woo_product_single_disable_tab_content_box = new QodeField("yesno","woo_product_single_disable_tab_content_box","no","Disable Tab Content Box","Enabling this option will turn disable box around tab content.");
	$panel2->addChild("woo_product_single_disable_tab_content_box",$woo_product_single_disable_tab_content_box);