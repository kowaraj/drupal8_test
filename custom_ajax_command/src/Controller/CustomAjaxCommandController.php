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
	public function trigger3() {

		$ret = rmdir('/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_current_3/');
		if(! $ret) 
		{
			$rmdir_result = "failed to rmdir";
		} else {
			$rmdir_result = "succeded to rmdir";
		}

		return [
			'#type' => 'markup',
			'#markup' => $this->t('<p> 
									Result : ' . $rmdir_result . '<br>
									</p>'),
		];
	}

	public function trigger2() {

		$ret = rmdir('/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_current_2/');
		if(! $ret) 
		{
			$rmdir_result = "failed to rmdir";
		} else {
			$rmdir_result = "succeded to rmdir";
		}
	  
		// $dst_path = '/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_current_2';
		// // delete dir if exists
		// $rmdir2_result = "";
		// if ( is_dir($dst_path) ) {
		// 	$rmdir2_result = rmdir($dst_path);
		// } else {
		// 	$rmdir2_result = "none";
		// }

		return [
			'#type' => 'markup',
			'#markup' => $this->t('<p> 
									Result : ' . $rmdir_result . '<br>
									</p>'),
		];

	}

	// To be triggered by an external request (from ed_reader when ready) via a curl/wget/httprequest.
	public function trigger() {

		// read the current index
		// EventDisplayCurrentBuffer is the current source of screenshots for a client
		$current_buf = \Drupal::state()->get('EventDisplayCurrentBuffer');
		if ($current_buf == "") 
			$current_buf = 1;

		// source path
		$src_path = '/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_copied';
			
		// destination path
		if ($current_buf == "1") {
			$dst_path = '/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_current_2';
		} else if ($current_buf == "2") {
			$dst_path = '/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_current_1';
		} else {
			$dst_path = '/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_current_unknown';
		}
		
		// // delete files if exist
		$rmdir_result = "";
		if ( is_dir($dst_path) ) {
			array_map('unlink', glob($dst_path . "/*"));
			$rmdir_result = "ok";
		} else {
			$rmdir_result = "none";
		}
		
		// // delete dir if exists
		$rmdir2_result = "";
		if ( is_dir($dst_path) ) {
			$rmdir2_result = rmdir($dst_path);
		} else {
			$rmdir2_result = "none";
		}

		// $ff = [];
		// foreach (glob($dst_path. "/*") as $filename) {
		// 	array_push($ff, $filename);      
		// 	unlink($filename);
		// }

		//move
		$rename_result = "";
		if (! rename($src_path, $dst_path)) {
			$rename_result = 'failed';
		} else {
			$rename_result = 'ok';
			if ($current_buf == "1") {
				\Drupal::state()->set('EventDisplayCurrentBuffer','2');
			} else {
				\Drupal::state()->set('EventDisplayCurrentBuffer','1');
			}
		}

		// return 
		$current_buf_now = \Drupal::state()->get('EventDisplayCurrentBuffer');
		return [
			'#type' => 'markup',
			'#markup' => $this->t('<p> 
									Current buffer was       : ' . $current_buf . '<br>
									Result of the rename was : ' . $rename_result . '<br>
									Current buffer now is    : ' . $current_buf_now . '<br>
									Path of source           : ' . $src_path . '<br>
									Path of destination      : ' . $dst_path . '<br>
									Result of rmdir          : ' . $rmdir_result . '<br>
									Result of rmdir2         : ' . $rmdir2_result . '<br>
									files ======== ' . implode(",", $ff) . '<br>
									len ======== ' . count($ff) . '<br>
									</p>'),
		];
	}


	public function getCurrentBuffer() {
		$current_buf_now = \Drupal::state()->get('EventDisplayCurrentBuffer');
		$dir_path = '/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_current_' . $current_buf_now;
		$img_path = '/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer_current_' . $current_buf_now;
		$d = array_diff(scandir($dir_path), array('..', '.', '.DAV')); 
		$ret['d'] = sizeof($d);
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
		$ret['d'] = sizeof($d);
		
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
 
		# New responses
		$response = new AjaxResponse();

        # Custom Ajax command
		//$message = 'This alert () was started from the Ajax custom command2-2';
		// $img_list = [
		// 	"/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/ss_1561740332.png", 
		// 	"/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/ss_1561740333.png", 
		// 	"/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/ss_1561740334.png",
		// 	"/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/ss_1561740335.png",
		// 	"/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/ss_1561740336.png"
		//   ];
		$buffer_info = $this->getCurrentBuffer();
		//$response->addCommand(new CustomAjaxCommand2($message));
		$response->addCommand(new CustomAjaxCommand2($buffer_info));
 
		# Return response
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
