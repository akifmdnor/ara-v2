<?php

namespace App\Services;

use App\Models\CarModel;
use App\Models\ModelSpecification;
use DateTime;

class AvailabilityService
{
    /**
     * Check if a car model is unavailable during the specified period
     *
     * @param CarModel $carModel
     * @param string $pickupDateTime
     * @param string $returnDateTime
     * @return bool
     */
    public function checkCarModelUnavailable(CarModel $carModel, string $pickupDateTime, string $returnDateTime): bool
    {
        $unavailable = true;

        foreach ($carModel->cars as $car) {
            $available = !$this->checkCarUnavailable($car, $pickupDateTime, $returnDateTime);
            // If any car is available, the model is available
            if ($available) {
                $unavailable = false;
            }
        }

        return $unavailable;
    }

    /**
     * Check if a specific car is unavailable during the specified period
     *
     * @param mixed $car
     * @param string $pickupDateTime
     * @param string $returnDateTime
     * @return bool
     */
    public function checkCarUnavailable($car, string $pickupDateTime, string $returnDateTime): bool
    {
        $pickupDateTimeObj = DateTime::createFromFormat('d/m/Y h:i A', $pickupDateTime);
        $returnDateTimeObj = DateTime::createFromFormat('d/m/Y h:i A', $returnDateTime);

        $unavailable = false;

        foreach ($car->unavailablePeriods as $unavailablePeriod) {
            $start = new DateTime($unavailablePeriod->start);
            $end = new DateTime($unavailablePeriod->end);

            if ($start < $returnDateTimeObj && $end > $pickupDateTimeObj) {
                return true;
            }
        }

        return $unavailable;
    }

    /**
     * Check if a model specification is unavailable during the specified period
     *
     * @param ModelSpecification $modelSpec
     * @param string $pickupDateTime
     * @param string $returnDateTime
     * @param array $branchIds
     * @return bool
     */
    public function checkModelSpecUnavailable(ModelSpecification $modelSpec, string $pickupDateTime, string $returnDateTime, array $branchIds): bool
    {
        $unavailable = true;

        foreach ($modelSpec->car_models as $carModel) {
            if (in_array($carModel->branch_id, $branchIds) && !$carModel->is_deactive) {
                $available = !$this->checkCarModelUnavailable($carModel, $pickupDateTime, $returnDateTime);
                if ($available) {
                    $unavailable = false;
                }
            }
        }

        return $unavailable;
    }
}
