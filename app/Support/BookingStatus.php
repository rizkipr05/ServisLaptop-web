<?php

namespace App\Support;

class BookingStatus
{
    public const PENDING   = 'pending';
    public const CONFIRMED = 'confirmed';
    public const DIAGNOSED = 'diagnosed';
    public const IN_REPAIR = 'in_repair';
    public const READY     = 'ready';
    public const COMPLETED = 'completed';
    public const CANCELLED = 'cancelled';

    public static function all(): array
    {
        return [
            self::PENDING,
            self::CONFIRMED,
            self::DIAGNOSED,
            self::IN_REPAIR,
            self::READY,
            self::COMPLETED,
            self::CANCELLED,
        ];
    }
}
