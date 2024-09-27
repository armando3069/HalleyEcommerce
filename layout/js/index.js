const middleSide = document.getElementById("middle_side");
const rightSide = document.getElementById("right_side");
const hideBTN = document.getElementById("hide_btn");

let isHidden = true;

hideBTN.addEventListener("click", clickHide);

function clickHide() {
  if (isHidden) {
    middleSide.style.display = "flex";
    rightSide.style.display = "flex";
    isHidden = false;
  } else {
    middleSide.style.display = "none";
    rightSide.style.display = "none";
    isHidden = true;
  }
}

function checkWindowSize() {
  if (window.innerWidth < 700) {
    if (isHidden) {
      middleSide.style.display = "none";
      rightSide.style.display = "none";
    }
  } else {
    middleSide.style.display = "flex";
    rightSide.style.display = "flex";
    isHidden = false;
  }
}

window.addEventListener("resize", checkWindowSize);

checkWindowSize();

let macbookImg = document.getElementById("macbook_img");
let playStationImg = document.getElementById("playstation");
let airpodsImg = document.getElementById("airpods");
let visonImg = document.getElementById("vision");

function checkWindowSize2() {
  if (window.innerWidth < 700) {
    macbookImg.src = "./layout/img/macbook2.svg";
    airpodsImg.src = "./layout/img/airpods.svg";
    visonImg.src = "./layout/img/vision.svg";
    playStationImg.src = "./layout/img/playStation.svg";
  } else {
    macbookImg.src = "./layout/img/MacBook_crop.svg";
    airpodsImg.src = "./layout/img/hero__gnfk5g59t0qe_xlarge_2x 1_crop.svg";
    visonImg.src = "./layout/img/image 36_crop.svg";
    playStationImg.src = "./layout/img/PlayStation_crop.svg";
  }
}

// Ascultă la schimbarea dimensiunii ferestrei
window.addEventListener("resize", checkWindowSize2);

// Verifică dimensiunea la încărcare
checkWindowSize2();
