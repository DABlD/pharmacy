<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, JsonResponse};
use App\Models\Test;
use Exception;

class TestController extends Controller
{
    public function index(Request $req)
	{
		try{
			$test = new Test();
			$test->text = $req->text;
			$test->date = now()->toDateTimeString();
			$test->save();
		} catch (Exception $e) {
			return response()->json([
				'data' => [],
				'message' => $e->getMessage()
			], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
		}
		
		return response()->json([
			'data' => $test,
			'message' => 'Success'
		], JsonResponse::HTTP_OK);
	}
}
