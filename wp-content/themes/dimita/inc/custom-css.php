<?php 
	$dimita_settings = dimita_global_settings(); 
	$repeat = isset($dimita_settings['background_repeat']) && $dimita_settings['background_repeat'] ? $dimita_settings['background_repeat'] : "no-repeat";
	$layout = isset($dimita_settings['layout']) && $dimita_settings['layout'] ? $dimita_settings['layout'] : "";
	$bg_image_box =	isset($dimita_settings['background_box_img']) ? $dimita_settings['background_box_img'] : "";
	$background_color = isset($dimita_settings['background_color']) ? $dimita_settings['background_color'] : "";
	function dimita_hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);
		if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		return implode(",", $rgb);
	}
?>
<?php if($background_color) : ?>
	body{
		background-color: <?php echo esc_html($background_color); ?> ;
	}
<?php endif; ?>
<?php if( (isset($bg_image_box['url']) && $bg_image_box['url']) && ($layout == 'boxed' )) {?>
	body.box-layout{
	<?php if( $layout == 'boxed' && $bg_image_box['url']) : ?>
		background-image: url("<?php echo esc_url( $bg_image_box['url'] ) ?>");
		background-position: top center; 
		background-attachment: fixed;
		background-size: cover;
		background-repeat: <?php echo esc_html( $repeat )?>;	
	<?php endif; ?>
	}
<?php } ?>
<?php 
	$background_img =  isset($dimita_settings['background_img']) ? $dimita_settings['background_img'] : "";
	if( ( isset($background_img['url']) && $background_img['url']) && ($layout != 'boxed' ) ) { ?>
	body{
		background-image: url("<?php echo esc_html( $background_img['url'] ); ?>");
		background-repeat: <?php echo esc_html( $repeat )?>;
	}
<?php } ?>
<?php
$family_font_custom = isset($dimita_settings['family_font_custom']) && $dimita_settings['family_font_custom'] ? $dimita_settings['family_font_custom'] : array();
$class_font_custom = isset($dimita_settings['class_font_custom']) && $dimita_settings['class_font_custom'] ? $dimita_settings['class_font_custom'] : "";	
if($family_font_custom && $class_font_custom) : 
		echo html_entity_decode($class_font_custom); ?>
		{
			font-family:	<?php echo esc_html($family_font_custom['font-family']) ?> ; 
			font-size:	<?php echo esc_html($family_font_custom['font-size']) ?>; 
			font-weight:<?php echo esc_html($family_font_custom['font-weight']) ?>;	
		}		
<?php endif; ?>