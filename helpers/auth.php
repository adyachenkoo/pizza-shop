<?php

use Illuminate\Support\Str;

if (!function_exists('generate_guest_token')) {
    function generate_guest_token(): string
    {
        return Str::uuid()->toString();
    }
}
