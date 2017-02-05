$(document).ready(init);

function init() {
  $('#search-form').submit(handleSubmit);
}

function handleSubmit(e) {
  e.preventDefault();
  console.log(e);
}
