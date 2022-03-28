<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\BitcoinInfoRepository;
use Carbon\Carbon;

class BitcoinInfoController extends Controller
{

    public function index(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'currency' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Faild',
                'errors' => $validate->errors()
            ], 400);
        }

        $lastMonthRate = $this->getLastMonthRate($request->currency);
        $currentRate = $this->getCurrentRate($request->currency);

        return response()->json([
            'message'       => 'Welcome to the API',
            'current_rate'  => $currentRate,
            ...$lastMonthRate
        ]);
    }

    private function getLastMonthRate($currency)
    {
        $repository = new BitcoinInfoRepository($currency);
        $repository->setUrlParam('start', Carbon::now()->subDays(30)->format('Y-m-d'));
        $repository->setUrlParam('end', Carbon::now()->format('Y-m-d'));
        $repository->get();

        return [
            'min_rate' => $repository->getMinRate(),
            'max_rate' => $repository->getMaxRate()
        ];
    }

    private function getCurrentRate($currency)
    {
        $repository = new BitcoinInfoRepository($currency);
        $repository->setBaseUrl('https://api.coindesk.com/v1/bpi/currentprice/eur.json');
        $repository->get();

        return $repository->getCurrentRate();
    }
}
