<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function list(){
        try {
            dd('aq');
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
    }
}
