<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models;

class CompanyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/companies/{id}",
     *     summary="Get company details",
     *     tags={"Companies"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Company id",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/CompanyResponse")
     *     )
     * )
     */
    public function getCompanyDetails($id) {
      $company = Company::first();

      return response()->json($company, 200);
    }

    public function getTru() {
      return response()->json(true, 200);
    }
}
