<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Models\Supplier;
use App\Models\ContactDetail;

class SupplierController extends Controller
{
    /**
     * @OA\Post(
     *     path="/suppliers",
     *     summary="Create a supplier",
     *     tags={"Suppliers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SupplierRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/SupplierResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function createSupplier(Request $request) {
    }
}
