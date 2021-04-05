<?php 
	get_header(); 
	$dimita_settings = dimita_global_settings();
	$background = dimita_get_config('background');
	$bgs = isset($dimita_settings['img-404']['url']) && $dimita_settings['img-404']['url'] ? $dimita_settings['img-404']['url'] : "";
?>
<div class="container">
	<div class="page-404">
		<div class="content-page-404">
			<div class="title-error"><?php echo isset($dimita_settings['title-error']) ? $dimita_settings['title-error'] : esc_html__('Ooops.', 'dimita'); ?></div>
			<div class="sub-error"><?php echo isset($dimita_settings['sub-error']) ? $dimita_settings['sub-error'] : esc_html__("We can't seem to find the page you're looking for...", 'dimita'); ?></div>
			<a class="btn" href="<?php echo esc_url( home_url('/') ); ?>"><?php echo isset($dimita_settings['btn-error']) ? esc_html($dimita_settings['btn-error']) : esc_html__('Back to Homepage', 'dimita'); ?></a>	
		</div>
	</div>
</div>
<?php
get_footer();