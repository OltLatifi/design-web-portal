document.addEventListener("DOMContentLoaded", function () {
  const articles = [
    {
      id: 1,
      title: "Article 1",
      author: "John Doe",
      content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
      date: "2023-11-19",
    },
    {
      id: 2,
      title: "Article 2",
      author: "Jane Smith",
      content:
        "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
      date: "2023-11-20",
    },
    {
      id: 3,
      title: "Article 3",
      author: "Jane Smith",
      content:
        "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
      date: "2023-11-20",
    },
  ];

  const articleId = getArticleId();

  displayArticle(articles, articleId);
});

function displayArticle(articles, articleId) {
  const articleContainer = document.getElementById("article-container");

  const article = articles.find((article) => article.id === articleId);

  if (article) {
    const titleElement = document.createElement("h2");
    const authorElement = document.createElement("pre");
    const imageElement = document.createElement("img");
    const contentElement = document.createElement("div");
    titleElement.innerHTML = `
        ${article.title}
        `;
    authorElement.classList.add("meta");
    imageElement.src = `../../assets/articles/article${articleId}.png`;
    authorElement.innerHTML = `
        By ${article.author} | ${article.date}
        `;
    contentElement.innerHTML = `
        <div>${article.content}</div>
      `;

    articleContainer.appendChild(titleElement);
    articleContainer.appendChild(authorElement);
    articleContainer.appendChild(imageElement);
    articleContainer.appendChild(contentElement);
  } else {
    articleContainer.innerHTML = "<p>Article not found</p>";
  }
}

function getArticleId() {
  const urlParams = new URLSearchParams(window.location.search);
  return parseInt(urlParams.get("id")) || 1;
}
