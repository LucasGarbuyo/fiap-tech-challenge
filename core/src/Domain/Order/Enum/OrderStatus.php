<?php

namespace TechChallenge\Domain\Order\Enum;

enum OrderStatus: string
{
    case RECEIVED = "Recebido";
    case IN_PREPARATION = 'Em preparação';
    case READY = 'Pronto';
    case FINISHED = 'Finalizado';
}
