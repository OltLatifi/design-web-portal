document.addEventListener("DOMContentLoaded", function () {
  const articleId = getArticleId();

  var articles;

  fetch("../../articles.json")
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      articles = data;
      displayArticle(articles, articleId);
    })
    .catch((error) => {
      console.error("Error fetching article:", error);
      displayArticle(articles, articleId);
    });
});

function displayArticle(articles, articleId) {
  const articleContainer = document.getElementById("article-container");

  const article = articles.find((article) => article.id === articleId);

  if (article) {
    const titleElement = document.getElementById("article-title");
    const authorElement = document.getElementById("article-author");
    const imageElement = document.getElementById("article-image");
    const contentElement = document.getElementById("article-content");
    titleElement.innerText = `
        ${article.title}
        `;
    imageElement.src = `../../assets/articles/article${articleId}.png`;
    authorElement.innerText = `
        By ${article.author} | ${article.date}
        `;
    contentElement.innerText = `
        ${article.content}
      `;
  } else {
    articleContainer.innerText = "<p>Article not found</p>";
  }
}

function getArticleId() {
  const urlParams = new URLSearchParams(window.location.search);
  return parseInt(urlParams.get("id")) || 1;
}
