<?php
/**
 * Template Name: Login & Register
 * Frontend login/registration page template.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
	exit;
}

$auth_errors = array();
$auth_success = '';

if ('POST' === $_SERVER['REQUEST_METHOD'] && isset($_POST['brainworks_auth_action'])) {
	$action = sanitize_key(wp_unslash($_POST['brainworks_auth_action']));

	if (!isset($_POST['brainworks_auth_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['brainworks_auth_nonce'])), 'brainworks_auth_form')) {
		$auth_errors[] = esc_html__('Security check failed. Please try again.', 'brainworks');
	} else {
		if ('login' === $action) {
			$user_login = isset($_POST['log']) ? sanitize_text_field(wp_unslash($_POST['log'])) : '';
			$user_pass = isset($_POST['pwd']) ? (string) wp_unslash($_POST['pwd']) : '';
			$remember = !empty($_POST['rememberme']);

			if ('' === $user_login || '' === $user_pass) {
				$auth_errors[] = esc_html__('Please fill in username/email and password.', 'brainworks');
			} else {
				$creds = array(
					'user_login'    => $user_login,
					'user_password' => $user_pass,
					'remember'      => $remember,
				);
				$user = wp_signon($creds, is_ssl());

				if (is_wp_error($user)) {
					$auth_errors[] = $user->get_error_message();
				} else {
					wp_set_current_user($user->ID);
					do_action('wp_login', $user->user_login, $user);
					wp_safe_redirect(home_url('/'));
					exit;
				}
			}
		}

		if ('register' === $action) {
			if (!get_option('users_can_register')) {
				$auth_errors[] = esc_html__('User registration is currently disabled.', 'brainworks');
			} else {
				$username = isset($_POST['user_login']) ? sanitize_user(wp_unslash($_POST['user_login']), true) : '';
				$email = isset($_POST['user_email']) ? sanitize_email(wp_unslash($_POST['user_email'])) : '';
				$password = isset($_POST['user_pass']) ? (string) wp_unslash($_POST['user_pass']) : '';
				$password_confirm = isset($_POST['user_pass_confirm']) ? (string) wp_unslash($_POST['user_pass_confirm']) : '';

				if ('' === $username || '' === $email || '' === $password || '' === $password_confirm) {
					$auth_errors[] = esc_html__('Please fill in all registration fields.', 'brainworks');
				} elseif (!is_email($email)) {
					$auth_errors[] = esc_html__('Please enter a valid email address.', 'brainworks');
				} elseif ($password !== $password_confirm) {
					$auth_errors[] = esc_html__('Passwords do not match.', 'brainworks');
				} elseif (username_exists($username)) {
					$auth_errors[] = esc_html__('This username is already taken.', 'brainworks');
				} elseif (email_exists($email)) {
					$auth_errors[] = esc_html__('This email is already registered.', 'brainworks');
				} else {
					$user_id = wp_create_user($username, $password, $email);
					if (is_wp_error($user_id)) {
						$auth_errors[] = $user_id->get_error_message();
					} else {
						$auth_success = esc_html__('Registration successful. You can now sign in.', 'brainworks');
					}
				}
			}
		}
	}
}

get_header();
?>

<div class="site-content site-content--full-width auth-page">
	<main class="site-main auth-page__main">
		<?php while (have_posts()): the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('auth-page__article'); ?>>
				<header class="entry-header auth-page__header">
					<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
				</header>
				<div class="entry-content auth-page__content">
					<?php the_content(); ?>

					<?php if (is_user_logged_in()): ?>
						<div class="auth-page__notice auth-page__notice--success">
							<?php
							printf(
								esc_html__('You are already logged in as %s.', 'brainworks'),
								'<strong>' . esc_html(wp_get_current_user()->display_name) . '</strong>'
							);
							?>
						</div>
					<?php else: ?>
						<?php if (!empty($auth_errors)): ?>
							<div class="auth-page__notice auth-page__notice--error">
								<ul>
									<?php foreach ($auth_errors as $error): ?>
										<li><?php echo wp_kses_post($error); ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>

						<?php if ('' !== $auth_success): ?>
							<div class="auth-page__notice auth-page__notice--success"><?php echo esc_html($auth_success); ?></div>
						<?php endif; ?>

						<div class="auth-page__grid">
							<section class="auth-card auth-card--login">
								<h2><?php esc_html_e('Sign In', 'brainworks'); ?></h2>
								<form method="post" action="<?php echo esc_url(get_permalink()); ?>" class="auth-form auth-form--login">
									<p>
										<label for="auth-log"><?php esc_html_e('Username or Email', 'brainworks'); ?></label>
										<input id="auth-log" type="text" name="log" required>
									</p>
									<p>
										<label for="auth-pwd"><?php esc_html_e('Password', 'brainworks'); ?></label>
										<input id="auth-pwd" type="password" name="pwd" required>
									</p>
									<p class="auth-form__remember">
										<label><input type="checkbox" name="rememberme" value="forever"> <?php esc_html_e('Remember me', 'brainworks'); ?></label>
									</p>
									<?php wp_nonce_field('brainworks_auth_form', 'brainworks_auth_nonce'); ?>
									<input type="hidden" name="brainworks_auth_action" value="login">
									<p><button type="submit"><?php esc_html_e('Login', 'brainworks'); ?></button></p>
								</form>
							</section>

							<section class="auth-card auth-card--register">
								<h2><?php esc_html_e('Create Account', 'brainworks'); ?></h2>
								<?php if (!get_option('users_can_register')): ?>
									<p><?php esc_html_e('Registration is disabled on this site.', 'brainworks'); ?></p>
								<?php else: ?>
									<form method="post" action="<?php echo esc_url(get_permalink()); ?>" class="auth-form auth-form--register">
										<p>
											<label for="auth-user-login"><?php esc_html_e('Username', 'brainworks'); ?></label>
											<input id="auth-user-login" type="text" name="user_login" required>
										</p>
										<p>
											<label for="auth-user-email"><?php esc_html_e('Email', 'brainworks'); ?></label>
											<input id="auth-user-email" type="email" name="user_email" required>
										</p>
										<p>
											<label for="auth-user-pass"><?php esc_html_e('Password', 'brainworks'); ?></label>
											<input id="auth-user-pass" type="password" name="user_pass" required>
										</p>
										<p>
											<label for="auth-user-pass-confirm"><?php esc_html_e('Confirm Password', 'brainworks'); ?></label>
											<input id="auth-user-pass-confirm" type="password" name="user_pass_confirm" required>
										</p>
										<?php wp_nonce_field('brainworks_auth_form', 'brainworks_auth_nonce'); ?>
										<input type="hidden" name="brainworks_auth_action" value="register">
										<p><button type="submit"><?php esc_html_e('Register', 'brainworks'); ?></button></p>
									</form>
								<?php endif; ?>
							</section>
						</div>
					<?php endif; ?>
				</div>
			</article>
		<?php endwhile; ?>
	</main>
</div>

<?php
get_footer();
