<?php
  
namespace App\Enums;
 
enum TaskStatusEnum:string {
    case NEW = 'New';
    case INPROGRESS = 'InProgress';
    case ONREVIEW = 'OnReview';
    case COMPLETED = 'Completed';
}