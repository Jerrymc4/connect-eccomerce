<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreController extends Controller
{
    /**
     * Display a listing of the stores.
     */
    public function index(Request $request)
    {
        $query = Store::query();

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('owner_email', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhereHas('domains', function($q) use ($search) {
                      $q->where('domain', 'like', "%{$search}%");
                  });
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Apply sorting
        $sortField = $request->sort ?? 'created_at';
        $sortDirection = $request->direction ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        // Get results with pagination
        $stores = $query->with('domains')->paginate(10)->withQueryString();

        return view('admin.stores.index', [
            'stores' => $stores
        ]);
    }

    /**
     * Show the form for creating a new store.
     */
    public function create()
    {
        $owners = User::where('user_type', User::TYPE_STORE_OWNER)->get();
        
        return view('admin.stores.create', [
            'owners' => $owners
        ]);
    }

    /**
     * Store a newly created store in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:domains,domain',
            'owner_email' => 'required|email',
            'owner_name' => 'nullable|string|max:255',
            'owner_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive,pending',
            'description' => 'nullable|string',
            'business_name' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'logo_url' => 'nullable|url',
        ]);

        // Generate a slug from the name
        $validated['slug'] = Str::slug($validated['name']);

        // Create the store
        $store = Store::createStore(
            $validated['name'], 
            $validated['domain'], 
            $validated['owner_email'], 
            collect($validated)->except(['name', 'domain', 'owner_email'])->toArray()
        );

        // If owner_id is provided, update the owner
        if (!empty($validated['owner_id'])) {
            $owner = User::find($validated['owner_id']);
            if ($owner) {
                $store->updateOwner($owner);
            }
        }

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store created successfully.');
    }

    /**
     * Display the specified store.
     */
    public function show(Store $store)
    {
        $store->load('domains');
        
        // If there's an owner, load them
        if ($store->owner_id) {
            $store->load('owner');
        }
        
        return view('admin.stores.show', [
            'store' => $store
        ]);
    }

    /**
     * Show the form for editing the specified store.
     */
    public function edit(Store $store)
    {
        $store->load('domains');
        $owners = User::where('user_type', User::TYPE_STORE_OWNER)->get();
        
        return view('admin.stores.edit', [
            'store' => $store,
            'owners' => $owners
        ]);
    }

    /**
     * Update the specified store in storage.
     */
    public function update(Request $request, Store $store)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique('domains', 'domain')->ignore($store->domains->first()->id ?? null)
            ],
            'owner_email' => 'required|email',
            'owner_name' => 'nullable|string|max:255',
            'owner_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive,pending',
            'description' => 'nullable|string',
            'business_name' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'logo_url' => 'nullable|url',
        ]);

        // Update the store details
        $store->name = $validated['name'];
        $store->slug = Str::slug($validated['name']);
        $store->status = $validated['status'];
        $store->description = $validated['description'];
        $store->business_name = $validated['business_name'];
        $store->tax_id = $validated['tax_id'];
        $store->phone = $validated['phone'];
        $store->email = $validated['email'];
        $store->address_line1 = $validated['address_line1'];
        $store->address_line2 = $validated['address_line2'];
        $store->city = $validated['city'];
        $store->state = $validated['state'];
        $store->postal_code = $validated['postal_code'];
        $store->country = $validated['country'];
        $store->logo_url = $validated['logo_url'];
        $store->owner_email = $validated['owner_email'];
        $store->owner_name = $validated['owner_name'];
        $store->save();

        // Update domain if changed
        $currentDomain = $store->domains->first();
        if ($currentDomain && $currentDomain->domain !== $validated['domain']) {
            $currentDomain->domain = $validated['domain'];
            $currentDomain->save();
        }

        // If owner_id is provided, update the owner
        if (!empty($validated['owner_id'])) {
            $owner = User::find($validated['owner_id']);
            if ($owner) {
                $store->updateOwner($owner);
            }
        }

        return redirect()->route('admin.stores.show', $store)
            ->with('success', 'Store updated successfully.');
    }

    /**
     * Remove the specified store from storage.
     */
    public function destroy(Store $store)
    {
        // This is a potentially dangerous operation, so we might want to add additional confirmation
        try {
            $store->delete();
            return redirect()->route('admin.stores.index')
                ->with('success', 'Store deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete store: ' . $e->getMessage());
        }
    }
} 