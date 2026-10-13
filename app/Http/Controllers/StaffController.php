<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffMembers = Staff::with('user')->latest()->paginate(10);

        return view('staff.index', compact('staffMembers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Main user information
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],

            // Staff profile information
            'staff_code' => ['required', 'string', 'max:50', 'unique:staff,staff_code'],
            'phone' => ['nullable', 'string', 'max:20'],
            'designation' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'in:active,inactive,on_leave,suspended'],
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Create User account with role 'staff'
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'staff',
            ]);

            // 2. Create Staff profile referencing the new User ID
            Staff::create([
                'user_id' => $user->id,
                'staff_code' => $validated['staff_code'],
                'phone' => $validated['phone'] ?? null,
                'designation' => $validated['designation'] ?? null,
                'status' => $validated['status'] ?? 'active',
            ]);
        });

        return redirect()->route('staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        $staff->load('user');

        return view('staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        $staff->load('user');

        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            // Main user information
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $staff->user_id],
            'password' => ['nullable', 'string', 'min:6'],

            // Staff profile information
            'staff_code' => ['required', 'string', 'max:50', 'unique:staff,staff_code,' . $staff->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'designation' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'in:active,inactive,on_leave,suspended'],
        ]);

        DB::transaction(function () use ($staff, $validated) {
            // 1. Update user main information
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = $validated['password'];
            }

            if ($staff->user) {
                $staff->user->update($userData);
            }

            // 2. Update staff profile
            $staff->update([
                'staff_code' => $validated['staff_code'],
                'phone' => $validated['phone'] ?? null,
                'designation' => $validated['designation'] ?? null,
                'status' => $validated['status'] ?? 'active',
            ]);
        });

        return redirect()->route('staff.index')
            ->with('success', 'Staff profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        DB::transaction(function () use ($staff) {
            $user = $staff->user;
            $staff->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('staff.index')
            ->with('success', 'Staff member and associated user account removed successfully.');
    }
}
