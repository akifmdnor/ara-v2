<?php

namespace App\Services;

use DateTime;

class DateTimeService
{
    /**
     * Get days between two dates
     *
     * @param string $fromDate
     * @param string $toDate
     * @param bool $ignoreExtraHours
     * @return int
     */
    public function getDays(string $fromDate, string $toDate, bool $ignoreExtraHours = false): int
    {
        $fromDateObj = DateTime::createFromFormat('d/m/Y h:i A', $fromDate);
        $toDateObj = DateTime::createFromFormat('d/m/Y h:i A', $toDate);

        $interval = $toDateObj->diff($fromDateObj);

        $days = (int) $interval->format('%a');
        $hours = (int) $interval->format('%h');

        if ($hours >= 5 && !$ignoreExtraHours) {
            $days = $days + 1;
            $hours = 0;
        }

        return $days;
    }

    /**
     * Get hours between two dates
     *
     * @param string $fromDate
     * @param string $toDate
     * @param bool $ignoreExtraHours
     * @return int
     */
    public function getHours(string $fromDate, string $toDate, bool $ignoreExtraHours = false): int
    {
        $fromDateObj = DateTime::createFromFormat('d/m/Y h:i A', $fromDate);
        $toDateObj = DateTime::createFromFormat('d/m/Y h:i A', $toDate);

        $interval = $toDateObj->diff($fromDateObj);
        $days = (int) $interval->format('%a');
        $hours = (int) $interval->format('%h');

        if ($hours >= 5 && !$ignoreExtraHours) {
            $days = $days + 1;
            $hours = 0;
        }

        return $hours;
    }

    /**
     * Generate duration title string
     *
     * @param int $totalDay
     * @param int $totalHour
     * @return string
     */
    public function durationTitle(int $totalDay, int $totalHour): string
    {
        // Check hour if equal/higher than 6 calculate as one day
        if ($totalHour == 0) {
            $rentDuration = $totalDay . ' ' . 'Days ';
        } else {
            $rentDuration = $totalDay . ' ' . 'Days ' . $totalHour . ' Hours';
        }

        return $rentDuration;
    }
}
