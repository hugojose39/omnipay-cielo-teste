# Omnipay: Cielo

**Gateway Cielo para biblioteca de processamento de pagamentos Omnipay PHP**

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

[Omnipay](https://github.com/thephpleague/omnipay) é um sistema de pagamento multigateway independente de estrutura biblioteca de processamento para PHP 5.3+. Este pacote implementa suporte Cielo para Omnipay.

## Instalar

Via Composer

``` bash
$ composer require hugojose39/omnipay-cielo-teste
```

## Uso básico

O seguinte gateway é fornecido por este pacote:

 * [Cielo](https://cielo.com.br/)

Para obter instruções gerais de uso, consulte o [Omnipay](https://github.com/thephpleague/omnipay) principal
repositório.

### Exemplo de transação autorizada com Cartão de crédito
``` php
    // Crie um gateway para o Cielo Gateway
    // (rotas para GatewayFactory::create)
    $gateway = Omnipay::create('Cielo');
  
    // Inicialize o gateway
    $gateway->initialize([
        'merchantId' => 'MyMerchantId',
        'merchantKey' => 'MyMerchantKey',
    ]);
  
    // Crie um objeto de cartão
    // Ele será usado nos testes
    $card = [
      'CardNumber' =>'4551870000000183',
      'Holder' =>'Teste Holder',
      'ExpirationDate' =>'12/2021',
      'SecurityCode' =>'123',
      'Brand' =>'Visa'
    ];
  
    // Crie um objeto de cliente
    // Ele será usado nos testes
    $customer = [
      'Name' => 'Comprador Teste Boleto',
      'Identity' => '1234567890',
      'Address' => [
          'Street' => 'Avenida Marechal Câmara',
          'Number' => '160',
          'Complement' => 'Sala 934',
          'ZipCode' => '22750012',
          'District' => 'Centro',
          'City' => 'Rio de Janeiro',
          'State' => 'RJ',
          'Country' => 'BRA'
      ],
    ];
  
    // Faça uma transação autorizada no gateway
    $transaction = $gateway->authorize([
        'amount'           => '10.00',
        'soft_descriptor'  => 'test',
        'payment_method'   => 'CreditCard',
        'installments'     => 5,
        'card'             => $card,
        'customer'         => $customer
    ]);
  
    $response = $transaction->send();
  
    if ($response->isSuccessful()) {
        echo "Transação autorizada com sucesso!\n";
        $saleId = $response->getTransactionReference();
        $customerData = $response->getCustomerReference();
        $cardData = $response->getCardReference();
    }
```

### Exemplo de transação autorizada com Boleto

``` php
    // Crie um gateway para o Cielo Gateway
    // (rotas para GatewayFactory::create)
    $gateway = Omnipay::create('Cielo');
    // Inicialize o gateway
    $gateway->initialize([
        'merchantId' => 'MyMerchantId',
        'merchantKey' => 'MyMerchantKey',
    ]);

    // Crie um objeto de cliente
    // Ele será usado nos testes
    $customer = [
      'Name' => 'Comprador Teste Boleto',
      'Identity' => '1234567890',
      'Address' => [
          'Street' => 'Avenida Marechal Câmara',
          'Number' => '160',
          'Complement' => 'Sala 934',
          'ZipCode' => '22750012',
          'District' => 'Centro',
          'City' => 'Rio de Janeiro',
          'State' => 'RJ',
          'Country' => 'BRA'
      ],
    ];

    // Faça uma transação autorizada no gateway
    $transaction = $gateway->authorize([
        'amount'           => '10.00',
        'provider'         => 'Bradesco',
        'payment_method'   => 'Boleto',
        'customer'         => $customer
    ]);

    $response = $transaction->send();

    if ($response->isSuccessful()) {
        echo "Transação autorizada com sucesso!\n";
        $saleId = $response->getTransactionReference();
        $customerData = $response->getCustomerReference();
        $boletoData = $response->getBoleto();
    }
```

### Exemplo de transação com Cartão de crédito
``` php
    // Crie um gateway para o Cielo Gateway
    // (rotas para GatewayFactory::create)
    $gateway = Omnipay::create('Cielo');
  
    // Inicialize o gateway
    $gateway->initialize([
        'merchantId' => 'MyMerchantId',
        'merchantKey' => 'MyMerchantKey',
    ]);
  
    // Crie um objeto de cartão
    // Ele será usado nos testes
    $card = [
      'CardNumber' =>'4551870000000183',
      'Holder' =>'Teste Holder',
      'ExpirationDate' =>'12/2021',
      'SecurityCode' =>'123',
      'Brand' =>'Visa'
    ];
  
    // Crie um objeto de cliente
    // Ele será usado nos testes
    $customer = [
      'Name' => 'Comprador Teste Boleto',
      'Identity' => '1234567890',
      'Address' => [
          'Street' => 'Avenida Marechal Câmara',
          'Number' => '160',
          'Complement' => 'Sala 934',
          'ZipCode' => '22750012',
          'District' => 'Centro',
          'City' => 'Rio de Janeiro',
          'State' => 'RJ',
          'Country' => 'BRA'
      ],
    ];
  
    // Faça uma transação no gateway
    $transaction = $gateway->purchase([
        'amount'           => '10.00',
        'soft_descriptor'  => 'test',
        'payment_method'   => 'CreditCard',
        'installments'     => 5,
        'card'             => $card,
        'customer'         => $customer
    ]);
  
    $response = $transaction->send();
  
    if ($response->isSuccessful()) {
        echo "Transação efetuada com sucesso!\n";
        $saleId = $response->getTransactionReference();
        $customerData = $response->getCustomerReference();
        $cardData = $response->getCardReference();
    }
```

### Exemplo de transação com Boleto

``` php
    // Crie um gateway para o Cielo Gateway
    // (rotas para GatewayFactory::create)
    $gateway = Omnipay::create('Cielo');
    // Inicialize o gateway
    $gateway->initialize([
        'merchantId' => 'MyMerchantId',
        'merchantKey' => 'MyMerchantKey',
    ]);

    // Crie um objeto de cliente
    // Ele será usado nos testes
    $customer = [
      'Name' => 'Comprador Teste Boleto',
      'Identity' => '1234567890',
      'Address' => [
          'Street' => 'Avenida Marechal Câmara',
          'Number' => '160',
          'Complement' => 'Sala 934',
          'ZipCode' => '22750012',
          'District' => 'Centro',
          'City' => 'Rio de Janeiro',
          'State' => 'RJ',
          'Country' => 'BRA'
      ],
    ];

    // Faça uma transação autorizada no gateway
    $transaction = $gateway->purchase([
        'amount'           => '10.00',
        'provider'         => 'Bradesco',
        'payment_method'   => 'Boleto',
        'customer'         => $customer
    ]);

    $response = $transaction->send();

    if ($response->isSuccessful()) {
        echo "Transação efetuada com sucesso!\n";
        $saleId = $response->getTransactionReference();
        $customerData = $response->getCustomerReference();
        $boletoData = $response->getBoleto();
    }
```

### Exemplo de captura de transação
``` php
    // Crie um gateway para o Cielo Gateway
    // (rotas para GatewayFactory::create)
    $gateway = Omnipay::create('Cielo');
  
    // Inicialize o gateway
    $gateway->initialize([
        'merchantId' => 'MyMerchantId',
        'merchantKey' => 'MyMerchantKey',
    ]);
  
    // Capture uma transação no gateway
    $transaction = $gateway->capture([
        'amount'                => '10.00',
        'transactionReference'  => '123456',
    ]);
  
    $response = $transaction->send();
  
    if ($response->isSuccessful()) {
        echo "Transação capturada com sucesso!\n";
        $saleId = $response->getTransactionReference();
    }
```

### Exemplo de ctokenização do cartão
``` php
    // Crie um gateway para o Cielo Gateway
    // (rotas para GatewayFactory::create)
    $gateway = Omnipay::create('Cielo');
  
    // Inicialize o gateway
    $gateway->initialize([
        'merchantId' => 'MyMerchantId',
        'merchantKey' => 'MyMerchantKey',
    ]);
  
    // Capture uma transação no gateway
    $transaction = $gateway->createTokenCard([
        'card' => [
            'CustomerName' => 'Comprador Teste Cielo',
            'CardNumber' => '4532117080573700',
            'Holder' => 'Comprador T Cielo',
            'ExpirationDate' => '12/2030',
            'Brand' => 'Visa',
        ],
    ]);
  
    $response = $transaction->send();
  
    if ($response->isSuccessful()) {
        echo "Token criado com sucesso!\n";
        $cardData = $response->getCardReference();
    }
```

## Modo de teste

Para utilizar a API da Cielo em diferentes modos, como teste ou produção, é importante estar ciente de que existem endpoints distintos para cada ambiente. Ao inicializar o gateway, você pode configurar o modo de teste fornecendo o parâmetro testMode como true. Isso permite que você se conecte aos endpoints de teste, garantindo que as transações ocorram em um ambiente controlado para fins de desenvolvimento e depuração.

## Licença

Este projeto é licenciado sob a Licença MIT.
