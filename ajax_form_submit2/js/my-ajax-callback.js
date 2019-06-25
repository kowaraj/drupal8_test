(function($)
{
  //argument passed from InvokeCommand
  $.fn.myAjaxCallback = function(argument)
  {
    console.log('myAjaxCallback is called.');
    //set some input field's value to 'My arguments'
    $('#some-wrapper input').attr('value', argument);
  };
})(jQuery);
