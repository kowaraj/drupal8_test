<?php
namespace Drupal\ajax_form_submit2\Form;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\OpenModalDialogCommand;



use Drupal\Core\Ajax\InvokeCommand;



class AjaxSubmitDemo2 extends FormBase {
	
	public function getFormId() {
		return 'ajax_submit_demo2';
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
		$form['message_2'] = [
			'#type' => 'markup',
			'#markup' => '<div class="result_message2"></div>',
		];
		$form['actions_2'] = [
			'#type' => 'button',
			'#value' => $this->t('Submit2'),
			'#ajax' => [
				'callback' => '::setMessage2',
			],
		];
		$form['container']['output'] = [
			'#type' => 'textfield',
			'#size' => '60',
			'#disabled' => TRUE,
			'#value' => 'Hello, World!',
			'#attributes' => [
				'id' => ['edit-output'],
			],
		];

		$form['input_1'] = [
			'#type' => 'textfield',
			'#title' => 'A Textfield',
			'#description' => 'Enter a number to be validated via ajax.',
			'#size' => '60',
			'#maxlength' => '10',
			'#required' => TRUE,
			'#ajax' => [
				'callback' => '::sayHello1',
				'event' => 'keyup',
				'wrapper' => 'edit-output',
				'progress' => [
					'type' => 'throbber',
					'message' => t('Verifying entry...'),
				],
			],
		];

		$form['input_2'] = [
			'#type' => 'textfield',
			'#title' => 'A Textfield',
			'#description' => 'Enter a number to be validated via ajax.',
			'#size' => '60',
			'#maxlength' => '10',
			'#required' => TRUE,
			'#ajax' => [
				'callback' => '::sayHello2',
				'event' => 'keyup',
				'wrapper' => 'edit-output',
				'progress' => [
					'type' => 'throbber',
					'message' => t('Verifying entry...'),
				],
			],
		];

		$form['input_3'] = [
			'#type' => 'textfield',
			'#title' => 'A Textfield',
			'#description' => 'Enter a number to be validated via ajax.',
			'#size' => '60',
			'#maxlength' => '10',
			'#required' => TRUE,
			'#ajax' => [
				'callback' => '::sayHelloAjax',
				'event' => 'keyup',
				'wrapper' => 'edit-output',
				'progress' => [
					'type' => 'throbber',
					'message' => t('Verifying entry...'),
				],
			],
		];
		
		$form['input_4'] = [
			'#type' => 'textfield',
			'#title' => 'A Textfield',
			'#description' => 'Enter a number to be validated via ajax.',
			'#size' => '60',
			'#maxlength' => '10',
			'#required' => TRUE,
			'#ajax' => [
				'callback' => '::sayHelloFromJQuery',
				'event' => 'keyup',
				'wrapper' => 'edit-output',
				'progress' => [
					'type' => 'throbber',
					'message' => t('Verifying entry...'),
				],
			],
		];


		return $form;
	}

	public function sayHello1(array &$form, FormStateInterface $form_state) {
		$elem = [
			'#type' => 'textfield',
			'#size' => '60',
			'#disabled' => TRUE,
			'#value' => 'Hello, ' . $form_state->getValue('input_1') . '!',
			'#attributes' => [
				'id' => ['edit-output'],
			],
		];
		
		return $elem;
	}

	public function sayHello2(array &$form, FormStateInterface $form_state) {
		$markup = '<h1>H3llo!?' . $form_state->getValue('input_2') . '</h1>';
		return ['#markup' => $markup];
	}

	public function sayHelloAjax(array &$form, FormStateInterface $form_state) {
		//create a text field render array
		$elem = [
			'#type' => 'textfield',
			'#size' => '60',
			'#disabled' => TRUE,
			'#value' => 'Hello-from-ajax-3, ' . $form_state->getValue('input_3') . '!',
			'#attributes' => [
				'id' => ['edit-output'],
			],
		];

		$renderer = \Drupal::service('renderer');
		$response = new AjaxResponse();

		//issue a command that replaces the element #edit-output 
		//with the rendered markup of the field created above.
		$response->addCommand(new ReplaceCommand('#edit-output', $renderer->render($elem)));

		//show a dialog box
		// $dialogText['#markup'] = "Nice text ...";
		// $dialogText['#attached']['library'][] = 'core/drupal.dialog.ajax';
		// $response->addCommand(new OpenModalDialogCommand("My title", $dialogText, ['width' => '300']));

		return $response;
	}


	public function sayHelloFromJQuery(array &$form, FormStateInterface $form_state) {
		$response = new AjaxResponse();
		$response->addCommand(new InvokeCommand(NULL, 'myAjaxCallback', ['My arguments']));
		return $response;
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
	
	public function setMessage2(array $form, FormStateInterface $form_state) {
		$response = new AjaxResponse();
		$response->addCommand(
			new HtmlCommand(
				'.result_message2',
				'<div class="my_top_message">' . t('The results is @result', ['@result' => ($form_state->getValue('number_1') - $form_state->getValue('number_2'))]) . '</div>'
			)
		);
		return $response;
	}

	public function submitForm(array &$form, FormStateInterface $form_state) {
	}
	
}
