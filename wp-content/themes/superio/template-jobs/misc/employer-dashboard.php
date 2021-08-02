<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$jobs = WP_Job_Board_Pro_Query::get_posts(array(
    'post_type' => 'job_listing',
    'post_status' => 'publish',
    'author' => $user_id,
    'fields' => 'ids'
));
$count_jobs = $jobs->post_count;
$shortlist = get_post_meta($employer_id, WP_JOB_BOARD_PRO_EMPLOYER_PREFIX.'shortlist', true);
$shortlist = is_array($shortlist) ? count($shortlist) : 0;
$total_reviews = WP_Job_Board_Pro_Review::get_total_reviews($employer_id);
$views = get_post_meta($employer_id, WP_JOB_BOARD_PRO_EMPLOYER_PREFIX.'views_count', true);

$job_ids = !empty($jobs->posts) ? $jobs->posts : array();
$query_vars = array(
	'post_type'         => 'job_applicant',
	'posts_per_page'    => 1,
	'paged'    			=> 1,
	'post_status'       => 'publish',
	'meta_query'       => array(
		array(
			'key' => WP_JOB_BOARD_PRO_APPLICANT_PREFIX.'job_id',
			'value'     => array_merge(array(0), $job_ids),
			'compare'   => 'IN',
		)
	)
);
$applicants = new WP_Query($query_vars);
$applicants_count = $applicants->found_posts;


?>
<div class="box-dashboard-wrapper employer-dashboard-wrapper">
	<h3 class="title"><?php esc_html_e('Applications statistics', 'superio'); ?></h3>
	<div class="space-30">
		<div class="statistics row">
			<div class="col-xs-12 col-lg-3 col-sm-6">
				<div class="inner-header">
					<div class="posted-jobs list-item flex-middle justify-content-between text-right">
						<div class="icon-wrapper">
							<div class="icon">
								<i class="flaticon-briefcase-1"></i>
							</div>
						</div>
						<div class="inner">
							<div class="number-count"><?php echo esc_html( $count_jobs ? WP_Job_Board_Pro_Mixes::format_number($count_jobs) : 0); ?></div>
							<span><?php esc_html_e('Posted Jobs', 'superio'); ?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-lg-3 col-sm-6">
				<div class="inner-header">
				<div class="views-count-wrapper list-item flex-middle justify-content-between text-right">
					<div class="icon-wrapper">
					<div class="icon">
						<i class="flaticon-resume"></i>
					</div>
					</div>
					<div class="inner">
						<div class="number-count"><?php echo esc_html( $applicants_count ? WP_Job_Board_Pro_Mixes::format_number($applicants_count) : 0 ); ?></div>
						<span><?php esc_html_e('Application', 'superio'); ?></span>
					</div>
				</div>
				</div>
			</div>
			<div class="col-xs-12 col-lg-3 col-sm-6">
				<div class="inner-header">
				<div class="review-count-wrapper list-item flex-middle justify-content-between text-right">
					<div class="icon-wrapper">
					<div class="icon">
						<i class="flaticon-chat"></i>
					</div>
					</div>
					<div class="inner">
						<div class="number-count"><?php echo esc_html( $total_reviews ? WP_Job_Board_Pro_Mixes::format_number($total_reviews) : 0 ); ?></div>
						<span><?php esc_html_e('Review', 'superio'); ?></span>
					</div>
				</div>
				</div>
			</div>
			<div class="col-xs-12 col-lg-3 col-sm-6">
				<div class="inner-header">
				<div class="shortlist list-item flex-middle justify-content-between text-right">
					<div class="icon-wrapper">
					<div class="icon">
						<i class="flaticon-bookmark"></i>
					</div>
					</div>
					<div class="inner">
						<div class="number-count"><?php echo esc_html($shortlist ? WP_Job_Board_Pro_Mixes::format_number($shortlist) : 0); ?></div>
						<span><?php esc_html_e('Shortlisted', 'superio'); ?></span>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<?php if ( version_compare(WP_JOB_BOARD_PRO_PLUGIN_VERSION, '1.1.6', '>') ) {
		wp_enqueue_script( 'chart', get_template_directory_uri() . '/js/chart.min.js', array( 'jquery' ), '1.0.0', true );
	?>
		<?php
			$query_vars = array(
				'post_type'     => 'job_listing',
				'post_status'   => apply_filters('wp-job-board-pro-my-jobs-post-statuses', array( 'publish', 'expired', 'pending', 'pending_approve', 'draft', 'preview' )),
				'paged'         => 1,
				'author'        => get_current_user_id(),
				'orderby'		=> 'date',
				'order'			=> 'DESC',
				'fields'		=> 'ids'
			);

			$jobs = new WP_Query($query_vars);
			if ( !empty($jobs->posts) ) {
				superio_load_select2();
		?>
			<div class="inner-list">
				<h3 class="title-small"><?php echo esc_html__( 'Page Views', 'superio' ); ?></h3>
				<div class="page_views-wrapper">
					
					<div class="page_views-wrapper">
						<canvas id="dashboard_job_chart_wrapper" data-job_id="<?php echo esc_attr($jobs->posts[0]); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'superio-job-chart-nonce' )); ?>"></canvas>
					</div>

					<div class="search-form-wrapper">
						<form class="stats-graph-search-form" method="post">
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<label><?php esc_html_e('Jobs', 'superio'); ?></label>
										<select class="form-control" name="job_id">
											<?php foreach ($jobs->posts as $post_id) { ?>
												<option value="<?php echo esc_attr($post_id); ?>"><?php echo esc_html(get_the_title($post_id)); ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-xs-6">
									<div class="form-group">
										<label><?php esc_html_e('Number Days', 'superio'); ?></label>
										<select class="form-control" name="nb_days">
											<option value="30"><?php esc_html_e('30 days', 'superio'); ?></option>
											<option value="15" selected><?php esc_html_e('15 days', 'superio'); ?></option>
											<option value="7"><?php esc_html_e('7 days', 'superio'); ?></option>
										</select>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php } ?>

	<?php } ?>
	<div class="inner-list">
		<h3 class="title-small"><?php esc_html_e('Recent Applicants', 'superio'); ?></h3>
		<div class="applicants">
			<?php
				$jobs_loop = WP_Job_Board_Pro_Query::get_posts(array(
					'post_type' => 'job_listing',
					'fields' => 'ids',
					'author' => $user_id,
				));
				$job_ids = array();
				if ( !empty($jobs_loop) && !empty($jobs_loop->posts) ) {
					$job_ids = $jobs_loop->posts;
				}
				if ( !empty($job_ids) ) {
					$query_args = array(
						'post_type'         => 'job_applicant',
						'posts_per_page'    => 5,
						'post_status'       => 'publish',
						'meta_query'       => array(
							array(
								'key' => WP_JOB_BOARD_PRO_APPLICANT_PREFIX.'job_id',
								'value'     => $job_ids,
								'compare'   => 'IN',
							),
						)
					);

					$applicants = new WP_Query($query_args);
					
					if ( $applicants->have_posts() ) {
						while ( $applicants->have_posts() ) : $applicants->the_post();
							global $post;
							
		                    $app_status = WP_Job_Board_Pro_Applicant::get_post_meta($post->ID, 'app_status', true);
		                    if ( $app_status == 'rejected' ) {
								echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'content-rejected-applicant' );
							} elseif ( $app_status == 'approved' ) {
								echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'content-approved-applicant' );
							} else {
								echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'content-applicant' );
							}

						endwhile;
						wp_reset_postdata();
					} else {
						?>
						<div class="no-found"><?php esc_html_e('No applicants found.', 'superio'); ?></div>
						<?php
					}
				} else {
					?>
					<div class="no-found"><?php esc_html_e('No applicants found.', 'superio'); ?></div>
					<?php
				}
			?>
		</div>
	</div>
</div>