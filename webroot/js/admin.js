$(function() {
    // filters
    $('.form-filters select').selectpicker({
      selectedTextFormat: 'count > 0'
    });
    $('.form-filters select').on('hidden.bs.select', function (e) {
      $('.form-filters').submit();
    });
});
