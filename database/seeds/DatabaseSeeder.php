<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AdminSeeder::class);

        Model::reguard();
    }
}

class AdminSeeder extends Seeder {

	public function run() {
		$role = Role::create(array(
			'name' => 'admin',
		));

		$user = User::create(array(
			'name' => 'admin',
			'email' => 'admin@admin.hu',
			'password' => bcrypt('123456'),
		));

		$user->attachRole($role);

	}

}
