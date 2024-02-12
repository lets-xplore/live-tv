<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Video;
use App\Models\Category;
use Illuminate\Support\Facades\Session;

class VideoController extends Controller
{
    public function index()
    {
        $page_title = "Videos Listing";
        $videos = Video::paginate(10);
        return view('admin.videoslisting', compact('videos', 'page_title'));
    }

    public function importVideo(Request $request)
    {
        $page_title = "Import Video";
        $token = "474af410bb0aeec7deb656792b35771a";

        if ($request->isMethod('get')) {
            return view('admin.importvideo', compact('page_title', 'token'));
        } elseif ($request->isMethod('post')) {
            $client = new Client();
            $accessToken = $request->vimeo_token ?: $token; // Use the provided token or the default token
            try {
                $response = $client->request('GET', 'https://api.vimeo.com/me/videos', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                    ],
                ]);
                $data = json_decode($response->getBody(), true);
                $this->InsertData($data);

                // Flash a success message to the session
                Session::flash('success', '.');

                //return view('admin.dashboard', compact('page_title', 'token'));
                return redirect()->route('admin.dashboard')->with('success', 'Videos imported successfully');
            } catch (\Exception $e) {
                return redirect()->route('admin.import.video', compact('page_title', 'token'))
                    ->with('error', 'Error connecting to Vimeo API: ' . $e->getMessage());
            }
        }
    }

    public function InsertData($data)
    {
        foreach ($data['data'] as $record) {
            $link640 = '';
            $thumb = '';

            $finalLink = null;

            foreach ($record['files'] as $file) {
                if ($file['quality'] === 'hls') {
                    $finalLink = $file['link'];
                    break;
                } elseif ($file['quality'] === 'hd' && $finalLink === null) {
                    $finalLink = $file['link'];
                }
            }

            if ($finalLink === null) {
                $firstFile = reset($record['files']);
                $finalLink = $firstFile['link'];
            }

            if (isset($record['pictures']['sizes']) && is_array($record['pictures']['sizes'])) {
                foreach ($record['pictures']['sizes'] as $size) {
                    if ($size['width'] == 640) {
                        $link640 = $size['link'];
                    }
                    if ($size['width'] == 295) {
                        $thumb = $size['link']; // Assign the thumbnail URL to $thumb
                    }
                }
            }

            // Check if a record with the same 'uri' already exists
            $existingVideo = Video::where('uri', $record['uri'])->first();

            if ($existingVideo) {
                // If an existing video record is found, update its data
                $existingVideo->update([
                    'name' => $record['name'],
                    'direct_url' => $finalLink,
                    'description' => $record['description'],
                    'link' => $record['link'],
                    'player_embed_url' => $record['player_embed_url'],
                    'duration' => $record['duration'],
                    'pictures' => $link640,
                    'thumb_image' => $thumb,
                ]);
            } else {
                // If no existing video record is found, create a new one
                $video = new Video([
                    'uri' => $record['uri'],
                    'name' => $record['name'],
                    'direct_url' => $finalLink,
                    'description' => $record['description'],
                    'link' => $record['link'],
                    'player_embed_url' => $record['player_embed_url'],
                    'duration' => $record['duration'],
                    'pictures' => $link640,
                    'thumb_image' => $thumb,
                ]);

                // Save the new video record to the database
                $video->save();
            }
        }
    }


    public function Category(Request $request)
    {
        $page_title = "Clinic";
        $changeOrder = $request->input('change-order', 0); // Default to 0 if the parameter is not present

        if ($changeOrder == 1) {
            $categories = Category::orderBy('order_index')->select('id', 'name', 'status', 'video_id_array')->get();
        } else {
            $categories = Category::orderBy('order_index')->select('id', 'name', 'status', 'video_id_array')->paginate(10);
        }

        return view('admin.category', compact('page_title', 'categories'));
    }


    public function AddCategory(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'category_name' => 'required|string|max:255|unique:categories,name',
            ]);

            $category = new Category([
                'name' => $request->input('category_name'),
            ]);

            $category->save();

            return redirect()->route('admin.category')->with('success', 'Clinic added successfully');
        }

        $page_title = "Clinic";
        $categories = Category::orderBy('order_index')->select('id', 'name', 'status')->paginate(20);

        return view('admin.category', compact('page_title', 'categories'));
    }

    public function EditCategory(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.category')->with('error', 'Clinic not found.');
        }
        $videos = Video::select('id', 'name', 'thumb_image')->get();
        $page_title = "Edit Clinic";
        return view('admin.editcategory', compact('category', 'videos', 'page_title'));
    }



    public function DeleteCategory(Request $request, $category_id)
    {


        $category = Category::find($category_id);
        if (!$category) {
            return redirect()->route('admin.category')->with('error', 'Clinic not found.');
        }

        $category->delete();
        return redirect()->route('admin.category')->with('success', 'Clinic deleted successfully.');
    }

    public function UpdateCategory(Request $request, $id)
    {
        $this->validate($request, [
            'category_name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'video_ids' => 'array',
        ]);
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('admin.category')->with('error', 'Clinic not found.');
        }
        $category->name = $request->input('category_name');
        $category->status = $request->input('status');
        $category->video_id_array = $request->input('video_ids', []);
        $category->save();

        return redirect()->route('admin.category')->with('success', 'Clinic updated successfully.');
    }


    public function UpdateCategoryOrder(Request $request)
    {

        $sortedItemIds = $request->input('sortedItemIds');
        foreach ($sortedItemIds as $id => $orderIndex) {
            Category::where('id', $id)->update(['order_index' => $orderIndex]);
        }
        return response()->json(['message' => 'Order updated successfully']);
    }
}
