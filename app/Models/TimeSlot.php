<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    public function containsPeriod($timePeriod)
    {
        $edgesA = self::getParts($this->time);
        $edgesB = self::getParts($timePeriod);

        return (($edgesB[0] >= $edgesA[0]) && $edgesB[2] <= $edgesA[2]);
    }

    /**
     * Get the beginning and end of a given time period
     *
     * @param string $timePeriod Time period
     * @return array Parts of given time period
     */
    public static function getParts($timePeriod)
    {
        preg_match('/(0?\d{1,2}):(\d{2})\s*\-\s*(\d{2}):(\d{2})/', $timePeriod, $matches);

        return array_slice($matches, 1);
    }

}
