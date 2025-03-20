<?php

/*-------------------------- Récupération des fiches et leurs données ------------------------------*/
$args = array(
    'post_type'      => 'fiches-photos',
    'posts_per_page' => -1,
    'post_status'    => 'publish'

$query = new WP_Query($args);

if ($query->have_posts()) {
    foreach ($query->posts as $post) {
        $this_post_datas = setup_postdata($post);
        print_r($this_post_datas);//////
    }// Fin de foreach ($query->posts as $post)
}// Fin de if ($query->have_posts())

?>