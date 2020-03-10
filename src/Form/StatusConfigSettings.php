<?php

namespace Drupal\status_config\Form;

use Drupal\Core\Form\ConfigFormBase;

use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration form for status message text and colors.
 */
class StatusConfigSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $weight = 1;

    $form = parent::buildForm($form, $form_state);

    // $config = \Drupal::config('status_config.settings');
    $config = $this->config('status_config.settings');

    $logmessage = $config->get('custom_log_message') ?? 'Custom log message';
    $statusmessage = $config->get('custom_status_message') ?? 'Custom status message';

    $textcolor = $config->get('color_status_text') ?? 'black';
    $bgcolor = $config->get('color_status_bg') ?? '#bfe8f3';
    $bordercolor = $config->get('border_color') ?? '#0a99bc';
    $shadowcolor = $config->get('shadow_color') ?? '#999999';

    $form['custom_log_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Log message text'),
      '#default_value' => $logmessage,
      '#required' => TRUE,
      '#weight' => $weight,
    ];

    $form['custom_status_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Status message text'),
      '#default_value' => $statusmessage,
      '#required' => TRUE,
      '#weight' => $weight,
      '#attributes' => ['style' => 'background-color: ' . $bgcolor . '; color: ' . $textcolor . ';' . ' border-color: ' . $bordercolor . ';' . ' border-width: ' . '2px' . ';' . ' box-shadow: -6px 6px 3px ' . $shadowcolor . ';'],
    ];

    $form['color_status_bg'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Status message background color'),
      '#default_value' => $bgcolor,
      '#required' => TRUE,
      '#weight' => $weight,
      '#attributes' => ['style' => 'background-color: ' . $bgcolor . '; color: ' . $textcolor . ';' . ' border-color: ' . $bordercolor . ';' . ' border-width: ' . '2px' . ';' . ' box-shadow: -6px 6px 3px ' . $shadowcolor . ';'],
    ];

    $form['color_status_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Status message text color'),
      '#default_value' => $textcolor,
      '#required' => TRUE,
      '#weight' => $weight,
      '#attributes' => ['style' => 'background-color: ' . $bgcolor . '; color: ' . $textcolor . ';' . ' border-color: ' . $bordercolor . ';' . ' border-width: ' . '2px' . ';' . ' box-shadow: -6px 6px 3px ' . $shadowcolor . ';'],
    ];

    $form['border_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Border color'),
      '#default_value' => $bordercolor,
      '#required' => TRUE,
      '#weight' => $weight,
      '#attributes' => ['style' => 'background-color: ' . $bgcolor . '; color: ' . $textcolor . ';' . ' border-color: ' . $bordercolor . ';' . ' border-width: ' . '2px' . ';' . ' box-shadow: -6px 6px 3px ' . $shadowcolor . ';'],
    ];

    $form['shadow_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Shadow color'),
      '#default_value' => $shadowcolor,
      '#required' => TRUE,
      '#weight' => $weight,
      '#attributes' => ['style' => 'background-color: ' . $bgcolor . '; color: ' . $textcolor . ';' . ' border-color: ' . $bordercolor . ';' . ' border-width: ' . '2px' . ';' . ' box-shadow: -6px 6px 3px ' . $shadowcolor . ';'],
    ];

    $textcolor = $config->get('color_error_text') ?? 'white';
    $bgcolor = $config->get('color_error_bg') ?? '#DD0C15';

    $form['color_error_bg'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Error message background color'),
      '#default_value' => $bgcolor,
      '#required' => TRUE,
      '#weight' => $weight,
      '#attributes' => ['style' => 'background-color: ' . $bgcolor . '; color: ' . $textcolor . ';' . ' border-color: ' . $bordercolor . ';' . ' border-width: ' . '2px' . ';' . ' box-shadow: -6px 6px 3px ' . $shadowcolor . ';'],
    ];

    $form['color_error_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Error message text color'),
      '#default_value' => $textcolor,
      '#required' => TRUE,
      '#weight' => $weight,
      '#attributes' => ['style' => 'background-color: ' . $bgcolor . '; color: ' . $textcolor . ';' . ' border-color: ' . $bordercolor . ';' . ' border-width: ' . '2px' . ';' . ' box-shadow: -6px 6px 3px ' . $shadowcolor . ';'],
    ];

    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('status_config.settings');

    $config->set('custom_log_message', $form_state->getValue('custom_log_message'));
    $config->set('custom_status_message', $form_state->getValue('custom_status_message'));

    $config->set('color_status_bg', $form_state->getValue('color_status_bg'));
    $config->set('color_status_text', $form_state->getValue('color_status_text'));
    $config->set('border_color', $form_state->getValue('border_color'));
    $config->set('shadow_color', $form_state->getValue('shadow_color'));
    $config->set('color_error_bg', $form_state->getValue('color_error_bg'));
    $config->set('color_error_text', $form_state->getValue('color_error_text'));

    $config->save();
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'status_config.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'status_config_settings_form';
  }

}
