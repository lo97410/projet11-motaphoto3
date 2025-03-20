<?php

/*------------------------------------------------- Section photos liées x2 -------------------------------------------------------------*/
    /*----------------------- Si la page courante est une page fiche photo -------------------------------*/
    $current_url = get_permalink();
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

    // On liste les posts de la même categorie
    $current_url = get_permalink();
    $search_term = "/photo/";
    $isSingledPost = strpos($current_url, $search_term);
    
    if($isSingledPost !== false) {
        $args = array(
            'post_type'      => 'photo',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'categorie',
                    'field'    => 'slug',
                    'terms'    => 'mariage'
                )
            )
        );
    } /*else {
        if(is_front_page() || is_home()) {// Si on est sur la page d'accueil
            $args = array(
                'post_type'      => 'fiches-photos',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            );
        }// Fin de if(is_front_page() || is_home())
        }*/
    //var_dump(get_permalink());//////
    //var_dump(home_url());//////
    //var_dump($args);//////

    $query = new WP_Query($args);
    
    $arrayPostSameCategorie = array();
    $arrayAllPosts = array();

    if($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $postTitre = get_the_title($post_id);
            $postUrl = get_permalink($post_id);
            $categorie_photo = wp_get_post_terms($post_id,'categorie', );
                $imgPhoto = get_post_meta($post_id,'fichier-image', true);
                $urlPostImage = wp_get_attachment_url($imgPhoto);
            // On liste les taxonomies
            /*$taxonomies = get_object_taxonomies('fiches-photos', 'names');
            var_dump($taxonomies);//////
            array(5) {
                [0]=>
                string(11) "post_format"
                [1]=>
                string(5) "annee"
                [2]=>
                string(6) "format"
                [3]=>
                string(10) "photo-type"
                [4]=>
                string(16) "categories-photo"
                }
                ...*/

            // On remplis le tableau des posts de même catégorie si page single
            if($isSingledPost !== false) {
                // Si l'id du post est différent du post affiché
                if($postId != $post_id) {
                    $arrayPostSameCategorie[] = array(
                        'post_id'         => $post_id,
                        'categorie' => $categorie_photo,
                        'fichier-image'   => $imgPhoto,
                        'url_image'       => $urlPostImage
                        );
                    }// Fin de if($postId != $post_id)
                }
                /*else {
                    if(is_front_page() || is_home()) {
                        // On charge le tableau de tous les posts
                    }
                }*/
            }// Fin de while ($query->have_posts())

            //var_dump($arrayAllPosts);//////

        }// Fin de if($query->have_posts())

        wp_reset_postdata(); // Réinitialiser la requête globale !

        //var_dump($arrayPostSameCategorie);//////
        /*    [0]=>
                    array(4) {
                        ["post_id"]=>
                        int(231)
                        ["categorie-photo"]=>
                        array(1) {
                        [0]=>
                        object(WP_Term)#2722 (10) {
                            ["term_id"]=>
                            int(11)
                            ["name"]=>
                            string(7) "Mariage"
                            ["slug"]=>
                            string(7) "mariage"
                            ["term_group"]=>
                            int(0)
                            ["term_taxonomy_id"]=>
                            int(11)
                            ["taxonomy"]=>
                            string(16) "categories-photo"
                            ["description"]=>
                            string(0) ""
                            ["parent"]=>
                            int(0)
                            ["count"]=>
                            int(9)
                            ["filter"]=>
                            string(3) "raw"
                        }
                        }
                        ["fichier-image"]=>
                        string(3) "180"
                        ["url_image"]=>
                        string(91) "http://127.0.0.1/ocdevwp-projet11/motaphoto2/wp-content/uploads/2025/02/nathalie-15-pso.jpg"
                    }*/
        if($isSingledPost !== false) {
            echo "\n <section class='photosLiees' >";
        } /*else {
            echo "\n <section class='photosAllPosts' >";
        }*/

        /*----------------------- Si la page courante est une page fiche photo -------------------------------*/
        if($isSingledPost !== false) {
            // Selection  aléatoire de 2 images de même catégorie
            $arrayRandomImgs = array_rand($arrayPostSameCategorie, 2);
            //var_dump($arrayRandomImgs);//////
            /*array(2) {
                [0]=>
                int(0)
                [1]=>
                int(4)
                }*/
            
            echo "\n <h3>VOUS AIMEREZ AUSSI</h3>";
        } // Fin de if($isSingledPost !== false)
        /*else {
            $arrayRandomImgs = $arrayAllPosts;
            $arrayPostSameCategorie = $arrayAllPosts;
            }*/// + else
        //var_dump($arrayPostSameCategorie);//////

        if($isSingledPost !== false) {
            echo "\n <div class='imgX2' >";
        }
        else {
            get_template_part('template-parts/photo_block_filters');// !!! Page d'acceuil !!! ********************************************

            //echo "\n <div class=' ' >";
        }
        if($isSingledPost !== false) {
            foreach($arrayRandomImgs as $key => $value) {
                var_dump($value);//////

                // On affiche les images / lien vers la fiche du post
                if($isSingledPost !== false) {
                    //$currentRandomPostId = $arrayPostSameCategorie[$value]['post_id'];
                    $currentRandomPostId = $value;
                } /*else {
                    if(is_front_page() || is_home()) {
                        $currentRandomPostId = $value['post_id'];
                        }
                    }*/
                
                $curentRandomPostUrl = get_permalink($currentRandomPostId);
                $curentRandomPostTitle = get_the_title($currentRandomPostId);
                if($isSingledPost !== false) {
                    //$curentRandomPostImgId = $arrayPostSameCategorie[$value]['fichier-image'];
                    $curentRandomPostImgUrl = get_the_post_thumbnail_url($value, 'large');
                    } /*else {
                        if(is_front_page() || is_home()) {
                            $curentRandomPostImgId = $value['fichier-image'];
                        }
                    }*/
                //$curentRandomPostImgUrlMedium = wp_get_attachment_image_src($curentRandomPostImgId, 'large')[0];// Url de l'image taille large
                //$curentRandomPostImgUrl = $curentRandomPostImgUrlMedium;
                
                if($isSingledPost !== false) {
                    echo "\n <a href='".$curentRandomPostUrl."' title='".$curentRandomPostTitle."' class='randomImgLink' >";
                }
                /*else {
                    echo "\n <a href='".$curentRandomPostUrl."' title='".$curentRandomPostTitle."' class='allPostsImgLink' >";
                    }*/
                    echo "\n <img src='".$curentRandomPostImgUrl."' alt='".$curentRandomPostTitle."' title='".$curentRandomPostTitle."' >";
                echo "\n </a>";
            }// Fin de foreach($arrayRandomImgs as $key => $value)
        }// Fin de if($isSingledPost !== false)
        echo "\n </div>";
    echo "\n </section>";

?>