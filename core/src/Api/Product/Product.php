<?php

namespace TechChallenge\Api\Product;

use Illuminate\Http\Request;
use TechChallenge\Api\Controller;
use TechChallenge\Adapters\Controllers\Product\Index as ControllerProductIndex;
use TechChallenge\Adapters\Controllers\Product\Show as ControllerProductShow;
use TechChallenge\Infra\DB\Eloquent\Product\DAO as EloquentProductDAO;
use Throwable;

use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class Product extends Controller
{
    public function index()
    {
        try {
            $results = (new ControllerProductIndex(new EloquentProductDAO()))->execute([]);

            return $this->return($results, 200);
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

    public function show(Request $request, string $id)
    {
        try {
            $result = (new ControllerProductShow(new EloquentProductDAO()))->execute($id);

            return $this->return($result, 200);
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
}
