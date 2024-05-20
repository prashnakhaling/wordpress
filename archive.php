<?php
if (have_posts()):
    while (have_posts()):
        the_post();
        echo "<h2><a href='" . get_permalink() . "'>";
        the_title();
        echo "</a></h2><p>";
        // the_excerpt();
        echo "</p>";

    endwhile;
endif;