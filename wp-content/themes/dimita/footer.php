	</div><!-- #main -->
		<?php 
			global $page_id;
			$dimita_settings = dimita_global_settings();
			$footer_style = dimita_get_config('footer_style','');
			$footer_style = (get_post_meta( $page_id,'page_footer_style', true )) ? get_post_meta( $page_id, 'page_footer_style', true ) : $footer_style ;
			$header_style = dimita_get_config('header_style', ''); 
			$header_style  = (get_post_meta( $page_id, 'page_header_style', true )) ? get_post_meta($page_id, 'page_header_style', true ) : $header_style ;
		?>
		<?php if($footer_style && (get_post($footer_style)) && in_array( 'elementor/elementor.php', apply_filters('active_plugins', get_option( 'active_plugins' )))){ ?>
			<?php $elementor_instance = Elementor\Plugin::instance(); ?>
			<footer id="bwp-footer" class="bwp-footer <?php echo esc_attr( get_post($footer_style)->post_name ); ?>">
				<?php echo dimita_render_footer($footer_style);	?>
			</footer>
		<?php }else{
			dimita_copyright();
		}?>
	</div><!-- #page -->
	<div class="search-overlay">	
		<span class="close-search"><i class="icon_close"></i></span>	
		<div class="container wrapper-search">
			<?php dimita_search_form_product(); ?>		
		</div>	
	</div>
	<div class="bwp-quick-view">
	</div>	
	<?php 
		$back_active = dimita_get_config('back_active');
		if($back_active && $back_active == 1):
	?>
	<div class="back-top">
		<i class="arrow_carrot-up"></i>
	</div>
	<?php endif;?>
	<?php if((isset($dimita_settings['show-newletter']) && $dimita_settings['show-newletter']) && is_active_sidebar('newletter-popup-form') && function_exists('dimita_popup_newsletter')) : ?>		
		<?php dimita_popup_newsletter(); ?>
	<?php endif;  ?>
	<?php wp_footer(); ?>
</body>
</html>