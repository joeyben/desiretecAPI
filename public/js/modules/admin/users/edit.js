$(function() {
  $("#roles-list input").on("change", function() {
    var id = $(this).val();
    if ($(this).data('name') === 'Administrator') {
      $('#permissions-list').find('input').each(function() {
        $(this).prop("checked", true);
      })
    } else  {
      $('#permissions-list').find('input').each(function() {
        $(this).prop("checked", false);
      })

      $('#collapse-link-collapsed-' + id).find('span').each(function() {
        var permId = 'perm_' + id
        $('#permissions-list').find('#' + permId).each(function() {
          $(this).prop("checked", true);
        })
      })
    }

  });
});
