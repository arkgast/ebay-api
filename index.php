<!Doctype html>
<html lang="en">
  <head>
    <title>Ebay - Search Item</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
      .text-center {
        text-align: center;
      }
      #previous-searches > div {
        box-shadow: 2px 2px 2px #000;
        padding: 0.5em 0;
      }
      .img-wrapper {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
      }
      .img-container {
        width: 130px;
        height: 200px;
      }
      .img-container img {
        width: 100%;
        height: 100%;
        padding: 2px;
      }
    </style>
  </head>
  <body>
    <div class='container'>
      <div class="row">
        <h1 class="text-center">Search item</h1>
        <div id="form-container" class="col-md-6">
          <form id="search-form">
            <div class="form-group">
              <label for="item-id">Item ID</label>
              <input type="number" name="item-id" id="item-id" class="form-control" placeholder="Item ID">
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary btn-lg">Search</button>
            </div>
          </form>
        </div>
        <div id="item-wrapper" class="col-md-6 text-center">
          Search result goes here
        </div>
      </div>
      <div id="previous-searches-wrapper" class="row">
        <h3 class="text-center">Previous Searches</h3>
        <div id="previous-searches" class="text-center"></div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="./js/main.js"></script>
  </body>
</html>
