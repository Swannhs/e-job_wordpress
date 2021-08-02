<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_Job_Board_Pro_Candidate_Meta::get_instance($post->ID);

if ( $meta_obj->check_post_meta_exist('award') && ($award = $meta_obj->get_post_meta( 'award' )) ) {
?>
    <div id="job-candidate-award" class="my_resume_eduarea color-yellow">
        <h4 class="title"><?php esc_html_e('Awards', 'superio'); ?></h4>
        <?php foreach ($award as $item) { ?>

            <div class="content">
                <div class="circle">
                    <?php if ( !empty($item['title']) ) {
                        echo substr(trim($item['title']), 0, 1);
                    } ?>
                </div>
                <div class="top-info">
                    <?php if ( !empty($item['title']) ) { ?>
                        <h4 class="edu_stats"><?php echo esc_html($item['title']); ?></h4>
                    <?php } ?>
                    <?php if ( !empty($item['year']) ) { ?>
                        <div class="year"><?php echo esc_html($item['year']); ?></div>
                    <?php } ?>
                </div>
                <?php if ( !empty($item['description']) ) { ?>
                    <div class="mb0"><?php echo esc_html($item['description']); ?></div>
                <?php } ?>
            </div>

        <?php } ?>
    </div>
<?php }