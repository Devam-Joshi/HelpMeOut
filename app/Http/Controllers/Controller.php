<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GoogleAccessTokenService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $googleAccessTokenService;

    public function __construct(GoogleAccessTokenService $googleAccessTokenService)
    {
        $this->googleAccessTokenService = $googleAccessTokenService;
    }

    public function getToken()
    {
        try {
            $token = $this->googleAccessTokenService->getAccessToken();
            return $token;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getUserFCMTokensById($id)
    {
        $userTokens = User::where('id', $id)
            ->pluck('fcm_token');
        $deviceToken = $userTokens->first();

        return $deviceToken;
    }
    public function sendNotification($title, $message, $to, $userId, $imageUrl = "", $openScreen = "dashboard")
    {

        $payload = [
            "message" => [
                "token" => $to,

                "notification" => [
                    "title" => $title,
                    "body" => $message,
                    "image" => $imageUrl
                ],
                "data" => [
                    "title" => $title,
                    "body" => $message,
                    "image" => $imageUrl,
                    "openscreen" => $openScreen
                ]
            ]
        ];

        $jsonPayload = json_encode($payload);
        $token = $this->getToken();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://fcm.googleapis.com/v1/projects/helpmeout-3d068/messages:send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonPayload,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
            ],
        ]);

        $response = curl_exec($curl);

        // if ($response === false) {
        //     dd("cURL Error: " . curl_error($curl));
        // }

        curl_close($curl);

        // Save DB notification
        // DB::table('notifications')->insert([
        //     'type' => "Individual",
        //     'topic' => "Individual",
        //     'title' => $title,
        //     'message' => $message,
        //     'image_url' => $imageUrl,
        //     'open_screen' => $openScreen,
        //     'mark_as_read' => 0,
        //     'user_id' => $userId,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        return $response;
    }

    public function sendTopicNotification($title, $message, $topic, $imageUrl = null, $openScreen = "dashboard")
    {
        $payload = [
            "message" => [
                "topic" => $topic,

                "notification" => [
                    "title" => $title,
                    "body" => $message,
                    "image" => $imageUrl
                ],
                "data" => [
                    "title" => $title,
                    "body" => $message,
                    "image" => $imageUrl,
                    "openscreen" => $openScreen
                ]
            ]
        ];

        $jsonPayload = json_encode($payload);
        $token = $this->getToken(); // FIREBASE TOKEN

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://fcm.googleapis.com/v1/projects/attendance-s1313/messages:send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonPayload,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: ' . "Bearer $token",
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

}
