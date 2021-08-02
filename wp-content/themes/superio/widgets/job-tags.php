<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'job_listing' ) {
    return;
}

$tags = superio_job_display_tags($post, 'no-title', false);

if ( empty($tags) ) {
	return;
}

extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

?>
<div class="job-detail-tags">
    <?php echo trim($tags); ?>
</div>
