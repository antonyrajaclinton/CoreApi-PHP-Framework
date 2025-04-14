<?php

namespace Controllers;

use Root\Base\Handlers\Request;

class AuthController
{

   public function signIn()
   {
      $getUserName = Request::input('userName','dd');
      $getEmailAddress = Request::input();
      $getPassword = Request::input();


    print_r($getUserName);
   }
   public function signUp()
   {
      echo 123445455;
      return 2346534;
   }
}
