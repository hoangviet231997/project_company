<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityAndDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$cites = [
			['id' => '1', 'city_post_code' => '700000', 'city_name' => 'Hồ Chí Minh'],
			['id' => '2', 'city_post_code' => '100000', 'city_name' => 'Hà Nội']
		];

		DB::table('city')->insert($cites);

		$districts = [
			['id' => '1', 'city_id' => '1', 'district_postcode' => '760', 'district_name' => 'Quận 1'],
			['id' => '2', 'city_id' => '1', 'district_postcode' => '769', 'district_name' => 'Quận 2'],
			['id' => '3', 'city_id' => '1', 'district_postcode' => '770', 'district_name' => 'Quận 3'],
			['id' => '4', 'city_id' => '1', 'district_postcode' => '773', 'district_name' => 'Quận 4'],
			['id' => '5', 'city_id' => '1', 'district_postcode' => '774', 'district_name' => 'Quận 5'],
			['id' => '6', 'city_id' => '1', 'district_postcode' => '775', 'district_name' => 'Quận 6'],
			['id' => '7', 'city_id' => '1', 'district_postcode' => '778', 'district_name' => 'Quận 7'],
			['id' => '8', 'city_id' => '1', 'district_postcode' => '776', 'district_name' => 'Quận 8'],
			['id' => '9', 'city_id' => '1', 'district_postcode' => '763', 'district_name' => 'Quận 9'],
			['id' => '10', 'city_id' => '1', 'district_postcode' => '771', 'district_name' => 'Quận 10'],
			['id' => '11', 'city_id' => '1', 'district_postcode' => '772', 'district_name' => 'Quận 11'],
			['id' => '12', 'city_id' => '1', 'district_postcode' => '761', 'district_name' => 'Quận 12'],
			['id' => '13', 'city_id' => '1', 'district_postcode' => '764', 'district_name' => 'Quận Gò Vấp'],
			['id' => '14', 'city_id' => '1', 'district_postcode' => '765', 'district_name' => 'Quận Bình Thạnh'],
			['id' => '15', 'city_id' => '1', 'district_postcode' => '766', 'district_name' => 'Quận Tân Bình'],
			['id' => '16', 'city_id' => '1', 'district_postcode' => '767', 'district_name' => 'Quận Tân Phú'],
			['id' => '17', 'city_id' => '1', 'district_postcode' => '768', 'district_name' => 'Quận Phú Nhuận'],
			['id' => '18', 'city_id' => '1', 'district_postcode' => '762', 'district_name' => 'Quận Thủ Đức'],
			['id' => '19', 'city_id' => '1', 'district_postcode' => '777', 'district_name' => 'Quận Bình Tân'],
			['id' => '20', 'city_id' => '1', 'district_postcode' => '783', 'district_name' => 'Huyện Củ Chi'],
			['id' => '21', 'city_id' => '1', 'district_postcode' => '784', 'district_name' => 'Huyện Hóc Môn'],
			['id' => '22', 'city_id' => '1', 'district_postcode' => '785', 'district_name' => 'Huyện Bình Chánh'],
			['id' => '23', 'city_id' => '1', 'district_postcode' => '786', 'district_name' => 'Huyện Nhà Bè'],
			['id' => '24', 'city_id' => '1', 'district_postcode' => '787', 'district_name' => 'Huyện Cần Giờ'],
			['id' => '25', 'city_id' => '2', 'district_postcode' => '2', 'district_name' => 'Quận Ba Đình'],
			['id' => '26', 'city_id' => '2', 'district_postcode' => '2', 'district_name' => 'Quận Hoàn Kiếm'],
			['id' => '27', 'city_id' => '2', 'district_postcode' => '2', 'district_name' => 'Quận Tây Hồ'],
			['id' => '28', 'city_id' => '2', 'district_postcode' => '2', 'district_name' => 'Quận Long Biên'],
			['id' => '29', 'city_id' => '2', 'district_postcode' => '2', 'district_name' => 'Quận Cầu Giấy'],
			['id' => '30', 'city_id' => '2', 'district_postcode' => '2', 'district_name' => 'Quận Đống Đa'],
			['id' => '31', 'city_id' => '2', 'district_postcode' => '2', 'district_name' => 'Quận Hai Bà Trưng'],
			['id' => '32', 'city_id' => '2', 'district_postcode' => '2', 'district_name' => 'Quận Hoàng Mai'],
			['id' => '33', 'city_id' => '2', 'district_postcode' => '2', 'district_name' => 'Quận Thanh Xuân'],
			['id' => '34', 'city_id' => '2', 'district_postcode' => '2', 'district_name' => 'Quận Hà Đông'],
			['id' => '35', 'city_id' => '2', 'district_postcode' => '2', 'district_name' => 'Quận Bắc Từ Liêm'],
			['id' => '36', 'city_id' => '2', 'district_postcode' => '2', 'district_name' => 'Quận Nam Từ Liêm']
		];

		DB::table('district')->insert($districts);
    }
}
