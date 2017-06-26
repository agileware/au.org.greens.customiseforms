<?php

require_once 'customiseforms.civix.php';

/**
 * Australian Greens customisations of Civi Core forms.
 *
 */
function customiseforms_civicrm_buildForm($formName, &$form) {
  // Atrium 2898: By default, do not have a confirmation page on a contribution page - this interferes with the Multipage form.
  if ($formName == "CRM_Contribute_Form_ContributionPage_Settings") {
    if ($form->getAction() == CRM_Core_Action::ADD) {
      $form->setDefaults(array('is_confirm_enabled' => FALSE));
    }
  }

  // Disable Primary Field Exports due to performance problems.
  if ($formName == "CRM_Export_Form_Select") {
    $form->setDefaults(array('exportOption' => CRM_Export_Form_Select::EXPORT_SELECTED));
    $exportOptionElements = $form->getElement('exportOption')->getElements();
    foreach ($exportOptionElements as $exportOption) {
      if ($exportOption->getValue() == CRM_Export_Form_Select::EXPORT_ALL) {
        $exportOption->setAttribute('disabled');
        $exportOption->setText(ts('Export PRIMARY fields - sorry this option has been disabled due to performance issues.  Please choose the data you wish to export instead.'));
      }
    }
  }
  // Atrium 4566 Set the Add new box for Memberships to be checked by default.
  if ($formName == "CRM_Contact_Form_Merge") {
    $defaults['operation[move_rel_table_memberships][add]'] = 1;
    $form->setDefaults($defaults);
  }

  // Change the submit button text on the Main and Confirm form steps for greens NSW Membership forms to be more accurate and about membership
  if ($formName == 'CRM_Contribute_Form_Contribution_Confirm' || $formName == 'CRM_Contribute_Form_Contribution_Main') {
    customiseforms_change_nsw_membership_button_text($formName, $form);
  }
}

/**
 * Change the submit button text on the Main and Confirm form steps for greens NSW Membership forms to be more accurate and about membership
 */
function customiseforms_change_nsw_membership_button_text($formName, &$form) {
  $membership_join_forms = array(79);
  $membership_renew_forms = array(85);
  $type = '';
  $value = '';
  $contribution_form_classes = array("CRM_Contribute_Form_Contribution_Confirm", "CRM_Contribute_Form_Contribution_Main");
  $button_names = array(
    'CRM_Contribute_Form_Contribution_Confirm' => '_qf_Confirm_next',
    'CRM_Contribute_Form_Contribution_Main' => '_qf_Main_upload',
  );
  $buttons = $form->getElement('buttons')->getElements();
  foreach ($buttons as $button) {
    if ($button->_attributes['name'] == $button_names[$formName]) {
      if (in_array($form->_id, $membership_renew_forms)) {
        $type = 'Renewal';
      }
      elseif (in_array($form->_id, $membership_join_forms)) {
        $type = 'Application';
      }
      if (substr($formName, -4) == 'Main' && !empty($type)) {
        $value = 'Confirm Membership ' . $type;
      }
      elseif (!empty($type)) {
        $value = 'Submit Membership ' . $type;
      }
      if (!empty($value)) {
        $button->setValue($value);
      }
    }
  }
}

/**
 * Australian Greens customisations of Civi Core templates.
 */
function customiseforms_civicrm_alterContent(&$content, $context, $tplName, &$object) {
  // Atrium 3932: Remove in-line editing to improve performance of the Manage Tags, Manage Price Sets and Schedule Reminders pages
  if ($tplName == "CRM/Tag/Page/Tag.tpl" || $tplName == "CRM/Price/Page/Set.tpl" || $tplName == "CRM/Admin/Page/ScheduleReminders.tpl") {
    $content = str_replace(" crm-editable", "", $content);
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function customiseforms_civicrm_config(&$config) {
  _customiseforms_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function customiseforms_civicrm_xmlMenu(&$files) {
  _customiseforms_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function customiseforms_civicrm_install() {
  _customiseforms_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function customiseforms_civicrm_uninstall() {
  _customiseforms_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function customiseforms_civicrm_enable() {
  _customiseforms_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function customiseforms_civicrm_disable() {
  _customiseforms_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function customiseforms_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _customiseforms_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function customiseforms_civicrm_managed(&$entities) {
  _customiseforms_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function customiseforms_civicrm_caseTypes(&$caseTypes) {
  _customiseforms_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function customiseforms_civicrm_angularModules(&$angularModules) {
  _customiseforms_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function customiseforms_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _customiseforms_civix_civicrm_alterSettingsFolders($metaDataFolders);
}
