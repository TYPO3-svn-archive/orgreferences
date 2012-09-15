<?php

if (!defined ('TYPO3_MODE'))
{
  die ('Access denied.');
}



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // INDEX
  // -----
  // Configuration by the extension manager
  //    Localization support
  //    Store record configuration
  // General Configuration
  // Wizard fe_users
  // Other wizards and config drafts
  // TCA
  //   tx_orgreferences
  //   tx_orgreferences_cat (master for category tables)
  //   tx_orgreferences_client
  //   tx_orgreferences_course
  //   tx_orgreferences_achievement
  //   tx_orgreferences_focus
  //   tx_orgreferences_business
  //   tx_orgreferences_sector
  //   tx_orgreferences_type



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // Configuration by the extension manager

$bool_LL = false;
$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['orgreferences']);

  // Localization support
if (strtolower(substr($confArr['LLsupport'], 0, strlen('yes'))) == 'yes')
{
  $bool_LL = true;
}
  // Localization support

  // Simplify the Organiser
$bool_exclude_none    = true;
$bool_exclude_default = true;
switch ($confArr['TCA_simplify_organiser'])
{
  case('None excluded: Editor has access to all'):
    $bool_exclude_none    = false;
    $bool_exclude_default = false;
    break;
  case('All excluded: Administrator configures it'):
      // All will be left true.
    break;
  case('Default (recommended)'):
    $bool_exclude_default = false;
  default:
}
  // Simplify the Organiser


  // Simplify backend forms
$bool_fegroup_control = true;
if (strtolower(substr($confArr['TCA_simplify_fegroup_control'], 0, strlen('no'))) == 'no')
{
  $bool_fegroup_control = false;
}
$bool_time_control = true;
if (strtolower(substr($confArr['TCA_simplify_time_control'], 0, strlen('no'))) == 'no')
{
  $bool_time_control = false;
}
  // Simplify backend forms

  // Full wizard support
$bool_full_wizardSupport_catTables = true;
if (strtolower(substr($confArr['full_wizardSupport'], 0, strlen('no'))) == 'no')
{
  $bool_full_wizardSupport_catTables = false;
}
  // Full wizard support

  // Store record configuration
$bool_wizards_wo_add_and_list = false;
$str_marker_pid               = '###CURRENT_PID###';
switch($confArr['store_records'])
{
  case('Multi grouped: record groups in different directories'):
    $str_store_record_conf        = 'pid IN (###PAGE_TSCONFIG_IDLIST###)';
    $bool_wizards_wo_add_and_list = true;
    break;
  case('Clear presented: each record group in one directory at most'):
    $str_marker_pid               = '###PAGE_TSCONFIG_ID###';
    $str_store_record_conf        = 'pid = ###PAGE_TSCONFIG_ID###';
    $bool_wizards_wo_add_and_list = true;
    break;
  case('Easy 2: same as easy 1 but with storage pid'):
    $str_marker_pid               = '###STORAGE_PID###';
    $str_store_record_conf        = 'pid=###STORAGE_PID###';
    break;
  case('Easy 1: all in the same directory'):
  default:
    $str_store_record_conf        = 'pid=###CURRENT_PID###';
}
  // Store record configuration

switch($confArr['full_wizardSupport'])
{
  case('No'):
    $bool_wizards_wo_add_and_list_for_catTables = true;
    break;
  case('Yes (recommended)'):
  default:
    $bool_wizards_wo_add_and_list_for_catTables = false;
}
  // Configuration by the extension manager



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // General Configuration

    // JSopenParams for all wizards
  $JSopenParams     = 'height=680,width=800,status=0,menubar=0,scrollbars=1';
    // Rows of fe_group select box
  $size_fegroup     = 10;
    // General Configuration



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // Wizard fe_users

    // Wizard for fe_users
  $arr_config_feuser = array(
    'type'                => 'select',
    'size'                => 30,
    'minitems'            => 0,
    'maxitems'            => 999,
    'foreign_table'       => 'fe_users',
    'foreign_table_where' => 'AND fe_users.' . $str_store_record_conf . ' ORDER BY fe_users.last_name',
    'wizards' => array(
      '_PADDING'  => 2,
      '_VERTICAL' => 0,
      'add' => array(
        'type'   => 'script',
        'title'  => 'LLL:EXT:orgreferences/locallang_db.xml:wizard.fe_user.add',
        'icon'   => 'add.gif',
        'params' => array(
          'table'    => 'fe_users',
          'pid'      => $str_marker_pid,
          'setValue' => 'prepend'
        ),
        'script' => 'wizard_add.php',
      ),
      'list' => array(
        'type'   => 'script',
        'title'  => 'LLL:EXT:orgreferences/locallang_db.xml:wizard.fe_user.list',
        'icon'   => 'list.gif',
        'params' => array(
          'table' => 'fe_users',
          'pid'   => $str_marker_pid,
        ),
        'script' => 'wizard_list.php',
      ),
      'edit' => array(
        'type'                      => 'popup',
        'title'                     => 'LLL:EXT:orgreferences/locallang_db.xml:wizard.fe_user.edit',
        'script'                    => 'wizard_edit.php',
        'popup_onlyOpenIfSelected'  => 1,
        'icon'                      => 'edit2.gif',
        'JSopenParams'              => $JSopenParams,
      ),
    ),
  );
  if($bool_wizards_wo_add_and_list)
  {
    unset($arr_config_feuser['wizards']['add']);
    unset($arr_config_feuser['wizards']['list']);
  }
    // Wizard for fe_users

    // Wizard for tx_orgreferences_cat ...
  $arr_tx_orgreferences_cat = array (
    'exclude'   => $bool_exclude_default,
    'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_orgreferences_cat',
    'config'    => array (
      'type'      => 'select',
      'size'      => 10,
      'minitems'  => 0,
      'maxitems'  => 999,
      'MM'                  => 'tx_orgreferences_mm_tx_orgreferences_cat',
      'foreign_table'       => 'tx_orgreferences_cat',
      'foreign_table_where' => 'AND tx_orgreferences_cat.' . $str_store_record_conf . ' ORDER BY tx_orgreferences_cat.title',
      'wizards' => array(
        '_PADDING'  => 2,
        '_VERTICAL' => 0,
        'add' => array(
          'type'   => 'script',
          'title'  => 'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_cat.add',
          'icon'   => 'add.gif',
          'params' => array(
            'table'    => 'tx_orgreferences_cat',
            'pid'      => $str_marker_pid,
            'setValue' => 'prepend'
          ),
          'script' => 'wizard_add.php',
        ),
        'list' => array(
          'type'   => 'script',
          'title'  => 'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_cat.list',
          'icon'   => 'list.gif',
          'params' => array(
            'table' => 'tx_orgreferences_cat',
            'pid'   => $str_marker_pid,
          ),
          'script' => 'wizard_list.php',
        ),
        'edit' => array(
          'type'                      => 'popup',
          'title'                     => 'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_cat.edit',
          'script'                    => 'wizard_edit.php',
          'popup_onlyOpenIfSelected'  => 1,
          'icon'                      => 'edit2.gif',
          'JSopenParams'              => $JSopenParams,
        ),
      ),
    ),
  );
    // Wizard for tx_orgreferences_cat ...

    // Wizard fe_users



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // Other wizards and config drafts

  $arr_wizard_url = array (
    'type'      => 'input',
    'size'      => '80',
    'max'       => '256',
    'checkbox'  => '',
    'eval'      => 'trim',
    'wizards'   => array (
      '_PADDING'  => '2',
      'link'      => array (
        'type'         => 'popup',
        'title'        => 'Link',
        'icon'         => 'link_popup.gif',
        'script'       => 'browse_links.php?mode=wizard',
        'JSopenParams' => $JSopenParams,
      ),
    ),
    'softref' => 'typolink',
  );

  $conf_file_document = array (
    'type'          => 'group',
    'internal_type' => 'file',
    'allowed'       => '',
    'disallowed'    => 'php,php3',
    'max_size'      => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
    'uploadfolder'  => 'uploads/tx_org',
    'size'          => 10,
    'minitems'      => 0,
    'maxitems'      => 99,
  );

  $conf_file_image = array (
    'type'          => 'group',
    'internal_type' => 'file',
    'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
    'max_size'      => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
    'uploadfolder'  => 'uploads/tx_org',
    'show_thumbs'   => 1,
    'size'          => 3,
    'minitems'      => 0,
    'maxitems'      => 20,
  );

  $conf_input_30_trim = array (
    'type' => 'input',
    'size' => '30',
    'eval' => 'trim'
  );

  $conf_input_30_trimRequired = array (
    'type' => 'input',
    'size' => '30',
    'eval' => 'trim,required'
  );

  $conf_input_80_trim = array (
    'type' => 'input',
    'size' => '80',
    'eval' => 'trim'
  );
  $conf_text_30_05 = array (
    'type' => 'text',
    'cols' => '30',
    'rows' => '5',
  );

  $conf_text_50_10 = array (
    'type' => 'text',
    'cols' => '50',
    'rows' => '10',
  );

  $conf_text_rte = array (
    'type' => 'text',
    'cols' => '30',
    'rows' => '5',
    'wizards' => array(
      '_PADDING' => 2,
      'RTE' => array(
        'notNewRecords' => 1,
        'RTEonly'       => 1,
        'type'          => 'script',
        'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
        'icon'          => 'wizard_rte2.gif',
        'script'        => 'wizard_rte.php',
      ),
    ),
  );

  $conf_hidden = array (
    'exclude' => $bool_exclude_default,
    'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
    'config'  => array (
      'type'    => 'check',
      'default' => '0'
    )
  );
  $conf_starttime = array (
    'exclude' => $bool_time_control,
    'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
    'config'  => array (
      'type'     => 'input',
      'size'     => '8',
      'max'      => '20',
      'eval'     => 'date',
      'default'  => '0',
      'checkbox' => '0'
    )
  );
  $conf_endtime = array (
    'exclude' => $bool_time_control,
    'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
    'config'  => array (
      'type'     => 'input',
      'size'     => '8',
      'max'      => '20',
      'eval'     => 'date',
      'checkbox' => '0',
      'default'  => '0',
      'range'    => array (
        'upper' => mktime(0, 0, 0, date('m'), date('d'), date('Y')+30),
        'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
      )
    )
  );
  $conf_fegroup = array (
    'exclude'     => $bool_fegroup_control,
    'l10n_mode'   => 'mergeIfNotBlank',
    'label'       => 'LLL:EXT:lang/locallang_general.php:LGL.fe_group',
    'config'      => array (
      'type'      => 'select',
      'size'      => $size_fegroup,
      'maxitems'  => 20,
      'items' => array (
        array('LLL:EXT:lang/locallang_general.php:LGL.hide_at_login', -1),
        array('LLL:EXT:lang/locallang_general.php:LGL.any_login', -2),
        array('LLL:EXT:lang/locallang_general.php:LGL.usergroups', '--div--')
      ),
      'exclusiveKeys' => '-1,-2',
      'foreign_table' => 'fe_groups'
    )
  );
  // Other wizards and config drafts



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // tx_orgreferences - without any localisation support



$TCA['tx_orgreferences'] = array (
  'ctrl' => $TCA['tx_orgreferences']['ctrl'],
  'interface' => array (
    'showRecordFieldList' =>  'title, uid_extern, short, text, static_languages, static_countries, static_country_zones, location, length, recurrence, value, tx_org_tax, url, rating,'.
                              'requirements,'.
                              'subject,'.
                              'tx_orgreferences_cat, tx_orgreferences_focus, tx_orgreferences_sector, tx_orgreferences_client, tx_orgreferences_achievement, tx_orgreferences_course, tx_orgreferences_business, tx_orgreferences_type,'.
                              'fe_users,tx_org_headquarters,'.
                              'tx_org_cal,tx_org_news,'.
                              'logo, logoseo, image, imagecaption, imageseo, documents,'.
                              'hidden, starttime, endtime, fe_group,'.
                              'keywords, description',
  ),
  'feInterface' => $TCA['tx_orgreferences']['feInterface'],
  'columns' => array (
    'title' => array (
      'exclude'   => 0,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.title',
      'config'    => $conf_input_30_trimRequired,
    ),
    'uid_extern'  => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.uid_extern',
      'config'    => $conf_input_30_trim,
    ),
    'short' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.short',
      'config'  => $conf_text_50_10,
    ),
    'text' => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.text',
      'config'    => $conf_text_rte,
    ),
    'static_languages' => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.static_languages',
      'config'    => array (
        'type'      => 'select',
        'size'      => 5,
        'minitems'  => 0,
        'maxitems'  => 99,
        'xx_items' => array(
          '0' => array(
            '0' => '',
          ),
        ),
        'foreign_table'       => 'static_languages',
        'foreign_table_where' => ' ORDER BY static_languages.lg_name_en',
      ),
    ),
    'static_countries' => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.static_countries',
      'config'    => array (
        'type'      => 'select',
        'size'      => 1,
        'minitems'  => 0,
        'maxitems'  => 1,
        'items' => array(
          '0' => array(
            '0' => '',
          ),
        ),
        'foreign_table'       => 'static_countries',
      ),
    ),
    'static_country_zones' => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.static_country_zones',
      'config'    => array (
        'type'    => 'select',
        'items'         => array(
          '' => '',
        ),
        'size'          => 1,
        'minitems'      => 0,
        'maxitems'      => 1,
        'foreign_table' => 'static_country_zones',
          // WORKFLOW: We don't want any iem by default
        'foreign_table_where' => 'AND 0',
          // WORKFLOW: We get all needed items by itemsProcFunc
        'itemsProcFunc' => 'tx_browser_tca->static_country_zones',
        'itemsProcFunc_conf' => array(
            // If your TCA field is not called 'static_countries', you have to configure 'countries_are_in'
          //'countries_are_in' => 'static_countries',
        ),
      ),
    ),
    'location'  => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.location',
      'config'    => $conf_input_80_trim,
    ),
    'length'  => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.length',
      'config'    => $conf_input_30_trim,
    ),
    'recurrence'  => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.recurrence',
      'config'    => $conf_input_80_trim,
    ),
    'value'  => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.value',
      'config'    => $conf_input_30_trim,
    ),
    'tx_org_tax' => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_org_tax',
      'config'    => array (
        'type'                => 'select',
        'size'                => 1,
        'minitems'            => 0,
        'maxitems'            => 1,
        'items' => array(
          '0' => array('', 0),
        ),
        'foreign_table'       => 'tx_org_tax',
        'foreign_table_where' => 'AND tx_org_tax.' . $str_store_record_conf . ' ORDER BY tx_org_tax.value',
      )
    ),
    'url' => array (
      'exclude' => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.url',
      'config' => $arr_wizard_url,
    ),
    'rating'  => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.rating',
      'config'    => $conf_input_30_trim,
    ),
    'requirements' => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.requirements',
      'config'    => $conf_text_rte,
    ),
    'subject' => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.subject',
      'config'    => $conf_text_rte,
    ),
    'tx_orgreferences_cat'       => $arr_tx_orgreferences_cat,
    'tx_orgreferences_focus'     => $arr_tx_orgreferences_cat,
    'tx_orgreferences_sector'    => $arr_tx_orgreferences_cat,
    'tx_orgreferences_client'  => $arr_tx_orgreferences_cat,
    'tx_orgreferences_achievement'    => $arr_tx_orgreferences_cat,
    'tx_orgreferences_course'    => $arr_tx_orgreferences_cat,
    'tx_orgreferences_business' => $arr_tx_orgreferences_cat,
    'tx_orgreferences_type'      => $arr_tx_orgreferences_cat,
    'fe_users' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.fe_users',
      'config'  => $arr_config_feuser,
    ),
    'tx_org_headquarters'     => $arr_tx_orgreferences_cat,
    'tx_org_cal'              => $arr_tx_orgreferences_cat,
    'tx_org_news'             => $arr_tx_orgreferences_cat,
    'logo' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.logo',
      'config'  => $conf_file_image,
    ),
    'logoseo' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.logoseo',
      'config'  => $conf_text_30_05,
    ),
    'image' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.image',
      'config'  => $conf_file_image,
    ),
    'imagecaption' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.imagecaption',
      'config'  => $conf_text_30_05,
    ),
    'imageseo' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.imageseo',
      'config'  => $conf_text_30_05,
    ),
    'documents' => array (
      'exclude' => $bool_exclude_none,
      'label' => 'LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.documents',
      'config' => $conf_file_document,
    ),
    'hidden'    => $conf_hidden,
    'starttime' => $conf_starttime,
    'endtime'   => $conf_endtime,
    'fe_group'  => $conf_fegroup,
    'keywords' => array (
      'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.keywords',
      'exclude' => $bool_exclude_default,
      'config'  => $conf_input_80_trim,
    ),
    'description' => array (
      'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.description',
      'exclude' => $bool_exclude_default,
      'config'  => $conf_text_50_10,
    ),
  ),
  'types' => array (
    '0' => array('showitem' =>  '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_references,           title, uid_extern, short, text;;;richtext[]:rte_transform[mode=ts];, static_languages, static_countries, static_country_zones, location, length, recurrence, value, tx_org_tax, url, rating,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_requirements,       requirements;;;richtext[]:rte_transform[mode=ts];,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_subject,            subject;;;richtext[]:rte_transform[mode=ts];,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_categories,         tx_orgreferences_cat, tx_orgreferences_focus, tx_orgreferences_sector, tx_orgreferences_client, tx_orgreferences_achievement, tx_orgreferences_course, tx_orgreferences_business, tx_orgreferences_type,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_user_headquarter,   fe_users,tx_org_headquarters,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_cal_news,           tx_org_cal,tx_org_news,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_media,              logo, logoseo, image, imagecaption, imageseo, documents,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_access,             hidden;;1;;,fe_group'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_seo,                keywords, description,'.
                                ''),
  ),
  'palettes' => array (
    '1' => array('showitem' => 'starttime,endtime,'),
  )
);
  // Relation fe_users
$TCA['tx_orgreferences']['columns']['fe_users']['config']['MM'] =
  'tx_orgreferences_mm_fe_users';
  // Relation fe_users

  // Relation tx_orgreferences_client
$TCA['tx_orgreferences']['columns']['tx_orgreferences_client']['label'] =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_orgreferences_client';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_client']['config']['size'] =
  5;
$TCA['tx_orgreferences']['columns']['tx_orgreferences_client']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_client';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_client']['config']['foreign_table'] =
  'tx_orgreferences_client';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_client']['config']['foreign_table_where'] =
  'AND tx_orgreferences_client.' . $str_store_record_conf . ' ORDER BY tx_orgreferences_client.title';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_client']['config']['wizards']['add']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_client.add';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_client']['config']['wizards']['add']['params']['table'] =
  'tx_orgreferences_client';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_client']['config']['wizards']['list']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_client.list';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_client']['config']['wizards']['edit']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_client.edit';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_client']['config']['wizards']['list']['params']['table'] =
  'tx_orgreferences_client';
if($bool_wizards_wo_add_and_list_for_catTables)
{
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_client']['config']['wizards']['add']);
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_client']['config']['wizards']['list']);
}
  // Relation tx_orgreferences_client

  // Relation tx_orgreferences_cat
$TCA['tx_orgreferences']['columns']['tx_orgreferences_cat']['config']['size'] =
  5;
  // Relation tx_orgreferences_cat

  // Relation tx_orgreferences_course
$TCA['tx_orgreferences']['columns']['tx_orgreferences_course']['label'] =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_orgreferences_course';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_course']['config']['size'] =
  5;
$TCA['tx_orgreferences']['columns']['tx_orgreferences_course']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_course';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_course']['config']['foreign_table'] =
  'tx_orgreferences_course';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_course']['config']['foreign_table_where'] =
  'AND tx_orgreferences_course.' . $str_store_record_conf . ' ORDER BY tx_orgreferences_course.title';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_course']['config']['wizards']['add']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_course.add';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_course']['config']['wizards']['add']['params']['table'] =
  'tx_orgreferences_course';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_course']['config']['wizards']['list']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_course.list';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_course']['config']['wizards']['edit']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_course.edit';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_course']['config']['wizards']['list']['params']['table'] =
  'tx_orgreferences_course';
if($bool_wizards_wo_add_and_list_for_catTables)
{
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_course']['config']['wizards']['add']);
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_course']['config']['wizards']['list']);
}
  // Relation tx_orgreferences_course

  // Relation tx_orgreferences_achievement
$TCA['tx_orgreferences']['columns']['tx_orgreferences_achievement']['label'] =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_orgreferences_achievement';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_achievement']['config']['size'] =
  5;
$TCA['tx_orgreferences']['columns']['tx_orgreferences_achievement']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_achievement';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_achievement']['config']['foreign_table'] =
  'tx_orgreferences_achievement';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_achievement']['config']['foreign_table_where'] =
  'AND tx_orgreferences_achievement.' . $str_store_record_conf . ' ORDER BY tx_orgreferences_achievement.title';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_achievement']['config']['wizards']['add']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_achievement.add';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_achievement']['config']['wizards']['add']['params']['table'] =
  'tx_orgreferences_achievement';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_achievement']['config']['wizards']['list']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_achievement.list';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_achievement']['config']['wizards']['edit']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_achievement.edit';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_achievement']['config']['wizards']['list']['params']['table'] =
  'tx_orgreferences_achievement';
if($bool_wizards_wo_add_and_list_for_catTables)
{
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_achievement']['config']['wizards']['add']);
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_achievement']['config']['wizards']['list']);
}
  // Relation tx_orgreferences_achievement

  // Relation tx_orgreferences_focus
$TCA['tx_orgreferences']['columns']['tx_orgreferences_focus']['label'] =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_orgreferences_focus';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_focus']['config']['size'] =
  5;
$TCA['tx_orgreferences']['columns']['tx_orgreferences_focus']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_focus';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_focus']['config']['foreign_table'] =
  'tx_orgreferences_focus';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_focus']['config']['foreign_table_where'] =
  'AND tx_orgreferences_focus.' . $str_store_record_conf . ' ORDER BY tx_orgreferences_focus.title';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_focus']['config']['wizards']['add']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_focus.add';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_focus']['config']['wizards']['add']['params']['table'] =
  'tx_orgreferences_focus';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_focus']['config']['wizards']['list']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_focus.list';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_focus']['config']['wizards']['edit']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_focus.edit';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_focus']['config']['wizards']['list']['params']['table'] =
  'tx_orgreferences_focus';
if($bool_wizards_wo_add_and_list_for_catTables)
{
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_focus']['config']['wizards']['add']);
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_focus']['config']['wizards']['list']);
}
  // Relation tx_orgreferences_focus

  // Relation tx_orgreferences_business
$TCA['tx_orgreferences']['columns']['tx_orgreferences_business']['label'] =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_orgreferences_business';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_business']['config']['size'] =
  5;
$TCA['tx_orgreferences']['columns']['tx_orgreferences_business']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_business';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_business']['config']['foreign_table'] =
  'tx_orgreferences_business';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_business']['config']['foreign_table_where'] =
  'AND tx_orgreferences_business.' . $str_store_record_conf . ' ORDER BY tx_orgreferences_business.title';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_business']['config']['wizards']['add']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_business.add';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_business']['config']['wizards']['add']['params']['table'] =
  'tx_orgreferences_business';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_business']['config']['wizards']['list']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_business.list';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_business']['config']['wizards']['edit']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_business.edit';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_business']['config']['wizards']['list']['params']['table'] =
  'tx_orgreferences_business';
if($bool_wizards_wo_add_and_list_for_catTables)
{
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_business']['config']['wizards']['add']);
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_business']['config']['wizards']['list']);
}
  // Relation tx_orgreferences_business

  // Relation tx_orgreferences_sector
$TCA['tx_orgreferences']['columns']['tx_orgreferences_sector']['label'] =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_orgreferences_sector';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_sector']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_sector';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_sector']['config']['foreign_table'] =
  'tx_orgreferences_sector';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_sector']['config']['foreign_table_where'] =
  'AND tx_orgreferences_sector.' . $str_store_record_conf . ' ORDER BY tx_orgreferences_sector.title';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_sector']['config']['wizards']['add']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_sector.add';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_sector']['config']['wizards']['add']['params']['table'] =
  'tx_orgreferences_sector';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_sector']['config']['wizards']['list']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_sector.list';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_sector']['config']['wizards']['edit']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_sector.edit';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_sector']['config']['wizards']['list']['params']['table'] =
  'tx_orgreferences_sector';
if($bool_wizards_wo_add_and_list_for_catTables)
{
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_sector']['config']['wizards']['add']);
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_sector']['config']['wizards']['list']);
}
  // Relation tx_orgreferences_sector

  // Relation tx_orgreferences_type
$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['label'] =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_orgreferences_type';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['size'] =
  1;
$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['items'][] =
  array('', 0);
$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['minitems'] =
  1;
//$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['maxitems'] =
//  1;
$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_type';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['foreign_table'] =
  'tx_orgreferences_type';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['foreign_table_where'] =
  'AND tx_orgreferences_type.' . $str_store_record_conf . ' ORDER BY tx_orgreferences_type.title';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['wizards']['add']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_type.add';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['wizards']['add']['params']['table'] =
  'tx_orgreferences_type';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['wizards']['list']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_type.list';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['wizards']['edit']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_type.edit';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['wizards']['list']['params']['table'] =
  'tx_orgreferences_type';
if($bool_wizards_wo_add_and_list_for_catTables)
{
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['wizards']['add']);
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_type']['config']['wizards']['list']);
}
  // Relation tx_orgreferences_type

  // Relation tx_org_cal
$TCA['tx_orgreferences']['columns']['tx_org_cal']['label'] =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_org_cal';
$TCA['tx_orgreferences']['columns']['tx_org_cal']['config']['MM'] =
  'tx_orgreferences_mm_tx_org_cal';
$TCA['tx_orgreferences']['columns']['tx_org_cal']['config']['foreign_table'] =
  'tx_org_cal';
$TCA['tx_orgreferences']['columns']['tx_org_cal']['config']['foreign_table_where'] =
  'AND tx_org_cal.' . $str_store_record_conf . ' ORDER BY tx_org_cal.datetime DESC, tx_org_cal.title';
$TCA['tx_orgreferences']['columns']['tx_org_cal']['config']['wizards']['add']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_org_cal.add';
$TCA['tx_orgreferences']['columns']['tx_org_cal']['config']['wizards']['add']['params']['table'] =
  'tx_org_cal';
$TCA['tx_orgreferences']['columns']['tx_org_cal']['config']['wizards']['list']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_org_cal.list';
$TCA['tx_orgreferences']['columns']['tx_org_cal']['config']['wizards']['edit']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_org_cal.edit';
$TCA['tx_orgreferences']['columns']['tx_org_cal']['config']['wizards']['list']['params']['table'] =
  'tx_org_cal';
if($bool_wizards_wo_add_and_list)
{
  unset($TCA['tx_orgreferences']['columns']['tx_org_cal']['config']['wizards']['add']);
  unset($TCA['tx_orgreferences']['columns']['tx_org_cal']['config']['wizards']['list']);
}
  // Relation tx_org_cal

  // Relation tx_org_headquarters
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['label'] =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_org_headquarters';
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['eval'] =
  'required';
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['size'] =
  1;
//$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['items'][] =
//  array('', 0);
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['maxitems'] =
  10;
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['minitems'] =
  1;
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['MM'] =
  'tx_orgreferences_mm_tx_org_headquarters';
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['foreign_table'] =
  'tx_org_headquarters';
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['foreign_table_where'] =
  'AND tx_org_headquarters.' . $str_store_record_conf . ' ORDER BY tx_org_headquarters.title';
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['wizards']['add']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_org_headquarters.add';
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['wizards']['add']['params']['table'] =
  'tx_org_headquarters';
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['wizards']['list']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_org_headquarters.list';
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['wizards']['edit']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_org_headquarters.edit';
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['wizards']['list']['params']['table'] =
  'tx_org_headquarters';
if($bool_wizards_wo_add_and_list)
{
  unset($TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['wizards']['add']);
  unset($TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['wizards']['list']);
}
  // Relation tx_org_headquarters

  // Relation tx_org_news
$TCA['tx_orgreferences']['columns']['tx_org_news']['label'] =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_org_news';
$TCA['tx_orgreferences']['columns']['tx_org_news']['config']['MM'] =
  'tx_orgreferences_mm_tx_org_news';
$TCA['tx_orgreferences']['columns']['tx_org_news']['config']['foreign_table'] =
  'tx_org_news';
$TCA['tx_orgreferences']['columns']['tx_org_news']['config']['foreign_table_where'] =
  'AND tx_org_news.' . $str_store_record_conf . ' ORDER BY tx_org_news.datetime DESC, tx_org_news.title';
$TCA['tx_orgreferences']['columns']['tx_org_news']['config']['wizards']['add']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_org_news.add';
$TCA['tx_orgreferences']['columns']['tx_org_news']['config']['wizards']['add']['params']['table'] =
  'tx_org_news';
$TCA['tx_orgreferences']['columns']['tx_org_news']['config']['wizards']['list']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_org_news.list';
$TCA['tx_orgreferences']['columns']['tx_org_news']['config']['wizards']['edit']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_org_news.edit';
$TCA['tx_orgreferences']['columns']['tx_org_news']['config']['wizards']['list']['params']['table'] =
  'tx_org_news';
if($bool_wizards_wo_add_and_list)
{
  unset($TCA['tx_orgreferences']['columns']['tx_org_news']['config']['wizards']['add']);
  unset($TCA['tx_orgreferences']['columns']['tx_org_news']['config']['wizards']['list']);
}
  // Relation tx_org_news


  // tx_orgreferences - without any localisation support



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // tx_orgreferences_cat (master for category tables)

$TCA['tx_orgreferences_cat'] = array (
  'ctrl' => $TCA['tx_orgreferences_cat']['ctrl'],
  'interface' => array (
    'showRecordFieldList' =>  'title,tx_orgreferences,'.
                              'hidden'
  ),
  'feInterface' => $TCA['tx_orgreferences_cat']['feInterface'],
  'columns' => array (
    'title' => array (
      'exclude' => 0,
      'label' => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_cat.title',
      'config'  => $conf_input_30_trimRequired,
    ),
    'tx_orgreferences' => $arr_tx_orgreferences_cat,
    'hidden'          => $conf_hidden,
  ),
  'types' => array (
    '0' => array('showitem' =>  '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_cat.div_cat,     title,tx_orgreferences,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_cat.div_access,  hidden'.
                                ''),
  ),
);

  // Relation tx_orgreferences
$TCA['tx_orgreferences_cat']['columns']['tx_orgreferences']['label'] =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_cat.tx_orgreferences';
$TCA['tx_orgreferences_cat']['columns']['tx_orgreferences']['config']['maxitems'] = 999;
unset($TCA['tx_orgreferences_cat']['columns']['tx_orgreferences']['config']['items']);
$TCA['tx_orgreferences_cat']['columns']['tx_orgreferences']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_cat';
$TCA['tx_orgreferences_cat']['columns']['tx_orgreferences']['config']['MM_opposite_field'] =
  'tx_orgreferences_cat';
$TCA['tx_orgreferences_cat']['columns']['tx_orgreferences']['config']['foreign_table'] =
  'tx_orgreferences';
$TCA['tx_orgreferences_cat']['columns']['tx_orgreferences']['config']['foreign_table_where'] =
  'AND tx_orgreferences.' . $str_store_record_conf . ' ORDER BY tx_orgreferences.title';
$TCA['tx_orgreferences_cat']['columns']['tx_orgreferences']['config']['wizards']['add']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences.add';
$TCA['tx_orgreferences_cat']['columns']['tx_orgreferences']['config']['wizards']['add']['params']['table'] =
  'tx_orgreferences';
$TCA['tx_orgreferences_cat']['columns']['tx_orgreferences']['config']['wizards']['list']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences.list';
$TCA['tx_orgreferences_cat']['columns']['tx_orgreferences']['config']['wizards']['edit']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences.edit';
$TCA['tx_orgreferences_cat']['columns']['tx_orgreferences']['config']['wizards']['list']['params']['table'] =
  'tx_orgreferences';
  // Relation tx_orgreferences
  // tx_orgreferences_cat (master for category tables)



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // tx_orgreferences_client

$TCA['tx_orgreferences_client'] = array (
  'ctrl' => $TCA['tx_orgreferences_client']['ctrl'],
  'interface' => array (
    'showRecordFieldList' =>  'title,tx_orgreferences,'.
                              'hidden'
  ),
  'feInterface' => $TCA['tx_orgreferences_client']['feInterface'],
  'columns' => array (
    'title' => array (
      'exclude' => 0,
      'label' => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_client.title',
      'config'  => $conf_input_30_trimRequired,
    ),
    'tx_orgreferences' => $TCA['tx_orgreferences_cat']['columns']['tx_orgreferences'],
    'hidden'          => $conf_hidden,
  ),
  'types' => array (
    '0' => array('showitem' =>  '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_client.div_client,   title,tx_orgreferences,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_client.div_access,   hidden'.
                                ''),
  ),
);

  // Relation tx_orgreferences
$TCA['tx_orgreferences_client']['columns']['tx_orgreferences']['config']['maxitems'] = 999;
unset($TCA['tx_orgreferences_degeree']['columns']['tx_orgreferences']['config']['items']);
$TCA['tx_orgreferences_client']['columns']['tx_orgreferences']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_client';
$TCA['tx_orgreferences_client']['columns']['tx_orgreferences']['config']['MM_opposite_field'] =
  'tx_orgreferences_client';
  // Relation tx_orgreferences
  // tx_orgreferences_client



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // tx_orgreferences_course

$TCA['tx_orgreferences_course'] = array (
  'ctrl' => $TCA['tx_orgreferences_course']['ctrl'],
  'interface' => array (
    'showRecordFieldList' =>  'title,tx_orgreferences,'.
                              'hidden'
  ),
  'feInterface' => $TCA['tx_orgreferences_course']['feInterface'],
  'columns' => array (
    'title' => array (
      'exclude' => 0,
      'label' => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_course.title',
      'config'  => $conf_input_30_trimRequired,
    ),
    'tx_orgreferences' => $TCA['tx_orgreferences_cat']['columns']['tx_orgreferences'],
    'hidden'          => $conf_hidden,
  ),
  'types' => array (
    '0' => array('showitem' =>  '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_course.div_course,   title,tx_orgreferences,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_course.div_access,   hidden'.
                                ''),
  ),
);

  // Relation tx_orgreferences
$TCA['tx_orgreferences_course']['columns']['tx_orgreferences']['config']['maxitems'] = 999;
unset($TCA['tx_orgreferences_degeree']['columns']['tx_orgreferences']['config']['items']);
$TCA['tx_orgreferences_course']['columns']['tx_orgreferences']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_course';
$TCA['tx_orgreferences_course']['columns']['tx_orgreferences']['config']['MM_opposite_field'] =
  'tx_orgreferences_course';
  // Relation tx_orgreferences
  // tx_orgreferences_course



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // tx_orgreferences_achievement

$TCA['tx_orgreferences_achievement'] = array (
  'ctrl' => $TCA['tx_orgreferences_achievement']['ctrl'],
  'interface' => array (
    'showRecordFieldList' =>  'title,tx_orgreferences,'.
                              'hidden'
  ),
  'feInterface' => $TCA['tx_orgreferences_achievement']['feInterface'],
  'columns' => array (
    'title' => array (
      'exclude' => 0,
      'label' => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_achievement.title',
      'config'  => $conf_input_30_trimRequired,
    ),
    'tx_orgreferences' => $TCA['tx_orgreferences_cat']['columns']['tx_orgreferences'],
    'hidden'          => $conf_hidden,
  ),
  'types' => array (
    '0' => array('showitem' =>  '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_achievement.div_achievement,   title,tx_orgreferences,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_achievement.div_access,   hidden'.
                                ''),
  ),
);

  // Relation tx_orgreferences
$TCA['tx_orgreferences_achievement']['columns']['tx_orgreferences']['config']['maxitems'] = 999;
unset($TCA['tx_orgreferences_degeree']['columns']['tx_orgreferences']['config']['items']);
$TCA['tx_orgreferences_achievement']['columns']['tx_orgreferences']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_achievement';
$TCA['tx_orgreferences_achievement']['columns']['tx_orgreferences']['config']['MM_opposite_field'] =
  'tx_orgreferences_achievement';
  // Relation tx_orgreferences
  // tx_orgreferences_achievement



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // tx_orgreferences_focus

$TCA['tx_orgreferences_focus'] = array (
  'ctrl' => $TCA['tx_orgreferences_focus']['ctrl'],
  'interface' => array (
    'showRecordFieldList' =>  'title,tx_orgreferences,'.
                              'hidden'
  ),
  'feInterface' => $TCA['tx_orgreferences_focus']['feInterface'],
  'columns' => array (
    'title' => array (
      'exclude' => 0,
      'label' => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_focus.title',
      'config'  => $conf_input_30_trimRequired,
    ),
    'tx_orgreferences' => $TCA['tx_orgreferences_cat']['columns']['tx_orgreferences'],
    'hidden'          => $conf_hidden,
  ),
  'types' => array (
    '0' => array('showitem' =>  '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_focus.div_focus,   title,tx_orgreferences,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_focus.div_access,   hidden'.
                                ''),
  ),
);

  // Relation tx_orgreferences
$TCA['tx_orgreferences_focus']['columns']['tx_orgreferences']['config']['maxitems'] = 999;
unset($TCA['tx_orgreferences_degeree']['columns']['tx_orgreferences']['config']['items']);
$TCA['tx_orgreferences_focus']['columns']['tx_orgreferences']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_focus';
$TCA['tx_orgreferences_focus']['columns']['tx_orgreferences']['config']['MM_opposite_field'] =
  'tx_orgreferences_focus';
  // Relation tx_orgreferences
  // tx_orgreferences_focus



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // tx_orgreferences_business

$TCA['tx_orgreferences_business'] = array (
  'ctrl' => $TCA['tx_orgreferences_business']['ctrl'],
  'interface' => array (
    'showRecordFieldList' =>  'title,tx_orgreferences,'.
                              'hidden'
  ),
  'feInterface' => $TCA['tx_orgreferences_business']['feInterface'],
  'columns' => array (
    'title' => array (
      'exclude' => 0,
      'label' => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_business.title',
      'config'  => $conf_input_30_trimRequired,
    ),
    'tx_orgreferences' => $TCA['tx_orgreferences_cat']['columns']['tx_orgreferences'],
    'hidden'          => $conf_hidden,
  ),
  'types' => array (
    '0' => array('showitem' =>  '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_business.div_business,   title,tx_orgreferences,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_business.div_access,   hidden'.
                                ''),
  ),
);

  // Relation tx_orgreferences
$TCA['tx_orgreferences_business']['columns']['tx_orgreferences']['config']['maxitems'] = 999;
unset($TCA['tx_orgreferences_degeree']['columns']['tx_orgreferences']['config']['items']);
$TCA['tx_orgreferences_business']['columns']['tx_orgreferences']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_business';
$TCA['tx_orgreferences_business']['columns']['tx_orgreferences']['config']['MM_opposite_field'] =
  'tx_orgreferences_business';
  // Relation tx_orgreferences
  // tx_orgreferences_business



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // tx_orgreferences_sector

$TCA['tx_orgreferences_sector'] = array (
  'ctrl' => $TCA['tx_orgreferences_sector']['ctrl'],
  'interface' => array (
    'showRecordFieldList' =>  'title,tx_orgreferences,'.
                              'hidden'
  ),
  'feInterface' => $TCA['tx_orgreferences_sector']['feInterface'],
  'columns' => array (
    'title' => array (
      'exclude' => 0,
      'label' => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_sector.title',
      'config'  => $conf_input_30_trimRequired,
    ),
    'tx_orgreferences' => $TCA['tx_orgreferences_cat']['columns']['tx_orgreferences'],
    'hidden'          => $conf_hidden,
  ),
  'types' => array (
    '0' => array('showitem' =>  '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_sector.div_sector,  title,tx_orgreferences,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_sector.div_access,        hidden'.
                                ''),
  ),
);

  // Relation tx_orgreferences
$TCA['tx_orgreferences_sector']['columns']['tx_orgreferences']['config']['maxitems'] = 999;
unset($TCA['tx_orgreferences_sector']['columns']['tx_orgreferences']['config']['items']);
$TCA['tx_orgreferences_sector']['columns']['tx_orgreferences']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_sector';
$TCA['tx_orgreferences_sector']['columns']['tx_orgreferences']['config']['MM_opposite_field'] =
  'tx_orgreferences_sector';
  // Relation tx_orgreferences
  // tx_orgreferences_sector



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // tx_orgreferences_type

$TCA['tx_orgreferences_type'] = array (
  'ctrl' => $TCA['tx_orgreferences_type']['ctrl'],
  'interface' => array (
    'showRecordFieldList' =>  'title,tx_orgreferences,'.
                              'hidden'
  ),
  'feInterface' => $TCA['tx_orgreferences_type']['feInterface'],
  'columns' => array (
    'title' => array (
      'exclude' => 0,
      'label' => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_type.title',
      'config'  => $conf_input_30_trimRequired,
    ),
    'tx_orgreferences' => $TCA['tx_orgreferences_cat']['columns']['tx_orgreferences'],
    'hidden'          => $conf_hidden,
  ),
  'types' => array (
    '0' => array('showitem' =>  '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_type.div_type,     title,tx_orgreferences,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_type.div_access,   hidden'.
                                ''),
  ),
);

  // Relation tx_orgreferences
$TCA['tx_orgreferences_type']['columns']['tx_orgreferences']['config']['maxitems'] = 999;
unset($TCA['tx_orgreferences_type']['columns']['tx_orgreferences']['config']['items']);
$TCA['tx_orgreferences_type']['columns']['tx_orgreferences']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_type';
$TCA['tx_orgreferences_type']['columns']['tx_orgreferences']['config']['MM_opposite_field'] =
  'tx_orgreferences_type';
  // Relation tx_orgreferences
  // tx_orgreferences_type



?>