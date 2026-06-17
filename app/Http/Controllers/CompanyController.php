<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models;

class CompanyController extends Controller
{
    public function getCompanyDetails($id) {
      $company = Company::first();

      return response()->json($company, 200);
    }

    public function getTru() {
      return response()->json(true, 200);
    }
}
