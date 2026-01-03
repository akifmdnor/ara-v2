<?php

namespace App\Http\Controllers\Web\Listing;

use App\Http\Controllers\Controller;
use App\Repositories\BranchRepository;
use App\Repositories\ModelSpecificationRepository;
use App\Services\CarListingService;
use App\Services\MapBoxService;
use App\Services\DateTimeService;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    protected $branchRepository;
    protected $modelSpecificationRepository;
    protected $carListingService;
    protected $mapBoxService;
    protected $dateTimeService;

    public function __construct(
        BranchRepository $branchRepository,
        ModelSpecificationRepository $modelSpecificationRepository,
        CarListingService $carListingService,
        MapBoxService $mapBoxService,
        DateTimeService $dateTimeService
    ) {
        $this->branchRepository = $branchRepository;
        $this->modelSpecificationRepository = $modelSpecificationRepository;
        $this->carListingService = $carListingService;
        $this->mapBoxService = $mapBoxService;
        $this->dateTimeService = $dateTimeService;
    }

    public function branch($id, Request $request)
    {
        $pickupLocation = $request->pickup_location;
        $returnLocation = $request->return_location;

        // Set default return location if not provided
        if ($request->get('return_location') == null) {
            $request->request->add(['return_location' => $request->get('pickup_location')]);
            $request->request->add(['return_latitude' => $request->get('pickup_latitude')]);
            $request->request->add(['return_longitude' => $request->get('pickup_longitude')]);
        }

        // Validate required date/time parameters
        if (!$request->get('pickup_date') || !$request->get('pickup_time') ||
            !$request->get('return_date') || !$request->get('return_time')) {
            return redirect('/');
        }

        $pickupDateTime = str_replace('-', '/', $request->get('pickup_date')) . ' ' . $request->get('pickup_time');
        $returnDateTime = str_replace('-', '/', $request->get('return_date')) . ' ' . $request->get('return_time');

        // Get branches within distance
        $branches = $this->branchRepository->getAll();
        $branchDistances = $this->mapBoxService->getBranchDistanceMapbox(
            $branches,
            $request->get('pickup_latitude'),
            $request->get('pickup_longitude'),
            $request->get('pickup_location')
        );

        $branchesWithinDistance = [];
        foreach ($branches as $key => $branch) {
            $distance = $branchDistances[$key] ?? null;
            if (isset($distance) && $distance < 50 && $distance != 0) {
                $branchesWithinDistance[] = $branch->id;
            }
        }

        // Get model specification
        $modelSpec = $this->modelSpecificationRepository->getModelSpecificationWithPictures($id);
        if (!$modelSpec) {
            abort(404);
        }

        // Get car models for this model spec within the distance
        $carModels = $this->carListingService->getCarModelsByModelSpec(
            $modelSpec->id,
            $branchesWithinDistance,
            $pickupDateTime,
            $returnDateTime,
            $request->only(['pickup_latitude', 'pickup_longitude', 'pickup_location']),
            $request->only(['return_latitude', 'return_longitude', 'return_location'])
        );

        // Process included array for display
        $modelSpec->includedArray = preg_split('/<br[^>]*>/i', $modelSpec->included);

        return view('web.page3', compact('modelSpec', 'carModels', 'pickupLocation', 'returnLocation'));
    }
}
