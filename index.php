<?php
/**
 * Created by PhpStorm.
 * User: hunostor
 * Date: 2018. 03. 03.
 * Time: 19:09
 */

require 'vendor/autoload.php';

$calc = new \Calculator\ParkingPaymentCalculator();
$start = new DateTime('2018-03-03 12:18:20');
$end = new DateTime('2018-03-03 19:19:20');

var_dump($calc->payment($start, $end));

//Számítás az alábbiak szerint:
//Belépést követöen van 180mp türelmi idő. Addig ha kiléptetem nincs fizetési kötelezetség.
//Ezt követöen az első óra 200Ft
//után minden megkezdett fél óra
//100Ft
//Maximum 8 -óra díja számítható. ha 12 -t tölt bent akkor is csak 800Ft a díj. Ez az alap napi jegy is. ezért.
//amennyiben valaki "bennalvos"
//minden nap 800ft/ nap

