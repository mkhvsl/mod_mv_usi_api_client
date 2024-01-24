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

if (property_exists($data, 'data'))
{
    foreach ($data->data as $item)
    {
        $year = date('Y', strtotime($item->date_start));
        $filterYears['filter-year-' . $year] = $year;

        if($item->categories->data) {
            foreach($item->categories->data as $row)
            {
                $filterCategories['filter-category-' . $row->id] = $row->name_en;
            }
        }
    }

    arsort($filterYears, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
    asort($filterCategories, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
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
                        <a href>Category <span uk-drop-parent-icon></span></a>
                        <div class="uk-navbar-dropdown uk-width-large">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li uk-filter-control="filter: ; group: data-category"><a href="#">All</a></li>
                                <?php foreach ($filterCategories as $id => $name) : ?>
                                <li uk-filter-control="filter: .<?php echo $id ?>; group: data-category"><a href="#"><?php echo $name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>
<ul class="js-filter uk-list uk-list-disc uk-list-divider">
    <?php foreach ($data->data as $item) : ?>
    <?php
    $year = date('Y', strtotime($item->date_start));

    $people = [];
    if($item->people->data) {
        foreach($item->people->data as $row)
        {
            $name = $row->person->short_name;
            /*if (property_exists($row->person, 'url_en'))
            {
                $name = '<a href="' . $row->person->url_en . '" target="_blank">' . $row->person->short_name . '</a>';
            }*/
            $people[$row->person->short_name] = $name;
        }
    }

    $categories = [];
    if($item->categories->data) {
        foreach($item->categories->data as $row)
        {
            $categories['filter-category-' . $row->id] = $row->name_en;
        }
    }

    $title =  $item->title_en;
    if (property_exists($item, 'url_en'))
    {
        $title = '<a href="' . $item->url_en . '" target="_blank">' .  $item->title_en . '</a>';
    }
    ?>
    <li class="filter-year-<?php echo $year ?> <?php echo implode(' ', array_keys($categories)) ?>">
        <?php echo implode(', ', $people) ?> (<?php echo $year ?>) <?php echo $title ?>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

