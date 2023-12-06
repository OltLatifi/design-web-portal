document.addEventListener("DOMContentLoaded", function () {
  var articles;
  fetch("articles.json")
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      articles = data.slice(0, 8);
      displayArticles(articles);
    })
    .catch((error) => {
      console.error("Error fetching article:", error);
      displayArticles(articles);
    });
});

function displayArticles(articles) {
  console.log(articles);
  let hotArticleTitle = document.getElementById("hot-article-title");
  let hotArticleContent = document.getElementById("hot-article-content");
  hotArticleTitle.innerText = articles[0].title;
  const truncatedContent = articles[0].content.slice(0, 300);
  hotArticleContent.innerText =
    truncatedContent.length < articles[0].content.length
      ? truncatedContent + "..."
      : truncatedContent;

  var hotArticle = document.getElementById("hot-topics");
  var hotArticleLink = document.getElementById("main-topic");
  hotArticleLink.href = `pages/news/article.html?id=${articles[0]}`;
  hotArticle.style = `
        background: url(assets/articles/article${articles[0].id}.png),
        linear-gradient(180deg, transparent, black);
    `;

  var articlesContainer = document.getElementById("articles-list");
  articles.forEach((element) => {
    var article = document.createElement("a");
    article.href = `pages/news/article.html?id=${element.id}`;
    article.classList.add("single-article");
    article.innerHTML = `
        <img class="index-list-article" src="assets/articles/article${element.id}.png" alt="Article Image ${element.id}">
        <h3>${element.title}</h3>
        <div class="metadata">
        <span>2 Hours Ago</span>
        <span>CNN</span>
        </div>
        `;
    articlesContainer.appendChild(article);
  });
}
