$(document).ready(init);

function init() {
  $('#search-form').submit(handleSubmit);
  $('#previous-searches').on('click', 'button.delete-item', deleteItem);
  loadPreviousSearches();
}

function handleSubmit(e) {
  e.preventDefault();
  var formData = $(this).serialize();
  var itemContainer = $('#item-wrapper');
  itemContainer.html(showLoader());
  $.post('handler.php?action=search', formData, function(data) {
    itemContainer.html(data);
    loadPreviousSearches();
  });
}

function showLoader() {
  return "<img src='./img/gears.svg' />";
}

function loadPreviousSearches() {
  var previousSearches = $('#previous-searches');
  $.get('handler.php', {action: 'list'}, function(data) {
    previousSearches.html(data);
  })
}

function deleteItem() {
  var encId = this.dataset.id;
  $.post('handler.php?action=delete', {'item-id': encId}, function(data) {
    loadPreviousSearches();
  });
}
