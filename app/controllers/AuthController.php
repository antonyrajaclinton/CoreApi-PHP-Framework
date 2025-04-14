<?php

namespace Controllers;

use Root\Base\Handlers\Request;
use Root\Base\Handlers\File;

class AuthController
{

   public function signIn()
   {
      $getUserName = Request::input('userName', 'dd');
      $getEmailAddress = Request::input();
      $getPassword = Request::input();
      $uploadProfileImage = File::upload('file', 'uploads/profileImages');

   }
   public function signUp()
   {
      echo 123445455;
      return 2346534;
   }
}
