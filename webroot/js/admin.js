$(function() {
    // filters
    $('.form-filters select').selectpicker({
      selectedTextFormat: 'count > 0'
    });
    $('.form-filters input').on('change', function(e) {
      $('.form-filters').submit();
    });
    $('.form-filters select').on('hidden.bs.select', function (e) {
      $('.form-filters').submit();
    });
});
