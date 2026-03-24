<?php
//************************************************
// wp_headの削除
//************************************************
remove_action('wp_head', 'feed_links_extra', 3);			// Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2);					// Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link');						// Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link');				// Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link');					// index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0);	// prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0);		// start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);	// Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator');					// Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

// ファンクラブ用カスタム投稿タイプ（内部名）
if (! defined('EVOLUER_PT_FANCLUB_NEWS')) {
	define('EVOLUER_PT_FANCLUB_NEWS', 'fcnews');
}
if (! defined('EVOLUER_PT_FANCLUB_TICKET')) {
	define('EVOLUER_PT_FANCLUB_TICKET', 'ticket');
}

/**
 * fc-news / fc-ticket から fcnews / ticket へ DB を移行（1回のみ）。
 */
function evoluer_maybe_migrate_fanclub_cpt_slugs()
{
	$version = (int) get_option('evoluer_fanclub_cpt_slug_version', 0);
	if ($version >= 2) {
		return;
	}
	global $wpdb;
	$wpdb->update($wpdb->posts, array('post_type' => EVOLUER_PT_FANCLUB_NEWS), array('post_type' => 'fc-news'), array('%s'), array('%s'));
	$wpdb->update($wpdb->posts, array('post_type' => EVOLUER_PT_FANCLUB_TICKET), array('post_type' => 'fc-ticket'), array('%s'), array('%s'));
	update_option('evoluer_fanclub_cpt_slug_version', 2);
	update_option('evoluer_flush_rewrite_rules_flag', '1');
}

/**
 * ファンクラブ CPT の /fanclub/{artist}/news|ticket|… リライト・リダイレクト。
 */
require_once get_template_directory() . '/inc/fanclub-cpt-rewrites.php';


//************************************************
// 親子関係の取得
//************************************************
function page_is_ancestor_of($slug)
{
	global $post;
	// 親か判別したい固定ページスラッグからページ情報を取得
	$page = get_page_by_path($slug);
	$result = false;
	if (isset($page)) {
		foreach ((array)$post->ancestors as $ancestor) {
			if ($ancestor == $page->ID) {
				$result = true;
			}
		}
	}
	return $result;
}


//************************************************
// ファンクラブ URL → fc-fanclub ターム（shibuki / yonekichi など）
//************************************************
/**
 * Request path without subdirectory (e.g. evoluer/fanclub/shibuki/gallery → fanclub/shibuki/gallery).
 *
 * @return string
 */
function evoluer_get_fanclub_request_path()
{
	$path = trim((string) parse_url(isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '', PHP_URL_PATH), '/');
	$site_path = trim((string) parse_url(home_url('/'), PHP_URL_PATH), '/');
	if ($site_path !== '' && 0 === strpos($path, $site_path . '/')) {
		$path = trim(substr($path, strlen($site_path)), '/');
	}
	return $path;
}

/**
 * Whether to load fc-movie-player.js (custom play + fullscreen on .js-fc-movie-card).
 * Uses request path so hub pages work even when is_page_template() does not match the PHP filename.
 *
 * @return bool
 */
function evoluer_should_enqueue_fc_movie_player()
{
	if (is_post_type_archive('fc-movie')) {
		return true;
	}
	if (is_page_template(array('page-movie.php', 'page-yonekichi.php', 'page-shibuki.php'))) {
		return true;
	}
	$path = evoluer_get_fanclub_request_path();
	if ($path === '') {
		return false;
	}
	// Hub and all subpaths: /fanclub/yonekichi/ … /fanclub/shibuki/movie/ …
	if (preg_match('#^fanclub/(yonekichi|shibuki)(/|$)#', $path)) {
		return true;
	}
	// Short URLs without fanclub prefix (theme rewrites)
	if (preg_match('#^(yonekichi|shibuki)(/|$)#', $path)) {
		return true;
	}

	return false;
}

/**
 * Enqueue shared fc-movie-player script (safe to call from templates before get_header).
 *
 * @return void
 */
function evoluer_enqueue_fc_movie_player_script()
{
	static $done = false;
	if ($done || is_admin()) {
		return;
	}
	$file = get_template_directory() . '/assets/js/fc-movie-player.js';
	if (! file_exists($file)) {
		return;
	}
	$done = true;
	wp_enqueue_script(
		'evoluer-fc-movie-player',
		get_template_directory_uri() . '/assets/js/fc-movie-player.js',
		array(),
		filemtime($file),
		true
	);
}

/**
 * Map artist segment in URL to fc-fanclub term slug (fanclub_yonekichi / fanclub_shibuki).
 * Filter: evoluer_fanclub_artist_slug_to_term
 *
 * @return string 'fanclub_yonekichi'|'fanclub_shibuki'
 */
function evoluer_fanclub_term_slug_for_request()
{
	$map = apply_filters(
		'evoluer_fanclub_artist_slug_to_term',
		array(
			// fanclub_yonekichi = 中村米吉（yonekichi） / fanclub_shibuki = 紫吹（shibuki）
			'yonekichi' => 'fanclub_yonekichi',
			'shibuki'   => 'fanclub_shibuki',
		)
	);

	$path  = evoluer_get_fanclub_request_path();
	$parts = array_values(array_filter(explode('/', $path)));

	// /fanclub/shibuki/gallery/ …
	if (isset($parts[0], $parts[1]) && 'fanclub' === $parts[0] && isset($map[$parts[1]])) {
		return $map[$parts[1]];
	}

	// /shibuki/ … (no fanclub prefix)
	if (isset($parts[0]) && isset($map[$parts[0]])) {
		return $map[$parts[0]];
	}

	// Fallback: EFM page IDs (member hub pages)
	if (is_page()) {
		$pid         = (int) get_queried_object_id();
		$fanclub_y_id = (int) get_option('efm_page_fanclub_yonekichi_id', 0);
		$fanclub_s_id = (int) get_option('efm_page_fanclub_shibuki_id', 0);
		if ($pid > 0 && $fanclub_y_id > 0 && $pid === $fanclub_y_id) {
			return 'fanclub_yonekichi';
		}
		if ($pid > 0 && $fanclub_s_id > 0 && $pid === $fanclub_s_id) {
			return 'fanclub_shibuki';
		}
	}

	$user = wp_get_current_user();
	if ($user && $user->exists()) {
		$roles = (array) $user->roles;
		if (in_array('fanclub_shibuki', $roles, true)) {
			return 'fanclub_shibuki';
		}
	}

	return 'fanclub_yonekichi';
}

/**
 * Return taxonomy term slugs to query for the current request.
 *
 * @return array<int, string>
 */
function evoluer_fanclub_term_slugs_for_request()
{
	$term = function_exists('evoluer_fanclub_term_slug_for_request')
		? evoluer_fanclub_term_slug_for_request()
		: 'fanclub_yonekichi';

	if ('fanclub_shibuki' === $term) {
		return array('fanclub_shibuki');
	}

	return array('fanclub_yonekichi');
}

/**
 * Base URL for current artist hub (e.g. /fanclub/yonekichi/) for "もっと見る" links.
 *
 * @return string Trailing slash URL.
 */
function evoluer_fanclub_artist_base_url()
{
	$map = apply_filters(
		'evoluer_fanclub_artist_slug_to_term',
		array(
			'yonekichi' => 'fanclub_yonekichi',
			'shibuki'   => 'fanclub_shibuki',
		)
	);

	$path  = evoluer_get_fanclub_request_path();
	$parts = array_values(array_filter(explode('/', $path)));

	if (isset($parts[0], $parts[1]) && 'fanclub' === $parts[0] && isset($map[$parts[1]])) {
		return trailingslashit(home_url('/fanclub/' . $parts[1]));
	}

	if (isset($parts[0]) && isset($map[$parts[0]])) {
		return trailingslashit(home_url('/fanclub/' . $parts[0]));
	}

	if (is_page()) {
		$pid         = (int) get_queried_object_id();
		$fanclub_y_id = (int) get_option('efm_page_fanclub_yonekichi_id', 0);
		$fanclub_s_id = (int) get_option('efm_page_fanclub_shibuki_id', 0);
		if ($pid > 0 && $fanclub_y_id > 0 && $pid === $fanclub_y_id) {
			return trailingslashit(home_url('/fanclub/yonekichi/'));
		}
		if ($pid > 0 && $fanclub_s_id > 0 && $pid === $fanclub_s_id) {
			return trailingslashit(home_url('/fanclub/shibuki/'));
		}
	}

	$user = wp_get_current_user();
	if ($user && $user->exists()) {
		$roles = (array) $user->roles;
		if (in_array('fanclub_shibuki', $roles, true)) {
			return trailingslashit(home_url('/fanclub/shibuki/'));
		}
	}

	return trailingslashit(home_url('/fanclub/yonekichi/'));
}

/**
 * 会員エリア表示名（EFM 会員番号 000001様）。プラグイン未使用時は表示名。
 *
 * @return string
 */
function evoluer_fanclub_member_display_sama()
{
	if (! is_user_logged_in()) {
		return 'Member';
	}
	if (! class_exists('EFM_Membership')) {
		$u = wp_get_current_user();

		return $u && $u->exists() ? $u->display_name : 'Member';
	}

	$term = function_exists('evoluer_fanclub_term_slug_for_request') ? evoluer_fanclub_term_slug_for_request() : 'fanclub_yonekichi';
	$plan = EFM_Membership::plan_type_from_fanclub_term_slug($term);
	$row  = EFM_Membership::get_active_member_row_for_plan(get_current_user_id(), $plan);
	if (! $row) {
		$row = EFM_Membership::get_any_active_member_row(get_current_user_id());
	}
	if ($row) {
		return EFM_Membership::format_member_number_sama((int) $row->id);
	}

	$u = wp_get_current_user();

	return $u && $u->exists() ? $u->display_name : 'Member';
}

/**
 * 有効期限の残り日数が 0〜30 日のときのみ「会員期間は今後X日…」を返す。
 *
 * @return string HTML（空文字のときは非表示）。
 */
function evoluer_fanclub_member_period_notice_html()
{
	if (! is_user_logged_in() || ! class_exists('EFM_Membership')) {
		return '';
	}

	$term = function_exists('evoluer_fanclub_term_slug_for_request') ? evoluer_fanclub_term_slug_for_request() : 'fanclub_yonekichi';
	$plan = EFM_Membership::plan_type_from_fanclub_term_slug($term);
	$row  = EFM_Membership::get_active_member_row_for_plan(get_current_user_id(), $plan);
	if (! $row) {
		$row = EFM_Membership::get_any_active_member_row(get_current_user_id());
	}
	if (! $row || empty($row->payment_end)) {
		return '';
	}

	$end = strtotime($row->payment_end);
	if (! $end) {
		return '';
	}

	$days_left = (int) floor(($end - time()) / DAY_IN_SECONDS);
	if ($days_left < 0 || $days_left > 30) {
		return '';
	}

	$days_show = max(0, $days_left);

	return '<p class="text-[#7A7A7A] text-[14px] md:text-[16px] mb-[26px]">会員期間は今後' . esc_html((string) $days_show) . '日残りしました。</p>';
}

/**
 * ファンクラブ NEWS アーカイブ URL（/fanclub/{artist}/news/ … 現在のアーティスト文脈に合わせる）。
 *
 * @return string
 */
function evoluer_fanclub_fcnews_archive_url()
{
	$base = untrailingslashit(evoluer_fanclub_artist_base_url());

	return trailingslashit($base . '/news');
}

/**
 * ファンクラブ Ticket アーカイブ URL（/fanclub/{artist}/ticket/）。
 *
 * @return string
 */
function evoluer_fanclub_ticket_archive_url()
{
	$base = untrailingslashit(evoluer_fanclub_artist_base_url());

	return trailingslashit($base . '/ticket');
}

/**
 * NEWS 一覧へ（アーカイブ fcnews）。
 *
 * @return string
 */
function evoluer_fanclub_news_list_url()
{
	return evoluer_fanclub_fcnews_archive_url();
}

/**
 * Ticket 一覧へ（アーカイブ ticket）。
 *
 * @return string
 */
function evoluer_fanclub_ticket_list_url()
{
	return evoluer_fanclub_ticket_archive_url();
}

/**
 * ファンクラブ Gallery アーカイブ URL（/fanclub/{artist}/gallery/）。
 *
 * @return string
 */
function evoluer_fanclub_fcgallery_archive_url()
{
	$base = untrailingslashit(evoluer_fanclub_artist_base_url());

	return trailingslashit($base . '/gallery');
}

/**
 * ファンクラブ Movie アーカイブ URL（/fanclub/{artist}/movie/）。
 *
 * @return string
 */
function evoluer_fanclub_fc_movie_archive_url()
{
	$base = untrailingslashit(evoluer_fanclub_artist_base_url());

	return trailingslashit($base . '/movie');
}

/**
 * Back button HTML to current fanclub hub (/fanclub/{artist}/).
 *
 * @param string $label Button label.
 * @return string
 */
function evoluer_fanclub_back_to_hub_button_html($label = 'ファンクラブTOPへ戻る')
{
	$url = function_exists('evoluer_fanclub_artist_base_url')
		? evoluer_fanclub_artist_base_url()
		: home_url('/fanclub/');

	return '<a href="' . esc_url($url) . '" class="inline-flex items-center gap-[6px] !text-[#13AA05] text-[14px] md:text-[15px] underline underline-offset-[3px] hover:opacity-80"><span> ‹ </span><span>' . esc_html($label) . '</span></a>';
}

/**
 * フッター等：アーティスト固定の一覧 URL（中村米吉=yonekichi=fanclub_yonekichi / 紫吹=shibuki=fanclub_shibuki）。
 * 文脈依存の evoluer_fanclub_*_archive_url() とは別に、列ごとに明示する。
 *
 * @param string $artist_slug `yonekichi`（中村米吉=fanclub_yonekichi）|`shibuki`（紫吹=fanclub_shibuki）
 * @param string $segment     `news`|`ticket`|`movie`|`gallery`
 * @return string /fanclub/{artist}/{segment}/
 */
function evoluer_fanclub_hub_section_url($artist_slug, $segment)
{
	$artists = apply_filters('evoluer_fanclub_artist_slugs', array('yonekichi', 'shibuki'));
	if (! in_array($artist_slug, $artists, true)) {
		$artist_slug = 'yonekichi';
	}
	$segments = array('news', 'ticket', 'movie', 'gallery');
	if (! in_array($segment, $segments, true)) {
		return trailingslashit(home_url('/fanclub/' . $artist_slug));
	}

	return trailingslashit(home_url('/fanclub/' . $artist_slug . '/' . $segment));
}


//************************************************
// スタイルシートとjsファイルの管理
//************************************************
function add_files()
{

	//CSSの設定
	// Tailwind build output (generated by `npm run dev` / `npm run build`)
	$tailwind_css_rel  = '/dist/output.css';
	$tailwind_css_path = get_template_directory() . $tailwind_css_rel;
	$tailwind_css_ver  = file_exists($tailwind_css_path) ? filemtime($tailwind_css_path) : null;
	wp_enqueue_style('tailwindcss', get_template_directory_uri() . $tailwind_css_rel, array(), $tailwind_css_ver);

	// Site styles (keep these after Tailwind so they can override utilities when needed)
	wp_enqueue_style('stylecss', get_template_directory_uri() . '/assets/css/style.css', array('tailwindcss'));

	if (is_home()) {
		wp_enqueue_style('indexcss', get_template_directory_uri() . '/assets/css/index.css');
		wp_enqueue_style('slickcss', get_template_directory_uri() . '/assets/css/slick.css');
		wp_enqueue_style('slickthemecss', get_template_directory_uri() . '/assets/css/slick-theme.css');
	}
	// elseif (is_singular('fc-entry')) {
	// 	wp_enqueue_style('form_commoncss', get_template_directory_uri() . '/assets/css/form_common.css');
	// 	wp_enqueue_style('fanclubcss', get_template_directory_uri() . '/assets/css/fanclub.css');
	// } 
	elseif (is_singular('artist')) {
		wp_enqueue_style('artistcss', get_template_directory_uri() . '/assets/css/artist.css');
		wp_enqueue_style('slickcss', get_template_directory_uri() . '/assets/css/slick.css');
		wp_enqueue_style('slickthemecss', get_template_directory_uri() . '/assets/css/slick-theme.css');
	} elseif (is_post_type_archive('news') || is_singular('news')) {
		wp_enqueue_style('newscss', get_template_directory_uri() . '/assets/css/news.css');
	} elseif (is_page('privacy') || is_page('commerce')) {
		wp_enqueue_style('privacycss', get_template_directory_uri() . '/assets/css/privacy.css');
	} elseif (is_page('company')) {
		wp_enqueue_style('companycss', get_template_directory_uri() . '/assets/css/company.css');
	} elseif (is_page('sitemap')) {
		wp_enqueue_style('sitemapcss', get_template_directory_uri() . '/assets/css/sitemap.css');
	} elseif (is_page('contact')) {
		wp_enqueue_style('form_commoncss', get_template_directory_uri() . '/assets/css/form_common.css');
		wp_enqueue_style('contactcss', get_template_directory_uri() . '/assets/css/contact.css');
	}

	//JavaScriptの設定 管理画面外で読み込む
	if (!is_admin()) {
		wp_deregister_script('jquery');	// WordPress本体のjquery.jsを読み込まない
		wp_enqueue_script('cdn-jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '', true);
		wp_enqueue_script('viewportjs', get_template_directory_uri() . '/assets/js/viewport-mini.js', array(), false, true);
		wp_enqueue_script('commonjs', get_template_directory_uri() . '/assets/js/common.js', array(), false, true);
		$offcanvas_js = get_template_directory() . '/assets/js/header-offcanvas.js';
		if (file_exists($offcanvas_js)) {
			wp_enqueue_script(
				'evoluer-header-offcanvas',
				get_template_directory_uri() . '/assets/js/header-offcanvas.js',
				array(),
				filemtime($offcanvas_js),
				true
			);
		}

		if (is_home() || is_page('feature')) {
			wp_enqueue_script('indexjs', get_template_directory_uri() . '/assets/js/index.js', array(), false, true);
			wp_enqueue_script('slickjs', get_template_directory_uri() . '/assets/js/slick.min.js', array(), false, true);
		} elseif (is_page('contact')) {
			wp_enqueue_script('validjs', get_template_directory_uri() . '/assets/js/validation.js', array(), false, true);
			wp_enqueue_script('contactjs', get_template_directory_uri() . '/assets/js/contact.js', array(), false, true);
		}
		// elseif (is_singular('fc-entry')) {
		// 	wp_enqueue_script('ajaxzip3js', get_template_directory_uri() . '/assets/js/ajaxzip3.js', array(), false, true);
		// 	wp_enqueue_script('validjs', get_template_directory_uri() . '/assets/js/validation.js', array(), false, true);
		// 	wp_enqueue_script('fcentryjs', get_template_directory_uri() . '/assets/js/fcentry.js', array(), false, true);
		// } 
		elseif (is_singular('artist')) {
			wp_enqueue_script('slickjs', get_template_directory_uri() . '/assets/js/slick.min.js', array(), false, true);
			wp_enqueue_script('artistjs', get_template_directory_uri() . '/assets/js/artist.js', array(), false, true);
		} elseif (evoluer_should_enqueue_fc_movie_player()) {
			evoluer_enqueue_fc_movie_player_script();
		}
	}
}
add_action('wp_enqueue_scripts', 'add_files');


//************************************************
// バージョン表記を消す
//************************************************
function remove_cssjs_ver($src)
{
	if (strpos($src, '?ver='))
		$src = remove_query_arg('ver', $src);
	return $src;
}
add_filter('script_loader_src', 'remove_cssjs_ver', 10, 2);
add_filter('style_loader_src', 'remove_cssjs_ver', 10, 2);


//************************************************
// カスタム投稿ファイルの作成
//************************************************
function custom_post_types()
{
	evoluer_maybe_migrate_fanclub_cpt_slugs();

	$label    = 'タレント';
	$slug_a   = 'artist';
	$option_a = array(
		'label'  => $label,
		'labels' => array(
			'name'               => $label,
			'singular_name'      => $label,
			'add_new_item'       => $label . 'を追加',
			'add_new'            => '新規追加',
			'new_item'           => '新規' . $label,
			'view_item'          => $label . 'を表示',
			'not_found'          => $label . 'は見つかりませんでした',
			'not_found_in_trash' => 'ゴミ箱に' . $label . 'はありません。',
			'search_items'       => $label . 'を検索',
			'edit_item'          => $label . 'の編集',
			'view_item'          => $label . 'を表示',
			'all_items'          => $label . '一覧',
		),
		'capability_type' => 'post',
		'rewrite'         => array(
			'slug'       => $slug_a,
			'with_front' => false
		),
		'public'       => true,
		'query_var'    => true,
		'has_archive'  => true,
		'hierarchical' => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'supports'     => array(
			'title',
		),
	);
	register_post_type($slug_a, $option_a);

	$label    = '新着情報';
	$slug_n   = 'news';
	$option_n = array(
		'label'  => $label,
		'labels' => array(
			'name'               => $label,
			'singular_name'      => $label,
			'add_new_item'       => $label . 'を追加',
			'add_new'            => '新規追加',
			'new_item'           => '新規' . $label,
			'view_item'          => $label . 'を表示',
			'not_found'          => $label . 'は見つかりませんでした',
			'not_found_in_trash' => 'ゴミ箱に' . $label . 'はありません。',
			'search_items'       => $label . 'を検索',
			'edit_item'          => $label . 'の編集',
			'view_item'          => $label . 'を表示',
			'all_items'          => $label . '一覧',
		),
		'capability_type' => 'post',
		'rewrite'         => array(
			'slug'       => $slug_n,
			'with_front' => false
		),
		'public'       => true,
		'query_var'    => true,
		'has_archive'  => true,
		'hierarchical' => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'supports'     => array(
			'title',
			'editor',
		),
	);
	register_post_type($slug_n, $option_n);

	$label    = 'ファンクラブ・新着情報';
	$slug_nf   = EVOLUER_PT_FANCLUB_NEWS;
	$option_nf = array(
		'label'  => $label,
		'labels' => array(
			'name'               => $label,
			'singular_name'      => $label,
			'add_new_item'       => $label . 'を追加',
			'add_new'            => '新規追加',
			'new_item'           => '新規' . $label,
			'view_item'          => $label . 'を表示',
			'not_found'          => $label . 'は見つかりませんでした',
			'not_found_in_trash' => 'ゴミ箱に' . $label . 'はありません。',
			'search_items'       => $label . 'を検索',
			'edit_item'          => $label . 'の編集',
			'view_item'          => $label . 'を表示',
			'all_items'          => $label . '一覧',
		),
		'capability_type' => 'post',
		'rewrite'         => array(
			'slug'       => $slug_nf,
			'with_front' => false
		),
		'public'       => true,
		'query_var'    => true,
		'has_archive'  => true,
		'hierarchical' => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'supports'     => array(
			'title',
			'editor',
			'tags',
		),
	);

	register_post_type($slug_nf, $option_nf);
	$label    = 'ファンクラブ・画廊';
	$slug_nf   = 'fc-gallery';
	$option_nf = array(
		'label'  => $label,
		'labels' => array(
			'name'               => $label,
			'singular_name'      => $label,
			'add_new_item'       => $label . 'を追加',
			'add_new'            => '新規追加',
			'new_item'           => '新規' . $label,
			'view_item'          => $label . 'を表示',
			'not_found'          => $label . 'は見つかりませんでした',
			'not_found_in_trash' => 'ゴミ箱に' . $label . 'はありません。',
			'search_items'       => $label . 'を検索',
			'edit_item'          => $label . 'の編集',
			'view_item'          => $label . 'を表示',
			'all_items'          => $label . '一覧',
		),
		'capability_type' => 'post',
		'rewrite'         => array(
			'slug'       => $slug_nf,
			'with_front' => false
		),
		'public'       => true,
		'query_var'    => true,
		'has_archive'  => true,
		'hierarchical' => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'supports'     => array(
			'title',
			'editor',
			'tags',
		),
	);
	register_post_type($slug_nf, $option_nf);

	$label    = 'ファンクラブ・動画';
	$slug_nf   = 'fc-movie';
	$option_nf = array(
		'label'  => $label,
		'labels' => array(
			'name'               => $label,
			'singular_name'      => $label,
			'add_new_item'       => $label . 'を追加',
			'add_new'            => '新規追加',
			'new_item'           => '新規' . $label,
			'view_item'          => $label . 'を表示',
			'not_found'          => $label . 'は見つかりませんでした',
			'not_found_in_trash' => 'ゴミ箱に' . $label . 'はありません。',
			'search_items'       => $label . 'を検索',
			'edit_item'          => $label . 'の編集',
			'view_item'          => $label . 'を表示',
			'all_items'          => $label . '一覧',
		),
		'capability_type' => 'post',
		'rewrite'         => array(
			'slug'       => $slug_nf,
			'with_front' => false
		),
		'public'       => true,
		'query_var'    => true,
		'has_archive'  => true,
		'hierarchical' => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'supports'     => array(
			'title',
			'editor',
		),
	);
	register_post_type($slug_nf, $option_nf);

	$label    = 'ファンクラブ・チケット';
	$slug_nf   = EVOLUER_PT_FANCLUB_TICKET;
	$option_nf = array(
		'label'  => $label,
		'labels' => array(
			'name'               => $label,
			'singular_name'      => $label,
			'add_new_item'       => $label . 'を追加',
			'add_new'            => '新規追加',
			'new_item'           => '新規' . $label,
			'view_item'          => $label . 'を表示',
			'not_found'          => $label . 'は見つかりませんでした',
			'not_found_in_trash' => 'ゴミ箱に' . $label . 'はありません。',
			'search_items'       => $label . 'を検索',
			'edit_item'          => $label . 'の編集',
			'view_item'          => $label . 'を表示',
			'all_items'          => $label . '一覧',
		),
		'capability_type' => 'post',
		'rewrite'         => array(
			'slug'       => $slug_nf,
			'with_front' => false
		),
		'public'       => true,
		'query_var'    => true,
		'has_archive'  => true,
		'hierarchical' => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'supports'     => array(
			'title',
			'editor',
		),
	);
	register_post_type($slug_nf, $option_nf);

	// ファンクラブ種別カテゴリ（中村米吉/紫吹）カテゴリ：fc-fanclub を振り分ける
	$tax_label = 'ファンクラブ カテゴリー';
	$tax_slug  = 'fc-fanclub';
	$args_tf   = array(
		'labels' => array(
			'name'              => $tax_label,
			'singular_name'     => 'ファンクラブ',
			'search_items'      => $tax_label . 'を検索',
			'all_items'         => $tax_label . '一覧',
			'edit_item'         => $tax_label . 'の編集',
			'update_item'      => $tax_label . 'の更新',
			'add_new_item'     => '新規' . $tax_label,
			'menu_name'         => $tax_label,
		),
		'public'                => true,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'hierarchical'          => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'rewrite'               => array(
			'slug'       => $tax_slug,
			'with_front' => false,
		),
	);
	// Bind this taxonomy to fanclub news/gallery/movie/ticket post types.
	register_taxonomy($tax_slug, array(EVOLUER_PT_FANCLUB_NEWS, 'fc-gallery', 'fc-movie', EVOLUER_PT_FANCLUB_TICKET), $args_tf);

	// Create terms (new slugs) if they don't exist yet.
	$term_y = term_exists('fanclub_yonekichi', $tax_slug);
	if (0 === $term_y || null === $term_y) {
		wp_insert_term('中村米吉 official fan club', $tax_slug, array('slug' => 'fanclub_yonekichi'));
	}
	$term_s = term_exists('fanclub_shibuki', $tax_slug);
	if (0 === $term_s || null === $term_s) {
		wp_insert_term('紫吹 official fan club', $tax_slug, array('slug' => 'fanclub_shibuki'));
	}

	// Legacy term slugs intentionally removed; only new slugs are supported.

	$label    = '出演情報';
	$slug_s   = 'schedule';
	$option_s = array(
		'label'  => $label,
		'labels' => array(
			'name'               => $label,
			'singular_name'      => $label,
			'add_new_item'       => $label . 'を追加',
			'add_new'            => '新規追加',
			'new_item'           => '新規' . $label,
			'view_item'          => $label . 'を表示',
			'not_found'          => $label . 'は見つかりませんでした',
			'not_found_in_trash' => 'ゴミ箱に' . $label . 'はありません。',
			'search_items'       => $label . 'を検索',
			'edit_item'          => $label . 'の編集',
			'view_item'          => $label . 'を表示',
			'all_items'          => $label . '一覧',
		),
		'capability_type' => 'post',
		'rewrite'         => array(
			'slug'       => $slug_s,
			'with_front' => false
		),
		'public'       => true,
		'query_var'    => true,
		'has_archive'  => true,
		'hierarchical' => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'supports'     => array(
			'title'
		),
	);
	register_post_type($slug_s, $option_s);

	//カスタムタクソノミー
	$label    = '新着情報 カテゴリー';
	$args_n_c = array(
		'labels' => array(
			'name'                => $label,
			'singular_name'       => $label,
			'search_items'        => $label . 'を検索',
			'all_items'           => $label . '一覧',
			'parent_item'         => $label . 'の親カテゴリー',
			'parent_item_colon'   => $label . 'の親カテゴリー:',
			'edit_item'           => $label . 'の編集',
			'update_item'         => $label . 'の更新',
			'add_new_item'        => $label . 'を追加',
			'new_item_name'       => '新規' . $label,
			'menu_name'           => $label
		),
		'public'                => true,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'hierarchical'          => true,
		'update_count_callback' => '_update_post_term_count',
		'show_in_rest'          => true,
	);
	register_taxonomy('news-cat', $slug_n, $args_n_c);

	$label    = '出演情報 カテゴリー';
	$args_s_c = array(
		'labels' => array(
			'name'                => $label,
			'singular_name'       => $label,
			'search_items'        => $label . 'を検索',
			'all_items'           => $label . '一覧',
			'parent_item'         => $label . 'の親カテゴリー',
			'parent_item_colon'   => $label . 'の親カテゴリー:',
			'edit_item'           => $label . 'の編集',
			'update_item'         => $label . 'の更新',
			'add_new_item'        => $label . 'を追加',
			'new_item_name'       => '新規' . $label,
			'menu_name'           => $label
		),
		'public'                => true,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'hierarchical'          => true,
		'update_count_callback' => '_update_post_term_count',
	);
	register_taxonomy('schedule-cat', $slug_s, $args_s_c);
}
add_action('init', 'custom_post_types');

/** スラッグ変更後にリライトルールを再生成 */
add_action(
	'init',
	static function () {
		if (get_option('evoluer_flush_rewrite_rules_flag')) {
			flush_rewrite_rules(false);
			delete_option('evoluer_flush_rewrite_rules_flag');
		}
	},
	99
);

/** ファンクラブ NEWS / Ticket / Movie / Gallery アーカイブの表示件数（is_post_type_archive に依存しない） */
add_action(
	'pre_get_posts',
	static function ($query) {
		if (is_admin() || ! $query->is_main_query()) {
			return;
		}
		$post_type = $query->get('post_type');
		if (is_array($post_type)) {
			$post_type = reset($post_type);
		}
		if (empty($post_type)) {
			return;
		}
		$fanclub_archives = array(EVOLUER_PT_FANCLUB_NEWS, EVOLUER_PT_FANCLUB_TICKET, 'fc-movie', 'fc-gallery');
		if (! in_array($post_type, $fanclub_archives, true)) {
			return;
		}
		// 単一投稿は除外（/fanclub/.../news/slug/ など）。
		if ((string) $query->get('name') !== '' || (int) $query->get('p') > 0) {
			return;
		}
		$query->set('posts_per_page', 20);
	}
);

// If /fc-entry/* incorrectly resolves to the homepage, force the main query
// to the matching Page so it renders the correct template (no redirect loops).
add_action(
	'template_redirect',
	static function () {
		$path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');

		// If WordPress is installed in a subdirectory (e.g. /evoluer/), strip it.
		$site_path = trim(parse_url(home_url('/'), PHP_URL_PATH), '/');
		if ($site_path !== '' && 0 === strpos($path, $site_path . '/')) {
			$path = trim(substr($path, strlen($site_path) + 1), '/');
		}

		if ($path === '' || ($path !== 'fc-entry' && 0 !== strpos($path, 'fc-entry/'))) {
			return;
		}

		$page = get_page_by_path($path, OBJECT, 'page');
		// Also try just the last segment (in case pages are not hierarchical).
		if (! $page && false !== strpos($path, '/')) {
			$last = trim(substr($path, strrpos($path, '/') + 1), '/');
			if ($last !== '') {
				$page = get_page_by_path($last, OBJECT, 'page');
			}
		}

		if (! $page) {
			return;
		}

		// Already resolved correctly.
		if (is_page($page->ID)) {
			return;
		}

		// Force WP_Query to render the correct Page.
		global $wp_query, $post;

		$post = $page;
		setup_postdata($post);

		$wp_query->posts            = array($page);
		$wp_query->post             = $page;
		$wp_query->post_count      = 1;
		$wp_query->queried_object  = $page;

		$wp_query->is_home          = false;
		$wp_query->is_front_page   = false;
		$wp_query->is_page          = true;
		$wp_query->is_singular     = true;
		$wp_query->is_404          = false;
	},
	0
);


//************************************************
// 表示アイコンの変更
//************************************************
function add_menu_icons_styles()
{
	echo '<style>
		#adminmenu #menu-posts-news div.wp-menu-image:before {
			content: "\f488";
		}
	</style>';
}
add_action('admin_head', 'add_menu_icons_styles');


//************************************************
// 投稿キャプチャー画像と画像サイズを追加、削除する
//************************************************
add_theme_support('post-thumbnails');
add_image_size('artist_icon_mb', 304, 304, true);
add_image_size('artist_icon_pc', 120, 120, true);

function my_intermediate_image_sizes_advanced($sizes)
{
	unset($sizes['1536x1536']); // 1536pxの画像を停止
	unset($sizes['2048x2048']); // 2048pxの画像を停止
	unset($sizes['medium']);
	unset($sizes['medium_large']);
	unset($sizes['large']);
	return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'my_intermediate_image_sizes_advanced');

//****************************************
// 画像挿入のクラス等削除
//****************************************
function remove_img_attr($html, $id, $alt, $title, $align, $size)
{
	$html = preg_replace('/title=[\'"]([^\'"]+)[\'"]/i', '', $html);
	return preg_replace('/ class=[\'"]([^\'"]+)[\'"]/i', '', $html);
}
add_filter('get_image_tag', 'remove_img_attr', 10, 6);


//************************************************
// カスタム投稿のスラッグをIDに変更
//************************************************
function auto_post_slug($slug, $post_ID, $post_status, $post_type)
{
	if ($post_type == 'news' || $post_type == 'schedule') {
		$slug = utf8_uri_encode($post_type) . '-' . $post_ID;
	}
	return $slug;
}
add_filter('wp_unique_post_slug', 'auto_post_slug', 10, 4);


//************************************************
// タイトル入力のプレスホルダーを変更
//************************************************
function change_default_title($title)
{
	$screen = get_current_screen();
	if ($screen->post_type == 'post') {				//投稿
		$title = 'ブログのタイトルを入力';
	} elseif ($screen->post_type == 'page') {		//固定ページ
		$title = '固定ページのタイトルを入力';
	} elseif ($screen->post_type == 'artist') {		//カスタム投稿タイプ：artist
		$title = 'タレント名を入力';
	} elseif ($screen->post_type == 'news') {		//カスタム投稿タイプ：news
		$title = '新着情報のタイトルを入力';
	} elseif ($screen->post_type == 'schedule') {	//カスタム投稿タイプ：schedule
		$title = '出演情報のタイトルを入力';
	} elseif (defined('EVOLUER_PT_FANCLUB_NEWS') && $screen->post_type === EVOLUER_PT_FANCLUB_NEWS) {
		$title = 'ファンクラブ新着情報のタイトルを入力';
	} elseif (defined('EVOLUER_PT_FANCLUB_TICKET') && $screen->post_type === EVOLUER_PT_FANCLUB_TICKET) {
		$title = 'ファンクラブチケットのタイトルを入力';
	}
	return $title;
}
add_filter('enter_title_here', 'change_default_title');


//************************************************
// メニューの追加と並び替え
//************************************************
function my_custom_menu_order($menu_order)
{
	if (!$menu_order) return true;
	return array(
		'index.php',							//ダッシュボード
		'edit.php?post_type=artist',			//カスタムポスト
		'edit.php?post_type=news',				//カスタムポスト
		'edit.php?post_type=schedule',			//カスタムポスト
		'edit.php?post_type=' . EVOLUER_PT_FANCLUB_NEWS,			//ファンクラブ新着情報
		'edit.php?post_type=fc-gallery',		//ファンクラブ画廊
		'edit.php?post_type=fc-movie',			//ファンクラブ動画
		'edit.php?post_type=' . EVOLUER_PT_FANCLUB_TICKET,			//ファンクラブチケット
		'separator1',							//区切り線1
		'edit.php?post_type=page',				//固定ページ
		'upload.php', 							//メディア
		'separator2', 							//区切り線2
		'edit.php?post_type=mw-wp-form',		//コンタクトフォーム設定
		'edit.php?post_type=acf-field-group',	//カスタムフィールド設定
		'themes.php', 							//外観
		'plugins.php',							//プラグイン
		'users.php',							//ユーザー
		'tools.php',							//ツール
		'options-general.php',					//設定
		'separator3', 							//区切り線3
	);
}
add_filter('custom_menu_order', 'my_custom_menu_order');
add_filter('menu_order', 'my_custom_menu_order');


//************************************************
// 管理メニュー非表示管理
//************************************************
function remove_menus()
{
	global $menu;
	remove_menu_page('edit.php');				// 投稿を非表示
	remove_menu_page('edit-comments.php');	// コメント
}
add_action('admin_menu', 'remove_menus');


//************************************************
// 管理画面の投稿一覧追加
//************************************************
//* 投稿ID追加 */
function add_posts_columns_postid($columns)
{
	$columns['postid'] = 'ID';
	return $columns;
}
function add_posts_columns_postid_row($column_name, $post_id)
{
	if ('postid' == $column_name) {
		echo $post_id;
	}
}
add_filter('manage_posts_columns', 'add_posts_columns_postid');
add_action('manage_posts_custom_column', 'add_posts_columns_postid_row', 10, 2);

//* 出演情報 カテゴリー */
function add_schedule_columns_tax($columns)
{
	$columns['schedule-cat'] = '出演情報 タレント名';
	return $columns;
}
function add_schedule_columns_tax_row($column_name, $post_id)
{
	if ('schedule-cat' == $column_name) {
		$schedule_terms = get_the_terms($post_id, $column_name);
		$parent_term_id = $schedule_terms[0]->parent;
		if ($parent_term_id != 0) { //親カテゴリーではないならば
			$term = get_term($parent_term_id, $column_name);
			echo '<a href="' . admin_url() . 'edit.php?post_type=' . get_post_type() . '&' . $column_name . '=' . $term->slug . '">' . $term->name . '</a>';
		}
	}
}
function sort_custom_columns($columns)
{
	$columns = array(
		'cb'                    => '<input type="checkbox" />',
		'title'                 => 'タイトル',
		'schedule-cat'          => '出演情報 タレント名',
		'taxonomy-schedule-cat' => '出演情報 詳細',
		'date'                  => '日時'
	);
	return $columns;
}
add_filter('manage_schedule_posts_columns', 'add_schedule_columns_tax');
add_filter('manage_schedule_posts_columns', 'sort_custom_columns');
add_action('manage_schedule_posts_custom_column', 'add_schedule_columns_tax_row', 10, 2);

/* 絞り込みを追加 */
function schedule_cat_add_filter()
{
	global $post_type;
	if ('schedule' == $post_type) {
?>
		<select name="schedule-cat">
			<option value="">出演情報 タレントで絞り込み</option>
			<?php
			$args = array(
				'parent' => 0,
				'hierarchical' => true,
				'hide_empty' => false,
				'orderby' => 'term_order', // Category Order and Taxonomy Terms Order を使用
				'order' => 'ASC'
			);
			$terms = get_terms('schedule-cat', $args);
			foreach ($terms as $term) { ?>
				<option value="<?php echo $term->slug; ?>" <?php if ($_GET['schedule-cat'] == $term->slug) {
																											print 'selected';
																										} ?>><?php echo $term->name; ?></option>
			<?php
			}
			?>
		</select>
	<?php
	}
}
add_action('restrict_manage_posts', 'schedule_cat_add_filter');


//************************************************
// 親タームを選択できないようにする
//************************************************
require_once(ABSPATH . '/wp-admin/includes/template.php');
class Nocheck_Category_Checklist extends Walker_Category_Checklist
{
	function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0)
	{
		global $post_type;
		if ('schedule' == $post_type) {
			extract($args);
			if (empty($taxonomy))
				$taxonomy = 'category';
			if ($taxonomy == 'category')
				$name = 'post_category';
			else
				$name = 'tax_input[' . $taxonomy . ']';
			$class = in_array($category->term_id, $popular_cats) ? ' class="popular-category"' : '';
			$cat_child = get_term_children($category->term_id, $taxonomy);
			if (!empty($cat_child)) {
				$output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' . checked(in_array($category->term_id, $selected_cats), true, false) . disabled(empty($args['disabled']), true, false) . ' /> ' . esc_html(apply_filters('the_category', $category->name)) . '</label>';
			} else {
				$output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' . checked(in_array($category->term_id, $selected_cats), true, false) . disabled(empty($args['disabled']), false, false) . ' /> ' . esc_html(apply_filters('the_category', $category->name)) . '</label>';
			}
		} else {
		}
	}
}
function wp_category_terms_checklist_no_top($args, $post_id = null)
{
	global $post_type;
	if ('schedule' == $post_type) {
		$args['checked_ontop'] = false;
		$args['walker'] = new Nocheck_Category_Checklist();
	}
	return $args;
}
add_action('wp_terms_checklist_args', 'wp_category_terms_checklist_no_top');


//************************************************
// 自動保存停止
//************************************************
function disable_autosave()
{
	wp_deregister_script('autosave');
}
add_action('wp_print_scripts', 'disable_autosave');


//************************************************
// 自動整形機能を無効化
//************************************************
remove_filter('the_content', 'wpautop');    // 記事の自動整形を無効にする
remove_filter('the_excerpt', 'wpautop');    // 抜粋の自動整形を無効にする


//************************************************
// moreハッシュを削除
//************************************************
function remove_more_jump_link($link)
{
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"', $offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end - $offset);
	}
	return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');


//************************************************
// 管理バーを表示しない
//************************************************
add_filter('show_admin_bar', '__return_false');


//****************************************
// SmartCustomFields コード定義
//****************************************
function my_add_meta_box($settings, $type, $id, $meta_type)
{
	//投稿タイプで判定
	switch ($type) {
		case 'artist':
			$settings[] = add_scf_news_tax_group();
			$settings[] = add_scf_schedule_tax_group();
			break;
		default:
			break;
	}
	return $settings;
}
add_filter('smart-cf-register-fields', 'my_add_meta_box', 10, 4);

//****************************************
//　カスタム投稿 タレントのタイトル（タレント名）一覧を設定
//****************************************
function add_scf_artist_group()
{
	$args = array(
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'post_type'      => 'artist',
		'orderby'        => 'post_date',
		'order'          => 'DESC',
	);
	$artists = get_posts($args);
	if ($artists) {
		foreach ($artists as $artist) {
			$key           = 'no_' . $artist->ID;
			$field["$key"] = $artist->post_title;
		}
	}
	wp_reset_postdata();
	$setting = SCF::add_setting('meta_box_artist', 'タレント名');
	$items = array(
		array(
			'type'    => 'select',                 // タイプ
			'name'    => 'fc_select_artist',       // 名前
			'label'   => 'タレント名を指定する',
			'choices' => $field,
			'default' => '',
		),
	);
	$setting->add_group('cf_artist_group', false, $items);
	return $setting;
}

//****************************************
//　ニュースカテゴリ 一覧を設定
//****************************************
function add_scf_news_tax_group()
{
	$tax   = 'news-cat';
	$args  = array('hide_empty' => false);
	$terms = get_terms($tax, $args);
	$field = array('0' => '未選択');
	if ($terms && !is_wp_error($terms)) {
		foreach ($terms as $term) {
			$key           = $term->slug;
			$field["$key"] = $term->name;
		}
	}
	$setting = SCF::add_setting('meta_box_news_tax', '最新情報を表示するタレントを設定');
	$items = array(
		array(
			'type'    => 'select',                // タイプ
			'name'    => 'select_news_cat',       // 名前
			'label'   => 'タレント名',
			'choices' => $field,
			'default' => '',
		),
	);
	$setting->add_group('cf_news_tax_group', false, $items);
	return $setting;
}

//****************************************
//　スケジュールの親カテゴリ 一覧を設定
//****************************************
function add_scf_schedule_tax_group()
{
	$tax   = 'schedule-cat';
	$args  = array(
		'parent'     => 0,     // 親タームのみ
		'hide_empty' => false  // 投稿記事がないタームも取得
	);
	$terms = get_terms($tax, $args);
	$field = array('0' => '未選択');
	if ($terms && !is_wp_error($terms)) {
		foreach ($terms as $term) {
			$key           = $term->slug;
			$field["$key"] = $term->name;
		}
	}
	$setting = SCF::add_setting('meta_box_schedule_tax', 'スケジュール表示するタレントを設定');
	$items = array(
		array(
			'type'    => 'select',                 // タイプ
			'name'    => 'select_schedule_cat',    // 名前
			'label'   => 'タレント名',
			'choices' => $field,
			'default' => '',
		),
	);
	$setting->add_group('cf_schedule_tax_group', false, $items);
	return $setting;
}


//************************************************
// ファンクラブ入会フォーム読み込み時にタレント名を設定
//************************************************
function my_mwform_value($value, $name)
{
	if ($name === 'fanclub') {
		$return_val = $value;
		$artist_no  = post_custom('fc_select_artist', $_GET['post_id']);
		if ($artist_no) {
			$artist_no   = mb_substr($artist_no, 3);
			$return_val = get_the_title($artist_no);
		}
		return $return_val;
	}
	return $value;
}
add_filter('mwform_value_mw-wp-form-31', 'my_mwform_value', 10, 2);


//************************************************
// ファンクラブ入会フォーム readonly属性追加
//************************************************
function my_mwform_text_shortcode_tag($output, $tag, $attr)
{
	if ($tag == 'mwform_text' && $attr['name'] == 'fanclub') {
		$output = str_replace('<input ', '<input readonly ', $output);
	}
	return $output;
}
add_filter('do_shortcode_tag', 'my_mwform_text_shortcode_tag', 10, 3);


//************************************************
// ファンクラブ入会フォーム エラー文言設定
//************************************************
function fcentry_custom_mwform_error_message($error, $key, $rule)
{
	switch ($key) {
		case 'name':
			if ($rule === 'noempty') {
				return '氏名が未入力です。';
			}
			break;
		case 'kana':
			if ($rule === 'noempty') {
				return 'フリガナが未入力です。';
			} elseif ($rule === 'katakana') {
				return 'フリガナは全角カタカナで入力してください。';
			}
			break;
		case 'zip1':
			if ($rule === 'noempty') {
				return '郵便番号が未入力です。';
			}
			break;
		case 'zip2':
			if ($rule === 'noempty') {
				return '郵便番号が未入力です。';
			}
			break;
		case 'address':
			if ($rule === 'noempty') {
				return 'ご住所が未入力です。';
			}
			break;
		case 'tel':
			if ($rule === 'noempty') {
				return '電話番号が未入力です。';
			} elseif ($rule === 'numeric') {
				return '電話番号は半角数字で入力してください。';
			}
			break;
		case 'birth-year':
			if ($rule === 'numeric') {
				return '年は半角数字で入力してください。';
			}
			break;
		case 'birth-month':
			if ($rule === 'numeric') {
				return '月は半角数字で入力してください。';
			}
			break;
		case 'birth-day':
			if ($rule === 'numeric') {
				return '日は半角数字で入力してください。';
			}
			break;
		case 'email':
			if ($rule === 'noempty') {
				return 'メールアドレスが未入力です。';
			} elseif ($rule === 'mail') {
				return '入力いただいた内容はメールアドレスの形式ではありません。';
			}
			break;
	}
	return $error;
}
add_filter('mwform_error_message_mw-wp-form-31', 'contact_custom_mwform_error_message', 10, 3);

//************************************************
// お問い合わせフォーム エラー文言設定
//************************************************
function contact_custom_mwform_error_message($error, $key, $rule)
{
	switch ($key) {
		case 'cont_your-office':
			if ($rule === 'noempty') {
				return '会社名が未入力です。';
			}
			break;
		case 'cont_your-name':
			if ($rule === 'noempty') {
				return '氏名が未入力です。';
			}
			break;
		case 'cont_tel-code':
			if ($rule === 'noempty') {
				return '電話番号が未入力です。';
			} elseif ($rule === 'numeric') {
				return '電話番号は半角数字で入力してください。';
			}
			break;
		case 'cont_your-email':
			if ($rule === 'noempty') {
				return 'メールアドレスが未入力です。';
			} elseif ($rule === 'mail') {
				return '入力いただいた内容はメールアドレスの形式ではありません。';
			}
			break;
		case 'cont_your-message':
			if ($rule === 'noempty') {
				return 'お問い合わせ・ご依頼内容が未入力です。';
			}
			break;
	}
	return $error;
}
add_filter('mwform_error_message_mw-wp-form-30', 'contact_custom_mwform_error_message', 10, 3);


//************************************************
// 404回避
//************************************************
function category_link_custom($query = array())
{
	// 子カテゴリーの404を回避
	if (isset($query['category_name']) && strpos($query['category_name'], '/') === false && isset($query['name'])) {
		$parent_category = get_category_by_slug($query['category_name']);
		$child_categories = get_categories('child_of=' . $parent_category->term_id);
		foreach ($child_categories as $child_category) {
			if ($query['name'] === $child_category->category_nicename) {
				$query['category_name'] = $query['category_name'] . '/' . $query['name'];
				unset($query['name']);
			}
		}
	}
	// カテゴリーのページ送りを修正して404を回避
	if (isset($query['name']) && $query['name'] === 'page' && isset($query['page'])) {
		$paged = $query['page'];
		if (is_numeric($paged)) {
			$query['paged'] = (int) $paged;
			unset($query['name']);
			unset($query['page']);
		}
	}
	return $query;
}
add_filter('request', 'category_link_custom');


//****************************************
// ページネーション
//****************************************
function pagenation($max_page = '', $range = 2)
{
	$showitems = ($range * 1) + 1;
	global $paged;
	if (empty($paged)) $paged = 1;
	$now_page = $paged;

	if ($max_page == '') {
		global $wp_query;
		$max_page = $wp_query->max_num_pages;
		if (!$max_page) {
			$max_page = 1;
		}
	}
	if (1 != $max_page) {
		echo "<ul class=\"pagenation\">\n";
		// 「前へ」を表示
		if ($now_page > 1) {
			echo "  <li class=\"pagenation__num pager_item_prev\"><a href=\"" . get_pagenum_link() . "\" class=\"nav_link nav_link_prev\"><span>前へ</span></a></li>\n";
		}
		// ページ番号を出力
		for ($i = 1; $i <= $max_page; $i++) {
			if (1 != $max_page && (!($i >= $now_page + $range + 1 || $i <= $now_page - $range - 1) || $max_page <= $showitems)) {
				echo ($now_page == $i) ? "  <li class=\"pagenation__num current\"><a href=\"" . get_pagenum_link($i) . "\">" . $i . "</a></li>\n" : // 現在のページ
					"  <li class=\"pagenation__num\"><a href=\"" . get_pagenum_link($i) . "\">" . $i . "</a></li>\n";
			}
		}
		// 「次へ」を表示
		if ($now_page < $max_page) {
			echo "  <li class=\"pagenation__num pager_item_next\"><a href=\"" . get_pagenum_link($max_page) . "\" class=\"nav_link nav_link_next\"><span>次へ</span></a></li>\n";
		}
		echo "</ul>\n";
	}
}


//****************************************
// タイトルの必須化
//****************************************
function required_title()
{
	?>
	<script>
		jQuery(function($) {
			if ($('#post_type').val() == 'artist') {
				$('#post').submit(function(e) {
					if ($('#title').val() == '') {
						alert('タレント名を入力してください。');
						e.preventDefault();
					}
				});
			} else if ($('#post_type').val() == 'news' || $('#post_type').val() == 'schedule') {
				$('#post').submit(function(e) {
					if ($('#title').val() == '') {
						alert('タイトルを入力してください。');
						e.preventDefault();
					}
				});
			}
		});
	</script>
<?php
}
add_action('admin_head-post-new.php', 'required_title');
add_action('admin_head-post.php', 'required_title');


//****************************************
// WordPressのデフォルトファビコンを消す
//****************************************
add_action('do_faviconico', 'wp_favicon_remover');
function wp_favicon_remover()
{
	exit;
}


//****************************************
// 固定ページのエディタを非表示
//****************************************
add_filter('use_block_editor_for_post', function ($use_block_editor, $post) {
	if ($post->post_type === 'page') {
		if (in_array($post->post_name, ['custom_top'])) {
			remove_post_type_support('page', 'editor');
			return false;
		}
	}
	return $use_block_editor;
}, 10, 2);


//****************************************
// トップページの設定リンク設定
//****************************************
function admin_add_menu()
{
	add_menu_page('トップページの設定', 'トップページの設定', 'manage_options', 'setting_for_top', '', '', '1');
}
add_action('admin_menu', 'admin_add_menu');
function admin_analytics_menu_link()
{
?><script>
		jQuery(function($) {
			// 上で指定したメニューのスラッグ
			var menu_slug = 'setting_for_top';
			$('a.toplevel_page_' + menu_slug).prop({
				href: "http://www.evoluer.jp/cms/wp-admin/post.php?post=442&action=edit"
			});
		});
	</script><?php
					}
					add_action('admin_print_footer_scripts', 'admin_analytics_menu_link');

						?>

<?php
/**
 * Temporarily disable Shibuki fanclub pages and show a Coming Soon screen.
 * Covers /fanclub/shibuki/... and /shibuki/... routes.
 */
add_action(
	'template_redirect',
	static function () {
		if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
			return;
		}
		if (defined('REST_REQUEST') && REST_REQUEST) {
			return;
		}

		$path = function_exists('evoluer_get_fanclub_request_path')
			? evoluer_get_fanclub_request_path()
			: trim((string) parse_url(isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '', PHP_URL_PATH), '/');

		$is_shibuki_path = ('' !== $path) && (bool) preg_match('#^(fanclub/shibuki|shibuki)(/|$)#', $path);
		$is_shibuki_login_redirect = false;
		if ('fanclub/login' === $path) {
			$artist = isset($_GET['artist']) ? sanitize_key(wp_unslash($_GET['artist'])) : '';
			if ('shibuki' === $artist) {
				$is_shibuki_login_redirect = true;
			}
			if (! $is_shibuki_login_redirect && ! empty($_GET['redirect_to'])) {
				$redirect_to = (string) wp_unslash($_GET['redirect_to']);
				$redirect_path = trim((string) parse_url($redirect_to, PHP_URL_PATH), '/');
				$site_path = trim((string) parse_url(home_url('/'), PHP_URL_PATH), '/');
				if ($site_path !== '' && 0 === strpos($redirect_path, $site_path . '/')) {
					$redirect_path = trim(substr($redirect_path, strlen($site_path)), '/');
				}
				if (preg_match('#^(fanclub/shibuki|shibuki)(/|$)#', $redirect_path)) {
					$is_shibuki_login_redirect = true;
				}
			}
		}

		if (! $is_shibuki_path && ! $is_shibuki_login_redirect) {
			return;
		}

		status_header(200);
		nocache_headers();
		get_header();
?>
	<main id="" class="flex items-center justify-center bg-[#DDE4DE] min-h-[80vh] py-[80px] xl:pt-[200px]">
		<section class="w-full max-w-[980px] mx-auto px-[30px] text-center">
			<h1 class="text-[28px] md:text-[36px] lg:text-[48px] xl:text-[60px] font-bold text-[#222] mb-[16px]">紫吹 official fan club</h1>
			<p class="text-[18px] md:text-[24px] lg:text-[32px] xl:text-[40px] tracking-[2px] text-[#13AA05] font-semibold mb-[20px]">COMING SOON</p>
			<p class="text-[14px] md:text-[16px] lg:text-[20px] xl:text-[24px] text-[#666] leading-relaxed">
				現在、こちらのページは公開準備中です。<br>
				公開までしばらくお待ちください。
			</p>
			<div class="mt-[32px]">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block !underline !underline-offset-4 text-[#13AA05] text-[14px] md:text-[16px]">トップページへ戻る</a>
			</div>
		</section>
	</main>
<?php
		get_footer();
		exit;
	},
	-1000
);
