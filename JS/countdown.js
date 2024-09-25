//Definir la variable en el segundo que empieza

var segundoInicio = 5;

function actualizar() {
    document.getElementById('countdown').innerHTML = segundoInicio;

    if (segundoInicio == 0) {
        window.location.href = "../HTML/pistas.html";
    }else {
        segundoInicio -=1;
        setTimeout(actualizar, 1E3);
    }
}
actualizar();