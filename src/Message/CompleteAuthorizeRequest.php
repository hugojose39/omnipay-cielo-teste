<?php

namespace Omnipay\CieloTest\Message;

/**
 * Classe CompleteAuthorizeRequest
 *
 * Esta classe representa uma solicitação de conclusão de autorização no gateway Cielo.
 * 
 * @see \Omnipay\CieloTest\Message\AbstractRequest
 */
class CompleteAuthorizeRequest extends AbstractRequest
{
    /**
     * Obtém os dados da solicitação
     *
     * @return array Retorna os dados da solicitação de conclusão de autorização.
     */
    public function getData(): array
    {
        $data = [];

        return $data;
    }
}
