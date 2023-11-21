<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
// use Kreait\Firebase\Messaging\Notification;

class Firebase
{

    private $firebase;
    private $messaging;

    function __construct()
    {
        $this->ci = &get_instance();
        $this->firebase = (new Factory)->withServiceAccount(FCPATH . '/tangan-angie-firebase-adminsdk-aqx3o-7ec05a63ec.json');
        $this->messaging = $this->firebase->createMessaging();
    }

    function sendData($token, $data = [])
    {
        try {
            $message = CloudMessage::withTarget('token', $token)
                // ->withNotification(Notification::create('Test', 'Test')
                ->withData($data);
            return $this->messaging->send($message);
        } catch (Exception $e) {
            return null;
        }
    }
}
