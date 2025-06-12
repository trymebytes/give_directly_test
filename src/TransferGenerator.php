<?php
namespace GiveDirectly;

use DateTime;
use Exception;

class TransferGenerator {
    /**
     * Generate a series of transfers based on the cadence, start date, amount, and count.
     *
     * @param string $cadence "weekly" or "monthly"
     * @param string $start_date The start date in 'Y-m-d' format
     * @param float $amount The amount for each transfer
     * @param int $count The number of transfers to generate
     * @return array An array of transfers with date and amount
     * @throws Exception If the cadence is invalid
     */
    public function generateTransfer(string $cadence, string $start_date, float $amount, int $count): array{
        if (!in_array($cadence, ['weekly', 'monthly'])) {
            throw new Exception("Invalid cadence. Use 'weekly' or 'monthly'.");
        }

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
                $date->modify('+1 week');
                break;
            case 'monthly':
                $this->handleMonthlyCadence($date, $start_day);
                break;
            default:
                throw new Exception("Invalid cadence. Use 'weekly' or 'monthly'.");
        }
    }

    /**
     * Handle the logic for monthly cadence, including irregular months.
     *
     * @param DateTime $date The current date to increment
     * @param string $start_day The original start day of the start date
     */
    private function handleMonthlyCadence(DateTime $date, string $start_day) {
        // If the current start day is different from the original start day
        if ($start_day !== $date->format('d')) {
            $date->modify('first day of next month');
            $date->setDate($date->format('Y'), $date->format('m'), $start_day);
            return;
        } 
        // Handle the case where the current day count does not exist in the next month(e.g., 31st in February)
        $nextMonth = clone $date;
        $nextMonth->modify('+1 month');
        $month_skipped = (intval($nextMonth->format('n')) - intval($date->format('n'))) > 1 ? true : false;
        if ($month_skipped) {
            // If a month was skipped, set to the last day of the skipped month
            $date->modify('last day of next month'); 
        } else {
            // Otherwise, just add one month
            $date->modify('+1 month');
        }
    }
}

