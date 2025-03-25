jQuery(document).ready(function($) {
    //console.log('inside ajax(child.js : document.ready !)');//////

    /*------------------------------------ On crée les écouteur d'évènment change des listes déroulantes ----------------------------------*/
    $('#filtre_categorie, #filtre_format, #filtre_type_annee').on('change', function() {
        var categorie = $('#filtre_categorie').val();
        var format = $('#filtre_format').val();
        var typeAnnee = $('#filtre_type_annee').val();
        // On test si c'est une année ou un type qui est envoyé et on extrait le repère entre parenthèses
        var annee = "";
        var type = "";
        if (typeAnnee.includes("(annee)")) {
            annee = typeAnnee.replace("(annee)", "");
            type = "";
        }
        if (typeAnnee.includes("(type)")) {
            annee = "";
            type = typeAnnee.replace("(type)", "");
        }
        
        /*----------------------------------------- Requête AJAX ------------------------------------------------*/
        var divContainerPhotosAccueil = $('#div_container_photos_accueil');

        if ((categorie != undefined || categorie === "") && (format != undefined || format === "") && (type != undefined || type === "") && (annee != undefined || annee === "")) {
            //console.log("Requête AJAX en cours...", { categorie, format, type, annee });//////
            $.ajax({
                type: 'POST',
                url: '/ocdevwp-projet11/motaphoto3/wp-admin/admin-ajax.php', // url WordPress pour traiter les requêtes AJAX
                data: {
                    action: 'get_photos', // identifiant de l'action pour les hooks
                    categorie: categorie,
                    format: format,
                    type: type,
                    annee: annee
                },
                success: function(response) {
                    console.log("Réponse AJAX complète :", response);////// On met la réponse en console

                    if (Array.isArray(response) && response.length > 0) {
                        afficherPhotos(response); // Appel de la fonction de construction du HTML à injecter

                        console.log("AJAX envoyé");//////
                    } else {
                        divContainerPhotosAccueil = $('#div_container_photos_accueil');
                        divContainerPhotosAccueil.html('<p>Aucune image trouvée.</p>');

                        console.log("AJAX pas de photo");//////
                    }
                },
                error: function(xhr, status, error) {
                    // Si une erreur survient pendant l'exécution de la requête AJAX
                    console.error('Erreur AJAX : ', status, error);

                    divContainerPhotosAccueil = $('#div_container_photos_accueil');
                    divContainerPhotosAccueil.html('<p>Une erreur est survenue lors de la récupération des données.</p>');

                    console.log("AJAX erreur de transmission de données", xhr.status, error);//////
                }
            });// Fin de $.ajax(
        }// Fin de if (categorie && format && type && annee)
    });// Fin de $('#filtre_categorie, #filtre_format, #filtre_type_annee').on('change', function()

    /*------------------------------------------------ Fonction de construction du html à injecter -----------------------------------------*/
    // Fonction pour afficher les images retournées par AJAX
    function afficherPhotos(photos) {
        var divContainerPhotosAccueil = $('#div_container_photos_accueil');
        divContainerPhotosAccueil.empty();
        //console.log("afficherPhotos(photos)");//////

        var htmlDivPhotosContent = "";
        
        // On ouvre le div des photos
        //htmlDivPhotosContent = "<div class='div_container_photos_accueil' id='div_container_photos_accueil' >";

        // On boucle pour mettre les photos
        if (photos && photos.length > 0) {
            $.each(photos, function(i, photo) {
            console.table(photo);//////
            
            htmlDivPhotosContent = htmlDivPhotosContent + "<a href='"+photo['url']+"' title='"+photo['titre']+"' target='_blank' >";
            htmlDivPhotosContent = htmlDivPhotosContent + "<img src='"+photo['image']+"' alt='"+photo['titre']+"' title='"+photo['titre']+"' >";
            htmlDivPhotosContent = htmlDivPhotosContent + "</a>";
            });// Fin de $.each(photos, function(i, photo)

        //htmlDivPhotosContent = htmlDivPhotosContent + "</div>";
        // On injecte le HTML dans le div
        divContainerPhotosAccueil.html(htmlDivPhotosContent);
        } 
        else {
            // Si aucune image n'est trouvée, afficher un message
            divContainerPhotosAccueil.html('<p>Aucune photo trouvée.</p>');
            //console.log("Aucune photo trouvée");//////
            }// Fin de if (photos && photos.length > 0) + else
    }// Fin de function afficherPhotos(photos)


    /*------------------------------------------------------------ Action bouton Voir plus ------------------------------------------------------------------------------*/
    // Attachement de l'événement 'click' sur le bouton
    $('#buttonVoirPlus').on('click', function() {
        voirPlus();  // Appel de la fonction
    });

    var currentPage = 1;
    // Onclick bouton Voir plus
    function voirPlus() {
        //console.log("Requête AJAX Voir plus en cours...");//////
        currentPage++;
        // Si la dernière page est atteinte on cache le bouton Voir Plus
        if(currentPage == nb_pages) {
            $('#btnVoirPlus').hide();
        }

        $.ajax({
            type: 'POST',
            url: '/ocdevwp-projet11/motaphoto3/wp-admin/admin-ajax.php', // url WordPress pour traiter les requêtes AJAX
            data: {
                action: 'voir_plus_photos', // identifiant de l'action pour les hooks
                paged: currentPage,
            },
            success: function(response) {
                console.log("Réponse AJAX complète :", response);////// On met la réponse en console

                if (Array.isArray(response) && response.length > 0) {
                    afficherVoirPlusPhotos(response); // Appel de la fonction de construction du HTML à injecter

                    console.log("AJAX envoyé");//////
                } else {
                    divContainerPhotosAccueil = $('#div_container_photos_accueil');
                    divContainerPhotosAccueil.html('<p>Aucune image trouvée.</p>');

                    console.log("AJAX pas de photo");//////
                }
            },
            error: function(xhr, status, error) {
                // Si une erreur survient pendant l'exécution de la requête AJAX
                console.error('Erreur AJAX : ', status, error);
                divContainerPhotosAccueil = $('#div_container_photos_accueil');
                divContainerPhotosAccueil.html('<p>Une erreur est survenue lors de la récupération des données.</p>');
                console.log("AJAX erreur de transmission de données", xhr.status, error);//////
            }
        });// Fin de $.ajax(

        //-=====================================================> $('#buttonVoirPlus').hide(); !!!!!!!!!!!!!!!!!!!!!!4+
    }// Fin de function voirPlus()


    //------------------------------ Fonction de cosntruction du HTML -------------------------//
    function afficherVoirPlusPhotos(photos) {
        var divContainerPhotosAccueil = $('#div_container_photos_accueil');
        //console.log("Inside afficherVoirPlusPhotos(plusDePhotos)");//////

        var htmlDivPhotosContentAccueil = divContainerPhotosAccueil.html();
        
        // On boucle pour mettre les photos
        if (photos && photos.length > 0) {
            $.each(photos, function(i, photo) {
            console.table(photo);//////
            
            htmlDivPhotosContentAccueil = htmlDivPhotosContentAccueil + "<a href='"+photo['url']+"' title='"+photo['titre']+"' target='_blank' >";
            htmlDivPhotosContentAccueil = htmlDivPhotosContentAccueil + "<img src='"+photo['image']+"' alt='"+photo['titre']+"' title='"+photo['titre']+"' >";
            htmlDivPhotosContentAccueil = htmlDivPhotosContentAccueil + "</a>";
            });// Fin de $.each(photos, function(i, photo)

        // On ajoute le HTML dans le div
        divContainerPhotosAccueil.html(htmlDivPhotosContentAccueil);

        } else {
            // Si aucune image n'est trouvée, afficher un message
            divContainerPhotosAccueil.html('<p>Aucune photo trouvée.</p>');
            //console.log("Aucune photo trouvée");//////
        }// Fin de if (photos && photos.length > 0) + else
    }// Fin de function afficherVoirPlusPhotos(plusDePhotos)

});// Fin de jQuery(document).ready(function($)