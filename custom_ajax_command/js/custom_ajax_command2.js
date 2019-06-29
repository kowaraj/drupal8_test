(function ($, Drupal) {
 
    if (Drupal.AjaxCommands) {
   
      // Custom Ajax command
      Drupal.AjaxCommands.prototype.customAjaxCommand2 = function (ajax, response, status) {
        alert (response.message + "ADDED POSTFIX ! ! !");
      }
   
    }
   
  }) (jQuery, Drupal);