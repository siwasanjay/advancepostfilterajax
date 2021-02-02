<?php
// Filter on select option change.
add_action( "wp_ajax_apfa_filter_post", "apfa_filter_posts" );
add_action( "wp_ajax_nopriv_apfa_filter_post", "apfa_filter_posts" );
function apfa_filter_posts() {

	$posts_per_page = get_option( 'numbers_of_post' ); // posts per page default 6
	// Posts args
	$args = array(
		'post_type' => 'post', // post only
	);

	$args['posts_per_page'] = $posts_per_page; // posts per page

	// Category
	if( isset( $_POST['cCategory'] ) && $_POST['cCategory'] != '' ) {
		$args['category__in'] = array( $_POST['cCategory'] );
	}

	if( isset( $_POST['cPage'] ) ) {
		$args['paged'] = $_POST['cPage'];
	}

	// Order by
	if( isset( $_POST['cOrder'] ) ) {
		$orderby = $_POST['cOrder'];
		if( $orderby == 'date' ) {
			$args['orderby'] = 'date';
			$args['order'] = 'DESC';
		} else if ( $orderby == 'date-asc' ) {
			$args['orderby'] = 'date';
			$args['order'] = 'ASC';
		} else if ( $orderby == 'title' ) {
			$args['orderby'] = 'title';
			$args['order'] = 'ASC';
		}
	}
	$posts = new WP_Query( $args );
	while( $posts->have_posts() ) : $posts->the_post();
		?>
		<div class="card">
			<?php the_post_thumbnail( 'post-thumbnail', array( "class", "card-img-top" ) ); ?>
			<div class="card-body">
				<h5 class="card-title"><?php the_title(); ?></h5>
				<hr>
				<p class="card-text"><?php the_excerpt(); ?></p>
				<p class="card-text"><small class="text-muted"><?php echo get_the_date(); ?> <cite class="text-right" title="Source Title"><?php _e( 'Author: ', 'advance-post-filter-ajax' ) ; ?><?php the_author(); ?></cite></small></p>
			</div><!-- .card-body -->
		</div><!-- .card -->
		<?php
	endwhile;
	wp_reset_postdata(); // Reset post data. Set post data to default.

	die();

}


// Load more on button click.
add_action( "wp_ajax_apfa_loadmore_button", "apfa_loadmore_buttons" );
add_action( "wp_ajax_nopriv_apfa_loadmore_button", "apfa_loadmore_buttons" );
function apfa_loadmore_buttons() {
	
	$posts_per_page = get_option( 'numbers_of_post' ); // posts per page default 6
	// Posts args
	$args = array(
		'post_type' => 'post', // post only
	);

	$args['posts_per_page'] = $posts_per_page; // posts per page

	// Category
	if( isset( $_POST['cCategory'] ) && $_POST['cCategory'] != '' ) {
		$args['category__in'] = array( $_POST['cCategory'] );
	}

	if( isset( $_POST['cPage'] ) ) {
		$args['paged'] = $_POST['cPage'];
	}
	// Order by
	if( isset( $_POST['cOrder'] ) ) {
		$orderby = $_POST['cOrder'];
		if( $orderby == 'date' ) {
			$args['orderby'] = 'date';
			$args['order'] = 'DESC';
		} else if ( $orderby == 'date-asc' ) {
			$args['orderby'] = 'date';
			$args['order'] = 'ASC';
		} else if ( $orderby == 'title' ) {
			$args['orderby'] = 'title';
			$args['order'] = 'ASC';
		}
	}
	$posts = new WP_Query( $args );
	while( $posts->have_posts() ) : $posts->the_post();
		?>
		<div class="card">
			<?php the_post_thumbnail( 'post-thumbnail', array( "class", "card-img-top" ) ); ?>
			<div class="card-body">
				<h5 class="card-title"><?php the_title(); ?></h5>
				<hr>
				<p class="card-text"><?php the_excerpt(); ?></p>
				<p class="card-text"><small class="text-muted"><?php echo get_the_date(); ?> <cite class="text-right" title="Source Title"><?php _e( 'Author: ', 'advance-post-filter-ajax' ) ; ?><?php the_author(); ?></cite></small></p>
			</div><!-- .card-body -->
		</div><!-- .card -->
		<?php
	endwhile;
	wp_reset_postdata(); // Reset post data. Set post data to default.

	die();

}