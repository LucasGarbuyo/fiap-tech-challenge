<?php

namespace TechChallenge\Api\MercadoPago;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use MercadoPago\Client\CardToken\CardTokenClient;
use GuzzleHttp\Exception\RequestException;
use MercadoPago\Config\MPConfig;
use MercadoPago\Exceptions\MPApiException;
use GuzzleHttp\Client;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Entity\Payment\PaymentCreateRequest;
use MercadoPago\Http\Adapter\GuzzleHttpAdapter;
use MercadoPago\Client\Common\RequestOptions;

class MercadoPago extends Controller
{
  public function handle(Request $request)
  {

    // Log the request for debugging
    Log::info('Mercado Pago Webhook received:', [$request->all()]);

    $cardToken = $this->processPayment($request);

    dd($cardToken->id);
  }

  public function processPayment(Request $request)
  {
    // Configura o SDK do MercadoPago com seu token de acesso
    $accessToken = config('services.mercadopago.access_token');
    $requestOptions = new RequestOptions();
    $requestOptions->setAccessToken($accessToken);

    // Dados do cartão enviados pela solicitação
    $data = [
      'card_number' => $request->input('card_number'),
      'expiration_month' => $request->input('expiration_month'),
      'expiration_year' => $request->input('expiration_year'),
      'security_code' => $request->input('security_code'),
      'cardholder' => [
        'name' => $request->input('cardholder_name'),
        'identification' => [
          'type' => $request->input('identification_type'),
          'number' => $request->input('identification_number'),
        ],
      ],
    ];

    try {
      // Cria o cliente de token de cartão
      $cardTokenClient = new CardTokenClient();

      // Envia a requisição para gerar o token de cartão
      $cardToken = $cardTokenClient->create($data, $requestOptions);

      // Retorna o token de cartão gerado
      return $cardToken; //response()->json($cardToken);
    } catch (MPApiException $e) {
      // Captura a resposta de erro
      $errorResponse = json_decode($e->getMessage(), true);
      return response()->json(['error' => $errorResponse], $e->getCode());
    } catch (\Exception $e) {
      // Trata outras exceções
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }
}
/*



{
  "additional_info": {
    "items": [
      {
        "id": "MLB1915344730",
        "title": "Point Mini",
        "description": "Point product for card payments via Bluetooth.",
        "picture_url": "https://http2.mlstatic.com/resources/frontend/statics/growth-sellers-landings/device-mlb-point-i_medium2x.png",
        "category_id": "electronics",
        "quantity": 1,
        "unit_price": 58.8,
        "type": "electronics",
        "event_date": "2023-12-31T09:37:52.000-04:00",
        "warranty": false,
        "category_descriptor": {
          "passenger": {},
          "route": {}
        }
      }
    ],
    "payer": {
      "first_name": "Test",
      "last_name": "Test",
      "phone": {
        "area_code": 11,
        "number": "987654321"
      },
      "address": {
        "street_number": null
      }
    },
    "shipments": {
      "receiver_address": {
        "zip_code": "12312-123",
        "state_name": "Rio de Janeiro",
        "city_name": "Buzios",
        "street_name": "Av das Nacoes Unidas",
        "street_number": 3003
      }
    }
  },
  "application_fee": null,
  "binary_mode": false,
  "campaign_id": null,
  "capture": true,
  "coupon_amount": 58.8,
  "description": "Hot Dog",
  "differential_pricing_id": null,
  "external_reference": "MP0001",
  "installments": 1,
  "metadata": null,
  "payer": {
    "entity_type": "individual",
    "type": "customer",
    "id": null,
    "email": "test_user_123@testuser.com",
    "identification": {
      "type": "CPF",
      "number": "95749019047"
    }
  },
  "payment_method_id": "pix",
  "token": "6ce2bdc0f2d9672cd2b56bda8579e7d2",
  "transaction_amount": 58.8
}


https://api.mercadopago.com/v1/payments
*/
