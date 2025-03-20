<?php

/*------------------------- On récupère les infos du post -----------------------------------*/
$post_id = get_the_ID();

$titre = get_the_title($post_id);
$image_url = get_the_post_thumbnail_url($post_id, 'full');
$image_url = $image_url.".webp";

// On attribut les valeurs aux taxonomy CPT UI
$categorie_objet = get_the_terms($post_id, 'categorie');
$categorie = $categorie_objet[0]->name;

$format_objet = get_the_terms($post_id, 'format');
$format = $format_objet[0]->name;

// On récupère les customs fields SCF
$type = get_post_meta($post_id, 'type', true);
$reference = get_post_meta($post_id, 'reference', true);
$annee = get_post_meta($post_id, 'annee', true);

?>

<!---------------------------------------- Affichage du post ---------------------------------------->
<article class="single_post_article" >

    <!------------ Div des infos du poast --------------------->
    <div class="infos_du_post" >
        <h2><?php echo $titre; ?></h2>
        <div class="infos_post_item" >
            Référence : <?php echo $reference; ?>
        </div>
        <div class="infos_post_item" >
            Catégorie : <?php echo $categorie; ?>
        </div>
        <div class="infos_post_item" >
            Format : <?php echo $format; ?>
        </div>
        <div class="infos_post_item" >
            Type : <?php echo $type; ?>
        </div>
        <div class="infos_post_item" >
            Année : <?php echo $annee; ?>
        </div>

        <!--<br />
        <hr>-->

    </div>
    
    <hr />

    <!---------------- Image de droite ---------------------->
    <div class="image_du_post" >
        <?php
        if($format == 'Portrait') {
            echo "<img src='".$image_url."' alt='".$titre."' title='".$titre."' class='img_portrait' >";
        }
        if($format == 'Paysage') {
            echo "<img src='".$image_url."' alt='".$titre."' title='".$titre."' class='img_paysage' >";
        }
        ?>
    </div>
</article>

<!------------------------ Template part block 2 photos ------------------>
<?php get_template_part('template-parts/bloc_2photos_dans_single'); ?>
