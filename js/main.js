$(document).ready(init);

function init() {
  $('#search-form').submit(handleSubmit);
}

function handleSubmit(e) {
  e.preventDefault();
  var formData = $(this).serialize();
  var itemContainer = $('#item-wrapper');
  itemContainer.html(showLoader());
  $.post('handler.php?action=search', formData, function(data) {
    previousSearches.html(data);
  });
}

function showLoader() {
  return "<img src='./img/gears.svg' />";
}
