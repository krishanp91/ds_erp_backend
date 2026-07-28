<?php

namespace App\Http\Controllers;

use App\Dtos\MeasureUnitDto;
use App\Http\Requests\MeasureUnitRequest;
use App\Services\MeasureUnitService;

use Illuminate\Http\Request;

use App\Models\MeasureUnit;

class MeasureUnitController extends Controller
{
    private $measureUnitService;

    public function __construct(MeasureUnitService $measureUnitService) {
        $this->measureUnitService = $measureUnitService;
    }

    /**
     * @OA\Post(
     *     path="/measure-units",
     *     summary="Create a measure unit",
     *     tags={"Measure Units"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/MeasureUnitRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/MeasureUnitResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function createUnit(MeasureUnitRequest $request) {
        $measureUnit = MeasureUnitDto::fromRequest($request);
        $measureUnit = $this->measureUnitService->createMeasureUnit($measureUnit);
        return response()->json($measureUnit, 200);
    }

    /**
     * @OA\Get(
     *     path="/measure-units",
     *     summary="Get list of measure units",
     *     tags={"Measure Units"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="active",
     *         in="query",
     *         description="Filter measure units by active state. When true, only active (active=1) measure units are returned; when false, only inactive (active=0) measure units are returned. When omitted or empty, all measure units are returned.",
     *         required=false,
     *         allowEmptyValue=true,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/MeasureUnitResponse")
     *          )
     *     )
     * )
     */
    public function getAllMeasureUnits(Request $request) {
        $active = $request->query('active');

        $query = MeasureUnit::withTrashed();
        if ($active !== null && $active !== '') {
            $isActive = filter_var($active, FILTER_VALIDATE_BOOLEAN);
            $query->where('active', $isActive ? 1 : 0);
        }

        $measureUnits = $query->get();
        return response()->json($measureUnits, 200);
    }

    /**
     * @OA\Get(
     *     path="/measure-units/{id}",
     *     summary="Get measure unit by id",
     *     tags={"Measure Units"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the measure unit",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/MeasureUnitResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid measure unit id")
     * )
     */
    public function getMeasureUnit($id) {
        $measureUnit = MeasureUnit::find('id', $id);
        return response()->json($measureUnit, 200);
    }

    /**
     * @OA\Put(
     *     path="/measure-units/{id}",
     *     summary="Update a measure unit",
     *     tags={"Measure Units"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the measure unit",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/MeasureUnitRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/MeasureUnitResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function updateMeasureUnit($id, MeasureUnitRequest $request)
    {
        $measureUnitDto = MeasureUnitDto::fromRequest($request);
        $measureUnit = $this->measureUnitService->updateMeasureUnit($id, $measureUnitDto);

        return response()->json($measureUnit, 200);
    }

    /**
     * @OA\Delete(
     *     path="/measure-units/{id}",
     *     summary="Delete measure unit",
     *     tags={"Measure Units"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the measure unit",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/MeasureUnitResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid measure unit id")
     * )
     */
    public function deleteMeasureUnit($id) {
        $measureUnit = MeasureUnit::find($id);

        if ($measureUnit == null) {
            return response()->json(["code"=>"Invalid Input", "message"=>"Measure unit not found"], 400);
        }

        $measureUnit->active = 0;
        $measureUnit->update();

        return response()->json($measureUnit, 200);
    }
}
