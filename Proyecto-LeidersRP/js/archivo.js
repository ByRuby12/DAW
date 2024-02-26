document.addEventListener("DOMContentLoaded", function() {
    const contenedor = document.querySelector(".contenedor-general");
    const blueButton = document.querySelector(".blue-button");
    const greenButton = document.querySelector(".green-button");
    const redButton = document.querySelector(".red-button");
    const whiteButton = document.querySelector(".white-button");

    blueButton.addEventListener("click", function() {
        contenedor.style.backgroundColor = "blue";
    });

    greenButton.addEventListener("click", function() {
        contenedor.style.backgroundColor = "green";
    });

    redButton.addEventListener("click", function() {
        contenedor.style.backgroundColor = "red";
    });

    whiteButton.addEventListener("click", function() {
        contenedor.style.backgroundColor = "white";
    });
});
