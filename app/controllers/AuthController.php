<?php

namespace Controllers;

use Root\Base\Handlers\Request;
use Root\Base\Handlers\File;
use Root\Base\Handlers\Validation;
use Root\Base\Handlers\Response;

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
         "email" => Request::input('emailAddress'),
         "password" => Request::input('password'),
         "profile_image" => $uploadProfileImage->fileUrl
      ];


      Response::JSON(['message' => 'Registered']);
   }

   public function signUp()
   {
      echo 123445455;
      return 2346534;
   }
}
