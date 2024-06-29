<?php

namespace TechChallenge\Adapter\Driver\Api\V1;

class Controller
{
    protected function return($data = [], $status = 200)
    {
        return response()->json($data, $status, ["Content-Type: application/json", "Accept: application/json"]);
    }
}
