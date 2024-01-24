<?php

/**
 * @package     mod_mv_usi_api_client
 *
 * @copyright   (C) 2024 Mykhailo Vasylenko <https://github.com/mkhvsl>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Module\MvUsiApiClient\Site\Helper;

use Joomla\CMS\Access\Access;
use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Date\Date;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\Database\DatabaseAwareInterface;
use Joomla\Database\DatabaseAwareTrait;
use Joomla\Registry\Registry;
use Joomla\String\StringHelper;
use Joomla\CMS\Http\HttpFactory;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Helper for mod_articles_category
 *
 * @since  1.6
 */
class UsiApiHelper implements DatabaseAwareInterface
{
    use DatabaseAwareTrait;

    /**
     * Retrieve data
     *
     * @param   Registry         $params  The module parameters.
     * @param   SiteApplication  $app           The current application.
     *
     * @return  object[]
     *
     * @since   4.4.0
     */
    public function getData(Registry $params, SiteApplication $app)
    {
        $http = HttpFactory::getHttp();

        $response = $http->get('https://search.usi.ch/api/people/' . $params->get('id') . '/' . $params->get('resource'));

        $data = json_decode((string) $response->getBody());

        return $data;
    }
}
