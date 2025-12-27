<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\RecentBooking;
use App\Models\CarModel;
use App\Models\HomepageManager;
use App\Models\CustomerReview;

class SearchController extends Controller
{
    /**
     * Display the web index page with homepage data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        return view('web.search');

    }
}
