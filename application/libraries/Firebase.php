<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\ApnsConfig;
// use Kreait\Firebase\Messaging\Notification;

class Firebase
{

    private $firebase;
    private $messaging;

    function __construct()
    {
        $this->ci = &get_instance();
        $this->firebase = (new Factory)->withServiceAccount(FCPATH . '/socialchannel-fbd99-firebase-adminsdk-nhgc0-a3e6a2d7f1.json');
        $this->messaging = $this->firebase->createMessaging();
    }

    function sendData($token, $data = [])
    {
        try {
            $message = CloudMessage::withTarget('token', $token)
                // ->withNotification(Notification::create('Test', 'Test')
                ->withData($data)
                ->withHighestPossiblePriority()
                ->withApnsConfig([
                    "payload" => [
                        "aps" => [
                            "content-available" => 1
                        ]
                    ]
                ]);
            return $this->messaging->send($message);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
