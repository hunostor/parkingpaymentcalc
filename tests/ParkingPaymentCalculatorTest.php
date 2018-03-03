<?php
/**
 * Created by PhpStorm.
 * User: hunostor
 * Date: 2018. 03. 03.
 * Time: 19:11
 */


class ParkingPaymentCalculatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Calculator\ParkingPaymentCalculator
     */
    private $parking;

    public function setUp()
    {
        $this->parking = new \Calculator\ParkingPaymentCalculator();
    }

    public function testIN180minGracePeriodFree()
    {
        $start = new DateTime('2018-03-03 18:18:20');
        $end = new DateTime('2018-03-03 19:18:20');

        $this->parking->payment($start, $end);

        $this->assertSame(0, $this->parking->getCash());

        $start = new DateTime('2018-03-03 15:18:20');
        $end = new DateTime('2018-03-03 18:18:20');

        $this->parking->payment($start, $end);

        $this->assertSame(0, $this->parking->getCash());
    }

    public function testOUT180minGracePeriodFree()
    {
        $start = new DateTime('2018-03-03 15:18:20');
        $end = new DateTime('2018-03-03 18:39:20');

        $this->parking->payment($start, $end);

        $this->assertSame(200, $this->parking->getCash());
    }

    public function testFirstHourAfterFreeTimeThis200Ft()
    {
        $start = new DateTime('2018-03-03 15:18:20');
        $end = new DateTime('2018-03-03 18:19:20');

        $this->parking->payment($start, $end);

        $this->assertSame(200, $this->parking->getCash());
    }

    public function testOverOneHourFirstPaymentTime()
    {
        $start = new DateTime('2018-03-03 15:18:20');
        $end = new DateTime('2018-03-03 19:19:20');

        $this->parking->payment($start, $end);

        $this->assertSame(300, $this->parking->getCash());
    }

    public function testOverOneHourFirstPaymentTimePlus7HalfHour()
    {
        $start = new DateTime('2018-03-03 12:18:20');
        $end = new DateTime('2018-03-03 19:19:20');

        $this->parking->payment($start, $end);

        $this->assertSame(900, $this->parking->getCash());
    }

    public function testFullCalculate8hourOneDay()
    {
        $start = new DateTime('2018-03-03 10:18:20');
        $end = new DateTime('2018-03-03 19:19:20');

        $this->parking->payment($start, $end);

        $this->assertSame(1000, $this->parking->getCash());

        $start = new DateTime('2018-03-03 09:18:20');
        $end = new DateTime('2018-03-03 19:19:20');

        $this->parking->payment($start, $end);

        $this->assertSame(1000, $this->parking->getCash());
    }
}