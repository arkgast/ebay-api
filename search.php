<?php

require_once 'core/search_item.php';
require_once 'core/database.php';

$itemId = $_POST['item-id'];

$app = SearchItem::withItemId($itemId);
$item = $app->getItem();
$images = $item->PictureURL;

echo "<h1>Product info</h1>";
echo "<h4>{$item->Title}</h4>";
echo "Price: {$item->ConvertedCurrentPrice} <br/>";
foreach ($images as $image) {
  echo "<img src={$image} width=150 height=180>";
}

echo "<br><=============================><br>";

$db = new EbaySearchLog();
$list = $db->list();
print_r($list);
$db->insertRow('title', 'seller1', 8.45, 'img1');
$db->deleteRow(7);
