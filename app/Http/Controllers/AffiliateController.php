<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Repositories\AffiliateRepository;
use App\Classes\ApiResponseClass;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    private AffiliateRepository $affiliateRepository;
    
    public function __construct(AffiliateRepository $affiliateRepository)
    {
        $this->affiliateRepository = $affiliateRepository;
    }

    /**
     * Display affiliates within range.
     */
    public function index()
    {
        $data = $this->affiliateRepository->filter(100);

	return ApiResponseClass::sendResponse($data,'',200);
    }
}
