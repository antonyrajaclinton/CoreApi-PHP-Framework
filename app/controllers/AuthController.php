<?php

namespace App\Controllers;

use Root\Base\Handlers\Request;
use Root\Base\Handlers\File;
use Root\Base\Handlers\Validation;
use Root\Base\Handlers\Response;
use App\Models\UserModel;
use Root\Base\DB;

class AuthController
{

   public function signIn(): void
   {

      $validationResponse = Validation::validate(Request::input(), ['name', 'emailAddress:email', 'password']);
      if (!$validationResponse->status) {
         Response::JSON(['status' => false, 'message' => $validationResponse->error], 400);
      }

      $uploadProfileImage = File::upload('file', 'uploads/profileImages');
      $fields = [
         "user_name" =>  Request::input('name'),
         "user_email" => Request::input('emailAddress'),
         "password" => Request::input('password'),
         // "profile_image" => $uploadProfileImage->fileUrl
      ];
      // $getInstance = new DB();
      UserModel::create($fields);
      DB::commit();
      DB::lastQuery();


      Response::JSON(['message' => 'Registered']);
   }

   public function signUp()
   {
      echo 123445455;
      return 2346534;
   }
}
