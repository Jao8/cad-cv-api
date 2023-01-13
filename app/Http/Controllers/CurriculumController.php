<?php

namespace App\Http\Controllers;

use App\Enum\Types as TypeEnum;
use App\Models\Curriculums;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CurriculumController extends Controller
{
    public function insert(Request $req)
    {
        try {
            $validator = $this->validateRequest($req);
            $user = auth()->user();

            if(!$validator->fails()) {

                if($user->type_id == TypeEnum::ADMIN->value) {
                    DB::beginTransaction();

                    $curriculum = new Curriculums();
                    $curriculum->user_id = $user->id;
                    $curriculum->name = $req->name;
                    $curriculum->mother_name = $req->parents['mother'];
                    $curriculum->father_name = $req->parents['father'];
                    $curriculum->birth = Carbon::parse($req->birthDate)->format('Y-m-d');
                    $curriculum->cpf = $req->cpf;
                    $curriculum->cep = $req->cep;
                    $curriculum->city = $req->city;
                    $curriculum->district = $req->district;
                    $curriculum->address = $req->address;
                    $curriculum->phone = $req->phone;
                    $curriculum->role = $req->role;
                    $curriculum->experience = $req->xp;


                    $curriculum->save();

                    DB::commit();

                    $response = response()->json([
                        'message' => 'success',
                        'status' => 200,
                        'data' => $curriculum
                    ]);
                } else{
                    $response = response()->json([
                        'message' => 'invalid permissions',
                        'status' => 401,
                    ]);
                }
            }else{
                $response = response()->json([
                    'message' => 'invalid data',
                    'status' => 400,
                    'data' => $validator->errors()
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $response = response()->json([
                'message' => 'error',
                'status' => 500,
            ]);
        }

        return $response;
    }

    private function validateRequest(Request $req)
    {
        return Validator::make($req->all(), [
            'name' => 'required|string|min:2|max:255',
            'parents' => 'required|array|min:2|max:2',
            'parents.*' => 'required|string|distinct|min:2|max:255',
            'phone' => 'required|string',
            'address' => 'required|string|min:3|max:255',
            'city' => 'required|string|min:3|max:255',
            'district' => 'required|string|min:3|max:255',
            'cpf' => 'required|string',
            'cep' => 'required|string',
            'role' => 'required|string|min:3|max:255',
            'xp' => 'required|string|min:3',
            'birthDate' => 'required|date',
        ]);
    }

}
