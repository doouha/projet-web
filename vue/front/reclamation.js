document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("recl").addEventListener("submit", validerFormulaire);
});

function validerFormulaire(event) {
    event.preventDefault();
    displayMessage("id_client", "", false);
    displayMessage("contenue", "", false);
    displayMessage("reclamation", "", false);

    var idClient = document.getElementById("id_client").value.trim();
    var contenue = document.getElementById("contenue").value.trim();
    var isValid = true;

    var motsInappropries = ["insulte", "ham", "inutile"];
    var motTrouve = motsInappropries.find(mot => contenue.toLowerCase().includes(mot.toLowerCase()));
    if (idClient === "") {
        displayMessage("id_client", "Le champ ID Client est vide. Veuillez entrer un ID.", true);
        isValid = false;
    }

    if (contenue === "") {
        displayMessage("contenue", "Le champ Contenu est vide. Veuillez entrer une réclamation.", true);
        isValid = false;
    } else if (motTrouve) {
        displayMessage("contenue", "Le message contient des mots inappropriés : '" + motTrouve + "'. Veuillez corriger votre réclamation.", true);
        isValid = false;
    }

    if (isValid) {
        displayMessage("reclamation", "Votre réclamation a été enregistrée avec succès !", false);
        document.getElementById("recl").reset(); 
        setTimeout(() => {
            displayMessage("reclamation", "", false);
        }, 3000);
    } else {
        displayMessage("reclamation", "Veuillez corriger les erreurs avant de soumettre.", true);
    }
}



function displayMessage(id, message, isError) {
    var element = document.getElementById(id + "_error");
    if (element) {
        element.style.color = isError ? "red" : "green";
        element.innerText = message;
    }
}

