<?php

declare(strict_types=1);

/*
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

defined('_IN_JOHNCMS') || die('Error: restricted access');

/**
 * @var PDO                        $db
 * @var Johncms\Api\ToolsInterface $tools
 * @var Johncms\Api\UserInterface  $user
 * @var League\Plates\Engine       $view
 */

$total = $db->query('SELECT COUNT(*) FROM `users` WHERE `rights` >= 1')->fetchColumn();
$req = $db->query("SELECT `id`, `name`, `sex`, `lastdate`, `datereg`, `status`, `rights`, `ip`, `browser`, `rights` FROM `users` WHERE `rights` >= 1 ORDER BY `rights` DESC LIMIT ${start}, " . $user->config->kmess);

echo $view->render('users::userlist', [
    'pagination' => $tools->displayPagination('?act=userlist&amp;', $start, $total, $user->config->kmess),
    'title'      => _t('Administration'),
    'total'      => $total,
    'list'       =>
        function () use ($req) {
            while ($res = $req->fetch()) {
                yield $res;
            }
        },
]);
