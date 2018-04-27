$(document).ready(function(){

  var contador = 0;

  $('#menu-ham').on('click', function(){
    contador ++;
    if(contador == 1) {
      $('.menu-ham i').removeClass('fa fa-bars').addClass('fa fa-times');
    } else {
      $('.menu-ham i').removeClass('fa fa-times').addClass('fa fa-bars');
      contador = 0;
    }
    $('nav.menu-navegacion').toggle('slow');
  });

  var responsive = 769;

  $(window).resize(function(){

    if($(document).width() > responsive) {
      $('nav.menu-navegacion').show();
    } else {
      $('nav.menu-navegacion').hide();
    }
  }); 
});



