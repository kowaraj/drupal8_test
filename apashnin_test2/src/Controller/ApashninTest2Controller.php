<?php

namespace Drupal\apashnin_test2\Controller;

use Drupal\Core\Controller\ControllerBase;


class ApashninTest2Controller extends ControllerBase {

	public function content() {
    		return array(
        		'#markup' => '' . t('Hello there!') . '',
    		);
	}
}
