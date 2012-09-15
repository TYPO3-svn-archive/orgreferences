<?php
if (!defined ('TYPO3_MODE'))
{
  die ('Access denied.');
}



  ////////////////////////////////////////////////////////////////////////////
  //
  // INDEX

  // Configuration by the extension manager
  //    Localization support
  //    Store record configuration
  // Enables the Include Static Templates
  // Add pagetree icons
  // Configure third party tables
  // draft field tx_orgreferences
  //    fe_users
  //    tx_org_cal
  //    tx_org_headquarters
  // TCA tables
  //    orgreferences
  //    orgreferences_audience
  //    orgreferences_cat
  //    orgreferences_course
  //    orgreferences_degree
  //    orgreferences_focus
  //    orgreferences_riskcycle
  //    orgreferences_sector
  //    orgreferences_type



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // Configuration by the extension manager

$confArr  = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);

  // Language for labels of static templates and page tsConfig
$llStatic = $confArr['LLstatic'];
switch($llStatic) {
  case($llStatic == 'German'):
    $llStatic = 'de';
    break;
  default:
    $llStatic = 'default';
}
  // Language for labels of static templates and page tsConfig

  // Simplify the Organiser
$bool_exclude_none    = 1;
$bool_exclude_default = 1;
switch ($confArr['TCA_simplify_organiser'])
{
  case('None excluded: Editor has access to all'):
    $bool_exclude_none    = 0;
    $bool_exclude_default = 0;
    break;
  case('All excluded: Administrator configures it'):
      // All will be left true.
    break;
  case('Default (recommended)'):
    $bool_exclude_default = 0;
  default:
}
  // Simplify the Organiser

  // Simplify backend forms
$bool_time_control = true;
if (strtolower(substr($confArr['TCA_simplify_time_control'], 0, strlen('no'))) == 'no')
{
  $bool_time_control = false;
}
  // Simplify backend forms

  // Store record configuration
$bool_wizards_wo_add_and_list       = false;
$bool_full_wizardSupport_allTables  = true;
$str_marker_pid                     = '###CURRENT_PID###';
switch($confArr['store_records'])
{
  case('Multi grouped: record groups in different directories'):
    //var_dump('MULTI');
    $str_store_record_conf        = 'pid IN (###PAGE_TSCONFIG_IDLIST###)';
    $bool_wizards_wo_add_and_list = true;
    break;
  case('Clear presented: each record group in one directory at most'):
    //var_dump('CLEAR');
    $str_store_record_conf        = 'pid IN (###PAGE_TSCONFIG_ID###)';
    $bool_wizards_wo_add_and_list = true;
    break;
  case('Easy 2: same as easy 1 but with storage pid'):
    $str_marker_pid         = '###STORAGE_PID###';
    $str_store_record_conf  = 'pid=###STORAGE_PID###';
    break;
  case('Easy 1: all in the same directory'):
  default:
    //var_dump('EASY');
    $str_store_record_conf        = 'pid=###CURRENT_PID###';
}
  // Store record configuration
  // Configuration of the extension manager



  ////////////////////////////////////////////////////////////////////////////
  //
  // Enables the Include Static Templates

  // Case $llStatic
switch(true) {
  case($llStatic == 'de'):
      // German
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/',          '+Org-Referenzen: Basis (immer einbinden!)');
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/references/351/',  '+Org-Referenzen: Referenzen');
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/references/361/',  '+Org-Referenzen: Referenzen - Rand');
    break;
  default:
      // English
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/base/',          '+Org-References: Basis (obligate!)');
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/references/351/',  '+Org-References: References');
    t3lib_extMgm::addStaticFile($_EXTKEY,'static/references/361/',  '+Org-References: References - margin');
}
  // Case $llStatic
  // Enables the Include Static Templates



  ////////////////////////////////////////////////////////////////////////////
  //
  // Add pagetree icons

  // Case $llStatic
switch(true) {
  case($llStatic == 'de'):
      // German
    $TCA['pages']['columns']['module']['config']['items'][] =
       array('Org: Referenzen', 'org_wrkshp', t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/references.gif');
    break;
  default:
      // English
    $TCA['pages']['columns']['module']['config']['items'][] =
       array('Org: References', 'org_wrkshp', t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/references.gif');
}
  // Case $llStatic

$ICON_TYPES['org_wrkshp']   = array('icon' => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/references.gif');

  // Add pagetree icons



  /////////////////////////////////////////////////
  //
  // Add default page and user TSconfig

t3lib_extMgm::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/tsConfig/' . $llStatic . '/page.txt">');
  // Add default page and user TSconfig



  ////////////////////////////////////////////////////////////////////////////
  //
  // Configure third party tables

  // draft field tx_orgreferences
  // fe_users
  // tx_org_cal
  // tx_org_headquarters

  // draft field tx_orgreferences
$arr_tx_orgreferences = array (
  'exclude' => 0,
  'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.reference',
  'config'  => array (
    'type'     => 'select',
    'size'     =>   30,
    'minitems' =>    0,
    'maxitems' =>    1,
    'MM'                  => '%MM%',
    'MM_opposite_field'   => '%MM_opposite_field%',
    'foreign_table'       => 'tx_orgreferences',
    'foreign_table_where' => 'AND tx_orgreferences.' . $str_store_record_conf . ' ORDER BY tx_orgreferences.title',
    'wizards' => array(
      '_PADDING'  => 2,
      '_VERTICAL' => 0,
      'add' => array(
        'type'   => 'script',
        'title'  => 'LLL:EXT:orgreferences/locallang_db.xml:wizard.references.add',
        'icon'   => 'add.gif',
        'params' => array(
          'table'    => 'tx_orgreferences',
          'pid'      => $str_marker_pid,
          'setValue' => 'prepend'
        ),
        'script' => 'wizard_add.php',
      ),
      'list' => array(
        'type'   => 'script',
        'title'  => 'LLL:EXT:orgreferences/locallang_db.xml:wizard.references.list',
        'icon'   => 'list.gif',
        'params' => array(
          'table'   => 'tx_orgreferences',
          'pid'     => $str_marker_pid,
        ),
        'script' => 'wizard_list.php',
      ),
      'edit' => array(
        'type'                      => 'popup',
        'title'                     => 'LLL:EXT:orgreferences/locallang_db.xml:wizard.references.edit',
        'script'                    => 'wizard_edit.php',
        'popup_onlyOpenIfSelected'  => 1,
        'icon'                      => 'edit2.gif',
        'JSopenParams'              => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
      ),
    ),
  ),
);
  // draft field tx_orgreferences

  // fe_users
t3lib_div::loadTCA('fe_users');

  // Add field tx_orgreferences
$showRecordFieldList = $TCA['fe_users']['interface']['showRecordFieldList'];
$showRecordFieldList = $showRecordFieldList.',tx_orgreferences';
$TCA['fe_users']['interface']['showRecordFieldList'] = $showRecordFieldList;
  // Add field tx_orgreferences

  // Add field tx_orgreferences
$TCA['fe_users']['columns']['tx_orgreferences']                  = $arr_tx_orgreferences;
$TCA['fe_users']['columns']['tx_orgreferences']['label']         =
  'LLL:EXT:orgreferences/locallang_db.xml:fe_users.tx_orgreferences';
$TCA['fe_users']['columns']['tx_orgreferences']['config']['MM']  = 'tx_orgreferences_mm_fe_users';
  // Add field tx_orgreferences

  // Insert div [references] at position $int_div_position
$str_showitem     = $TCA['fe_users']['types']['0']['showitem'];
$arr_showitem     = explode('--div--;', $str_showitem);
$int_div_position = 2;
foreach($arr_showitem as $key => $value)
{
  switch(true)
  {
    case($key < $int_div_position):
        // Don't move divs, which are placed before the new tab
      $arr_new_showitem[$key] = $value;
      break;
    case($key == $int_div_position):
        // Insert the new tab
      $arr_new_showitem[$key]     = 'LLL:EXT:orgreferences/locallang_db.xml:fe_users.div_tx_orgreferences, tx_orgreferences,';
        // Move former tab one position behind
      $arr_new_showitem[$key + 1] = $value;
      break;
    case($key > $int_div_position):
        // Move divs, which are placed after the new tab one position behind
      $arr_new_showitem[$key + 1] = $value;
      break;
  }
}
$str_showitem                 = implode('--div--;', $arr_new_showitem);
$TCA['fe_users']['types']['0']['showitem']   = $str_showitem;
  // Insert div [references] at position $int_div_position

if($bool_wizards_wo_add_and_list)
{
  unset($TCA['fe_users']['columns']['tx_orgreferences']['config']['wizards']['add']);
  unset($TCA['fe_users']['columns']['tx_orgreferences']['config']['wizards']['list']);
}
  // fe_users

  // tx_org_cal
t3lib_div::loadTCA('tx_org_cal');

  // typeicons: Add type_icon
$TCA['tx_org_cal']['ctrl']['typeicons']['tx_org_repertoire'] =
  t3lib_extmgm::extRelPath($_EXTKEY) . 'ext_icon/references.gif';
  // typeicons: Add type_icon

  // showRecordFieldList: Add field tx_orgreferences
$showRecordFieldList = $TCA['tx_org_cal']['interface']['showRecordFieldList'];
$showRecordFieldList = $showRecordFieldList.',tx_orgreferences';
$TCA['tx_org_cal']['interface']['showRecordFieldList'] = $showRecordFieldList;
  // showRecordFieldList: Add field tx_orgreferences

  // columns: Add field tx_orgreferences
$TCA['tx_org_cal']['columns']['tx_orgreferences']                  = $arr_tx_orgreferences;
$TCA['tx_org_cal']['columns']['tx_orgreferences']['label']         =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_org_cal.tx_orgreferences';
$TCA['tx_org_cal']['columns']['tx_orgreferences']['config']['MM']  = 'tx_orgreferences_mm_tx_org_cal';
  // columns: Add field tx_orgreferences

  // columns: extend type
$TCA['tx_org_cal']['columns']['type']['config']['items']['tx_orgreferences'] = array
(
  '0' => 'LLL:EXT:orgreferences/locallang_db.xml:tx_org_cal.type.tx_orgreferences',
  '1' => 'tx_orgreferences',
  '2' => 'EXT:orgreferences/ext_icon/references.gif',
);
  // columns: extend type

  // Insert type [repertoire] with fields to TCAtypes
$TCA['tx_org_cal']['types']['tx_orgreferences']['showitem'] =
  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_calendar,
    type,title,
    --palette--;LLL:EXT:org/locallang_db.xml:palette.datetime_datetimeend;datetime_datetimeend,
    tx_org_caltype,tx_orgreferences,'.
  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_event,
    tx_org_location,tx_org_calentrance,'.
  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_department,
    tx_org_department,'.
  '--div--;LLL:EXT:org/locallang_db.xml:tx_org_cal.div_control,
    hidden;;1;;,fe_group'.
  ''
;
  // tx_org_cal

  // tx_org_headquarters
  // Load the TCA
t3lib_div::loadTCA('tx_org_headquarters');

  // Add fields to TCAshowReacordFieldList
$showRecordFieldList = $TCA['tx_org_headquarters']['interface']['showRecordFieldList'];
$showRecordFieldList = $showRecordFieldList.',tx_orgreferences_premium,tx_orgreferences';
$TCA['tx_org_headquarters']['interface']['showRecordFieldList'] = $showRecordFieldList;
  // Add fields to TCAshowReacordFieldList

  // Add fields to TCAcolumns: premium, references
t3lib_extMgm::addTCAcolumns(
  'tx_org_headquarters',
  array
  (
    'tx_orgreferences_premium' => array
    (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tx_org_headquarters.tx_orgreferences_premium',
      'config'  => array (
        'type'    => 'check',
        'default' => '0'
      )
    ),
    'tx_orgreferences' => $arr_tx_orgreferences,
  )
);
$TCA['tx_org_headquarters']['columns']['tx_orgreferences']['label']                        =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_org_headquarters.tx_orgreferences';
$TCA['tx_org_headquarters']['columns']['tx_orgreferences']['config']['MM']                 =
  'tx_orgreferences_mm_tx_org_headquarters';
$TCA['tx_org_headquarters']['columns']['tx_orgreferences']['config']['MM_opposite_field']  =
  'tx_org_headquarters';
  // Add fields to TCAcolumns: premium, references

  // Insert fields to TCAtypes, which haven't an own div
t3lib_extMgm::addToAllTCAtypes('tx_org_headquarters', 'tx_orgreferences_premium', '', 'before:mail_address');

  // Insert div [references] with fields to TCAtypes
$str_showitem     = $TCA['tx_org_headquarters']['types']['0']['showitem'];
$arr_showitem     = explode('--div--;', $str_showitem);
$int_div_position = 3;
foreach($arr_showitem as $key => $value)
{
  switch(true)
  {
    case($key < $int_div_position):
        // Don't move divs, which are placed before the new tab
      $arr_new_showitem[$key] = $value;
      break;
    case($key == $int_div_position):
        // Insert the new tab
      $arr_new_showitem[$key]     = 'LLL:EXT:orgreferences/locallang_db.xml:tx_org_headquarters.div_tx_orgreferences, tx_orgreferences,';
        // Move former tab one position behind
      $arr_new_showitem[$key + 1] = $value;
      break;
    case($key > $int_div_position):
        // Move divs, which are placed after the new tab one position behind
      $arr_new_showitem[$key + 1] = $value;
      break;
  }
}
$str_showitem                                           = implode('--div--;', $arr_new_showitem);
$TCA['tx_org_headquarters']['types']['0']['showitem']   = $str_showitem;
  // Insert div [references] with fields to TCAtypes
  // tx_org_headquarters

  // Configure third party tables



  ////////////////////////////////////////////////////////////////////////////
  //
  // TCA tables

  // orgreferences
  // orgreferences_audience
  // orgreferences_cat
  // orgreferences_course
  // orgreferences_degree
  // orgreferences_focus
  // orgreferences_riskcycle
  // orgreferences_sector
  // orgreferences_type

  // orgreferences ////////////////////////////////////////////////////////////
$TCA['tx_orgreferences'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences',
    'label'             => 'title',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
      'starttime' => 'starttime',
      'endtime'   => 'endtime',
      'fe_group'  => 'fe_group',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => true,
    'requestUpdate'     => 'static_countries',
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/references.gif',
  ),
);
  // orgreferences /////////////////////////////////////////////////////////////////////

  // orgreferences_audience ///////////////////////////////////////////////////////////////////
$TCA['tx_orgreferences_audience'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_audience',
    'label'             => 'title',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/audience.gif',
  ),
);
  // orgreferences_audience ///////////////////////////////////////////////////////////////////

  // orgreferences_cat ///////////////////////////////////////////////////////////////////
$TCA['tx_orgreferences_cat'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_cat',
    'label'             => 'title',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/cat.gif',
  ),
);
  // orgreferences_cat ///////////////////////////////////////////////////////////////////

  // orgreferences_course ///////////////////////////////////////////////////////////////////
$TCA['tx_orgreferences_course'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_course',
    'label'             => 'title',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/course.gif',
  ),
);
  // orgreferences_course ///////////////////////////////////////////////////////////////////

  // orgreferences_degree ///////////////////////////////////////////////////////////////////
$TCA['tx_orgreferences_degree'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_degree',
    'label'             => 'title',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/degree.gif',
  ),
);
  // orgreferences_degree ///////////////////////////////////////////////////////////////////

  // orgreferences_focus ///////////////////////////////////////////////////////////////////
$TCA['tx_orgreferences_focus'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_focus',
    'label'             => 'title',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/focus.gif',
  ),
);
  // orgreferences_focus ///////////////////////////////////////////////////////////////////

  // orgreferences_riskcycle ///////////////////////////////////////////////////////////////////
$TCA['tx_orgreferences_riskcycle'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_riskcycle',
    'label'             => 'title',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/riskcycle.gif',
  ),
);
  // orgreferences_riskcycle ///////////////////////////////////////////////////////////////////

  // orgreferences_sector ///////////////////////////////////////////////////////////////////
$TCA['tx_orgreferences_sector'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_sector',
    'label'             => 'title',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/sector.gif',
  ),
);
  // orgreferences_sector ///////////////////////////////////////////////////////////////////

  // orgreferences_type ///////////////////////////////////////////////////////////////////
$TCA['tx_orgreferences_type'] = array (
  'ctrl' => array (
    'title'             => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_type',
    'label'             => 'title',
    'tstamp'            => 'tstamp',
    'crdate'            => 'crdate',
    'cruser_id'         => 'cruser_id',
    'default_sortby'    => 'ORDER BY title',
    'delete'            => 'deleted',
    'enablecolumns'     => array (
      'disabled'  => 'hidden',
    ),
    'dividers2tabs'     => true,
    'hideAtCopy'        => false,
    'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
    'thumbnail'         => 'image',
    'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon/type.gif',
  ),
);
  // orgreferences_type ///////////////////////////////////////////////////////////////////


  // TCA tables //////////////////////////////////////////////////////////////

?>