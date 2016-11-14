$(document).ready(function() {

  $("form").submit(function( event ) {
    $('.data').addClass('loading');
    event.preventDefault();

    $.ajax({
      url: 'process.php',
      type: 'POST',
      data: $('form').serialize(),
      success: function(response, textStatus, jqXHR) {
        $('.data').html(response);
        $('.data').addClass('hasdata');
        $('.data').removeClass('loading');
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(textStatus, errorThrown);
     }
    });

  });

});
