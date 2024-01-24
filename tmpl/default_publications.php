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

$filterYears = [];
$filterCategories = [];
$groups = [];
$itemsAttributes = [];
$allAttributes = [];

if (property_exists($data, 'data'))
{
    foreach ($data->data as $item)
    {
        $year = $item->year;
        $filterYears['filter-year-' . $year] = $year;

        $type = $item->type->name_en;
        $filterTypes['filter-type-' . $item->type->id] = $type;

        $groups[$type][] = $item;

        if($item->attributes->data) {
            foreach($item->attributes->data as $row)
            {
                $itemsAttributes[$item->id][$row->type->name_en] = $row->value;
                $allAttributes[$row->type->name_en] = $row->type->name_en;
            }
        }
    }

    arsort($filterYears, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
    asort($filterTypes, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
    asort($allAttributes, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
    ksort($groups, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
}

?>

<?php if (property_exists($data, 'data')) : ?>
<nav class="uk-navbar-container">
    <div class="uk-container">
        <div uk-navbar="mode: click">

            <div class="uk-navbar-left">

                <ul class="uk-navbar-nav">
                    <li class="uk-active" uk-filter-control><a href="#">All</a></li>
                    <li>
                        <a href>Year <span uk-drop-parent-icon></span></a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li uk-filter-control="filter: ; group: data-year"><a href="#">All</a></li>
                                <?php foreach ($filterYears as $id => $name) : ?>
                                <li uk-filter-control="filter: .<?php echo $id ?>; group: data-year"><a href="#"><?php echo $name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href>Type <span uk-drop-parent-icon></span></a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li uk-filter-control="filter: ; group: data-type"><a href="#">All</a></li>
                                <?php foreach ($filterTypes as $id => $name) : ?>
                                <li uk-filter-control="filter: .<?php echo $id ?>; group: data-type"><a href="#"><?php echo $name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>
<div class="uk-margin-top">
    <?php foreach ($groups as $groupName => $items) : ?>
    <div class="uk-h3"><?php echo $groupName ?> (<?php echo count($items) ?>)</div>
        <ul class="js-filter uk-list uk-list-disc uk-column-1-2@l">
            <?php foreach ($items as $item) : ?>
            <?php
            $year = $item->year;

            $authors = [];
            if($item->authors->data) {
                foreach($item->authors->data as $row)
                {
                    $name = $row->person->short_name;
                    /*if (property_exists($row->person, 'url_en'))
                    {
                        $name = '<a href="' . $row->person->url_en . '" target="_blank">' . $row->person->short_name . '</a>';
                    }*/
                    $authors[$row->person->short_name] = $name;
                }
            }

            $title = $item->title;
            if (property_exists($item, 'url_en'))
            {
                $title = '<a href="' . $item->url_en . '" target="_blank">' . $item->title . '</a>';
            }

            $attributes = [];
            if(isset($itemsAttributes[$item->id]))
            {
                if(isset($itemsAttributes[$item->id]['Conference proceedings']))
                {
                    $attributes[] = $itemsAttributes[$item->id]['Conference proceedings'];
                }

                if(isset($itemsAttributes[$item->id]['Meeting name']))
                {
                    $attributes[] = $itemsAttributes[$item->id]['Meeting name'];
                }

                if(isset($itemsAttributes[$item->id]['Meeting place']))
                {
                    $attributes[] = $itemsAttributes[$item->id]['Meeting place'];
                }

                if(isset($itemsAttributes[$item->id]['Book']))
                {
                    $attributes[] = $itemsAttributes[$item->id]['Book'];
                }

                if(isset($itemsAttributes[$item->id]['Journal']))
                {
                    $attributes[] = $itemsAttributes[$item->id]['Journal'];
                }

                if(isset($itemsAttributes[$item->id]['Series']))
                {
                    $attributes[] = $itemsAttributes[$item->id]['Series'];
                }

                if(isset($itemsAttributes[$item->id]['Publisher']))
                {
                    $attributes[] = $itemsAttributes[$item->id]['Publisher'];
                }

                if(
                    isset($itemsAttributes[$item->id]['Volume'])
                     && isset($itemsAttributes[$item->id]['Number'])
                     && isset($itemsAttributes[$item->id]['Start page number'])
                     && isset($itemsAttributes[$item->id]['End page number'])
                    )
                {
                    $attributes[] = $itemsAttributes[$item->id]['Volume'] . ' (' . $itemsAttributes[$item->id]['Number'] . '):' . $itemsAttributes[$item->id]['Start page number'] . '-' . $itemsAttributes[$item->id]['End page number'];
                }
                elseif(
                    isset($itemsAttributes[$item->id]['Start page number'])
                     && isset($itemsAttributes[$item->id]['End page number'])
                    )
                {
                    $attributes[] = $itemsAttributes[$item->id]['Start page number'] . '-' . $itemsAttributes[$item->id]['End page number'];
                }

                if(isset($itemsAttributes[$item->id]['ISSN']))
                {
                    $attributes[] = 'ISSN ' . $itemsAttributes[$item->id]['ISSN'];
                }

                if(isset($itemsAttributes[$item->id]['ISBN']))
                {
                    $attributes[] = 'ISBN ' . $itemsAttributes[$item->id]['ISBN'];
                }
            }
            ?>
        
            <li class="filter-year-<?php echo $year ?> filter-type-<?php echo $item->type->id ?>"><?php echo implode(', ', $authors) ?> (<?php echo $year ?>) <?php echo $title ?>. <?php echo implode('. ', $attributes) ?></li>

            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php //echo '<pre>' . print_r($itemsAttributes, true) . '</pre>'; ?>
<?php //echo '<pre>' . print_r($allAttributes, true) . '</pre>'; ?>