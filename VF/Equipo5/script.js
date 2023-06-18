document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('last-modified').innerHTML = document.lastModified;
});

function mostrarPersona(imagen, texto) {
  document.getElementById('ventanaImagen').src = imagen;
  document.getElementById('ventanaTexto').textContent = texto;
  $('#ventanaPersona').modal('show');
}

function alternarTexto(texto1, texto2) {
  var parrafo = document.getElementById('P_Equipo');
  if (parrafo.textContent === texto1) {
    parrafo.textContent = texto2;
  } else {
    parrafo.textContent = texto1;
  }
}
function alternarTexto2(texto1, texto2) {
  var parrafo = document.getElementById('P_Equipo2');
  if (parrafo.textContent === texto1) {
    parrafo.textContent = texto2;
  } else {
    parrafo.textContent = texto1;
  }
}
function alternarTexto3(texto1, texto2) {
  var parrafo = document.getElementById('P_Equipo3');  
  if (parrafo.textContent === texto1) {
    parrafo.textContent = texto2;
  } else {
    parrafo.textContent = texto1;
  }
}
