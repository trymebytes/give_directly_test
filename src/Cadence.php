<?php
namespace GiveDirectly;

use DateTime;
use Exception;

class Cadence {
    private  static array $allowed_cadences = [
        'weekly' => ['cadence_number' => 1, 'cadence_modifier' => '+1 week'],
        'monthly' => ['cadence_number' => 1, 'cadence_modifier' => '+1 month'],
        'quarterly' => ['cadence_number' => 3, 'cadence_modifier' => '+3 months'],
        'biannual' => ['cadence_number' => 6, 'cadence_modifier' => '+6 months'],
    ];
    

    /**
     * Handle the cadence for a given date.
     * 
     * @param string $cadence The cadence type (weekly, monthly, quarterly, biannual)
     * @param DateTime $date The date to modify
     * @param string $start_day The start day of the month (1-31)
     * @throws Exception If the cadence is invalid or if the start day is not valid for the new month
     * @return void
     */
    public static function handleCadence(string $cadence, DateTime $date, string $start_day): void {
        if (!self::validateCadence($cadence)) {
            throw new Exception("Invalid cadence: " . $cadence);
        }

        if ($cadence == 'weekly') {
            $date->modify('+1 week');
            return;
        }

        $cadence_number = self::$allowed_cadences[$cadence]['cadence_number'];
        $cadence_modifier = self::$allowed_cadences[$cadence]['cadence_modifier'];

        $current_month = (int)$date->format('n');
        $next_month = $current_month + $cadence_number;
        
        if ($next_month > 12) {
            $next_month -= 12;
        }

        $date->modify($cadence_modifier);

        if( $date->format('n') != $next_month ) {
            // If the current day is not the start day, set to the start day of the previous month
            $date->modify('last day of previous month');
        } 

        // Check if the start day is valid for the new month
        if( checkdate($date->format('m'), $start_day, $date->format('Y') ) ) {
            $date->setDate($date->format('Y'), $date->format('m'), $start_day);
        }
    }

    /**
     * Validate the cadence against the allowed cadences.
     * 
     * @param string $cadence The cadence to validate
     * @return bool True if valid, otherwise throws an exception
     */
    private static function validateCadence(string $cadence): bool {
        if (empty($cadence)) {
            throw new Exception("Cadence cannot be empty.");
        }
        if (!array_key_exists($cadence, self::$allowed_cadences)) {
            throw new Exception("Invalid cadence: " . $cadence);
        }
        return true;
    }
}