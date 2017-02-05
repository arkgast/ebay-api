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
  public static function handleSearch(int $itemId) {
    $app = SearchItem::withItemId($itemId);
    $item = $app->getItem();
    $len = count($item);
    if ($len > 0) {
      global $ACTION;
      self::handleDb($ACTION->ADD, $item);
      Helpers::formatSearchResult($item);
    } else
      echo "<h2> Item not found </h2>";
  }

  public static function handleDb($action, $item=null, $itemId=null) {
    global $ACTION;
    $searchDb = new EbaySearchLog();
    switch ($action) {
      case $ACTION->ADD:
        $searchDb->insertRow($item->Title, $item->Seller, $item->ConvertedCurrentPrice, (array)$item->PictureURL);
        break;
      case $ACTION->DELETE:
        $decId = Helpers::decrypt($itemId);
        $searchDb->deleteRow($decId);
        break;
      case $ACTION->LIST:
        $list = $searchDb->list();
        $len = count($list);
        if ($len > 0)
          Helpers::formatListResult($list);
        else
          echo "<h2> There are not previous searches </h2>";
        break;
    }
  }
}

class Helpers {
  private static $ENCRYPT_KEY = "key";

  public static function formatSearchResult($item) {
    $images = $item->PictureURL;
    echo "
      <div id='item-container'>
        <h1>Item Info</h1>
        <h4>{$item->Title}</h4>
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
      echo "
        <div>
          <h5>{$item['title']}</h5>
          <p>{$item['seller']}</p>
          <p>{$item['price']}</p>";
      $images = unserialize($item['images']);
      foreach ($images as $img) {
        echo "<img src={$img} with=120 height=150 />";
      }
      $encId = self::encrypt($item['id']);
      echo "
        <button class='delete-item' data-id='{$encId}'>Delete</button>
        </div>";
    }
  }

  public static function encrypt($string) {
    $algorithm = 'rijndael-128';
    $key = md5(self::$ENCRYPT_KEY, true);
    $iv_length = mcrypt_get_iv_size($algorithm, MCRYPT_MODE_CBC);
    $iv_var = mcrypt_create_iv($iv_length, MCRYPT_RAND);
    $encrypted = mcrypt_encrypt($algorithm, $key, $string, MCRYPT_MODE_CBC, $iv_var);
    $result = base64_encode($iv_var . $encrypted);
    return $result;
  }

  public static function decrypt($string) {
    $algorithm = 'rijndael-128';
    $key = md5(self::$ENCRYPT_KEY, true);
    $iv_length = mcrypt_get_iv_size($algorithm, MCRYPT_MODE_CBC);
    $string = base64_decode($string);
    $iv_var = substr($string, 0, $iv_length);
    $encrypted = substr($string, $iv_length);
    $result = mcrypt_decrypt($algorithm, $key, $encrypted, MCRYPT_MODE_CBC, $iv_var);
    return $result;
  }

}

switch ($action) {
  case $ACTION->ADD:
  case $ACTION->DELETE:
  case $ACTION->LIST:
    Handler::handleDb($action, null, $itemId);
    break;
  case $ACTION->SEARCH:
    $itemId = intval($itemId);
    Handler::handleSearch($itemId);
    break;
  default:
    echo 'There is nothing to see';
}
