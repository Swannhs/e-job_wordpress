<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

?>

<?php do_action( 'wp_job_board_pro_before_employer_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('map-item'); ?> <?php superio_employer_item_map_meta($post); ?>>
    <div class="employer-grid v3 layout-employer">
        <?php superio_employer_display_follow_btn($post->ID); ?>
        <?php superio_employer_display_logo($post); ?>
        <?php the_title( sprintf( '<h2 class="employer-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    </div>
</article><!-- #post-## -->

<?php do_action( 'wp_job_board_pro_after_employer_content', $post->ID ); ?>