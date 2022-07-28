<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $index = Role::all()->toArray();
        return array_reverse($index);
    }

    public function create(Request $request)
    {
        try{
            $role = new Role();
            $role->name = $request->name;
            $role->desc = $request->desc;
            $role->save();
            $success = true;
            $message = "role added successfully";
        }catch(\Illuminate\Database\QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return response()->json($role);
    }

    public function update($id, Request $request)
    {
        $role = Role::find($id);
        $request->validate([
            'name' => 'required',
            'desc' => 'required'
        ]);

        $input = $request->all();
        
        $role->update($input);

        return response()->json(['success'=> 'Role update successfully']);
    }
    public function delete($id)
    {
        $role = Role::find($id);
        $role->delete();
        //unlink('img/'.$role->image);
        return response()->json(['success'=> 'Role deleted successfully']);

    }

    
    public function show(Role $role)
    {
        
    }

    
    

   
    
    public function destroy(Role $role)
    {
        
    }
}
