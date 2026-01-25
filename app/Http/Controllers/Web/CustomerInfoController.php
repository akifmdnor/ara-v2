<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerInfoController extends Controller
{
    /**
     * Display the customer information form.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get car details from session or request
        // For now, we'll use dummy data similar to AddOnController
        $carDetails = [
            'id' => $request->car_model_id ?? 1,
            'name' => 'Perodua Myvi 1.5H',
            'brand_logo' => asset('images/ara-logo.png'),
            'image' => asset('images/ara-logo.png'),
            'group' => 'A',
            'category' => 'Compact',
            'pickup_location' => $request->pickup_location ?? 'Bandar Puteri, Puchong, Selangor',
            'return_location' => $request->return_location ?? 'Subang Jaya',
            'pickup_date' => $request->pickup_date ?? '05-05-2024, 9:00 AM',
            'return_date' => $request->return_date ?? '07-05-2024, 9:00 AM',
            'rental_days' => 2,
            'rental_price' => 400.00,
            'door_to_door_delivery' => 18.00,
            'door_to_door_pickup' => 18.00,
            'discount' => 0.00,
            'total_price' => 436.00,
            'tax_amount' => 26.16,
            'security_deposit' => 300.00,
            'is_promo' => false,
            'promo_percentage' => 0,
        ];

        return view('web.customer-info.index', compact('carDetails'));
    }

    /**
     * Get countries list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountries()
    {
        try {
            // Using REST Countries API (free)
            $response = Http::timeout(10)->get('https://restcountries.com/v3.1/all?fields=name,cca2,idd');

            if ($response->successful()) {
                $countries = collect($response->json())->map(function ($country) {
                    $root = $country['idd']['root'] ?? '';
                    $suffixes = $country['idd']['suffixes'] ?? [];

                    // Handle multiple calling codes (take the first one)
                    $callingCode = '';
                    if (!empty($suffixes)) {
                        $callingCode = $root . $suffixes[0];
                    } elseif (!empty($root)) {
                        $callingCode = $root;
                    }

                    return [
                        'name' => $country['name']['common'],
                        'code' => $country['cca2'],
                        'calling_code' => $callingCode,
                    ];
                })->filter(function ($country) {
                    // Include countries with 1, 2, or 3 digit calling codes
                    return preg_match('/^\+\d{1,3}$/', $country['calling_code']);
                })->sortBy('name')->values();

                return response()->json(['countries' => $countries]);
            }

            // Fallback to static list if API fails
            return $this->getFallbackCountries();

        } catch (\Exception $e) {
            return $this->getFallbackCountries();
        }
    }

    /**
     * Get states/provinces for a country using CountriesNow API
     *
     * @param string $countryCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStates($countryCode)
    {
        try {
            // First, get the country name from our cached countries data
            $countryName = $this->getCountryNameByCode($countryCode);

            if (!$countryName) {
                return response()->json(['states' => []]);
            }

            // Call CountriesNow API
            $response = Http::timeout(10)->post('https://countriesnow.space/api/v0.1/countries/states', [
                'country' => $countryName
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['data']['states']) && is_array($data['data']['states'])) {
                    $states = array_map(function ($state) {
                        return $state['name'] ?? $state;
                    }, $data['data']['states']);

                    return response()->json(['states' => $states]);
                }
            }

            // If API fails, fallback to hardcoded states
            return $this->getFallbackStates($countryCode);

        } catch (\Exception $e) {
            // If API fails, fallback to hardcoded states
            return $this->getFallbackStates($countryCode);
        }
    }

    /**
     * Get country name by country code from our cached countries
     *
     * @param string $countryCode
     * @return string|null
     */
    private function getCountryNameByCode($countryCode)
    {
        // Cache the countries data to avoid repeated API calls
        static $countriesCache = null;

        if ($countriesCache === null) {
            try {
                $response = Http::timeout(10)->get('https://restcountries.com/v3.1/all?fields=name,cca2');
                if ($response->successful()) {
                    $countriesCache = collect($response->json())->mapWithKeys(function ($country) {
                        return [$country['cca2'] => $country['name']['common']];
                    })->toArray();
                }
            } catch (\Exception $e) {
                $countriesCache = [];
            }
        }

        return $countriesCache[strtoupper($countryCode)] ?? null;
    }

    /**
     * Fallback states for when API fails
     *
     * @param string $countryCode
     * @return \Illuminate\Http\JsonResponse
     */
    private function getFallbackStates($countryCode)
    {
        $states = [];

        // Malaysia states
        if (strtoupper($countryCode) === 'MY') {
            $states = [
                'Johor',
                'Kedah',
                'Kelantan',
                'Kuala Lumpur',
                'Labuan',
                'Melaka',
                'Negeri Sembilan',
                'Pahang',
                'Penang',
                'Perak',
                'Perlis',
                'Putrajaya',
                'Sabah',
                'Sarawak',
                'Selangor',
                'Terengganu'
            ];
        }
        // Singapore (no states, just Singapore)
        elseif (strtoupper($countryCode) === 'SG') {
            $states = ['Singapore'];
        }
        // Indonesia provinces
        elseif (strtoupper($countryCode) === 'ID') {
            $states = [
                'Aceh',
                'Bali',
                'Bangka Belitung',
                'Banten',
                'Bengkulu',
                'Central Java',
                'Central Kalimantan',
                'Central Sulawesi',
                'East Java',
                'East Kalimantan',
                'East Nusa Tenggara',
                'Gorontalo',
                'Jakarta',
                'Jambi',
                'Lampung',
                'Maluku',
                'North Kalimantan',
                'North Maluku',
                'North Sulawesi',
                'North Sumatra',
                'Papua',
                'Riau',
                'Riau Islands',
                'South East Sulawesi',
                'South Kalimantan',
                'South Sulawesi',
                'South Sumatra',
                'West Java',
                'West Kalimantan',
                'West Nusa Tenggara',
                'West Papua',
                'West Sulawesi',
                'West Sumatra',
                'Yogyakarta'
            ];
        }
        // Thailand provinces
        elseif (strtoupper($countryCode) === 'TH') {
            $states = [
                'Amnat Charoen',
                'Ang Thong',
                'Bangkok',
                'Bueng Kan',
                'Buriram',
                'Chachoengsao',
                'Chai Nat',
                'Chaiyaphum',
                'Chanthaburi',
                'Chiang Mai',
                'Chiang Rai',
                'Chonburi',
                'Chumphon',
                'Kalasin',
                'Kamphaeng Phet',
                'Kanchanaburi',
                'Khon Kaen',
                'Krabi',
                'Lampang',
                'Lamphun',
                'Loei',
                'Lopburi',
                'Mae Hong Son',
                'Maha Sarakham',
                'Mukdahan',
                'Nakhon Nayok',
                'Nakhon Pathom',
                'Nakhon Phanom',
                'Nakhon Ratchasima',
                'Nakhon Sawan',
                'Nakhon Si Thammarat',
                'Nan',
                'Narathiwat',
                'Nong Bua Lamphu',
                'Nong Khai',
                'Nonthaburi',
                'Pathum Thani',
                'Pattani',
                'Phang Nga',
                'Phatthalung',
                'Phayao',
                'Phetchabun',
                'Phetchaburi',
                'Phichit',
                'Phitsanulok',
                'Phra Nakhon Si Ayutthaya',
                'Phrae',
                'Phuket',
                'Prachinburi',
                'Prachuap Khiri Khan',
                'Ranong',
                'Ratchaburi',
                'Rayong',
                'Roi Et',
                'Sa Kaeo',
                'Sakon Nakhon',
                'Samut Prakan',
                'Samut Sakhon',
                'Samut Songkhram',
                'Saraburi',
                'Satun',
                'Sing Buri',
                'Sisaket',
                'Songkhla',
                'Sukhothai',
                'Suphan Buri',
                'Surat Thani',
                'Surin',
                'Tak',
                'Trang',
                'Trat',
                'Ubon Ratchathani',
                'Udon Thani',
                'Uthai Thani',
                'Uttaradit',
                'Yala',
                'Yasothon'
            ];
        }
        // For other countries, return empty array
        else {
            $states = [];
        }

        return response()->json(['states' => $states]);
    }

    /**
     * Fallback countries list if API fails
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function getFallbackCountries()
    {
        // Comprehensive fallback with accurate calling codes (1, 2, or 3 digits)
        $countries = [
            ['name' => 'Malaysia', 'code' => 'MY', 'calling_code' => '+60'],
            ['name' => 'Singapore', 'code' => 'SG', 'calling_code' => '+65'],
            ['name' => 'Indonesia', 'code' => 'ID', 'calling_code' => '+62'],
            ['name' => 'Thailand', 'code' => 'TH', 'calling_code' => '+66'],
            ['name' => 'United States', 'code' => 'US', 'calling_code' => '+1'],
            ['name' => 'United Kingdom', 'code' => 'GB', 'calling_code' => '+44'],
            ['name' => 'India', 'code' => 'IN', 'calling_code' => '+91'],
            ['name' => 'Australia', 'code' => 'AU', 'calling_code' => '+61'],
            ['name' => 'Canada', 'code' => 'CA', 'calling_code' => '+1'],
            ['name' => 'Germany', 'code' => 'DE', 'calling_code' => '+49'],
            ['name' => 'France', 'code' => 'FR', 'calling_code' => '+33'],
            ['name' => 'Japan', 'code' => 'JP', 'calling_code' => '+81'],
            ['name' => 'South Korea', 'code' => 'KR', 'calling_code' => '+82'],
            ['name' => 'China', 'code' => 'CN', 'calling_code' => '+86'],
            ['name' => 'Brazil', 'code' => 'BR', 'calling_code' => '+55'],
            ['name' => 'Mexico', 'code' => 'MX', 'calling_code' => '+52'],
            ['name' => 'Russia', 'code' => 'RU', 'calling_code' => '+7'],
            ['name' => 'Italy', 'code' => 'IT', 'calling_code' => '+39'],
            ['name' => 'Spain', 'code' => 'ES', 'calling_code' => '+34'],
            ['name' => 'Netherlands', 'code' => 'NL', 'calling_code' => '+31'],
            ['name' => 'Belgium', 'code' => 'BE', 'calling_code' => '+32'],
            ['name' => 'Switzerland', 'code' => 'CH', 'calling_code' => '+41'],
            ['name' => 'Austria', 'code' => 'AT', 'calling_code' => '+43'],
            ['name' => 'Denmark', 'code' => 'DK', 'calling_code' => '+45'],
            ['name' => 'Sweden', 'code' => 'SE', 'calling_code' => '+46'],
            ['name' => 'Norway', 'code' => 'NO', 'calling_code' => '+47'],
            ['name' => 'Poland', 'code' => 'PL', 'calling_code' => '+48'],
            ['name' => 'Czech Republic', 'code' => 'CZ', 'calling_code' => '+420'],
            ['name' => 'Portugal', 'code' => 'PT', 'calling_code' => '+351'],
        ];

        return response()->json(['countries' => $countries]);
    }

    /**
     * Store customer information and proceed to payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required|string|max:5',
            'phone' => 'required|string|max:20',
            'id_number' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        // Store customer info in session
        session(['customer_info' => $validated]);

        // Redirect to payment page
        return redirect()->route('payment.index');
    }
}
