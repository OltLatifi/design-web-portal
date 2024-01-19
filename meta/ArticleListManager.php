<?php

class ArticleListManager {
    private $db;
    private $sql = "
      SELECT article.*, user.first_name, user.last_name
      FROM article
      INNER JOIN user ON article.author_id = user.id
      WHERE article.status = 1
      ORDER BY article.created_at DESC
    ";

    public function __construct(Database $db) {
      $this->db = $db;
    }

    public function getPublishedArticles() {
      $sql = $this->sql ;
      return $this->db->query($sql);
    }
}

?>