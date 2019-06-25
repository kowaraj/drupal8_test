<?php

namespace Drupal\custom_ajax_link2\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AlertCommand;


class CustomAjaxLink2Controller extends ControllerBase {

	public function alertpage($xname) {
 
		# New responses
		$response = new AjaxResponse();
 
		# Commands Ajax
		$response->addCommand(new AlertCommand ('Hello'. $xname));
 
		# Return response
		return $response;
	}

	public function mainpage($xparam) {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('
			<div>
			<p>
             test mainpage ' . $xparam . '
			</p>
			</div>

			'),
    		];
	}
	
	public function testpage() {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('
			<div>
			<p>
			<a class="use-ajax" href="/custom_ajax_link2/alertpage/Andrej"> open alert for ajax link testing </a>
			</p>
			</div>

			'),
    		];
	}


}
