<?php
/*
 * Template Name: APFA Filter
 * Description: A Page Template with a post filter.
 */
get_header( 'filter' ); ?>
    <div class="container">
        <?php
        $posts_per_page = get_option( 'numbers_of_post' ); // posts per page default 6
        // If posts per page is set from plugin settings
        if( empty( $posts_per_page ) ) {
            $posts_per_page = get_option( 'posts_page' );
        }
        $hide_empty = false;
        if ( ! empty( get_option( 'hide_empty_cat' ) ) ) {
            $hide_empty = true;
        }
        $exclude_uncat = array();
        if( ! empty( get_option( 'hide_uncat' ) ) ) {
            $exclude_uncat = array( '1' );
        }
        // Get all categories
        $categories = get_categories( array(
            'hide_empty' => $hide_empty, // hide empty categories.
            'exclude' => $exclude_uncat, // hide uncategories category.
        ) );
        // List all categories
        if( $categories ) {
            ?>
            <div class="filter-options">
                <form action="" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <select id="inputState" class="form-control">
                                <option value="" <?php echo ( $_POST['inputState'] == '' ) ? "selected" : "" ?>><?php _e( 'All Categories', 'advance-post-filter-ajax' ); ?></option>
                                <?php
                                foreach ( $categories as $cat ) {
                                    ?>
                                    <option value="<?php echo $cat->slug; ?>" <?php echo ( $_POST['inputState'] == $cat->slug ) ? "selected" : "" ?>><?php _e( $cat->name, 'advance-post-filter-ajax' ); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div><!-- .filter-options -->
            <?php
        }
        // post args
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $posts_per_page,
        );
        $posts = new WP_Query( $args );
        while( $posts->have_posts() ) : $posts->the_post();
            echo get_the_title();
        endwhile;
        wp_reset_postdata(); // Reset post data. Set post data to default.
        ?>
    </div><!-- .container -->
<?php get_footer();
