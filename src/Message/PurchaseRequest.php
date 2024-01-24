<?php

namespace Hugojose39\OmnipayCieloTeste\Message;

class PurchaseRequest extends AuthorizeRequest
{
    public function getData()
    {
        $data = parent::getData();
        $data['Payment']['Capture'] = true;

        return $data;
    }
}
