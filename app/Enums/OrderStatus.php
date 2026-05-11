<?php

namespace App\Enums;

class OrderStatus
{
    const ENVIADO = 'enviado';
    const ENTREGUE = 'entregue';
    const PENDENTE = 'pendente';
    const AGUARDANDO = 'aguardando_pagamento';
    const PAGO = 'pago';
    const CANCELADO = 'cancelado';
    const VENCIDO = 'vencido';
}
