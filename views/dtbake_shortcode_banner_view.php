<div class="full_banner" id="banner_<?php echo esc_attr( $sc_atts->banner_id ); ?>">
	<span class="title"><?php echo esc_html( $sc_atts->title ); ?></span>
	<span class="content"><?php echo esc_html( $sc_atts->innercontent ); ?></span>
	<?php if ( $sc_atts->link && $sc_atts->linkhref ) : ?>
	<a href="<?php echo esc_url( $sc_atts->linkhref ); ?>" class="link dtbaker_button_light"><?php echo esc_html( $sc_atts->link ); ?></a>
	<?php endif; ?>
</div>
