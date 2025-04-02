<?php

/*----------------------- Si la page courante est une page fiche photo -------------------------------*/
$current_url = get_permalink();
$curent_postPage_id = get_the_ID();
//echo "- current_url : ".$current_url." - home_url : ".home_url();//////
$search_term = "/photo/";
$isSingledPost = strpos($current_url, $search_term);
if($isSingledPost !== false) {
    // On affiche contact et navigation
    $prev_post = get_previous_post();
    //var_dump($prev_post);//////
    $next_post = get_next_post();
    //var_dump($next_post);//////
    //if(!empty($prev_post)) {
        $prev_thumbnail = get_the_post_thumbnail($prev_post->ID, 'thumbnail');
    //}
    //if(!empty($next_post)) {
        $next_thumbnail = get_the_post_thumbnail($next_post->ID, 'thumbnail');
    //}

    echo "\n <section class='contact_et_nav' >";
        //--- Contact avec ref de l'image ---//
        echo "\n <div class='contact_ref_img' >";
            echo "\n <span class='like_photo' >Cette photo vous intéresse ?</span>";
            // On récupère le champs refPhoto
            $postId = get_the_ID();
            // Récupère la valeur du champ personnalisé "reference"
            $meta_data = get_post_meta($postId);
            //var_dump($meta_data);//////
            /*array(6) {
                ["_edit_lock"]=>
                array(1) {
                    [0]=>
                    string(12) "1739447730:1"
                }
                ["_thumbnail_id"]=>
                array(1) {
                    [0]=>
                    string(3) "173"
                }
                ["_edit_last"]=>
                array(1) {
                    [0]=>
                    string(1) "1"
                }
                ["fichier-image"]=>
                array(1) {
                    [0]=>
                    string(3) "173"
                }
                ["titre_de_la_photo"]=>
                array(1) {
                    [0]=>
                    string(14) "Au bal masqué"
                }
                ["reference_de_la_photo"]=>
                array(1) {
                    [0]=>
                    string(6) "bf2393"
                }
            }*/

            $reference_de_la_photo = $meta_data['reference'][0];
            //$categories_photo = $meta_data['categories-photo'][0];


            $onclickFunction = "showModaleContact('".$reference_de_la_photo."')";
            echo "\n <a href='#' title='Cliquez pour nous contacter à propos de cette photo' onclick=\"".$onclickFunction."\" >";
                echo "\n <button class='button_contact_ref_img' >Contact</button>";
            echo "\n </a>";
        echo "\n </div>";

            echo "\n <nav class='prev_next_post-nav' >";
            
                // Lien vers l'article précédent
                if (!empty($prev_post)) {
                    $prev_link = get_permalink($prev_post->ID);
                    $prev_title = get_the_title($prev_post->ID);
                } else {
                    //echo "\n <div class='nav-previous disabled' >Aucune photo précédente</div>";
                }

                // Lien vers l'article suivant
                if (!empty($next_post)) {

                    $next_link = get_permalink($next_post->ID);
                    $next_title = get_the_title($next_post->ID);
                    } else {
                        //echo '<div class="nav-next disabled">Aucune photo  suivante</div>';
                    }

                //echo "\n <br />*** prev_thumbnail : ".$prev_thumbnail." <br />- next_thumbnail : ".$next_thumbnail."<br /> - prev_link : ".$prev_link."<br /> - prev_title : ".$prev_title."<br /> - next_link : ".$next_link."<br /> - next_title : ".$next_title." ***<br />";//////

                /*-------------------------------- Affichage du menu prev/next -------------------------------------*/
                echo "\n <div class='postNavThumbnail' >";
                    if(get_next_post()) {
                        echo $next_thumbnail;
                    }
                echo "\n </div>";

                echo "\n <div class='PostNavFleches' >";
                        if(get_previous_post()) {
                            echo "\n <a href='".$prev_link."' tilte='".$prev_title."' >";
                                echo "\n <img src='".get_stylesheet_directory_uri()."/assets/images/flechePrev.png' alt='".$prev_title."' title='".$prev_title."' >";
                            echo "\n </a>";
                        }
                        if(get_next_post()) {
                            echo "\n <a href='".$next_link."' tilte='".$next_title."' >";
                                echo "\n <img src='".get_stylesheet_directory_uri()."/assets/images/flecheNext.png' alt='".$next_title."' title='".$next_title."' >";
                            echo "\n </a>";
                        }
                echo "\n </div>";

            echo "\n </nav>";
    echo "\n </section>";
}// Fin de if($isSingledPost !== false)

/*----------------------------------------- Photos liées x2 -----------------------------------*/
$post_id = get_the_ID();

// On cherche la catégorie du post courant
//$categorie_objet = get_the_terms($post_id, 'categorie');
//$categorie = $categorie_objet[0]->name;

// On attribut les valeurs aux taxonomy CPT UI
$categorie_objet = get_the_terms($post_id, 'categorie');
$categories_slug = $categorie_objet[0]->slug;

if ($categories_slug && !is_wp_error($categories_slug)) {
    $term_slug = $categories_slug;
    $post_type = 'photo';
    $taxonomy  = 'categorie';

    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => -1,

        'tax_query'      => array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $term_slug,
            ),
        ),
    );
    //print_r($args);//////
    /*Array
        (
            [post_type] => photo
            [posts_per_page] => 2
            [orderby] => rand
            [tax_query] => Array
                (
                    [0] => Array
                        (
                            [taxonomy] => categorie
                            [field] => slug
                            [terms] => mariage
                        )
                )
        )*/


    $query = new WP_Query($args);

    // Affichage des résultats
    if ($query->have_posts()) {
        
        if($isSingledPost !== false) {
            
            $posts_array = array();

            while ($query->have_posts()) {
                $query->the_post();
                
                $post_id_boucle_while = get_the_ID();

                if($post_id_boucle_while !== $curent_postPage_id) {
                    $posts_array[] = [
                        'ID'      => get_the_ID(),
                        'title'   => get_the_title(),
                        'url'     => get_permalink(),
                        'image'   => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                    ];
                }// Fin de if($post_id_boucle_while !== $curent_postPage_id)
            }// Fin de while ($query->have_posts())

            // Mélange 3x l'ordre des posts
            uasort($posts_array, fn() => rand(-1, 1));
            $selected_posts = array_slice($posts_array, 0, 2);
            //print_r($selected_posts);//////

            if (!empty($selected_posts)) {
                echo "<section class='photosLiees' >";
                echo "<h3>VOUS AIMEREZ AUSSI</h3>";
                echo "\n <div class='imgX2' >";

                foreach($selected_posts as $key_postArray => $value_postArray) {
                    //echo '- Nombre total de posts récupérés : ' . count($posts_array) . '<br>';//////
                    //print_r($value_postArray);//////
                    /*Array
                        (
                            [ID] => 311
                            [title] => Team mariée
                            [url] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/photo/team-mariee/
                            [image] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/wp-content/uploads/2025/02/nathalie-15-pso.jpg
                        )
                        Array
                        (...)*/
                //}

                    $curent_id = $value_postArray['ID'];
                    $curent_titre = $value_postArray['title'];
                    $curent_image_url = $value_postArray['image'];
                    $curent_image_url = $curent_image_url.".webp";

                    $curent_post_url = $value_postArray['url'];

                    if($curent_id !== $post_id) {
                        echo "\n <a href='".$curent_post_url."' title='".$curent_titre."' class='randomImgLink' >";
                            echo "<img src='".$curent_image_url."' title='".$curent_titre."' alt='".$curent_titre."' >";
                        echo "</a>";
                    }// Fin de if($curent_id !== $post_id)
                    
                }// Fin de foreach($selected_posts as $key_postArray => $value_postArray)
            }
            else {
                echo "<section class='photosLiees' >";
                echo "\n <div class='imgX2' >";
                echo "<p> Pas d'autres photos dans cette catégorie";
                }// Fin de if (!empty($selected_posts))


        } else {
            echo "\n <p>Aucune photo trouvée.</p>";
            }// Fin de if($isSingledPost !== false)
    } else {
        echo "\n <p>Aucune photo trouvée.</p>";
        }// Fin de if ($query->have_posts()) + else

    echo '</div>';
echo "</section>";

    // Réinitialiser la requête
    wp_reset_postdata();
}

?>