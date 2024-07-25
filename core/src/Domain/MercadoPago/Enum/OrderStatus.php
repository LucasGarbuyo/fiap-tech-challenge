<?php

namespace TechChallenge\Domain\Order\Enum;

enum OrderStatus: string
{
    case NEW = "NEW";
    case RECEIVED = "RECEIVED";
    case PAID = "PAID";
    case IN_PREPARATION = "IN_PREPARATION";
    case READY = "READY";
    case FINISHED = "FINISHED";
    case CANCELED = "CANCELED";
}
