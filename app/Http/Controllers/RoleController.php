<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class RoleController - Controller for roles
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{
    /**
     * List all roles
     *
     * @return Response $response
     */
    public function list(){
        try {
            $roles = Roles::all();
            $response = response()->json([
                'status' => 200,
                'message' => 'success',
                'roles' => $roles,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $response = response()->json([
                'status' => 500,
                'message' => 'error'
            ]);
        }
        return $response;
    }
}
