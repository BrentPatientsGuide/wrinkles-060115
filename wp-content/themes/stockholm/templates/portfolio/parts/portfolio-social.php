<?php
global $qode_options;
?>

<?php if(isset($qode_options['enable_social_share'])  && $qode_options['enable_social_share'] == "yes") { ?>
	<div class="portfolio_social_holder">
		<?php echo do_shortcode('[social_share_list]'); ?>
	</div> <!-- close div.portfolio_social_holder -->
<?php } ?>