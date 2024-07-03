<?php

namespace TechChallenge\Api;

class Controller
{
    protected function return($content = '', $status = 200)
    {
        return response($content, $status, ["Content-Type: application/json", "Accept: application/json"]);
    }
}
