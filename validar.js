function validar(){


var phoneNumber = document.getElementsByName("phoneNumber")[0].value;

var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;




if ((phoneNumber == "")) {  //COMPRUEBA CAMPOS VACIOS
    alert("Debe ingresar un numero de celular");
    return index.html;
}



}