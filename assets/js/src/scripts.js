$(document).ready(function() {

  // Close button for data
  $('.close').click(function() {
    $('.data').fadeOut();
  });

  $('input.url').blur(function() {
    var input = $(this);
    var val = input.val();
    if (val && !val.match(/^http([s]?):\/\/.*/)) {
      input.val('http://' + val);
    }
  });

  $(document).keypress(function(e) {
    if(e.which == 13) {
      var val = $('input.url').val();
      if (val && !val.match(/^http([s]?):\/\/.*/)) {
        input.val('http://' + val);
      }
    }
  });

  // Form ajax
  $("form").submit(function( event ) {
    $('.loader').addClass('show');
    event.preventDefault();

    $.ajax({
      url: 'process.php',
      type: 'POST',
      timeout: 10000,
      data: $('form').serialize(),

      success: function(response, textStatus, jqXHR) {

        $('.data').css('display', 'block');
        $('.data').removeClass('error');
        $('.data').html(response);
        $('.data').addClass('hasdata');
        $('form').addClass('submitted');
        $('.loader').removeClass('show');
      },
      error: function(jqXHR, textStatus, errorThrown) {

        $('.data').css('display', 'block');
        $('.data').addClass('error');
        $('.loader').removeClass('show');

        if (textStatus == "timeout") {
          $('.data .message').text('Site down or really slow (timed out).');
          $('.data h1, .load-time, .close, .powered-by').removeClass('nocontent');
          $('.data h1').text('Site is down');
        } else {
          $('.data .message').text('Site down or really slow (timed out). Error:' + errorThrown);
          $('.data h1, .load-time, .close, .powered-by').removeClass('nocontent');
          $('.data h1').text('Site is down');
        }
     }
    });

  });

});
