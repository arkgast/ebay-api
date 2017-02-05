<?php
require_once 'HTTP/Request2.php';


class SearchItem {
  private $APP_ID = "ArnoldGa-EbaySear-PRD-0cd44e4f7-f462f8ba";
  private $itemId;

  public static function withItemId($itemId) {
    $instance = new self();
    $instance->setItemId($itemId);
    return $instance;
  }

  public function setItemId($itemId) {
    $this->itemId = $itemId;
  }

  public function getItemId() {
    return $this->itemId;
  }

  public function urlGen() {
    $url = "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=XML&appid={$this->APP_ID}&siteid=0&version=967&ItemID={$this->getItemId()}";
    return $url;
  }

  public function doRequest() {
    $url = $this->urlGen();
    $request = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);
    try {
      $response = $request->send();
      if ($response->getStatus() === 200) {
        return $response->getBody();
      } else {
        //echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase();
        return false;
      }
    } catch (HTTP_Request2_Exception $e) {
      //echo "Error " . $e->getMessage();
      return false;
    }
  }

  public function getItem() {
    $xmlData = $this->doRequest();
    if ($xmlData) {
      $xml = simplexml_load_string($xmlData);
      return $xml->Item;
    } else
      return false;
  }
}


