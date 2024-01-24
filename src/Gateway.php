<?php

namespace Hugojose39\OmnipayCieloTeste;

use Hugojose39\OmnipayCieloTeste\Message\AuthorizeRequest;
use Hugojose39\OmnipayCieloTeste\Message\CaptureRequest;
use Hugojose39\OmnipayCieloTeste\Message\CreateCardTokenRequest;
use Hugojose39\OmnipayCieloTeste\Message\PurchaseRequest;
use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Cielo';
    }

    public function getDefaultParameters(): array
    {
        return [
            'merchantId' => '',
            'merchantKey' => '',
        ];
    }

    public function getMerchantId(): string
    {
        return $this->getParameter('MerchantId');
    }

    public function setMerchantId(string $value): Gateway
    {
        return $this->setParameter('MerchantId', $value);
    }

    public function getMerchantKey(): string
    {
        return $this->getParameter('MerchantKey');
    }

    public function setMerchantKey(string $value): Gateway
    {
        return $this->setParameter('MerchantKey', $value);
    }

    public function authorize(array $parameters = []): AuthorizeRequest
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    public function capture(array $parameters = []): CaptureRequest
    {
        return $this->createRequest(CaptureRequest::class, $parameters);
    }

    public function purchase(array $parameters = []): PurchaseRequest
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function createTokenCard(array $parameters = array()): CreateCardTokenRequest
    {
        return $this->createRequest(CreateCardTokenRequest::class, $parameters);
    }
}
