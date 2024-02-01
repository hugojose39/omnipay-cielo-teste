<?php

namespace Omnipay\CieloTest\Message;

/**
 * Classe CaptureRequest
 *
 * Esta classe representa uma solicitação de captura no gateway Cielo.
 * 
 * @see \Omnipay\CieloTest\Message\AbstractRequest
 */
class CaptureRequest extends AbstractRequest
{
    /**
     * Obtém os dados da solicitação
     *
     * @return array Retorna os dados da solicitação de captura.
     */
    public function getData(): array
    {
        $data = [
            '' => '',
        ];

        return $data;
    }

    /**
     * Obtém o endpoint da solicitação
     *
     * @return string Retorna o endpoint da solicitação de captura.
     */
    public function getEndpoint(): string
    {
        $capture = $this->getAmountInteger() ? "/capture?amount={$this->getAmountInteger()}" : '/capture';

        return $this->endpoint().'1/sales/'.$this->getTransactionReference().$capture;
    }

    /**
     * Obtém o método HTTP da solicitação
     *
     * @return string Retorna o método HTTP da solicitação de captura.
     */
    public function getHttpMethod(): string
    {
        return 'PUT';
    }
}
