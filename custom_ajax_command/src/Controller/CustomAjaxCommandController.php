<?php

namespace Drupal\custom_ajax_command\Controller;

use Drupal\custom_ajax_command\Ajax\CustomAjaxCommand;
use Drupal\custom_ajax_command\Ajax\CustomAjaxCommand2;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AlertCommand;

class CustomAjaxCommandController extends ControllerBase {

	public function customalert() {
 
		# New responses
		$response = new AjaxResponse();

        # Custom Ajax command
        $message = 'This alert () was started from the Ajax custom command';
        $response->addCommand(new CustomAjaxCommand($message));
 
		# Return response
		return $response;
	}

	public function testpage() {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('
			<div>
			<p>
			<a class="use-ajax" href="/custom_ajax_command/customalert"> Alert (custom) me! </a>
			</p>
			</div>

			'),
    	];
	}
	public function customalert2() {
 
		# New responses
		$response = new AjaxResponse();

        # Custom Ajax command
        $message = 'This alert () was started from the Ajax custom command2-2';
        $response->addCommand(new CustomAjaxCommand2($message));
 
		# Return response
		return $response;
	}

	public function testpage2() {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('
			<div>
			<p>
			<a class="use-ajax" href="/custom_ajax_command/customalert2"> Alert (custom) me! </a>
			</p>
			</div>

			'),
    	];
	}
	public function templatepage() {
		return [
		  '#theme' => 'my_template',
		  '#test_var' => $this->t('Test Value'),
		];
	}

	public function templatepage2() {
		return [
		  '#theme' => 'my_template2',
		  '#test_var' => $this->t('Test Value'),
		];
	}
	
}
