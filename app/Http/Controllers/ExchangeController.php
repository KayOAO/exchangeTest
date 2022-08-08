<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ExchangeController extends Controller
{
    public function exchange(Request $request)
    {
        $result = '';
        try {
            $request->validate([
                'SourceType' => 'required|alpha|size:3',
                'TargetType' => 'required|alpha|size:3',
                'Price' => 'required|numeric',
            ]);

            $rate = $this->getRate(strtoupper($request->SourceType), strtoupper($request->TargetType));
            $result = number_format($request->Price * $rate, 2, '.', ',');
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $exception->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $e) {
            return response($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response($result, Response::HTTP_OK);
    }

    private function getRate(string $sourceType, string $targetType)
    {
        $currenciesData = '{
                "currencies": {
                    "TWD": {
                        "TWD": 1,
                        "JPY": 3.669,
                        "USD": 0.03281
                    },
                    "JPY": {
                        "TWD": 0.26956,
                        "JPY": 1,
                        "USD": 0.00885
                    },
                    "USD": {
                        "TWD": 30.444,
                        "JPY": 111.801,
                        "USD": 1
                    }
                }
            }';

        $currenciesInfo = json_decode($currenciesData);
        $currencies = $currenciesInfo->currencies;
        if (isset($currencies->$sourceType)) {
            if (isset($currencies->$sourceType->$targetType)) {
                return $currencies->$sourceType->$targetType;
            }
            throw new Exception('targetType : ' . $targetType . ' not found');
        }
        throw new Exception('sourceType : ' . $sourceType . ' not found');
    }
}
