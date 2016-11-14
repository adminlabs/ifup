$(document).ready(function() {

  $("form").submit(function( event ) {
    $('.loader').addClass('show');
    event.preventDefault();

    $.ajax({
      url: 'process.php',
      type: 'POST',
      timeout: 10000,
      data: $('form').serialize(),
      success: function(response, textStatus, jqXHR) {
        $('.data').removeClass('error');
        $('.data').html(response);
        $('.data').addClass('hasdata');
        $('.loader').removeClass('show');
      },
      error: function(jqXHR, textStatus, errorThrown){
        $('.data').addClass('error');
        $('.loader').removeClass('show');

        if (textStatus == "timeout") {
          $('.data').append('Time out or slow site');
        } else {
          $('.data').append('Time out or slow site. Error:' + errorThrown);
        }
     }
    });

  });

});
