$(document).ready(function() {
  $('#save').click(function() {
      let content = $('#entry').val().trim();
      if (content) {
          $.post('', { content: content }, function(response) {
              if (response.status === 'success') {
                  location.reload();
              }
          }, 'json');
      }
  });

  $('.delete').click(function() {
      let id = $(this).data('id');
      if (confirm('Tem certeza que deseja excluir esta anotação?')) {
          $.post('', { delete_id: id }, function(response) {
              if (response.status === 'success') {
                  location.reload();
              }
          }, 'json');
      }
  });

  $(document).on('click', '.expand', function() {
      let content = $(this).data('content');
      $('#modal-content').text(content);
      $('#modal').removeClass('hidden');
  });

  $('#close-modal').click(function() {
      $('#modal').addClass('hidden');
  });

  $('#toggleTheme').click(function() {
      $('html').toggleClass('dark');
      if ($('html').hasClass('dark')) {
          localStorage.setItem('theme', 'dark');
          $('#toggleTheme').text('☀️');
      } else {
          localStorage.setItem('theme', 'light');
          $('#toggleTheme').text('🌙');
      }
  });
});
