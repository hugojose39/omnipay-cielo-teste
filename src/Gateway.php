<?php

namespace Omnipay\CieloTest;

use Omnipay\CieloTest\Message\AcceptNotificationRequest;
use Omnipay\CieloTest\Message\AuthorizeRequest;
use Omnipay\CieloTest\Message\CaptureRequest;
use Omnipay\CieloTest\Message\CompleteAuthorizeRequest;
use Omnipay\CieloTest\Message\CompletePurchaseRequest;
use Omnipay\CieloTest\Message\CreateCardRequest;
use Omnipay\CieloTest\Message\CreateCardTokenRequest;
use Omnipay\CieloTest\Message\DeleteCardRequest;
use Omnipay\CieloTest\Message\FetchTransactionRequest;
use Omnipay\CieloTest\Message\PurchaseRequest;
use Omnipay\CieloTest\Message\RefundRequest;
use Omnipay\CieloTest\Message\UpdateCardRequest;
use Omnipay\CieloTest\Message\VoidRequest;
use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'CieloTest';
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

    public function createTokenCard(array $parameters = []): CreateCardTokenRequest
    {
        return $this->createRequest(CreateCardTokenRequest::class, $parameters);
    }

    public function acceptNotification(array $parameters = []): AcceptNotificationRequest
    {
        return $this->createRequest(AcceptNotificationRequest::class, $parameters);
    }

    public function completeAuthorize(array $parameters = []): CompleteAuthorizeRequest
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = []): CompletePurchaseRequest
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    public function createCard(array $parameters = []): CreateCardRequest
    {
        return $this->createRequest(CreateCardRequest::class, $parameters);
    }

    public function deleteCard(array $parameters = []): DeleteCardRequest
    {
        return $this->createRequest(DeleteCardRequest::class, $parameters);
    }

    public function fetchTransaction(array $parameters = []): FetchTransactionRequest
    {
        return $this->createRequest(FetchTransactionRequest::class, $parameters);
    }

    public function refund(array $parameters = []): RefundRequest
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    public function void(array $parameters = []): VoidRequest
    {
        return $this->createRequest(VoidRequest::class, $parameters);
    }

    public function updateCard(array $parameters = []): UpdateCardRequest
    {
        return $this->createRequest(UpdateCardRequest::class, $parameters);
    }
}
