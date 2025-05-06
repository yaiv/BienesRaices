//Menu hamburguesa que oculta y muestra los elementos 
//Tan pronto como se cargue el documento ejecuta esta funcion 
document.addEventListener('DOMContentLoaded', function(){

    eventListeners();
    darkMode();
});

function eventListeners(){
    const mobileMenu = document.querySelector ('.mobile-menu'); //Se eligue elemento del html   
    //Se da clic en mobileMenu -Se registra el click --Se manda a llamar la funcion 
    mobileMenu.addEventListener('click', navegacionResponsive) //Cuando se de click en mobil menu se ejecuta la funcion 
 }

//Se genera clase mostrar al seleccionar la navegacion en responsi
 function navegacionResponsive() {
    const navegacion = document.querySelector ('.navegacion') //Se eligue elemento del html 
    //Si contiene la clase de mostrar, removerla
    if(navegacion.classList.contains('mostrar')){
        navegacion.classList.remove('mostrar');

    }else{//caso contrario agregarla 
        navegacion.classList.add('mostrar');
    }    
 }


 //tambien se puede realizar de otra manera mediante un 
//  function navegacionResponsive() {
//     const navegacion = document.querySelector ('.navegacion') //Se eligue elemento del html 
//     navegacion.classList.toggle('mostrar') //Si se tiene la clase la elimina y si no la tiene la crea 


//Boton para DARK MODE 

//Se genera funcion con toggle 
function darkMode (){
    const btnDarkMode = document.querySelector ('.dark-mode-boton'); //Se eligue elemento del html 
    btnDarkMode.addEventListener('click', function() { //Cuando se de click en btnDarkMode se ejecuta la funcion 
        document.body.classList.toggle('dark-mode'); //toggle va a crear en el body la clase 'dark-mode' en caso de que ya se cuente con ella la remueve 
    })
}

