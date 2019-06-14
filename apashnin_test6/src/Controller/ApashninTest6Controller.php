<?php

namespace Drupal\apashnin_test6\Controller;

use Drupal\Core\Controller\ControllerBase;


class ApashninTest6Controller extends ControllerBase {

	public function secondpage($param) {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('<p>This is the SECOND PAGE: $param</p>
			'),
    		];
	}

	public function loginpage() {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('<p>This is the LOGIN</p>
			'),
    		];
	}

	public function content() {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('
			<div>
<p><a href="https://pcamsvc03.cern.ch/server1/api/a1">HTTPS-a1</a></p>
<p><a href="https://pcamsvc03.cern.ch/server1/api/a2">HTTPS-a2</a></p>
			</div>
			'),
    		];
	}
}
