<?php

	//-> Require
		require_once( __DIR__ . '/../canvas.php' );

	//-> Dimension
		function dimension( $canvas, $x1, $y1, $x2, $y2, $offset, $label ) {
			//-> Layer
				$canvas->layer( 'Dimensions' );
			//-> Direction
				$length = hypot( $x2 - $x1, $y2 - $y1 );
				$ux     = ( $x2 - $x1 ) / $length;
				$uy     = ( $y2 - $y1 ) / $length;
				$nx     = $uy;
				$ny     = -$ux;
			//-> Side
				if( $offset > 0 ) {
					$side = 1;
				} else {
					$side = -1;
				}
			//-> Dimension line
				$ax = $x1 + $nx * $offset;
				$ay = $y1 + $ny * $offset;
				$bx = $x2 + $nx * $offset;
				$by = $y2 + $ny * $offset;
			//-> Lines
				$canvas
					->stroke_color( '#999999' )
					->stroke_width( 0.5 )
					->line( $x1 + $nx * $side * 5, $y1 + $ny * $side * 5, $ax + $nx * $side * 5, $ay + $ny * $side * 5 )
					->line( $x2 + $nx * $side * 5, $y2 + $ny * $side * 5, $bx + $nx * $side * 5, $by + $ny * $side * 5 )
					->line( $ax, $ay, $bx, $by )
					->line( $ax, $ay, $ax + $ux * 5 + $nx * 2, $ay + $uy * 5 + $ny * 2 )
					->line( $ax, $ay, $ax + $ux * 5 - $nx * 2, $ay + $uy * 5 - $ny * 2 )
					->line( $bx, $by, $bx - $ux * 5 + $nx * 2, $by - $uy * 5 + $ny * 2 )
					->line( $bx, $by, $bx - $ux * 5 - $nx * 2, $by - $uy * 5 - $ny * 2 );
			//-> Label
				$canvas
					->text_size( 8 )
					->text_color( '#999999' )
					->text( ( $ax + $bx ) / 2 + $nx * 3, ( $ay + $by ) / 2 + $ny * 3, $label, rad2deg( atan2( $uy, $ux ) ), 'bottom-center' );
		}
		
	//-> Hole
		function hole( $canvas, $x, $y, $radius ) {
			//-> Circle
				$canvas
					->layer( 'Outline' )
					->fill_color( '#FFFFFF' )
					->stroke_color( '#666666' )
					->stroke_width( 1 )
					->circle( $x, $y, $radius );
			//-> Axes
				$canvas
					->layer( 'Axes' )
					->stroke_color( '#CDA869' )
					->stroke_width( 0.5 )
					->line( $x - $radius - 5, $y, $x + $radius + 5, $y )
					->line( $x, $y - $radius - 5, $x, $y + $radius + 5 );
		}
		
	//-> Canvas
		$canvas = new canvas();
		$canvas->unit( 'mm' );
		$canvas->text_font( __DIR__ . '/Montserrat.ttf' );
		
	//-> Boundaries
		$canvas->layer( 'Outline' )->fill_color( '#F5F5F5' )->stroke_color( '#666666' )->stroke_width( 1 )->rectangle( 0, 0, 120, 80, 5 );
		
	//-> Holes
		hole( $canvas, 60, 40, 15 );
		hole( $canvas, 20, 20, 5 );
		hole( $canvas, 100, 20, 5 );
		hole( $canvas, 100, 60, 5 );
		hole( $canvas, 20, 60, 5 );
		
	//-> Dimensions
		dimension( $canvas, 0, 0, 120, 0, 20, '120' );
		dimension( $canvas, 0, 80, 0, 0, 20, '80' );
		dimension( $canvas, 20, 80, 100, 80, -20, '80' );
		dimension( $canvas, 120, 60, 120, 20, -20, '40' );
		
	//-> Diameters
		$canvas
			->layer( 'Dimensions' )
			->text_size( 8 )
			->text_color( '#999999' )
			->text( 63, 22, 'Ø30', 0, 'left-bottom' )
			->text( 25, 15, 'Ø10', 0, 'left-bottom' );
			
	//-> Center the plate on the page ( 200 x 200 )
		$canvas->translate( ( 100 - 60 ), ( 100 - 40 ) );
		
	//-> Output
		foreach( array( 'svg', 'pdf', 'dxf', 'jpg', 'png' ) as $format ) {
			//-> Document
				$document = new $format( 200, 200, 'mm' );
				$document->append( $canvas )->save( __DIR__ . '/technical_drawing.' . $format );
		}
		