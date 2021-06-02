<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU Affero General Public License, version 3 (AGPL-3.0-or-later)
 * Copyright 2001 - 2020 Ampache.org
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

use Ampache\Config\AmpConfig;
use Ampache\Module\Shout\ShoutParentObjectLoaderInterface;
use Ampache\Repository\Model\ModelFactoryInterface;
use Ampache\Repository\Model\User;
use Ampache\Module\Util\Ui;

/** @var int[] $object_ids */
/** @var string $web_path */
/** @var ModelFactoryInterface $modelFactory */
/** @var ShoutParentObjectLoaderInterface $shoutParentObjectLoader */

global $dic;
$modelFactory            = $dic->get(ModelFactoryInterface::class);
$shoutParentObjectLoader = $dic->get(ShoutParentObjectLoaderInterface::class);

$web_path = AmpConfig::get('web_path'); ?>
<table class="tabledata striped-rows">
    <thead>
        <tr class="th-top">
            <th class="cel_object"><?php echo T_('Object'); ?></th>
            <th class="cel_username"><?php echo T_('User'); ?></th>
            <th class="cel_sticky"><?php echo T_('Sticky'); ?></th>
            <th class="cel_comment"><?php echo T_('Comment'); ?></th>
            <th class="cel_date"><?php echo T_('Date Added'); ?></th>
            <th class="cel_action"><?php echo T_('Action'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($object_ids as $shout_id) {
            $libitem = $modelFactory->createShoutbox($shout_id);

            $object = $shoutParentObjectLoader->load(
                $libitem->getObjectType(),
                $libitem->getObjectId()
            );
            $object->format();
            $client = new User($libitem->getUserId());
            $client->format();

            require Ui::find_template('show_shout_row.inc.php'); ?>
        <?php
        } if (!count($object_ids)) { ?>
        <tr>
            <td colspan="6" class="error"><?php echo T_('No records found'); ?></td>
        </tr>
        <?php
        } ?>
    </tbody>
    <tfoot>
        <tr class="th-bottom">
            <th class="cel_object"><?php echo T_('Object'); ?></th>
            <th class="cel_username"><?php echo T_('User'); ?></th>
            <th class="cel_sticky"><?php echo T_('Sticky'); ?></th>
            <th class="cel_comment"><?php echo T_('Comment'); ?></th>
            <th class="cel_date"><?php echo T_('Date Added'); ?></th>
            <th class="cel_action"><?php echo T_('Action'); ?></th>
        </tr>
    </tfoot>
</table>
