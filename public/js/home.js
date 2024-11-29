document.querySelectorAll(".card").forEach((card) => {
    card.addEventListener("click", function() {
        window.location = `${this.id}`;
    });
});

