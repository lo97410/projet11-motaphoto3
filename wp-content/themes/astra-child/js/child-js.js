/*--------------------------- Traitements de la modale de contact -----------------------------------*/
// Classe du lien contact : itemMenuContact
let refPhotoToSend= null;
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".itemMenuContact").addEventListener("click", function(event) {
        event.preventDefault(); // Empêche le lien # de fonctionner pour pouvoir appeler le js
        showModaleContact(refPhotoToSend);// Ajouter ref photo !!!!!! //////

        if (event.target.closest(".itemMenuContact")) {
            event.preventDefault(); // Empêche le lien # de fonctionner
            showModaleContact(refPhotoToSend);
        }
    });// Fin de document.querySelector(".itemMenuContact").addEventListener("click"

// Menu burger
document.addEventListener("click", function(event) {
    if (event.target.closest(".itemMenuContact")) {
        event.preventDefault(); // Empêche le lien # de fonctionner
        showModaleContact(refPhotoToSend);
    }
});

    // Bouton de fermeture de modale
    document.querySelector(".closeModale").addEventListener("click", function(event) {
        let modaleContact= document.querySelector("#popup-modale");
        // On lance l'animation de l'opacité avec setTimeout
        let divOpacity= parseFloat(window.getComputedStyle(modaleContact).opacity);
        var interval = setInterval(function() {
            if (divOpacity > 0) {
                divOpacity = divOpacity - 0.05;
                modaleContact.style.opacity = divOpacity;
                console.log('divOpacity > 0 : '+divOpacity)//////
                } else {
                    clearInterval(interval);
                    modaleContact.style.display= 'none';
                    console.log('Mail sent, divOpacity !> 0 : '+divOpacity)//////
                }
        }, 10);// Fin de var interval = setInterval
    });// Fin de document.querySelector(".closeModale").addEventListener("click"
});// Fin de document.addEventListener("DOMContentLoaded"

// Fade in formulaire de contact
const idModaleContact= 'popup-modale';
function showModaleContact(refPhotoToSend) {
    let modaleContact= document.querySelector("#popup-modale");
    modaleContact.style.display= 'flex';

    // On remplis le champs ref photo si var transmise
    if(refPhotoToSend) {
        //console.log(refPhotoToSend);//////
        document.querySelector("#refphotoid").value= refPhotoToSend;
        //$(#refphotoid).val(refPhotoToSend);
    }

     // On lance l'animation de l'opacité avec setTimeout
    let divOpacity= parseFloat(window.getComputedStyle(modaleContact).opacity);
    //console.log('Start divOpacity : '+divOpacity)//////
    var interval = setInterval(function() {
        if (divOpacity < 1) {
            divOpacity= divOpacity + 0.05;
            modaleContact.style.opacity = divOpacity;
            //console.log('divOpacity < 1: '+divOpacity)//////
            } else {
                clearInterval(interval);
                }
    }, 10);// Fin de var interval = setInterval

    // On ferme la modale au submit OK du formulaire
    let formModaleContact = document.querySelector(".wpcf7-form");
    // Écoute de l'événement wpcf7submit
    formModaleContact.addEventListener("wpcf7submit", function(event) {
        // État de la soumission avec event.detail.status
        if (event.detail.status === "mail_sent") {
            console.log("Formulaire envoyé avec succès !");//////
            } else {
                console.log("Erreur dans l'envoi du formulaire : "+event.detail.status);//////
                }

        // Si la soumission du formulaire est ok on ferme la modale
        let sendMailStatus= event.detail.status;
        console.log('Statut final event.detail.status : '+sendMailStatus);//////
        // Si sendMailStatus == mail_failed on considère que c'est OK (l'envois de mail n'étant pas paramétré dans Xampp), on ferme la modale et on affiche une fenêtre alert de confirmation
        if(sendMailStatus == 'mail_failed' || sendMailStatus == 'mail_sent')
                {
                    // On lance l'animation de l'opacité avec setTimeout
                    divOpacity= parseFloat(window.getComputedStyle(modaleContact).opacity);
                    var interval = setInterval(function() {
                        if (divOpacity > 0) {
                            divOpacity = divOpacity - 0.05;
                            modaleContact.style.opacity = divOpacity;
                            console.log('divOpacity > 0 : '+divOpacity)//////
                            } else {
                                clearInterval(interval);
                                alert('Votre message à bien été envoyé');
                                modaleContact.style.display= 'none';
                                //console.log('divOpacity !> 0 : '+divOpacity)//////
                            }
                    }, 10);// Fin de var interval = setInterval
                }// Fin de if(sendMailStatus == 'mail_failed' || sendMailStatus == 'mail_sent')
    });// Fin de formModaleContact.addEventListener("wpcf7submit"
}// Fin de function showModaleContact(refPhotoToSend)

// Survol des photos en page d'accueil
jQuery(document).ready(function() {
    jQuery(".hoverphoto").hover(
        function() {
            jQuery(this).css('opacity', 1);
        },
        function() {
            jQuery(this).css('opacity', 0);
        }
    );
});




