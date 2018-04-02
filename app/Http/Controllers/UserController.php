<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Land;
use App\User;

class UserController extends Controller
{
    /**
     * Get User for a given id
     *
     * @param  int  $id
     * @return Response
     */
    public function getById($id) {
        
        return User::where('id', $id)->first();
    }

    /**
     * List lands for a given User
     *
     * @param  int  $land
     * @return Response
     */
    public function listLands($idUser) {
        return Land::where('user', $idUser)->where('active', 1)->get();
    }

}
