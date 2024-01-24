<?php

namespace Hugojose39\OmnipayCieloTeste\Message;

use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset($this->data['MerchantOrderId']) || isset($this->data['CardToken']) || isset($this->data['Status']);
    }

    public function getTransactionReference(): ?string
    {
        if (isset($this->data['Payment']['PaymentId'])) {
            return $this->data['Payment']['PaymentId'];
        }

        if (isset($this->data['Tid'])) {
            return $this->data['Tid'];
        }

        return null;
    }

    public function getCardReference()
    {
        if (isset($this->data['CardToken'])) {
            return $this->data['CardToken'];
        } elseif (isset($this->data['MerchantOrderId']) && isset($this->data['Payment']['CreditCard'])) {
            return $this->data['Payment']['CreditCard'];
        }

        return null;
    }

    public function getCustomerReference()
    {
        if (isset($this->data['MerchantOrderId']) && isset($this->data['Customer'])) {
            return $this->data['Customer'];
        }

        return null;
    }

    public function getMessage(): ?array
    {
        if (!$this->isSuccessful()) {
            return [
                'code' => $this->data[0]['Code'],
                'error' => $this->data[0]['Message'],
            ];
        }

        return null;
    }

    public function getBoleto(): ?array
    {
        if (isset($this->data['MerchantOrderId']) && isset($this->data['Payment']['BarCodeNumber'])) {
            return [
                'boleto_url' => $this->data['Payment']['Url'],
                'boleto_barcode' => $this->data['Payment']['BarCodeNumber'],
                'digitable_line' => $this->data['Payment']['DigitableLine'],
                'boleto_expiration_date' => $this->data['Payment']['ExpirationDate'],
            ];
        }

        return null;
    }
}
