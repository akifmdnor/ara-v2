<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WebService;

class IndexController extends Controller
{
    protected $webService;

    public function __construct(WebService $webService)
    {
        $this->webService = $webService;
    }

    /**
     * Display the web index page with homepage data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $homepageData = $this->webService->getHomepageData();

        return view('web.landing.index', $homepageData);
    }
}
