<?php

namespace App\Enums;

/**
 * MetricInterval
 *
 * @category Enum
 * @package  App\Enums
 * @author   Thomas van der Westen <post@thomasvanderwesten.nl>
 * @license  MIT https://opensource.org/licenses/MIT
 */
enum MetricInterval: string
{
    case Minute = 'minute';
    case Hourly = 'hourly';
    case Daily = 'daily';
    case Weekly = 'weekly';
    case Monthly = 'monthly';
}
