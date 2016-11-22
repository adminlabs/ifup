$(document).ready(function() {

  // // Allow adding regular url without having to type http
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
