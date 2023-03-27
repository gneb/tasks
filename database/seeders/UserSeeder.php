<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Enums\TaskStatusEnum;
use App\Enums\UserRolesEnum;
use App\Models\User;
use App\Models\Task;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insertOrIgnore([
            'name' => 'admin',
            'email' => 'admin@admin.admin',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insertOrIgnore([
            'name' => 'moderator',
            'email' => 'moderator@moderator.moderator',
            'username' => 'moderator',
            'password' => Hash::make('moderator'),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        for($i = 1; $i < 9; $i ++){
            $user = User::create([
                'username' => "user{$i}",
                'name' => "user{$i}",
                'email' => "user{$i}@user.user",
                'password' => Hash::make("user{$i}"),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            
            $user->assignRole(UserRolesEnum::USER->value);
        }

        $taskStatuses = array_map(fn($status): string => $status->value, TaskStatusEnum::cases());

        for($i = 1; $i < 21; $i ++){

            $task = Task::create([
                'name' => "task {$i}",
                'description' => "task {$i} description",
                'assignee_id' => rand(1, 10),
                'status' => $taskStatuses[rand(0, count($taskStatuses) - 1)],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        }


        $admin = User::where('email', 'admin@admin.admin')->first();
        $admin->assignRole(UserRolesEnum::ADMIN->value);

        $moderator = User::where('email', 'moderator@moderator.moderator')->first();
        $moderator->assignRole(UserRolesEnum::MODERATOR->value);
    }
}
