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
  //   tx_orgreferences_achievement
  //   tx_orgreferences_business
  //   tx_orgreferences_client
  //   tx_orgreferences_sector
  //   tx_orgreferences_tool



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


  $conf_datetime = array (
    'type'    => 'input',
    'size'    => '10',
    'max'     => '20',
    'eval'    => 'datetime',
    'default' => mktime(date('H'),date('i'),0,date('m'),date('d'),date('Y')),
  );
  
  $conf_file_document = array (
    'type'          => 'group',
    'internal_type' => 'file',
    'allowed'       => '',
    'disallowed'    => 'php,php3',
    'max_size'      => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
    'uploadfolder'  => 'uploads/tx_orgreferences',
    'size'          => 10,
    'minitems'      => 0,
    'maxitems'      => 99,
  );

  $conf_file_image = array (
    'type'          => 'group',
    'internal_type' => 'file',
    'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
    'max_size'      => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
    'uploadfolder'  => 'uploads/tx_orgreferences',
    'show_thumbs'   => 1,
    'size'          => 3,
    'minitems'      => 0,
    'maxitems'      => 20,
  );

//  $conf_input_30_trim = array (
//    'type' => 'input',
//    'size' => '30',
//    'eval' => 'trim'
//  );

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
    'showRecordFieldList' =>  'title, short, text, datetime, static_countries, static_country_zones, location, longitude, latitude, staff, url,' .
                              'tx_orgreferences_sector, tx_orgreferences_client, tx_orgreferences_achievement, tx_orgreferences_business, tx_orgreferences_tool,' .
                              'fe_users,tx_org_headquarters,' .
                              'tx_org_cal,tx_org_news,' .
                              'logo, logoseo, image,imagecaption,imageseo,imagewidth,imageheight,imageorient,imagecaption,imagecols,imageborder,imagecaption_position,image_link,image_zoom,image_noRows,image_effects,image_compression, headerseo, documents,' .
                              'hidden, starttime, endtime, fe_group,' .
                              'keywords, description',
  ),
  'feInterface' => $TCA['tx_orgreferences']['feInterface'],
  'columns' => array (
    'title' => array (
      'exclude'   => 0,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.title',
      'config'    => $conf_input_30_trimRequired,
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
    'datetime' => array (
      'exclude'   => $bool_exclude_default,
      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.datetime',
      'config'    => $conf_datetime,
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
    'longitude'  => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.longitude',
      'config'    => $conf_input_80_trim,
    ),
    'latitude'  => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.latitude',
      'config'    => $conf_input_80_trim,
    ),
    'staff'  => array (
      'exclude'   => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.staff',
      'config'    => array (
        'type'  => 'input',
        'size'  => '5',
        'max'   => '5',
        'default' => '1',
        'eval'  => 'trim,int',
        'range' => array(
          'lower' => 1,
          'upper' => 99999
        ),
      ),
    ),
    'url' => array (
      'exclude' => $bool_exclude_default,
      'label'     => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.url',
      'config' => $arr_wizard_url,
    ),
    'tx_orgreferences_sector'       => $arr_tx_orgreferences_cat,
    'tx_orgreferences_client'       => $arr_tx_orgreferences_cat,
    'tx_orgreferences_achievement'  => $arr_tx_orgreferences_cat,
    'tx_orgreferences_business'     => $arr_tx_orgreferences_cat,
    'tx_orgreferences_tool'         => $arr_tx_orgreferences_cat,
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
      'exclude'   => $bool_exclude_default,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:org/locallang_db.xml:tca_phrase.image',
      'config'    => $conf_file_image,
    ),
    'imagecaption' => array (
      'exclude'   => $bool_exclude_default,
      'l10n_mode' => 'prefixLangTitle',
      'label'     => 'LLL:EXT:org/locallang_db.xml:tca_phrase.imagecaption',
      'config'    => $conf_text_30_05,
    ),
    'imagecaption_position' => array (
      'exclude'   => $bool_exclude_none,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:cms/locallang_ttc.xml:imagecaption_position',
      'config'    => array (
        'type' => 'select',
        'items' => array (
          array ('', ''),
          array ('LLL:EXT:cms/locallang_ttc.xml:imagecaption_position.I.1', 'center'),
          array ('LLL:EXT:cms/locallang_ttc.xml:imagecaption_position.I.2', 'right'),
          array ('LLL:EXT:cms/locallang_ttc.xml:imagecaption_position.I.3', 'left'),
        ),
        'default' => ''
      ),
    ),
    'imageseo' => array (
      'exclude'   => $bool_exclude_default,
      'l10n_mode' => 'prefixLangTitle',
      'label'     => 'LLL:EXT:org/locallang_db.xml:tca_phrase.imageseo',
      'config'    => $conf_text_30_05,
    ),
    'imagewidth' => array (
      'exclude'   => $bool_exclude_default,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:cms/locallang_ttc.xml:imagewidth',
      'config'    => array (
        'type'      => 'input',
        'size'      => '10',
        'max'       => '10',
        'eval'      => 'trim',
        'checkbox'  => '0',
        'default'   => ''
      ),
    ),
    'imageheight' => array (
      'exclude'   => $bool_exclude_default,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:cms/locallang_ttc.xml:imageheight',
      'config'    => array (
        'type'      => 'input',
        'size'      => '10',
        'max'       => '10',
        'eval'      => 'trim',
        'checkbox'  => '0',
        'default'   => ''
      ),
    ),
    'imageorient' => array (
      'exclude'   => $bool_exclude_default,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:cms/locallang_ttc.xml:imageorient',
      'config'    => array (
        'type'  => 'select',
        'items' => array (
          array ('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.0', 0, 'selicons/above_center.gif'),
          array ('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.1', 1, 'selicons/above_right.gif'),
          array ('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.2', 2, 'selicons/above_left.gif'),
          array ('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.3', 8, 'selicons/below_center.gif'),
          array ('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.4', 9, 'selicons/below_right.gif'),
          array ('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.5', 10, 'selicons/below_left.gif'),
          array ('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.6', 17, 'selicons/intext_right.gif'),
          array ('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.7', 18, 'selicons/intext_left.gif'),
          array ('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.8', '--div--'),
          array ('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.9', 25, 'selicons/intext_right_nowrap.gif'),
          array ('LLL:EXT:cms/locallang_ttc.xml:imageorient.I.10', 26, 'selicons/intext_left_nowrap.gif'),
        ),
        'selicon_cols'      => 6,
        'default'           => '0',
        'iconsInOptionTags' => 1,
      ),
    ),
    'imageborder' => array (
      'exclude'   => $bool_exclude_none,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:cms/locallang_ttc.xml:imageborder',
      'config' => array (
        'type' => 'check'
      ),
    ),
    'image_noRows' => array (
      'exclude'   => $bool_exclude_none,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:cms/locallang_ttc.xml:image_noRows',
      'config'    => array (
        'type' => 'check'
      ),
    ),
    'image_link' => array (
      'exclude'   => $bool_exclude_default,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:cms/locallang_ttc.xml:image_link',
      'config'    => array (
        'type' => 'text',
        'cols' => '30',
        'rows' => '3',
        'wizards' => array (
          '_PADDING' => 2,
          'link' => array (
            'type' => 'popup',
            'title' => 'Link',
            'icon' => 'link_popup.gif',
            'script' => 'browse_links.php?mode=wizard',
            'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
          ),
        ),
        'softref' => 'typolink[linkList]'
      ),
    ),
    'image_zoom' => array (
      'exclude'   => $bool_exclude_default,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:cms/locallang_ttc.xml:image_zoom',
      'config'    => array (
        'type' => 'check'
      ),
    ),
    'image_effects' => array (
      'exclude'   => $bool_exclude_default,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:cms/locallang_ttc.xml:image_effects',
      'config'    => array (
        'type' => 'select',
        'items' => array (
          array ('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.0', 0),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.1', 1),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.2', 2),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.3', 3),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.4', 10),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.5', 11),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.6', 20),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.7', 23),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.8', 25),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_effects.I.9', 26),
        ),
      ),
    ),
    'image_frames' => array (
      'exclude'   => $bool_exclude_none,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:cms/locallang_ttc.xml:image_frames',
      'config'    => array (
        'type'  => 'select',
        'items' => array (
          array ('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.0', 0),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.1', 1),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.2', 2),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.3', 3),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.4', 4),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.5', 5),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.6', 6),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.7', 7),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_frames.I.8', 8),
        ),
      ),
    ),
    'image_compression' => array (
      'exclude'   => $bool_exclude_none,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:cms/locallang_ttc.xml:image_compression',
      'config'    => array (
        'type'  => 'select',
        'items' => array (
          array ('LLL:EXT:lang/locallang_general.php:LGL.default_value', 0),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_compression.I.1', 1),
          array ('GIF/256', 10),
          array ('GIF/128', 11),
          array ('GIF/64', 12),
          array ('GIF/32', 13),
          array ('GIF/16', 14),
          array ('GIF/8', 15),
          array ('PNG', 39),
          array ('PNG/256', 30),
          array ('PNG/128', 31),
          array ('PNG/64', 32),
          array ('PNG/32', 33),
          array ('PNG/16', 34),
          array ('PNG/8', 35),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_compression.I.15', 21),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_compression.I.16', 22),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_compression.I.17', 24),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_compression.I.18', 26),
          array ('LLL:EXT:cms/locallang_ttc.xml:image_compression.I.19', 28),
        ),
      ),
    ),
    'imagecols' => array (
      'exclude'   => $bool_exclude_default,
//      'l10n_mode' => 'exclude',
      'label'     => 'LLL:EXT:cms/locallang_ttc.xml:imagecols',
      'config'    => array (
        'type'  => 'select',
        'items' => array (
          array ('1', 1),
          array ('2', 2),
          array ('3', 3),
          array ('4', 4),
          array ('5', 5),
          array ('6', 6),
          array ('7', 7),
          array ('8', 8),
        ),
        'default' => 1
      ),
    ),
    'header' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.header',
      'config'  => $conf_file_image,
    ),
    'headerseo' => array (
      'exclude' => $bool_exclude_default,
      'label'   => 'LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.headerseo',
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
    '0' => array('showitem' =>  
      '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_references,         title, uid_extern, short, text;;;richtext[]:rte_transform[mode=ts];, datetime, static_countries, static_country_zones, location, longitude, latitude, staff, url,'.
      '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_categories,         tx_orgreferences_sector, tx_orgreferences_client, tx_orgreferences_achievement, tx_orgreferences_business, tx_orgreferences_tool,'.
      '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_logoAndHeader, ' .
        '--palette--;LLL:EXT:orgreferences/locallang_db.xml:palette.logofiles;logofiles,' .
        '--palette--;LLL:EXT:orgreferences/locallang_db.xml:palette.headerfiles;headerfiles,' .
        'documents, ' .
      '--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.images,' .
        '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.imagefiles;imagefiles,' .
        '--palette--;LLL:EXT:org/locallang_db.xml:palette.image_accessibility;image_accessibility,' .
        '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.imageblock;imageblock,' .
        '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.imagelinks;imagelinks,' .
        '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.image_settings;image_settings,' .
      '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_user_headquarter,   fe_users,tx_org_headquarters,'.
      '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_cal_news,           tx_org_cal,tx_org_news,'.
      '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_access,             hidden;;1;;,fe_group'.
      '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.div_seo,                keywords, description,'.
    ''),
  ),
  'palettes' => array (
    '1' => array('showitem' => 'starttime,endtime,'),
    'headerfiles' => array (
      'showitem' => 'header;LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.header, headerseo;LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.headerseo,',
      'canNotCollapse' => 1,
    ),
    'image_accessibility' => array (
      'showitem' => 'imageseo;LLL:EXT:org/locallang_db.xml:tca_phrase.imageseo,',
      'canNotCollapse' => 1,
    ),
    'imageblock' => array (
      'showitem' => 'imageorient;LLL:EXT:cms/locallang_ttc.xml:imageorient_formlabel, imagecols;LLL:EXT:cms/locallang_ttc.xml:imagecols_formlabel, --linebreak--,' .
                    'image_noRows;LLL:EXT:cms/locallang_ttc.xml:image_noRows_formlabel, imagecaption_position;LLL:EXT:cms/locallang_ttc.xml:imagecaption_position_formlabel',
      'canNotCollapse' => 1,
    ),
    'imagefiles' => array (
      'showitem' => 'image;LLL:EXT:cms/locallang_ttc.xml:image_formlabel, imagecaption;LLL:EXT:cms/locallang_ttc.xml:imagecaption_formlabel,',
      'canNotCollapse' => 1,
    ),
    'imagelinks' => array (
      'showitem' => 'image_zoom;LLL:EXT:cms/locallang_ttc.xml:image_zoom_formlabel, image_link;LLL:EXT:cms/locallang_ttc.xml:image_link_formlabel',
      'canNotCollapse' => 1,
    ),
    'image_settings' => array (
      'showitem' => 'imagewidth;LLL:EXT:cms/locallang_ttc.xml:imagewidth_formlabel, imageheight;LLL:EXT:cms/locallang_ttc.xml:imageheight_formlabel, imageborder;LLL:EXT:cms/locallang_ttc.xml:imageborder_formlabel, --linebreak--,' .
                    'image_compression;LLL:EXT:cms/locallang_ttc.xml:image_compression_formlabel, image_effects;LLL:EXT:cms/locallang_ttc.xml:image_effects_formlabel, image_frames;LLL:EXT:cms/locallang_ttc.xml:image_frames_formlabel',
      'canNotCollapse' => 1,
    ),
    'logofiles' => array (
      'showitem' => 'logo;LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.logo, logoseo;LLL:EXT:orgreferences/locallang_db.xml:tca_phrase.logoseo,',
      'canNotCollapse' => 1,
    ),
  )
);
  // Relation fe_users
$TCA['tx_orgreferences']['columns']['fe_users']['config']['MM'] =
  'tx_orgreferences_mm_fe_users';
  // Relation fe_users

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

  // Relation tx_orgreferences_tool
$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['label'] =
  'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences.tx_orgreferences_tool';
//$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['size'] =
//  1;
//$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['items'][] =
//  array('', 0);
//$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['minitems'] =
//  1;
////$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['maxitems'] =
////  1;
$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_tool';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['foreign_table'] =
  'tx_orgreferences_tool';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['foreign_table_where'] =
  'AND tx_orgreferences_tool.' . $str_store_record_conf . ' ORDER BY tx_orgreferences_tool.title';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['wizards']['add']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_tool.add';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['wizards']['add']['params']['table'] =
  'tx_orgreferences_tool';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['wizards']['list']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_tool.list';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['wizards']['edit']['title'] =
  'LLL:EXT:orgreferences/locallang_db.xml:wizard.tx_orgreferences_tool.edit';
$TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['wizards']['list']['params']['table'] =
  'tx_orgreferences_tool';
if($bool_wizards_wo_add_and_list_for_catTables)
{
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['wizards']['add']);
  unset($TCA['tx_orgreferences']['columns']['tx_orgreferences_tool']['config']['wizards']['list']);
}
  // Relation tx_orgreferences_tool

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
//$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['eval'] =
//  'required';
//$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['size'] =
//  1;
////$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['items'][] =
////  array('', 0);
//$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['maxitems'] =
//  10;
$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['maxitems'] =
  1;
//$TCA['tx_orgreferences']['columns']['tx_org_headquarters']['config']['minitems'] =
//  1;
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
  // tx_orgreferences_tool

$TCA['tx_orgreferences_tool'] = array (
  'ctrl' => $TCA['tx_orgreferences_tool']['ctrl'],
  'interface' => array (
    'showRecordFieldList' =>  'title,tx_orgreferences,'.
                              'hidden'
  ),
  'feInterface' => $TCA['tx_orgreferences_tool']['feInterface'],
  'columns' => array (
    'title' => array (
      'exclude' => 0,
      'label' => 'LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_tool.title',
      'config'  => $conf_input_30_trimRequired,
    ),
    'tx_orgreferences' => $TCA['tx_orgreferences_cat']['columns']['tx_orgreferences'],
    'hidden'          => $conf_hidden,
  ),
  'types' => array (
    '0' => array('showitem' =>  '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_tool.div_tool,     title,tx_orgreferences,'.
                                '--div--;LLL:EXT:orgreferences/locallang_db.xml:tx_orgreferences_tool.div_access,   hidden'.
                                ''),
  ),
);

  // Relation tx_orgreferences
$TCA['tx_orgreferences_tool']['columns']['tx_orgreferences']['config']['maxitems'] = 999;
unset($TCA['tx_orgreferences_tool']['columns']['tx_orgreferences']['config']['items']);
$TCA['tx_orgreferences_tool']['columns']['tx_orgreferences']['config']['MM'] =
  'tx_orgreferences_mm_tx_orgreferences_tool';
$TCA['tx_orgreferences_tool']['columns']['tx_orgreferences']['config']['MM_opposite_field'] =
  'tx_orgreferences_tool';
  // Relation tx_orgreferences
  // tx_orgreferences_tool



?>