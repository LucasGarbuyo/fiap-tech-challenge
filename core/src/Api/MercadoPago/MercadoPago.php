<?php

namespace TechChallenge\Api\MercadoPago;

use Illuminate\Http\Request;
use TechChallenge\Api\Controller;
use TechChallenge\Application\DTO\MercadoPago\DtoInput as MercadoPagoDtoInput;
use TechChallenge\Adapters\Controllers\MercadoPago\Update as ControllerMercadoPagoUpdate;
use Throwable;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class MercadoPago extends Controller
{

  public function updatePayment(Request $request, string $id)
  {
   
    try {
      $dto = new MercadoPagoDtoInput(
        $id,
        $request->transaction_amount,
        $request->token,
        $request->description,
        $request->installments,
        $request->payment_method_id,
        $request->payer_email,
        $request->order_id
      );

      (new ControllerMercadoPagoUpdate($this->AbstractFactoryRepository))->execute($dto);

      return $this->return(null, 204);
    } catch (DefaultException $e) {
      return $this->return(
        [
          "error" => [
            "message" => $e->getMessage()
          ]
        ],
        $e->getStatus()
      );
    } catch (Throwable $e) {
      return $this->return(
        [
          "error" => [
            "message" => $e->getMessage()
          ]
        ],
        400
      );
    }
  }

  /*

  public function createPayment(Request $request)
  {
    try {
      $dto = new MercadoPagoPaymentDto(
        $request->transaction_amount,
        $request->token,
        $request->description,
        $request->installments,
        $request->payment_method_id,
        $request->payer_email,
        $request->order_id
      );

      $payment = $this->mercadoPagoService->createPayment($dto);

      return response()->json(['message' => 'Payment created successfully', 'payment' => $payment], 200);
    } catch (Throwable $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function createPreference(Request $request)
  {
    try {
      $dto = new MercadoPagoPreferenceDto(
        $request->title,
        $request->quantity,
        $request->unit_price
      );

      $preference = $this->mercadoPagoService->createPreference($dto);

      return response()->json(['message' => 'Preference created successfully', 'preference' => $preference], 200);
    } catch (Throwable $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
    */
}
