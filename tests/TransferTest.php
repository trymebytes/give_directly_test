<?php

use PHPUnit\Framework\TestCase;
use GiveDirectly\TransferGenerator;

class TransferTest extends TestCase
{
    private function transferGenerator(): TransferGenerator
    {
        return new TransferGenerator();
    }

    public function test_weekly_transfer(): void
    {
        $actual_result   = $this->transferGenerator()->generateTransfer("weekly", "2024-04-20", 100.00, 3);
        $expected_result = [
            ['date' => '2024-04-20', 'amount' => 100.00],
            ['date' => '2024-04-27', 'amount' => 100.00],
            ['date' => '2024-05-04', 'amount' => 100.00],
        ];
        $this->assertEquals($expected_result, $actual_result);
    }

    public function test_monthly_transfer(): void
    {
        $actual_result   = $this->transferGenerator()->generateTransfer("monthly", "2024-03-20", 100.00, 3);
        $expected_result = [
            ['date' => '2024-03-20', 'amount' => 100.00],
            ['date' => '2024-04-20', 'amount' => 100.00],
            ['date' => '2024-05-20', 'amount' => 100.00],
        ];
        $this->assertEquals($expected_result, $actual_result);
    }

    public function test_monthly_transfer_for_single_irregular_months(): void
    {
        $actual_result   = $this->transferGenerator()->generateTransfer("monthly", "2024-01-30", 100.00, 3);
        $expected_result = [
            ['date' => '2024-01-30', 'amount' => 100.00],
            ['date' => '2024-02-29', 'amount' => 100.00],
            ['date' => '2024-03-30', 'amount' => 100.00],
        ];
        $this->assertEquals($expected_result, $actual_result);
    }


    public function test_monthly_transfer_for_multiple_irregular_months(): void
    {
        $actual_result   = $this->transferGenerator()->generateTransfer("monthly", "2024-01-31", 100.00, 7);
        $expected_result = [
            ['date' => '2024-01-31', 'amount' => 100.00],
            ['date' => '2024-02-29', 'amount' => 100.00],
            ['date' => '2024-03-31', 'amount' => 100.00],
            ['date' => '2024-04-30', 'amount' => 100.00],
            ['date' => '2024-05-31', 'amount' => 100.00],
            ['date' => '2024-06-30', 'amount' => 100.00],
            ['date' => '2024-07-31', 'amount' => 100.00],
        ];
        $this->assertEquals($expected_result, $actual_result);
    }

    public function test_quarterly_transfer(): void
    {
        $actual_result   = $this->transferGenerator()->generateTransfer("quarterly", "2024-12-31", 100.00, 6);
        $expected_result = [
            ['date' => '2024-12-31', 'amount' => 100.00],
            ['date' => '2025-03-31', 'amount' => 100.00],
            ['date' => '2025-06-30', 'amount' => 100.00],
            ['date' => '2025-09-30', 'amount' => 100.00],
            ['date' => '2025-12-31', 'amount' => 100.00],
            ['date' => '2026-03-31', 'amount' => 100.00],
        ];
        $this->assertEquals($expected_result, $actual_result);
    }

    public function test_biannual_transfer(): void
    {
        $actual_result   = $this->transferGenerator()->generateTransfer("biannual", "2024-01-01", 100.00, 2);
        $expected_result = [
            ['date' => '2024-01-01', 'amount' => 100.00],
            ['date' => '2024-07-01', 'amount' => 100.00],
        ];
        $this->assertEquals($expected_result, $actual_result);
    }

    public function test_annual_transfer(): void
    {
        $actual_result   = $this->transferGenerator()->generateTransfer("annual", "2024-01-01", 100.00, 2);
        $expected_result = [
            ['date' => '2024-01-01', 'amount' => 100.00],
            ['date' => '2025-01-01', 'amount' => 100.00],
        ];
        $this->assertEquals($expected_result, $actual_result);
    }
}
