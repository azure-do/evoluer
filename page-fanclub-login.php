<?php
/*
Template Name: Fanclub (Member) - Login
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style(
	'fanclub-login-page',
	get_template_directory_uri() . '/assets/css/fanclub-login-page.css',
	array(),
	'1.0.0'
);
?>

<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php wp_head(); ?>
</head>
<body class="fanclub-login-page">
	<div class="fanclub-login-fanclub-name">
		中村米吉official fan club
	</div>

	<div class="fanclub-login-wrap">
		<div class="fanclub-login-panel">
			<div class="fanclub-login-title-wrap">
				<span class="fanclub-login-title-bg" aria-hidden="true"></span>
				<h1 class="fanclub-login-title">ログイン</h1>
			</div>

			<?php
			// Resolve register / lost password URLs from PMS (so links stay correct).
			$register_url = home_url( '/register/' );
			$lost_url     = home_url( '/lost-password/' );
			if ( function_exists( 'pms_get_page' ) ) {
				$reg_page  = pms_get_page( 'register', true );
				$lost_page = pms_get_page( 'lost-password', true );
				if ( ! empty( $reg_page ) ) {
					$register_url = $reg_page;
				}
				if ( ! empty( $lost_page ) ) {
					$lost_url = $lost_page;
				}
			}
			?>

			<div class="fanclub-login-terms">
				会員規約及びプライバシーポリシーに同意の上、ログインをお進めください。
			</div>

			<div class="fanclub-login-form">
				<?php
				// block="true" ensures the form is shown even when the user is logged-in.
				// Styling is applied via page-scoped CSS.
				echo do_shortcode( '[pms-login block="true" redirect_url="' . esc_url_raw( home_url( '/fanclub/' ) ) . '" logout_redirect_url="' . esc_url_raw( home_url( '/fc-entry/login/' ) ) . '" register_url="" lostpassword_url="" ]' );
				?>
			</div>

			<div class="fanclub-login-forgot">
				<a href="<?php echo esc_url( $lost_url ); ?>">
					パスワードを忘れた方はこちら
				</a>
			</div>

			<hr class="fanclub-login-divider" />

			<div class="fanclub-login-new-member">
				新規入会をご希望の方
			</div>

			<a class="fanclub-login-signup-btn" href="<?php echo esc_url( $register_url ); ?>">
				ご入会はこちらから
			</a>
		</div>
	</div>

	<?php wp_footer(); ?>
</body>
</html>

