<?php
  
namespace App\Enums;
 
enum UserRolesEnum:string {
    case ADMIN = 'Admin';
    case MODERATOR = 'Moderator';
    case USER = 'User';
}