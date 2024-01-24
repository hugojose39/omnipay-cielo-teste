<?php

namespace Hugojose39\OmnipayCieloTeste\Message;

class CreateCardTokenRequest extends AbstractRequest
{
    public function getData(): array
    {
        if ($this->getCard()) {
            $data = $this->getCardData();
        } else {
            [];
        }

        return $data;
    }
    
    public function getEndpoint()
    {
        return $this->endpoint.'1/card';
    }
}
