<?php

/**
 * @package     mod_mv_usi_api_client
 *
 * @copyright   (C) 2024 Mykhailo Vasylenko <https://github.com/mkhvsl>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;

if (!$data) {
    return;
}

$wa = $app->getDocument()->getWebAssetManager();

$wa->registerAndUseStyle('uikit.css', 'https://cdn.jsdelivr.net/npm/uikit@3.17.11/dist/css/uikit.min.css');
$wa->registerAndUseScript('uikit.js', 'https://cdn.jsdelivr.net/npm/uikit@3.17.11/dist/js/uikit.min.js');
$wa->registerAndUseScript('uikit-icons.js', 'https://cdn.jsdelivr.net/npm/uikit@3.17.11/dist/js/uikit-icons.min.js');

?>
<div class="mod-mv-usi-api-client" uk-filter="target: .js-filter">
    <?php require ModuleHelper::getLayoutPath('mod_mv_usi_api_client', $params->get('layout', 'default') . '_' . $params->get('resource', 'courses')); ?>
</div>
<?php //echo '<pre>' . print_r($data, true) . '</pre>'; ?>
