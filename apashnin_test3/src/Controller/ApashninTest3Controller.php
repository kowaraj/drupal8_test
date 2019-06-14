<?php

namespace Drupal\apashnin_test3\Controller;

use Drupal\Core\Controller\ControllerBase;


class ApashninTest3Controller extends ControllerBase {

	public function content() {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t("<p>asdfasdfasfd</p>" . '<p> <img id="ed00" style="width:1000px;height:600px;border:0;" src="/sites/test-apashnin.web.cern.ch/files/ss.png" /></p>'),
    		];

	}
}
