<?php
session_start();

// Arguments de la requête WP_Query pour obtenir tous les posts
$args = array(
    'post_type'      => 'photo',  // Type de contenu : ici 'post' pour les articles
    'posts_per_page' => -1,      // -1 signifie qu'on veut récupérer tous les posts
);

// Lancer la requête WP_Query
$query = new WP_Query($args);

// Si des posts existent, on les affiche
if ($query->have_posts()) {
    $array_all_posts = array();
    $nb_all_posts = 0;
    
    while ($query->have_posts()) {
        $query->the_post();  // Prépare le post pour affichage

        $post_id = get_the_ID();
        $array_all_posts[$post_id] = array();

        $post_title = get_the_title();
        $post_link = get_permalink();

        $post_image = get_the_post_thumbnail($post->ID, 'medium');

        $array_all_posts[$post_id]['id'] = $post_id;
        $array_all_posts[$post_id]['titre'] = $post_title;
        $array_all_posts[$post_id]['url'] = $post_link;


        $categories = get_the_terms($post_id, 'categorie');
        //print_r($categorie);//////
        if ($categories) {
            foreach ($categories as $categorie) {
                $curent_categorie_slug = $categorie->slug;
                $curent_categorie_name = $categorie->name;
                $array_all_posts[$post_id]['categorie'] = array();
                $array_all_posts[$post_id]['categorie']['slug'] = $curent_categorie_slug;
                $array_all_posts[$post_id]['categorie']['name'] = $curent_categorie_name;
            }
        }

        $formats = get_the_terms($post_id, 'format');
        if ($formats) {
            foreach($formats as $format) {
                $curent_format_slug = $format->slug;
                $curent_format_name = $format->name;
                $array_all_posts[$post_id]['format'] = array();
                $array_all_posts[$post_id]['format']['slug'] = $curent_format_slug;
                $array_all_posts[$post_id]['format']['name'] = $curent_format_name;
            }
        }

        $type = get_post_meta($post_id, 'type', true);
        if ($type !== null) {
                $array_all_posts[$post_id]['type'] = $type;
        }

        $reference = get_post_meta($post_id, 'reference', true);
        if ($reference !== null) {
                $array_all_posts[$post_id]['reference'] = $reference;
        }

        $annee = get_post_meta($post_id, 'annee', true);
        if ($annee !== null) {
                $array_all_posts[$post_id]['annee'] = $annee;
        }

        $image = get_the_post_thumbnail_url($post_id, 'large');
        if ($image !== null) {
            $image = $image.".webp";
            $array_all_posts[$post_id]['image'] = $image;
        }

    }// Fin de while($query->have_posts())
        
    /*print_r($array_all_posts);//////
    Array
    (
        [311] => Array
            (
                [id] => 311
                [titre] => Team mariée
                [url] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/photo/team-mariee/
                [categorie] => Mariage
                [format] => Portrait
                [type] => Numérique
                [reference] => bf2400
                [annee] => 2022
                [image] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/wp-content/uploads/2025/02/nathalie-15-pso-684x1024.jpg.webp
            )
    ... )*/

    $nb_posts = count($array_all_posts);
    $nb_voir_plus = ceil($nb_posts / 8);
    $numero_voir_plus = 1;
    $count = 0;
    $array_voir_plus = array();
    if($array_all_posts) {
        foreach($array_all_posts as $post) {
            /*print_r($post);//////
            [id] => 295
            [titre] => Santé !
            [url] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/photo/sante/
            [categorie] => Réception
            [format] => Paysage
            [type] => Argentique
            [reference] => bf2385
            [annee] => 2019
            [image] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/wp-content/uploads/2025/02/nathalie-0-pso-1024x682.jpg.webp*/

            $count = $count + 1;
            //echo " - count : ".$count." - numero_voir_plus : ".$numero_voir_plus."<br />";//////
            if($count <= 8) {
                $post_id =  $post['id'];
                $array_voir_plus[$numero_voir_plus][$post_id] = array();
                $array_voir_plus[$numero_voir_plus][$post_id] = $post;
            }
            else {
                $count = 0;
                $numero_voir_plus = $numero_voir_plus +1;
            }
        }// Fin de foreach($array_all_posts as $post)
    }// Fin de if($array_all_posts)

    /*print_r($array_voir_plus);//////
    (
        [1] => Array
            (
                [311] => Array
                    (
                        [id] => 311
                        [titre] => Team mariée
                        [url] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/photo/team-mariee/
                        [categorie] => Mariage
                        [format] => Portrait
                        [type] => Numérique
                        [reference] => bf2400
                        [annee] => 2022
                        [image] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/wp-content/uploads/2025/02/nathalie-15-pso-684x1024.jpg.webp
                    )
            )
    )*/

    if($array_voir_plus) {
        $_SESSION['array_voir_plus'] = $array_voir_plus;
    }

    /*---------------------- On crée les tableaux pour afficher les listes déroulantes de filtrage des posts ----------------------*/
    if($array_all_posts) {
        $filtre_categorie = array();
        $filtre_format = array();
        $filtre_type = array();
        $filtre_annee = array();

        foreach($array_all_posts as $id_post => $single_post) {
            /*Array array_all_posts
            (
                [311] => Array
                    (
                        [id] => 311
                        [titre] => Team mariée
                        [url] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/photo/team-mariee/
                        [categorie] => Mariage
                        [format] => Portrait
                        [type] => Numérique
                        [reference] => bf2400
                        [annee] => 2022
                        [image] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/wp-content/uploads/2025/02/nathalie-15-pso-684x1024.jpg.webp
                    )
            ... )*/

            /*print_r($single_post);//////
            Array
                (
                    [id] => 310
                    [titre] => Du soir au matin
                    [url] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/photo/du-soir-au-matin/
                    [categorie] => Mariage
                    [format] => Portrait
                    [type] => Argentique
                    [reference] => bf2399
                    [annee] => 2022
                    [image] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/wp-content/uploads/2025/02/nathalie-14-pso-682x1024.jpg.webp
                )*/

                $curent_postId = $single_post['id'];
                $curent_post_categorie = $single_post['categorie'];
                /*print_r($curent_post_categorie);//////
                Array
                    (
                    [slug] => mariage
                    [name] => Mariage
                    )*/

                //print_r($filtre_categorie);//////
                if(empty($filtre_categorie)) {
                    $filtre_categorie[] = $curent_post_categorie;
                    }

                $slug_présent = false;
                $array_slugs_presents = array_column($filtre_categorie, 'slug');
                /*echo "\n <br />******************* array_slugs_presents ***********************<br />";//////
                print_r($array_slugs_presents);//////*/

                foreach($array_slugs_presents as $slug_present) {
                    /*echo "\n <br />******************* slugs_present - curent_post_categorie['slug'] : ".$curent_post_categorie['slug']." ***********************<br />";//////
                    print_r($slug_present);//////*/

                    if($slug_present == $curent_post_categorie['slug']) {
                        $slug_présent = true;
                    }
                }// Fin de foreach($array_slugs_presents as $slug_present)
                if($slug_présent == false) {
                    $filtre_categorie[] = $curent_post_categorie;
                }
                
                $curent_postId = $single_post['id'];
                $curent_post_format = $single_post['format'];
                /*print_r($curent_post_format);//////
                Array
                    (
                    [slug] => mariage
                    [name] => Mariage
                    )*/

                //print_r($filtre_format);//////
                if(empty($filtre_format)) {
                    $filtre_format[] = $curent_post_format;
                    }

                $slug_présent = false;
                $array_slugs_presents = array_column($filtre_format, 'slug');
                /*echo "\n <br />******************* array_slugs_presents ***********************<br />";//////
                print_r($array_slugs_presents);//////*/

                foreach($array_slugs_presents as $slug_present) {
                    /*echo "\n <br />******************* slugs_present - curent_post_format['slug'] : ".$curent_post_format['slug']." ***********************<br />";//////
                    print_r($slug_present);//////*/

                    if($slug_present == $curent_post_format['slug']) {
                        $slug_présent = true;
                    }
                }// Fin de foreach($array_slugs_presents as $slug_present)
                if($slug_présent == false) {
                    $filtre_format[] = $curent_post_format;
                }
                                
                $curent_post_type = $single_post['type'];
                if(!in_array($curent_post_type, $filtre_type)) {
                    $filtre_type[] = $curent_post_type;
                }

                $curent_post_annee = $single_post['annee'];
                if(!in_array($curent_post_annee, $filtre_annee)) {
                    $filtre_annee[] = $curent_post_annee;
                }
            
        }// Fin de foreach($array_all_posts as $id_post => $single_post)

        sort($filtre_categorie);
        sort( $filtre_format);
        sort($filtre_type);
        sort($filtre_annee);
    
        /*echo "<br /> - filtre_categorie :<br />";
        print_r($filtre_categorie);//////
        echo "<br /><br /> - filtre_format :<br />";
        print_r($filtre_format);//////
        echo "<br /><br /> - filtre_type :<br />";
        print_r($filtre_type);//////
        echo "<br /><br /> - filtre_categorie :<br />";
        print_r($filtre_annee);//////*/

        /*-------------------------------------------- On affiche les listes déroulantes de filtrage ------------------------------*/
        echo "\n <section class='div_container_filtres' >";
        echo "\n <div class='div_filtres' >";
            echo "\n <div class='div_filtre_gauche' >";
                
                echo "\n <select name='filtre_categorie' id='filtre_categorie' class='select_liste_deroulante' >";
                    echo "\n <option value='' class='option_liste_deroulante' >Catégorie</option>";
                    foreach($filtre_categorie as $key_categorie => $curent_categorie) {
                        var_dump($curent_categorie);//////
                        echo "\n <option value='".$curent_categorie['slug']."' >".$curent_categorie['name']."</option>";
                        }
                echo "\n </select>";

                echo "\n <select name='filtre_format' id='filtre_format' class='select_liste_deroulante' >";
                    echo "\n <option value='' class='option_liste_deroulante' >Format</option>";
                    foreach($filtre_format as $curent_format) {
                        echo "\n <option value='".$curent_format['slug']."' >".$curent_format['name']."</option>";
                        }

                echo "\n </select>";
            echo "\n </div>";

            echo "\n <div class='div_filtre_droite' >";

                echo "\n <select name='filtre_type_annee' id='filtre_type_annee' class='select_liste_deroulante' >";
                    echo "\n <option value='' class='option_liste_deroulante' >Trier par</option>";

                    echo "\n <optgroup label='Années' >";
                    foreach($filtre_annee as $curent_annee) {
                        echo "\n <option value='".$curent_annee."(annee)' >".$curent_annee."</option>";
                    }
                    echo "\n </optgroup>";

                    echo "\n <optgroup label='Type' >";
                    foreach($filtre_type as $curent_type) {
                        echo "\n <option value='".$curent_type."(type)' >".$curent_type."</option>";
                    }
                    echo "\n </optgroup>";

                echo "\n </select>";

            echo "\n </div>";

        echo "\n </div>";
        echo "\n </section>";

        /*----------------------------------------------- On affiche les 8 photos d'origne ---------------------------------*/
        echo "\n <div class='div_container_photos_accueil' id='div_container_photos_accueil' >";
            $nb_photos_affichees = 0;

            foreach($array_voir_plus[1] as $key_voir_plus => $array_voir_plus) {
                /*print_r($array_voir_plus);//////
                Array
                    (
                        [id] => 311
                        [titre] => Team mariée
                        [url] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/photo/team-mariee/
                        [categorie] => Mariage
                        [format] => Portrait
                        [type] => Numérique
                        [reference] => bf2400
                        [annee] => 2022
                        [image] => http://127.0.0.1/ocdevwp-projet11/motaphoto3/wp-content/uploads/2025/02/nathalie-15-pso-684x1024.jpg.webp
                    )*/

                echo "\n <a href='".$array_voir_plus['url']."' title='".$array_voir_plus['titre']."' >";
                    echo "\n <img src='".$array_voir_plus['image']."' alt='".$array_voir_plus['titre']."' title='".$array_voir_plus['titre']."' >";
                echo "\n </a>";
            }// Fin de foreach($array_voir_plus[1] as $key_voir_plus => $array_voir_plus)
        echo "\n </div>";

        }// Fin de if($array_all_posts)
    
    }// Fin de if ($query->have_posts())
    else {
        echo 'Aucune photos trouvée.';
    }
        
    // Réinitialiser les données de post après la boucle
    wp_reset_postdata();

?>