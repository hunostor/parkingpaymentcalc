<?php
/**
 * Created by PhpStorm.
 * User: hunostor
 * Date: 2018. 03. 03.
 * Time: 19:27
 */

namespace Calculator;


use DateTime;

class ParkingPaymentCalculator
{
    private $cash = 0;

    /**
     * @var int
     */
    private $firstFreeMinutes = 180;

    /**
     * @var int
     */
    private $firstFreeHours = 3;


    /**
     * @var int
     */
    private $halfHourCost = 100;

    /**
     * @var int
     */
    private $firstHourCost = 200;

    /**
     * @var int
     */
    private $allPaidHours = 8;

    /**
     *
     */
    const PAY_FREE = 0;

    /**
     * @param DateTime $start
     * @param DateTime $end
     * return void
     */
    public function payment(DateTime $start, DateTime $end)
    {
        $diff = $this->calcTimeDiffInterval($start, $end);

        $minutes = $this->calcElapsedMinutes($diff);

        $this->calcFreeZone($minutes);

        $this->calcOverOneHourFreeZone($minutes);

        $this->calcHalfHourPaid($minutes);
    }

    /**
     * @param $minutes int
     * return void
     */
    private function calcHalfHourPaid($minutes)
    {
        if ($minutes > $this->calcRestHoursInMinutes()) {
            $halfHours = ceil((($minutes - $this->calcRestHoursInMinutes()) / 30));

            if ($halfHours > $this->countHalfHours()) {
                $cash = $this->countHalfHours() * $this->halfHourCost;
                $this->cash = $this->cash + $cash;
            } else {
                $cash = $halfHours * $this->halfHourCost;
                $this->cash = $this->cash + $cash;
            }

        }
    }

    /**
     * @param $minutes int
     * return void
     */
    private function calcOverOneHourFreeZone($minutes)
    {
        if($minutes > $this->firstFreeMinutes) {
            $this->cash = $this->firstHourCost;
        }
    }

    /**
     * @param $minutes int
     * return void
     */
    private function calcFreeZone($minutes)
    {
        if ($minutes <= $this->firstFreeMinutes) {
            $this->cash = self::PAY_FREE;
        }
    }

    /**
     * @param \DateInterval $difference
     * @return int
     */
    private function calcElapsedMinutes(\DateInterval $difference)
    {
        return ($difference->h * 60) + $difference->i;
    }

    /**
     * @return int
     */
    private function calcRestHoursInMinutes()
    {
        return ($this->firstFreeHours + 1) * 60;
    }

    /**
     * @return int
     */
    private function countHalfHours()
    {
        return ($this->allPaidHours - ($this->firstFreeHours + 1)) * 2;
    }

    /**
     * @param DateTime $start
     * @param DateTime $end
     * @return bool|\DateInterval
     */
    private function calcTimeDiffInterval(DateTime $start, DateTime $end)
    {
        return $end->diff($start);
    }

    /**
     * @return int
     */
    public function getCash()
    {
        return (int) $this->cash;
    }

    /**
     * @param $hours int
     */
    public function setFirstFreeHours($hours)
    {
        $this->firstFreeHours = $hours;
        $this->firstFreeMinutes = $hours * 60;
    }

    /**
     * @param $huf int
     */
    public function setHalfHourCost($huf)
    {
        $this->halfHourCost = $huf;
    }

    /**
     * @param $hours int
     */
    public function setAllPaidHours($hours)
    {
        $this->allPaidHours = $hours;
    }
}