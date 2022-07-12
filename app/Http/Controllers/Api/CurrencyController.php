<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{

    public function index()
    {

        $currency = DB::table('currency')->get();
        
        return response()->json(["success" => true,
            "currency" => $currency], 200);

    }

   
    public function store(Request $request)
    {

        if (!request()->hasFile('logo')) {
                return response()->json(["success" => false, "message" => 'upload_file_not_found'], 400);
            }
            $file = request()->file('logo');
            if (!$file->isValid()) {
                return response()->json(["success" => false, "message" => 'logo'], 400);
            }
            $path = public_path('logo');
            $file_name = $file->getClientOriginalName();
            $f = $file->move($path, $file->getClientOriginalName());
    
            $f1 = "logo/" . $file_name;
           
        $data['logo'] = $f1;
        $data['name'] = $request->input('name');
        $data['price'] = $request->input('price');
        $data['market'] = $request->input('market');
        $data['total_supply'] = $request->input('total_supply');
        DB::table('currency')->insertGetId($data);
        return response()->json(["success" => true,
            "message" => "Created Successful"], 201);
      
    }
    public function destroy(int $id)
    {
        $currency=DB::table('currency')->where('id',$id)->delete();
        

         return response()->json(["success" => true,'message'=>'Delete successful'],200);
        
    }

}
