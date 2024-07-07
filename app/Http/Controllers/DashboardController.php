<?php

namespace App\Http\Controllers;

use App\Http\Resources\UseFeatureResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() {
        $usedFeatures = UseFeatureResource::query()->with('feature')->where('user_id', auth()->user()->id)->latest()->paginate();

        return Inertia::render('Dashboard', [
            'usedFeatures'=> UseFeatureResource::collection($usedFeatures),
        ]);

    }
}
