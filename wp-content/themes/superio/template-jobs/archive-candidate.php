<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;
if ( isset( $_REQUEST['load_type'] ) && WP_Job_Board_Pro_Mixes::is_ajax_request() ) {
	if ( 'items' !== $_REQUEST['load_type'] ) {
        echo WP_Job_Board_Pro_Template_Loader::get_template_part('archive-candidate-ajax-full', array('candidates' => $wp_query));
	} else {
		echo WP_Job_Board_Pro_Template_Loader::get_template_part('archive-candidate-ajax-candidates', array('candidates' => $wp_query));
	}

} else {
	get_header();
	
	$layout_type = superio_get_candidates_layout_type();

	if ( $layout_type == 'half-map' ) {
	?>
		<section id="main-container" class="inner">
			<div class="row no-margin layout-type-<?php echo esc_attr($layout_type); ?>">
				<div id="main-content" class="col-xs-12 col-md-7 no-padding">
					<div class="inner-left">
						<?php if ( is_active_sidebar( 'candidates-filter-sidebar' ) ): ?>
							<div class="filter-sidebar offcanvas-filter-sidebar">
								<div class="mobile-groups-button hidden-lg hidden-md clearfix text-center">
									<button class=" btn btn-sm btn-theme btn-view-map" type="button"><i class="fa fa-map-o" aria-hidden="true"></i> <?php esc_html_e( 'Map View', 'superio' ); ?></button>
									<button class=" btn btn-sm btn-theme  btn-view-listing hidden-sm hidden-xs" type="button"><i class="fa fa-list" aria-hidden="true"></i> <?php esc_html_e( 'Listing View', 'superio' ); ?></button>
								</div>
								<div class="filter-scroll">
						   			<?php dynamic_sidebar( 'candidates-filter-sidebar' ); ?>
						   		</div>
					   		</div>
					   	<?php endif; ?>
					   	<div class="content-listing">
							<?php
								echo WP_Job_Board_Pro_Template_Loader::get_template_part('loop/candidate/archive-inner', array('candidates' => $wp_query));

								echo WP_Job_Board_Pro_Template_Loader::get_template_part('loop/candidate/pagination', array('candidates' => $wp_query));
							?>
						</div>
					</div>
				</div><!-- .content-area -->
				<div class="col-md-5 col-xs-12 no-padding">
					<div id="jobs-google-maps" class="fix-map">
						<span class="filter-in-sidebar btn-theme btn hidden-lg hidden-md"><i class="ti-filter"></i><span class="text"><?php esc_html_e( 'Filter', 'superio' ); ?></span></span>
					</div>
				</div>
			</div>
		</section>
	<?php
	} else {
		$sidebar_configs = superio_get_candidates_layout_configs();

		$layout_sidebar = superio_get_candidates_layout_sidebar();
	?>
		<section id="main-container" class="page-job-board inner layout-type-<?php echo esc_attr($layout_type); ?> <?php echo ((superio_get_candidates_show_filter_top())?'has-filter-top':''); ?>">

			<?php if ( $layout_type == 'top-map' ) { ?>
				<div class="mobile-groups-button hidden-lg hidden-md clearfix text-center">
					<button class=" btn btn-xs btn-theme btn-view-map" type="button"><i class="fas fa-map" aria-hidden="true"></i> <?php esc_html_e( 'Map View', 'superio' ); ?></button>
					<button class=" btn btn-xs btn-theme  btn-view-listing hidden-sm hidden-xs" type="button"><i class="fas fa-list" aria-hidden="true"></i> <?php esc_html_e( 'Properties View', 'superio' ); ?></button>
				</div>
				
				<div class="p-relative">
					<div id="jobs-google-maps" class="hidden-sm hidden-xs top-map"></div>

					<?php if ( $layout_sidebar == 'main' && is_active_sidebar( 'candidates-filter-top-sidebar' ) ) { ?>
						<div class="candidates-filter-top-sidebar-wrapper">
							<div class="container">
					   			<?php dynamic_sidebar( 'candidates-filter-top-sidebar' ); ?>
					   		</div>
					   	</div>
					<?php } ?>
				</div>
			<?php } ?>

			<?php superio_render_breadcrumbs(); ?>

			<?php if ( superio_get_candidates_show_filter_top() ) { ?>
				<div class="candidates-filter-top-sidebar-wrapper filter-top-sidebar-wrapper">
			   		<?php dynamic_sidebar( 'candidates-filter-top-sidebar' ); ?>
			   	</div>
			<?php } ?>

			<section class="layout-job-sidebar-v2 main-content <?php echo apply_filters('superio_candidate_content_class', 'container');?> inner">
				<?php superio_before_content( $sidebar_configs ); ?>
				<div class="row">
					<?php superio_display_sidebar_left( $sidebar_configs ); ?>

					<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
						<main id="main" class="site-main layout-type-<?php echo esc_attr($layout_type); ?>" role="main">
							<?php
								echo WP_Job_Board_Pro_Template_Loader::get_template_part('loop/candidate/archive-inner', array('candidates' => $wp_query));

								echo WP_Job_Board_Pro_Template_Loader::get_template_part('loop/candidate/pagination', array('candidates' => $wp_query));
							?>
						</main><!-- .site-main -->
					</div><!-- .content-area -->
					
					<?php superio_display_sidebar_right( $sidebar_configs ); ?>
				</div>
			</section>
		</section>
	<?php
	}

	get_footer();
}