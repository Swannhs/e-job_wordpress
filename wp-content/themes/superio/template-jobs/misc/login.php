<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$popup = isset($popup) ? $popup : false;
$rand = rand(0000, 9999);
?>
<div class="login-form-wrapper">
	<div id="login-form-wrapper<?php echo esc_attr($rand); ?>" class="form-container">			
		<?php if ( defined('SUPERIO_DEMO_MODE') && SUPERIO_DEMO_MODE ) { ?>
			<div class="sign-in-demo-notice">
				Username: <strong>candidate</strong> or <strong>employer</strong><br>
				Password: <strong>demo</strong>
			</div>
		<?php } ?>
		
		<form class="login-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
			<?php if ( isset($_SESSION['register_msg']) ) { ?>
				<div class="alert <?php echo esc_attr($_SESSION['register_msg']['error'] ? 'alert-warning' : 'alert-info'); ?>">
					<?php echo trim($_SESSION['register_msg']['msg']); ?>
				</div>
			<?php
				unset($_SESSION['register_msg']);
			}
			?>
			<div class="form-group">
				<label><?php esc_attr_e('Username or email','superio'); ?></label>
				<input autocomplete="off" type="text" name="username" class="form-control" id="username_or_email" placeholder="<?php esc_attr_e('Username or email','superio'); ?>">
			</div>
			<div class="form-group">
				<label><?php esc_attr_e('Password','superio'); ?></label>
				<input name="password" type="password" class="password required form-control" id="login_password" placeholder="<?php esc_attr_e('Password','superio'); ?>">
			</div>
			<div class="row form-group info">
				<div class="col-sm-6">
					<label for="user-remember-field" class="remember">
						<input type="checkbox" name="remember" id="user-remember-field" value="true"> <?php echo esc_html__('Keep me signed in','superio'); ?>
					</label>
				</div>
				<div class="col-sm-6 text-right">
					<a class="back-link" href="#forgot-password-form-wrapper<?php echo esc_attr($rand); ?>" title="<?php esc_attr_e('Forgot Password','superio'); ?>"><?php echo esc_html__("Lost Your Password?",'superio'); ?></a>
				</div>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-theme btn-block" name="submit" value="<?php esc_attr_e('Login','superio'); ?>"/>
			</div>
			<?php
				do_action('login_form');
				wp_nonce_field('ajax-login-nonce', 'security_login');
			?>
			<?php if ( $popup ) { ?>
				<div class="register-info">
					<?php esc_html_e('Don\'t you have an account?', 'superio'); ?>
					<a class="apus-user-register" href="#apus_register_form">
	                    <?php esc_html_e('Register', 'superio'); ?>
	                </a>
	            </div>
	        <?php } ?>
		</form>
	</div>
	<!-- reset form -->
	<div id="forgot-password-form-wrapper<?php echo esc_attr($rand); ?>" class="form-container forgotpassword-form-wrapper">
		<div class="top-info-user text-center1">
			<h3 class="title"><?php echo esc_html__('Reset Password', 'superio'); ?></h3>
			<div class="des"><?php echo esc_html__('Please Enter Username or Email','superio') ?></div>
		</div>
		<form name="forgotpasswordform" class="forgotpassword-form" action="<?php echo esc_url( site_url('wp-login.php?action=lostpassword', 'login_post') ); ?>" method="post">
			<div class="lostpassword-fields">
				<div class="form-group">
					<input type="text" name="user_login" class="user_login form-control" id="lostpassword_username" placeholder="<?php esc_attr_e('Username or E-mail','superio'); ?>">
				</div>
				<?php
					do_action('lostpassword_form');
					wp_nonce_field('ajax-lostpassword-nonce', 'security_lostpassword');
				?>

	            <div id="recaptcha-contact-form" class="ga-recaptcha" data-sitekey="<?php echo esc_attr(wp_job_board_pro_get_option( 'recaptcha_site_key' )); ?>"></div>
		      	
				<div class="form-group">
					<div class="row">
						<div class="col-xs-6"><input type="submit" class="btn btn-theme btn-sm btn-block" name="wp-submit" value="<?php esc_attr_e('Get New Password', 'superio'); ?>" tabindex="100" /></div>
						<div class="col-xs-6"><input type="button" class="btn btn-danger btn-sm btn-block btn-cancel" value="<?php esc_attr_e('Cancel', 'superio'); ?>" tabindex="101" /></div>
					</div>
				</div>
			</div>
			<div class="lostpassword-link"><a href="#login-form-wrapper<?php echo esc_attr($rand); ?>" class="back-link"><?php echo esc_html__('Back To Login', 'superio'); ?></a></div>
		</form>
	</div>
</div>
