let articles;
let biggestId;
fetch("../../articles.json")
  .then((response) => {
    return response.json();
  })
  .then((data) => {
    articles = data;
    biggestId = data[data.length - 1]?.id;
    displaySlides(articles);
  })
  .catch((error) => {
    console.error("Error fetching article:", error);
    displaySlides(articles);
  });

function displaySlides(articles) {
  let slider = document.getElementById("slider");
  let slider_list;
  articles.map((element, index) => {
    slider_list = document.createElement("div");
    slider_list.classList.add("slider-article");
    slider_list.id = "slide_" + element.id;

    if (index > 0) {
      slider_list.classList.add("hide");
    }

    slider_list.innerHTML = `
        <img src="/assets/articles/article${element.id}.png" alt="Article image ${element.id}">
        <h3>${element.title}</h3>
        <div class="metadata">
        <span>2 Hours Ago</span>
        <span>CNN</span>
        </div>
    `;
    slider.appendChild(slider_list);
  });
}

let slide = 1;
function clearAll() {
  let slides = document.querySelectorAll(".slider-article");
  slides.forEach((el) => el.classList.add("hide"));
}

function goNext() {
  clearAll();
  if (slide < biggestId) {
    slide++;
  } else {
    slide = 1;
  }
  document.getElementById("slide_" + slide).classList.remove("hide");
}

function goPrevious() {
  clearAll();
  if (slide > 1) {
    slide--;
  } else {
    slide = biggestId;
  }
  document.getElementById("slide_" + slide).classList.remove("hide");
}
