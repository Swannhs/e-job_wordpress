<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;

wp_enqueue_style( 'jquery-datetimepicker', WP_JOB_BOARD_PRO_PLUGIN_URL . 'assets/css/jquery.datetimepicker.min.css', array(), '1.1.0' );
wp_enqueue_script( 'jquery-datetimepicker', WP_JOB_BOARD_PRO_PLUGIN_URL . 'assets/js/jquery.datetimepicker.full.min.js', array( 'jquery' ), '1.1.0', true );

?>
<div id="job-apply-reschedule-meeting-form-wrapper-<?php echo esc_attr($post->ID); ?>" class="job-apply-email-form-wrapper mfp-hide">
	<div class="inner">
		<h2 class="widget-title"><span><?php esc_html_e('Re-schedule Meeting', 'wp-job-board-pro'); ?></span></h2>

		<form id="job-apply-reschedule-meeting-form-<?php echo esc_attr($post->ID); ?>" class="reschedule-meeting-form" method="post">
			<div class="form-group">
				<label><?php esc_html_e('Date', 'wp-job-board-pro'); ?></label>
				<input type="text" class="form-control style2 datetimepicker-date" name="date" placeholder="<?php echo esc_attr(date_i18n(get_option('date_format'), strtotime('now'))); ?>" required="required" data-date_format="<?php echo esc_attr(get_option('date_format')); ?>">
			</div>
			<div class="form-group">
				<label><?php esc_html_e('Time', 'wp-job-board-pro'); ?></label>
				<input type="text" class="form-control style2 datetimepicker-time" name="time" placeholder="<?php echo esc_attr(date_i18n(get_option('time_format'), strtotime('now'))); ?>" required="required" data-time_format="<?php echo esc_attr(get_option('time_format')); ?>">
			</div>
			<div class="form-group">
				<label><?php esc_html_e('Time Duration', 'wp-job-board-pro'); ?></label>
				<input type="text" class="form-control style2" name="time_duration" placeholder="<?php esc_attr_e('30', 'wp-job-board-pro'); ?>" required="required">
			</div>

	     	<div class="form-group space-30">
	     		<label><?php esc_html_e('Message', 'wp-job-board-pro'); ?></label>
	            <textarea class="form-control style2" name="message" placeholder="<?php esc_attr_e( 'Message', 'wp-job-board-pro' ); ?>"></textarea>
	        </div>
	        <!-- /.form-group -->

			<?php wp_nonce_field( 'wp-job-board-pro-reschedule-meeting-nonce', 'nonce' ); ?>
	      	<input type="hidden" name="action" value="wp_job_board_pro_ajax_reschedule_meeting">
	      	<input type="hidden" name="meeting_id" value="<?php echo esc_attr($post->ID); ?>">
	        <button class="button btn btn-theme btn-block" name="reschedule-meeting"><?php echo esc_html__( 'Re-schedule Meeting', 'wp-job-board-pro' ); ?></button>
		</form>
	</div>
</div>
