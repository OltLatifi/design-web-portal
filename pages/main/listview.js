document.addEventListener("DOMContentLoaded", function () {
  var articles;
  var page = 0;
  fetch("../../../articles.json")
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      articles = data.slice(page, page + 20);
      displayArticles(articles);
    })
    .catch((error) => {
      console.error("Error fetching article:", error);
      displayArticles(articles);
    });
});

function displayArticles(articles) {
  var articlesContainer = document.getElementById("articles-list");
  articles.forEach((element) => {
    var article = document.createElement("a");
    article.href = `pages/news/article.html?id=${element.id}`;
    article.classList.add("single-article");
    article.innerHTML = `
      <img class="index-list-article" src="../../assets/articles/article${element.id}.png" alt="Article Image ${element.id}">
      <h3>${element.title}</h3>
      <div class="metadata">
      <span>2 Hours Ago</span>
      <span>CNN</span>
      </div>
      `;
    articlesContainer.appendChild(article);
  });
}
