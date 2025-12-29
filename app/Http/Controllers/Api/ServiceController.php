<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // GET /api/services (public)
    public function index(Request $request)
    {
        $q = $request->query('q');
        $onlyActive = $request->boolean('active', true);

        $services = Service::query()
            ->when($onlyActive, fn($x) => $x->where('is_active', true))
            ->when($q, fn($x) => $x->where('name', 'like', "%{$q}%"))
            ->orderBy('name')
            ->paginate(12);

        return response()->json([
            'data' => $services
        ]);
    }

    // GET /api/services/{service} (public)
    public function show(Service $service)
    {
        // kalau mau blok service nonaktif untuk public:
        if (!$service->is_active) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        return response()->json([
            'data' => $service
        ]);
    }
}
