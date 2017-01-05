$(function() {
    // filters
    $('.form-filters select')
      .selectpicker({
        selectedTextFormat: 'count > 0'
      })
      .on('hidden.bs.select', function(e) {
        $.ajax({
          type: 'get',
          url: document.location.href,
          data: $(".form-filters :input[value!=''][value!='.']").serialize()
        });
      });
    $('.form-filters input')
      .on('change keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
          e.preventDefault();
          $.ajax({
            type: 'get',
            url: document.location.href,
            data: $(".form-filters :input[value!=''][value!='.']").serialize()
          });
          return false;
        }
      });
    $('.form-filters a.btn')
      .on('click', function(e) {
        e.preventDefault();
        $.ajax({
          type: 'get',
          url: $(this).attr('href')
        });
      });
});
