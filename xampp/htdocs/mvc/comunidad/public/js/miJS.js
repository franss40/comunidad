document.addEventListener("DOMContentLoaded",function(event){
    
    var abrirSideNav = document.getElementById("openNav");
    var cerrarSideNav = document.getElementById("closeNav");
    var sideNav = document.getElementById("sideNav");
    
    abrirSideNav.addEventListener("click", function(e){
        sideNav.style.width = "100%";
    });
    
    cerrarSideNav.addEventListener("click", function(e){
        sideNav.style.width = "0%";
    });
     
    
});