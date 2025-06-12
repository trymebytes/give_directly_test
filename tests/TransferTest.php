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
        $actual_result = $this->transferGenerator()->generateTransfer("monthly", "2024-03-20", 300.00, 3);
        $expected_result = [
            ['date' => '2024-03-20', 'amount' => 100.00],
            ['date' => '2024-04-20', 'amount' => 100.00],
            ['date' => '2024-05-20', 'amount' => 100.00],
        ];
        $this->assertEquals($expected_result, $actual_result);

    }
    
}