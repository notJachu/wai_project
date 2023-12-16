var input = document.getElementById('favcolor') as HTMLInputElement | null;
var value = input?.value
var myForm = document.getElementById('myForm') as HTMLFormElement;

var $svg = $("#gSvg");

$( function() {
  $( "#datepicker" ).datepicker({
    showAnim: "slideDown"
  });
} );


function storageAvailable() {
  try {
    const x = "__storage_test__";
    sessionStorage.setItem(x, x);
    sessionStorage.removeItem(x);
    return true;
  } catch (e) {
    return (
      e instanceof DOMException &&
      // everything except Firefox
      (e.code === 22 ||
        // Firefox
        e.code === 1014 ||
        // test name field too, because code might not be present
        // everything except Firefox
        e.name === "QuotaExceededError" ||
        // Firefox
        e.name === "NS_ERROR_DOM_QUOTA_REACHED") &&
      // acknowledge QuotaExceededError only if there's something already stored
      sessionStorage &&
      sessionStorage.length !== 0
    );
  }
}

if (storageAvailable()){
  var saveButton = document.createElement('button');

  saveButton.innerText = "Save form";
  saveButton.classList.add('finalButton');
  myForm.appendChild(saveButton);
  
  saveButton.addEventListener('click', (event) => {
    event.preventDefault();
    const formData = new FormData(myForm);
    const formValues: { [key: string]: string } = {};
    formData.forEach((value, key) => {
      formValues[key] = value.toString();
    });
    sessionStorage.setItem('inputs', JSON.stringify(formValues));
    alert("Form input saved to storage");
  });
  
  const savedFormData = sessionStorage.getItem('inputs');
  if (savedFormData){
    const parsedData = JSON.parse(savedFormData);
    $svg.attr('fill', parsedData["favcolor"]);
    Object.keys(parsedData).forEach((key) => {
      console.log(key, " ", parsedData[key]);
      const inputElement = myForm.elements.namedItem(key);
      if (inputElement instanceof HTMLInputElement || inputElement instanceof HTMLTextAreaElement) {
        inputElement.value = parsedData[key];
        if (inputElement.type != 'color'){
          inputElement.click();
        }
        if (inputElement instanceof HTMLInputElement){
          inputElement.checked = true;
        }
      }
    }); 
  }
}

$( function() {
  var availableTags = [
  "argentine rock",
  "ars antiqua",
  "ars nova",
  "ars subtilior",
  "art pop",
  "art punk",
  "art rock",
  "ashik",
  "asian",
  "asian american jazz",
  "asian underground",
  "assyrian pop music",
  "atlanta hip hop",
  "australian aboriginal",
  "australian country",
  "australian country music",
  "australian hip hop",
  "australian pub rock",
  "austropop",
  "avant-garde",
  "avant-garde jazz",
  "avant-garde metal",
  "avant-punk",
  "axé",
  "bachata",
  "background music",
  "baggy",
  "bahrain",
  "baila",
  "baisha xiyue",
  "baithak gana",
  "baião",
  "bajourou",
  "bakersfield sound",
  "bal-musette",
  "balakadri",
  "balearic beat",
  "balearic trance",
  "balinese gamelan",
  "balkan brass band",
  "ballad",
  "ballata",
  "ballet",
  "baltimore club",
  "bambuco",
  "banda",
  "bangsawan",
  "bantowbol",
  "barbadian",
  "barbershop",
  "barn dance",
  "baroque",
  "baroque pop",
  "basque",
  "bass",
  "bassline",
  "batucada",
  "batá-rumba",
  "baul",
  "beach",
  "beat",
  "beat music",
  "beatboxing",
  "beautiful",
  "beautiful music",
  "bebop",
  "beiguan",
  "bel canto",
  "belizean",
  "bend-skin",
  "benga",
  "bent edge",
  "berlin school",
  "bhajan",
  "bhangra",
  "bhangragga",
  "big band",
  "big beat",
  "big room",
  "biguine",
  "bihu",
  "bikutsi",
  "biomusic",
  "bitpop",
  "black metal",
  "black midi",
  "blackened death metal",
  "blue-eyed soul",
  "bluegrass",
  "blues",
  "blues ballad",
  "blues country",
  "blues rock",
  "blues shouter",
  "boi",
  "bolero",
  "bolivia",
  "bongo flava",
  "boogaloo",
  "boogie",
  "boogie-woogie",
  "bosnian",
  "bossa nova",
  "bounce",
  "bounce music",
  "bouncy house",
  "bouncy techno",
  "bouyon",
  "brass",
  "brazilian",
  "brazilian rock",
  "breakbeat",
  "breakbeat hardcore",
  "breakcore",
  "breakstep",
  "brega",
  "breton",
  "brick city club",
  "brill building",
  "brill building sound",
  "brit funk",
  "british",
  "british blues",
  "british dance band",
  "british folk revival",
  "british hip hop",
  "british invasion",
  "britpop",
  "broken beat",
  "brostep",
  "brown-eyed soul",
  "brukdown",
  "bubblegum dance",
  "bubblegum pop",
  "buddhist",
  "bulerías",
  "bullerengue",
  "bunraku",
  "burger-highlife",
  "burgundian school",
  "bush ballad",
  "byzantine",
  "c-pop",
  "ca din tulnic",
  "ca trù",
  "cabaret",
  "cadence rampa",
  "cadence-lypso",
  "cajun",
  "cajun fiddle tunes",
  "calinda",
  "calypso",
  "calypso-style baila",
  "campursari",
  "canadian blues",
  "canción",
  "candombe",
  "canon",
  "cantata",
  "cante chico",
  "cante jondo",
  "canterbury scene",
  "cantiga",
  "cantiñas",
  "canto livre",
  "cantopop",
  "canzone",
  "canzone napoletana",
  "cape jazz",
  "capoeira",
  "caribbean and caribbean-influenced",
  "cariso",
  "carnatic",
  "carol",
  "cartageneras",
  "cavacha",
  "celempungan",
  "cello rock",
  "celtic"
  ];
  $( "#Other" ).autocomplete({
    source: availableTags
  });
} );

var randomColor = (): string => {
    let result = '';
    for (let i = 0; i < 6; ++i) {
      const value = Math.floor(16 * Math.random());
      result += value.toString(16);
    }
    console.log(result);
    return '#' + result;
  };

window.onload = () => {
    if(input?.value){
        input.value = randomColor();
        value = input.value;
    }
}

input?.addEventListener('input', function(event){
  const target = event.target as HTMLInputElement;
  console.log(target.value);
  $svg.attr('fill', target.value);
})

$(".chosen-select").chosen({width: '25%'})

