<?php

namespace App\Http\Controllers;

use App\Enum\Types as TypeEnum;
use App\Models\Curriculums;
use App\Models\CurriculumsStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CurriculumController extends Controller
{

    /**
     * Perform an action.
     * Currently actions: approve, reject a Curriculum.
     *
     * @param Request $req
     * @return Response $response
     */
    public function action(Request $req)
    {
        try {
            $user = auth()->user();
            $validator = Validator::make($req->all(), [
                'curriculum_id' => 'required|integer',
                'action' => 'required|string'
            ]);

            if (!$validator->fails()) {

                $curriculum = Curriculums::find($req->curriculum_id);

                if (!empty($curriculum)) {
                    if($user->type_id == TypeEnum::MANAGER->value){
                        DB::beginTransaction();
                        $curriculumStatus = new CurriculumsStatus();

                        $curriculumStatus->curriculum_id = $curriculum->id;
                        $curriculumStatus->status = $req->action == 'approve' ? 1 : 2;

                        $curriculumStatus->save();
                    } else {
                        $response = response()->json([
                            'message' => 'invalid permissions',
                            'status' => 401,
                        ]);
                    }

                } else {
                    $response = response()->json([
                        'message' => 'not found',
                        'status' => 404,
                    ]);
                }
            } else {
                $response = response()->json([
                    'message' => 'invalid request',
                    'status' => 400,
                    'data' => $validator->errors()
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $response = response()->json([
                'status' => 500,
                'message' => 'error'
            ]);
        }

        return $response;
    }

    /**
     * Insert a new curriculum.
     *
     * @param Request $req
     * @return Response $response
     */
    public function insert(Request $req)
    {
        try {
            $validator = $this->validateRequest($req);
            $user = auth()->user();

            if (!$validator->fails()) {

                if ($user->type_id == TypeEnum::ADMIN->value) {
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
                    $curriculum->role_id = $req->role;
                    $curriculum->experience = $req->xp;


                    $curriculum->save();

                    DB::commit();

                    $response = response()->json([
                        'message' => 'success',
                        'status' => 200,
                        'data' => $curriculum
                    ]);
                } else {
                    $response = response()->json([
                        'message' => 'invalid permissions',
                        'status' => 401,
                    ]);
                }
            } else {
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

    /**
     * Update a curriculum.
     *
     * @param Request $req
     * @return Response $response
     */
    public function update(Request $req)
    {
        try {
            $validator = $this->validateRequest($req);
            $user = auth()->user();

            if (!$validator->fails()) {

                if ($user->type_id == TypeEnum::ADMIN->value) {

                    $curriculum = Curriculums::find($req->id);
                    if (!empty($curriculum)) {
                        DB::beginTransaction();
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
                        $curriculum->role_id = $req->role;
                        $curriculum->experience = $req->xp;


                        $curriculum->save();

                        DB::commit();

                        $response = response()->json([
                            'message' => 'success',
                            'status' => 200,
                            'data' => $curriculum
                        ]);
                    } else {
                        $response = response()->json([
                            'message' => 'not found',
                            'status' => 404
                        ]);
                    }
                } else {
                    $response = response()->json([
                        'message' => 'invalid permissions',
                        'status' => 401,
                    ]);
                }
            } else {
                $response = response()->json([
                    'message' => 'invalid data',
                    'status' => 400,
                    'data' => $validator->errors()
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $response = response()->json([
                'message' => 'error',
                'status' => 500,
            ]);
        }
    }

    /**
     * List all curriculums from a user.
     *
     * @return Response $response
     */
    public function list()
    {
        try {
            $user = auth()->user();

            if ($user->type_id == TypeEnum::ADMIN->value) {
                $curriculums = Curriculums::where('user_id', $user->id)->with('role')->get();

                $response = response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $curriculums
                ]);
            } else if ($user->type_id == TypeEnum::ADMIN->value) {
                $curriculums = Curriculums::with('user')->get();

                $response = response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $curriculums
                ]);
            } else {
                $response = response()->json([
                    'message' => 'invalid permissions',
                    'status' => 401,
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $response = response()->json([
                'message' => 'error',
                'status' => 500,
            ]);
        }
        return $response;
    }

    /**
     * Find a curriculum by id.
     *
     * @return Response $response
     */
    public function find($curriculumId)
    {
        try {
            $user = auth()->user();
            $validator = Validator::make(['id' => $curriculumId], [
                'id' => 'required|numeric'
            ]);

            if(!$validator->fails()){
                if ($user->type_id == TypeEnum::ADMIN->value) {
                    $curriculum = Curriculums::where('user_id', $user->id)->with('role')->find($curriculumId);

                    $response = response()->json([
                        'message' => 'success',
                        'status' => 200,
                        'data' => $curriculum
                    ]);
                }else if($user->type_id == TypeEnum::MANAGER->value){
                    $curriculum = Curriculums::with('role')->find($curriculumId);

                    $response = response()->json([
                        'message' => 'success',
                        'status' => 200,
                        'data' => $curriculum
                    ]);
                }
                else {
                    $response = response()->json([
                        'message' => 'invalid permissions',
                        'status' => 401,
                    ]);
                }
            } else {
                $response = response()->json([
                    'message' => 'invalid data',
                    'status' => 400,
                    'data' => $validator->errors()
                ]);
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $response = response()->json([
                'message' => 'error',
                'status' => 500,
            ]);
        }
        return $response;
    }

    /**
     * Delete a curriculum.
     *
     * @param int $curriculumId
     * @return Response $response
     */
    public function delete($curriculumId)
    {
        try {
            $user = auth()->user();
            $validator = Validator::make(['id' => $curriculumId], [
                'id' => 'required|numeric'
            ]);

            if(!$validator->fails()){
                if ($user->type_id == TypeEnum::MANAGER->value) {
                    $curriculum = Curriculums::find($curriculumId);

                    if (isset($curriculum)) {
                        $curriculum->delete();

                        $response = response()->json([
                            'message' => 'success',
                            'status' => 200,
                        ]);
                    } else {
                        $response = response()->json([
                            'message' => 'curriculum not found',
                            'status' => 404,
                        ]);
                    }
                } else {
                    $response = response()->json([
                        'message' => 'invalid permissions',
                        'status' => 401,
                    ]);
                }
            }else {
                $response = response()->json([
                    'message' => 'invalid data',
                    'status' => 400,
                    'data' => $validator->errors()
                ]);
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $response = response()->json([
                'message' => 'error',
                'status' => 500,
            ]);
        }
        return $response;
    }

    /**
     * Validate the request.
     *
     * @param Request $req
     * @return Validator $validator
     */
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
            'role' => 'required|int',
            'xp' => 'required|string|min:3',
            'birthDate' => 'required|date',
        ]);
    }
}
