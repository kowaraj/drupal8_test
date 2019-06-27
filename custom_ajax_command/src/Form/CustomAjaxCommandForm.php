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
	
	public function buildForm(array $form, FormStateInterface $form_state) {
		$form['message'] = [
			'#type' => 'markup',
			'#markup' => '<div class="result_message">TEST-DIV-RES-MES</div>',
		];
		$form['number_1'] = [
			'#type' => 'textfield',
			'#title' => $this->t('Number 1'),
		];
		$form['number_2'] = [
			'#type' => 'textfield',
			'#title' => $this->t('Number 2'),
		];
		$form['actions'] = [
			'#type' => 'button',
			'#value' => $this->t('Submit'),
			'#ajax' => [
				'callback' => '::setMessage',
			],
		];
		$form['ed_template_test'] = [
			'#theme' => 'my_template2',
			'#test_var' => $this->t('Test Value for the Form!'),
		];
		$form['ed_template3'] = [
			'#theme' => 'my_template3',
			'#test_var' => $this->t('Test Value for the Form for Template #3!'),
			'#ss_path' => '/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss_default.png',
			'#events' => ['event1', 'event2'],
            '#featured' => ['featured1', 'featured2'],

		];
		$form['ed_ss'] = [
			'#type' => 'markup',
			'#markup' => '			
			<div>
			<p>
			<img id="ed00" style="width:200px;height:120px;border:0;" src="/sites/test-apashnin.web.cern.ch/files/EventDisplay/ss_default.png" />
			</p>
			</div>
			',
		];

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
	
}
