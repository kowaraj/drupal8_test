<?php

namespace Drupal\apashnin_test\Controller;

class ApashninTestController {

	public function hello() {

		$items = array(
			array('name' => 'Article number one'), 
			array('name' => 'Article number 2'), 
			array('name' => 'Article number III') 
		);

		return array(
			'#theme' => 'article_list',
			'#title' => "New3 Title of A.Pashnin Test module",
			'#markup' => "This is some content <p> of A.Pashnin Test module<",
			'#items' => $items
		);
	}
}
