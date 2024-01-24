<?php

namespace Hugojose39\OmnipayCieloTeste\Message;

class CaptureRequest extends AbstractRequest
{
    public function getData(): array
    {
        $data = [];

        return $data;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint.'1/sales/'.$this->getTransactionReference()."/capture?amount={$this->getAmountInteger()}";
    }

    public function getHttpMethod(): string
    {
        return 'PUT';
    }
}
