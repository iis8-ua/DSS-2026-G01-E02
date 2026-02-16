<?php
namespace App\Enums;

enum EstadoReserva: string {
    case PENDIENTE = 'PENDIENTE';
    case ACEPTADA = 'ACEPTADA';
    case RECHAZADA = 'RECHAZADA';
    case CANCELADA = 'CANCELADA';
    case FINALIZADA = 'FINALIZADA';
}
