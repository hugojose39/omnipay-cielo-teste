<?php

namespace Omnipay\CieloTest\Message;

/**
 * Classe CreateCardTokenRequest
 *
 * Esta classe representa uma solicitação de criação de token de cartão no gateway Cielo.
 * 
 * @see \Omnipay\CieloTest\Message\AbstractRequest
 */
class CreateCardTokenRequest extends AbstractRequest
{
    /**
     * Obtém os dados da solicitação
     *
     * @return array Retorna os dados da solicitação de criação de token de cartão.
     */
    public function getData(): array
    {
        if ($this->getCard()) {
            $data = $this->getCardData();
        } else {
            $data = [
                '' => '',
            ];
        }

        return $data;
    }
    
    /**
     * Obtém o endpoint para a solicitação de criação de token de cartão.
     *
     * @return string Retorna o endpoint para a solicitação de criação de token de cartão.
     */
    public function getEndpoint(): string
    {
        return $this->endpoint().'1/card';
    }
}
