<?php
namespace App\Traits;

use App\Models\Setting;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Exception\FirebaseException;

trait MiscHelper
{

  public function calc_distance($p1, $p2)
  {
    $r = 6378137;
    $dLat = deg2rad($p2['latitude'] - $p1['latitude']);
    $dLong = deg2rad($p2['longitude'] - $p1['longitude']);

    $a = sin($dLat / 2) * sin($dLat / 2) +
      cos(deg2rad($p1['latitude'])) * cos(deg2rad($p2['latitude'])) *
      sin($dLong / 2) * sin($dLong / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $d = $r * $c;
    return $d;
  }

  public function calc_price($distance)
  {

    $price_per_km = Setting::where('name', 'price_per_km')->value('value');
    $min_price = Setting::where('name', 'min_price')->value('value');
    $max_price = Setting::where('name', 'max_price')->value('value');

    $true_price = ($distance / 1000) * $price_per_km;
    $price = min(max($true_price, $min_price),$max_price);
    return $price;
  }

}
