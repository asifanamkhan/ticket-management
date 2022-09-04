<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function download()
    {
        $format = 'png';
        $mime = 'image/png';
        $headers = [
            'Content-type'        => $mime,
            'Content-Disposition' => 'attachment; filename="qrcode.png"',
        ];

        $image = QrCode::format('png')->size(150)->generate(route('scan.packages', ['id' => auth()->user()->id]));
    
        return \Response::make($image, 200, $headers);
    }
}
