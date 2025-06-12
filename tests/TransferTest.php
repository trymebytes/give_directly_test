<?php
use PHPUnit\Framework\TestCase;
use GiveDirectly\TransferGenerator;

class TransferTest extends TestCase {
    private function transferGenerator(): TransferGenerator {
        return new TransferGenerator();
    }

    public function test_weekly_transfer(): void {
        $actual_result = $this->transferGenerator()->generateTransfer("weekly", "2024-04-20", 100.00, 3);
        $expected_result = [
                ['date' => '2024-04-20', 'amount' => 100.00],
                ['date' => '2024-04-27', 'amount' => 100.00],
                ['date' => '2024-05-04', 'amount' => 100.00],
        ];
        $this->assertEquals($expected_result, $actual_result);
    }

    public function test_monthly_transfer(): void {
        $actual_result = $this->transferGenerator()->generateTransfer("monthly", "2024-03-20", 100.00, 3);
        $expected_result = [
            ['date' => '2024-03-20', 'amount' => 100.00],
            ['date' => '2024-04-20', 'amount' => 100.00],
            ['date' => '2024-05-20', 'amount' => 100.00],
        ];
        $this->assertEquals($expected_result, $actual_result);
    }

    public function test_transfer_for_one_irregular_months(): void {
        $actual_result = $this->transferGenerator()->generateTransfer("monthly", "2024-01-30", 100.00, 3);
        $expected_result = [
            ['date' => '2024-01-30', 'amount' => 100.00],
            ['date' => '2024-02-29', 'amount' => 100.00],
            ['date' => '2024-03-30', 'amount' => 100.00],
        ];
        $this->assertEquals($expected_result, $actual_result);
    }


    public function test_transfer_for__multiple_irregular_months(): void {
        $actual_result = $this->transferGenerator()->generateTransfer("monthly", "2024-01-31", 100.00, 7);
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
    
}