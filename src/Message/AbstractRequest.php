<?php

namespace Hugojose39\OmnipayCieloTeste\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

abstract class AbstractRequest extends BaseAbstractRequest
{
    protected $endpoint = sprintf('https://%s.cieloecommerce.cielo.com.br/', $this->getTestMode() ? 'apisandbox' : 'api');

    public function getMerchantOrderId(): array
    {
        return $this->getParameter('merchant_order_id');
    }
    public function setMerchantOrderId($value): AbstractRequest
    {
        return $this->setParameter('merchant_order_id', $value);
    }

    public function getCard(): array
    {
        return $this->getParameter('card');
    }

    public function setCard($value): AbstractRequest
    {
        return $this->setParameter('card', $value);
    }

    public function getMerchantId(): string
    {
        return $this->getParameter('MerchantId');
    }

    public function setMerchantId(string $value): AbstractRequest
    {
        return $this->setParameter('MerchantId', $value);
    }

    public function getMerchantKey(): string
    {
        return $this->getParameter('MerchantKey');
    }

    public function setMerchantKey(string $value): AbstractRequest
    {
        return $this->setParameter('MerchantKey', $value);
    }

    public function getCustomer(): array
    {
        return $this->getParameter('customer');
    }

    public function setCustomer($value): AbstractRequest
    {
        return $this->setParameter('customer', $value);
    }

    protected function insertMerchantToData($data): array
    {
        $data['MerchantId'] = $this->getMerchantId();
        $data['MerchantKey'] = $this->getMerchantKey();

        return $data;
    }

    public function getHttpMethod(): string
    {
        return 'POST';
    }

    public function sendData($data)
    {
        $httpRequest = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [
                'Content-Type' => 'application/json'
            ],
            json_encode($this->insertMerchantToData($data)),
            $this->getOptions()
        );

        $payload = json_decode($httpRequest->getBody()->getContents(), true);

        return $this->response = new Response($this, $payload);
    }

    protected function getOptions(): array
    {
        return [];
    }

    protected function getEndpoint()
    {
        return $this->endpoint;
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }

    protected function getCardData(): array
    {
        $data = [];

        $data = $this->getCard();

        return $data;
    }

    protected function getCustomerData(): array
    {
        $data = [];

        $data['Customer'] = $this->getCustomer();

        return $data;
    }
}
