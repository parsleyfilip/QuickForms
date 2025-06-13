<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $forms = $user->forms()->latest()->get();
        Log::info('Dashboard accessed by user: ' . $user->id);
        Log::info('Forms fetched: ' . $forms->count());
        return view('dashboard', compact('forms'));
    }
}
