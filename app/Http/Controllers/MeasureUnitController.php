<?php

namespace App\Http\Controllers;

use App\DTOs\MeasureUnitDto;
use App\Http\Requests\MeasureUnitRequest;
use App\Services\MeasureUnitService;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Models\MeasureUnit;

class MeasureUnitController extends Controller
{
    private $measureUnitService;

    public function __construct(MeasureUnitService $measureUnitService) {
        $this->measureUnitService = $measureUnitService;
    }

    public function createUnit(MeasureUnitRequest $request) {
        $measureUnit = MeasureUnitDto::fromRequest($request);
        $measureUnit = $this->measureUnitService->createMeasureUnit($measureUnit);
        return response()->json($measureUnit, 200);
    }

    public function getAllMeasureUnits() {
        $categories = MeasureUnit::get();
        return response()->json($categories, 200);
    }

    public function getMeasureUnit($id) {
        $measureUnit = MeasureUnit::find('id', $id);
        return response()->json($measureUnit, 200);
    }

    public function updateMeasureUnit($id, Request $request) {
        try {
            $measureUnit = MeasureUnit::find($id);

            if ($measureUnit == null) {
            return response()->json(["code"=>"Invalid Input", "message"=>"Measure unit not found"], 400);
            }

            $measureUnit->unit_name = $request->unit_name;
            $measureUnit->description = $request->description;
            $measureUnit->active = $request->active;
            $measureUnit->update();

            return response()->json($measureUnit, 200);
        } catch(Exception $ex) {
            Log::channel('debug')->error($ex->getMessage());
            return response()->json(["message"=>$ex->getMessage()], 500);
        }
    }

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
