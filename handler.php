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
    FormatHTML::formatSearchResult($item);
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
        FormatHTML::formatListResult($list);
        break;
    }
  }
}

class FormatHTML {
   public static function formatSearchResult($item) {
    $images = $item->PictureURL;
    echo "
      <div id='item-container'>
        <h1>Item Info</h1>
        <h4>{$item->title}</h4>
        <h5>Price: {$item->ConvertedCurrentPrice}</h5>
        <div id='images-container'>";
    foreach ($images as $image) {
      echo "<img src={$image} width=150 height=180>";
    }
    echo "</div>
      </div>";
  }

  public static function formatListResult($list) {
    foreach ($list as $item) {
      print_r($item);
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
