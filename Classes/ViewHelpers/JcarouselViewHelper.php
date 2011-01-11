<?php
class Tx_f2jcarouselvh_ViewHelpers_JcarouselViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Displays HTML items in a JCarousel
	 *
	 * @param array $htmlItems
	 * @param string $cssFile
	 * @param string $jsonJCarouselConfig
	 * @param string $preJsCode
	 * @param string $postJsCode
	 * @return string
	 */
	public function render($htmlItems = NULL, $cssFile = NULL, $jsonJCarouselConfig = NULL, $preJsCode = NULL, $postJsCode) {
		$this->addHeaderFiles($cssFile);

		$pluginId = md5(time());

		$this->addJcarouselJS($pluginId, $jsonJCarouselConfig, $preJsCode, $postJsCode);

		$view = t3lib_div::makeInstance('Tx_Fluid_View_StandaloneView');
		$view->setTemplatePathAndFilename(t3lib_extMgm::extPath('f2jcarouselvh').'Resources/Private/Templates/JcarouselViewHelper.html');

		$view->assign('htmlItems', $htmlItems);
		$view->assign('pluginId', $pluginId);

		return $view->render();
	}

	private function addHeaderFiles($cssFile = NULL) {
		$response = $this->controllerContext->getResponse();
		if ( !isset($GLOBALS['f2jcarouselvh_js'])) {
			$GLOBALS['f2jcarouselvh_js'] = TRUE;
			$response->addAdditionalHeaderData(
				'<script type="text/javascript" src="'. t3lib_extMgm::extRelPath('f2jcarouselvh') . 'Resources/Public/JavaScript/jquery.jcarousel.js"></script>'
			);
		}

		if (!$cssFile) {
			if ( !isset($GLOBALS['f2jcarouselvh_css'])) {
				$GLOBALS['f2jcarouselvh_css'] = TRUE;
				$response->addAdditionalHeaderData(
					'<link rel="stylesheet" type="text/css" href="'. t3lib_extMgm::extRelPath('f2jcarouselvh') . 'Resources/Public/StyleSheet/skins/tango/skin.css" />'
				);
			}
		}
	}

	private function addJcarouselJS($pluginId, $jsonConfig, $preJsCode, $postJsCode) {
		$view = t3lib_div::makeInstance('Tx_Fluid_View_StandaloneView');
		$view->setTemplatePathAndFilename(t3lib_extMgm::extPath('f2jcarouselvh').'Resources/Private/Templates/JcarouselViewHelper.js');
		$view->assign('pluginId', $pluginId);
		$view->assign('preJsCode', $preJsCode);
		$view->assign('postJsCode', $postJsCode);
		$view->assign('jsonConfig', $jsonConfig);

		$response = $this->controllerContext->getResponse();
		$response->addAdditionalHeaderData(
				'<script type="text/javascript">'. $view->render() .'</script>'
		);
	}
}
?>