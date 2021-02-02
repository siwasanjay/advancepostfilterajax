<?php
/*
 * Template Name: APFA Filter
 * Description: A Page Template with a post filter.
 */
get_header( 'filter' ); ?>
    <div class="container">
        <?php
        $posts_per_page = get_option( 'numbers_of_post' ); // posts per page default 6

        // Hide empty category.
        $hide_empty = false;
        if ( ! empty( get_option( 'hide_empty_cat' ) ) ) {
            $hide_empty = true;
        }

        // Exclude uncategories.
        $exclude_uncat = array();
        if( ! empty( get_option( 'hide_uncat' ) ) ) {
            $exclude_uncat = array( '1' );
        }

        // Current category.
        $currentCat = '';
        if( isset( $_POST['cCategory'] ) ) {
            $currentCat = $_POST['cCategory'];
        }
        ?>
        <div class="filter-options">
            <form action="" method="post">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <select id="inputCat" class="form-control">
                            <option value="" <?php echo ( $currentCat == '' ) ? "selected" : "" ?>><?php _e( 'All Categories', 'advance-post-filter-ajax' ); ?></option>
                            <?php
                            // Get all categories
                            $categories = get_categories( array(
                                'hide_empty' => $hide_empty, // hide empty categories.
                                'exclude' => $exclude_uncat, // hide uncategories category.
                            ) );

                            if( $categories ) {
                                // List all categories
                                foreach ( $categories as $cat ) {
                                    ?>
                                    <option value="<?php echo $cat->term_id; ?>" <?php echo ( $currentCat == $cat->slug ) ? "selected" : "" ?>>
                                        <?php _e( $cat->name, 'advance-post-filter-ajax' ); ?> <?php _e( '(' . $cat->count . ')' , 'advance-post-filter-ajax' ); ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select id="orderBy" class="form-control">
                            <option value=""><?php _e( 'Order By', 'advance-post-filter-ajax' ); ?></option>
                            <option value="date"><?php _e( 'Latest', 'advance-post-filter-ajax' ); ?></option>
                            <option value="date-asc"><?php _e( 'Oldest', 'advance-post-filter-ajax' ); ?></option>
                            <option value="title"><?php _e( 'Alphabetical', 'advance-post-filter-ajax' ); ?></option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" id="searchFilter" placeholder="Search">
                    </div>
                </div><!-- .form-row -->
            </form>
        </div><!-- .filter-options -->
        <?php
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        // post args
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $posts_per_page,
            'page'  => $paged,
        );
        $posts = new WP_Query( $args );
        ?>
        <div id="apfa-filter-wrapper" class="card-columns" data-page="<?php echo $paged + 1; ?>">
            <?php while( $posts->have_posts() ) : $posts->the_post(); ?>
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
            ?>
        </div><!-- #apfa-filter-wrapper -->
        <?php if( ( ( $posts->max_num_pages - $paged ) > 0 ) ) {
            // Load More
            $load_more_type = get_option( 'load_more' );
            if( isset( $load_more_type ) && 'button' == $load_more_type[0] ) {
            $button_text = get_option( 'button_text' );
                ?>
                <div id="loadmore" class="col-md-12 text-center">
                    <button type="button" class="btn btn-light"><?php _e( $button_text, 'advance-post-filter-ajax' ); ?></button>
                </div>
                <?php
            }
        } ?>
        
    </div><!-- .container -->
<?php get_footer();
