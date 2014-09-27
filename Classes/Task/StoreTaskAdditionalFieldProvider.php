<?php
namespace DANNYM\StoreUrl\Task;

class StoreTaskAdditionalFieldProvider implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface {
	public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject) {
		$additionalFields = array();

        // URL to download
		if (empty($taskInfo['url'])) {
			if ($parentObject->CMD == 'edit') {
				$taskInfo['url'] = $task->url;
			} else {
				$taskInfo['url'] = '';
			}
		}
		$fieldID = 'task_url';
		$fieldCode = '<input type="text" name="tx_scheduler[url]" id="' . $fieldID . '" value="' . htmlspecialchars($taskInfo['url']) . '" size="50" />';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'URL'
		);

        // storeuid where to store the HTML
		if (empty($taskInfo['storeuid'])) {
			if ($parentObject->CMD == 'edit') {
				$taskInfo['storeuid'] = $task->storeuid;
			} else {
				$taskInfo['storeuid'] = '';
			}
		}
		$fieldID = 'task_storeuid';
		$fieldCode = '<input type="text" name="tx_scheduler[storeuid]" id="' . $fieldID . '" value="' . htmlspecialchars($taskInfo['storeuid']) . '" size="5" />';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'UID des Ziel-HTML-Elements'
		);

        // Content Element which should be extracted
		if (empty($taskInfo['contentElement'])) {
			if ($parentObject->CMD == 'add') {
				$taskInfo['contentElement'] = 'body';
			} elseif ($parentObject->CMD == 'edit') {
				$taskInfo['contentElement'] = $task->contentElement;
			} else {
				$taskInfo['contentElement'] = '';
			}
		}
		$fieldID = 'task_contentElement';
		$fieldCode = '<input type="text" name="tx_scheduler[contentElement]" id="' . $fieldID . '" value="' . htmlspecialchars($taskInfo['contentElement']) . '" size="30" />';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'Content Element (xpath queries allowed)'
		);

        // Include Container Tag
		if (empty($taskInfo['includeContainerTag'])) {
			if ($parentObject->CMD == 'edit') {
				$taskInfo['includeContainerTag'] = $task->includeContainerTag;
			} else {
				$taskInfo['includeContainerTag'] = false;
			}
		}
		$fieldID = 'task_includeContainerTag';
		$fieldCode = '<input type="checkbox" name="tx_scheduler[includeContainerTag]" id="' . $fieldID . '" value="1" ' . ($taskInfo['includeContainerTag'] ? 'checked="checked"' : '') . '/>';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'Include Container Tag'
		);

        // Line at the end to include the current time
		if (empty($taskInfo['timeMarker'])) {
			if ($parentObject->CMD == 'add') {
				$taskInfo['timeMarker'] = '<p>(Stand: %d.%m.%Y %H:%M)</p>';
			} elseif ($parentObject->CMD == 'edit') {
				$taskInfo['timeMarker'] = $task->timeMarker;
			} else {
				$taskInfo['timeMarker'] = '';
			}
		}
		$fieldID = 'task_timeMarker';
		$fieldCode = '<input type="text" name="tx_scheduler[timeMarker]" id="' . $fieldID . '" value="' . htmlspecialchars($taskInfo['timeMarker']) . '" size="50" />';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'Marker to include update time'
		);

        // Wrapper for complete content
		if (empty($taskInfo['wrapper'])) {
			if ($parentObject->CMD == 'edit') {
				$taskInfo['wrapper'] = $task->wrapper;
			} else {
				$taskInfo['wrapper'] = '';
			}
		}
		$fieldID = 'task_wrapper';
		$fieldCode = '<input type="text" name="tx_scheduler[wrapper]" id="' . $fieldID . '" value="' . htmlspecialchars($taskInfo['wrapper']) . '" size="50" />';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'Wrapper for output (separate with |)'
		);

        // Replace attributes in Tags
		if (empty($taskInfo['attr_queries'])) {
			if ($parentObject->CMD == 'add') {
				$taskInfo['attr_queries'] = '//*';
			} elseif ($parentObject->CMD == 'edit') {
				$taskInfo['attr_queries'] = $task->attr_queries;
			} else {
				$taskInfo['attr_queries'] = '';
			}
		}
		$fieldID = 'task_attr_queries';
		$fieldCode = '<textarea name="tx_scheduler[attr_queries]" id="' . $fieldID . '" cols="50" rows="3">' . htmlspecialchars($taskInfo['attr_queries']) . '</textarea>';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'Replace attributes in Tags (xpath queries allowed, one per line)'
		);

        // Names of attributes to replace
		if (empty($taskInfo['attributes'])) {
			if ($parentObject->CMD == 'add') {
				$taskInfo['attributes'] = 'style';
			} elseif ($parentObject->CMD == 'edit') {
				$taskInfo['attributes'] = $task->attributes;
			} else {
				$taskInfo['attributes'] = '';
			}
		}
		$fieldID = 'task_attributes';
		$fieldCode = '<textarea name="tx_scheduler[attributes]" id="' . $fieldID . '" cols="50" rows="3">' . htmlspecialchars($taskInfo['attributes']) . '</textarea>';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'Names of attributes to replace (one per line)'
		);

        // Values to replace with
		if (empty($taskInfo['attr_replace_with'])) {
			if ($parentObject->CMD == 'edit') {
				$taskInfo['attr_replace_with'] = $task->attr_replace_with;
			} else {
				$taskInfo['attr_replace_with'] = '';
			}
		}
		$fieldID = 'task_attr_replace_with';
		$fieldCode = '<textarea name="tx_scheduler[attr_replace_with]" id="' . $fieldID . '" cols="50" rows="3">' . htmlspecialchars($taskInfo['attr_replace_with']) . '</textarea>';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'Values to replace with (one per line) (if empty, attribute will be completely removed)'
		);


        // Replace content of the following tags
		if (empty($taskInfo['tags_to_replace_content'])) {
			if ($parentObject->CMD == 'edit') {
				$taskInfo['tags_to_replace_content'] = $task->tags_to_replace_content;
			} else {
				$taskInfo['tags_to_replace_content'] = '';
			}
		}
		$fieldID = 'task_tags_to_replace_content';
		$fieldCode = '<textarea name="tx_scheduler[tags_to_replace_content]" id="' . $fieldID . '" cols="50" rows="3">' . htmlspecialchars($taskInfo['tags_to_replace_content']) . '</textarea>';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'Replace content of the following tags (xpath queries allowed, one per line)'
		);

        // Replace content with
		if (empty($taskInfo['content_replace_with'])) {
			if ($parentObject->CMD == 'edit') {
				$taskInfo['content_replace_with'] = $task->content_replace_with;
			} else {
				$taskInfo['content_replace_with'] = '';
			}
		}
		$fieldID = 'task_content_replace_with';
		$fieldCode = '<textarea name="tx_scheduler[content_replace_with]" id="' . $fieldID . '" cols="50" rows="3">' . htmlspecialchars($taskInfo['content_replace_with']) . '</textarea>';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'Replace content with (one per line)'
		);

        // Replace complete tags
		if (empty($taskInfo['tags_to_replace'])) {
			if ($parentObject->CMD == 'add') {
				$taskInfo['tags_to_replace'] = '//script';
			} elseif ($parentObject->CMD == 'edit') {
				$taskInfo['tags_to_replace'] = $task->tags_to_replace;
			} else {
				$taskInfo['tags_to_replace'] = '';
			}
		}
		$fieldID = 'task_tags_to_replace';
		$fieldCode = '<textarea name="tx_scheduler[tags_to_replace]" id="' . $fieldID . '" cols="50" rows="3">' . htmlspecialchars($taskInfo['tags_to_replace']) . '</textarea>';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'Replace complete tags (xpath queries allowed, one per line)'
		);

        // Replace tag with
		if (empty($taskInfo['tags_replace_with'])) {
			if ($parentObject->CMD == 'add') {
				$taskInfo['tags_replace_with'] = '<!--script removed-->';
			} elseif ($parentObject->CMD == 'edit') {
				$taskInfo['tags_replace_with'] = $task->tags_replace_with;
			} else {
				$taskInfo['tags_replace_with'] = '';
			}
		}
		$fieldID = 'task_tags_replace_with';
		$fieldCode = '<textarea name="tx_scheduler[tags_replace_with]" id="' . $fieldID . '" cols="50" rows="3">' . htmlspecialchars($taskInfo['tags_replace_with']) . '</textarea>';
		$additionalFields[$fieldID] = array(
			'code'     => $fieldCode,
			'label'    => 'Replace tag with (one per line)'
		);

		return $additionalFields;
}

    public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject) {
    	$retVal = true;
    	
		$submittedData['url'] = trim($submittedData['url']);
		if (!\TYPO3\CMS\Core\Utility\GeneralUtility::isValidUrl($submittedData['url'])) {
			$parentObject->addMessage('URL muss angegeben werden', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
			$retVal = false;
		}
        
		if (!\TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($submittedData['storeuid'])) {
			$parentObject->addMessage('UID muss als Zahl angegeben werden', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
			$retVal = false;
		}
		else {
			$submittedData['storeuid'] = \TYPO3\CMS\Core\Utility\MathUtility::convertToPositiveInteger($submittedData['storeuid']);
			$recData = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord('tt_content', $submittedData['storeuid'], 'CType');
			if (!is_array($recData) || $recData['CType'] != 'html') {
				$parentObject->addMessage('Angegebene UID ist kein HTML Element', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
				$retVal = false;
		    }
		}
        
		$submittedData['contentElement'] = trim($submittedData['contentElement']);
		if ($submittedData['contentElement'] == '') {
			$parentObject->addMessage('Content Element muss angegeben werden', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
			$retVal = false;
		}
        
        $submittedData['includeContainerTag'] = $submittedData['includeContainerTag'] == '1';
        $submittedData['timeMarker'] = trim($submittedData['timeMarker']);
        $submittedData['wrapper'] = trim($submittedData['wrapper']);
        // it's important for the textareas to remove CRs input from Windows computers
        $submittedData['attr_queries'] = str_replace("\r", '', trim($submittedData['attr_queries']));
        $submittedData['attributes'] = str_replace("\r", '', rtrim($submittedData['attributes']));
        $submittedData['attr_replace_with'] = str_replace("\r", '', rtrim($submittedData['attr_replace_with']));
        $submittedData['tags_to_replace_content'] = str_replace("\r", '', trim($submittedData['tags_to_replace_content']));
        $submittedData['content_replace_with'] = str_replace("\r", '', rtrim($submittedData['content_replace_with']));
        $submittedData['tags_to_replace'] = str_replace("\r", '', trim($submittedData['tags_to_replace']));
        $submittedData['tags_replace_with'] = str_replace("\r", '', rtrim($submittedData['tags_replace_with']));
        
		return $retVal;
    }

	public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task) {
		$task->url = $submittedData['url'];
		$task->storeuid = $submittedData['storeuid'];
		$task->contentElement = $submittedData['contentElement'];
		$task->includeContainerTag = $submittedData['includeContainerTag'];
		$task->timeMarker = $submittedData['timeMarker'];
		$task->wrapper = $submittedData['wrapper'];
		$task->attr_queries = $submittedData['attr_queries'];
		$task->attributes = $submittedData['attributes'];
		$task->attr_replace_with = $submittedData['attr_replace_with'];
		$task->tags_to_replace_content = $submittedData['tags_to_replace_content'];
		$task->content_replace_with = $submittedData['content_replace_with'];
		$task->tags_to_replace = $submittedData['tags_to_replace'];
		$task->tags_replace_with = $submittedData['tags_replace_with'];
	}
}
?>
