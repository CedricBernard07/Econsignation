
//SECONDAIRE  empêcher le clic droit mene sur Pannellum
document.addEventListener("DOMContentLoaded", function () {
    let panoramaElement = document.getElementById("panorama");

    if (!panoramaElement) return; // Vérifie si l'élément existe

    // Bloquer complètement le menu contextuel Panellum
    document.addEventListener("contextmenu", function (event) {
        if (event.target.closest("#panorama")) {
            event.preventDefault();
        }
    });

    // Vérifier et supprimer le lien contextuel Panellum après son chargement
    function removePannellumContextMenu() {
        let pannellumMenu = document.querySelector(".pnlm-about-msg");
        if (pannellumMenu) {
            pannellumMenu.remove(); // 🔹 Supprime l'élément affichant le lien Panellum
        }
    }

    // Attendre le chargement de Panellum et supprimer le menu
    setTimeout(removePannellumContextMenu, 500); // 🔹 Délai pour s'assurer que Panellum est bien chargé

    // Surveiller les changements de DOM pour détecter si Panellum réaffiche son menu
    let observer = new MutationObserver(removePannellumContextMenu);
    observer.observe(document.body, { childList: true, subtree: true });

    // Désactiver tous les événements liés au menu contextuel
    panoramaElement.addEventListener("mousedown", function (event) {
        if (event.button === 2) { // Clic droit
            event.preventDefault();
        }
    });

    panoramaElement.addEventListener("mouseup", function (event) {
        if (event.button === 2) {
            event.preventDefault();
        }
    });
});
