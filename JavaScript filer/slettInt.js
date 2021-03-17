// Dokumentet er jevnlig oppdatert av alle gruppemedlemmene
function visMerAk() {
    var domKlasse = document.getElementsByClassName("skjul3-Ak");
    for(var i=0; i<domKlasse.length; i++) {
        domKlasse[i].style.display = "block";
    }
    document.getElementById("vis-mer-Ak").style.display = "none";
    document.getElementById("knappForSkjul-Ak").style.display = "block";
}

function visMindreAk() {
    var domKlasse = document.getElementsByClassName("skjul3-Ak");
    for(var i=0; i<domKlasse.length; i++) {
        domKlasse[i].style.display = "none";
    }
    document.getElementById("knappForSkjul-Ak").style.display = "none";
    document.getElementById("vis-mer-Ak").style.display = "block";
}

function visMerAr() {
    var domKlasse = document.getElementsByClassName("skjul3-Ar");
    for(var i=0; i<domKlasse.length; i++) {
        domKlasse[i].style.display = "inline-block";
    }
    document.getElementById("vis-mer-Ar").style.display = "none";
    document.getElementById("knappForSkjul-Ar").style.display = "block";
}

function visMindreAr() {
    var domKlasse = document.getElementsByClassName("skjul3-Ar");
    for(var i=0; i<domKlasse.length; i++) {
        domKlasse[i].style.display = "none";
    }
    document.getElementById("knappForSkjul-Ar").style.display = "none";
    document.getElementById("vis-mer-Ar").style.display = "block";
}

// Funksjon for å skrive antall ord bruk i bio og melding x/1024
var utTekstFelt = document.getElementById("utTall");
var antallTegn = document.getElementById("antallTegn");
var ord = "";
function endreAntall() {
    var total = utTekstFelt.value;
    antallTegn.innerHTML = total.length+"/1024";
}
// Kjører funksjonen en gang ved start
try {
    endreAntall();
} catch{

}

// Påmelding av arregnement
function tester(eventid) {
    var valgt = document.getElementById("valgar");
    var verdi = valgt.options[valgt.selectedIndex].value;

    console.log(verdi);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "Action/oppdaterArr.php?arrValg="+verdi+"&knappen="+eventid, true);
    xmlhttp.send();

}


function noer(str) {
    if (str.length == 0) {
        document.getElementById("re").innerHTML = "";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("re").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "Action/intEr.php?q=" + str, true);
        xmlhttp.send();
      }
}




// Modal artikkler
var modalinn = document.getElementsByClassName('modal-innhold');
var modal = document.getElementsByClassName('modalid');
var knapp = document.getElementsByClassName('modalKnapp');
var span  = document.getElementsByClassName('close');

for(let i=0;i < knapp.length; i++) {
    knapp[i].onclick = function() {
        modal[i].style.display = 'block';
        modalinn[i].classList.add('active');
        document.querySelector('section.active').id = 'modalSwipe';
    }
}
for(let i=0; i < span.length; i++) {
    span[i].onclick = function() {
        modal[i].style.display = 'none';
        modalinn[i].classList.remove('active');
        modalinn[i].classList.remove('animated');
        modalinn[i].classList.remove('bounceOutRight');
        modalinn[i].classList.remove('bounceOutLeft');
        document.getElementById("modalSwipe").setAttribute("id", "");
    }
}
for(let i=0; i < modal.length; i++) {
    window.addEventListener('click', function(event) {
        if(event.target == modal[i]) {
            modal[i].style.display = 'none';
            modalinn[i].classList.remove('active');
            modalinn[i].classList.remove('animated');
            modalinn[i].classList.remove('bounceOutRight');
            modalinn[i].classList.remove('bounceOutLeft');
            document.getElementById("modalSwipe").setAttribute("id", "");
        }
    })
}

/* SWIPE */
var lbl;
function SWIPE() {
lbl = document.getElementById("modalSwipe");

lbl.addEventListener("touchstart", startTouch, false);
lbl.addEventListener("touchend", endTouch, false);
lbl.addEventListener("touchmove", moveTouch, false);
}

var initialX = null;
var initialY = null;
function startTouch(e) {
initialX = e.touches[0].clientX;
initialY = e.touches[0].clientY;
}
function endTouch() {
initialX = null;
initialY = null;
}

function moveTouch(e) {
if (initialX === null) { return; }
if (initialY === null) { return; }
var currentX = e.touches[0].clientX;
var currentY = e.touches[0].clientY;
var diffX = initialX - currentX;
var diffY = initialY - currentY;

if (Math.abs(diffX) > Math.abs(diffY)) {
    // sliding horizontally
    if (diffX > 0) {
        animasjon_V();  
    } 
    else {
        animasjon_H();
    }
} 
else {
    return;
}
e.preventDefault();
}

//Global variabel for utsettelse på 500 millisekunder.
//Brukes i animasjonene
var utsett = 500; 

// Animasjon for venstre swipe
function animasjon_V(){
    var a = document.getElementById("modalSwipe");
    var modalinn = document.getElementsByClassName('modal-innhold');
    var modal = document.getElementsByClassName('modalid');
    a.className += ' animated bounceOutLeft';

    setTimeout(
        function() {
            for(let i=0; i < modal.length; i++) {
                modalinn[i].classList.remove('active');
                modalinn[i].classList.remove('animated');
                modalinn[i].classList.remove('bounceOutLeft');
                modal[i].style.display = 'none';
            }   
            document.getElementById("modalSwipe").setAttribute("id", "");
        }  
    ,utsett);
}
//Animasjon for høyre svipe
function animasjon_H(){
    var a = document.getElementById("modalSwipe");
    var modalinn = document.getElementsByClassName('modal-innhold');
    var modal = document.getElementsByClassName('modalid');
    a.className += ' animated bounceOutRight';
    
    setTimeout(
        function() {
            for(let i=0; i < modal.length; i++) {
                modalinn[i].classList.remove('active');
                modalinn[i].classList.remove('animated');
                modalinn[i].classList.remove('bounceOutRight');
                modal[i].style.display = 'none';
            }
            document.getElementById("modalSwipe").setAttribute("id", "");
        }
    ,utsett);  
}

/* Feil passord input */
function popup() {
    alert("Feil passord har blitt tastet inn");
}

/*Funksjon  for popup på modal vis/skjul */
function popupvindu() {
    var popup = document.getElementById("popupid");
    popup.classList.toggle("vis");
}




//Funksjon for lest melding
function lestMel(lest,id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "Action/oppdaterlest.php?idmelding="+id+"&lest="+lest, true);
    xmlhttp.send();

}


function meldingBoks(verdi) {
    document.getElementById("utMeld").innerHTML = "";
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("utMeld").innerHTML = this.responseText;
            }
    }
    xmlhttp.open("GET", "Action/nyMelding.php?verdi="+verdi, true);
    xmlhttp.send();

}


// visbildet du har valgt
function visFil(event){
    var utBilde = document.getElementById('bildePrew');
    utBilde.src = URL.createObjectURL(event.target.files[0]);
}


// meldingsfunksjon
// endre innboks
var artikkelene =document.getElementsByClassName('meldingPre');
var papir =document.getElementsByClassName('papirK');
var sendte = document.getElementsByClassName('sendtK');
var advarsler = document.getElementsByClassName('advarsler');
var typeboks = document.getElementsByClassName('button');


function endreBoks(valg) {
    // Henter klassene
    // Vanlig innboks
    if(valg ==0){
        // Alle andre meldinger
        for(var l=0; l<artikkelene.length;l++){
            artikkelene[l].style.display = "inline-block";
        }
        // Setter boss usynlig
        for(var i=0; i<papir.length;i++){
            papir[i].style.display = "none";
        }
        for(var j=0; j<sendte.length;j++){
            sendte[j].style.display = "none";
        }
        for(var k=0; k<advarsler.length;k++){
            advarsler[k].style.display = "none";
        }

        // endre valgt knapp
        typeboks[0].classList.add("typeBoksValgt");
        typeboks[1].classList.remove("typeBoksValgt");
        typeboks[2].classList.remove("typeBoksValgt");
        typeboks[3].classList.remove("typeBoksValgt");

        // Sendte meldinger
    } else if(valg ==1){

        for(var l=0; l<artikkelene.length;l++){
            artikkelene[l].style.display = "none";
        }

        for(var i=0; i<papir.length;i++){
            papir[i].style.display = "none";
        }
            
        for(var j=0; j<sendte.length;j++){
            sendte[j].style.display = "inline-block";
        }
        for(var k=0; k<advarsler.length;k++){
            advarsler[k].style.display = "none";
        }

        // endre valgt knapp
        typeboks[0].classList.remove("typeBoksValgt");
        typeboks[1].classList.add("typeBoksValgt");
        typeboks[2].classList.remove("typeBoksValgt");
        typeboks[3].classList.remove("typeBoksValgt");
        // Papirkurv
    } else if(valg ==2){
        // Alle andre meldinger
        for(var l=0; l<artikkelene.length;l++){
            artikkelene[l].style.display = "none";
        }
        for(var j=0; j<sendte.length;j++){
            sendte[j].style.display = "none";
        }
        // Setter boss synlig
        for(var i=0; i<papir.length;i++){
            papir[i].style.display = "inline-block";
        }
        for(var k=0; k<advarsler.length;k++){
            advarsler[k].style.display = "none";
        }
        // endre valgt knapp
        typeboks[0].classList.remove("typeBoksValgt");
        typeboks[1].classList.remove("typeBoksValgt");
        typeboks[2].classList.add("typeBoksValgt");
        typeboks[3].classList.remove("typeBoksValgt");

    } else if(valg ==3){
        // Advarsler
        for(var l=0; l<artikkelene.length;l++){
            artikkelene[l].style.display = "none";
        }
        for(var j=0; j<sendte.length;j++){
            sendte[j].style.display = "none";
        }
        // Setter boss synlig
        for(var i=0; i<papir.length;i++){
            papir[i].style.display = "none";
        }
        for(var k=0; k<advarsler.length;k++){
            advarsler[k].style.display = "inline-block";
        }

        // endre valgt knapp
        typeboks[0].classList.remove("typeBoksValgt");
        typeboks[1].classList.remove("typeBoksValgt");
        typeboks[2].classList.remove("typeBoksValgt");
        typeboks[3].classList.add("typeBoksValgt");
    }

}

// Finner eller artikklene
for(let i=0;i<artikkelene.length;i++){
    artikkelene[i].onclick = function() {
        artikkelene[i].classList.remove("ulestK");
        try {
            meldingId = readsda[i].value;
            visHele(meldingId);
        } catch(err){
            
        }
    }
}
// melding teller i header
var utAntallMel = document.getElementById("utAntallMel");
var utMelding = document.getElementById('meldingVis');

// vis melding
function visHele(idmelding) {
    
    var xmlTeller = new XMLHttpRequest();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            utMelding.innerHTML = this.responseText;
        }
      }
    xmlhttp.open("GET", "Action/setMelding.php?idmelding="+idmelding, true);
    xmlhttp.send();
    
    xmlTeller.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            utAntallMel.innerHTML = this.responseText;
            
        }
    }
    xmlTeller.open("GET", "Action/antallMelding.php", true);
    xmlTeller.send();
}


var bossK = document.getElementsByClassName('boss');
var readsda = document.getElementsByClassName('reeeee');
// Slett melding

for(let i=0;i<bossK.length;i++){
    bossK[i].onclick = function() {
        bossId = readsda[i].value;
        if(artikkelene[i].classList.contains("papirK")){
            artikkelene[i].classList.remove("papirK");
            slettBoss(bossId,0);
        } else {
            artikkelene[i].classList.add("papirK");
            slettBoss(bossId,1);
        }
    }
}

function slettBoss(idmelding,type){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "Action/slettMelding.php?idmelding="+idmelding+"&type="+type, true);
    xmlhttp.send();
}

// Velg mottaker
function velgMot(brukernavn) {
    document.getElementById("mottaker").innerHTML.value = brukernavn;
}

// Sende melding
function sendMelding(){
    var tittel= document.getElementById('tittelMel').value;
    var mottaker =document.getElementById('mottakerMel');
    var utTall =document.getElementById('utTall').value;

    var utTest = document.getElementById('utTest');
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            utTest.innerHTML = this.responseText;
        }
      }

    xmlhttp.open("GET", "Action/meldingAction.php?tittel="+tittel+"&mottaker="+mottaker.value+"&tekst="+utTall, true);
    xmlhttp.send();

    // Setter mottaker til null
    mottaker.value= "";
}

//Nedtrekksmeny i Arrangement modalen, åpner menyen
function arrangJS(valgt) {
    // DOM elementer
    var skalKlass = document.getElementsByClassName("skalVis");
    var kanlKlass = document.getElementsByClassName("kaniVis");
    var intKlass = document.getElementsByClassName("intVis");

        // Sjekker hvilke knapp som e valgt
        if (valgt == "skalVis"){
           
            // Toggler for alle instanser av klassen
            for(var i=0; i <skalKlass.length;i++){
                skalKlass[i].classList.toggle("arrangShow");
            }
        } else if(valgt == "kaniVis"){
            // Toggler for alle instanser av klassen
            for(var i=0; i <kanlKlass.length;i++){
                kanlKlass[i].classList.toggle("arrangShow");
            }
        } else {
            // Toggler for alle instanser av klassen
            for(var i=0; i <intKlass.length;i++){
                intKlass[i].classList.toggle("arrangShow");
            }
        }

}

//Lukker nedtrekksmenyen når bruker klikker utenfor menyen
window.onclick = function(event) {
    if (!event.target.matches('.brukerKnapp')) {
      var dropdowns = document.getElementsByClassName("arrang-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('arrangShow')) {
          openDropdown.classList.remove('arrangShow');
        }
      }
    }
  }
// XML rapporter bruker fra interesse siden
function rapportBruker(){
    var brukerRapportert = document.getElementById("funnetB").innerHTML;
    var beskrivelse = document.getElementById("beskrivelseRap").value;

    var utRap = document.getElementById("utRap");

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            utRap.innerHTML = this.responseText;
        }
      }

    xmlhttp.open("GET", "Action/rapporterBruker.php?&brukerRapportert="+brukerRapportert+"&beskrivelse="+beskrivelse, true);
    xmlhttp.send();
}



function finnBruker(str) {
    if (str.length == 0) {
        document.getElementById("utbrukerA").innerHTML = "";
        return;

      } else {

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("utbrukerA").innerHTML = this.responseText;
          }
        };
    }
        xmlhttp.open("GET", "Action/finnBrukerAdvarsel.php?brukernavn="+ str, true);
        xmlhttp.send();


}

function settBruker(navn){
    document.getElementById("brukerValgt").value = navn;
    //utTidligereAdvarsler

    // Finner tidligere advarsler
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("utTidligereAdvarsler").innerHTML = this.responseText;
      }
    };

    xmlhttp.open("GET", "Action/finnAdvarsel.php?brukernavn="+ navn, true);
    xmlhttp.send();

    var xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("statusUt").innerHTML = this.responseText;
      }
    };
    xmlhttp2.open("GET", "Action/finnStatus.php?brukernavn=" + navn, true);
    xmlhttp2.send(); 
  
}


function finnBrukerMelding(bokstav) {
    if (bokstav.length == 0) {
        document.getElementById("mottakereL").innerHTML = "";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("mottakereL").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "Action/finnKontakt.php?q=" + bokstav, true);
        xmlhttp.send(); 
      }
}

function endreMel(verdi) {
    document.getElementById('mottakerMel').value = verdi;
}

function finnBrukerRettig(bokstav) {
    if (bokstav.length == 0) {
        document.getElementById("utbrukerR").innerHTML = "";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("utbrukerR").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "Action/finnBrukereRetting.php?q=" + bokstav, true);
        xmlhttp.send(); 
      }
}

function endreRettigMel(verdi) {
    document.getElementById("rettighetMottak").value = verdi;
}

function ekskluder(brukernavn) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("utEkskluder").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "Action/ekskluderBruker.php?brukernavn=" + brukernavn, true);
    xmlhttp.send(); 


}

// fuksjon for sortering av epost
function sorterTabell(tabellen) {
    var table = 0;
    var rader =0;
    var bytte= 0;
    var i= 0;
    var x= 0;
    var y= 0;
    var shouldSwitch= 0;
    var vei= 0;
    var switchcount = 0;
    table = document.getElementById("rapportTable");
    vei = "asc";
    bytte = true;

    while (bytte) {
      bytte = false;
      rader = table.rows;
      for (i = 1; i < (rader.length - 1); i++) {
        shouldSwitch = false;
        y = rader[i + 1].getElementsByTagName("td")[tabellen];
        x = rader[i].getElementsByTagName("td")[tabellen];
        if (vei == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
          }

        } else if (vei == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
        }
          }
      }
      if (shouldSwitch) {
        rader[i].parentNode.insertBefore(rader[i + 1], rader[i]);
        bytte = true;
        switchcount ++;
      } else {
        if (switchcount == 0 && vei == "asc") {
            vei = "desc";
          bytte = true;
        }

      }


        }
  }

  function lagmindreRapport(brukernavn) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("utTest").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "Action/lagMindreRapport.php?brukernavn=" + brukernavn, true);
    xmlhttp.send(); 
  }