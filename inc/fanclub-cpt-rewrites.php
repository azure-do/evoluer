<?php
/**
 * Fanclub URL: /fanclub/{artist}/ticket|news|movie|gallery/ …
 * Short form: /{artist}/ticket|news|movie|gallery/ …
 * Bare /ticket/, /fcnews/ 等はファンクラブ付きURLへリダイレクト。
 *
 * @package evoluer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URL セグメント → post_type（news = fcnews, movie = fc-movie）。
 *
 * @return array<string, string>
 */
function evoluer_fanclub_url_segment_to_post_type() {
	return array(
		'ticket'  => EVOLUER_PT_FANCLUB_TICKET,
		'news'    => EVOLUER_PT_FANCLUB_NEWS,
		'movie'   => 'fc-movie',
		'gallery' => 'fc-gallery',
	);
}

/**
 * post_type → 公開URLセグメント（1つに固定）。
 *
 * @param string $post_type Post type name.
 * @return string
 */
function evoluer_fanclub_url_segment_for_post_type( $post_type ) {
	$map = array(
		EVOLUER_PT_FANCLUB_TICKET => 'ticket',
		EVOLUER_PT_FANCLUB_NEWS   => 'news',
		'fc-movie'                => 'movie',
		'fc-gallery'              => 'gallery',
	);

	return isset( $map[ $post_type ] ) ? $map[ $post_type ] : $post_type;
}

/**
 * fc-fanclub ターム slug → アーティストURLスラッグ（yonekichi = 中村米吉 / shibuki = 紫吹）。
 *
 * @param string $term_slug fanclub_yonekichi|fanclub_shibuki.
 * @return string
 */
function evoluer_fanclub_term_slug_to_artist_slug( $term_slug ) {
	$map = array(
		// new slugs
		'fanclub_yonekichi' => 'yonekichi',
		'fanclub_shibuki'   => 'shibuki',
	);

	return isset( $map[ $term_slug ] ) ? $map[ $term_slug ] : 'yonekichi';
}

/**
 * デフォルトのアーティストスラッグ（一覧リダイレクト用）。
 *
 * @return string
 */
function evoluer_fanclub_default_artist_slug_for_redirect() {
	if ( is_user_logged_in() ) {
		$user = wp_get_current_user();
		$roles = $user ? (array) $user->roles : array();
		if ( in_array( 'fanclub_shibuki', $roles, true ) ) {
			return 'shibuki';
		}
	}

	return 'yonekichi';
}

/**
 * 投稿の正規ファンクラブURL（/fanclub/{artist}/{seg}/{slug}/）。
 *
 * @param WP_Post $post Post object.
 * @return string
 */
function evoluer_fanclub_canonical_permalink_for_post( $post ) {
	if ( ! $post instanceof WP_Post ) {
		return '';
	}

	$fanclub_types = array( EVOLUER_PT_FANCLUB_TICKET, EVOLUER_PT_FANCLUB_NEWS, 'fc-movie', 'fc-gallery' );
	if ( ! in_array( $post->post_type, $fanclub_types, true ) ) {
		return '';
	}

	$terms = get_the_terms( $post->ID, 'fc-fanclub' );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return '';
	}

	$term      = reset( $terms );
	$artist    = evoluer_fanclub_term_slug_to_artist_slug( $term->slug );
	$segment   = evoluer_fanclub_url_segment_for_post_type( $post->post_type );
	$post_slug = $post->post_name;

	return trailingslashit( home_url( '/fanclub/' . $artist . '/' . $segment . '/' . $post_slug ) );
}

/**
 * アーカイブの正規URL。
 *
 * @param string $post_type Post type.
 * @return string
 */
function evoluer_fanclub_canonical_archive_url( $post_type ) {
	$artist  = evoluer_fanclub_default_artist_slug_for_redirect();
	$segment = evoluer_fanclub_url_segment_for_post_type( $post_type );

	return trailingslashit( home_url( '/fanclub/' . $artist . '/' . $segment ) );
}

add_action(
	'init',
	static function () {
		add_rewrite_tag( '%evoluer_fc_artist%', '([^/]+)' );
	},
	24
);

add_filter(
	'query_vars',
	static function ( $vars ) {
		$vars[] = 'evoluer_fc_artist';

		return $vars;
	}
);

/**
 * リライトルール登録（CPT登録の後）。
 */
add_action(
	'init',
	static function () {
		if ( ! defined( 'EVOLUER_PT_FANCLUB_NEWS' ) || ! defined( 'EVOLUER_PT_FANCLUB_TICKET' ) ) {
			return;
		}

		$artists  = apply_filters( 'evoluer_fanclub_artist_slugs', array( 'yonekichi', 'shibuki' ) );
		$segments = evoluer_fanclub_url_segment_to_post_type();

		foreach ( $artists as $artist ) {
			foreach ( $segments as $url_seg => $post_type ) {
				// アーカイブ
				add_rewrite_rule(
					'^fanclub/' . $artist . '/' . $url_seg . '/?$',
					'index.php?post_type=' . $post_type . '&evoluer_fc_artist=' . $artist,
					'top'
				);
				add_rewrite_rule(
					'^' . $artist . '/' . $url_seg . '/?$',
					'index.php?post_type=' . $post_type . '&evoluer_fc_artist=' . $artist,
					'top'
				);
				// ページ送り
				add_rewrite_rule(
					'^fanclub/' . $artist . '/' . $url_seg . '/page/([0-9]+)/?$',
					'index.php?post_type=' . $post_type . '&evoluer_fc_artist=' . $artist . '&paged=$matches[1]',
					'top'
				);
				add_rewrite_rule(
					'^' . $artist . '/' . $url_seg . '/page/([0-9]+)/?$',
					'index.php?post_type=' . $post_type . '&evoluer_fc_artist=' . $artist . '&paged=$matches[1]',
					'top'
				);
				// 単一投稿
				add_rewrite_rule(
					'^fanclub/' . $artist . '/' . $url_seg . '/([^/]+)/?$',
					'index.php?post_type=' . $post_type . '&name=$matches[1]&evoluer_fc_artist=' . $artist,
					'top'
				);
				add_rewrite_rule(
					'^' . $artist . '/' . $url_seg . '/([^/]+)/?$',
					'index.php?post_type=' . $post_type . '&name=$matches[1]&evoluer_fc_artist=' . $artist,
					'top'
				);
			}
		}

		$v = (int) get_option( 'evoluer_fanclub_rewrite_version', 0 );
		if ( $v < 3 ) {
			update_option( 'evoluer_fanclub_rewrite_version', 3 );
			update_option( 'evoluer_flush_rewrite_rules_flag', '1' );
		}
	},
	25
);

/**
 * アーカイブ: fc-fanclub で絞り込み。
 */
add_action(
	'pre_get_posts',
	static function ( $query ) {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		$artist = $query->get( 'evoluer_fc_artist' );
		if ( empty( $artist ) ) {
			return;
		}

		$post_type = $query->get( 'post_type' );
		if ( is_array( $post_type ) ) {
			$post_type = reset( $post_type );
		}
		if ( empty( $post_type ) ) {
			return;
		}

		$fanclub_types = array( EVOLUER_PT_FANCLUB_TICKET, EVOLUER_PT_FANCLUB_NEWS, 'fc-movie', 'fc-gallery' );
		if ( ! in_array( $post_type, $fanclub_types, true ) ) {
			return;
		}

		// 単一投稿は `name` または `p` で取得。is_post_type_archive() は環境によって false のままのことがあるため明示判定する。
		if ( (string) $query->get( 'name' ) !== '' || (int) $query->get( 'p' ) > 0 ) {
			return;
		}

		$map = apply_filters(
			'evoluer_fanclub_artist_slug_to_term',
			array(
				'yonekichi' => 'fanclub_yonekichi',
				'shibuki'   => 'fanclub_shibuki',
			)
		);

		if ( ! isset( $map[ $artist ] ) ) {
			return;
		}

		$term_slug  = $map[ $artist ];
		$term_slugs = ( 'fanclub_shibuki' === $term_slug )
			? array( 'fanclub_shibuki' )
			: array( 'fanclub_yonekichi' );

		$query->set(
			'tax_query',
			array(
				array(
					'taxonomy' => 'fc-fanclub',
					'field'    => 'slug',
					'terms'    => $term_slugs,
				),
			)
		);
	}
);

/**
 * 単一: URL のアーティストと投稿のタームが一致するか。
 */
add_action(
	'template_redirect',
	static function () {
		if ( ! is_singular() ) {
			return;
		}

		$artist = get_query_var( 'evoluer_fc_artist' );
		if ( empty( $artist ) ) {
			return;
		}

		$map = apply_filters(
			'evoluer_fanclub_artist_slug_to_term',
			array(
				'yonekichi' => 'fanclub_yonekichi',
				'shibuki'   => 'fanclub_shibuki',
			)
		);

		if ( ! isset( $map[ $artist ] ) ) {
			return;
		}

		$term_slug  = $map[ $artist ];
		$term_slugs = ( 'fanclub_shibuki' === $term_slug )
			? array( 'fanclub_shibuki' )
			: array( 'fanclub_yonekichi' );
		$post_id   = (int) get_queried_object_id();

		if ( $post_id <= 0 || ! has_term( $term_slugs, 'fc-fanclub', $post_id ) ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			nocache_headers();
		}
	},
	8
);

/**
 * プレフィックスなし /ticket/, /fcnews/, 単一URL → /fanclub/{artist}/… へ。
 */
add_action(
	'template_redirect',
	static function () {
		if ( is_admin() ) {
			return;
		}

		if ( get_query_var( 'evoluer_fc_artist' ) ) {
			return;
		}

		$fanclub_types = array( EVOLUER_PT_FANCLUB_TICKET, EVOLUER_PT_FANCLUB_NEWS, 'fc-movie', 'fc-gallery' );

		if ( is_post_type_archive( $fanclub_types ) ) {
			$pt = get_post_type();
			if ( is_array( $pt ) ) {
				$pt = reset( $pt );
			}
			$url = evoluer_fanclub_canonical_archive_url( (string) $pt );
			if ( $url !== '' ) {
				wp_safe_redirect( $url, 301 );
				exit;
			}
		}

		if ( is_singular( $fanclub_types ) ) {
			$post = get_queried_object();
			if ( ! $post instanceof WP_Post ) {
				return;
			}
			$url = evoluer_fanclub_canonical_permalink_for_post( $post );
			if ( $url !== '' ) {
				wp_safe_redirect( $url, 301 );
				exit;
			}
		}
	},
	5
);

/**
 * フロントで表示するパーマリンクをファンクラブ形式に。
 */
add_filter(
	'post_type_link',
	static function ( $post_link, $post ) {
		if ( ! $post instanceof WP_Post || 'publish' !== $post->post_status ) {
			return $post_link;
		}

		$fanclub_types = array( EVOLUER_PT_FANCLUB_TICKET, EVOLUER_PT_FANCLUB_NEWS, 'fc-movie', 'fc-gallery' );
		if ( ! in_array( $post->post_type, $fanclub_types, true ) ) {
			return $post_link;
		}

		$url = evoluer_fanclub_canonical_permalink_for_post( $post );

		return $url !== '' ? $url : $post_link;
	},
	10,
	2
);
