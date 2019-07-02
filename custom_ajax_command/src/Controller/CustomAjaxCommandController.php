<?php

namespace Drupal\custom_ajax_command\Controller;

use Drupal\custom_ajax_command\Ajax\CustomAjaxCommand;
use Drupal\custom_ajax_command\Ajax\CustomAjaxCommand2;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AlertCommand;

class CustomAjaxCommandController extends ControllerBase {

	public function customalert() {
		$response = new AjaxResponse();
		$buffer_info = $this->getCurrentBuffer();
		$response->addCommand(new CustomAjaxCommand($buffer_info));
		return $response;
	}

	public function testpage() {
		return [
      			'#type' => 'markup',
				'#markup' => $this->t('

			<div id="ed00ss" data-list1="" data-list2="" data-index="1"> </div>

			<div>
			<script>
				window.onload=function(){
					if( document.getElementById("id_customalert")!=null ) {
						document.getElementById("id_customalert").click();
						console.log("customalert link has been auto-clicked");
					}
				}
			</script>

			<img id="ed00" style="width:600px;height:360px;border:0;" src="/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss_default.png"> 

			<p hidden>
			<a id="id_customalert" class="use-ajax" href="/custom_ajax_command/customalert"> Alert (custom) me! </a>
			</p>
			</div>
			'),
    	];
	}
	public function trigger3() {
		return [
			'#type' => 'markup',
			'#markup' => $this->t('<p> </p>'),
		];
	}

	public function trigger2() {
		return [
			'#type' => 'markup',
			'#markup' => $this->t('<p> </p>'),
		];
	}

	// To be triggered by an external request (from ed_reader when ready) via a curl/wget/httprequest.
	public function trigger() {

		// destination path
		$current_buf = gmdate("U");

		$dst_path = '/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_current_' . $current_buf;

		// source path
		$src_path = '/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_copied';

		//move
		$rename_result = "";
		if (! rename($src_path, $dst_path)) {
			$rename_result = 'failed';
		} else {
			$rename_result = 'ok';
			\Drupal::state()->delete('qqq');
			\Drupal::state()->set('qqq', (int)$current_buf);
		}

		// return 
		$current_buf_now = \Drupal::state()->get('qqq');
		return [
			'#type' => 'markup',
			'#markup' => $this->t('<p> 
									Current buffer was       : ' . $current_buf . '<br>
									Result of the rename was : ' . $rename_result . '<br>
									Current buffer now is    : ' . $current_buf_now . '<br>
									(src) Path : ' . $src_path . '<br>
									(dst) Path : ' . $dst_path . '<br>
									</p>'),
		];
	}


	public function getCurrentBuffer() {
		$current_buf_now = \Drupal::state()->get('qqq');
		$dir_path = '/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_current_' . $current_buf_now;
		$img_path = '/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_current_' . $current_buf_now;
		$d = array_diff(scandir($dir_path), array('..', '.', '.DAV')); 
		$ret['d'] = array_slice($d, 0, 10);
		$ret['img_path'] = $img_path;
		$ret['current_buf_now'] = $current_buf_now;
		return $ret;
	}

	public function obsolete__getCurrentBuffer() {
		$d_slice_size = 100;
		$ts_delta = 10;
		$ret = [];
		$dir_path = '/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/';
		$img_path = "/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/";

		// TODO: do a better matching! e.g: for filename pattern 'ss_123456789.png'?
		$d = array_diff(scandir($dir_path), array('..', '.', '.DAV')); 
		$ret['d'] = $d;
		
		$ts_now = gmdate("U"); //time();
		$ret['ts_current'] = $ts_now;
		$ts = ((int)$ts_now) - $ts_delta;
 		$ret['ts_to_fetch'] = $ts;

		$ts_i = array_search('ss_' . $ts . '.png', $d);
		$ret['ts_to_fetch_index'] = $ts_i;

		if ($ts_i != false) {
			$d_slice = array_slice($d, $ts_i, $d_slice_size);
			$ret['slice'] = $d_slice;				
			$ret['stale'] = false;				
		} else {
			$d_slice = array_slice($d, 0, $d_slice_size);
			$ret['slice'] = $d_slice;
			$ret['stale'] = true;				
		}

		$ret['img_path'] = $img_path;
		return $ret;
	}

	public function customalert2() {
		$response = new AjaxResponse();
		$buffer_info = $this->getCurrentBuffer();
		$response->addCommand(new CustomAjaxCommand2($buffer_info));
		return $response;
	}

	public function testpage2() {
		return [
      			'#type' => 'markup',
      			'#markup' => $this->t('
			<div>
			<img id="ed00" style="width:600px;height:360px;border:0;" src="/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss_default.png"> 
			<script>
				window.onload=function(){
					if( document.getElementById("id_customalert2")!=null ) {
						document.getElementById("id_customalert2").click();
						console.log("customalert2 link has been auto-clicked");
					}
				}

			</script>
			
			<p>
			<a id="id_customalert2" class="use-ajax" href="/custom_ajax_command/customalert2"> Alert (custom) me! </a>
			</p>
			<span id="ed00_status"> UNDEFINED </span>
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
