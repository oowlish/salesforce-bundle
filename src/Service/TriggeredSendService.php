<?php

declare(strict_types=1);

namespace Oowlish\SalesforceBundle\Service;

use FuelSdk\ET_Client;
use FuelSdk\ET_TriggeredSend;

class TriggeredSendService
{
    private $client;
    private $sendTrigger;

    public function __construct(ET_Client $client, ET_TriggeredSend $sendTrigger)
    {
        $this->client = $client;
        $this->sendTrigger = $sendTrigger;
    }

    public function sendMail(array $props, array $subscribers)
    {
        $this->sendTrigger->props = $props;
        $this->sendTrigger->authStub = $this->client;
        $this->sendTrigger->subscribers = $subscribers;

        return $this->sendTrigger->send();
    }
}
