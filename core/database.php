<?php

abstract class Database {
  private $HOST = 'localhost';
  private $USER = 'root';
  private $PASSWORD = '';
  private $DATABASE = 'ebay';
  protected $conn;
  protected $query;

  public function __construct() {
    $this->conn = mysqli_connect($this->HOST, $this->USER, $this->PASSWORD, $this->DATABASE);
    if (!$this->conn)
      echo "Can't connect";
  }

  public function fetch_data() {
    $result = $this->conn->query($this->query);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
    return $rows;
  }

  public function execute_query(...$params) {
    $stmt = $this->conn->prepare($this->query);
    $sLen = str_repeat('s', count($params));
    $stmt->bind_param($sLen, ...$params);
    $stmt->execute();
    $stmt->close();
  }
  
}


class EbaySearchLog extends Database {

  public function insertRow(...$params) {
    $this->serializeField(...$params);
    $this->query = 'insert into search_log(title, seller, price, images) values(?, ?, ?, ?)';
    $this->execute_query(...$params);
  }

  public function deleteRow(int $id) {
    $this->query = 'delete from search_log where id = ?';
    $this->execute_query($id);
  }

  public function list() {
    $this->query = 'select id, title, seller, price, images from search_log order by id desc';
    return $this->fetch_data();
  }

  /**
   * Serialize arr img field
   */
  protected function serializeField(&...$arr) {
    $arr[3] = serialize($arr[3]);
  }

}
