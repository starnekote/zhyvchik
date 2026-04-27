<?php
get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        ?>
        <div class="zhyvchik-<?php echo $post->post_name; ?>">
            <div class="container">
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>
        </div>
        <?php
    endwhile;
endif;

get_footer();