<?php
/**
 * Shows Default Slider Demo if there is not iteam in Featured Post Slider
 */
function catchflames_default_sliders() {
	delete_transient( 'catchflames_default_sliders' );

	// get data value from theme options
	global $catchflames_options_settings;
    $options = $catchflames_options_settings;
	$sliderlayout = $options[ 'select_slider_layout' ];

	if ( !$catchflames_default_sliders = get_transient( 'catchflames_default_sliders' ) ) {
		echo '<!-- refreshing cache -->';

		$sliderlayout = $options[ 'select_slider_layout' ];
		if ( $sliderlayout == 'fullwidth' ) :
			$layoutclass = 'full-width';
		else :
			$layoutclass = 'normal-width';
		endif;
		//data-cycle-loader="'. esc_attr( $options['image'] ) .'"

		$catchflames_default_sliders = '
		<div id="main-slider" class="featured-demo-slider ' . $layoutclass . '">
			<section class="featured-slider cycle-slideshow"
			    data-cycle-log="false"
			    data-cycle-pause-on-hover="true"
			    data-cycle-swipe="true"
			    data-cycle-auto-height=container
			    data-cycle-fx="'. esc_attr( $options['transition_effect'] ) .'"
				data-cycle-speed="'. esc_attr( $options['transition_duration'] ) * 1000 .'"
				data-cycle-timeout="'. esc_attr( $options['transition_delay'] ) * 1000 .'"
				data-cycle-loader="'. esc_attr( $options['image_loader'] ) .'"
				data-cycle-slides="> article"
				>
				<!-- prev/next links -->
				<div class="cycle-prev"></div>
				<div class="cycle-next"></div>

				<!-- empty element for pager links -->
	    		<div id="controllers" class="cycle-pager"></div>

				<article class="post hentry slides demo-image displayblock">
					<figure class="slider-image">
						<a title="Seto Ghumba" href="#">
							<img src="'. get_template_directory_uri() . '/images/demo/slider-1-1600x650.jpg" class="wp-post-image" alt="Seto Ghumba" title="Seto Ghumba">
						</a>
					</figure>
				</article><!-- .slides -->


				<article class="post hentry slides demo-image displaynone">
					<figure class="slider-image">
						<a title="Kathmandu Durbar Square" href="#">
							<img src="'. get_template_directory_uri() . '/images/demo/slider-2-1600x650.jpg" class="wp-post-image" alt="Kathmandu Durbar Square" title="Kathmandu Durbar Square">
						</a>
					</figure>
				</article><!-- .slides -->
			</section>
		</div><!-- #main-slider -->';

	set_transient( 'catchflames_default_sliders', $catchflames_default_sliders, 86940 );
	}
	echo $catchflames_default_sliders;
} // catchflames_default_sliders


if ( ! function_exists( 'catchflames_page_sliders' ) ) :
/**
 * Template for Featued Page Slider
 *
 * To override this in a child theme
 * simply create your own catchflames_page_sliders(), and that function will be used instead.
 *
 * @uses catchflames_header action to add it in the header
 * @since Catch Flames Pro 1.0
 */
function catchflames_page_sliders() {
	delete_transient( 'catchflames_page_sliders' );

	global $post, $catchflames_options_settings;
   	$options = $catchflames_options_settings;


	if( ( !$catchflames_page_sliders = get_transient( 'catchflames_page_sliders' ) ) && !empty( $options[ 'featured_slider_page' ] ) ) {
		echo '<!-- refreshing cache -->';

		$sliderlayout = $options[ 'select_slider_layout' ];
		if ( $sliderlayout == 'fullwidth' ) :
			$layoutclass = 'full-width';
			$imagesize = 'featured-slider-full';
		else :
			$layoutclass = 'normal-width';
			$imagesize = 'featured-slider-normal';
		endif;

		$catchflames_page_sliders = '
		<div id="main-slider" class="featured-page-slider ' . $layoutclass . '">
        	<section class="featured-slider cycle-slideshow"
			    data-cycle-log="false"
			    data-cycle-pause-on-hover="true"
			    data-cycle-swipe="true"
			    data-cycle-auto-height=container
			    data-cycle-fx="'. esc_attr( $options['transition_effect'] ) .'"
				data-cycle-speed="'. esc_attr( $options['transition_duration'] ) * 1000 .'"
				data-cycle-timeout="'. esc_attr( $options['transition_delay'] ) * 1000 .'"
				data-cycle-loader="'. esc_attr( $options['image_loader'] ) .'"
				data-cycle-slides="> article"
				>
				<!-- prev/next links -->
				<div class="cycle-prev"></div>
				<div class="cycle-next"></div>

				<!-- empty element for pager links -->
	    		<div id="controllers" class="cycle-pager"></div>';

				$get_featured_posts = new WP_Query( array(
					'posts_per_page'	=> $options[ 'slider_qty' ],
					'post_type'			=> 'page',
					'post__in'			=> $options[ 'featured_slider_page' ],
					'orderby' 			=> 'post__in'
				));


				$i=0; while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;
					$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
					$excerpt = get_the_excerpt();
					if ( $i == 1 ) { $classes = 'page pageid-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'page pageid-'.$post->ID.' hentry slides displaynone'; }
					$catchflames_page_sliders .= '
					<article class="'.$classes.'">
						<figure class="slider-image">
							<a title="Permalink to '.the_title('','',false).'" href="' . get_permalink() . '">
								'. get_the_post_thumbnail( $post->ID, $imagesize, array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class'	=> 'pngfix' ) ).'
							</a>
						</figure>';
						if ( empty ( $options[ 'disable_slider_text' ] ) ) {
							$catchflames_page_sliders .= '
							<div class="entry-container">
								<header class="entry-header">
									<h1 class="entry-title">
										<a title="Permalink to '.the_title('','',false).'" href="' . get_permalink() . '">'.the_title( '<span>','</span>', false ).'</a>
									</h1>
								</header>';
								if( $excerpt !='') {
									$catchflames_page_sliders .= '<div class="entry-content">'. $excerpt.'</div>';
								}
								$catchflames_page_sliders .= '
							</div>';
						}
					$catchflames_page_sliders .= '</article><!-- .slides -->';

				endwhile; wp_reset_query();
				$catchflames_page_sliders .= '
			</section>
  		</div><!-- #main-slider -->';

  	set_transient( 'catchflames_page_sliders', $catchflames_page_sliders, 86940 );
	}
	echo $catchflames_page_sliders;
} // catchflames_page_sliders
endif;


if ( ! function_exists( 'catchflames_slider_display' ) ) :
/**
 * Shows Slider
 */
function catchflames_slider_display() {
	global $post, $wp_query, $catchflames_options_settings;
   	$options = $catchflames_options_settings;

	// get data value from theme options
	$enableslider = $options[ 'enable_slider' ];
	$slidertype = $options[ 'select_slider_type' ];

	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	if ( ( $enableslider == 'enable-slider-allpage' ) || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enableslider == 'enable-slider-homepage' ) ) :
		if (  $slidertype == 'page-slider' ) {
			if ( !empty( $options[ 'featured_slider_page' ] ) && function_exists( 'catchflames_page_sliders' ) ) {
				catchflames_page_sliders();
			}
			else {
				echo '<p style="text-align: center">' . esc_attr__( 'You have selected Page Slider but you haven\'t added the Page ID in "Appearance => Theme Options => Featured Slider => Featured Page Slider Options"', 'catch-flames' ) . '</p>';
			}
		}
		else {
			catchflames_default_sliders();
		}
	endif;
}
endif; // catchflames_slider_display

add_action( 'catchflames_before_main', 'catchflames_slider_display', 10 );