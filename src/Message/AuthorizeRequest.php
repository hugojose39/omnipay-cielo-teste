<?php

namespace Hugojose39\OmnipayCieloTeste\Message;

class AuthorizeRequest extends AbstractRequest
{
    public function getInstallments(): ?int
    {
        return $this->getParameter('installments');
    }

    public function setInstallments(int $value): AuthorizeRequest
    {
        return $this->setParameter('installments', (int)$value);
    }

    public function getSoftDescriptor(): ?string
    {
        return $this->getParameter('soft_descriptor');
    }

    public function setSoftDescriptor(string $value): AuthorizeRequest
    {
        return $this->setParameter('soft_descriptor', substr($value, 0, 13));
    }

    public function getProvider(): ?string
    {
        return $this->getParameter('provider');
    }

    public function setProvider(string $value): AuthorizeRequest
    {
        return $this->setParameter('provider', $value);
    }

    public function getData()
    {
        $this->validate('amount');

        $data = [];

        $data['MerchantOrderId'] = $this->getMerchantOrderId();
        $data['Payment']['Amount'] = $this->getAmountInteger();
        $data['Payment']['Type'] = $this->getPaymentMethod();
        $data['Payment']['Installments'] = $this->getInstallments();
        $data['Payment']['SoftDescriptor'] = $this->getSoftDescriptor();

        if ($this->getPaymentMethod() && (strtolower($this->getPaymentMethod()) == 'boleto')) {
            $data['Payment']['Provider'] = $this->getProvider();

            $data = array_merge($data, $this->getCustomerData());
        } elseif ($this->getCard()) {
            $data['Payment']['CreditCard'] = $this->getCardData();

            $data = array_merge($data, $this->getCustomerData());
        }

        $data['Payment']['Capture'] = true;

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint().'1/sales';
    }
}
