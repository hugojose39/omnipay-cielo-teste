<?php

namespace Omnipay\CieloTest\Message;

class CaptureRequest extends AbstractRequest
{
    public function getData(): array
    {
        $data = [
            '' => '',
        ];

        return $data;
    }

    public function getEndpoint(): string
    {
        $capture = $this->getAmountInteger() ? "/capture?amount={$this->getAmountInteger()}" : '/capture';

        return $this->endpoint().'1/sales/'.$this->getTransactionReference().$capture;
    }

    public function getHttpMethod(): string
    {
        return 'PUT';
    }
}
