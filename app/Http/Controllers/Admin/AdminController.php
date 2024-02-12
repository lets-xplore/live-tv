<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Video;
use App\Models\Category;

class AdminController extends Controller
{
    public function login(Request $request)
    {

        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        if ($request->isMethod('get')) {
            return view('admin.login');
        } elseif ($request->isMethod('post')) {
            $credentials = $request->only('email', 'password');

            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->route('admin.login')
                ->with('error', 'Invalid login credentials');
        }
        return redirect()->route('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function dashboard(Request $request)
    {
        $page_title = "Dashboard";

        // Get the total count of videos
        $totalVideos = Video::count();

        // Get the total count of active categories
        $activeCategories = Category::where('status', 1)->count();

        // Get the total count of inactive categories
        $inactiveCategories = Category::where('status', 0)->count();

        return view('admin.dashboard', compact('page_title', 'totalVideos', 'activeCategories', 'inactiveCategories'));
    }

    public function ResetData(Request $request)
    {
        try {
            // Clear all data from the 'categories' and 'videos' tables
            DB::table('categories')->truncate();
            DB::table('videos')->truncate();

            // Return to the dashboard with a success message
            return redirect()->route('admin.dashboard')->with('success', 'All data has been reset successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            return redirect()->route('admin.dashboard')->with('error', 'An error occurred while resetting data.');
        }
    }
}
