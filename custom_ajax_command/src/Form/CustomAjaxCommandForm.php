<?php
namespace Drupal\custom_ajax_command\Form;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Ajax\InvokeCommand;

class CustomAjaxCommandForm extends FormBase {
	
	public function getFormId() {
		return 'custom_ajax_command_form';
	}
	
	public function getTitle2() {
		return $this->t('v.0.1.99');
	}

	public function getListOfScreenshots() {
		$dir_path = '/drupal/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/';
		$d = array_diff(scandir($dir_path), array('..', '.', '.DAV'));
		return $d; 
	}

	public function buildForm(array $form, FormStateInterface $form_state) {
		$title2 = $this->getTitle2();
		$list_of_files = $this->getListOfScreenshots();

		$form['offline_ed'] = [
			'#type' => 'checkbox',
			'#title' => $this->t('Go \'offline\' to explore stored events.'),
			'#ajax' => [
			  'callback' => '::textfieldsCallback',
			  'wrapper' => 'textfields-container',
			  'effect' => 'fade',
			],
		  ];
		$form['textfields_container'] = [
			'#type' => 'container',
			'#attributes' => ['id' => 'textfields-container'],
		];
		$form['textfields_container']['textfields'] = [
			'#type' => 'fieldset',
			// '#title' => $this->t("this is a title of the container"),
			// '#description' => t('this is the content of the container'),
		];

		if ($form_state->getValue('offline_ed', NULL) === 1) {
			$form['textfields_container']['textfields']['offline_ed'] = [
				'#theme' => 'my_template3',
				'#test_var' => $title2,
				'#ss_path' => '/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss_default.png',
				'#events' => $list_of_files,
				'#featured' => ['featured1', 'featured2'],
			];
		} else {
			$form['textfields_container']['textfields']['online_ed'] = [
				'#theme' => 'ed_online',
				'#ss_path' => '/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss_default.png',
			];			
		}
		return $form;
	}

	public function setMessage(array $form, FormStateInterface $form_state) {
		$response = new AjaxResponse();
		$response->addCommand(
			new HtmlCommand(
				'.result_message',
				'<div class="my_top_message">' . t('The results is @result', ['@result' => ($form_state->getValue('number_1') + $form_state->getValue('number_2'))]) . '</div>'
			)
		);
		return $response;
	}
	
	
	public function submitForm(array &$form, FormStateInterface $form_state) {
	}
	
	public function textfieldsCallback($form, FormStateInterface $form_state) {
		return $form['textfields_container'];
	  }
	
}
