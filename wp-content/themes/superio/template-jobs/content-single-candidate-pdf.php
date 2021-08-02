<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php do_action( 'wp_job_board_pro_before_job_detail', get_the_ID() ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('candidate-single-v1'); ?>>
	<!-- heading -->
	<?php echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'single-candidate/header-pdf' ); ?>

	<!-- Main content -->
	<div class="row">
		<div class="col-sm-12">

			<?php do_action( 'wp_job_board_pro_before_job_content', get_the_ID() ); ?>
			
			<?php echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'single-candidate/detail' ); ?>

			<!-- job description -->
			<?php if ( superio_get_config('show_candidate_description', true) ) { ?>
				<h2><?php esc_html_e('About Me', 'superio'); ?></h2>
				<div class="job-detail-description">
					<div class="inner">
						<?php the_content(); ?>
					</div>
				</div>
			<?php } ?>

			<?php if ( superio_get_config('show_candidate_video', true) ) { ?>
				<?php echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'single-candidate/video' ); ?>
			<?php } ?>

			<?php if ( superio_get_config('show_candidate_education', true) ) { ?>
				<?php echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'single-candidate/education' ); ?>
			<?php } ?>

			<?php if ( superio_get_config('show_candidate_experience', true) ) { ?>
				<?php echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'single-candidate/experience' ); ?>
			<?php } ?>

			<?php if ( superio_get_config('show_candidate_portfolios', true) ) { ?>
				<?php echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'single-candidate/portfolios' ); ?>
			<?php } ?>

			<?php if ( superio_get_config('show_candidate_skill', true) ) { ?>
				<?php echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'single-candidate/skill' ); ?>
			<?php } ?>

			<?php if ( superio_get_config('show_candidate_award', true) ) { ?>
				<?php echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'single-candidate/award' ); ?>
			<?php } ?>
			
			<?php do_action( 'wp_job_board_pro_after_job_content', get_the_ID() ); ?>
		</div>
	</div>

</article><!-- #post-## -->

<?php do_action( 'wp_job_board_pro_after_job_detail', get_the_ID() ); ?>