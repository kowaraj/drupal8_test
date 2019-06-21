<?php

namespace Drupal\apashnin_test6\Controller;

use Drupal\Core\Controller\ControllerBase;


class EventDisplay extends ControllerBase {

	public function mainpage() {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('


<p>Requested time of the Event Display (seconds in the past): <span id="ed_ts_delay"></span></p>
<script> 
setInterval(myMethod, 2000); 
function myMethod( ) { 
var ts_ms = Date.now();

var delta = 60*60; // 1 hour ago
var ts_ms_str = document.getElementById("ed_ts_delay").innerHTML;
    if (ts_ms_str.length == 0) { 
        delta = 60;
    } else {
        delta = parseInt(ts_ms_str);
    }
console.log("delta = " + delta);

var num_of_seconds = parseInt(ts_ms/1000) - delta;
console.log("num_of_seconds = " + num_of_seconds);

document.getElementById(\'ed00\').src="/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/ss_" + num_of_seconds + ".png" ;;
//document.getElementById(\'ed00\').src="/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss.png?" + Math.random() ;;
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


<script>
function setTsDelay(str) {
    if (str.length == 0) { 
        document.getElementById("ed_ts_delay").innerHTML = "600";
        return;
    } else {
        document.getElementById("ed_ts_delay").innerHTML = str;
        return;
    }
}
</script>
<p><b>Go back to your past on (seconds):</b></p>
<form> 
Delay: <input type="text" onkeyup="setTsDelay(this.value)">
</form>
<p>Suggestions: <span id="ed_ts_delay"></span></p>



			<div>
			<p>
			<img id="ed00" style="width:1000px;height:600px;border:0;" src="/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss.png" />
			</p>
			</div>

			'),
    		];
	}
}
