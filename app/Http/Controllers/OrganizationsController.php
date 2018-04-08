<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Models\Organization;
use App\Http\Models\User;

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
}
