<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('RolesSeeder');
		$this->command->info('roles table seeded');
	}

}

/**
* 
*/
class RolesSeeder extends Seeder
{
	
	public function run() {
		DB::table('roles')->delete();
		Role::create(array('keterangan' => 'Administrator'));
		Role::create(array('keterangan' => 'User'));
	}
}