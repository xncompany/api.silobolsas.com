<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Models\User;
use App\Http\Models\UserLand;
use App\Http\Models\UserAttribute;
use App\Http\Models\UserAttributeValue;

class UserController extends Controller
{
    /**
     * Get User for a given id
     *
     * @param  int  $id
     * @return Response
     */
    public function getById($id) {

        return User::where('id', $id)
                ->with(['user_type', 'attributes', 'attributes.user_attribute', 'organization'])
                ->where('active', 1)
                ->first();
    }

    /**
     * Reset Password for given User
     *
     * @param  int  $id
     * @return Response
     */
    public function resetPassword($id, Request $request) {

        $update = User::where('id', $id)->update(['password' => $request->input('password')]);

        if (!$update) {
            return new JsonResponse(null, 400);
        } 

        return new JsonResponse();
    }


    /**
     * Get User for a given id
     *
     * @param  int  $id
     * @return Response
     */
    public function getByEmailAndPassword(Request $request) {

        $request->validate([
            'email' => 'required|email|max:128',
            'password' => 'required|string|max:128'
        ]);

        $user = User::where('email', $request->input('email'))
                    ->where('password', md5($request->input('password')))
                    ->where('active', 1)
                    ->first();

        if (empty($user)) {
            return new JsonResponse("El usuario no existe", 500);
        }

        return $this->getById($user->id);
    }
    
    /**
     * Create User.
     *
     * @return Response
     */
    public function create(Request $request) {

        $request->validate([
            'email' => 'required|email|max:128',
            'password' => 'required|string|max:32',
            'user_type' => 'required|numeric|digits_between:1,10',
            'organization' => 'required|numeric|digits_between:1,10',
            'active' => 'required|boolean',
            'attributes' => 'json'
        ]);

        # did already exists?
        $user = User::where('email', $request->input('email'))
                    ->where('active', 1)
                    ->first();
        
        if (!empty($user)) {
            return new JsonResponse("El usuario ya existe", 500);
        }

        $user = User::create($request->all());
        
        if ($request->has('attributes')) {
            
            $attributes = json_decode($request->get('attributes'), true);
            
            foreach ($attributes as $attributeName => $attributeValue) {
                
                $userAttribute = UserAttribute::firstOrCreate(['description' => $attributeName]);
                UserAttributeValue::create([
                    'user' => $user->id,
                    'user_attribute' => $userAttribute->id,
                    'description' => $attributeValue
                ]);
            }
        }


        if ($request->has('user_lands')) {
            foreach ($request->get('user_lands') as $id_land) {
                UserLand::create(['user' => $user->id, 'land' => $id_land]);
            }
        }

        
        return $this->getById($user->id);
    }

    /**
     * Delete User.
     *
     * @return Response
     */
    public function delete($id) {

        $update = User::where('id', $id)->update(['active' => 0]);

        if (!$update) {
            return new JsonResponse(null, 400);
        } 

        return new JsonResponse();
    }
}
