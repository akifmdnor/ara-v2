<?php

namespace App\Services;

use App\Models\CarModel;
use App\Models\SeasonalPrice;
use DateTime;

class PriceCalculationService
{
    /**
     * Calculate price based on rental duration
     *
     * @param CarModel|null $carModel
     * @param int $rentDays
     * @param int $hours
     * @return float
     */
    public function calculatePrice($carModel, int $rentDays, int $hours): float
    {
        if (!$carModel) {
            return 0;
        }

        $amount = 0;

        if ($rentDays == 1) {
            $amount = $carModel->price_day;
        } elseif ($rentDays == 2) {
            $amount = $carModel->price_day_2;
        } elseif ($rentDays == 3) {
            $amount = $carModel->price_day_3;
        } elseif ($rentDays == 4) {
            $amount = $carModel->price_day_4;
        } elseif ($rentDays == 5) {
            $amount = $carModel->price_day_5;
        } elseif ($rentDays == 6) {
            $amount = $carModel->price_day_6;
        } elseif ($rentDays >= 7 && $rentDays < 14) {
            $difference = $carModel->price_day_14 - $carModel->price_day_7;
            $differenceDay = $difference / 7;
            $dayTotal = $rentDays - 7;
            $amount = ($dayTotal * $differenceDay) + $carModel->price_day_7;
        } elseif ($rentDays >= 14 && $rentDays < 21) {
            $difference = $carModel->price_day_21 - $carModel->price_day_14;
            $differenceDay = $difference / 7;
            $dayTotal = $rentDays - 14;
            $amount = ($dayTotal * $differenceDay) + $carModel->price_day_14;
        } elseif ($rentDays >= 21 && $rentDays < 32) {
            $difference = $carModel->price_day_28 - $carModel->price_day_21;
            $differenceDay = $difference / 7;
            $dayTotal = $rentDays - 21;
            $amount = ($dayTotal * $differenceDay) + $carModel->price_day_21;
        } elseif ($rentDays > 31) {
            $dayTotal = $rentDays - 30;
            $amount = ($dayTotal * $carModel->price_day_after_month) + $carModel->price_day_28;
        }

        $amountHours = 0;
        if ($hours > 0) {
            $amountHours = $hours * $carModel->price_hours;
        }

        $finalAmount = $amount + $amountHours;
        return $finalAmount;
    }

    /**
     * Calculate car model price considering seasonal prices
     *
     * @param CarModel|null $carModel
     * @param string $pickupDateTime
     * @param string $returnDateTime
     * @return float
     */
    public function calculateCarModelPrice(?CarModel $carModel, string $pickupDateTime, string $returnDateTime): float
    {
        if (!$carModel) {
            return 0;
        }

        $totalAmount = 0;

        $pickupDateTimeObj = DateTime::createFromFormat('d/m/Y h:i A', $pickupDateTime);
        $returnDateTimeObj = DateTime::createFromFormat('d/m/Y h:i A', $returnDateTime);

        $seasonalPrices = SeasonalPrice::where('car_model_id', $carModel->id)
            ->where(function ($query) use ($pickupDateTimeObj, $returnDateTimeObj) {
                $query->where('start_date', '<=', $returnDateTimeObj)
                    ->orWhere('start_date', '<=', $pickupDateTimeObj);
            })
            ->where('end_date', '>=', $pickupDateTimeObj)
            ->get();

        $seasonalPrices = $seasonalPrices->sortBy('start_date');

        $currentDateTime = $pickupDateTimeObj;

        $totalRegularDays = 0;
        $totalRegularHours = 0;
        $totalSeasonalDays = 0;
        $totalRentDays = 0;
        $totalRentHours = 0;

        $totalRentDays = $this->getDays($pickupDateTime, $returnDateTime);
        $totalRentHours = $this->getHours($pickupDateTime, $returnDateTime);

        $pickupTimeHours = $pickupDateTimeObj->format('H');
        $pickupTimeMinutes = $pickupDateTimeObj->format('i');

        foreach ($seasonalPrices as $seasonalPrice) {
            $seasonalPrice->start_date_obj = DateTime::createFromFormat('Y-m-d', $seasonalPrice->start_date)->setTime($pickupTimeHours, $pickupTimeMinutes);
            $seasonalPrice->end_date_obj = DateTime::createFromFormat('Y-m-d', $seasonalPrice->end_date)->setTime($pickupTimeHours, $pickupTimeMinutes);

            if (!$seasonalPrice->start_date_obj || !$seasonalPrice->end_date_obj) {
                continue;
            }

            if ($currentDateTime < $seasonalPrice->start_date_obj) {
                $regularDays = $this->getDays($currentDateTime->format('d/m/Y h:i A'), $seasonalPrice->start_date_obj->format('d/m/Y h:i A'));
                $regularHours = $this->getHours($currentDateTime->format('d/m/Y h:i A'), $seasonalPrice->start_date_obj->format('d/m/Y h:i A'));

                $totalRegularDays += $regularDays;
                $totalRegularHours += $regularHours;

                $currentDateTime = $seasonalPrice->start_date_obj;
            }

            $overlapStart = max($currentDateTime, $seasonalPrice->start_date_obj);
            $overlapEnd = min($returnDateTimeObj, $seasonalPrice->end_date_obj);

            if (!$overlapStart || !$overlapEnd) {
                $overlapDays = 0;
                $overlapHours = 0;
            } else {
                $overlapStartString = $overlapStart->format('d/m/Y h:i A');
                $overlapEndString = $overlapEnd->format('d/m/Y h:i A');

                $overlapDays = $this->getDays($overlapStartString, $overlapEndString);
                $overlapHours = $this->getHours($overlapStart->format('d/m/Y h:i A'), $overlapEnd->format('d/m/Y h:i A'));

                $seasonalAmount = $this->calculatePrice($seasonalPrice, $overlapDays, $overlapHours);
                $totalAmount += $seasonalAmount;
                $totalSeasonalDays += $overlapDays;

                $currentDateTime = $seasonalPrice->end_date_obj;
            }
        }

        if ($currentDateTime < $returnDateTimeObj) {
            $regularDays = $this->getDays($currentDateTime->format('d/m/Y h:i A'), $returnDateTimeObj->format('d/m/Y h:i A'));
            $regularHours = $this->getHours($currentDateTime->format('d/m/Y h:i A'), $returnDateTimeObj->format('d/m/Y h:i A'));

            $totalRegularDays += $regularDays;
            $totalRegularHours += $regularHours;
        }

        if ($totalRegularDays == 0 && $totalRegularHours == 0) {
            $regularAmount = 0;
        } else {
            $regularAmount = ($this->calculatePrice($carModel, $totalRentDays, $totalRentHours) / $totalRentDays) * $totalRegularDays;
        }

        $totalAmount += $regularAmount;
        return $totalAmount;
    }

    /**
     * Check if there's a promo during the rental period
     *
     * @param CarModel|null $carModel
     * @param string $pickupDateTime
     * @param string $returnDateTime
     * @return bool
     */
    public function checkIsPickupAndReturnIsPromo(?CarModel $carModel, string $pickupDateTime, string $returnDateTime): bool
    {
        if (!$carModel) {
            return false;
        }

        $pickupDateTimeObj = DateTime::createFromFormat('d/m/Y h:i A', $pickupDateTime);
        $returnDateTimeObj = DateTime::createFromFormat('d/m/Y h:i A', $returnDateTime);

        $seasonalPrices = SeasonalPrice::where('car_model_id', $carModel->id)
            ->where(function ($query) use ($pickupDateTimeObj, $returnDateTimeObj) {
                $query->where('start_date', '<=', $returnDateTimeObj)
                    ->orWhere('start_date', '<=', $pickupDateTimeObj);
            })
            ->where('end_date', '>=', $pickupDateTimeObj)
            ->get();

        foreach ($seasonalPrices as $seasonalPrice) {
            if ($seasonalPrice->is_promo == 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get days between two dates
     *
     * @param string $fromDate
     * @param string $toDate
     * @param bool $ignoreExtraHours
     * @return int
     */
    private function getDays(string $fromDate, string $toDate, bool $ignoreExtraHours = false): int
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
    private function getHours(string $fromDate, string $toDate, bool $ignoreExtraHours = false): int
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
}
