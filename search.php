<?php

require_once 'core/search_item.php';

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
