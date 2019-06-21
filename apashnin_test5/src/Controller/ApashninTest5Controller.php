<?php

namespace Drupal\apashnin_test5\Controller;

use Drupal\Core\Controller\ControllerBase;


class ApashninTest5Controller extends ControllerBase {

	public function secondpage($param) {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('
<p>
This is the SECOND PAGE: $param
</p>
			<p>
			<img id="ed00" style="width:100px;height:60px;border:0;" src="/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss_01.png" />
			</p>

			'),
    		];

	}

	public function loginpage() {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('

<p>
This is the LOGIN
<a href="http://asuseepc900/ss.png">GO TO a900</a>
</p>

			'),
    		];

	}


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
document.getElementById(\'ed00\').src="/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss_current.png?" + Math.random() ;;
console.log("refreshed"); 
}
</script>





<script>
function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "http://pcamsvc03:9090/api/a2", true);
        xmlhttp.send();
    }
}
</script>

<p><b>Start typing a name in the input field below:</b></p>
<form> 
First name: <input type="text" onkeyup="showHint(this.value)">
</form>
<p>Suggestions: <span id="txtHint"></span></p>







									  
			<div>
?HELLOO! 
<p><a href="secondpage">Second page</a></p>
<p><a href="loginpage">Login</a></p>
<p><a href="http://asuseepc900:9090/api/a1">Action: a1</a></p>
<p><a href="http://asuseepc900:9090/api/a2">Action: a2</a></p>
<p><a href="http://pcamsvc03:9090/api/a1">Action to vc03: a1</a></p>
<p><a href="http://pcamsvc03:9090/api/a2">Action to vc03: a2</a></p>


			<p>
			<img id="ed00" style="width:1000px;height:600px;border:0;" src="/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss.png" />
			</p>
			</div>
			'),
    		];

	}
}
