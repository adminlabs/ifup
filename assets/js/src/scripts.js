$(document).ready(function() {

  $("form").submit(function( event ) {
    $('.loader').addClass('show');
    event.preventDefault();

    $.ajax({
      url: 'process.php',
      type: 'POST',
      data: $('form').serialize(),
      success: function(response, textStatus, jqXHR) {
        $('.data').html(response);
        $('.data').addClass('hasdata');
        $('.loader').removeClass('show');
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(textStatus, errorThrown);
     }
    });

  });

});
