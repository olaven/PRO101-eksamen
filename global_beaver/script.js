//START

function myFunction() {
  var x = document.getElementById("frame");
  var button = document.getElementById("exit");
  x.style.display = "block";
  button.style.display = "block";
}
function exit() {
  var y = document.getElementById("frame");
  var button = document.getElementById("exit");

  y.style.display = "none";
  button.style.display = "none";
}

//VULKAN
function myFunctionVulkan() {
  var x = document.getElementById("frameVulkan");
  var buttonVulkan = document.getElementById("exitVulkan");
  x.style.display = "block";
  buttonVulkan.style.display = "block";
}
function exitVulkan() {
  var y = document.getElementById("frameVulkan");
  var buttonVulkan = document.getElementById("exitVulkan");

  y.style.display = "none";
  buttonVulkan.style.display = "none";
}

//KVADRATUREN
function myFunctionKvadraturen() {
  var x = document.getElementById("frameKvadraturen");
  var buttonKvadraturen = document.getElementById("exitKvadraturen");
  x.style.display = "block";
  buttonKvadraturen.style.display = "block";
}
function exitKvadraturen() {
  var y = document.getElementById("frameKvadraturen");
  var buttonKvadraturen = document.getElementById("exitKvadraturen");

  y.style.display = "none";
  buttonKvadraturen.style.display = "none";
}

//BRENNERIVEIEN
function myFunctionBrennerieveien() {
  var x = document.getElementById("frameBrennerieveien");
  var buttonBrenneriveien = document.getElementById("Brennerieveien");
  x.style.display = "block";
  buttonBrenneriveien.style.display = "block";
}
function exitBrenneriveien() {
  var y = document.getElementById("frameBrennerieveien");
  var buttonBrenneriveien = document.getElementById("Brennerieveien");

  y.style.display = "none";
  buttonBrenneriveien.style.display = "none";
}

//END

// NYE KNAPPER

function toLink(url_mobil, url_desktop, iframeId, exit) {
  console.log(iframeId);
  if (window.innerWidth <= 700) {
    window.open(url_mobil, "_blank");
  } else {
    document.getElementById(iframeId).src = url_desktop;
    document.getElementById(iframeId).style.display = "block";
    document.getElementById(exit).style.display = "block";
  }
}

function openBysykkel() {
  window.open("https://oslobysykkel.no/en/map", "_blank");
}

// NYE KNAPPER

function toLink1(url_mobil, url_desktop, iframeId, exit) {
  if (window.innerWidth <= 700) {
    window.open(url_mobil, "_blank");
  } else {
    document.getElementById(iframeId).src = url_desktop;
    document.getElementById(iframeId).style.display = "block";
    document.getElementById(exit).style.display = "block";
    console.log(document.getElementById(iframeId));
  }
}
