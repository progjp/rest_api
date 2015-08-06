<?php
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::collection('users')->delete();

        /**
         * @var Collection $users
         */
        $users = factory(App\User::class, 25)->create();

        foreach ($users as $user) {
            $friends = $users->diff([$user])->random(2);

            foreach ($friends as $friend) {
                $user->friends()->save($friend);
            }
        }
    }
}
