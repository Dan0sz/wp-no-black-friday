<?php
/**
 * @package Daan\NoBlackFriday
 * @author  Daan van den Bergh
 * @url https://daan.dev
 * @license MIT
 */

namespace Daan\NoBlackFriday;

class Bar {
	/**
	 * The post with this slug, if there is one, explains why there are no Black Friday deals.
	 */
	const POST_SLUG = 'black-friday';

	/**
	 * Build class.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_style' ] );
		add_action( 'wp_body_open', [ $this, 'render' ], 1 );
	}

	/**
	 * The stylesheet is small, so it's printed in the head to prevent the bar from showing unstyled.
	 *
	 * @return void
	 */
	public function enqueue_style() {
		if ( ! $this->is_shown() ) {
			return;
		}

		wp_register_style( 'wp-no-black-friday', false, [], null );
		wp_enqueue_style( 'wp-no-black-friday' );
		wp_add_inline_style( 'wp-no-black-friday', file_get_contents( NO_BLACK_FRIDAY_PLUGIN_DIR . 'assets/bar.css' ) );
	}

	/**
	 * @return void
	 */
	public function render() {
		if ( ! $this->is_shown() ) {
			return;
		}

		$url = $this->get_url();
		?>
		<div id="no-black-friday" class="nbf" role="region" aria-label="<?php esc_attr_e( 'No Black Friday deals', 'wp-no-black-friday' ); ?>" data-year="<?php echo esc_attr( wp_date( 'Y' ) ); ?>" data-until="<?php echo esc_attr( $this->get_end() ); ?>">
			<div class="nbf__confetti nbf__confetti--start" aria-hidden="true"><?php echo str_repeat( '<i></i>', 35 ); ?></div>
			<p class="nbf__text">
				<span class="nbf__tag"><del><?php esc_html_e( 'Black Friday', 'wp-no-black-friday' ); ?></del></span>
				<span><?php echo wp_kses_post( $this->get_text() ); ?></span>
				<?php if ( $url ) : ?>
					<a class="nbf__link" href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Here\'s why', 'wp-no-black-friday' ); ?> <span aria-hidden="true">&rarr;</span></a>
				<?php endif; ?>
			</p>
			<div class="nbf__confetti nbf__confetti--end" aria-hidden="true"><?php echo str_repeat( '<i></i>', 35 ); ?></div>
			<button type="button" class="nbf__close" aria-label="<?php esc_attr_e( 'Close', 'wp-no-black-friday' ); ?>">&times;</button>
		</div>
		<?php
		// Right after the bar, so it's gone before it's painted if it was closed, or if this page was cached in November.
		wp_print_inline_script_tag( file_get_contents( NO_BLACK_FRIDAY_PLUGIN_DIR . 'assets/bar.js' ) );
	}

	/**
	 * @return bool
	 */
	private function is_shown() {
		/**
		 * Whether to show the bar, e.g. to preview it in another month, or to hide it on some pages.
		 *
		 * @param bool $show True in November, in the site's timezone.
		 */
		return (bool) apply_filters( 'no_black_friday_show', $this->is_november() );
	}

	/**
	 * @return bool
	 */
	private function is_november() {
		return wp_date( 'n' ) === '11';
	}

	/**
	 * @return string When November ends (timestamp), empty if the bar is shown in another month.
	 */
	private function get_end() {
		if ( ! $this->is_november() ) {
			return '';
		}

		return (string) ( new \DateTimeImmutable( wp_date( 'Y' ) . '-12-01', wp_timezone() ) )->getTimestamp();
	}

	/**
	 * @return string
	 */
	private function get_text() {
		$text = sprintf(
			/* translators: %s: the site's name */
			__( '<strong>Not at %s.</strong> My best price isn\'t seasonal, you\'re already looking at it. No countdown timer needed.', 'wp-no-black-friday' ),
			esc_html( get_bloginfo( 'name', 'raw' ) )
		);

		/**
		 * The text on the bar.
		 *
		 * @param string $text May contain HTML, e.g. <strong>.
		 */
		return apply_filters( 'no_black_friday_text', $text );
	}

	/**
	 * @return string
	 */
	private function get_url() {
		$post = get_page_by_path( self::POST_SLUG, OBJECT, 'post' );
		$url  = $post && $post->post_status === 'publish' ? get_permalink( $post ) : '';

		// No link to the page they're already on.
		if ( $url && is_single( $post->ID ) ) {
			$url = '';
		}

		/**
		 * Where the link goes, e.g. to a post that explains why there are no Black Friday deals.
		 *
		 * @param string $url The published post with the slug black-friday, empty for no link.
		 */
		return apply_filters( 'no_black_friday_url', $url );
	}
}
