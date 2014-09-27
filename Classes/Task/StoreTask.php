<?php
namespace DANNYM\StoreUrl\Task;
class StoreTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {
    public function execute() {
    	// check UID
		$recData = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord('tt_content', $this->storeuid, 'CType, pid');
		if (!is_array($recData) || $recData['CType'] != 'html') {
			throw new \TYPO3\CMS\Scheduler\FailedExecutionException('Angegebene UID ist kein HTML Element');
        }
    	
    	// get the URL
    	$data = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($this->url);
    	if ($data === FALSE || empty($data)) {
    		throw new \TYPO3\CMS\Scheduler\FailedExecutionException('Konnte URL nicht laden.');
    	}
    	if (strlen($data) > 100000) {  // security...
    		throw new \TYPO3\CMS\Scheduler\FailedExecutionException('Geladene URL ist zu groß.');
    	}
    	
		// parse the HTML to dom
		$html = new \DANNYM\StoreUrl\Utility\simple_html_dom(null);
		$html->load($data);

		// get the relevant part
		$content = $html->find($this->contentElement,0);

		// Replace attributes
		$repAttributesSelector = explode("\n",$this->attr_queries);
		$repAttr = explode("\n",$this->attributes);
		$repWith = explode("\n",$this->attr_replace_with);
		for ($i=0; $i<sizeof($repAttributesSelector); $i++) {
			if (isset($repAttr[$i]) && $repAttr[$i] != '') {
				foreach ($content->find($repAttributesSelector[$i]) as $tag) {
					if (isset($repWith[$i]) && $repWith[$i] != '' ){
						$tag->setAttribute($repAttr[$i],$repWith[$i]);
					}
					else {
						$tag->removeAttribute($repAttr[$i]);
					}
				}
			}
		}
		
		// Replace content
		$replaceContSelector = explode("\n",$this->tags_to_replace_content);
		$replaceContWith = explode("\n",$this->content_replace_with);
		for ($i=0; $i<sizeof($replaceContSelector); $i++){
			foreach ($content->find($replaceContSelector[$i]) as $tag) {
				if (isset($replaceContWith[$i]) && $replaceContWith[$i] != '') {
					$tag->innertext = $replaceContWith[$i];
				}
				else {
					$tag->innertext = '';
				}
			}
		}
		
		// Replace tags
		$replaceTagSelector = explode("\n",$this->tags_to_replace);
		$replaceTagWith = explode("\n",$this->tags_replace_with);
		for ($i=0; $i<sizeof($replaceTagSelector); $i++) {
			foreach ($content->find($replaceTagSelector[$i]) as $tag) {
				if (isset($replaceTagWith[$i])) {
					$tag->outertext = $replaceTagWith[$i];
				}
			}
		}
		
		// Get content
		if (!$this->includeContainerTag){
			$content = $content->innertext;
		}

		// Update time
		if ($this->timeMarker != '') {
			$content = $content . strftime($this->timeMarker);
		}
				
		// Wrapper
		if ($this->wrapper != '') {
			$wrapParts = explode('|', $this->wrapper, 2);
			$content = $wrapParts[0] . $content . $wrapParts[1];
		}
		else {
			$content = '<div>' . $content . '</div>';
		}
		    	
    	// store it
    	if ($GLOBALS['TYPO3_DB']->exec_UPDATEquery('tt_content', 'uid='.$this->storeuid, array('bodytext'=>$content)) === FALSE) {
    		throw new \TYPO3\CMS\Scheduler\FailedExecutionException('Konnte HTML nicht abspeichern: '.$GLOBALS['TYPO3_DB']->sql_error());
    	}
    	// and clear the cache of the page where the content element is located
    	$tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
		$tce->start(array(), array());
		$tce->clear_cacheCmd($recData['pid']);
    	
        return true;
    }

    public function getAdditionalInformation() {
        return 'Speichere "'.$this->url.'" in UID '.$this->storeuid.'.';
    }
}
?>
