<?php

namespace Omnipay\CieloTest\Message;

/**
 * Classe CreateCardRequest
 *
 * Esta classe representa uma solicitação de criação de cartão no gateway Cielo.
 * 
 * @see \Omnipay\CieloTest\Message\AbstractRequest
 */
class CreateCardRequest extends AbstractRequest
{
    /**
     * Obtém os dados da solicitação
     *
     * @return array Retorna os dados da solicitação de criação de cartão.
     */
    public function getData(): array
    {
        $data = [];

        return $data;
    }
}
