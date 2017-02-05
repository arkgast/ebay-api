<?php
require_once 'core/search_item.php';
require_once 'core/database.php';

$itemId = $_POST['item-id'];
$action = $_GET['action'];

$ACTION = (object)array(
  'ADD' => 'add',
  'DELETE' => 'delete',
  'LIST' => 'list',
  'SEARCH' => 'search'
);

class Handler {
  public static function handleSearch($itemId) {
    $app = SearchItem::withItemId($itemId);
    $item = $app->getItem();
    $images = $item->PictureURL;

    echo "<h1>Product info</h1>";
    echo "<h4>{$item->Title}</h4>";
    echo "Price: {$item->ConvertedCurrentPrice} <br/>";
    foreach ($images as $image) {
      echo "<img src={$image} width=150 height=180>";
    }
  }

  public static function handleDb($action) {
    $searchDb = new EbaySearchLog();
    switch ($action) {
      case $ACTION->ADD:
        $searchDb->insertRow('title', 'seller1', 8.45, 'img1');
        break;
      case $ACTION->DELETE:
        $searchDb->deleteRow(7);
        break;
      case $ACTION->LIST:
        $list = $searchDb->list();
        print_r($list);
        break;
    }
  }
}

switch ($action) {
  case $ACTION->ADD:
  case $ACTION->DELETE:
  case $ACTION->LIST:
    Handler::handleDb($action);
    break;
  case $ACTION->SEARCH:
    Handler::handleSearch($itemId);
    break;
  default:
    echo 'There is nothing to see';
}
