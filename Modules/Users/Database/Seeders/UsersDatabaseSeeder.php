<?php

namespace Modules\Users\Database\Seeders;

use App\Flag;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $admin = factory(User::class)->create([
            'first_name'            => 'Admin',
            'last_name'             => 'M',
            'email'                 => 'goldoni.fouotsa+admin@desiretec.com',
            'api_token'             => '2cxFfbacikqS4mphg8DFUsUm3i2KkJ5yAqydeXT0Eoq3pZ4BdIcFqHLDbpE6',
        ]);

        $executive = factory(User::class)->create([
            'first_name'            => 'Executive',
            'last_name'             => 'M',
            'email'                 => 'goldoni.fouotsa+executive@desiretec.com',
            'api_token'             => 'O09zWlxhRvrTnxGAkBLDyhKMSGTrOHItmCm1YxXc20YwIPzrPCD3jZFug92a',
        ]);

        $user = factory(User::class)->create([
            'first_name'            => 'User',
            'last_name'             => 'M',
            'email'                 => 'goldoni.fouotsa+user@desiretec.com',
            'api_token'             => 'cX6FFEAiG20w3TiLYEbb1nefdUzMz3Jqr9estkmPh6zb6rBQFhE6qDU54r9E',
        ]);

        $event = factory(User::class)->create([
            'first_name'            => 'Event',
            'last_name'             => 'M',
            'email'                 => 'event@contact.com',
            'api_token'             => 'cX6FFEAiG20w3TiLYEbb1nefdUzMz3Jqr9estkmPh6zb6rBQFhE6qDU54r9F',
        ]);

        $admin->assignRole(Flag::ROLE_ADMIN);

        $executive->assignRole(Flag::ROLE_EVENT_MANAGER);

        $user->assignRole(Flag::ROLE_USER);

        $event->assignRole(Flag::ROLE_EVENT_MANAGER);
    }
}
