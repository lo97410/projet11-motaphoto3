<?php

/*-------------------------- Récupération des fiches et leurs données ------------------------------*/
$args = array(
    'post_type'      => 'fiches-photos',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
);

$query = new WP_Query($args);

$current_array_photo = array();
$array_photos = array(); // Tableau final contenant les posts et leurs taxonomies

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();

        $post_id = get_the_ID();
        $imgPhoto = get_post_meta($post_id,'fichier-image', true);

        $current_array_photo['post_id'] = $post_id;
        $current_array_photo['post_titre'] = get_the_title($post_id);
        $current_array_photo['post_url'] = get_permalink($post_id);
        $current_array_photo['post_img'] = get_post_meta($post_id,'fichier-image', true);
        $current_array_photo['post_img_url'] = wp_get_attachment_url($imgPhoto);
        $current_array_photo['post_annee'] = wp_get_post_terms($post_id,'annee', );
        $current_array_photo['post_format'] = wp_get_post_terms($post_id,'format', );
        $current_array_photo['post_type'] = wp_get_post_terms($post_id,'photo-type', );
        $current_array_photo['post_categorie'] = wp_get_post_terms($post_id,'categories-photo', );

        $array_photos[$post_id] = $current_array_photo;
    }// Fin de while ($query->have_posts())
}// Fin de if ($query->have_posts())

/*print_r($array_photos);//////
Array
(
    [0] => Array
        (
            [post_id] => 231
            [post_titre] => Team mariée
            [post_url] => http://127.0.0.1/ocdevwp-projet11/motaphoto2/fiches-photos/team-mariee/
            [post_img] => 180
            [post_img_url] => http://127.0.0.1/ocdevwp-projet11/motaphoto2/wp-content/uploads/2025/02/nathalie-15-pso.jpg
            [post_annee] => Array
                (
                    [0] => WP_Term Object
                        (
                            [term_id] => 16
                            [name] => 2022
                            [slug] => 2022
                            [term_group] => 0
                            [term_taxonomy_id] => 16
                            [taxonomy] => annee
                            [description] => 
                            [parent] => 0
                            [count] => 7
                            [filter] => raw
                        )

                )

            [post_format] => Array
                (
                    [0] => WP_Term Object
                        (
                            [term_id] => 18
                            [name] => Portrait
                            [slug] => portrait
                            [term_group] => 0
                            [term_taxonomy_id] => 18
                            [taxonomy] => format
                            [description] => 
                            [parent] => 0
                            [count] => 6
                            [filter] => raw
                        )

                )

            [post_type] => Array
                (
                    [0] => WP_Term Object
                        (
                            [term_id] => 20
                            [name] => Numérique
                            [slug] => numerique
                            [term_group] => 0
                            [term_taxonomy_id] => 20
                            [taxonomy] => photo-type
                            [description] => 
                            [parent] => 0
                            [count] => 11
                            [filter] => raw
                        )

                )

            [post_categorie] => Array
                (
                    [0] => WP_Term Object
                        (
                            [term_id] => 11
                            [name] => Mariage
                            [slug] => mariage
                            [term_group] => 0
                            [term_taxonomy_id] => 11
                            [taxonomy] => categories-photo
                            [description] => 
                            [parent] => 0
                            [count] => 9
                            [filter] => raw
                        )

                )

        )
)
*/

wp_reset_postdata();

/*-------------------------------------------- Création des tableaux des filtres ---------------------------*/

$array_annee_photos = array();
$array_formats_photos = array();
$array_photos_types = array();
$array_categories_photos = array();


foreach($array_photos as $key => $curent_fiche_photo) {
    /*print_r($curent_fiche_photo);//////
    Array
        (
            [post_id] => 231
            [post_titre] => Team mariée
            [post_url] => http://127.0.0.1/ocdevwp-projet11/motaphoto2/fiches-photos/team-mariee/
            [post_img] => 180
            [post_img_url] => http://127.0.0.1/ocdevwp-projet11/motaphoto2/wp-content/uploads/2025/02/nathalie-15-pso.jpg
            [post_annee] => Array
                (
                    [0] => WP_Term Object
                        (
                            [name] => 2022
                            [slug] => 2022
                            [term_group] => 0
                            [term_taxonomy_id] => 16
                            [taxonomy] => annee
                            [description] => 
                            [parent] => 0
                            [count] => 7
                            [filter] => raw
                        )

                )

            [post_format] => Array
                (
                    [0] => WP_Term Object
                        (
                            [term_id] => 18
                            [name] => Portrait
                            [slug] => portrait
                            [term_group] => 0
                            [term_taxonomy_id] => 18
                            [taxonomy] => format
                            [description] => 
                            [parent] => 0
                            [count] => 6
                            [filter] => raw
                        )

                )

            [post_type] => Array
                (
                    [0] => WP_Term Object
                        (
                            [term_id] => 20
                            [name] => Numérique
                            [slug] => numerique
                            [term_group] => 0
                            [term_taxonomy_id] => 20
                            [taxonomy] => photo-type
                            [description] => 
                            [parent] => 0
                            [count] => 11
                            [filter] => raw
                        )

                )

            [post_categorie] => Array
                (
                    [0] => WP_Term Object
                        (
                            [term_id] => 11
                            [name] => Mariage
                            [slug] => mariage
                            [term_group] => 0
                            [term_taxonomy_id] => 11
                            [taxonomy] => categories-photo
                            [description] => 
                            [parent] => 0
                            [count] => 9
                            [filter] => raw
                        )

                )

        )*/

    // Définiton des variables
    $curent_id_photo = $curent_fiche_photo['post_id'];

    $curent_slug_annee_photo = $curent_fiche_photo['post_annee'][0]->slug;
    $curent_annee_photo = $curent_fiche_photo['post_annee'][0]->name;

    $curent_slug_format_photo = $curent_fiche_photo['post_format'][0]->slug;
    $curent_format_photo = $curent_fiche_photo['post_format'][0]->name;

    $curent_slug_type_photo = $curent_fiche_photo['post_type'][0]->slug;
    $curent_type_photo = $curent_fiche_photo['post_type'][0]->name;

    $curent_slug_categorie_photo = $curent_fiche_photo['post_categorie'][0]->slug;
    $curent_categorie_photo = $curent_fiche_photo['post_categorie'][0]->name;

    // On remplis les tableaux en testant si la clé existe
    if (!array_key_exists($curent_annee_photo, $array_annee_photos)) {
        $array_annee_photos[$curent_annee_photo] = array();
        $array_annee_photos[$curent_annee_photo][$curent_slug_annee_photo] = array();
        $array_annee_photos[$curent_annee_photo][] = $curent_id_photo;
    }
    else {
        $array_annee_photos[$curent_annee_photo][] = $curent_id_photo;
        }

    if (!array_key_exists($curent_format_photo, $array_formats_photos)) {
        $array_formats_photos[$curent_format_photo] = array();
        $array_formats_photos[$curent_format_photo][] = $curent_id_photo;
    }
    else {
        $array_formats_photos[$curent_format_photo][] = $curent_id_photo;
        }

    if (!array_key_exists($curent_type_photo, $array_photos_types)) {
        $array_photos_types[$curent_type_photo] = array();
        $array_photos_types[$curent_type_photo][] = $curent_id_photo;
    }
    else {
        $array_photos_types[$curent_type_photo][] = $curent_id_photo;
        }

    if (!array_key_exists($curent_categorie_photo, $array_categories_photos)) {
        $array_categories_photos[$curent_categorie_photo] = array();
        $array_categories_photos[$curent_categorie_photo][] = $curent_id_photo;
    }
    else {
        $array_categories_photos[$curent_categorie_photo][] = $curent_id_photo;
        }

}// Fin de foreach($array_photos as $key => $curent_fiche_photo)
/*print_r($array_annee_photos);//////
Array
    (
        [2022] => Array
            (
                [0] => 231
                [1] => 229
                [2] => 227
                [3] => 225
                [4] => 223
                [5] => 221
                [6] => 219
            )

        [2021] => Array
            (
                [0] => 217
                [1] => 211
                [2] => 202
            )

        [2019] => Array
            (
                [0] => 215
                [1] => 204
                [2] => 200
                [3] => 198
            )

        [2020] => Array
            (
                [0] => 213
                [1] => 209
            )
    )*/
/*print_r($array_formats_photos);//////
Array
    (
        [Portrait] => Array
            (
                [0] => 231
                [1] => 227
                [2] => 217
                [3] => 211
                [4] => 209
                [5] => 204
            )

        [Paysage] => Array
            (
                [0] => 229
                [1] => 225
                [2] => 223
                [3] => 221
                [4] => 219
                [5] => 215
                [6] => 213
                [7] => 202
                [8] => 200
                [9] => 198
            )

    )*/
/*print_r($array_photos_types);//////
Array
    (
        [Numérique] => Array
            (
                [0] => 231
                [1] => 227
                [2] => 225
                [3] => 221
                [4] => 219
                [5] => 217
                [6] => 215
                [7] => 213
                [8] => 211
                [9] => 209
                [10] => 202
            )

        [Argentique] => Array
            (
                [0] => 229
                [1] => 223
                [2] => 204
                [3] => 200
                [4] => 198
            )

    )*/
/*print_r($array_categories_photos);//////
Array
    (
        [Mariage] => Array
            (
                [0] => 231
                [1] => 229
                [2] => 227
                [3] => 219
                [4] => 215
                [5] => 213
                [6] => 211
                [7] => 209
                [8] => 204
            )

        [Concert] => Array
            (
                [0] => 225
                [1] => 223
                [2] => 217
                [3] => 202
            )

        [Télévision] => Array
            (
                [0] => 221
            )

        [Réception] => Array
            (
                [0] => 200
                [1] => 198
            )

    )*/

/*-------------------------------- On crée les html des listes de selection ------------------------------*/
// Selection de catégorie :
$html_select_categorie = "\n <select name='' onchange='changeList(this.value);' >";
foreach($array_categories_photos as $key => $array) {

    /*print_r($array);//////
    Array
        (
            [0] => 231
            [1] => 229
            [2] => 227
            [3] => 219
            [4] => 215
            [5] => 213
            [6] => 211
            [7] => 209
            [8] => 204
        )
        Array
        (
            [0] => 225
            [1] => 223
            [2] => 217
            [3] => 202
        )
        Array
        (
            [0] => 221
        )
        Array
        (
            [0] => 200
            [1] => 198
        )*/

    $html_select_categorie = $html_select_categorie."\n <option value=".$curent_slug_categorie_photo." >".$curent_categorie_photo."</option>";
}
$html_select_categorie = $html_select_categorie."</select>";
echo $html_select_categorie;

?>