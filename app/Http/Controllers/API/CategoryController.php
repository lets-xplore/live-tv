<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categoriesWithVideos = Category::orderBy('order_index')->select('name as title', 'id', 'video_id_array')->where('status', 1)->get();

        $response = [
            'status' => true,
            'data' => [
                'sections' => $categoriesWithVideos,
            ],
        ];

        return response()->json($response);
    }
}
