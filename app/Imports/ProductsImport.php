<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductsImport implements ToArray, WithStartRow
{
	use Importable;

	public function array( array $array ) {
		// TODO: Implement array() method.
	}

	public function startRow(): int {
    	return 2;
	}
}