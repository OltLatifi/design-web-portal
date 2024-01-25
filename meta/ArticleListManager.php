<?php

class ArticleListManager {
    private $db;
    private $sql = "
      SELECT article.*, user.first_name, user.last_name
      FROM article
      INNER JOIN user ON article.author_id = user.id
      WHERE article.status = 1
    ";

    public function __construct(Database $db) {
      $this->db = $db;
    }

    public function getPublishedArticles($limit = 0) {
      $sql = $this->sql . " ORDER BY article.created_at DESC";
      if($limit > 0){
        $sql .= " LIMIT " . $limit;
      }
      return $this->db->query($sql);
    }

    public function getArticleById($id) {
      $sql = $this->sql . " AND article.id=" . $id;
      return $this->db->query($sql)[0];
    }

    public function getFavouriteArticles($userId){
      $sql = "
        SELECT article.*, user.first_name, user.last_name
        FROM article
        INNER JOIN favorites ON article.id = favorites.article_id
        INNER JOIN user ON article.author_id = user.id
        WHERE favorites.user_id = " . $userId;
      return $this->db->query($sql);
    }
}

?>