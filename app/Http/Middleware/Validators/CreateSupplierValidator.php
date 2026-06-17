<?php

namespace App\Http\Middleware\Validators;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CreateSupplierValidator {
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $rules = [
            'first_name' => 'required|max:100'
        ];
        $messages = [
            'first_name.required' => 'First Name is Required',
            'first_name.max' => 'First Name Exceeds Length (100)',
        ];

        $validator = Validator::make($request->json()->all(), $rules, $messages);
        return $next($validator);
        // if($validator->fails()) {
        //     return response()->json(["code"=>"Invalid Input", "message"=>$validator->errors()->first()], 400);
        // } else {
        //     return $next($request);
        // }
    }
}

