$(function(){
  $('#inputUsernameForSignup').bind('keyup', function(){
    var value = $(this).val()
    $(this).val(value.replace(/\s+/g, ''));
  });
});