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
			<div>
<p><a href="https://pcamsvc03.cern.ch/server1/api/a1">HTTPS-a1</a></p>
<p><a href="https://pcamsvc03.cern.ch/server1/api/a2">HTTPS-a2</a></p>
			</div>

			'),
    		];
	}

	public function content() {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('


<script> 
setInterval(myMethod, 2000); 
function myMethod( ) { 
var d = new Date();
var num_of_seconds = d.getSeconds() + 1;
var num_of_seconds_str = ("00" + num_of_seconds).slice(-2)
document.getElementById(\'ed00\').src="/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss_current.png?" + Math.random() ;;
console.log("refreshed"); 
}
</script>

<script>
function testFunction(str) {
    if (str.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        document.getElementById("txtHint").innerHTML = str;
        return;
    }
}
</script>

<p><b>Start typing a name in the input field below:</b></p>
<form> 
Test input value: <input type="text" onkeyup="testFunction(this.value)">
</form>
<p>Suggestions: <span id="txtHint"></span></p>


			'),
    		];
	}
}
