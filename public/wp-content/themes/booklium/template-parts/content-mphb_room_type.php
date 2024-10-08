<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Booklium
 */

$roomType    = MPHB()->getCurrentRoomType();
$has_gallery = $roomType->hasGallery();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( has_excerpt() ) :
			?>
            <div class="room-description">
				<?php
				the_excerpt();
				?>
            </div><!-- .entry-meta -->
		<?php endif; ?>
    </header><!-- .entry-header -->

	<?php
	if ( $has_gallery ) {
        do_action('booklium_render_single_room_gallery');
	} else {
		booklium_post_thumbnail( 'booklium-large' );
	}
	?>

    <div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
			/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'booklium' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'booklium' ),
			'after'  => '</div>',
		) );
		?>
    </div><!-- .entry-content -->

    <?php
    if ( $has_gallery && MPHB()->settings()->main()->isUseSingleRoomTypeGalleryMagnific() ) {

        wp_enqueue_script( 'mphb-fancybox' );
        wp_enqueue_style( 'mphb-fancybox-css' );
        ?>
        <script type="text/javascript">
            document.addEventListener( "DOMContentLoaded", function( event ) {
                (function( $ ) {
                    $( function() {
                        var galleryItems = $( ".single-room-gallery .gallery-icon>a" );
                        if ( galleryItems.length && $.fancybox ) {
                            galleryItems.fancybox( {
                                selector : '.single-room-gallery .gallery-icon>a',
                                loop: true
                            } );
                        }
                    } );
                })( jQuery );
            } );
        </script>
        <?php

    }
    ?>

</article><!-- #post-<?php the_ID(); ?> -->
