var container = document.getElementById("#animal")
var input = document.getElementById("#doador")

input.addEventListener("click", function() {
    if(container.style.display === "table-cell"){
        container.style.display = "none";
    } else{
        container.style.display = "table-cell";
    }
})