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

        for ($i = 0; $i < $count; $i++) {
            $transfers[] = [
                'date' => $date->format('Y-m-d'),
                'amount' => number_format($amount, 2)
            ];
            if ($cadence === 'weekly') {
                $date->modify('+1 week');
            } else {
                $date->modify('+1 month');
            }
        }
        return $transfers;
    }
}

