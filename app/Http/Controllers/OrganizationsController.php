<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Models\Organization;
use App\Http\Models\User;
use App\Http\Models\UserAttributeValue;

class OrganizationsController extends Controller
{
    /**
     * List organizations.
     *
     * @return Response
     */
    public function list() {
        return Organization::where('active', 1)->get();
    }
    
    /**
     * List users corresponding to the given organization.
     *
     * @return Response
     */
    public function users($id) {
        return User::where('organization', $id)
                ->with(['user_type', 'attributes', 'attributes.user_attribute', 'organization'])
                ->where('active', 1)
                ->get();
    }

    /**
     * Create new Organization.
     *
     * @return Response
     */
    public function create(Request $request) {

        $request->validate([
            'fullname' => 'required|string|max:128',
            'organization' => 'required|string|max:128',
            'password1' => 'required|string|max:128',
            'email' => 'required|email'
        ]);

        # already exists?
        $user = User::where('email', $request->input('email'))
                    ->where('active', 1)
                    ->first();
        
        if (!empty($user)) {
            return new JsonResponse("El usuario ya existe", 500);
        }

        # already exists?
        $organization = Organization::where('description', $request->input('organization'))
                        ->where('active', 1)
                        ->first();
        
        if (!empty($organization)) {
            return new JsonResponse("La empresa ya existe", 500);
        }

        # go!
        $organization = Organization::create([
            'description' => $request->input('organization'),
            'active' => 1
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'password' => md5($request->input('password1')),
            'active' => 1,
            'user_type' => 1,
            'organization' => $organization->id
        ]);

        UserAttributeValue::create([
            'user' => $user->id,
            'user_attribute' => 1,
            'description' => $request->input('fullname')
        ]);

        # bye!
        return $organization;
    }

    /**
     * Delete Organization by given Id.
     *
     * @return Response
     */
    public function delete($id) {

        $update = Organization::where('id', $id)->update(['active' => 0]);

        if (!$update) {
            return new JsonResponse(null, 400);
        } 

        return new JsonResponse();
    }
}
