<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\CarModel;
use App\Services\MapBoxService;
use App\Services\SearchService;


class SearchController extends Controller
{
    protected $mapBoxService;
    protected $searchService;

    public function __construct(MapBoxService $mapBoxService, SearchService $searchService)
    {
        $this->mapBoxService = $mapBoxService;
        $this->searchService = $searchService;
    }
    /**
     * Display the web index page with homepage data.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $date = strtotime("+3 day");
        $pickupDateTime = date('d/m/Y h:i A');
        $dropoffDateTime = date('d/m/Y h:i A', $date);

        if ($request->get('return_location') == NULL) {
            $request->request->add(['return_location' => $request->get('pickup_location')]);
            $request->request->add(['return_latitude' => $request->get('pickup_latitude')]);
            $request->request->add(['return_longitude' => $request->get('pickup_longitude')]);
        }

        if ($request->get('pickup_date') != null && $request->get('pickup_time') != null && $request->get('return_date') != null && $request->get('return_time') != null) {

            $pickupDateTime = str_replace('-', '/', $request->get('pickup_date')) . ' ' . $request->get('pickup_time');
            $dropoffDateTime = str_replace('-', '/', $request->get('return_date')) . ' ' . $request->get('return_time');
        }

        $branches = Branch::get();
        $branchesWithin30 = array();

        //new mapbox
        $branchDistances = $this->mapBoxService->getBranchDistanceMapbox($branches, $request->get('pickup_latitude'), $request->get('pickup_longitude'), $request->get('pickup_location'));
        //dd($branchDistances);
        foreach ($branches as $key => $branch) {
            $distance = $branchDistances[$key];
            if (isset($distance) && $distance < 50 && $distance != 0) {
                $branchesWithin30[] = $branch->id;
            }
        }

        // Handle reset filter
        if ($request->has('reset')) {
            return redirect()->route('web.search', array_filter([
                'pickup_location' => $request->get('pickup_location'),
                'pickup_latitude' => $request->get('pickup_latitude'),
                'pickup_longitude' => $request->get('pickup_longitude'),
                'pickup_date' => $request->get('pickup_date'),
                'pickup_time' => $request->get('pickup_time'),
                'return_location' => $request->get('return_location'),
                'return_latitude' => $request->get('return_latitude'),
                'return_longitude' => $request->get('return_longitude'),
                'return_date' => $request->get('return_date'),
                'return_time' => $request->get('return_time'),
            ]));
        }

        $minPrice = $request->get('min_price') ?? 0;
        $maxPrice = $request->get('max_price') ?? 1500;

        $modelSpecs = $this->searchService->processCarSearch(
            $branchesWithin30,
            $pickupDateTime,
            $dropoffDateTime,
            $minPrice,
            $maxPrice,
            //asc
            $request->get('sort_by') ?? 'DESC',
            $request->get('category'),
            $request->get('brand')
        );

        $categories = $this->searchService->getCategories();
        $brands = $this->searchService->getBrands();
        return view('web.search.index', compact('modelSpecs', 'categories', 'brands'));

    }
}
