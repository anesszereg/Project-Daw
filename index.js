let nom = document.querySelector(".nom");
let prenom = document.querySelector(".prenom");
let matricule = document.querySelector(".matricule");
let email = document.querySelector(".mail");
let groupe = document.querySelector(".groupe");

let bnt1 = document.querySelector(".btn1");
let bnt2 = document.querySelector(".btn2");

bnt1.addEventListener("click", () => {
  nom.innerText = "Soualleh mohammed";
  prenom.innerText = "ziad";
  matricule.innerText = "212131059298";
  email.innerText = "ziadsoulahmohammed@gmail.com";
  groupe.innerText = "4";
  console.log("bonjou");
  bnt1.style.filter = "brightness(0.75)";
  bnt2.style.filter = "brightness(0.75)";
  console.log('hrllo');
});
bnt2.addEventListener("click", () => {
  nom.innerText = "zereg";
  prenom.innerText = "aness";
  matricule.innerText = "212131033844";
  email.innerText = "anesszereg1@gmail.com";
  groupe.innerText = "4";
  bnt2.style.filter = "brightness(0.75)";
  bnt1.style.filter = "brightness(0.75)";
  console.log("coucou");
});
console.log("coucou");

//pop-up(modal) ajout pays:
const modalSection = document.getElementById("modalSection");
const showModal = () => {
  modalSection.style.display = "flex";
};

const hideModal = () => {
  modalSection.style.display = "none";
};

// Show the modal when needed (e.g., on button click)
const showButton = document.getElementById("nouveauPaysBtn");
showButton.addEventListener("click", showModal);

// Hide the modal when needed (e.g., on close button click)
const closeButton = document.getElementById("closeModalButton");
closeButton.addEventListener("click", hideModal);

//ajouter dans listes:(ajout.php)
function ajouter(element) {
  var input = document.getElementById(element);
  var liste = document.getElementById(element + "s");

  if (input.value !== "") {
    var option = document.createElement("option");
    option.text = input.value;
    liste.add(option);
    input.value = "";
  }
}

let i = 0;
function ajouter(event, parent, child) {
  event.preventDefault();

  const list = document.getElementById(parent);
  var input = document.getElementById(child);
  var text = input.value;

  var p = document.createElement("option");

  p.textContent = text;
  p.selected = true;
  p.addEventListener("dblclick", function () {
    list.removeChild(p);
  });
  list.appendChild(p);
  //list.insertBefore(p,list.firstElementChild);
}
