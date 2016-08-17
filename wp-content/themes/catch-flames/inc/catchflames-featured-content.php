<?php
/**
 * The template for displaying the Featured Content
 *
 * @package Catch Themes
 * @subpackage Catch Flames
 * @since Catch Flames 3.0
 */

if( !function_exists( 'catchflames_featured_content_display' ) ) :
/**
* Add Featured content.
*
* @uses action hook catchflames_before_content.
*
* @since Catch Flames 3.0
*/
function catchflames_featured_content_display() {
	//delete_transient( 'catchflames_featured_content' );
	global $post, $wp_query, $catchflames_options_settings;

	// get data value from options
	$options 		= $catchflames_options_settings;
	$enablecontent 	= $options['featured_content_option'];
	$contentselect 	= $options['featured_content_type'];

	// Front page displays in Reading Settings
	$page_on_front 	= get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');


	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	if ( $enablecontent == 'entire-site' || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enablecontent == 'homepage' ) ) {
		if ( $contentselect == 'featured-widget-content' ) {
			get_sidebar( 'featured-widget-content' );
		}
		else {
			if ( ( !$catchflames_featured_content = get_transient( 'catchflames_featured_content' ) ) ) {
				$layouts 	 = $options ['featured_content_layout'];
				$headline 	 = $options ['featured_content_headline'];
				$subheadline = $options ['featured_content_subheadline'];

				echo '<!-- refreshing cache -->';

				if ( !empty( $layouts ) ) {
					$classes = $layouts ;
				}

				if ( $contentselect == 'demo-featured-content' ) {
					$classes 	.= ' demo-featured-content' ;
					$headline 		= __( 'Featured Content', 'catch-flames' );
					$subheadline 	= __( 'Here you can showcase the x number of Featured Content. You can edit this Headline, Subheadline and Feaured Content from "Appearance -> Customize -> Featured Content Options".', 'catch-flames' );
				}
				elseif ( $contentselect == 'featured-page-content' ) {
					$classes .= ' featured-page-content' ;
				}

				$featured_content_position = $options [ 'featured_content_position' ];

				if ( '1' == $featured_content_position ) {
					$classes .= ' border-top' ;
				}

				$catchflames_featured_content ='
					<section id="featured-content" class="' . $classes . '">
						<div class="wrapper">';
							if ( !empty( $headline ) || !empty( $subheadline ) ) {
								$catchflames_featured_content .='<div class="featured-heading-wrap">';
									if ( !empty( $headline ) ) {
										$catchflames_featured_content .='<h1 id="featured-heading" class="entry-title">'. $headline .'</h1>';
									}
									if ( !empty( $subheadline ) ) {
										$catchflames_featured_content .='<p>'. $subheadline .'</p>';
									}
								$catchflames_featured_content .='</div><!-- .featured-heading-wrap -->';
							}

							$catchflames_featured_content .='
							<div class="featured-content-wrap">';
								// Select content
								if ( $contentselect == 'demo-featured-content' && function_exists( 'catchflames_demo_content' ) ) {
									$catchflames_featured_content .= catchflames_demo_content( $options );
								}
								elseif ( $contentselect == 'featured-page-content' && function_exists( 'catchflames_page_content' ) ) {
									$catchflames_featured_content .= catchflames_page_content( $options );
								}

				$catchflames_featured_content .='
							</div><!-- .featured-content-wrap -->
						</div><!-- .wrapper -->
					</section><!-- #featured-content -->';
				set_transient( 'catchflames_featured_content', $catchflames_featured_content, 86940 );

			}
			echo $catchflames_featured_content;
		}
	}
}
endif;


if ( ! function_exists( 'catchflames_featured_content_display_position' ) ) :
/**
 * Homepage Featured Content Position
 *
 * @action catchflames_content, catchflames_after_secondary
 *
 * @since Catch Flames 3.0
 */
function catchflames_featured_content_display_position() {
	// Getting data from Theme Options
	global $catchflames_options_settings;
	$options = $catchflames_options_settings;

	$featured_content_position = $options [ 'featured_content_position' ];

	if ( '1' != $featured_content_position ) {
		add_action( 'catchflames_before_main', 'catchflames_featured_content_display', 50 );
	} else {
		add_action( 'catchflames_after_main', 'catchflames_featured_content_display', 20 );
	}

}
endif; // catchflames_featured_content_display_position
add_action( 'catchflames_before', 'catchflames_featured_content_display_position', 10 );


if ( ! function_exists( 'catchflames_demo_content' ) ) :
/**
 * This function to display featured posts content
 *
 * @get the data value from customizer options
 *
 * @since Catch Flames 3.0
 *
 */
function catchflames_demo_content( $options ) {
	$catchflames_demo_content = '
		<article id="featured-post-1" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Travel Map" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/featured1-350x263.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h1 class="entry-title">
						<a title="Travel Map" href="#">Travel Map</a>
					</h1>
				</header>
			</div><!-- .entry-container -->
		</article>

		<article id="featured-post-2" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Volkswagen Camper" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/featured2-350x263.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h1 class="entry-title">
						<a title="Volkswagen Camper" href="#">Volkswagen Camper</a>
					</h1>
				</header>
			</div><!-- .entry-container -->
		</article>

		<article id="featured-post-3" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Best Beaches" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/featured3-350x263.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h1 class="entry-title">
						<a title="Best Beaches" href="#">Best Beaches</a>
					</h1>
				</header>
			</div><!-- .entry-container -->
		</article>';

	if( 'layout-four' == $options ['featured_content_layout'] || 'layout-two' == $options ['featured_content_layout'] ) {
		$catchflames_demo_content .= '
		<article id="featured-post-4" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Santorini Island" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/featured4-350x263.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h1 class="entry-title">
						<a title="Santorini Island" href="#">Santorini Island</a>
					</h1>
				</header>
			</div><!-- .entry-container -->
		</article>';
	}

	return $catchflames_demo_content;
}
endif; // catchflames_demo_content

if ( ! function_exists( 'catchflames_page_content' ) ) :
/**
 * This function to display featured page content
 *
 * @param $options: catchflames_theme_options from customizer
 *
 * @since Catch Flames 3.0
 */
function catchflames_page_content( $options ) {
	global $post;

	$quantity 		= $options [ 'featured_content_number' ];

	$show_content	= isset( $options['featured_content_show'] ) ? $options['featured_content_show'] : 'excerpt';

	$number_of_page = 0; 		// for number of pages

	$page_list		= array();	// list of valid pages ids

	$catchflames_page_content 	= '';

	//Get valid pages
	for( $i = 1; $i <= $quantity; $i++ ){
		if( isset ( $options['featured_content_page'][ $i ] ) && $options['featured_content_page'][ $i ] > 0 ){
			$number_of_page++;

			$page_list	=	array_merge( $page_list, array( $options['featured_content_page'][ $i ] ) );
		}

	}
	if ( !empty( $page_list ) && $number_of_page > 0 ) {
		$get_featured_posts = new WP_Query( array(
                    'posts_per_page' 		=> $number_of_page,
                    'post__in'       		=> $page_list,
                    'orderby'        		=> 'post__in',
                    'post_type'				=> 'page',
                ));

		$i=0;
		while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;
			$title_attribute = the_title_attribute( array( 'before' => __( 'Permalink to: ', 'catch-flames' ), 'echo' => false ) );

			$excerpt = get_the_excerpt();

			$catchflames_page_content .= '
				<article id="featured-post-' . $i . '" class="post hentry featured-page-content">';
				if ( has_post_thumbnail() ) {
					$catchflames_page_content .= '
					<figure class="featured-homepage-image">
						<a href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">
						'. get_the_post_thumbnail( $post->ID, 'featured-content', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class' => 'pngfix' ) ) .'
						</a>
					</figure>';
				}
				else {
					$catchflames_first_image = catchflames_get_first_image( $post->ID, 'catch-flames-featured-content', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class' => 'pngfix' ) );

					if ( '' != $catchflames_first_image ) {
						$catchflames_page_content .= '
						<figure class="featured-homepage-image">
							<a href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">
								'. $catchflames_first_image .'
							</a>
						</figure>';
					}
				}

				$catchflames_page_content .= '
					<div class="entry-container">
						<header class="entry-header">
							<h1 class="entry-title">
								<a href="' . get_permalink() . '" rel="bookmark">' . the_title( '','', false ) . '</a>
							</h1>
						</header>';
						if ( 'excerpt' == $show_content ) {
							$catchflames_page_content .= '<div class="entry-excerpt"><p>' . $excerpt . '</p></div><!-- .entry-excerpt -->';
						}
						elseif ( 'full-content' == $show_content ) {
							$content = apply_filters( 'the_content', get_the_content() );
							$content = str_replace( ']]>', ']]&gt;', $content );
							$catchflames_page_content .= '<div class="entry-content">' . $content . '</div><!-- .entry-content -->';
						}
					$catchflames_page_content .= '
					</div><!-- .entry-container -->
				</article><!-- .featured-post-'. $i .' -->';
		endwhile;

		wp_reset_query();
	}

	return $catchflames_page_content;
}
endif; // catchflames_page_content

function catchflames_get_first_image( $postID, $size, $attr ) {
	ob_start();

	ob_end_clean();

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field('post_content', $postID ) , $matches);

	if( isset( $matches [1] [0] ) ) {
		//Get first image
		$first_img = $matches [1] [0];

		return '<img class="pngfix wp-post-image" src="'. $first_img .'">';
	}

	return false;
}