<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class CertificateController extends Controller
{
    public function create()
{
    // helper function
    function base64Image($path){
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/'.$type.';base64,'.base64_encode($data);
    }

    $images = [
        'safety_logo' => base64Image(public_path('images/safety_first.jpg')),
        'sk_logo' => base64Image(public_path('images/sk_logo.jpeg')),
        'fire_icon' => base64Image(public_path('images/fire_extinguare.png')),
        'iso_logo' => base64Image(public_path('images/iso_9001.jpg')),
        'footer1' => base64Image(public_path('images/footer_image_1.jpg')),
        'footer2' => base64Image(public_path('images/footer_image_2.jpg')),
        'footer3' => base64Image(public_path('images/footer_image_3.jpg')),
        'footer4' => base64Image(public_path('images/footer_image_4.jpg')),
        'footer5' => base64Image(public_path('images/footer_image_5.jpg')),
        'footer6' => base64Image(public_path('images/footer_image_6.jpg')),
        'footer7' => base64Image(public_path('images/footer_image_7.jpg')),
        'footer8' => base64Image(public_path('images/footer_image_8.jpg')),
        'footer9' => base64Image(public_path('images/footer_image_9.jpg')),
    ];

    // GENERATE HTML
    $html = view('certificate', $images)->render();

    // TEMP HTML
    $tempHtmlPath = storage_path('app/temp_' . uniqid() . '.html');
    file_put_contents($tempHtmlPath, $html);

    // PDF PATH
    $pdfPath = storage_path('app/certificate.pdf');

    // PYTHON PATH
    $python = 'C:\Users\Devam Joshi\AppData\Local\Programs\Python\Python313\python.exe';

    // WEASYPRINT COMMAND
    $cmd = "\"$python\" -m weasyprint \"$tempHtmlPath\" \"$pdfPath\" 2>&1";

    shell_exec($cmd);

    @unlink($tempHtmlPath);

    return response()->json([
        'status' => 'success',
        'path' => $pdfPath
    ]);
}

}
