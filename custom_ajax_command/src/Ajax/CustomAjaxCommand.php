<?php
 
   namespace Drupal\custom_ajax_command\Ajax;
   use Drupal\Core\Ajax\CommandInterface;
 
   class CustomAjaxCommand implements CommandInterface {
 
     protected $message;
     # Constructs
     public function __construct ($message) {
       $this->message = $message;
     }
 
     # Implements Drupal \Core\Ajax\CommandInterface: render ().
     public function render () {
       return array (
         'command' => 'customAjaxCommand', // Required property - specifies the name of the custom Jquery (JS) method that will be started
         'message' => $this->message, // Variables that will be available in response
       );
     }
   }