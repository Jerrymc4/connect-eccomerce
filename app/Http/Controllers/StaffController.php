<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Staff;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Services\StoreAuthService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    protected $storeAuthService;

    public function __construct(StoreAuthService $storeAuthService)
    {
        $this->storeAuthService = $storeAuthService;
        $this->middleware('store.connection');
    }

    /**
     * Display a listing of staff members.
     */
    public function index()
    {
        // Check permission
        if (!$this->storeAuthService->hasPermission('view_staff')) {
            abort(403, 'Unauthorized');
        }

        $staff = Staff::with('roles')->get();
        
        return view('staff.index', [
            'staff' => $staff
        ]);
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create()
    {
        // Check permission
        if (!$this->storeAuthService->hasPermission('manage_staff')) {
            abort(403, 'Unauthorized');
        }

        $roles = Role::all();
        
        return view('staff.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created staff member.
     */
    public function store(Request $request)
    {
        // Check permission
        if (!$this->storeAuthService->hasPermission('manage_staff')) {
            abort(403, 'Unauthorized');
        }

        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'is_admin' => 'boolean',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
        ]);

        // Set default for is_admin if not provided
        $validated['is_admin'] = $request->has('is_admin') ? true : false;

        // Create the staff member
        DB::beginTransaction();
        try {
            $staff = Staff::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'is_admin' => $validated['is_admin'],
                'phone' => $validated['phone'] ?? null,
                'position' => $validated['position'] ?? null,
                'status' => 'active',
            ]);

            // Assign role if selected
            if ($request->has('role_id')) {
                $staff->roles()->attach($request->role_id);
            }

            DB::commit();
            return redirect()->route('staff.index')->with('success', 'Staff member created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create staff member: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified staff member.
     */
    public function show(Staff $staff)
    {
        // Check permission
        if (!$this->storeAuthService->hasPermission('view_staff')) {
            abort(403, 'Unauthorized');
        }

        return view('staff.show', [
            'staff' => $staff->load('roles')
        ]);
    }

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit(Staff $staff)
    {
        // Check permission
        if (!$this->storeAuthService->hasPermission('manage_staff')) {
            abort(403, 'Unauthorized');
        }

        $roles = Role::all();
        
        return view('staff.edit', [
            'staff' => $staff->load('roles'),
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified staff member.
     */
    public function update(Request $request, Staff $staff)
    {
        // Check permission
        if (!$this->storeAuthService->hasPermission('manage_staff')) {
            abort(403, 'Unauthorized');
        }

        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string',
            'is_admin' => 'boolean',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'status' => 'required|string|in:active,inactive',
        ]);

        // Set default for is_admin if not provided
        $validated['is_admin'] = $request->has('is_admin') ? true : false;

        // Update the staff member
        DB::beginTransaction();
        try {
            $staff->name = $validated['name'];
            $staff->email = $validated['email'];
            $staff->role = $validated['role'];
            $staff->is_admin = $validated['is_admin'];
            $staff->phone = $validated['phone'] ?? null;
            $staff->position = $validated['position'] ?? null;
            $staff->status = $validated['status'];
            
            // Only update password if provided
            if (!empty($validated['password'])) {
                $staff->password = Hash::make($validated['password']);
            }
            
            $staff->save();

            // Update roles if provided
            if ($request->has('role_id')) {
                $staff->roles()->sync($request->role_id);
            }

            DB::commit();
            return redirect()->route('staff.index')->with('success', 'Staff member updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update staff member: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Promote staff member to admin.
     */
    public function promoteToAdmin(Staff $staff)
    {
        // Check permission - only store owners should be able to do this
        if (!$this->storeAuthService->isAuthenticatedAsOwner()) {
            abort(403, 'Only store owners can promote staff to admin');
        }

        try {
            $storeId = session('current_store_id');
            $store = Store::findOrFail($storeId);
            
            $this->storeAuthService->promoteToStoreAdmin($staff, $store);
            
            return redirect()->route('staff.index')->with('success', 'Staff member promoted to admin successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to promote staff member: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified staff member.
     */
    public function destroy(Staff $staff)
    {
        // Check permission
        if (!$this->storeAuthService->hasPermission('manage_staff')) {
            abort(403, 'Unauthorized');
        }

        try {
            $staff->delete();
            return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete staff member: ' . $e->getMessage()]);
        }
    }
} 