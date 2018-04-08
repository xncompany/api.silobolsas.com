<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Organization;
use App\User;

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
        return User::where('organization', $id)->where('active', 1)->get();
    }
}
