<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Contracts\Repositories\StoreRepositoryInterface;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * @var StoreRepositoryInterface
     */
    protected $storeRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Display a listing of the stores.
     */
    public function index()
    {
        $stores = $this->storeRepository->getAllWithDomains();
        return view('stores.index', compact('stores'));
    }
} 