<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Arr;

final class Pronouns
{
    protected static string $ae_aer = 'ae/aer';
    protected static string $e_em = 'e/em';
    protected static string $he_him = 'he/him';
    protected static string $per_per = 'per/per';
    protected static string $she_her = 'she/her';
    protected static string $they_them = 'they/them';
    protected static string $ve_ver = 've/ver';
    protected static string $xe_xem = 'xe_xem';
    protected static string $ze_hir = 'ze_hir';

    /**
     * @return array<int,string>
     */
    public static function all(): array
    {
        return [
            static::$ae_aer,
            static::$e_em,
            static::$he_him,
            static::$per_per,
            static::$she_her,
            static::$they_them,
            static::$ve_ver,
            static::$xe_xem,
            static::$ze_hir,
        ];
    }

    /**
     * @return string
     */
    public static function random(): string
    {
        return strval(Arr::random(array: static::all()));
    }
}
