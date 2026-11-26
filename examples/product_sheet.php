<?php

	//-> Require
		require_once( __DIR__ . '/../canvas.php' );
		require_once( __DIR__ . '/technical_drawing.php' );

	//-> Product
		$product =
			array(
				'name'        => 'Mounting plate',
				'reference'   => 'MP-120',
				'image'       => __DIR__ . '/product_sheet.jpg',
				'description' => 'A lightweight aluminium plate designed to mount motors, bearings and sensors on aluminium profiles. The central bore accepts shafts up to 30 mm, while the four corner holes fit standard M8 screws. The plate is CNC machined, deburred and anodized for long-lasting corrosion protection.',
				'specifications' =>
					array(
						'Material'   => 'Aluminium 6060 T6',
						'Dimensions' => '120 × 80 mm',
						'Thickness'  => '5 mm',
						'Holes'      => '4 × Ø10 mm, 1 × Ø30 mm',
						'Finish'     => 'Natural anodized',
						'Weight'     => '116 g',
					),
			);

	//-> Document
		$pdf = new pdf();
		$pdf->text_font( __DIR__ . '/Montserrat.ttf' );
		$pdf->metadata( 'title', $product['name'] . ' ' . $product['reference'] );
		$pdf->metadata( 'subject', 'Product sheet' );

	//-> Header
		$pdf->fill_color( '#CDA869' )->stroke_width( 0 )->rectangle( 0, 0, 210, 30 );
		$pdf->text_size( 7 )->text_color( '#FFFFFF' )->text( 15, 15, 'PRODUCT SHEET', 0, 'middle-left' );
		$pdf->text_size( 5 )->text_color( '#FFFFFF' )->text( 195, 15, $product['reference'], 0, 'middle-right' );

	//-> Image
		$pdf->image( $product['image'], 15, 42, 80, 60 );
		$pdf->fill_color( '#00000000' )->stroke_color( '#DDDDDD' )->stroke_width( 0.3 )->rectangle( 15, 42, 80, 60 );

	//-> Name
		$pdf->text_size( 7 )->text_color( '#333333' )->text( 105, 42, $product['name'], 0, 'top-left' );
		$pdf->text_size( 4 )->text_color( '#CDA869' )->text( 105, 53, 'Ref. ' . $product['reference'], 0, 'top-left' );

	//-> Description
		$pdf->text_size( 3.5 )->text_color( '#555555' );
		$pdf->paragraph( 105, 62, 90, $product['description'], 0, 'justified', 'top-left', 5 );

	//-> Next position
		$y = max( 42 + 60, 62 + $pdf->paragraph_height( 90, $product['description'], 5 ) ) + 12;

	//-> Specifications
		$pdf->text_size( 5 )->text_color( '#333333' )->text( 15, $y, 'Specifications', 0, 'top-left' );
		$y += 12;
		foreach( $product['specifications'] as $label => $value ) {
			//-> Row
				$pdf->text_size( 3.5 )->text_color( '#999999' )->text( 15, $y + 4, $label, 0, 'middle-left' );
				$pdf->text_size( 3.5 )->text_color( '#333333' )->text( 75, $y + 4, $value, 0, 'middle-left' );
				$pdf->stroke_color( '#E5E5E5' )->stroke_width( 0.3 )->line( 15, $y + 8, 195, $y + 8 );
			//-> Next row
				$y += 8;
		}

	//-> Drawing
		$y += 12;
		$pdf->text_size( 5 )->text_color( '#333333' )->text( 15, $y, 'Dimensions', 0, 'top-left' );
		$canvas->scale( 0.5 );
		$canvas->translate( 55, $y - 5 );
		$pdf->append( $canvas );

	//-> Footer
		$pdf->stroke_color( '#DDDDDD' )->stroke_width( 0.3 )->line( 15, 282, 195, 282 );
		$pdf->text_size( 3 )->text_color( '#999999' )->text( 15, 287, 'Generated with Canvas PHP', 0, 'middle-left' );
		$pdf->link( 'https://github.com/ben-sta/canvas-php' )->text( 195, 287, 'github.com/ben-sta/canvas-php', 0, 'middle-right' );

	//-> Output
		$pdf->save( __DIR__ . '/product_sheet.pdf' );
		
	//-> SVG preview
		$preview = new svg( 210, 297, 'mm' );
		$preview->append( $pdf );
		$preview->save( __DIR__ . '/product_sheet.svg' );
