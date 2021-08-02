<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'candidate' ) {
    return;
}

extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

?>
<div id="candidate-buttons" class="candidate-buttons">
    <?php
    
    if ( $show_cv_button ) {
        WP_Job_Board_Pro_Candidate::display_download_cv_btn($post->ID, 'btn btn-download-cv');
    }
    if ( $show_shortlist_button ) {
        WP_Job_Board_Pro_Candidate::display_shortlist_btn($post->ID);
    }
    ?>
</div>