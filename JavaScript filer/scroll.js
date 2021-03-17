/* knapp som tar deg til toppen igjen 
  Deler av funksjonen sin kode er fra 
  https://www.w3schools.com/howto/howto_js_scroll_to_top.asp
  hentet 27.05.2020
*/
Toppknapp = document.getElementById("topBtn");
window.onscroll = function() {scrollFunksjon()};
function scrollFunksjon() {
  if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
    Toppknapp.style.display = "block";
  } 
  else {
    Toppknapp.style.display = "none";
  }
}
function backToTop() {
  document.documentElement.scrollTop = 0;
}



/* Funksjon for navbar
Deler av funksjonen sin kode er fra
https://www.w3schools.com/howto/howto_js_topnav_responsive.asp
Hentet 03.12.2019*/
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}

// Skrevet av Sanan
// Kontrollert av Stian