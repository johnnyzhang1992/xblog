<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/10/7
 * Time: 23:07
 */

namespace App\Notifications;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use XblogConfig;
class BaseNotification extends Notification implements ShouldQueue
{
    public function enableMail()
    {
        return XblogConfig::getValue('enable_mail_notification') == 'true';
    }
}