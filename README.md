## About Tasks

this is simple laravel-api project to manage users and tasks

## Installation

- Clone project
- Run ```docker-compose build```
- Run ```docker-compose up```
- Enter tasks_app container ```docker exec -it <container_id> bash```
- Run ```composer install```
- Run ```chown -R www-data:www-data /var/www/html/storage/*```
- Run ```php artisan migrate:refresh --seed```

- Server will run on ```http://localhost:8082```


## Api endpoints


- **[Documantation for Users](https://documenter.getpostman.com/view/25064323/2s93RQTZSB)**
- **[Documantation for Tasks](https://documenter.getpostman.com/view/25064323/2s93RQTZS8)**

``` Or import postman collections from postman directory```


### Users

There is one Admin 
```
email: admin@admin.admin
password: admin
```

one Moderator
```
email: moderator@moderator.moderator
password: moderator
```

eight users. for example id=2
```
email: user2@user.user
password: user2
```

twenty tasks. these tasks will be randomly assigned to users on seed.




## Notes

- To change Roles names: ```app/Enums/UserRolesEnum.php```
- To change Task status names: ```app/Enums/TaskStatusEnum.php```
- To change default permission: ``` database/seeders/RoleAndPermissionsSeeder.php```

- Admins can give roles(Admin,Moderator,User) to any users
- Admins can crud users(except users only registration)/tasks. assignee tasks
- Moderators can view Users and Tasks, Update or delete Tasks. assignee tasks
- Users only can view Tasks or change Task status on which they are assigned to. 
- Roles and Permissions are managed with **[https://github.com/spatie/laravel-permission](Spatie)**
