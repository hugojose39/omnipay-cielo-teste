<?php

namespace Omnipay\CieloTest\Message;

/**
 * Classe AcceptNotificationRequest
 *
 * Esta classe representa uma solicitação para aceitar notificações do gateway Cielo.
 * 
 * @see \Omnipay\CieloTest\Message\AbstractRequest
 */
class AcceptNotificationRequest extends AbstractRequest
{
    /**
     * Obtém os dados da solicitação
     *
     * @return array Retorna um array vazio, pois não são necessários dados para aceitar notificações.
     */
    public function getData(): array
    {
        $data = [
            '' => '',
        ];

        return $data;
    }
}
