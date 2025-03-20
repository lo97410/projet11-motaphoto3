<?php
/*------------------- Infos du post ------------------*/
$post_id = get_the_ID();

$infos_single_post = array();

// Titre et contenu du post
if ($post && $post->post_type === 'fiches-photos') {
    $titre_h2 = esc_html($post->post_title);
    $infos_single_post['titre_h2'] = $titre_h2;
    } else {
        echo 'Post non trouvé ou incorrect.';
    }

// Metadatas : champs du post
$meta_data = get_post_meta($post_id);

$titre_de_la_photo = $meta_data['titre_de_la_photo'][0];
$infos_single_post['titre_de_la_photo'] = $titre_de_la_photo;

$reference_de_la_photo = $meta_data['reference_de_la_photo'][0];
$infos_single_post['reference_de_la_photo'] = $reference_de_la_photo;

$image_id = $meta_data['fichier-image'][0];
$infos_single_post['image_id'] = $image_id;

$image_url_jpg = wp_get_attachment_url($image_id);
$infos_single_post['image_url_jpg'] = $image_url_jpg;

$image_path = wp_get_attachment_url($image_id);
// On ajoute .webp après le .jpg => apellation Imagify
$image_path = $image_path.".webp";
$infos_single_post['image_path'] = $image_path;

$image_filename = pathinfo($image_path, PATHINFO_FILENAME);
$infos_single_post['image_filename'] = $image_filename;

// Taxonomie(s) du post
$taxonomies = get_object_taxonomies('fiches-photos', 'names');

// Récupérer les taxonomies du post type 'fiches-photos'
if (!$post_id || get_post_status($post_id) === false) {
    echo "Erreur : L’ID du post est invalide.";
    return;
}

if (!empty($taxonomies)) {
    $term_taxonomies = array();
    foreach ($taxonomies as $taxonomy) {
        if (!is_string($taxonomy) || empty($taxonomy)) {
            echo 'Erreur : Taxonomie invalide.';
            continue;
        }

        $terms = wp_get_post_terms($post_id, $taxonomy);
            //print_r($terms);//////

        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $terms_taxonomy = array();
                $terms_taxonomy['taxonomy'] = esc_html($taxonomy);
                $terms_taxonomy['name'] = esc_html($term->name);

                $term_taxonomies[] = $terms_taxonomy;
            }      
        }// Fin de if ($terms && !is_wp_error($terms))
    }// Fin de foreach ($taxonomies as $taxonomy)
    //print_r($term_taxonomies);//////
} else {
    echo 'Aucune taxonomie trouvée pour ce type de post.';
    }// Fin de if (!empty($taxonomies)) + else

$infos_single_post['taxonomies'] = $term_taxonomies;
foreach($infos_single_post as $key => $value) {
    if($key == 'taxonomies') {
        foreach($value as $key2 => $value2) {
            //print_r($value2);//////
            /*Array
                (
                    [taxonomy] => annee
                    [name] => 2022
                )
                Array
                (
                    [taxonomy] => format
                    [name] => Paysage
                )
                Array
                (
                    [taxonomy] => photo-type
                    [name] => Argentique
                )
                Array
                (
                    [taxonomy] => categories-photo
                    [name] => Mariage
                )*/
            if($value2['taxonomy'] == 'annee') {
                $anee_photo = $value2['name'];
            }
            if($value2['taxonomy'] == 'format') {
                $format_photo = $value2['name'];
            }
            if($value2['taxonomy'] == 'photo-type') {
                $type_photo = $value2['name'];
            }
            if($value2['taxonomy'] == 'categories-photo') {
                $categories_photo = $value2['name'];
            }
        }// Fin de foreach($value as $key2 => $value2)
    }// Fin de if($key == 'taxonomies')
}// Fin de foreach($infos_single_post as $key => $value)
//print_r($infos_single_post);//////
/*
Array
(
    [titre_h2] => Du soir au matin
    [titre_de_la_photo] => Du soir au matin
    [reference_de_la_photo] => bf2399
    [image_id] => 179
    [image_url_jpg] => http://127.0.0.1/ocdevwp-projet11/motaphoto2/wp-content/uploads/2025/02/nathalie-14-pso.jpg
    [image_path] => http://127.0.0.1/ocdevwp-projet11/motaphoto2/wp-content/uploads/2025/02/nathalie-14-pso.jpg.webp
    [image_filename] => nathalie-14-pso.jpg
    [taxonomies] => Array
        (
            [0] => Array
                (
                    [taxonomy] => annee
                    [name] => 2022
                )

            [1] => Array
                (
                    [taxonomy] => format
                    [name] => Paysage
                )

            [2] => Array
                (
                    [taxonomy] => photo-type
                    [name] => Argentique
                )

            [3] => Array
                (
                    [taxonomy] => categories-photo
                    [name] => Mariage
                )

        )

)
*/

?>

<!---------------------------------------- Affichage du post ---------------------------------------->
<article class="single_post_article" >

    <!------------ Div des infos du poast --------------------->
    <div class="infos_du_post" >
        <h2><?php echo $infos_single_post['titre_h2']; ?></h2>
        <div class="infos_post_item" >
            Référence : <?php echo $infos_single_post['reference_de_la_photo']; ?>
        </div>
        <div class="infos_post_item" >
            Catégorie : <?php echo $categories_photo; ?>
        </div>
        <div class="infos_post_item" >
            Format : <?php echo $format_photo; ?>
        </div>
        <div class="infos_post_item" >
            Type : <?php echo $type_photo; ?>
        </div>
        <div class="infos_post_item" >
            Année : <?php echo $anee_photo; ?>
        </div>

        <!--<br />
        <hr>-->

    </div>
    
    <hr />

    <!---------------- Image de droite ---------------------->
    <div class="image_du_post" >
        <?php
        if($format_photo == 'Portrait') {
            echo "<img src='".$image_path."' alt='".$titre_de_la_photo."' title='".$titre_de_la_photo."' class='img_portrait' >";
        }
        if($format_photo == 'Paysage') {
            echo "<img src='".$image_path."' alt='".$titre_de_la_photo."' title='".$titre_de_la_photo."' class='img_paysage' >";
        }
        ?>
    </div>
</article>

<!------------------------ Template part block photo ------------------>
<?php //get_template_part('template-parts/photo_block'); ?>
