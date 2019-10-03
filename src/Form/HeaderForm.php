<?php

namespace Drupal\airsuggest_tracking_scripts\Form;

use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provide settings page for adding JS before the end of body tag.
 */
class HeaderForm extends ConfigFormBase {

  /**
   * Implements FormBuilder::getFormId.
   */
  public function getFormId() {
    return 'hfs_header_settings';
  }

  /**
   * Implements ConfigFormBase::getEditableConfigNames.
   */
  protected function getEditableConfigNames() {
    return ['airsuggest_tracking_scripts.header.settings'];
  }

  /**
   * Implements FormBuilder::buildForm.
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $header_section = $this->config('airsuggest_tracking_scripts.header.settings')->get();

    $form['hfs_header'] = [
      '#type'        => 'fieldset',
      '#title'       => $this->t('Add Scripts in Header'),
      '#description' => $this->t('All the defined scripts in this section would be added just before closing the <strong>body</strong> tag.'),
    ];

    $form['hfs_header']['scripts'] = [
      '#type'          => 'textarea',
      '#title'         => $this->t('Header Scripts'),
      '#default_value' => isset($header_section['scripts']) ? $header_section['scripts'] : '',
      '#description'   => $this->t('<p>Visit Our product section and find tracking code link. There you will find tracking code, Kindly copy and paste here. You will install tracking Code in one click.</p>'),
      '#rows'          => 10,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Implements FormBuilder::submitForm().
   *
   * Serialize the user's settings and save it to the Drupal's config Table.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $this->configFactory()
      ->getEditable('airsuggest_tracking_scripts.header.settings')
      ->set('styles', $values['styles'])
      ->set('scripts', $values['scripts'])
      ->save();

    drupal_set_message($this->t('Your Settings have been saved.'), 'status');
  }

}
