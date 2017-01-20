$(document).ready(function() {

  // Close button for data
  $('.close').click(function() {
    $('.data').fadeOut();
  });

  // Allow adding regular url without having to type http
  $("#url").keydown(function() {
    if (!/^http:\/\//.test(this.value)) {
      this.value = "http://" + this.value;
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
          $('.data .message').text('Site is probably up but really slow (timed out). Try with www.');
        } else {
          $('.data .message').text('Site is probably up but really slow (timed out). Error:' + errorThrown);
        }
     }
    });

  });

});
