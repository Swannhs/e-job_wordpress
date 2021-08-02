<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'candidate' ) {
    return;
}

$meta_obj = WP_Job_Board_Pro_Candidate_Meta::get_instance($post->ID);

if ( $meta_obj->check_post_meta_exist('socials') && ($socials = $meta_obj->get_post_meta( 'socials' )) ) {
    $all_socials = WP_Job_Board_Pro_Mixes::get_socials_network();
    extract( $args );
    extract( $instance );
    $title = apply_filters('widget_title', $instance['title']);

    if ( $title ) {
        echo trim($before_title)  . trim( $title ) . $after_title;
    }
    ?>

    <div class="job-detail-detail in-sidebar">
        <?php if ( $socials ) { ?>
        <div class="flex-middle">
            <div class="social-title"><?php echo esc_html__('Social Profiles:','superio'); ?> </div>
            <div class="apus-social-share ali-right">
                <?php foreach ($socials as $social) { ?>
                    <?php if ( !empty($social['url']) && !empty($social['network']) ) {
                        $icon_class = !empty( $all_socials[$social['network']]['icon'] ) ? $all_socials[$social['network']]['icon'] : '';
                    ?>
                        <a href="<?php echo esc_html($social['url']); ?>">
                            <i class="<?php echo esc_attr($icon_class); ?>"></i>
                        </a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>

<?php }