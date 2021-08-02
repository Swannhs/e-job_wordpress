<?php 

extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  .trim( $title ) . $after_title;
}

?>
<div class="widget-search">

    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
			<button type="submit" class="btn btn-search"><i class="flaticon-magnifiying-glass"></i></button>
			<input type="text" placeholder="<?php esc_attr_e( 'keywords', 'superio' ); ?>" name="s" class="apus-search form-control"/>
		<?php if ( isset($post_type) && $post_type ): ?>
			<input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" class="post_type" />
		<?php endif; ?>
	</form>

</div>