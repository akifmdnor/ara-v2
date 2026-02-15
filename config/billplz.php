<?php
// You can find the keys here : https://www.billplz.com/api/
return [
	'BILLPLZ_API_URL'             => env('BILLPLZ_API_URL','https://www.billplz.com/api'),
	'BILLPLZ_API_VERSION'         => env('BILLPLZ_API_VERSION', 'v3'),
	'BILLPLZ_USE_SSL'             => false,
	'BILLPLZ_API_KEY'     		  => env('BILLPLZ_API_KEY', ''),
	'BILLPLZ_COLLECTION_ID'       => env('BILLPLZ_COLLECTION_ID', ''),
];