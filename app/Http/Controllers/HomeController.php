<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Contracts\Repositories\StoreRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     * Show the application dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->user_type === User::TYPE_ADMIN) {
            return view('admin.dashboard');
        }
        
        if ($user->user_type === User::TYPE_STORE_OWNER) {
            $store = $this->storeRepository->getByOwner($user);
            
            if (!$store) {
                return view('admin.dashboard');
            }
            
            $domain = $store->domains->first();
            
            if ($domain) {
                return redirect()->away("https://{$domain->domain}");
            }
            
            return view('admin.dashboard');
        }
        
        return view('admin.dashboard');
    }
} 