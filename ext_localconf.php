<?php

if (!defined ('TYPO3_MODE'))
{
  die ('Access denied.');
}

if (file_exists(t3lib_extMgm::extPath('browser').'lib/class.tx_browser_tca.php'))
{
  require_once(t3lib_extMgm::extPath('browser').'lib/class.tx_browser_tca.php');
}

?>
