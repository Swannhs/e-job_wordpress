<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

?>

<?php do_action( 'wp_job_board_pro_before_employer_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('map-item'); ?> <?php superio_employer_item_map_meta($post); ?>>
    <div class="employer-list v1 layout-employer">
        <?php superio_employer_display_follow_btn($post->ID); ?>
        <div class="flex-middle-sm">
            <div class="inner-left flex-middle">
                <?php if ( has_post_thumbnail() ) { ?>
                    <?php superio_employer_display_logo($post); ?>
                <?php } ?>
                <div class="info-employer">
                    <div class="title-wrapper">
                        <?php the_title( sprintf( '<h2 class="employer-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                    </div>
                    <div class="employer-metas">
                        <?php superio_employer_display_short_location($post,'icon'); ?>
                    </div>
                </div>
            </div>
            <div class="ali-right">
                <?php superio_employer_display_open_position($post); ?>
            </div>
        </div>
    </div>
</article><!-- #post-## -->
<?php do_action( 'wp_job_board_pro_after_employer_content', $post->ID ); ?>