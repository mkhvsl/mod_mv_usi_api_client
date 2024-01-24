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

?>

<?php if (property_exists($data, 'data')) : ?>
<ul class="js-filter uk-list uk-list-disc uk-list-divider">
    <?php foreach ($data->data as $item) : ?>
    <?php
    $lecturers = [];
    if($item->lecturers->data) {
        foreach($item->lecturers->data as $row)
        {
            $name = $row->person->short_name;
            /*if (property_exists($row->person, 'url_en'))
            {
                $name = '<a href="' . $row->person->url_en . '" target="_blank">' . $row->person->short_name . '</a>';
            }*/
            $lecturers[$row->person->short_name] = $name;
        }
    }

    $title =  $item->name_en;
    if (property_exists($item, 'url_en'))
    {
        $title = '<a href="' . $item->url_en . '" target="_blank">' .  $item->name_en . '</a>';
    }
    ?>
    <li>
        <?php echo $title ?>, <?php echo implode(', ', $lecturers) ?>, <?php echo $item->semester_academic_year ?>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

