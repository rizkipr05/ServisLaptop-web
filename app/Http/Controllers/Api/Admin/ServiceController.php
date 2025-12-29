<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // GET /api/admin/services
    public function index(Request $request)
    {
        $q = $request->query('q');

        $services = Service::query()
            ->when($q, fn($x) => $x->where('name', 'like', "%{$q}%"))
            ->latest()
            ->paginate(15);

        return response()->json(['data' => $services]);
    }

    // POST /api/admin/services
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:120'],
            'description' => ['nullable','string'],
            'base_price' => ['required','integer','min:0'],
            'estimated_days' => ['nullable','integer','min:0','max:365'],
            'is_active' => ['required','boolean'],
        ]);

        $service = Service::create($validated);

        return response()->json([
            'message' => 'Service created',
            'data' => $service
        ], 201);
    }

    // GET /api/admin/services/{service}
    public function show(Service $service)
    {
        return response()->json(['data' => $service]);
    }

    // PUT/PATCH /api/admin/services/{service}
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => ['sometimes','required','string','max:120'],
            'description' => ['sometimes','nullable','string'],
            'base_price' => ['sometimes','required','integer','min:0'],
            'estimated_days' => ['sometimes','nullable','integer','min:0','max:365'],
            'is_active' => ['sometimes','required','boolean'],
        ]);

        $service->update($validated);

        return response()->json([
            'message' => 'Service updated',
            'data' => $service
        ]);
    }

    // DELETE /api/admin/services/{service}
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json([
            'message' => 'Service deleted'
        ]);
    }
}
