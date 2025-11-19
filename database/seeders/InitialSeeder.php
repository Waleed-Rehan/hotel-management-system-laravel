<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{User,RoomType,Room};
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class InitialSeeder extends Seeder {
    public function run(): void {
        // roles
        $roles = ['SuperAdmin','Reception','Housekeeping','Maintenance','LimitedManager'];
        foreach($roles as $r){ Role::firstOrCreate(['name'=>$r]); }
        // admin
        $admin = User::firstOrCreate(['username'=>'admin'],[
            'name'=>'Super Admin','password'=>Hash::make('password')
        ]);
        $admin->assignRole('SuperAdmin');
        // room types
        $single = RoomType::firstOrCreate(['name'=>'Single'], ['capacity'=>1,'beds'=>1,'base_price'=>50]);
        $double = RoomType::firstOrCreate(['name'=>'Double'], ['capacity'=>2,'beds'=>2,'base_price'=>80]);
        // rooms
        foreach(range(101,110) as $n){ Room::firstOrCreate(['number'=>(string)$n], ['floor'=>1,'room_type_id'=>$single->id,'status'=>'vacant']); }
        foreach(range(201,210) as $n){ Room::firstOrCreate(['number'=>(string)$n], ['floor'=>2,'room_type_id'=>$double->id,'status'=>'vacant']); }
    }
}
