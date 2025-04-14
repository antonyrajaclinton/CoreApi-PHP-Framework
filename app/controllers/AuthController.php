<?php

namespace Controllers;

use Root\Base\Handlers\Request;
use Root\Base\Handlers\File;
use Root\Base\Handlers\Validation;
use Root\Base\Handlers\Response;

class AuthController
{

   public function signIn()
   {
      $getUserName = Request::input('userName');
      $getEmailAddress = Request::input('userEmail');
      $getPassword = Request::input();
      $uploadProfileImage = File::upload('file', 'uploads/profileImages');

      $fields = [
         "userName" => $getUserName,
         "email" =>  $getEmailAddress
      ];

      Validation::validate($fields, ['userName', 'email:email'], true);
      
      Response::JSON(['message' => 'Registered']);
   }
   public function signUp()
   {
      echo 123445455;
      return 2346534;
   }
}
