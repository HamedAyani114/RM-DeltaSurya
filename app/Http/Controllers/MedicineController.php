<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Http::post('http://recruitment.rsdeltasurya.com/api/v1/auth', [
            'email' => 'hamedayani27@gmail.com',
            'password' => '089616087216'
        ])->json();

        $medicines = Http::withToken($auth['access_token'])
        ->get('http://recruitment.rsdeltasurya.com/api/v1/medicines')
        ->json();

        foreach($medicines['medicines'] as $key => $medicine) {
            $prices = Http::withToken($auth['access_token'])
            ->get('http://recruitment.rsdeltasurya.com/api/v1/medicines/' . $medicine['id'] . '/prices')
            ->json();

            $latestMedPrice = 0;
            foreach($prices['prices'] as $price) {
                if ($price['end_date']['value'] >= Carbon::now()->format('Y-m-d') || $price['end_date']['value'] == null) {
                    $latestMedPrice = $price['unit_price'];
                }
            }

            $medicines['medicines'][$key]['harga'] = $latestMedPrice;
        }
        return view('medicines.index', [
            'pageTitle' => 'Data Obat',
            'medicines' => $medicines['medicines']
        ]);
    }
}
