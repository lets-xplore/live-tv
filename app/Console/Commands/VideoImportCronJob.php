<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http; // Import Http facade
Use App\Models\Video;
use GuzzleHttp\Client;
class VideoImportCronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vimeo:video-import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Vimeo videos daily';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Define the Vimeo API access token here or retrieve it from your config
        $token = "474af410bb0aeec7deb656792b35771a";


        $client = new Client();
        $accessToken = $token; // Use the provided token or the default token
        try {
            $response = $client->request('GET', 'https://api.vimeo.com/me/videos', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);
            $data = json_decode($response->getBody(), true);
            $this->InsertData($data);

            \Log::info('Cron job executed at ' . now());
        } catch (\Exception $e) {
            \Log::error('Error in Vimeo API request: ' . $e->getMessage());
        }
    }

    public function insertData($data)
    {
        foreach ($data['data'] as $record) {
            $link640 = '';
            $thumb = ''; // Initialize the $thumb variable

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
                    'direct_url' => $record['play']['hls']['link'],
                    'description' => $record['description'],
                    'link' => $record['link'],
                    'player_embed_url' => $record['embed']['html'],
                    'duration' => $record['duration'],
                    'pictures' => $link640,
                    'thumb_image' => $thumb,
                ]);
            } else {
                // If no existing video record is found, create a new one
                Video::create([
                    'uri' => $record['uri'],
                    'name' => $record['name'],
                    'direct_url' => $record['play']['hls']['link'],
                    'description' => $record['description'],
                    'link' => $record['link'],
                    'player_embed_url' => $record['embed']['html'],
                    'duration' => $record['duration'],
                    'pictures' => $link640,
                    'thumb_image' => $thumb,
                ]);
            }
        }
    }
}
