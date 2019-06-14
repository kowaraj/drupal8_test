<?php

namespace Drupal\apashnin_test5\Controller;

use Drupal\Core\Controller\ControllerBase;


class ApashninTest5Controller extends ControllerBase {

	public function content() {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('
	
<script> 
setInterval(myMethod, 3000); 
function myMethod( ) { 
var d = new Date();
var num_of_seconds = d.getSeconds() + 1;
var num_of_seconds_str = ("00" + num_of_seconds).slice(-2)
document.getElementById(\'ed00\').src="/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss_" + num_of_seconds_str + ".png" ;;
console.log("refreshed"); 
}
</script>
			<div>
			<p>
			<img id="ed00" style="width:1000px;height:600px;border:0;" src="/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss.png" />
			</p>
			</div>
			'),
    		];

	}
}
