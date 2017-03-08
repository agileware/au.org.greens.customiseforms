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
}

/**
 * Australian Greens customisations of Civi Core templates.
 */
function customiseforms_civicrm_alterContent( &$content, $context, $tplName, &$object ) {
// Atrium 3932: Remove in-line editing to improve performance of the Manage Tags, Manage Price Sets and Schedule Reminders pages
  if($tplName == "CRM/Tag/Page/Tag.tpl" || $tplName == "CRM/Price/Page/Set.tpl" || $tplName == "CRM/Admin/Page/ScheduleReminders.tpl") {
    $content = str_replace(" crm-editable","",$content);
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
 * @param array $files
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
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
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
 * @param array $caseTypes
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

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function customiseforms_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function customiseforms_civicrm_navigationMenu(&$menu) {
  _customiseforms_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'au.org.greens.customiseforms')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _customiseforms_civix_navigationMenu($menu);
} // */
