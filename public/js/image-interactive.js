document.addEventListener("DOMContentLoaded", function() {
    let areas = document.querySelectorAll("area");
    let tooltip = document.getElementById("tooltip");
    let image = document.getElementById("interactive-image");
    let canvas = document.getElementById("canvas-overlay");
    let ctx = canvas.getContext("2d");

    // Fonction pour ajuster le canvas et redessiner les cercles
    function adjustCanvasSize() {
        canvas.width = image.clientWidth;
        canvas.height = image.clientHeight;
        drawCircles();
    }

    // Fonction pour dessiner uniquement les cercles
    function drawCircles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height); // Effacer le canvas
        ctx.strokeStyle = "red"; // Couleur des cercles
        ctx.lineWidth = 2; // Épaisseur du contour

        let originalWidth = image.naturalWidth;
        let originalHeight = image.naturalHeight;
        let scaleX = canvas.width / originalWidth;
        let scaleY = canvas.height / originalHeight;

        areas.forEach(area => {
            let coords = area.getAttribute("coords").split(",").map(Number);
            if (area.shape === "circle") {
                let x = coords[0] * scaleX;
                let y = coords[1] * scaleY;
                let radius = coords[2] * scaleX; // Appliquer le même ratio X pour le rayon
                ctx.beginPath();
                ctx.arc(x, y, radius, 0, 2 * Math.PI);
                ctx.stroke();
            }
        });
    }

    // S'assurer que l'image est bien chargée avant d'ajuster le canvas
    image.onload = function() {
        adjustCanvasSize();
    };

    // Redessiner les cercles au redimensionnement de la fenêtre
    window.addEventListener("resize", adjustCanvasSize);

    // **Forcer le redessin au rechargement de la page**
    setTimeout(adjustCanvasSize, 500);

    // Afficher la bulle de texte au clic
    areas.forEach(area => {
        area.addEventListener("click", function(event) {
            event.preventDefault();

            let tooltipText = this.getAttribute("data-tooltip");
            let coords = this.getAttribute("coords").split(",").map(Number);

            let scaleX = image.clientWidth / image.naturalWidth;
            let scaleY = image.clientHeight / image.naturalHeight;
            let x = coords[0] * scaleX;
            let y = coords[1] * scaleY;

            tooltip.style.left = x + "px";
            tooltip.style.top = y + "px";
            tooltip.textContent = tooltipText;
            tooltip.style.display = "block";
        });
    });

    // Cacher la bulle au clic ailleurs
    image.addEventListener("click", function() {
        tooltip.style.display = "none";
    });
});
