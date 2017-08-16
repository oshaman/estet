<?php

use Illuminate\Database\Seeder;

class EstablishmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('establishments')->insert([
            [
                'title' => 'Клиника №1',
                'alias' => 'klinika-1',
                'logo' => 'pic1.jpg',
                'address' => 'Киев, ул. Крещатик,1',
                'phones' => '555-55-55',
                'site' => 'site1.com',
                'parent' => null,
                'services' => '["\u0422\u0440\u0435\u043f\u0430\u043d\u0430\u0446\u0438\u044f \u0447\u0435\u0440\u0435\u043f\u0430"]',
                'about' => 'About Us test 1',
                'category' => 'clinic',
                'spec' => 'test_spec1'
            ],
            [
                'title' => 'Дистрибьютор №1',
                'alias' => 'distributor-1',
                'logo' => 'pic2.jpg',
                'address' => 'Киев, ул. Крещатик,2',
                'phones' => '555-55-77',
                'site' => 'site2.com',
                'parent' => null,
                'services' => '["\u0422\u0440\u0435\u043f\u0430\u043d\u0430\u0446\u0438\u044f \u0447\u0435\u0440\u0435\u043f\u0430"]',
                'about' => 'About Us test 2',
                'category' => 'distributor',
                'spec' => 'test_spec2'
            ],
            [
                'title' => 'Бренд №1',
                'alias' => 'brand-1',
                'logo' => 'pic3.jpg',
                'address' => 'Киев, ул. Крещатик,3',
                'phones' => '555-77-55',
                'site' => 'site3.com',
                'parent' => 3,
                'services' => '["\u0422\u0440\u0435\u043f\u0430\u043d\u0430\u0446\u0438\u044f \u0447\u0435\u0440\u0435\u043f\u0430"]',
                'about' => 'About Us test 3',
                'category' => 'brand',
                'spec' => 'test_spec3'
            ],
            [
                'title' => 'Бренд №2',
                'alias' => 'brand-2',
                'logo' => 'pic4.jpg',
                'address' => 'Киев, ул. Крещатик,4',
                'phones' => '555-77-54',
                'site' => 'site4.com',
                'parent' => 3,
                'services' => '["\u0422\u0440\u0435\u043f\u0430\u043d\u0430\u0446\u0438\u044f \u0447\u0435\u0440\u0435\u043f\u0430"]',
                'about' => 'About Us test 4',
                'category' => 'brand',
                'spec' => 'test_spec4'
            ],
            [
                'title' => 'Клиника №2',
                'alias' => 'klinika-2',
                'logo' => 'pic5.jpg',
                'address' => 'Киев, ул. Крещатик,5',
                'phones' => '545-55-55',
                'site' => 'site5.com',
                'parent' => null,
                'services' => '["\u0422\u0440\u0435\u043f\u0430\u043d\u0430\u0446\u0438\u044f \u0447\u0435\u0440\u0435\u043f\u0430"]',
                'about' => 'About Us test 5',
                'category' => 'clinic',
                'spec' => 'test_spec5'
            ],
            [
                'title' => 'Дистрибьютор №2',
                'alias' => 'distributor-2',
                'logo' => 'pic6.jpg',
                'address' => 'Киев, ул. Крещатик,6',
                'phones' => '555-87-77',
                'site' => 'site6.com',
                'parent' => null,
                'services' => '["\u0422\u0440\u0435\u043f\u0430\u043d\u0430\u0446\u0438\u044f \u0447\u0435\u0440\u0435\u043f\u0430"]',
                'about' => 'About Us test 6',
                'category' => 'distributor',
                'spec' => 'test_spec6'
            ],
            [
                'title' => 'Бренд №3',
                'alias' => 'brand-3',
                'logo' => 'pic7.jpg',
                'address' => 'Киев, ул. Крещатик,7',
                'phones' => '555-77-58',
                'site' => 'site7.com',
                'parent' => 6,
                'services' => '["\u0422\u0440\u0435\u043f\u0430\u043d\u0430\u0446\u0438\u044f \u0447\u0435\u0440\u0435\u043f\u0430"]',
                'about' => 'About Us test 7',
                'category' => 'brand',
                'spec' => 'test_spec7'
            ],
            [
                'title' => 'Бренд №4',
                'alias' => 'brand-4',
                'logo' => 'pic8.jpg',
                'address' => 'Киев, ул. Крещатик,8',
                'phones' => '555-77-34',
                'site' => 'site8.com',
                'parent' => 6,
                'services' => '["\u0422\u0440\u0435\u043f\u0430\u043d\u0430\u0446\u0438\u044f \u0447\u0435\u0440\u0435\u043f\u0430"]',
                'about' => 'About Us test 8',
                'category' => 'brand',
                'spec' => 'test_spec8'
            ],
        ]);
    }
}
