<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // GET /api/admin/users?q=&role=&per_page=
    public function index(Request $request)
    {
        $q = $request->query('q');
        $role = $request->query('role'); // admin|customer
        $perPage = (int) ($request->query('per_page', 15));
        $perPage = max(5, min(50, $perPage));

        $users = User::query()
            ->select(['id','name','email','role','phone','address','created_at'])
            ->when($role, fn($x) => $x->where('role', $role))
            ->when($q, function ($x) use ($q) {
                $x->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('phone', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate($perPage);

        return response()->json(['data' => $users]);
    }

    // POST /api/admin/users
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:100'],
            'email' => ['required','email','max:150','unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => ['required', Rule::in(['admin','customer'])],
            'phone' => ['nullable','string','max:30'],
            'address' => ['nullable','string','max:500'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'], // cast hashed di model
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        return response()->json([
            'message' => 'User created',
            'data' => $user->only(['id','name','email','role','phone','address','created_at'])
        ], 201);
    }

    // GET /api/admin/users/{user}
    public function show(User $user)
    {
        return response()->json([
            'data' => $user->only(['id','name','email','role','phone','address','created_at'])
        ]);
    }

    // PUT/PATCH /api/admin/users/{user}
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['sometimes','required','string','max:100'],
            'email' => [
                'sometimes','required','email','max:150',
                Rule::unique('users','email')->ignore($user->id),
            ],
            'role' => ['sometimes','required', Rule::in(['admin','customer'])],
            'phone' => ['sometimes','nullable','string','max:30'],
            'address' => ['sometimes','nullable','string','max:500'],

            // password optional, tapi kalau diisi harus confirmed
            'password' => ['sometimes','nullable','confirmed', Password::min(8)],
        ]);

        // proteksi: admin tidak boleh demote dirinya sendiri (opsional tapi aman)
        if (isset($validated['role']) && $request->user()->id === $user->id && $validated['role'] !== 'admin') {
            return response()->json([
                'message' => 'You cannot change your own role'
            ], 422);
        }

        // update field biasa
        $user->fill(collect($validated)->except(['password'])->toArray());

        // update password kalau dikirim
        if (array_key_exists('password', $validated) && !empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return response()->json([
            'message' => 'User updated',
            'data' => $user->only(['id','name','email','role','phone','address','created_at'])
        ]);
    }

    // DELETE /api/admin/users/{user}
    public function destroy(Request $request, User $user)
    {
        // proteksi: admin tidak boleh hapus dirinya sendiri
        if ($request->user()->id === $user->id) {
            return response()->json([
                'message' => 'You cannot delete your own account'
            ], 422);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted'
        ]);
    }
}
