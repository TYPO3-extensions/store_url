<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['DANNYM\\StoreUrl\\Task\\StoreTask'] = array(
	'extension'        => $_EXTKEY,
	'title'            => 'URL abspeichern',
	'description'      => 'Dieser Task speichert eine gegebene URL in ein HTML Content Element ab.',
	'additionalFields' => 'DANNYM\\StoreUrl\\Task\\StoreTaskAdditionalFieldProvider'
);
?>
