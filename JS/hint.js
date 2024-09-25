const pistas = [
    {
        titulo: "Primera pista",
        textos: [
            "Este lugar es fresco y lleno de verde. Las aves suelen descansar en sus ramas. Es común ver a la gente leer o relajarse aquí. A menudo, se colocan bancas para descansar. Se encuentra en parques y jardines. Donde los árboles se alzan y el sol apenas pasa.",
        ],
        imagen: "../img/primera_pista.jpg"
    },
    {
        titulo: "Segunda pista",
        textos: [
            "Por aquí, el agua fluye y el tráfico sigue. Es un camino que conecta dos lados. Los barcos pasan por debajo, los autos por encima. Su estructura es vital para la ciudad. Una obra de ingeniería que atraviesa ríos o canales. Donde el agua y la tierra se encuentran, pero no se tocan.",
        ],
        imagen: "../img/segunda_pista.jpg"
    },

];

let currentHintIndex = 0;

function updateHint(index) {
    const tittle = document.getElementById('tittle');
    const textPlaceHolder = document.getElementById('text-placeholder');
    const imagePlaceHolder = document.getElementById('image-placeholder');

    //actualizar titulo de la pista
    tittle.innerText = pistas[index].titulo;

    //limpiar el texto anterior
    textPlaceHolder.innerHTML = '';

    //agregar los nuevos textos
    pistas[index].textos.forEach(texto => {
        const p = document.createElement('p');
        p.innerText = texto;
        textPlaceHolder.appendChild(p);
    });

    //actualizar la imagen
    imagePlaceHolder.src = pistas[index].imagen;
}

//funcion para pasar a la siguiente pista
function nextHint() {
    currentHintIndex = (currentHintIndex + 1) % pistas.length;
    updateHint(currentHintIndex);
}

//inicializar con la primera
updateHint(currentHintIndex);
