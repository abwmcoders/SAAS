<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResourcse;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index() {
        $features = Feature::where('active', true)->get();
          return Inertia::render('Welcome', [
            'features' => FeatureResourcse::collection($features),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
          ]);
    }
}
