<?php
namespace GiveDirectly;

use DateTime;
use Exception;
use GiveDirectly\Cadence;

class TransferGenerator {
    /**
     * Generate a series of transfers based on the cadence, start date, amount, and count.
     *
     * @param string $cadence "weekly" or "monthly"
     * @param string $start_date The start date in 'Y-m-d' format
     * @param float $amount The amount for each transfer
     * @param int $count The number of transfers to generate
     * @return array An array of transfers with date and amount
     */
    public function generateTransfer(string $cadence, string $start_date, float $amount, int $count): array{
        $transfers = [];
        $date = new DateTime($start_date);
        $start_day = $date->format('d');

        for ($i = 0; $i < $count; $i++) {
            $transfers[] = [
                'date' => $date->format('Y-m-d'),
                'amount' => number_format($amount, 2)
            ];
            $this->incrementDate($cadence, $date, $start_day);
        }
        return $transfers;
    }

    /**
     * Increment the date based on the cadence.
     *
     * @param string $cadence "weekly" or "monthly"
     * @param DateTime $date The current date to increment
     * @param string $start_day The original start day of the month
     * @throws Exception If the cadence is invalid
     */
    private function incrementDate(string $cadence, DateTime $date, string $start_day) {
        switch ($cadence) {
            case 'weekly':
                Cadence::handleCadence('weekly', $date, $start_day);
                break;
            case 'monthly':
                Cadence::handleCadence('monthly', $date, $start_day);
                break;
            case 'quarterly':
                Cadence::handleCadence('quarterly', $date, $start_day);
                break;
            case 'biannual':
                Cadence::handleCadence('biannual', $date, $start_day);
                break;
            case 'annual':
                Cadence::handleCadence('annual', $date, $start_day);
                break;
            default:
                throw new Exception("Invalid cadence. Use 'weekly' or 'monthly'.");
        }
    }
}
