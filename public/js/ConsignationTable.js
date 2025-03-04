
// Fonction pour recharger le tableau de suivi des etapes de la consignation
function reloadTable() {
    fetch('/parcours/get-score')
        .then(response => {
            if (!response.ok) {
                throw new Error("Problème lors du chargement des scores !");
            }
            return response.json();
        })
        .then(data => {
            if (!data.score) {
                throw new Error("Format de réponse invalide !");
            }

            // Sélectionner toutes les cellules de validation dans le tableau
            document.querySelectorAll(".validation").forEach(cell => {
                let row = cell.parentElement;
                let numCell = row.cells[0]; // Récupérer le N° de l'étape
                let etapeKey = "etape" + numCell.textContent.trim(); // Génère "etape1", "etape2", etc.

                // Met à jour la cellule Validation uniquement
                if (data.score[etapeKey] === 1) {
                    cell.innerHTML = "✅";
                } else if (data.score[etapeKey] === -1) {
                    cell.innerHTML = "❌";
                } else {
                    cell.innerHTML = ""; // Étape non encore réalisée
                }
            });
        })
        .catch(error => console.error("Erreur lors du rechargement du tableau :", error));
}
