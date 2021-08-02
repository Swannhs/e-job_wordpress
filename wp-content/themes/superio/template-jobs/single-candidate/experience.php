<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_Job_Board_Pro_Candidate_Meta::get_instance($post->ID);

if ( $meta_obj->check_post_meta_exist('experience') && ($experience = $meta_obj->get_post_meta( 'experience' )) ) {
?>
    <div id="job-candidate-experience" class="candidate-detail-experience my_resume_eduarea color-blue">
        <h4 class="title"><?php esc_html_e('Work &amp; Experience', 'superio'); ?></h4>
        <?php foreach ($experience as $item) { ?>
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
                    <?php if ( !empty($item['start_date']) || !empty($item['end_date']) ) { ?>
                        <div class="year">
                            <?php if ( !empty($item['start_date']) ) { ?>
                                <?php echo esc_html($item['start_date']); ?>
                            <?php } ?>
                            <?php if ( !empty($item['end_date']) ) { ?>
                                - <?php echo esc_html($item['end_date']); ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="edu_center">
                    <?php if ( !empty($item['company']) ) { ?>
                        <span class="university"><?php echo esc_html($item['company']); ?></span>
                    <?php } ?>
                </div>
                <?php if ( !empty($item['description']) ) { ?>
                    <p class="mb0"><?php echo esc_html($item['description']); ?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php }