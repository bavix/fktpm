<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Qr;
use Bavix\Helpers\Arr;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{

    public function rgb($hex)
    {

        if (is_array($hex))
        {
            return $hex;
        }

        if ($hex{0} === '#')
        {
            $hex = substr($hex, 1);
        }

        $data = str_split($hex, (strlen($hex) === 6) + 1);

        return Arr::map($data, function ($hex) {
            return hexdec($hex);
        });

    }

    public static function hex()
    {
        return config(
            'bx.css.' . config('bx.style') . '.default',
            config('bx.css.sot.default')
        );
    }

    public function index(Request $request, $hash)
    {
        $model = Qr::findByHash($hash);

        abort_if($model === null, 404);

        /**
         * @var $qr \SimpleSoftwareIO\QrCode\BaconQrCodeGenerator
         */
        $qr = QrCode::format('png');

        $hex = $this->rgb(static::hex());

        $png = $qr
            ->size(400)
            ->margin(0)
            ->color(...$hex)
            ->merge(config('qr.logo'), .3, true)
            ->generate($model->url);

        return response($png, 200, [
            'Content-Type' => 'image/png',
            'Expires'      => gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60 * (24) * 365))
        ]);
    }

}
