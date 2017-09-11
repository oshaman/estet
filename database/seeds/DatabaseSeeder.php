<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(SpecialtiesTableSeeder::class);
        $this->call(BlogCategoriesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(HoroscopeSeeder::class);
        $this->call(EstablishmentsTableSeeder::class);
        $this->call(PremiumTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(EventscategoriesTableSeeder::class);
        $this->call(SeosTableSeeder::class);
        $this->call(OrganizersTableSeeder::class);
        $this->call(AdvertisingsTableSeeder::class);
    }
}
