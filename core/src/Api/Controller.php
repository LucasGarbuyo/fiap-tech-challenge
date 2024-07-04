<?php

namespace TechChallenge\Api;

class Controller
{
    protected function return(mixed $data = [], int $status = 200)
    {
        return response()->json($data, $status, ["Content-Type: application/json", "Accept: application/json"]);
    }
}
