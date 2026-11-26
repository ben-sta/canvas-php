<?php
	//-> Canvas PHP
		//-> https://github.com/ben-sta/canvas-php
		//-> Copyright (c) 2026 ben-sta
		//-> Released under the MIT License
	//-> Canvas
		class canvas {
			//-> Canvas
				protected $errors              = array();
				protected $width               = 0;
				protected $height              = 0;
				protected $unit                = 'px';
				protected $origin              = 'top-left';
				protected $layer               = '0';
				protected $link                = null;
				protected $text_font_directory = __DIR__ . '/fonts';
				protected $throw_exceptions    = false;
			//-> Style
				protected $style =
					array(
						'stroke_color'    => '#000000FF',
						'stroke_width'    => 1,
						'stroke_linecap'  => 'round',
						'stroke_linejoin' => 'round',
						'fill_color'      => '#000000FF',
						'text_font'       => '',
						'text_size'       => 10,
						'text_color'      => '#000000FF'
					);
			//-> Elements
				protected $elements = array();
			//-> Valid
				public function valid() {
					//-> Check
						if( count( $this->errors ) > 0 ) {
							//-> Return
								return false;
						} else {
							//-> Return
								return true;
						}
				}
			//-> Exceptions
				public function exceptions( $enabled = null ) {
					//-> Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->throw_exceptions;
						}
					//-> Check
						if( !is_bool( $enabled ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid value' );
							//-> Return
								return $this;
						}
					//-> Update
						$this->throw_exceptions = $enabled;
					//-> Return
						return $this;
				}
			//-> Errors
				public function errors() {
					//-> Return
						return $this->errors;
				}
			//-> Error
				protected function error( $message ) {
					//-> Message
						$message = strval( $message );
					//-> Add
						$this->errors[] = $message;
					//-> Reset link
						$this->link = null;
					//-> Exception
						if( $this->throw_exceptions ) {
							//-> Exception
								throw new \RuntimeException( $message );
						}
					//-> Return
						return $this;
				}
			//-> Size
				public function size( $width = null, $height = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return
									array(
										'width'  => $this->width,
										'height' => $this->height
									);
						}
					//-> Width
						$this->width( $width );
					//-> Check
						if( func_num_args() > 1 ) {
							//-> Height
								$this->height( $height );
						}
					//-> Return
						return $this;
				}
			//-> Width
				public function width( $width = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->width;
						}
					//-> Check
						if( !is_numeric( $width ) || floatval( $width ) <= 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Width must be greater than 0 : ' . var_export( $width, true ) );
							//-> Return
								return $this;
						}
					//-> Update
						$this->width = floatval( $width );
					//-> Return
						return $this;
				}
			//-> Height
				public function height( $height = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->height;
						}
					//-> Check
						if( !is_numeric( $height ) || floatval( $height ) <= 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Height must be greater than 0 : ' . var_export( $height, true ) );
							//-> Return
								return $this;
						}
					//-> Update
						$this->height = floatval( $height );
					//-> Return
						return $this;
				}
			//-> Unit
				public function unit( $unit = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->unit;
						}
					//-> Clean
						if( is_string( $unit ) ) {
							//-> Clean
								$unit = strtolower( trim( $unit ) );
						}
					//-> Check
						if( !is_string( $unit ) || !in_array( $unit, array( 'px', 'mm', 'cm', 'm', 'in', 'pt' ), true ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid unit : ' . var_export( $unit, true ) . ' ( px / mm / cm / m / in / pt )' );
							//-> Return
								return $this;
						}
					//-> Update
						$this->unit = $unit;
					//-> Return
						return $this;
				}
			//-> Origin
				public function origin( $origin = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->origin;
						}
					//-> Clean
						if( is_string( $origin ) ) {
							//-> Clean
								$origin = strtolower( trim( $origin ) );
						}
					//-> Alias
						if( $origin === 'screen' ) {
							//-> Update
								$origin = 'top-left';
						}
						if( $origin === 'cartesian' ) {
							//-> Update
								$origin = 'bottom-left';
						}
					//-> Check
						if( !is_string( $origin ) || !in_array( $origin, array( 'top-left', 'bottom-left' ), true ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid origin : ' . var_export( $origin, true ) . ' ( top-left / bottom-left )' );
							//-> Return
								return $this;
						}
					//-> Update
						$this->origin = $origin;
					//-> Return
						return $this;
				}
			//-> Layer
				public function layer( $layer = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->layer;
						}
					//-> Check
						if( !is_string( $layer ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid layer : ' . var_export( $layer, true ) );
							//-> Return
								return $this;
						}
					//-> Clean
						$layer = trim( $layer );
					//-> Check
						if( $layer === '' ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid layer : ' . var_export( $layer, true ) );
							//-> Return
								return $this;
						}
					//-> Update
						$this->layer = $layer;
					//-> Return
						return $this;
				}
			//-> Link
				public function link( $link = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->link;
						}
					//-> Reset
						if( $link === null ) {
							//-> Update
								$this->link = null;
							//-> Return
								return $this;
						}
					//-> Check
						if( !is_string( $link ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid link : ' . var_export( $link, true ) );
							//-> Return
								return $this;
						}
					//-> Clean
						$link = trim( $link );
					//-> Check
						if( $link === '' ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid link : ' . var_export( $link, true ) );
							//-> Return
								return $this;
						}
					//-> Update
						$this->link = $link;
					//-> Return
						return $this;
				}
			//-> Translate
				public function translate( $x, $y ) {
					//-> Check
						if( !is_numeric( $x ) || !is_numeric( $y ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid translation : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Normalize
						$x = floatval( $x );
						$y = floatval( $y );
					//-> Each
						foreach( $this->elements as &$element ) {
							//-> Type
								switch( $element['type'] ) {
									case 'line':
										//-> Translate
											$element['x1'] += $x;
											$element['y1'] += $y;
											$element['x2'] += $x;
											$element['y2'] += $y;
										break;
									case 'polyline':
										//-> Points
											for( $i = 0; $i < count( $element['points'] ); $i += 2 ) {
												//-> Translate
													$element['points'][ $i ] += $x;
													$element['points'][ $i + 1 ] += $y;
											}
										break;
									case 'rectangle':
									case 'circle':
									case 'ellipse':
									case 'arc':
									case 'ellipse_arc':
									case 'image':
									case 'text':
									case 'paragraph':
										//-> Translate
											$element['x'] += $x;
											$element['y'] += $y;
										break;
								}
						}
					//-> Clean
						unset( $element );
					//-> Return
						return $this;
				}
			//-> Translate X
				public function translate_x( $x ) {
					//-> Return
						return $this->translate( $x, 0 );
				}
			//-> Translate Y
				public function translate_y( $y ) {
					//-> Return
						return $this->translate( 0, $y );
				}
			//-> Scale
				public function scale( $factor ) {
					//-> Check
						if( !is_numeric( $factor ) || floatval( $factor ) <= 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Scale factor must be greater than 0 : ' . var_export( $factor, true ) );
							//-> Return
								return $this;
						}
					//-> Normalize
						$factor = floatval( $factor );
					//-> Canvas
						$this->width *= $factor;
						$this->height *= $factor;
					//-> Style
						$this->style['stroke_width'] *= $factor;
						$this->style['text_size'] *= $factor;
					//-> Each
						foreach( $this->elements as &$element ) {
							//-> Type
								switch( $element['type'] ) {
									case 'line':
										//-> Scale
											$element['x1'] *= $factor;
											$element['y1'] *= $factor;
											$element['x2'] *= $factor;
											$element['y2'] *= $factor;
											$element['stroke_width'] *= $factor;
										break;
									case 'polyline':
										//-> Points
											foreach( $element['points'] as &$point ) {
												//-> Update
													$point *= $factor;
											}
										//-> Clean
											unset( $point );
										//-> Scale
											$element['stroke_width'] *= $factor;
										break;
									case 'rectangle':
										//-> Scale
											$element['x'] *= $factor;
											$element['y'] *= $factor;
											$element['width'] *= $factor;
											$element['height'] *= $factor;
											$element['radius'] *= $factor;
											$element['stroke_width'] *= $factor;
										break;
									case 'circle':
										//-> Scale
											$element['x'] *= $factor;
											$element['y'] *= $factor;
											$element['radius'] *= $factor;
											$element['stroke_width'] *= $factor;
										break;
									case 'ellipse':
										//-> Scale
											$element['x'] *= $factor;
											$element['y'] *= $factor;
											$element['radius_x'] *= $factor;
											$element['radius_y'] *= $factor;
											$element['stroke_width'] *= $factor;
										break;
									case 'arc':
										//-> Scale
											$element['x'] *= $factor;
											$element['y'] *= $factor;
											$element['radius'] *= $factor;
											$element['stroke_width'] *= $factor;
										break;
									case 'ellipse_arc':
										//-> Scale
											$element['x'] *= $factor;
											$element['y'] *= $factor;
											$element['radius_x'] *= $factor;
											$element['radius_y'] *= $factor;
											$element['stroke_width'] *= $factor;
										break;
									case 'image':
										//-> Scale
											$element['x'] *= $factor;
											$element['y'] *= $factor;
											$element['width'] *= $factor;
											$element['height'] *= $factor;
										break;
									case 'text':
										//-> Scale
											$element['x'] *= $factor;
											$element['y'] *= $factor;
											$element['text_size'] *= $factor;
										break;
									case 'paragraph':
										//-> Scale
											$element['x'] *= $factor;
											$element['y'] *= $factor;
											$element['width'] *= $factor;
											$element['height'] *= $factor;
											$element['line_height'] *= $factor;
											$element['text_size'] *= $factor;
										break;
								}
						}
					//-> Clean
						unset( $element );
					//-> Return
						return $this;
				}
			//-> Elements
				public function elements() {
					//-> Return
						return $this->elements;
				}
			//-> Append
				public function append( $canvas ) {
					//-> Check
						if( !( $canvas instanceof canvas ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid canvas' );
							//-> Return
								return $this;
						}
					//-> Check
						if( !$canvas->valid() ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Canvas is invalid' );
							//-> Return
								return $this;
						}
					//-> Check
						if( $canvas->unit() !== $this->unit ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Canvas units must be identical : ' . var_export( array( $this->unit, $canvas->unit() ), true ) );
							//-> Return
								return $this;
						}
					//-> Check
						if( $canvas->origin() !== $this->origin ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Canvas origins must be identical : ' . var_export( array( $this->origin, $canvas->origin() ), true ) );
							//-> Return
								return $this;
						}
					//-> Elements
						$elements = $canvas->elements();
					//-> Each
						foreach( $elements as $element ) {
							//-> Add
								$this->elements[] = $element;
						}
					//-> Return
						return $this;
				}
			//-> Add
				protected function add( $type, $element ) {
					//-> Check
						if( !is_string( $type ) || trim( $type ) === '' ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid element type : ' . var_export( $type, true ) );
							//-> Return
								return $this;
						}
					//-> Check
						if( !is_array( $element ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Element must be an array' );
							//-> Return
								return $this;
						}
					//-> Clean
						$type = trim( $type );
					//-> Common
						$element['type']  = $type;
						$element['layer'] = $this->layer;
						$element['link']  = $this->link;
					//-> Add
						$this->elements[] = $element;
					//-> Reset
						$this->link = null;
					//-> Return
						return $this;
				}
			//-> Font directory
				public function text_font_directory( $directory = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->text_font_directory;
						}
					//-> Clean
						if( is_string( $directory ) ) {
							//-> Clean
								$directory = trim( $directory );
						}
					//-> Check
						if( !is_string( $directory ) || !is_dir( $directory ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Font directory not found : ' . var_export( $directory, true ) );
							//-> Return
								return $this;
						}
					//-> Update
						$this->text_font_directory = realpath( $directory );
					//-> Return
						return $this;
				}
			//-> Font directory alias
				public function font_directory( $directory = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->text_font_directory();
						} else {
							//-> Return
								return $this->text_font_directory( $directory );
						}
				}
			//-> Style
				public function style( $style = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->style;
						}
					//-> Check
						if( !is_array( $style ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Style must be an array' );
							//-> Return
								return $this;
						}
					//-> Each
						foreach( $style as $name => $value ) {
							//-> Alias
								if( $name === 'font' ) {
									//-> Update
										$name = 'text_font';
								}
								if( $name === 'font_size' ) {
									//-> Update
										$name = 'text_size';
								}
							//-> Update
								if( !array_key_exists( $name, $this->style ) || !method_exists( $this, $name ) ) {
									//-> Error
										$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unknown style property : ' . var_export( $name, true ) );
								} else {
									//-> Call
										$this->$name( $value );
								}
						}
					//-> Return
						return $this;
				}
			//-> Color
				protected function color( $color, $g = null, $b = null, $a = null ) {
					//-> Variable
						$count = func_num_args();
					//-> Check
						if( !in_array( $count, array( 1, 3, 4 ), true ) ) {
							//-> Return
								return null;
						}
					//-> Hex
						if( $count == 1 ) {
							//-> Check
								if( !is_string( $color ) ) {
									//-> Return
										return null;
								}
							//-> Clean
								$color = trim( $color );
							//-> Prefix
								if( substr( $color, 0, 1 ) === '#' ) {
									//-> Clean
										$color = substr( $color, 1 );
								}
							//-> Check
								if( !in_array( strlen( $color ), array( 6, 8 ), true ) ) {
									//-> Return
										return null;
								}
							//-> Check
								if( !ctype_xdigit( $color ) ) {
									//-> Return
										return null;
								}
							//-> Clean
								$color = strtoupper( $color );
							//-> Alpha
								if( strlen( $color ) < 8 ) {
									//-> Append
										$color .= 'FF';
								}
							//-> Return
								return '#' . $color;
						}
					//-> RGB
						if( !is_numeric( $color ) || !is_numeric( $g ) || !is_numeric( $b ) ) {
							//-> Return
								return null;
						}
					//-> Alpha
						if( $count == 4 && !is_numeric( $a ) ) {
							//-> Return
								return null;
						}
					//-> Normalize
						$r = min( 255, max( 0, intval( $color ) ) );
						$g = min( 255, max( 0, intval( $g ) ) );
						$b = min( 255, max( 0, intval( $b ) ) );
					//-> Alpha
						if( $count > 3 ) {
							//-> Update
								$a = min( 255, max( 0, intval( $a ) ) );
						} else {
							//-> Update
								$a = 255;
						}
					//-> Return
						return sprintf( '#%02X%02X%02X%02X', $r, $g, $b, $a );
				}
			//-> Stroke color
				public function stroke_color( $color = null, $g = null, $b = null, $a = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->style['stroke_color'];
						}
					//-> Color
						$stroke_color = call_user_func_array( array( $this, 'color' ), func_get_args() );
					//-> Check
						if( $stroke_color === null ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid stroke color : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Update
						$this->style['stroke_color'] = $stroke_color;
					//-> Return
						return $this;
				}
			//-> Stroke width
				public function stroke_width( $width = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->style['stroke_width'];
						}
					//-> Check
						if( !is_numeric( $width ) || floatval( $width ) < 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Stroke width must be greater than or equal to 0 : ' . var_export( $width, true ) );
							//-> Return
								return $this;
						}
					//-> Update
						$this->style['stroke_width'] = floatval( $width );
					//-> Return
						return $this;
				}
			//-> Stroke linecap
				public function stroke_linecap( $linecap = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->style['stroke_linecap'];
						}
					//-> Clean
						if( is_string( $linecap ) ) {
							//-> Clean
								$linecap = strtolower( trim( $linecap ) );
						}
					//-> Check
						if( !is_string( $linecap ) || !in_array( $linecap, array( 'butt', 'round', 'square' ), true ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid stroke linecap : ' . var_export( $linecap, true ) . ' ( butt / round / square )' );
							//-> Return
								return $this;
						}
					//-> Update
						$this->style['stroke_linecap'] = $linecap;
					//-> Return
						return $this;
				}
			//-> Stroke linejoin
				public function stroke_linejoin( $linejoin = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->style['stroke_linejoin'];
						}
					//-> Clean
						if( is_string( $linejoin ) ) {
							//-> Clean
								$linejoin = strtolower( trim( $linejoin ) );
						}
					//-> Check
						if( !is_string( $linejoin ) || !in_array( $linejoin, array( 'miter', 'round', 'bevel' ), true ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid stroke linejoin : ' . var_export( $linejoin, true ) . ' ( miter / round / bevel )' );
							//-> Return
								return $this;
						}
					//-> Update
						$this->style['stroke_linejoin'] = $linejoin;
					//-> Return
						return $this;
				}
			//-> Fill color
				public function fill_color( $color = null, $g = null, $b = null, $a = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->style['fill_color'];
						}
					//-> Color
						$fill_color = call_user_func_array( array( $this, 'color' ), func_get_args() );
					//-> Check
						if( $fill_color === null ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid fill color : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Update
						$this->style['fill_color'] = $fill_color;
					//-> Return
						return $this;
				}
			//-> Text font
				public function text_font( $font = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->style['text_font'];
						}
					//-> Check
						if( !is_string( $font ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid font : ' . var_export( $font, true ) );
							//-> Return
								return $this;
						}
					//-> Clean
						$font = trim( $font );
					//-> Direct file
						if( is_file( $font ) && strtolower( pathinfo( $font, PATHINFO_EXTENSION ) ) === 'ttf' ) {
							//-> Update
								$this->style['text_font'] = realpath( $font );
							//-> Return
								return $this;
						}
					//-> Font directory
						$file = rtrim( $this->text_font_directory, '/\\' ) . '/' . $font;
					//-> Extension
						if( strtolower( pathinfo( $file, PATHINFO_EXTENSION ) ) !== 'ttf' ) {
							//-> Update
								$file .= '.ttf';
						}
					//-> Check
						if( !is_file( $file ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Font file not found : ' . var_export( $font, true ) );
							//-> Return
								return $this;
						}
					//-> Update
						$this->style['text_font'] = realpath( $file );
					//-> Return
						return $this;
				}
			//-> Font
				public function font( $font = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->text_font();
						} else {
							//-> Return
								return $this->text_font( $font );
						}
				}
			//-> Text size
				public function text_size( $size = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->style['text_size'];
						}
					//-> Check
						if( !is_numeric( $size ) || floatval( $size ) <= 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Text size must be greater than 0 : ' . var_export( $size, true ) );
							//-> Return
								return $this;
						}
					//-> Update
						$this->style['text_size'] = floatval( $size );
					//-> Return
						return $this;
				}
			//-> Font size
				public function font_size( $size = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->text_size();
						} else {
							//-> Return
								return $this->text_size( $size );
						}
				}
			//-> Text color
				public function text_color( $color = null, $g = null, $b = null, $a = null ) {
					//-> Set / Get
						if( func_num_args() < 1 ) {
							//-> Return
								return $this->style['text_color'];
						}
					//-> Color
						$text_color = call_user_func_array( array( $this, 'color' ), func_get_args() );
					//-> Check
						if( $text_color === null ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid text color : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Update
						$this->style['text_color'] = $text_color;
					//-> Return
						return $this;
				}
			//-> Anchor
				protected function anchor( $anchor ) {
					//-> Check
						if( !is_string( $anchor ) ) {
							//-> Return
								return null;
						}
					//-> Clean
						$anchor = strtolower( trim( $anchor ) );
					//-> Alias
						switch( $anchor ) {
							case 'auto':
								//-> Return
									return 'auto';
							case 'top-left':
							case 'left-top':
								//-> Return
									return 'top-left';
							case 'top-center':
							case 'center-top':
								//-> Return
									return 'top-center';
							case 'top-right':
							case 'right-top':
								//-> Return
									return 'top-right';
							case 'middle-left':
							case 'center-left':
							case 'left-middle':
							case 'left-center':
								//-> Return
									return 'middle-left';
							case 'middle-center':
							case 'center-middle':
							case 'center-center':
							case 'center':
							case 'middle':
								//-> Return
									return 'middle-center';
							case 'middle-right':
							case 'center-right':
							case 'right-middle':
							case 'right-center':
								//-> Return
									return 'middle-right';
							case 'bottom-left':
							case 'left-bottom':
								//-> Return
									return 'bottom-left';
							case 'bottom-center':
							case 'center-bottom':
								//-> Return
									return 'bottom-center';
							case 'bottom-right':
							case 'right-bottom':
								//-> Return
									return 'bottom-right';
						}
					//-> Return
						return null;
				}
			//-> Angle
				protected function angle( $angle ) {
					//-> Check
						if( !is_numeric( $angle ) ) {
							//-> Return
								return null;
						}
					//-> Normalize
						$angle = fmod( floatval( $angle ), 360 );
					//-> Check
						if( $angle < 0 ) {
							//-> Update
								$angle += 360;
						}
					//-> Return
						return $angle;
				}
			//-> Points
				protected function points( $points ) {
					//-> Variable
						$flat = array();
					//-> Check
						if( !is_array( $points ) || count( $points ) < 1 ) {
							//-> Return
								return null;
						}
					//-> Flat
						if( array_key_exists( 0, $points ) && !is_array( $points[0] ) ) {
							//-> Check
								if( count( $points ) % 2 != 0 ) {
									//-> Return
										return null;
								}
							//-> Normalize
								foreach( $points as $value ) {
									//-> Check
										if( !is_numeric( $value ) ) {
											//-> Return
												return null;
										}
									//-> Update
										$flat[] = floatval( $value );
								}
						} else {
							//-> Each
								foreach( $points as $point ) {
									//-> Check
										if(
											!is_array( $point ) ||
											!array_key_exists( 0, $point ) ||
											!array_key_exists( 1, $point ) ||
											!is_numeric( $point[0] ) ||
											!is_numeric( $point[1] )
										) {
											//-> Return
												return null;
										}
									//-> Add
										$flat[] = floatval( $point[0] );
										$flat[] = floatval( $point[1] );
								}
						}
					//-> Return
						return $flat;
				}
			//-> Line
				public function line( $x1, $y1, $x2, $y2 ) {
					//-> Check
						if( !is_numeric( $x1 ) || !is_numeric( $y1 ) || !is_numeric( $x2 ) || !is_numeric( $y2 ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid coordinates : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Return
						return
							$this->add(
								'line',
								array(
									'x1'             => floatval( $x1 ),
									'y1'             => floatval( $y1 ),
									'x2'             => floatval( $x2 ),
									'y2'             => floatval( $y2 ),
									'stroke_color'   => $this->style['stroke_color'],
									'stroke_width'   => $this->style['stroke_width'],
									'stroke_linecap' => $this->style['stroke_linecap']
								)
							);
				}
			//-> Polyline
				public function polyline( $points = null ) {
					//-> Arguments
						$arguments = func_get_args();
					//-> Check
						if( count( $arguments ) < 1 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Points are required' );
							//-> Return
								return $this;
						}
					//-> Points
						if( count( $arguments ) > 1 ) {
							//-> Update
								$points = $arguments;
						}
					//-> Normalize
						$points = $this->points( $points );
					//-> Check
						if( $points === null || count( $points ) < 4 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid points : ' . var_export( $arguments, true ) );
							//-> Return
								return $this;
						}
					//-> Closed
						$closed = false;
					//-> Check
						if(
							$points[0] == $points[ count( $points ) - 2 ] &&
							$points[1] == $points[ count( $points ) - 1 ]
						) {
							//-> Update
								$closed = true;
							//-> Remove duplicate point
								array_pop( $points );
								array_pop( $points );
						}
					//-> Check
						if( $closed && count( $points ) < 6 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - A closed polyline requires at least 3 points' );
							//-> Return
								return $this;
						}
					//-> Return
						return
							$this->add(
								'polyline',
								array(
									'points'          => $points,
									'closed'          => $closed,
									'stroke_color'    => $this->style['stroke_color'],
									'stroke_width'    => $this->style['stroke_width'],
									'stroke_linecap'  => $this->style['stroke_linecap'],
									'stroke_linejoin' => $this->style['stroke_linejoin'],
									'fill_color'      => $this->style['fill_color']
								)
							);
				}
			//-> Rectangle
				public function rectangle( $x, $y, $width, $height, $radius = 0, $angle = 0, $anchor = 'auto' ) {
					//-> Check
						if(
							!is_numeric( $x ) ||
							!is_numeric( $y ) ||
							!is_numeric( $width ) ||
							!is_numeric( $height ) ||
							!is_numeric( $radius ) ||
							!is_numeric( $angle ) ||
							!is_string( $anchor )
						) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid rectangle : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Normalize
						$x      = floatval( $x );
						$y      = floatval( $y );
						$width  = floatval( $width );
						$height = floatval( $height );
						$radius = floatval( $radius );
						$angle  = $this->angle( $angle );
						$anchor = $this->anchor( $anchor );
					//-> Check
						if( $anchor === null ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid anchor : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Check
						if( $width <= 0 || $height <= 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Width and height must be greater than 0 : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Check
						if( $radius < 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Radius must be greater than or equal to 0 : ' . var_export( $radius, true ) );
							//-> Return
								return $this;
						}
					//-> Radius
						$radius = min( $radius, 0.5 * min( $width, $height ) );
					//-> Return
						return
							$this->add(
								'rectangle',
								array(
									'x'               => $x,
									'y'               => $y,
									'width'           => $width,
									'height'          => $height,
									'radius'          => $radius,
									'angle'           => $angle,
									'anchor'          => $anchor,
									'stroke_color'    => $this->style['stroke_color'],
									'stroke_width'    => $this->style['stroke_width'],
									'stroke_linejoin' => $this->style['stroke_linejoin'],
									'fill_color'      => $this->style['fill_color']
								)
							);
				}
			//-> Square
				public function square( $x, $y, $size, $radius = 0, $angle = 0, $anchor = 'auto' ) {
					//-> Return
						return $this->rectangle( $x, $y, $size, $size, $radius, $angle, $anchor );
				}
			//-> Circle
				public function circle( $x, $y, $radius ) {
					//-> Check
						if( !is_numeric( $x ) || !is_numeric( $y ) || !is_numeric( $radius ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid circle : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Normalize
						$x      = floatval( $x );
						$y      = floatval( $y );
						$radius = floatval( $radius );
					//-> Check
						if( $radius <= 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Radius must be greater than 0 : ' . var_export( $radius, true ) );
							//-> Return
								return $this;
						}
					//-> Return
						return
							$this->add(
								'circle',
								array(
									'x'            => $x,
									'y'            => $y,
									'radius'       => $radius,
									'stroke_color' => $this->style['stroke_color'],
									'stroke_width' => $this->style['stroke_width'],
									'fill_color'   => $this->style['fill_color']
								)
							);
				}
			//-> Ellipse
				public function ellipse( $x, $y, $radius_x, $radius_y, $angle = 0 ) {
					//-> Check
						if(
							!is_numeric( $x ) ||
							!is_numeric( $y ) ||
							!is_numeric( $radius_x ) ||
							!is_numeric( $radius_y ) ||
							!is_numeric( $angle )
						) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid ellipse : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Normalize
						$x        = floatval( $x );
						$y        = floatval( $y );
						$radius_x = floatval( $radius_x );
						$radius_y = floatval( $radius_y );
						$angle    = $this->angle( $angle );
					//-> Check
						if( $radius_x <= 0 || $radius_y <= 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Ellipse radii must be greater than 0 : ' . var_export( array( $radius_x, $radius_y ), true ) );
							//-> Return
								return $this;
						}
					//-> Return
						return
							$this->add(
								'ellipse',
								array(
									'x'            => $x,
									'y'            => $y,
									'radius_x'     => $radius_x,
									'radius_y'     => $radius_y,
									'angle'        => $angle,
									'stroke_color' => $this->style['stroke_color'],
									'stroke_width' => $this->style['stroke_width'],
									'fill_color'   => $this->style['fill_color']
								)
							);
				}
			//-> Arc
				public function arc( $x, $y, $radius, $start, $end ) {
					//-> Check
						if(
							!is_numeric( $x ) ||
							!is_numeric( $y ) ||
							!is_numeric( $radius ) ||
							!is_numeric( $start ) ||
							!is_numeric( $end )
						) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid arc : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Normalize
						$x      = floatval( $x );
						$y      = floatval( $y );
						$radius = floatval( $radius );
						$start  = $this->angle( $start );
						$end    = $this->angle( $end );
						$sweep  = fmod( ( $end - $start + 360 ), 360 );
					//-> Check
						if( $radius <= 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Radius must be greater than 0 : ' . var_export( $radius, true ) );
							//-> Return
								return $this;
						}
					//-> Check
						if( $sweep == 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Arc start and end angles must be different' );
							//-> Return
								return $this;
						}
					//-> Return
						return
							$this->add(
								'arc',
								array(
									'x'              => $x,
									'y'              => $y,
									'radius'         => $radius,
									'start'          => $start,
									'sweep'          => $sweep,
									'stroke_color'   => $this->style['stroke_color'],
									'stroke_width'   => $this->style['stroke_width'],
									'stroke_linecap' => $this->style['stroke_linecap']
								)
							);
				}
			//-> Ellipse arc
				public function ellipse_arc( $x, $y, $radius_x, $radius_y, $start, $end, $angle = 0 ) {
					//-> Check
						if(
							!is_numeric( $x ) ||
							!is_numeric( $y ) ||
							!is_numeric( $radius_x ) ||
							!is_numeric( $radius_y ) ||
							!is_numeric( $start ) ||
							!is_numeric( $end ) ||
							!is_numeric( $angle )
						) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid ellipse arc : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Normalize
						$x        = floatval( $x );
						$y        = floatval( $y );
						$radius_x = floatval( $radius_x );
						$radius_y = floatval( $radius_y );
						$start    = $this->angle( $start );
						$end      = $this->angle( $end );
						$angle    = $this->angle( $angle );
						$sweep    = fmod( ( $end - $start + 360 ), 360 );
					//-> Check
						if( $radius_x <= 0 || $radius_y <= 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Ellipse radii must be greater than 0 : ' . var_export( array( $radius_x, $radius_y ), true ) );
							//-> Return
								return $this;
						}
					//-> Check
						if( $sweep == 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Ellipse arc start and end angles must be different' );
							//-> Return
								return $this;
						}
					//-> Return
						return
							$this->add(
								'ellipse_arc',
								array(
									'x'              => $x,
									'y'              => $y,
									'radius_x'       => $radius_x,
									'radius_y'       => $radius_y,
									'start'          => $start,
									'sweep'          => $sweep,
									'angle'          => $angle,
									'stroke_color'   => $this->style['stroke_color'],
									'stroke_width'   => $this->style['stroke_width'],
									'stroke_linecap' => $this->style['stroke_linecap']
								)
							);
				}
			//-> Image
				public function image( $path, $x, $y, $width, $height, $angle = 0, $anchor = 'auto' ) {
					//-> Check
						if(
							!is_string( $path ) ||
							!is_numeric( $x ) ||
							!is_numeric( $y ) ||
							!is_numeric( $width ) ||
							!is_numeric( $height ) ||
							!is_numeric( $angle ) ||
							!is_string( $anchor )
						) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid image : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Clean
						$path = trim( $path );
					//-> Check
						if( !is_file( $path ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Image file not found : ' . var_export( $path, true ) );
							//-> Return
								return $this;
						}
					//-> Image
						$image = @getimagesize( $path );
					//-> Check
						if(
							!is_array( $image ) ||
							!isset( $image['mime'] ) ||
							!in_array( $image['mime'], array( 'image/jpeg', 'image/png' ), true )
						) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid image file : ' . var_export( $path, true ) );
							//-> Return
								return $this;
						}
					//-> Normalize
						$path   = realpath( $path );
						$x      = floatval( $x );
						$y      = floatval( $y );
						$width  = floatval( $width );
						$height = floatval( $height );
						$angle  = $this->angle( $angle );
						$anchor = $this->anchor( $anchor );
					//-> Check
						if( $anchor === null ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid anchor : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Check
						if( $width <= 0 || $height <= 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Width and height must be greater than 0 : ' . var_export( array( $width, $height ), true ) );
							//-> Return
								return $this;
						}
					//-> Return
						return
							$this->add(
								'image',
								array(
									'path'   => $path,
									'mime'   => $image['mime'],
									'x'      => $x,
									'y'      => $y,
									'width'  => $width,
									'height' => $height,
									'angle'  => $angle,
									'anchor' => $anchor
								)
							);
				}
			//-> Text
				public function text( $x, $y, $text, $angle = 0, $anchor = 'auto' ) {
					//-> Text
						if( is_numeric( $text ) ) {
							//-> Clean
								$text = strval( $text );
						}
					//-> Check
						if(
							!is_numeric( $x ) ||
							!is_numeric( $y ) ||
							!is_string( $text ) ||
							!is_numeric( $angle ) ||
							!is_string( $anchor )
						) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid text : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Empty
						if( $text === '' ) {
							//-> Reset
								$this->link = null;
							//-> Return
								return $this;
						}
					//-> Check
						if( !is_file( $this->style['text_font'] ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Text font is not defined' );
							//-> Return
								return $this;
						}
					//-> Check
						if( !preg_match( '//u', $text ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Text must be a valid UTF-8 string : ' . var_export( $text, true ) );
							//-> Return
								return $this;
						}
					//-> Check
						if( strpos( $text, "\n" ) !== false || strpos( $text, "\r" ) !== false ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Text must contain a single line' );
							//-> Return
								return $this;
						}
					//-> Normalize
						$x      = floatval( $x );
						$y      = floatval( $y );
						$angle  = $this->angle( $angle );
						$anchor = $this->anchor( $anchor );
					//-> Check
						if( $anchor === null ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid anchor : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Return
						return
							$this->add(
								'text',
								array(
									'x'          => $x,
									'y'          => $y,
									'text'       => $text,
									'angle'      => $angle,
									'anchor'     => $anchor,
									'text_font'  => $this->style['text_font'],
									'text_size'  => $this->style['text_size'],
									'text_color' => $this->style['text_color']
								)
							);
				}
			//-> Text width
				public function text_width( $text ) {
					//-> Text
						if( is_numeric( $text ) ) {
							//-> Clean
								$text = strval( $text );
						}
					//-> Check
						if( !is_file( $this->style['text_font'] ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Text font is not defined' );
							//-> Return
								return null;
						}
					//-> Check
						if( !is_string( $text ) || !preg_match( '//u', $text ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Text must be a valid UTF-8 string : ' . var_export( $text, true ) );
							//-> Return
								return null;
						}
					//-> Check
						if( strpos( $text, "\n" ) !== false || strpos( $text, "\r" ) !== false ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Text must contain a single line' );
							//-> Return
								return null;
						}
					//-> Width
						$width = canvas_ttf::width( $this->style['text_font'], $text, $this->style['text_size'] );
					//-> Check
						if( $width === null ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to calculate text width' );
							//-> Return
								return null;
						}
					//-> Return
						return $width;
				}
			//-> Paragraph lines
				protected function paragraph_lines( $width, $text ) {
					//-> Result
						$result = array();
					//-> Normalize
						$text = str_replace( "\r\n", "\n", $text );
						$text = str_replace( "\r", "\n", $text );
					//-> Paragraphs
						$paragraphs = explode( "\n", $text );
					//-> Each
						foreach( $paragraphs as $paragraph ) {
							//-> Lines
								$lines = array();
							//-> Clean
								$paragraph = trim( $paragraph );
							//-> Empty
								if( $paragraph === '' ) {
									//-> Add
										$lines[] = '';
									//-> Add
										$result[] = $lines;
									//-> Continue
										continue;
								}
							//-> Words
								$words = preg_split( '/[ \t]+/', $paragraph );
							//-> Check
								if( $words === false ) {
									//-> Return
										return null;
								}
							//-> Line
								$line = '';
							//-> Each
								foreach( $words as $word ) {
									//-> Empty
										if( $word === '' ) {
											//-> Continue
												continue;
										}
									//-> Value
										$value = $word;
										if( $line !== '' ) {
											//-> Update
												$value = $line . ' ' . $word;
										}
									//-> Width
										$text_width = $this->text_width( $value );
									//-> Check
										if( !is_numeric( $text_width ) ) {
											//-> Return
												return null;
										}
									//-> Fit
										if( $text_width <= $width ) {
											//-> Update
												$line = $value;
											//-> Continue
												continue;
										}
									//-> Add
										if( $line !== '' ) {
											//-> Add
												$lines[] = $line;
										}
									//-> Update
										$line = $word;
								}
							//-> Add
								if( $line !== '' ) {
									//-> Add
										$lines[] = $line;
								}
							//-> Add
								$result[] = $lines;
						}
					//-> Return
						return $result;
				}
			//-> Paragraph height
				public function paragraph_height( $width, $text, $line_height = null ) {
					//-> Text
						if( is_numeric( $text ) ) {
							//-> Clean
								$text = strval( $text );
						}
					//-> Check
						if( !is_numeric( $width ) || !is_string( $text ) || ( $line_height !== null && !is_numeric( $line_height ) ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid paragraph : ' . var_export( func_get_args(), true ) );
							//-> Return
								return null;
						}
					//-> Clean
						$width = floatval( $width );
					//-> Check
						if( $line_height === null ) {
							//-> Update
								$line_height = $this->style['text_size'];
						} else {
							//-> Update
								$line_height = floatval( $line_height );
						}
					//-> Check
						if( $width <= 0 || $line_height <= 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid paragraph : ' . var_export( func_get_args(), true ) );
							//-> Return
								return null;
						}
					//-> Check
						if( !is_file( $this->style['text_font'] ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Text font is not defined' );
							//-> Return
								return null;
						}
					//-> Check
						if( !preg_match( '//u', $text ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Text must be a valid UTF-8 string : ' . var_export( $text, true ) );
							//-> Return
								return null;
						}
					//-> Empty
						if( $text === '' ) {
							//-> Return
								return 0;
						}
					//-> Paragraphs
						$paragraphs = $this->paragraph_lines( $width, $text );
					//-> Check
						if( $paragraphs === null ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to calculate paragraph' );
							//-> Return
								return null;
						}
					//-> Lines
						$line_count = 0;
						foreach( $paragraphs as $paragraph ) {
							//-> Update
								$line_count += count( $paragraph );
						}
					//-> Empty
						if( $line_count < 1 ) {
							//-> Return
								return 0;
						}
					//-> Return
						return ( $this->style['text_size'] + ( ( $line_count - 1 ) * $line_height ) );
				}
			//-> Paragraph
				public function paragraph( $x, $y, $width, $text, $angle = 0, $align = 'left', $anchor = 'auto', $line_height = null ) {
					//-> Text
						if( is_numeric( $text ) ) {
							//-> Clean
								$text = strval( $text );
						}
					//-> Check
						if(
							!is_numeric( $x ) ||
							!is_numeric( $y ) ||
							!is_numeric( $width ) ||
							!is_string( $text ) ||
							!is_numeric( $angle ) ||
							!is_string( $anchor ) ||
							!is_string( $align ) ||
							( $line_height !== null && !is_numeric( $line_height ) )
						) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid paragraph : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Empty
						if( $text === '' ) {
							//-> Reset
								$this->link = null;
							//-> Return
								return $this;
						}
					//-> Check
						if( !is_file( $this->style['text_font'] ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Text font is not defined' );
							//-> Return
								return $this;
						}
					//-> Check
						if( !preg_match( '//u', $text ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Text must be a valid UTF-8 string : ' . var_export( $text, true ) );
							//-> Return
								return $this;
						}
					//-> Normalize
						$x      = floatval( $x );
						$y      = floatval( $y );
						$width  = floatval( $width );
						$angle  = $this->angle( $angle );
						$anchor = $this->anchor( $anchor );
						$align  = strtolower( trim( $align ) );
					//-> Check
						if( $line_height === null ) {
							//-> Update
								$line_height = $this->style['text_size'];
						} else {
							//-> Update
								$line_height = floatval( $line_height );
						}
					//-> Check
						if(
							$width <= 0 ||
							$line_height <= 0 ||
							$anchor === null ||
							!in_array( $align, array( 'left', 'center', 'right', 'justified' ), true )
						) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid paragraph : ' . var_export( func_get_args(), true ) );
							//-> Return
								return $this;
						}
					//-> Paragraphs
						$paragraphs = $this->paragraph_lines( $width, $text );
					//-> Check
						if( $paragraphs === null ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to calculate paragraph' );
							//-> Return
								return $this;
						}
					//-> Lines
						$line_count = 0;
					//-> Each
						foreach( $paragraphs as $paragraph ) {
							//-> Update
								$line_count += count( $paragraph );
						}
					//-> Height
						$height = ( $this->style['text_size'] + ( ( $line_count - 1 ) * $line_height ) );
					//-> Return
						return
							$this->add(
								'paragraph',
								array(
									'x'           => $x,
									'y'           => $y,
									'width'       => $width,
									'height'      => $height,
									'paragraphs'  => $paragraphs,
									'angle'       => $angle,
									'anchor'      => $anchor,
									'align'       => $align,
									'line_height' => $line_height,
									'text_font'   => $this->style['text_font'],
									'text_size'   => $this->style['text_size'],
									'text_color'  => $this->style['text_color']
								)
							);
				}
		}
	//-> Canvas TTF
		class canvas_ttf {
			//-> Fonts
				protected static $fonts = array();
			//-> Width
				public static function width( $font, $text, $size ) {
					//-> Variables
						$width = 0;
					//-> Check
						if( !is_string( $font ) || !is_string( $text ) || !is_numeric( $size ) ) {
							//-> Return
								return null;
						}
					//-> Clean
						$size = floatval( $size );
					//-> Check
						if(
							$size <= 0 ||
							!is_file( $font ) ||
							strtolower( pathinfo( $font, PATHINFO_EXTENSION ) ) !== 'ttf' ||
							!preg_match( '//u', $text ) ||
							strpos( $text, "\n" ) !== false ||
							strpos( $text, "\r" ) !== false
						) {
							//-> Return
								return null;
						}
					//-> Clean
						$font = realpath( $font );
					//-> Font
						if( !isset( self::$fonts[ $font ] ) ) {
							//-> Load
								if( !self::load( $font ) ) {
									//-> Return
										return null;
								}
						}
					//-> Empty
						if( $text === '' ) {
							//-> Return
								return $width;
						}
					//-> Characters
						$characters = self::characters( $text );
					//-> Check
						if( $characters === null ) {
							//-> Return
								return null;
						}
					//-> Each
						foreach( $characters as $character ) {
							//-> Check
								if( !isset( self::$fonts[ $font ]['widths'][ $character ] ) ) {
									//-> Return
										return null;
								}
							//-> Add
								$width += self::$fonts[ $font ]['widths'][ $character ];
						}
					//-> Return
						return ( ( $width * $size ) / self::$fonts[ $font ]['units_per_em'] );
				}
			//-> Characters
				public static function characters( $text ) {
					//-> Variables
						$characters = array();
						$length     = strlen( $text );
					//-> Parse
						for( $i = 0; $i < $length; $i++ ) {
							//-> First byte
								$byte      = ord( $text[ $i ] );
								$bytes     = 1;
								$character = $byte;
							//-> Check
								if( ( $byte >= 128 && $byte <= 193 ) || $byte > 244 ) {
									//-> Return
										return null;
								}
							//-> 2 bytes
								if( $byte >= 194 ) {
									//-> Update
										$bytes     = 2;
										$character = $byte - 192;
								}
							//-> 3 bytes
								if( $byte >= 224 ) {
									//-> Update
										$bytes     = 3;
										$character = $byte - 224;
								}
							//-> 4 bytes
								if( $byte >= 240 ) {
									//-> Update
										$bytes     = 4;
										$character = $byte - 240;
								}
							//-> Next bytes
								for( $j = 1; $j < $bytes; $j++ ) {
									//-> Check
										if( ( $i + 1 ) >= $length ) {
											//-> Return
												return null;
										}
									//-> Next byte
										$i++;
										$byte = ord( $text[ $i ] );
									//-> Check
										if( $byte < 128 || $byte > 191 ) {
											//-> Return
												return null;
										}
									//-> Character
										$character = $character * 64 + ( $byte - 128 );
								}
							//-> Check
								if(
									( $bytes === 2 && $character < 128 ) ||
									( $bytes === 3 && $character < 2048 ) ||
									( $bytes === 4 && $character < 65536 ) ||
									( $character >= 55296 && $character <= 57343 ) ||
									$character > 1114111
								) {
									//-> Return
										return null;
								}
							//-> Add
								$characters[] = $character;
						}
					//-> Return
						return $characters;
				}
			//-> Metrics
				public static function metrics( $font, $size ) {
					//-> Check
						if( !is_string( $font ) || !is_numeric( $size ) ) {
							//-> Return
								return null;
						}
					//-> Clean
						$size = floatval( $size );
					//-> Check
						if( $size <= 0 || !is_file( $font ) || strtolower( pathinfo( $font, PATHINFO_EXTENSION ) ) !== 'ttf' ) {
							//-> Return
								return null;
						}
					//-> Clean
						$font = realpath( $font );
					//-> Font
						if( !isset( self::$fonts[ $font ] ) ) {
							//-> Load
								if( !self::load( $font ) ) {
									//-> Return
										return null;
								}
						}
					//-> Scale
						$scale = $size / self::$fonts[ $font ]['units_per_em'];
					//-> Metrics
						$height   = self::$fonts[ $font ]['cap_height'] * $scale;
						$ascent   = self::$fonts[ $font ]['ascent'] * $scale;
						$descent  = self::$fonts[ $font ]['descent'] * $scale;
						$line_gap = self::$fonts[ $font ]['line_gap'] * $scale;
					//-> Return
						return
							array(
								'family'      => self::$fonts[ $font ]['family'],
								'height'      => $height,
								'ascent'      => $ascent,
								'descent'     => $descent,
								'line_gap'    => $line_gap,
								'line_height' => $ascent - $descent + $line_gap
							);
				}
			//-> Data
				public static function data( $font ) {
					//-> Check
						if( !is_string( $font ) || !is_file( $font ) || strtolower( pathinfo( $font, PATHINFO_EXTENSION ) ) !== 'ttf' ) {
							//-> Return
								return null;
						}
					//-> Path
						$font = realpath( $font );
					//-> Load
						if( !isset( self::$fonts[ $font ] ) && !self::load( $font ) ) {
							//-> Return
								return null;
						}
					//-> Return
						return self::$fonts[ $font ];
				}
			//-> Read unsigned 16 bits
				protected static function read_unsigned_16( $file ) {
					//-> Read
						$data = fread( $file, 2 );
					//-> Check
						if( $data === false || strlen( $data ) !== 2 ) {
							//-> Return
								return null;
						}
					//-> Value
						$value = unpack( 'nvalue', $data );
					//-> Return
						return $value['value'];
				}
			//-> Read signed 16 bits
				protected static function read_signed_16( $file ) {
					//-> Value
						$value = self::read_unsigned_16( $file );
					//-> Check
						if( $value === null ) {
							//-> Return
								return null;
						}
					//-> Signed
						if( $value >= 32768 ) {
							//-> Update
								$value -= 65536;
						}
					//-> Return
						return $value;
				}
			//-> Read unsigned 32 bits
				protected static function read_unsigned_32( $file ) {
					//-> Values
						$high = self::read_unsigned_16( $file );
						$low  = self::read_unsigned_16( $file );
					//-> Check
						if( $high === null || $low === null ) {
							//-> Return
								return null;
						}
					//-> Return
						return ( ( $high * 65536 ) + $low );
				}
			//-> Load
				protected static function load( $font ) {
					//-> Open
						$file = fopen( $font, 'rb' );
					//-> Check
						if( $file === false ) {
							//-> Return
								return false;
						}
					//-> File size
						$stat = fstat( $file );
					//-> Check
						if( $stat === false || !isset( $stat['size'] ) || $stat['size'] < 12 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Size
						$file_size = $stat['size'];
					//-> Signature
						$signature = fread( $file, 4 );
					//-> Check
						if( $signature !== "\x00\x01\x00\x00" && $signature !== 'true' ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Number of tables
						$num_tables = self::read_unsigned_16( $file );
					//-> Check
						if( $num_tables === null || $num_tables <= 0 || ( 12 + ( $num_tables * 16 ) ) > $file_size ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Skip header
						if( fseek( $file, 6, SEEK_CUR ) !== 0 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Tables
						$tables = array();
					//-> Each
						for( $i = 0; $i < $num_tables; $i++ ) {
							//-> Tag
								$tag = fread( $file, 4 );
							//-> Check
								if( $tag === false || strlen( $tag ) !== 4 ) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
							//-> Skip checksum
								if( fseek( $file, 4, SEEK_CUR ) !== 0 ) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
							//-> Values
								$offset = self::read_unsigned_32( $file );
								$length = self::read_unsigned_32( $file );
							//-> Check
								if(
									$offset === null ||
									$length === null ||
									$offset > $file_size ||
									$length > ( $file_size - $offset )
								) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
							//-> Keep
								if( in_array( $tag, array( 'head', 'hhea', 'maxp', 'hmtx', 'cmap', 'name', 'OS/2' ), true ) ) {
									//-> Add
										$tables[ $tag ] =
											array(
												'offset' => $offset,
												'length' => $length
											);
								}
						}
					//-> Check tables
						if(
							!isset( $tables['head'] ) ||
							!isset( $tables['hhea'] ) ||
							!isset( $tables['maxp'] ) ||
							!isset( $tables['hmtx'] ) ||
							!isset( $tables['cmap'] )
						) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Check head
						if( $tables['head']['length'] < 20 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Head
						if( fseek( $file, $tables['head']['offset'] + 12, SEEK_SET ) !== 0 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Magic number
						$magic_number = self::read_unsigned_32( $file );
					//-> Check
						if( $magic_number === null || $magic_number != 1594834165 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Units per em
						if( fseek( $file, $tables['head']['offset'] + 18, SEEK_SET ) !== 0 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Read
						$units_per_em = self::read_unsigned_16( $file );
					//-> Check
						if( $units_per_em === null || $units_per_em < 16 || $units_per_em > 16384 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Bounding box
						if( $tables['head']['length'] < 44 || fseek( $file, $tables['head']['offset'] + 36, SEEK_SET ) !== 0 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Values
						$bbox =
							array(
								self::read_signed_16( $file ),
								self::read_signed_16( $file ),
								self::read_signed_16( $file ),
								self::read_signed_16( $file )
							);
					//-> Check
						if( in_array( null, $bbox, true ) ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Check hhea
						if( $tables['hhea']['length'] < 36 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Hhea
						if( fseek( $file, $tables['hhea']['offset'], SEEK_SET ) !== 0 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Version
						$version = self::read_unsigned_32( $file );
					//-> Check
						if( $version === null || $version != 65536 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Metrics
						$ascent     = self::read_signed_16( $file );
						$descent    = self::read_signed_16( $file );
						$line_gap   = self::read_signed_16( $file );
						$cap_height = $ascent;
					//-> OS/2
						if( isset( $tables['OS/2'] ) && $tables['OS/2']['length'] >= 70 ) {
							//-> Version
								if( fseek( $file, $tables['OS/2']['offset'], SEEK_SET ) !== 0 ) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
								$os2_version = self::read_unsigned_16( $file );
							//-> Cap height fallback
								if( fseek( $file, $tables['OS/2']['offset'] + 68, SEEK_SET ) !== 0 ) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
								$value = self::read_signed_16( $file );
							//-> Check
								if( $value !== null && $value > 0 ) {
									//-> Update
										$cap_height = $value;
								}
							//-> Cap height
								if( $os2_version !== null && $os2_version >= 2 && $tables['OS/2']['length'] >= 90 ) {
									//-> Seek
										if( fseek( $file, $tables['OS/2']['offset'] + 88, SEEK_SET ) !== 0 ) {
											//-> Close
												fclose( $file );
											//-> Return
												return false;
										}
									//-> Read
										$value = self::read_signed_16( $file );
									//-> Check
										if( $value !== null && $value > 0 ) {
											//-> Update
												$cap_height = $value;
										}
								}
						}
					//-> Check
						if( $ascent === null || $descent === null || $line_gap === null ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Number of horizontal metrics
						if( fseek( $file, $tables['hhea']['offset'] + 34, SEEK_SET ) !== 0 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Read
						$number_of_hmetrics = self::read_unsigned_16( $file );
					//-> Check
						if( $number_of_hmetrics === null || $number_of_hmetrics <= 0 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Check maxp
						if( $tables['maxp']['length'] < 6 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Maxp
						if( fseek( $file, $tables['maxp']['offset'], SEEK_SET ) !== 0 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Version
						$version = self::read_unsigned_32( $file );
					//-> Check
						if( $version === null || $version != 65536 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Glyph count
						$glyph_count = self::read_unsigned_16( $file );
					//-> Check
						if( $glyph_count === null || $glyph_count <= 0 || $number_of_hmetrics > $glyph_count ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Hmtx size
						$hmtx_length = ( $number_of_hmetrics * 4 ) + ( ( $glyph_count - $number_of_hmetrics ) * 2 );
					//-> Check hmtx
						if( $tables['hmtx']['length'] < $hmtx_length ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Hmtx
						if( fseek( $file, $tables['hmtx']['offset'], SEEK_SET ) !== 0 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Glyph widths
						$glyph_widths = array();
					//-> Metrics
						for( $i = 0; $i < $number_of_hmetrics; $i++ ) {
							//-> Width
								$width = self::read_unsigned_16( $file );
							//-> Check
								if( $width === null ) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
							//-> Add
								$glyph_widths[ $i ] = $width;
							//-> Skip left side bearing
								if( fseek( $file, 2, SEEK_CUR ) !== 0 ) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
						}
					//-> Remaining glyphs
						for( $i = $number_of_hmetrics; $i < $glyph_count; $i++ ) {
							//-> Width
								$glyph_widths[ $i ] = $width;
						}
					//-> Check cmap
						if( $tables['cmap']['length'] < 4 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Cmap
						if( fseek( $file, $tables['cmap']['offset'], SEEK_SET ) !== 0 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Header
						$version     = self::read_unsigned_16( $file );
						$cmap_tables = self::read_unsigned_16( $file );
					//-> Check
						if(
							$version === null ||
							$cmap_tables === null ||
							$version !== 0 ||
							$cmap_tables <= 0 ||
							( 4 + ( $cmap_tables * 8 ) ) > $tables['cmap']['length']
						) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Records
						$records = array();
					//-> Each
						for( $i = 0; $i < $cmap_tables; $i++ ) {
							//-> Values
								$platform = self::read_unsigned_16( $file );
								$encoding = self::read_unsigned_16( $file );
								$offset   = self::read_unsigned_32( $file );
							//-> Check
								if( $platform === null || $encoding === null || $offset === null ) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
							//-> Unicode
								if(
									( $platform === 0 && in_array( $encoding, array( 3, 4 ), true ) ) ||
									( $platform === 3 && in_array( $encoding, array( 1, 10 ), true ) )
								) {
									//-> Add
										$records[] =
											array(
												'platform' => $platform,
												'encoding' => $encoding,
												'offset'   => $offset
											);
								}
						}
					//-> Formats
						$cmap_4  = null;
						$cmap_12 = null;
					//-> Each
						foreach( $records as $record ) {
							//-> Check
								if( ( $record['offset'] + 2 ) > $tables['cmap']['length'] ) {
									//-> Continue
										continue;
								}
							//-> Subtable
								if( fseek( $file, $tables['cmap']['offset'] + $record['offset'], SEEK_SET ) !== 0 ) {
									//-> Continue
										continue;
								}
							//-> Format
								$format = self::read_unsigned_16( $file );
							//-> Format 12
								if(
									$format === 12 &&
									( ( $record['platform'] === 0 && $record['encoding'] === 4 ) || ( $record['platform'] === 3 && $record['encoding'] === 10 ) )
								) {
									//-> Update
										$cmap_12 = $record['offset'];
								}
							//-> Format 4
								if(
									$format === 4 &&
									( ( $record['platform'] === 0 && $record['encoding'] === 3 ) || ( $record['platform'] === 3 && $record['encoding'] === 1 ) )
								) {
									//-> Update
										$cmap_4 = $record['offset'];
								}
						}
					//-> Select cmap
						$cmap_offset = null;
						if( $cmap_12 !== null ) {
							//-> Update
								$cmap_offset = $cmap_12;
						}
						if( $cmap_offset === null && $cmap_4 !== null ) {
							//-> Update
								$cmap_offset = $cmap_4;
						}
					//-> Check
						if( $cmap_offset === null ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Cmap
						if( fseek( $file, $tables['cmap']['offset'] + $cmap_offset, SEEK_SET ) !== 0 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Format
						$format = self::read_unsigned_16( $file );
					//-> Check
						if( $format !== 4 && $format !== 12 ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Widths
						$widths = array();
						$glyphs = array();
					//-> Format 12
						if( $format === 12 ) {
							//-> Reserved
								$reserved = self::read_unsigned_16( $file );
							//-> Values
								$length   = self::read_unsigned_32( $file );
								$language = self::read_unsigned_32( $file );
								$groups   = self::read_unsigned_32( $file );
							//-> Check
								if(
									$reserved === null ||
									$length === null ||
									$language === null ||
									$groups === null ||
									$reserved !== 0 ||
									$length < 16 ||
									$length > ( $tables['cmap']['length'] - $cmap_offset ) ||
									$groups > floor( ( $length - 16 ) / 12 )
								) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
							//-> Groups
								for( $i = 0; $i < $groups; $i++ ) {
									//-> Values
										$start       = self::read_unsigned_32( $file );
										$end         = self::read_unsigned_32( $file );
										$start_glyph = self::read_unsigned_32( $file );
									//-> Check
										if( $start === null || $end === null || $start_glyph === null || $start > $end || $end > 1114111 ) {
											//-> Close
												fclose( $file );
											//-> Return
												return false;
										}
									//-> Characters
										for( $character = $start; $character <= $end; $character++ ) {
											//-> Glyph
												$glyph = $start_glyph + ( $character - $start );
											//-> Missing
												if( $glyph === 0 ) {
													//-> Continue
														continue;
												}
											//-> Check
												if( $glyph >= $glyph_count || !isset( $glyph_widths[ $glyph ] ) ) {
													//-> Close
														fclose( $file );
													//-> Return
														return false;
												}
											//-> Add
												$widths[ $character ] = $glyph_widths[ $glyph ];
												$glyphs[ $character ] = $glyph;
										}
								}
						}
					//-> Format 4
						if( $format === 4 ) {
							//-> Values
								$length        = self::read_unsigned_16( $file );
								$language      = self::read_unsigned_16( $file );
								$segment_count = self::read_unsigned_16( $file );
							//-> Check
								if(
									$length === null ||
									$language === null ||
									$segment_count === null ||
									$length < 24 ||
									$length > ( $tables['cmap']['length'] - $cmap_offset ) ||
									$segment_count <= 0 ||
									( $segment_count % 2 ) !== 0
								) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
							//-> Segment count
								$segment_count = intval( 0.5 * $segment_count );
							//-> Check
								if( ( 16 + ( $segment_count * 8 ) ) > $length ) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
							//-> Skip search values
								if( fseek( $file, 6, SEEK_CUR ) !== 0 ) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
							//-> Arrays
								$end_codes     = array();
								$start_codes   = array();
								$deltas        = array();
								$range_offsets = array();
								$range_places  = array();
							//-> End codes
								for( $i = 0; $i < $segment_count; $i++ ) {
									//-> End
										$end_codes[ $i ] = self::read_unsigned_16( $file );
									//-> Check
										if( $end_codes[ $i ] === null ) {
											//-> Close
												fclose( $file );
											//-> Return
												return false;
										}
								}
							//-> Reserved
								$reserved = self::read_unsigned_16( $file );
							//-> Check
								if( $reserved === null || $reserved !== 0 ) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
							//-> Start codes
								for( $i = 0; $i < $segment_count; $i++ ) {
									//-> Start
										$start_codes[ $i ] = self::read_unsigned_16( $file );
									//-> Check
										if( $start_codes[ $i ] === null ) {
											//-> Close
												fclose( $file );
											//-> Return
												return false;
										}
								}
							//-> Deltas
								for( $i = 0; $i < $segment_count; $i++ ) {
									//-> Delta
										$deltas[ $i ] = self::read_signed_16( $file );
									//-> Check
										if( $deltas[ $i ] === null ) {
											//-> Close
												fclose( $file );
											//-> Return
												return false;
										}
								}
							//-> Range offsets
								for( $i = 0; $i < $segment_count; $i++ ) {
									//-> Position
										$range_places[ $i ] = ftell( $file );
									//-> Check
										if( $range_places[ $i ] === false ) {
											//-> Close
												fclose( $file );
											//-> Return
												return false;
										}
									//-> Offset
										$range_offsets[ $i ] = self::read_unsigned_16( $file );
									//-> Check
										if( $range_offsets[ $i ] === null ) {
											//-> Close
												fclose( $file );
											//-> Return
												return false;
										}
								}
							//-> Check last segment
								if( $start_codes[ $segment_count - 1 ] !== 65535 || $end_codes[ $segment_count - 1 ] !== 65535 ) {
									//-> Close
										fclose( $file );
									//-> Return
										return false;
								}
							//-> Subtable limits
								$cmap_start = $tables['cmap']['offset'] + $cmap_offset;
								$cmap_end   = $cmap_start + $length;
							//-> Segments
								for( $i = 0; $i < $segment_count; $i++ ) {
									//-> Check
										if( $start_codes[ $i ] > $end_codes[ $i ] ) {
											//-> Close
												fclose( $file );
											//-> Return
												return false;
										}
									//-> Characters
										for( $character = $start_codes[ $i ]; $character <= $end_codes[ $i ]; $character++ ) {
											//-> Glyph
												$glyph = 0;
											//-> Delta
												if( $range_offsets[ $i ] === 0 ) {
													//-> Update
														$glyph = ( $character + $deltas[ $i ] ) % 65536;
													//-> Check
														if( $glyph < 0 ) {
															//-> Update
																$glyph += 65536;
														}
												}
											//-> Range
												if( $range_offsets[ $i ] !== 0 ) {
													//-> Position
														$position = $range_places[ $i ] + $range_offsets[ $i ] + ( ( $character - $start_codes[ $i ] ) * 2 );
													//-> Check
														if( $position < $cmap_start || ( $position + 2 ) > $cmap_end || fseek( $file, $position, SEEK_SET ) !== 0 ) {
															//-> Close
																fclose( $file );
															//-> Return
																return false;
														}
													//-> Glyph
														$glyph = self::read_unsigned_16( $file );
													//-> Check
														if( $glyph === null ) {
															//-> Close
																fclose( $file );
															//-> Return
																return false;
														}
													//-> Delta
														if( $glyph !== 0 ) {
															//-> Update
																$glyph = ( $glyph + $deltas[ $i ] ) % 65536;
															//-> Check
																if( $glyph < 0 ) {
																	//-> Update
																		$glyph += 65536;
																}
														}
												}
											//-> Missing
												if( $glyph === 0 ) {
													//-> Continue
														continue;
												}
											//-> Check
												if( $glyph >= $glyph_count || !isset( $glyph_widths[ $glyph ] ) ) {
													//-> Close
														fclose( $file );
													//-> Return
														return false;
												}
											//-> Add
												$widths[ $character ] = $glyph_widths[ $glyph ];
												$glyphs[ $character ] = $glyph;
										}
								}
						}
					//-> Check widths
						if( empty( $widths ) ) {
							//-> Close
								fclose( $file );
							//-> Return
								return false;
						}
					//-> Family
						$family = null;
					//-> Check
						if( isset( $tables['name'] ) && $tables['name']['length'] >= 6 ) {
							//-> Header
								fseek( $file, $tables['name']['offset'], SEEK_SET );
								$format        = self::read_unsigned_16( $file );
								$count         = self::read_unsigned_16( $file );
								$string_offset = self::read_unsigned_16( $file );
							//-> Records
								for( $i = 0; $i < $count; $i++ ) {
									//-> Values
										$platform = self::read_unsigned_16( $file );
										$encoding = self::read_unsigned_16( $file );
										$language = self::read_unsigned_16( $file );
										$name     = self::read_unsigned_16( $file );
										$length   = self::read_unsigned_16( $file );
										$offset   = self::read_unsigned_16( $file );
									//-> Family
										if(
											$family === null &&
											$name == 1 &&
											$platform == 3 &&
											in_array( $encoding, array( 1, 10 ), true ) &&
											$length >= 2 &&
											( $string_offset + $offset + $length ) <= $tables['name']['length']
										) {
											//-> Variables
												$position = $tables['name']['offset'] + $string_offset + $offset;
												$current  = ftell( $file );
												$value    = '';
											//-> Read
												fseek( $file, $position, SEEK_SET );
												$data = fread( $file, $length );
											//-> Restore
												fseek( $file, $current, SEEK_SET );
											//-> Decode
												for( $j = 0; ( $j + 1 ) < strlen( $data ); $j += 2 ) {
													//-> Character
														$character = ( ord( $data[ $j ] ) * 256 ) + ord( $data[ $j + 1 ] );
													//-> Surrogates
														if( $character >= 55296 && $character <= 57343 ) {
															//-> Continue
																continue;
														}
													//-> Check
														if( $character < 128 ) {
															//-> ASCII
																$value .= chr( $character );
														} elseif( $character < 2048 ) {
															//-> UTF-8 2 bytes
																$value .= chr( 192 + floor( $character / 64 ) ) . chr( 128 + ( $character % 64 ) );
														} else {
															//-> UTF-8 3 bytes
																$value .= chr( 224 + floor( $character / 4096 ) ) . chr( 128 + ( floor( $character / 64 ) % 64 ) ) . chr( 128 + ( $character % 64 ) );
														}
												}
											//-> Clean
												$value = trim( $value );
											//-> Check
												if( $value !== '' ) {
													//-> Update
														$family = $value;
												}
										}
								}
						}
					//-> Close
						fclose( $file );
					//-> Font
						self::$fonts[ $font ] =
							array(
								'units_per_em' => $units_per_em,
								'ascent'       => $ascent,
								'descent'      => $descent,
								'line_gap'     => $line_gap,
								'cap_height'   => $cap_height,
								'widths'       => $widths,
								'glyphs'       => $glyphs,
								'bbox'         => $bbox,
								'family'       => $family
							);
					//-> Return
						return true;
				}
		}
	//-> Renderer
		abstract class canvas_renderer extends canvas {
			//-> Renderer
				protected $mime = 'application/octet-stream';
			//-> Build
				abstract protected function build();
			//-> Data
				public function data() {
					//-> Check
						if( !$this->valid() ) {
							//-> Return
								return null;
						}
					//-> Data
						$data = $this->build();
					//-> Check
						if( !$this->valid() ) {
							//-> Return
								return null;
						}
					//-> Check
						if( !is_string( $data ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to build data' );
							//-> Return
								return null;
						}
					//-> Return
						return $data;
				}
			//-> Save
				public function save( $filename ) {
					//-> Check
						if( !is_string( $filename ) || trim( $filename ) === '' ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid filename : ' . var_export( $filename, true ) );
							//-> Return
								return $this;
						}
					//-> Clean
						$filename = trim( $filename );
					//-> Data
						$data = $this->data();
					//-> Check
						if( !is_string( $data ) ) {
							//-> Return
								return $this;
						}
					//-> Save
						if( @file_put_contents( $filename, $data ) !== strlen( $data ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to save file : ' . var_export( $filename, true ) );
							//-> Return
								return $this;
						}
					//-> Return
						return $this;
				}
			//-> Show
				public function show() {
					//-> Data
						$data = $this->data();
					//-> Check
						if( !is_string( $data ) ) {
							//-> Return
								return $this;
						}
					//-> Check
						if( headers_sent() ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Headers already sent' );
							//-> Return
								return $this;
						}
					//-> Header
						header( 'Content-Type: ' . $this->mime );
					//-> Output
						echo $data;
					//-> Exit
						exit;
				}
			//-> Download
				public function download( $filename ) {
					//-> Check
						if( !is_string( $filename ) || trim( $filename ) === '' ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid filename : ' . var_export( $filename, true ) );
							//-> Return
								return $this;
						}
					//-> Clean
						$filename = basename( trim( $filename ) );
						$filename = str_replace( array( "\r", "\n", '"' ), '', $filename );
					//-> Check
						if( $filename === '' ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid filename' );
							//-> Return
								return $this;
						}
					//-> Data
						$data = $this->data();
					//-> Check
						if( !is_string( $data ) ) {
							//-> Return
								return $this;
						}
					//-> Check
						if( headers_sent() ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Headers already sent' );
							//-> Return
								return $this;
						}
					//-> Headers
						header( 'Content-Type: ' . $this->mime );
						header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
					//-> Output
						echo $data;
					//-> Exit
						exit;
				}
		}
	//-> SVG
		class canvas_svg extends canvas_renderer {
			//-> Variable
				protected $mime = 'image/svg+xml';
			//-> Constructor
				public function __construct( $width = null, $height = null, $unit = 'px' ) {
					//-> Unit
						$this->unit( $unit );
					//-> Width
						if( $width !== null ) {
							//-> Update
								$this->width( $width );
						}
					//-> Height
						if( $height !== null ) {
							//-> Update
								$this->height( $height );
						}
				}
			//-> Tag
				protected function svg_tag( $name, $attributes = array(), $content = null ) {
					//-> XML
						$xml = '/\A[\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]*\z/u';
					//-> Each
						foreach( $attributes as $key => $value ) {
							//-> Skip
								if( $value === null ) {
									//-> Delete
										unset( $attributes[ $key ] );
								} else {
									//-> Check
										if( !preg_match( $xml, strval( $value ) ) ) {
											//-> Error
												$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid SVG attribute : ' . var_export( $key, true ) );
											//-> Return
												return null;
										}
									//-> Update
										$attributes[ $key ] = $key . '="' . htmlspecialchars( strval( $value ), ENT_QUOTES | ENT_XML1, 'UTF-8' ) . '"';
								}
						}
					//-> Attributes
						$attributes = implode( ' ', $attributes );
					//-> Content
						if( is_array( $content ) ) {
							//-> Update
								$content = implode( "\n", $content );
						} else {
							//-> Check
								if( $content !== null ) {
									//-> Check
										if( !preg_match( $xml, strval( $content ) ) ) {
											//-> Error
												$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid SVG text' );
											//-> Return
												return null;
										}
									//-> Update
										$content = htmlspecialchars( strval( $content ), ENT_QUOTES | ENT_XML1, 'UTF-8' );
								}
						}
					//-> Check
						if( $content === null ) {
							//-> Return
								return '<' . implode( ' ', array_filter( array( $name, $attributes ), 'strlen' ) ) . '/>';
						} else {
							//-> Return
								return '<' . implode( ' ', array_filter( array( $name, $attributes ), 'strlen' ) ) . '>' . $content . '</' . $name . '>';
						}
				}
			//-> Y
				protected function svg_y( $y ) {
					//-> Origin
						if( $this->origin() === 'bottom-left' ) {
							//-> Return
								return ( $this->height() - $y );
						}
					//-> Return
						return $y;
				}
			//-> Position X
				protected function svg_position_x( $x, $width, $anchor ) {
					//-> Switch
						switch( $anchor ) {
							case 'top-center':
							case 'middle-center':
							case 'bottom-center':
								//-> Return
									return ( $x - ( 0.5 * $width ) );
							case 'top-right':
							case 'middle-right':
							case 'bottom-right':
								//-> Return
									return ( $x - $width );
						}
					//-> Return
						return $x;
				}
			//-> Position Y
				protected function svg_position_y( $y, $height, $anchor ) {
					//-> Auto
						if( $anchor === 'auto' ) {
							//-> Origin
								if( $this->origin() === 'bottom-left' ) {
									//-> Return
										return ( $y - $height );
								}
							//-> Return
								return $y;
						}
					//-> Switch
						switch( $anchor ) {
							case 'middle-left':
							case 'middle-center':
							case 'middle-right':
								//-> Return
									return ( $y - ( 0.5 * $height ) );
							case 'bottom-left':
							case 'bottom-center':
							case 'bottom-right':
								//-> Return
									return ( $y - $height );
						}
					//-> Return
						return $y;
				}
			//-> Opacity
				protected function svg_opacity( $color ) {
					//-> Return
						return ( hexdec( substr( $color, 7, 2 ) ) / 255 );
				}
			//-> Build
				protected function build() {
					//-> Canvas
						$canvas_width  = $this->width();
						$canvas_height = $this->height();
						$unit          = $this->unit();
					//-> Check
						if( $canvas_width <= 0 || $canvas_height <= 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid canvas size' );
							//-> Return
								return null;
						}
					//-> Output
						$viewbox_width  = $canvas_width;
						$viewbox_height = $canvas_height;
						$output_width   = $canvas_width;
						$output_height  = $canvas_height;
						$output_unit    = $unit;
					//-> Meter
						if( $unit === 'm' ) {
							//-> Convert
								$output_width *= 1000;
								$output_height *= 1000;
								$output_unit = 'mm';
						}
					//-> Content
						$content     = array();
						$fonts       = array();
						$layer       = null;
						$layer_nodes = array();
					//-> Each
						foreach( $this->elements() as $element ) {
							//-> Layer
								if( !preg_match( '/\A[\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]*\z/u', $element['layer'] ) ) {
									//-> Error
										$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid SVG layer name : ' . var_export( $element['layer'], true ) );
									//-> Return
										return null;
								}
							//-> Layer change
								if( $layer !== null && $layer !== $element['layer'] ) {
									//-> Group
										$content[] = $this->svg_tag( 'g', array( 'class' => 'canvas-layer-' . md5( $layer ), 'data-layer' => $layer ), $layer_nodes );
									//-> Reset
										$layer_nodes = array();
								}
							//-> Current layer
								$layer = $element['layer'];
							//-> Variable
								$node = null;
							//-> Type
								switch( $element['type'] ) {
									case 'line':
										//-> Add
											$node =
												$this->svg_tag(
													'line',
													array(
														'x1'             => $element['x1'],
														'y1'             => $this->svg_y( $element['y1'] ),
														'x2'             => $element['x2'],
														'y2'             => $this->svg_y( $element['y2'] ),
														'stroke'         => substr( $element['stroke_color'], 0, 7 ),
														'stroke-opacity' => $this->svg_opacity( $element['stroke_color'] ),
														'stroke-width'   => $element['stroke_width'],
														'stroke-linecap' => $element['stroke_linecap']
													)
												);
										break;
									case 'polyline':
										//-> Points
											$points = array();
										//-> Each
											for( $i = 0; $i < count( $element['points'] ); $i += 2 ) {
												//-> Add
													$points[] = $element['points'][ $i ] . ',' . $this->svg_y( $element['points'][ $i + 1 ] );
											}
										//-> Closed
											if( $element['closed'] ) {
												//-> Variables
													$name         = 'polygon';
													$fill         = substr( $element['fill_color'], 0, 7 );
													$fill_opacity = $this->svg_opacity( $element['fill_color'] );
											} else {
												//-> Variables
													$name         = 'polyline';
													$fill         = 'none';
													$fill_opacity = null;
											}
										//-> Add
											$node =
												$this->svg_tag(
													$name,
													array(
														'points'          => implode( ' ', $points ),
														'stroke'          => substr( $element['stroke_color'], 0, 7 ),
														'stroke-opacity'  => $this->svg_opacity( $element['stroke_color'] ),
														'stroke-width'    => $element['stroke_width'],
														'stroke-linecap'  => $element['stroke_linecap'],
														'stroke-linejoin' => $element['stroke_linejoin'],
														'fill'            => $fill,
														'fill-opacity'    => $fill_opacity
													)
												);
										break;
									case 'rectangle':
										//-> Variables
											$transform = null;
											$radius    = null;
											$angle     = $element['angle'];
											$x         = $element['x'];
											$y         = $this->svg_y( $element['y'] );
										//-> Origin
											if( $this->origin() === 'bottom-left' ) {
												//-> Update
													$angle = -$angle;
											}
										//-> Transform
											if( $angle != 0 ) {
												//-> Update
													$transform = 'rotate(' . $angle . ' ' . $x . ' ' . $y . ')';
											}
										//-> Anchor
											$x = $this->svg_position_x( $x, $element['width'], $element['anchor'] );
											$y = $this->svg_position_y( $y, $element['height'], $element['anchor'] );
										//-> Radius
											if( $element['radius'] > 0 ) {
												//-> Update
													$radius = $element['radius'];
											}
										//-> Add
											$node =
												$this->svg_tag(
													'rect',
													array(
														'x'               => $x,
														'y'               => $y,
														'width'           => $element['width'],
														'height'          => $element['height'],
														'rx'              => $radius,
														'ry'              => $radius,
														'stroke'          => substr( $element['stroke_color'], 0, 7 ),
														'stroke-opacity'  => $this->svg_opacity( $element['stroke_color'] ),
														'stroke-width'    => $element['stroke_width'],
														'stroke-linejoin' => $element['stroke_linejoin'],
														'fill'            => substr( $element['fill_color'], 0, 7 ),
														'fill-opacity'    => $this->svg_opacity( $element['fill_color'] ),
														'transform'       => $transform
													)
												);
										break;
									case 'circle':
										//-> Add
											$node =
												$this->svg_tag(
													'circle',
													array(
														'cx'             => $element['x'],
														'cy'             => $this->svg_y( $element['y'] ),
														'r'              => $element['radius'],
														'stroke'         => substr( $element['stroke_color'], 0, 7 ),
														'stroke-opacity' => $this->svg_opacity( $element['stroke_color'] ),
														'stroke-width'   => $element['stroke_width'],
														'fill'           => substr( $element['fill_color'], 0, 7 ),
														'fill-opacity'   => $this->svg_opacity( $element['fill_color'] )
													)
												);
										break;
									case 'ellipse':
										//-> Variables
											$transform = null;
											$angle     = $element['angle'];
											$x         = $element['x'];
											$y         = $this->svg_y( $element['y'] );
										//-> Origin
											if( $this->origin() === 'bottom-left' ) {
												//-> Update
													$angle = -$angle;
											}
										//-> Transform
											if( $angle != 0 ) {
												//-> Update
													$transform = 'rotate(' . $angle . ' ' . $x . ' ' . $y . ')';
											}
										//-> Add
											$node =
												$this->svg_tag(
													'ellipse',
													array(
														'cx'             => $x,
														'cy'             => $y,
														'rx'             => $element['radius_x'],
														'ry'             => $element['radius_y'],
														'stroke'         => substr( $element['stroke_color'], 0, 7 ),
														'stroke-opacity' => $this->svg_opacity( $element['stroke_color'] ),
														'stroke-width'   => $element['stroke_width'],
														'fill'           => substr( $element['fill_color'], 0, 7 ),
														'fill-opacity'   => $this->svg_opacity( $element['fill_color'] ),
														'transform'      => $transform
													)
												);
										break;
									case 'arc':
										//-> Variables
											$start = deg2rad( $element['start'] );
											$end   = deg2rad( $element['start'] + $element['sweep'] );
											$large = 0;
											$sweep = 1;
										//-> Points
											$x1 = $element['x'] + ( $element['radius'] * cos( $start ) );
											$y1 = $element['y'] + ( $element['radius'] * sin( $start ) );
											$x2 = $element['x'] + ( $element['radius'] * cos( $end ) );
											$y2 = $element['y'] + ( $element['radius'] * sin( $end ) );
										//-> Large
											if( $element['sweep'] > 180 ) {
												//-> Update
													$large = 1;
											}
										//-> Origin
											if( $this->origin() === 'bottom-left' ) {
												//-> Update
													$sweep = 0;
											}
										//-> Path
											$path = implode( ' ', array( 'M', $x1, $this->svg_y( $y1 ), 'A', $element['radius'], $element['radius'], 0, $large, $sweep, $x2, $this->svg_y( $y2 ) ) );
										//-> Add
											$node =
												$this->svg_tag(
													'path',
													array(
														'd'              => $path,
														'stroke'         => substr( $element['stroke_color'], 0, 7 ),
														'stroke-opacity' => $this->svg_opacity( $element['stroke_color'] ),
														'stroke-width'   => $element['stroke_width'],
														'stroke-linecap' => $element['stroke_linecap'],
														'fill'           => 'none'
													)
												);
										break;
									case 'ellipse_arc':
										//-> Variables
											$transform = null;
											$angle     = $element['angle'];
											$start     = deg2rad( $element['start'] );
											$end       = deg2rad( $element['start'] + $element['sweep'] );
											$large     = 0;
											$sweep     = 1;
											$x         = $element['x'];
											$y         = $this->svg_y( $element['y'] );
										//-> Points
											$x1 = $element['x'] + ( $element['radius_x'] * cos( $start ) );
											$y1 = $element['y'] + ( $element['radius_y'] * sin( $start ) );
											$x2 = $element['x'] + ( $element['radius_x'] * cos( $end ) );
											$y2 = $element['y'] + ( $element['radius_y'] * sin( $end ) );
										//-> Large
											if( $element['sweep'] > 180 ) {
												//-> Update
													$large = 1;
											}
										//-> Origin
											if( $this->origin() === 'bottom-left' ) {
												//-> Update
													$angle = -$angle;
													$sweep = 0;
											}
										//-> Transform
											if( $angle != 0 ) {
												//-> Update
													$transform = 'rotate(' . $angle . ' ' . $x . ' ' . $y . ')';
											}
										//-> Path
											$path = implode( ' ', array( 'M', $x1, $this->svg_y( $y1 ), 'A', $element['radius_x'], $element['radius_y'], 0, $large, $sweep, $x2, $this->svg_y( $y2 ) ) );
										//-> Add
											$node =
												$this->svg_tag(
													'path',
													array(
														'd'              => $path,
														'stroke'         => substr( $element['stroke_color'], 0, 7 ),
														'stroke-opacity' => $this->svg_opacity( $element['stroke_color'] ),
														'stroke-width'   => $element['stroke_width'],
														'stroke-linecap' => $element['stroke_linecap'],
														'fill'           => 'none',
														'transform'      => $transform
													)
												);
										break;
									case 'image':
										//-> Variables
											$transform = null;
											$angle     = $element['angle'];
											$x         = $element['x'];
											$y         = $this->svg_y( $element['y'] );
											$image     = @file_get_contents( $element['path'] );
										//-> Check
											if( $image === false ) {
												//-> Error
													$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to read image : ' . var_export( $element['path'], true ) );
												//-> Return
													return null;
											}
										//-> Source
											$source = 'data:' . $element['mime'] . ';base64,' . base64_encode( $image );
										//-> Origin
											if( $this->origin() === 'bottom-left' ) {
												//-> Update
													$angle = -$angle;
											}
										//-> Transform
											if( $angle != 0 ) {
												//-> Update
													$transform = 'rotate(' . $angle . ' ' . $x . ' ' . $y . ')';
											}
										//-> Anchor
											$x = $this->svg_position_x( $x, $element['width'], $element['anchor'] );
											$y = $this->svg_position_y( $y, $element['height'], $element['anchor'] );
										//-> Add
											$node =
												$this->svg_tag(
													'image',
													array(
														'x'                   => $x,
														'y'                   => $y,
														'width'               => $element['width'],
														'height'              => $element['height'],
														'href'                => $source,
														'preserveAspectRatio' => 'none',
														'transform'           => $transform
													)
												);
										break;
									case 'text':
										//-> Variables
											$transform   = null;
											$angle       = $element['angle'];
											$x           = $element['x'];
											$y           = $this->svg_y( $element['y'] );
											$rotate_x    = $x;
											$rotate_y    = $y;
											$metrics     = canvas_ttf::metrics( $element['text_font'], $element['text_size'] );
											$width       = canvas_ttf::width( $element['text_font'], $element['text'], $element['text_size'] );
											$font        = 'canvas-' . md5( $element['text_font'] );
											$font_family = array( '"' . $font . '"' );
										//-> Check
											if( !is_array( $metrics ) ) {
												//-> Error
													$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to read font metrics : ' . var_export( $element['text_font'], true ) );
												//-> Return
													return null;
											}
										//-> Check
											if( !is_numeric( $width ) ) {
												//-> Error
													$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to calculate text width' );
												//-> Return
													return null;
											}
										//-> Origin
											if( $this->origin() === 'bottom-left' ) {
												//-> Update
													$angle = -$angle;
											}
										//-> Transform
											if( $angle != 0 ) {
												//-> Update
													$transform = 'rotate(' . $angle . ' ' . $rotate_x . ' ' . $rotate_y . ')';
											}
										//-> Anchor
											$x = $this->svg_position_x( $x, $width, $element['anchor'] );
											$y = $metrics['height'] + $this->svg_position_y( $y, $metrics['height'], $element['anchor'] );
										//-> Check
											if( !isset( $fonts[ $font ] ) ) {
												//-> Data
													$font_data = @file_get_contents( $element['text_font'] );
												//-> Check
													if( $font_data === false ) {
														//-> Error
															$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to read font : ' . var_export( $element['text_font'], true ) );
														//-> Return
															return null;
													}
												//-> Add
													$fonts[ $font ] = '@font-face{ font-family:' . $font . '; src:url(data:font/ttf;base64,' . base64_encode( $font_data ) . '); }';
											}
										//-> Font family
											if( is_string( $metrics['family'] ) && $metrics['family'] !== '' ) {
												//-> Add
													$font_family[] = '"' . $metrics['family'] . '"';
											}
										//-> Add
											$node =
												$this->svg_tag(
													'text',
													array(
														'x'            => $x,
														'y'            => $y,
														'font-family'  => implode( ', ', $font_family ),
														'font-size'    => $element['text_size'],
														'fill'         => substr( $element['text_color'], 0, 7 ),
														'fill-opacity' => $this->svg_opacity( $element['text_color'] ),
														'transform'    => $transform,
														'style'        => 'font-kerning:none',
														'xml:space'    => 'preserve',
													),
													$element['text']
												);
										break;
									case 'paragraph':
										//-> Variables
											$transform   = null;
											$angle       = $element['angle'];
											$x           = $element['x'];
											$y           = $this->svg_y( $element['y'] );
											$rotate_x    = $x;
											$rotate_y    = $y;
											$metrics     = canvas_ttf::metrics( $element['text_font'], $element['text_size'] );
											$font        = 'canvas-' . md5( $element['text_font'] );
											$font_family = array( '"' . $font . '"' );
											$lines       = array();
											$line_index  = 0;
										//-> Check
											if( !is_array( $metrics ) ) {
												//-> Error
													$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to read font metrics : ' . var_export( $element['text_font'], true ) );
												//-> Return
													return null;
											}
										//-> Origin
											if( $this->origin() === 'bottom-left' ) {
												//-> Update
													$angle = -$angle;
											}
										//-> Transform
											if( $angle != 0 ) {
												//-> Update
													$transform = 'rotate(' . $angle . ' ' . $rotate_x . ' ' . $rotate_y . ')';
											}
										//-> Anchor
											$x = $this->svg_position_x( $x, $element['width'], $element['anchor'] );
											$y = $this->svg_position_y( $y, $element['height'], $element['anchor'] );
										//-> Check
											if( !isset( $fonts[ $font ] ) ) {
												//-> Data
													$font_data = @file_get_contents( $element['text_font'] );
												//-> Check
													if( $font_data === false ) {
														//-> Error
															$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to read font : ' . var_export( $element['text_font'], true ) );
														//-> Return
															return null;
													}
												//-> Add
													$fonts[ $font ] = '@font-face{ font-family:' . $font . '; src:url(data:font/ttf;base64,' . base64_encode( $font_data ) . '); }';
											}
										//-> Paragraphs
											foreach( $element['paragraphs'] as $paragraph ) {
												//-> Each
													foreach( $paragraph as $line_number => $line ) {
														//-> Variables
															$line_x       = $x;
															$line_y       = $y + $metrics['height'] + ( $line_index * $element['line_height'] );
															$word_spacing = null;
															$line_width   = canvas_ttf::width( $element['text_font'], $line, $element['text_size'] );
														//-> Check
															if( !is_numeric( $line_width ) ) {
																//-> Error
																	$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to calculate paragraph line width' );
																//-> Return
																	return null;
															}
														//-> Align
															if( $element['align'] === 'center' ) {
																//-> Update
																	$line_x += 0.5 * ( $element['width'] - $line_width );
															}
															if( $element['align'] === 'right' ) {
																//-> Update
																	$line_x += $element['width'] - $line_width;
															}
														//-> Justified
															if( $element['align'] === 'justified' && $line_number < ( count( $paragraph ) - 1 ) ) {
																//-> Spaces
																	$spaces = substr_count( $line, ' ' );
																//-> Check
																	if( $spaces > 0 ) {
																		//-> Update
																			$word_spacing = ( $element['width'] - $line_width ) / $spaces;
																	}
															}
														//-> Add
															$lines[] =
																$this->svg_tag(
																	'tspan',
																	array(
																		'x'            => $line_x,
																		'y'            => $line_y,
																		'word-spacing' => $word_spacing
																	),
																	$line
																);
														//-> Next
															$line_index++;
													}
											}
										//-> Font family
											if( is_string( $metrics['family'] ) && $metrics['family'] !== '' ) {
												//-> Add
													$font_family[] = '"' . $metrics['family'] . '"';
											}
										//-> Add
											$node =
												$this->svg_tag(
													'text',
													array(
														'font-family'  => implode( ', ', $font_family ),
														'font-size'    => $element['text_size'],
														'fill'         => substr( $element['text_color'], 0, 7 ),
														'fill-opacity' => $this->svg_opacity( $element['text_color'] ),
														'transform'    => $transform,
														'style'        => 'font-kerning:none',
														'xml:space'    => 'preserve'
													),
													$lines
												);
										break;
									default:
										//-> Error
											$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unsupported element : ' . var_export( $element['type'], true ) );
										//-> Return
											return null;
								}
							//-> Link
								if( is_string( $element['link'] ) ) {
									//-> Wrap
										$layer_nodes[] = $this->svg_tag( 'a', array( 'href' => $element['link'] ), array( $node ) );
								} else {
									//-> Add
										$layer_nodes[] = $node;
								}
						}
					//-> Last layer
						if( $layer !== null ) {
							//-> Group
								$content[] =
									$this->svg_tag(
										'g',
										array(
											'class'      => 'canvas-layer-' . md5( $layer ),
											'data-layer' => $layer
										),
										$layer_nodes
									);
						}
					//-> Fonts
						if( count( $fonts ) > 0 ) {
							//-> Add
								array_unshift(
									$content,
									$this->svg_tag(
										'defs',
										array(),
										array(
											$this->svg_tag(
												'style',
												array( 'type' => 'text/css' ),
												implode( "\n", $fonts )
											)
										)
									)
								);
						}
					//-> SVG
						$svg =
							$this->svg_tag(
								'svg',
								array(
									'xmlns'   => 'http://www.w3.org/2000/svg',
									'width'   => $output_width . $output_unit,
									'height'  => $output_height . $output_unit,
									'viewBox' => '0 0 ' . $viewbox_width . ' ' . $viewbox_height
								),
								$content
							);
					//-> Return
						return implode( "\n", array( '<?xml version="1.0" encoding="UTF-8"?>', $svg ) );
				}
		}
	//-> DXF
		class canvas_dxf extends canvas_renderer {
			//-> Variables
				protected $mime               = 'image/vnd.dxf';
				protected $handle             = 256;
				protected $entities           = array();
				protected $model_space_handle = null;
			//-> Constructor
				public function __construct( $width = null, $height = null, $unit = 'mm' ) {
					//-> Unit
						$this->unit( $unit );
					//-> Width
						if( $width !== null ) {
							//-> Update
								$this->width( $width );
						}
					//-> Height
						if( $height !== null ) {
							//-> Update
								$this->height( $height );
						}
				}
			//-> Entity
				protected function dxf_entity( $type, $layer, $data = array() ) {
					//-> Add
						array_push(
							$this->entities,
							0,   $type,
							5,   strtoupper( dechex( $this->handle ) ),
							330, $this->model_space_handle,
							100, 'AcDbEntity',
							8,   strtoupper( $layer )
						);
					//-> Data
						foreach( $data as $value ) {
							//-> Add
								array_push( $this->entities, $value );
						}
					//-> Next
						$this->handle++;
				}
			//-> Unit code
				protected function dxf_unit_code() {
					//-> Unit
						if( $this->unit() === 'in' ) {
							//-> Return
								return 1;
						}
						if( $this->unit() === 'cm' ) {
							//-> Return
								return 5;
						}
						if( $this->unit() === 'm' ) {
							//-> Return
								return 6;
						}
					//-> Return
						return 4;
				}
			//-> Convert
				protected function dxf_convert( $value ) {
					//-> Unit
						if( $this->unit() === 'px' ) {
							//-> Return
								return ( $value * ( 25.4 / 96 ) );
						}
						if( $this->unit() === 'pt' ) {
							//-> Return
								return ( $value * ( 25.4 / 72 ) );
						}
					//-> Return
						return $value;
				}
			//-> X
				protected function dxf_x( $value ) {
					//-> Return
						return $this->dxf_convert( $value );
				}
			//-> Y
				protected function dxf_y( $value ) {
					//-> Origin
						if( $this->origin() === 'top-left' ) {
							//-> Update
								$value = -$value;
						}
					//-> Return
						return $this->dxf_convert( $value );
				}
			//-> Anchor
				protected function dxf_anchor( $anchor ) {
					//-> Auto
						if( $anchor === 'auto' ) {
							//-> Origin
								if( $this->origin() === 'top-left' ) {
									//-> Update
										$anchor = 'top-left';
								} else {
									//-> Update
										$anchor = 'bottom-left';
								}
						}
					//-> Return
						return $anchor;
				}
			//-> Rotation
				protected function dxf_rotation( $angle ) {
					//-> Origin
						if( $this->origin() === 'top-left' ) {
							//-> Update
								$angle = -$angle;
						}
					//-> Return
						return $angle;
				}
			//-> Position
				protected function dxf_position( $x, $y, $width, $height, $anchor ) {
					//-> Anchor
						$anchor = $this->dxf_anchor( $anchor );
					//-> Variables
						$left   = $x;
						$bottom = $y;
					//-> Horizontal
						switch( $anchor ) {
							case 'top-center':
							case 'middle-center':
							case 'bottom-center':
								//-> Update
									$left -= 0.5 * $width;
								break;
							case 'top-right':
							case 'middle-right':
							case 'bottom-right':
								//-> Update
									$left -= $width;
								break;
						}
					//-> Vertical
						switch( $anchor ) {
							case 'middle-left':
							case 'middle-center':
							case 'middle-right':
								//-> Update
									$bottom -= 0.5 * $height;
								break;
							case 'top-left':
							case 'top-center':
							case 'top-right':
								//-> Update
									$bottom -= $height;
								break;
						}
					//-> Return
						return
							array(
								'left'   => $left,
								'bottom' => $bottom
							);
				}
			//-> Color code
				protected function dxf_color_code( $color ) {
					//-> Return
						return hexdec( substr( $color, 1, 6 ) );
				}
			//-> Stroke width code
				protected function dxf_stroke_width_code( $width ) {
					//-> Unit
						switch( $this->unit() ) {
							case 'px':
								//-> Convert
									$width = $width * 25.4 / 96;
								break;
							case 'cm':
								//-> Convert
									$width = $width * 10;
								break;
							case 'm':
								//-> Convert
									$width = $width * 1000;
								break;
							case 'in':
								//-> Convert
									$width = $width * 25.4;
								break;
							case 'pt':
								//-> Convert
									$width = $width * 25.4 / 72;
								break;
						}
					//-> Variables
						$width    = $width * 100;
						$result   = 0;
						$distance = null;
					//-> Nearest
						foreach( array( 0, 5, 9, 13, 15, 18, 20, 25, 30, 35, 40, 50, 53, 60, 70, 80, 90, 100, 106, 120, 140, 158, 200, 211 ) as $value ) {
							//-> Difference
								$current = abs( $value - $width );
							//-> Check
								if( $distance === null || $current < $distance ) {
									//-> Update
										$result   = $value;
										$distance = $current;
								}
						}
					//-> Return
						return $result;
				}
			//-> Build
				protected function build() {
					//-> Variables
						$header = array();
						$footer = array();
						$styles = array( 'STANDARD' => 'txt.shx' );
						$layers = array( '0' => '0' );
						$min_x  = INF;
						$min_y  = INF;
						$max_x  = -INF;
						$max_y  = -INF;
					//-> Reset
						$this->handle   = 256;
						$this->entities = array();
					//-> Block record handles
						$this->model_space_handle = strtoupper( dechex( $this->handle++ ) );
						$paper_space_handle       = strtoupper( dechex( $this->handle++ ) );
					//-> Layout handles
						$model_layout_handle = strtoupper( dechex( $this->handle++ ) );
						$paper_layout_handle = strtoupper( dechex( $this->handle++ ) );
					//-> Each
						foreach( $this->elements() as $element ) {
							//-> Layer
								if(
									!preg_match( '//u', $element['layer'] ) ||
									strpbrk( $element['layer'], '<>/\\":;?*|=,`' ) !== false ||
									preg_match( '/[\x00-\x1F]/', $element['layer'] )
								) {
									//-> Error
										$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid DXF layer name : ' . var_export( $element['layer'], true ) );
									//-> Return
										return null;
								}
							//-> Store
								$layers[ strtoupper( $element['layer'] ) ] = strtoupper( $element['layer'] );
							//-> Type
								switch( $element['type'] ) {
									case 'line':
										//-> Coordinates
											$x1 = $this->dxf_x( $element['x1'] );
											$y1 = $this->dxf_y( $element['y1'] );
											$x2 = $this->dxf_x( $element['x2'] );
											$y2 = $this->dxf_y( $element['y2'] );
										//-> Extents
											$min_x = min( $min_x, $x1, $x2 );
											$min_y = min( $min_y, $y1, $y2 );
											$max_x = max( $max_x, $x1, $x2 );
											$max_y = max( $max_y, $y1, $y2 );
										//-> Add
											$this->dxf_entity(
												'LINE',
												$element['layer'],
												array(
													370, $this->dxf_stroke_width_code( $element['stroke_width'] ),
													420, $this->dxf_color_code( $element['stroke_color'] ),
													100, 'AcDbLine',
													10,  $x1,
													20,  $y1,
													30,  0,
													11,  $x2,
													21,  $y2,
													31,  0
												)
											);
										break;
									case 'polyline':
										//-> Closed
											if( $element['closed'] ) {
												//-> Update
													$closed = 1;
											} else {
												//-> Update
													$closed = 0;
											}
										//-> Entity
											$data =
												array(
													370, $this->dxf_stroke_width_code( $element['stroke_width'] ),
													420, $this->dxf_color_code( $element['stroke_color'] ),
													100, 'AcDbPolyline',
													90,  0.5 * count( $element['points'] ),
													70,  $closed
												);
										//-> Points
											for( $i = 0; $i < count( $element['points'] ); $i += 2 ) {
												//-> Coordinates
													$x = $this->dxf_x( $element['points'][ $i ] );
													$y = $this->dxf_y( $element['points'][ $i + 1 ] );
												//-> Extents
													$min_x = min( $min_x, $x );
													$min_y = min( $min_y, $y );
													$max_x = max( $max_x, $x );
													$max_y = max( $max_y, $y );
												//-> Add
													$data[] = 10;
													$data[] = $x;
													$data[] = 20;
													$data[] = $y;
											}
										//-> Add
											$this->dxf_entity( 'LWPOLYLINE', $element['layer'], $data );
										break;
									case 'rectangle':
										//-> Variables
											$x      = $this->dxf_x( $element['x'] );
											$y      = $this->dxf_y( $element['y'] );
											$width  = $this->dxf_convert( $element['width'] );
											$height = $this->dxf_convert( $element['height'] );
											$radius = $this->dxf_convert( $element['radius'] );
											$angle  = $element['angle'];
											$anchor = $element['anchor'];
										//-> Angle
											$angle = $this->dxf_rotation( $angle );
										//-> Position
											$position = $this->dxf_position( $x, $y, $width, $height, $anchor );
											$left     = $position['left'];
											$bottom   = $position['bottom'];
										//-> Rotation
											$radians = deg2rad( $angle );
											$cos     = cos( $radians );
											$sin     = sin( $radians );
										//-> Extents
											$corners =
												array(
													array( $left, $bottom ),
													array( $left + $width, $bottom ),
													array( $left + $width, $bottom + $height ),
													array( $left, $bottom + $height )
												);
											foreach( $corners as $corner ) {
												//-> Rotate
													$corner_x = $x + ( ( $corner[ 0 ] - $x ) * $cos ) - ( ( $corner[ 1 ] - $y ) * $sin );
													$corner_y = $y + ( ( $corner[ 0 ] - $x ) * $sin ) + ( ( $corner[ 1 ] - $y ) * $cos );
												//-> Update
													$min_x = min( $min_x, $corner_x );
													$min_y = min( $min_y, $corner_y );
													$max_x = max( $max_x, $corner_x );
													$max_y = max( $max_y, $corner_y );
											}
										//-> Points
											if( $radius > 0 ) {
												//-> Bulge
													$bulge = tan( deg2rad( 90 ) / 4 );
												//-> Rounded
													$points =
														array(
															array( $left + $radius, $bottom, 0 ),
															array( $left + $width - $radius, $bottom, $bulge ),
															array( $left + $width, $bottom + $radius, 0 ),
															array( $left + $width, $bottom + $height - $radius, $bulge ),
															array( $left + $width - $radius, $bottom + $height, 0 ),
															array( $left + $radius, $bottom + $height, $bulge ),
															array( $left, $bottom + $height - $radius, 0 ),
															array( $left, $bottom + $radius, $bulge )
														);
											} else {
												//-> Rectangle
													$points =
														array(
															array( $left, $bottom, 0 ),
															array( $left + $width, $bottom, 0 ),
															array( $left + $width, $bottom + $height, 0 ),
															array( $left, $bottom + $height, 0 )
														);
											}
										//-> Data
											$data =
												array(
													370, $this->dxf_stroke_width_code( $element['stroke_width'] ),
													420, $this->dxf_color_code( $element['stroke_color'] ),
													100, 'AcDbPolyline',
													90,  count( $points ),
													70,  1
												);
										//-> Points
											foreach( $points as $point ) {
												//-> Rotate
													$point_x = $x + ( ( $point[ 0 ] - $x ) * $cos ) - ( ( $point[ 1 ] - $y ) * $sin );
													$point_y = $y + ( ( $point[ 0 ] - $x ) * $sin ) + ( ( $point[ 1 ] - $y ) * $cos );
												//-> Add
													array_push( $data, 10, $point_x, 20, $point_y );
												//-> Bulge
													if( $point[ 2 ] != 0 ) {
														//-> Add
															array_push( $data, 42, $point[ 2 ] );
													}
											}
										//-> Add
											$this->dxf_entity( 'LWPOLYLINE', $element['layer'], $data );
										break;
									case 'circle':
										//-> Coordinates
											$x      = $this->dxf_x( $element['x'] );
											$y      = $this->dxf_y( $element['y'] );
											$radius = $this->dxf_convert( $element['radius'] );
										//-> Extents
											$min_x = min( $min_x, $x - $radius );
											$min_y = min( $min_y, $y - $radius );
											$max_x = max( $max_x, $x + $radius );
											$max_y = max( $max_y, $y + $radius );
										//-> Add
											$this->dxf_entity(
												'CIRCLE',
												$element['layer'],
												array(
													370, $this->dxf_stroke_width_code( $element['stroke_width'] ),
													420, $this->dxf_color_code( $element['stroke_color'] ),
													100, 'AcDbCircle',
													10,  $x,
													20,  $y,
													30,  0,
													40,  $radius
												)
											);
										break;
									case 'ellipse':
										//-> Coordinates
											$x        = $this->dxf_x( $element['x'] );
											$y        = $this->dxf_y( $element['y'] );
											$radius_x = $this->dxf_convert( $element['radius_x'] );
											$radius_y = $this->dxf_convert( $element['radius_y'] );
											$angle    = $element['angle'];
										//-> Origin
											if( $this->origin() === 'top-left' ) {
												//-> Update
													$angle = -$angle;
											}
										//-> Rotation
											$radians = deg2rad( $angle );
											$cos     = cos( $radians );
											$sin     = sin( $radians );
										//-> Major axis
											if( $radius_x >= $radius_y ) {
												//-> Update
													$major_x = $radius_x * $cos;
													$major_y = $radius_x * $sin;
													$ratio   = $radius_y / $radius_x;
											} else {
												//-> Update
													$major_x = -$radius_y * $sin;
													$major_y = $radius_y * $cos;
													$ratio   = $radius_x / $radius_y;
											}
										//-> Extents
											$radius = max( $radius_x, $radius_y );
											$min_x  = min( $min_x, $x - $radius );
											$min_y  = min( $min_y, $y - $radius );
											$max_x  = max( $max_x, $x + $radius );
											$max_y  = max( $max_y, $y + $radius );
										//-> Add
											$this->dxf_entity(
												'ELLIPSE',
												$element['layer'],
												array(
													370, $this->dxf_stroke_width_code( $element['stroke_width'] ),
													420, $this->dxf_color_code( $element['stroke_color'] ),
													100, 'AcDbEllipse',
													10,  $x,
													20,  $y,
													30,  0,
													11,  $major_x,
													21,  $major_y,
													31,  0,
													40,  $ratio,
													41,  0,
													42,  2 * M_PI
												)
											);
										break;
									case 'arc':
										//-> Coordinates
											$x      = $this->dxf_x( $element['x'] );
											$y      = $this->dxf_y( $element['y'] );
											$radius = $this->dxf_convert( $element['radius'] );
											$start  = $element['start'];
											$end    = $start + $element['sweep'];
										//-> Origin
											if( $this->origin() === 'top-left' ) {
												//-> Update
													$start = -$end;
													$end   = -$element['start'];
											}
										//-> Normalize
											$start = $this->angle( $start );
											$end   = $this->angle( $end );
										//-> Extents
											$min_x = min( $min_x, $x - $radius );
											$min_y = min( $min_y, $y - $radius );
											$max_x = max( $max_x, $x + $radius );
											$max_y = max( $max_y, $y + $radius );
										//-> Add
											$this->dxf_entity(
												'ARC',
												$element['layer'],
												array(
													370, $this->dxf_stroke_width_code( $element['stroke_width'] ),
													420, $this->dxf_color_code( $element['stroke_color'] ),
													100, 'AcDbCircle',
													10,  $x,
													20,  $y,
													30,  0,
													40,  $radius,
													100, 'AcDbArc',
													50,  $start,
													51,  $end
												)
											);
										break;
									case 'ellipse_arc':
										//-> Coordinates
											$x        = $this->dxf_x( $element['x'] );
											$y        = $this->dxf_y( $element['y'] );
											$radius_x = $this->dxf_convert( $element['radius_x'] );
											$radius_y = $this->dxf_convert( $element['radius_y'] );
											$angle    = $element['angle'];
											$start    = $element['start'];
											$end      = $start + $element['sweep'];
										//-> Origin
											if( $this->origin() === 'top-left' ) {
												//-> Update
													$angle = -$angle;
													$start = -$end;
													$end   = -$element['start'];
											}
										//-> Rotation
											$radians = deg2rad( $angle );
											$cos     = cos( $radians );
											$sin     = sin( $radians );
										//-> Major axis
											if( $radius_x >= $radius_y ) {
												//-> Update
													$major_x = $radius_x * $cos;
													$major_y = $radius_x * $sin;
													$ratio   = $radius_y / $radius_x;
											} else {
												//-> Update
													$major_x = -$radius_y * $sin;
													$major_y = $radius_y * $cos;
													$ratio   = $radius_x / $radius_y;
												//-> Parameters
													$start -= 90;
													$end -= 90;
											}
										//-> Normalize
											$start = deg2rad( $this->angle( $start ) );
											$end   = deg2rad( $this->angle( $end ) );
										//-> Extents
											$radius = max( $radius_x, $radius_y );
											$min_x  = min( $min_x, $x - $radius );
											$min_y  = min( $min_y, $y - $radius );
											$max_x  = max( $max_x, $x + $radius );
											$max_y  = max( $max_y, $y + $radius );
										//-> Add
											$this->dxf_entity(
												'ELLIPSE',
												$element['layer'],
												array(
													370, $this->dxf_stroke_width_code( $element['stroke_width'] ),
													420, $this->dxf_color_code( $element['stroke_color'] ),
													100, 'AcDbEllipse',
													10,  $x,
													20,  $y,
													30,  0,
													11,  $major_x,
													21,  $major_y,
													31,  0,
													40,  $ratio,
													41,  $start,
													42,  $end
												)
											);
										break;
									case 'text':
										//-> Coordinates
											$x      = $this->dxf_x( $element['x'] );
											$y      = $this->dxf_y( $element['y'] );
											$angle  = $element['angle'];
											$anchor = $element['anchor'];
											$font   = 'canvas-' . md5( $element['text_font'] );
										//-> Style
											$styles[ $font ] = basename( $element['text_font'] );
										//-> Angle
											$angle  = $this->angle( $this->dxf_rotation( $angle ) );
										//-> Anchor
											$anchor = $this->dxf_anchor( $anchor );
										//-> Alignment
											$align_x = 0;
											$align_y = 0;
										//-> Horizontal
											switch( $anchor ) {
												case 'top-center':
												case 'middle-center':
												case 'bottom-center':
													//-> Update
														$align_x = 1;
													break;
												case 'top-right':
												case 'middle-right':
												case 'bottom-right':
													//-> Update
														$align_x = 2;
													break;
											}
										//-> Vertical
											switch( $anchor ) {
												case 'top-left':
												case 'top-center':
												case 'top-right':
													//-> Update
														$align_y = 3;
													break;
												case 'middle-left':
												case 'middle-center':
												case 'middle-right':
													//-> Update
														$align_y = 2;
													break;
											}
										//-> Metrics
											$metrics = canvas_ttf::metrics( $element['text_font'], $element['text_size'] );
											$width   = canvas_ttf::width( $element['text_font'], $element['text'], $element['text_size'] );
										//-> Check
											if( !is_array( $metrics ) || !is_numeric( $width ) ) {
												//-> Error
													$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to calculate text metrics' );
												//-> Return
													return null;
											}
										//-> Size
											$height = $this->dxf_convert( $metrics['height'] );
										//-> Extents
											$extent = $this->dxf_convert( $width + $element['text_size'] );
											$min_x  = min( $min_x, $x - $extent );
											$min_y  = min( $min_y, $y - $extent );
											$max_x  = max( $max_x, $x + $extent );
											$max_y  = max( $max_y, $y + $extent );
										//-> Add
											$this->dxf_entity(
												'TEXT',
												$element['layer'],
												array(
													420, $this->dxf_color_code( $element['text_color'] ),
													100, 'AcDbText',
													10,  $x,
													20,  $y,
													30,  0,
													40,  $height,
													1,   $element['text'],
													50,  $angle,
													7,   $font,
													72,  $align_x,
													11,  $x,
													21,  $y,
													31,  0,
													100, 'AcDbText',
													73,  $align_y
												)
											);
										break;
									case 'paragraph':
										//-> Coordinates
											$x      = $this->dxf_x( $element['x'] );
											$y      = $this->dxf_y( $element['y'] );
											$width  = $this->dxf_convert( $element['width'] );
											$height = $this->dxf_convert( $element['height'] );
											$angle  = $element['angle'];
											$anchor = $element['anchor'];
										//-> Angle
											$angle  = $this->dxf_rotation( $angle );
										//-> Anchor
											$anchor = $this->dxf_anchor( $anchor );
											$anchors =
												array(
													'top-left',
													'top-center',
													'top-right',
													'middle-left',
													'middle-center',
													'middle-right',
													'bottom-left',
													'bottom-center',
													'bottom-right'
												);
											$attachment = array_search( $anchor, $anchors, true ) + 1;
										//-> Alignment
											$aligns = array( 'left' => 'l', 'center' => 'c', 'right' => 'r', 'justified' => 'j' );
										//-> Content
											$paragraphs = array();
											foreach( $element['paragraphs'] as $paragraph ) {
												//-> Text
													$text = implode( ' ', $paragraph );
												//-> Escape
													$text = str_replace( array( '\\', '{', '}' ), array( '\\\\', '\{', '\}' ), $text );
												//-> Add
													$paragraphs[] = $text;
											}
											$content = '\pxq' . $aligns[ $element['align'] ] . ';' . implode( '\P', $paragraphs );
										//-> Font
											$font = 'canvas-' . md5( $element['text_font'] );
											$styles[ $font ] = basename( $element['text_font'] );
										//-> Metrics
											$metrics = canvas_ttf::metrics( $element['text_font'], $element['text_size'] );
										//-> Check
											if( !is_array( $metrics ) ) {
												//-> Error
													$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to calculate text metrics' );
												//-> Return
													return null;
											}
										//-> Line spacing
											$spacing = 0.6 * $element['line_height'] / $metrics['height'];
											$spacing = max( 0.25, min( 4, $spacing ) );
										//-> Data
											$data =
												array(
													420, $this->dxf_color_code( $element['text_color'] ),
													100, 'AcDbMText',
													10,  $x,
													20,  $y,
													30,  0,
													40,  $this->dxf_convert( $metrics['height'] ),
													41,  $width,
													71,  $attachment,
													72,  1,
													7,   $font,
													50,  deg2rad( $angle ),
													73,  2,
													44,  $spacing
												);
										//-> Text chunks
											$chunks = array();
											$chunk  = '';
											foreach( preg_split( '//u', $content, -1, PREG_SPLIT_NO_EMPTY ) as $character ) {
												//-> Limit
													if( ( strlen( $chunk ) + strlen( $character ) ) > 249 ) {
														//-> Add
															$chunks[] = $chunk;
														//-> Reset
															$chunk = '';
													}
												//-> Append
													$chunk .= $character;
											}
										//-> Last chunk
											$chunks[] = $chunk;
										//-> Additional chunks
											while( count( $chunks ) > 1 ) {
												//-> Add
													$data[] = 3;
													$data[] = array_shift( $chunks );
											}
										//-> Last chunk
											$data[] = 1;
											$data[] = $chunks[0];
										//-> Add
											$this->dxf_entity( 'MTEXT', $element['layer'], $data );
										//-> Extents
											$extent = $width + $height;
											$min_x  = min( $min_x, $x - $extent );
											$min_y  = min( $min_y, $y - $extent );
											$max_x  = max( $max_x, $x + $extent );
											$max_y  = max( $max_y, $y + $extent );
										break;
									case 'image':
										//-> Error
											$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Images are not supported in DXF' );
										//-> Return
											return null;
									default:
										//-> Error
											$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unsupported element : ' . var_export( $element['type'], true ) );
										//-> Return
											return null;
								}
						}
					//-> Header
						array_push( $header, 0, 'SECTION', 2, 'HEADER', 9, '$ACADVER', 1, 'AC1021', 9, '$HANDSEED', 5 );
						$handseed_index = count( $header );
						array_push( $header, '', 9, '$INSUNITS', 70, $this->dxf_unit_code() );
					//-> Extents
						if( max( $min_x, $min_y, -$max_x, -$max_y ) < INF ) {
							//-> Update
								array_push( $header, 9, '$EXTMIN', 10, $min_x, 20, $min_y, 30, 0, 9, '$EXTMAX', 10, $max_x, 20, $max_y, 30, 0 );
						}
					//-> Header
						array_push( $header, 0, 'ENDSEC' );
					//-> Classes
						array_push(
							$header,
							0,   'SECTION',
							2,   'CLASSES',
							0,   'CLASS',
							1,   'LAYOUT',
							2,   'AcDbLayout',
							3,   'ObjectDBX Classes',
							90,  0,
							91,  2,
							280, 0,
							281, 0,
							0,   'ENDSEC'
						);
					//-> Tables
						array_push( $header, 0, 'SECTION', 2, 'TABLES' );
					//-> Viewport
						$view_center_x = 0;
						$view_center_y = 0;
						$view_height   = 100;
						$view_aspect   = 1.6;
					//-> Drawing extents
						if( max( $min_x, $min_y, -$max_x, -$max_y ) < INF ) {
							//-> Center
								$view_center_x = 0.5 * ( $min_x + $max_x );
								$view_center_y = 0.5 * ( $min_y + $max_y );
							//-> Size
								$view_width  = max( 1, $max_x - $min_x );
								$view_height = 1.1 * max( 1, $max_y - $min_y, $view_width / $view_aspect );
						}
					//-> VPORT table
						$table_handle = strtoupper( dechex( $this->handle++ ) );
						array_push(
							$header,
							0,   'TABLE',
							2,   'VPORT',
							5,   $table_handle,
							330, 0,
							100, 'AcDbSymbolTable',
							70,  1,
							0,   'VPORT',
							5,   strtoupper( dechex( $this->handle++ ) ),
							330, $table_handle,
							100, 'AcDbSymbolTableRecord',
							100, 'AcDbViewportTableRecord',
							2,   '*ACTIVE',
							70,  0,
							10,  0,
							20,  0,
							11,  1,
							21,  1,
							12,  $view_center_x,
							22,  $view_center_y,
							13,  0,
							23,  0,
							14,  1,
							24,  1,
							15,  10,
							25,  10,
							16,  0,
							26,  0,
							36,  1,
							17,  0,
							27,  0,
							37,  0,
							40,  $view_height,
							41,  $view_aspect,
							42,  50,
							43,  0,
							44,  0,
							50,  0,
							51,  0,
							71,  0,
							72,  100,
							73,  1,
							74,  0,
							75,  0,
							76,  0,
							77,  0,
							78,  0,
							281, 0,
							0,   'ENDTAB'
						);
					//-> Linetypes
						$table_handle = strtoupper( dechex( $this->handle ) );
						$this->handle++;
					//-> Table
						array_push( $header, 0, 'TABLE', 2, 'LTYPE', 5, $table_handle, 330, 0, 100, 'AcDbSymbolTable', 70, 3 );
					//-> Each
						foreach( array( 'BYBLOCK', 'BYLAYER', 'CONTINUOUS' ) as $name ) {
							//-> Linetype
								array_push(
									$header,
									0,   'LTYPE',
									5,   strtoupper( dechex( $this->handle ) ),
									330, $table_handle,
									100, 'AcDbSymbolTableRecord',
									100, 'AcDbLinetypeTableRecord',
									2,   $name,
									70,  0,
									3,   '',
									72,  65,
									73,  0,
									40,  0
								);
							//-> Next
								$this->handle++;
						}
					//-> End table
						array_push( $header, 0, 'ENDTAB' );
					//-> Layers
						$table_handle = strtoupper( dechex( $this->handle ) );
						$this->handle++;
					//-> Table
						array_push( $header, 0, 'TABLE', 2, 'LAYER', 5, $table_handle, 330, 0, 100, 'AcDbSymbolTable', 70, count( $layers ) );
					//-> Each
						foreach( $layers as $name ) {
							//-> Layer
								array_push(
									$header,
									0,   'LAYER',
									5,   strtoupper( dechex( $this->handle ) ),
									330, $table_handle,
									100, 'AcDbSymbolTableRecord',
									100, 'AcDbLayerTableRecord',
									2,   $name,
									70,  0,
									62,  7,
									6,   'CONTINUOUS'
								);
							//-> Next
								$this->handle++;
						}
					//-> End table
						array_push( $header, 0, 'ENDTAB' );
					//-> Styles
						if( count( $styles ) > 0 ) {
							//-> Handle
								$table_handle = strtoupper( dechex( $this->handle ) );
								$this->handle++;
							//-> Table
								array_push( $header, 0, 'TABLE', 2, 'STYLE', 5, $table_handle, 330, 0, 100, 'AcDbSymbolTable', 70, count( $styles ) );
							//-> Each
								foreach( $styles as $name => $file ) {
									//-> Style
										array_push(
											$header,
											0,   'STYLE',
											5,   strtoupper( dechex( $this->handle ) ),
											330, $table_handle,
											100, 'AcDbSymbolTableRecord',
											100, 'AcDbTextStyleTableRecord',
											2,   $name,
											70,  0,
											40,  0,
											41,  1,
											50,  0,
											71,  0,
											42,  0,
											3,   $file,
											4,   ''
										);
									//-> Next
										$this->handle++;
								}
							//-> End table
								array_push( $header, 0, 'ENDTAB' );
						}
					//-> Empty tables
						foreach( array( 'VIEW', 'UCS' ) as $name ) {
							//-> Table
								$table_handle = strtoupper( dechex( $this->handle++ ) );
								array_push( $header, 0, 'TABLE', 2, $name, 5, $table_handle, 330, 0, 100, 'AcDbSymbolTable', 70, 0, 0, 'ENDTAB' );
						}
					//-> Application identifiers
						$table_handle = strtoupper( dechex( $this->handle++ ) );
					//-> Table
						array_push( $header, 0, 'TABLE', 2, 'APPID', 5, $table_handle, 330, 0, 100, 'AcDbSymbolTable', 70, 1 );
					//-> ACAD
						array_push(
							$header,
							0,   'APPID',
							5,   strtoupper( dechex( $this->handle++ ) ),
							330, $table_handle,
							100, 'AcDbSymbolTableRecord',
							100, 'AcDbRegAppTableRecord',
							2,   'ACAD',
							70,  0
						);
					//-> End table
						array_push( $header, 0, 'ENDTAB' );
					//-> Dimension styles
						$table_handle = strtoupper( dechex( $this->handle++ ) );
					//-> Table
						array_push(
							$header,
							0,   'TABLE',
							2,   'DIMSTYLE',
							5,   $table_handle,
							330, 0,
							100, 'AcDbSymbolTable',
							70,  1,
							100, 'AcDbDimStyleTable',
							0,   'DIMSTYLE',
							105, strtoupper( dechex( $this->handle++ ) ),
							330, $table_handle,
							100, 'AcDbSymbolTableRecord',
							100, 'AcDbDimStyleTableRecord',
							2,   'Standard',
							70,  0,
							40,  1,
							41,  2.5,
							42,  0.625,
							43,  3.75,
							44,  1.25,
							140, 2.5,
							141, 2.5,
							144, 1,
							147, 0.625,
							77,  1,
							78,  8,
							271, 2,
							272, 2,
							275, 0,
							277, 2,
							278, 44,
							289, 3,
							371, -2,
							372, -2
						);
					//-> End table
						$header[] = 0;
						$header[] = 'ENDTAB';
					//-> Block records
						$table_handle = strtoupper( dechex( $this->handle++ ) );
					//-> Table
						array_push( $header, 0, 'TABLE', 2, 'BLOCK_RECORD', 5, $table_handle, 330, 0, 100, 'AcDbSymbolTable', 70, 2 );
					//-> Each
						foreach( array( '*Model_Space' => $this->model_space_handle, '*Paper_Space' => $paper_space_handle ) as $name => $handle ) {
							//-> Layout handle
								if( $name === '*Model_Space' ) {
									//-> Model
										$layout_handle = $model_layout_handle;
								} else {
									//-> Paper
										$layout_handle = $paper_layout_handle;
								}
							//-> Record
								array_push(
									$header,
									0,   'BLOCK_RECORD',
									5,   $handle,
									330, $table_handle,
									100, 'AcDbSymbolTableRecord',
									100, 'AcDbBlockTableRecord',
									2,   $name,
									340, $layout_handle,
									70,  0,
									280, 1,
									281, 0
								);
						}
					//-> End table
						array_push( $header, 0, 'ENDTAB' );
					//-> End tables
						array_push( $header, 0, 'ENDSEC' );
					//-> Blocks
						array_push( $header, 0, 'SECTION', 2, 'BLOCKS' );
					//-> Each
						foreach( array( '*Model_Space' => $this->model_space_handle, '*Paper_Space' => $paper_space_handle ) as $name => $handle ) {
							//-> Block
								array_push(
									$header,
									0,   'BLOCK',
									5,   strtoupper( dechex( $this->handle++ ) ),
									330, $handle,
									100, 'AcDbEntity',
									8,   '0',
									100, 'AcDbBlockBegin',
									2,   $name,
									70,  0,
									10,  0,
									20,  0,
									30,  0,
									3,   $name,
									1,   ''
								);
							//-> End block
								array_push(
									$header,
									0,   'ENDBLK',
									5,   strtoupper( dechex( $this->handle++ ) ),
									330, $handle,
									100, 'AcDbEntity',
									8,   '0',
									100, 'AcDbBlockEnd'
								);
						}
					//-> End blocks
						array_push( $header, 0, 'ENDSEC' );
					//-> Entities
						array_push( $header, 0, 'SECTION', 2, 'ENTITIES' );
					//-> Footer
						array_push( $footer, 0, 'ENDSEC' );
					//-> Object handles
						$root_dictionary_handle   = strtoupper( dechex( $this->handle++ ) );
						$group_dictionary_handle  = strtoupper( dechex( $this->handle++ ) );
						$layout_dictionary_handle = strtoupper( dechex( $this->handle++ ) );
					//-> Objects
						array_push(
							$footer,
							0,   'SECTION',
							2,   'OBJECTS',
							0,   'DICTIONARY',
							5,   $root_dictionary_handle,
							330, 0,
							100, 'AcDbDictionary',
							281, 1,
							3,   'ACAD_GROUP',
							350, $group_dictionary_handle,
							3,   'ACAD_LAYOUT',
							350, $layout_dictionary_handle,
							0,   'DICTIONARY',
							5,   $group_dictionary_handle,
							330, $root_dictionary_handle,
							100, 'AcDbDictionary',
							281, 1,
							0,   'DICTIONARY',
							5,   $layout_dictionary_handle,
							330, $root_dictionary_handle,
							100, 'AcDbDictionary',
							281, 1,
							3,   'Model',
							350, $model_layout_handle,
							3,   'Layout1',
							350, $paper_layout_handle
						);
					//-> Layouts
						foreach(
							array(
								array( 'Model', $model_layout_handle, $this->model_space_handle, 0 ),
								array( 'Layout1', $paper_layout_handle, $paper_space_handle, 1 )
							) as $layout
						) {
							//-> Layout
								array_push(
									$footer,
									0,   'LAYOUT',
									5,   $layout[1],
									330, $layout_dictionary_handle,
									100, 'AcDbPlotSettings',
									1,   '',
									4,   'A3',
									6,   '',
									40,  0,
									41,  0,
									42,  0,
									43,  0,
									44,  420,
									45,  297,
									46,  0,
									47,  0,
									48,  0,
									49,  0,
									140, 0,
									141, 0,
									142, 1,
									143, 1,
									70,  0,
									72,  1,
									73,  0,
									74,  5,
									7,   '',
									75,  16,
									76,  0,
									77,  2,
									78,  300,
									147, 1,
									148, 0,
									149, 0,
									100, 'AcDbLayout',
									1,   $layout[0],
									70,  1,
									71,  $layout[3],
									10,  0,
									20,  0,
									11,  420,
									21,  297,
									12,  0,
									22,  0,
									32,  0,
									14,  1e20,
									24,  1e20,
									34,  1e20,
									15,  -1e20,
									25,  -1e20,
									35,  -1e20,
									146, 0,
									13,  0,
									23,  0,
									33,  0,
									16,  1,
									26,  0,
									36,  0,
									17,  0,
									27,  1,
									37,  0,
									76,  1,
									330, $layout[2]
								);
						}
					//-> End objects
						array_push( $footer, 0, 'ENDSEC', 0, 'EOF' );
					//-> Handle seed
						$header[ $handseed_index ] = strtoupper( dechex( $this->handle ) );
					//-> Return
						return
							implode(
								"\r\n",
								array_merge(
									$header,
									$this->entities,
									$footer
								)
							);
				}
		}
	//-> GD
		abstract class canvas_gd extends canvas_renderer {
			//-> Variables
				protected $transparent   = false;
				protected $supersampling = 4;
				protected $gd_scale      = 1;
			//-> Constructor
				public function __construct( $width = null, $height = null, $unit = 'px' ) {
					//-> Unit
						$this->unit( $unit );
					//-> Width
						if( $width !== null ) {
							//-> Update
								$this->width( $width );
						}
					//-> Height
						if( $height !== null ) {
							//-> Update
								$this->height( $height );
						}
				}
			//-> Encode
				abstract protected function gd_encode( $image );
			//-> Pixels
				protected function gd_pixels( $value ) {
					//-> Unit
						switch( $this->unit() ) {
							case 'mm':
								//-> Return
									return $value * $this->gd_scale * ( 96 / 25.4 );
							case 'cm':
								//-> Return
									return $value * $this->gd_scale * ( 96 / 2.54 );
							case 'm':
								//-> Return
									return $value * $this->gd_scale * ( 96 / 0.0254 );
							case 'in':
								//-> Return
									return $value * $this->gd_scale * 96;
							case 'pt':
								//-> Return
									return $value * $this->gd_scale * ( 96 / 72 );
						}
					//-> Return
						return $value * $this->gd_scale;
				}
			//-> X
				protected function gd_x( $value ) {
					//-> Return
						return $this->gd_pixels( $value );
				}
			//-> Y
				protected function gd_y( $value ) {
					//-> Origin
						if( $this->origin() === 'bottom-left' ) {
							//-> Return
								return $this->gd_pixels( $this->height() - $value );
						}
					//-> Return
						return $this->gd_pixels( $value );
				}
			//-> Position X
				protected function gd_position_x( $x, $width, $anchor ) {
					//-> Switch
						switch( $anchor ) {
							case 'top-center':
							case 'middle-center':
							case 'bottom-center':
								//-> Return
									return ( $x - ( 0.5 * $width ) );
							case 'top-right':
							case 'middle-right':
							case 'bottom-right':
								//-> Return
									return ( $x - $width );
						}
					//-> Return
						return $x;
				}
			//-> Position Y
				protected function gd_position_y( $y, $height, $anchor ) {
					//-> Origin
						if( $this->origin() === 'bottom-left' ) {
							//-> Update
								$height = -$height;
							//-> Auto
								if( $anchor === 'auto' ) {
									//-> Update
										$anchor = 'bottom-left';
								}
						}
					//-> Switch
						switch( $anchor ) {
							case 'middle-left':
							case 'middle-center':
							case 'middle-right':
								//-> Return
									return ( $y - ( 0.5 * $height ) );
							case 'bottom-left':
							case 'bottom-center':
							case 'bottom-right':
								//-> Return
									return ( $y - $height );
						}
					//-> Return
						return $y;
				}
			//-> Color
				protected function gd_color( $image, $color ) {
					//-> Channels
						$red   = hexdec( substr( $color, 1, 2 ) );
						$green = hexdec( substr( $color, 3, 2 ) );
						$blue  = hexdec( substr( $color, 5, 2 ) );
						$alpha = hexdec( substr( $color, 7, 2 ) );
					//-> GD alpha
						$alpha = 127 - round( $alpha * 127 / 255 );
					//-> Return
						return imagecolorallocatealpha( $image, $red, $green, $blue, $alpha );
				}
			//-> Path
				protected function gd_path( $image, $element ) {
					//-> Count
						$coordinate_count = count( $element['points'] );
						$point_count      = intval( $coordinate_count / 2 );
					//-> Check
						if( $point_count > 1 ) {
							//-> Variables
								$points = array();
							//-> Points
								for( $i = 0; $i < $coordinate_count; $i += 2 ) {
									//-> Add
										$points[] = $this->gd_x( $element['points'][ $i ] );
										$points[] = $this->gd_y( $element['points'][ $i + 1 ] );
								}
							//-> Fill
								if( $element['closed'] && $point_count > 2 && substr( $element['fill_color'], -2 ) !== '00' ) {
									//-> Color
										$fill = $this->gd_color( $image, $element['fill_color'] );
									//-> Polygon
										imagefilledpolygon( $image, array_map( 'round', $points ), $fill );
								}
							//-> Stroke
								if( substr( $element['stroke_color'], -2 ) !== '00' && $element['stroke_width'] > 0 ) {
									//-> Note : outline opacity ignored ( poor handling of outlines with GD )
										$color = $this->gd_color( $image, substr( $element['stroke_color'], 0, 7 ) . 'FF' );
									//-> Variable
										$width = max( 1, round( $this->gd_pixels( $element['stroke_width'] ) ) );
									//-> Thickness
										imagesetthickness( $image, $width );
									//-> Check
										if( $element['closed'] ) {
											//-> Update
												$segments = $point_count;
										} else {
											//-> Update
												$segments = $point_count - 1;
										}
									//-> Segments
										for( $i = 0; $i < $segments; $i++ ) {
											//-> Coordinates
												$next = ( $i + 1 ) % $point_count;
												$x1   = $points[ $i * 2 ];
												$y1   = $points[ $i * 2 + 1 ];
												$x2   = $points[ $next * 2 ];
												$y2   = $points[ $next * 2 + 1 ];
											//-> Square caps
												if( !$element['closed'] && $element['stroke_linecap'] === 'square' && ( $i == 0 || $i == $point_count - 2 ) ) {
													//-> Direction
														$dx     = $x2 - $x1;
														$dy     = $y2 - $y1;
														$length = hypot( $dx, $dy );
													//-> Extend
														if( $length > 0 ) {
															//-> Offset
																$offset = 0.5 * $width / $length;
															//-> First
																if( $i == 0 ) {
																	//-> Update
																		$x1 -= $dx * $offset;
																		$y1 -= $dy * $offset;
																}
															//-> Last
																if( $i == $point_count - 2 ) {
																	//-> Update
																		$x2 += $dx * $offset;
																		$y2 += $dy * $offset;
																}
														}
												}
											//-> Draw
												imageline( $image, round( $x1 ), round( $y1 ), round( $x2 ), round( $y2 ), $color );
										}
									//-> Joins
										for( $i = 0; $i < $point_count; $i++ ) {
											//-> Check
												if( $element['closed'] || ( $i > 0 && $i < $point_count - 1 ) ) {
													//-> Point
														$x = $points[ $i * 2 ];
														$y = $points[ $i * 2 + 1 ];
													//-> Round
														if( $element['stroke_linejoin'] === 'round' ) {
															//-> Circle
																imagefilledellipse( $image, round( $x ), round( $y ), $width, $width, $color );
														} else {
															//-> Neighbors
																$previous = ( $i + $point_count - 1 ) % $point_count;
																$next     = ( $i + 1 ) % $point_count;
															//-> Directions
																$dx1     = $x - $points[ $previous * 2 ];
																$dy1     = $y - $points[ $previous * 2 + 1 ];
																$dx2     = $points[ $next * 2 ] - $x;
																$dy2     = $points[ $next * 2 + 1 ] - $y;
																$length1 = hypot( $dx1, $dy1 );
																$length2 = hypot( $dx2, $dy2 );
															//-> Check
																if( $length1 > 0 && $length2 > 0 ) {
																	//-> Normalize
																		$dx1 = $dx1 / $length1;
																		$dy1 = $dy1 / $length1;
																		$dx2 = $dx2 / $length2;
																		$dy2 = $dy2 / $length2;
																	//-> Cross
																		$cross = ( ( $dx1 * $dy2 ) - ( $dy1 * $dx2 ) );
																	//-> Check
																		if( abs( $cross ) > 0.000001 ) {
																			//-> Side
																				$side = 1;
																			//-> Check
																				if( $cross > 0 ) {
																					//-> Update
																						$side = -1;
																				}
																			//-> Corners
																				$half = 0.5 * $width;
																				$ax   = $x - $side * $dy1 * $half;
																				$ay   = $y + $side * $dx1 * $half;
																				$bx   = $x - $side * $dy2 * $half;
																				$by   = $y + $side * $dx2 * $half;
																				$join = array( $x, $y, $ax, $ay );
																			//-> Miter
																				if( $element['stroke_linejoin'] === 'miter' ) {
																					//-> Angle
																						$angle  = atan2( abs( $cross ), $dx1 * $dx2 + $dy1 * $dy2 );
																						$extend = $half * tan( 0.5 * $angle );
																					//-> Limit
																						if( $extend <= 4 * $half ) {
																							//-> Join
																								$join[] = $ax + $dx1 * $extend;
																								$join[] = $ay + $dy1 * $extend;
																						}
																				}
																			//-> Polygon
																				$join[] = $bx;
																				$join[] = $by;
																			//-> Draw
																				imagefilledpolygon( $image, array_map( 'round', $join ), $color );
																		}
																}
														}
												}
										}
									//-> Round caps
										if( !$element['closed'] && $element['stroke_linecap'] === 'round' ) {
											//-> Start
												imagefilledellipse( $image, round( $points[0] ), round( $points[1] ), $width, $width, $color );
											//-> End
												imagefilledellipse( $image, round( $points[ ( $point_count - 1 ) * 2 ] ), round( $points[ ( $point_count - 1 ) * 2 + 1 ] ), $width, $width, $color );
										}
								}
						}
				}
			//-> Build
				protected function build() {
					//-> Check
						if( !function_exists( 'imagecreatetruecolor' ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - GD extension is not available' );
							//-> Return
								return null;
						}
					//-> Scale
						$this->gd_scale = 1;
					//-> Size
						$image_width  = round( $this->gd_pixels( $this->width() ) );
						$image_height = round( $this->gd_pixels( $this->height() ) );
					//-> Check
						if( $image_width < 1 || $image_height < 1 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid image dimensions' );
							//-> Return
								return null;
						}
					//-> Supersampling
						$this->gd_scale = $this->supersampling;
					//-> Create
						$image = @imagecreatetruecolor( $image_width * $this->gd_scale, $image_height * $this->gd_scale );
					//-> Check
						if( $image === false ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to create image' );
							//-> Return
								return null;
						}
					//-> Background
						if( $this->transparent ) {
							//-> Transparency
								imagealphablending( $image, false );
								imagesavealpha( $image, true );
							//-> Fill
								$background = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
								imagefill( $image, 0, 0, $background );
							//-> Blending
								imagealphablending( $image, true );
						} else {
							//-> White
								$background = imagecolorallocate( $image, 255, 255, 255 );
								imagefill( $image, 0, 0, $background );
						}
					//-> Elements
						foreach( $this->elements() as $element ) {
							//-> Type
								switch( $element['type'] ) {
									case 'line':
										//-> Path
											$this->gd_path(
												$image,
												array(
													'points'          => array( $element['x1'], $element['y1'], $element['x2'], $element['y2'] ),
													'closed'          => false,
													'fill_color'      => '#00000000',
													'stroke_color'    => $element['stroke_color'],
													'stroke_width'    => $element['stroke_width'],
													'stroke_linecap'  => $element['stroke_linecap'],
													'stroke_linejoin' => 'miter'
												)
											);
										break;
									case 'polyline':
										//-> Path
											$this->gd_path( $image, $element );
										break;
									case 'rectangle':
										//-> Variables
											$x         = $element['x'];
											$y         = $element['y'];
											$width     = $element['width'];
											$height    = $element['height'];
											$radius    = $element['radius'];
											$anchor    = $element['anchor'];
											$points    = array();
											$direction = 1;
										//-> Origin
											if( $this->origin() === 'bottom-left' ) {
												//-> Update
													$direction = -1;
											}
										//-> Position
											$left = $this->gd_position_x( $x, $width, $anchor );
											$top  = $this->gd_position_y( $y, $height, $anchor );
										//-> Corners
											if( $radius > 0 ) {
												//-> Variables
													$steps = max( 2, ceil( sqrt( $this->gd_pixels( $radius ) ) ) );
													$corners =
														array(
															array( $left + $width - $radius, $top + $direction * $radius, -90 ),
															array( $left + $width - $radius, $top + $direction * ( $height - $radius ), 0 ),
															array( $left + $radius, $top + $direction * ( $height - $radius ), 90 ),
															array( $left + $radius, $top + $direction * $radius, 180 )
														);
												//-> Points
													foreach( $corners as $corner ) {
														//-> Each
															for( $i = 0; $i <= $steps; $i++ ) {
																//-> Angle
																	$angle = deg2rad( $corner[2] + 90 * $i / $steps );
																//-> Add
																	$points[] = $corner[0] + $radius * cos( $angle );
																	$points[] = $corner[1] + $direction * $radius * sin( $angle );
															}
													}
											} else {
												//-> Points
													$points =
														array(
															$left,
															$top,
															$left + $width,
															$top,
															$left + $width,
															$top + $direction * $height,
															$left,
															$top + $direction * $height
														);
											}
										//-> Rotation
											if( $element['angle'] != 0 ) {
												//-> Variables
													$angle = deg2rad( $element['angle'] );
													$cos   = cos( $angle );
													$sin   = sin( $angle );
												//-> Points
													for( $i = 0; $i < count( $points ); $i += 2 ) {
														//-> Coordinates
															$dx = $points[ $i ] - $x;
															$dy = $points[ $i + 1 ] - $y;
														//-> Update
															$points[ $i ]     = $x + $dx * $cos - $dy * $sin;
															$points[ $i + 1 ] = $y + $dx * $sin + $dy * $cos;
													}
											}
										//-> Element
											$element['points'] = $points;
											$element['closed'] = true;
										//-> Path
											$this->gd_path( $image, $element );
										break;
									case 'circle':
										//-> Radius
											$radius = $element['radius'];
											$points = array();
											$steps  = 4 * max( 2, ceil( sqrt( $this->gd_pixels( $radius ) ) ) );
										//-> Points
											for( $i = 0; $i < $steps; $i++ ) {
												//-> Angle
													$radians = ( 2 * M_PI * $i ) / $steps;
												//-> Add
													$points[] = $element['x'] + ( $radius * cos( $radians ) );
													$points[] = $element['y'] + ( $radius * sin( $radians ) );
											}
										//-> Path
											$this->gd_path(
												$image,
												array(
													'points'          => $points,
													'closed'          => true,
													'fill_color'      => $element['fill_color'],
													'stroke_color'    => $element['stroke_color'],
													'stroke_width'    => $element['stroke_width'],
													'stroke_linecap'  => 'round',
													'stroke_linejoin' => 'round'
												)
											);
										break;
									case 'ellipse':
										//-> Radius
											$radius_x = $element['radius_x'];
											$radius_y = $element['radius_y'];
											$points   = array();
											$angle    = deg2rad( $element['angle'] );
										//-> Rotation
											$cos   = cos( $angle );
											$sin   = sin( $angle );
											$steps = 4 * max( 2, ceil( sqrt( $this->gd_pixels( max( $radius_x, $radius_y ) ) ) ) );
										//-> Points
											for( $i = 0; $i < $steps; $i++ ) {
												//-> Angle
													$radians = ( 2 * M_PI * $i ) / $steps;
												//-> Local
													$x = $radius_x * cos( $radians );
													$y = $radius_y * sin( $radians );
												//-> Rotated
													$points[] = $element['x'] + ( $x * $cos ) - ( $y * $sin );
													$points[] = $element['y'] + ( $x * $sin ) + ( $y * $cos );
											}
										//-> Path
											$this->gd_path(
												$image,
												array(
													'points'          => $points,
													'closed'          => true,
													'fill_color'      => $element['fill_color'],
													'stroke_color'    => $element['stroke_color'],
													'stroke_width'    => $element['stroke_width'],
													'stroke_linecap'  => 'round',
													'stroke_linejoin' => 'round'
												)
											);
										break;
									case 'arc':
										//-> Variables
											$radius = $element['radius'];
											$start  = $element['start'];
											$sweep  = $element['sweep'];
											$points = array();
											$steps  = max( 1, ceil( ( $sweep / 90 ) * max( 2, ceil( sqrt( $this->gd_pixels( $radius ) ) ) ) ) );
										//-> Points
											for( $i = 0; $i <= $steps; $i++ ) {
												//-> Angle
													$angle = deg2rad( $start + ( $sweep * $i / $steps ) );
												//-> Add
													$points[] = $element['x'] + $radius * cos( $angle );
													$points[] = $element['y'] + $radius * sin( $angle );
											}
										//-> Path
											$this->gd_path(
												$image,
												array(
													'points'          => $points,
													'closed'          => false,
													'fill_color'      => '#00000000',
													'stroke_color'    => $element['stroke_color'],
													'stroke_width'    => $element['stroke_width'],
													'stroke_linecap'  => $element['stroke_linecap'],
													'stroke_linejoin' => 'round'
												)
											);
										break;
									case 'ellipse_arc':
										//-> Variables
											$radius_x = $element['radius_x'];
											$radius_y = $element['radius_y'];
											$start    = $element['start'];
											$sweep    = $element['sweep'];
											$angle    = deg2rad( $element['angle'] );
											$cos      = cos( $angle );
											$sin      = sin( $angle );
											$points   = array();
											$steps    = max( 1, ceil( ( $sweep / 90 ) * max( 2, ceil( sqrt( $this->gd_pixels( max( $radius_x, $radius_y ) ) ) ) ) ) );
										//-> Points
											for( $i = 0; $i <= $steps; $i++ ) {
												//-> Angle
													$radians = deg2rad( $start + ( $sweep * $i / $steps ) );
												//-> Local
													$x = $radius_x * cos( $radians );
													$y = $radius_y * sin( $radians );
												//-> Rotated
													$points[] = $element['x'] + ( $x * $cos ) - ( $y * $sin );
													$points[] = $element['y'] + ( $x * $sin ) + ( $y * $cos );
											}
										//-> Path
											$this->gd_path(
												$image,
												array(
													'points'          => $points,
													'closed'          => false,
													'fill_color'      => '#00000000',
													'stroke_color'    => $element['stroke_color'],
													'stroke_width'    => $element['stroke_width'],
													'stroke_linecap'  => $element['stroke_linecap'],
													'stroke_linejoin' => 'round'
												)
											);
										break;
									case 'image':
										//-> Source
											if( $element['mime'] === 'image/png' ) {
												//-> Load
													$source = @imagecreatefrompng( $element['path'] );
											} else {
												//-> Load
													$source = @imagecreatefromjpeg( $element['path'] );
											}
										//-> Check
											if( $source === false ) {
												//-> Error
													$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to load image : ' . var_export( $element['path'], true ) );
												//-> Return
													return null;
											} else {
												//-> Size
													$width  = max( 1, round( $this->gd_pixels( $element['width'] ) ) );
													$height = max( 1, round( $this->gd_pixels( $element['height'] ) ) );
												//-> Create
													$bitmap = @imagecreatetruecolor( $width, $height );
												//-> Check
													if( $bitmap === false ) {
														//-> Error
															$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to create image buffer' );
														//-> Return
															return null;
													} else {
														//-> Transparency
															imagealphablending( $bitmap, false );
															imagesavealpha( $bitmap, true );
															$clear = imagecolorallocatealpha( $bitmap, 0, 0, 0, 127 );
															imagefill( $bitmap, 0, 0, $clear );
														//-> Resize
															imagecopyresampled( $bitmap, $source, 0, 0, 0, 0, $width, $height, imagesx( $source ), imagesy( $source ) );
														//-> Position
															$x = $this->gd_x( $this->gd_position_x( $element['x'], $element['width'], $element['anchor'] ) );
															$y = $this->gd_y( $this->gd_position_y( $element['y'], $element['height'], $element['anchor'] ) );
														//-> Rotation
															if( $element['angle'] != 0 ) {
																//-> Angle
																	$angle = $element['angle'];
																	if( $this->origin() === 'bottom-left' ) {
																		//-> Update
																			$angle = -$angle;
																	}
																//-> Rotate
																	$rotated = @imagerotate( $bitmap, -$angle, $clear );
																//-> Check
																	if( $rotated === false ) {
																		//-> Error
																			$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to rotate image' );
																		//-> Return
																			return null;
																	} else {
																		//-> Anchor
																			$cx = $this->gd_x( $element['x'] );
																			$cy = $this->gd_y( $element['y'] );
																		//-> Offset
																			$dx = $x + 0.5 * $width - $cx;
																			$dy = $y + 0.5 * $height - $cy;
																		//-> Angle
																			$radians = deg2rad( $angle );
																			$cos     = cos( $radians );
																			$sin     = sin( $radians );
																		//-> Position
																			$x = $cx + $dx * $cos - $dy * $sin - 0.5 * imagesx( $rotated );
																			$y = $cy + $dx * $sin + $dy * $cos - 0.5 * imagesy( $rotated );
																		//-> Draw
																			imagecopy( $image, $rotated, round( $x ), round( $y ), 0, 0, imagesx( $rotated ), imagesy( $rotated ) );
																	}
															} else {
																//-> Draw
																	imagecopy( $image, $bitmap, round( $x ), round( $y ), 0, 0, $width, $height );
															}
													}
											}
										break;
									case 'text':
										//-> Check
											if( $element['text'] !== '' && substr( $element['text_color'], -2 ) !== '00' ) {
												//-> Variables
													$font    = $element['text_font'];
													$size    = $element['text_size'];
													$metrics = canvas_ttf::metrics( $font, $size );
													$width   = canvas_ttf::width( $font, $element['text'], $size );
												//-> Check
													if( !function_exists( 'imagettftext' ) || !is_array( $metrics ) || !is_numeric( $width ) ) {
														//-> Error
															$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to render text' );
														//-> Return
															return null;
													} else {
														//-> Position
															$x = $this->gd_position_x( $element['x'], $width, $element['anchor'] );
															$y = $this->gd_position_y( $element['y'], $metrics['height'], $element['anchor'] );
														//-> Baseline
															if( $this->origin() === 'bottom-left' ) {
																//-> Update
																	$y -= $metrics['height'];
															} else {
																//-> Update
																	$y += $metrics['height'];
															}
														//-> Rotation
															if( $element['angle'] != 0 ) {
																//-> Variables
																	$radians = deg2rad( $element['angle'] );
																	$cos     = cos( $radians );
																	$sin     = sin( $radians );
																	$dx      = $x - $element['x'];
																	$dy      = $y - $element['y'];
																//-> Update
																	$x = $element['x'] + $dx * $cos - $dy * $sin;
																	$y = $element['y'] + $dx * $sin + $dy * $cos;
															}
														//-> Angle
															$angle = $element['angle'];
														//-> Check
															if( $this->origin() === 'top-left' ) {
																//-> Update
																	$angle = -$angle;
															}
														//-> Color
															$color = $this->gd_color( $image, $element['text_color'] );
														//-> Draw
															$result = @imagettftext( $image, ( $this->gd_pixels( $size ) * ( 72 / 96 ) ), $angle, round( $this->gd_x( $x ) ), round( $this->gd_y( $y ) ), $color, $font, $element['text'] );
														//-> Check
															if( $result === false ) {
																//-> Error
																	$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to draw text' );
																//-> Return
																	return null;
															}
													}
											}
										break;
									case 'paragraph':
										//-> Check
											if( substr( $element['text_color'], -2 ) !== '00' ) {
												//-> Variables
													$font    = $element['text_font'];
													$size    = $element['text_size'];
													$metrics = canvas_ttf::metrics( $font, $size );
												//-> Check
													if( !function_exists( 'imagettftext' ) || !is_array( $metrics ) ) {
														//-> Error
															$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to render paragraph' );
														//-> Return
															return null;
													} else {
														//-> Position
															$x = $this->gd_position_x( $element['x'], $element['width'], $element['anchor'] );
															$y = $this->gd_position_y( $element['y'], $element['height'], $element['anchor'] );
														//-> Rotation
															$angle   = $element['angle'];
															$radians = deg2rad( $angle );
															$cos     = cos( $radians );
															$sin     = sin( $radians );
														//-> Angle
															if( $this->origin() === 'top-left' ) {
																//-> Update
																	$angle = -$angle;
															}
														//-> Style
															$color = $this->gd_color( $image, $element['text_color'] );
															$index = 0;
														//-> Paragraphs
															foreach( $element['paragraphs'] as $paragraph ) {
																//-> Lines
																	foreach( $paragraph as $number => $line ) {
																		//-> Width
																			$width = canvas_ttf::width( $font, $line, $size );
																		//-> Check
																			if( !is_numeric( $width ) ) {
																				//-> Error
																					$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to calculate paragraph line width' );
																				//-> Return
																					return null;
																			} else {
																				//-> Position
																					$line_x = $x;
																					$line_y = $y + $metrics['height'] + $index * $element['line_height'];
																				//-> Origin
																					if( $this->origin() === 'bottom-left' ) {
																						//-> Update
																							$line_y = $y - $metrics['height'] - $index * $element['line_height'];
																					}
																				//-> Align
																					if( $element['align'] === 'center' ) {
																						//-> Update
																							$line_x += 0.5 * ( $element['width'] - $width );
																					}
																					if( $element['align'] === 'right' ) {
																						//-> Update
																							$line_x += $element['width'] - $width;
																					}
																				//-> Text
																					if( $line !== '' ) {
																						//-> Justified
																							if(
																								$element['align'] === 'justified' &&
																								$number < count( $paragraph ) - 1 &&
																								strpos( $line, ' ' ) !== false
																							) {
																								//-> Words
																									$words   = explode( ' ', $line );
																									$spacing = ( $element['width'] - $width ) / ( count( $words ) - 1 );
																								//-> Each
																									foreach( $words as $word ) {
																										//-> Rotation
																											$dx = $line_x - $element['x'];
																											$dy = $line_y - $element['y'];
																											$tx = $element['x'] + $dx * $cos - $dy * $sin;
																											$ty = $element['y'] + $dx * $sin + $dy * $cos;
																										//-> Draw
																											$result = @imagettftext( $image, $this->gd_pixels( $size ) * ( 72 / 96 ), $angle, round( $this->gd_x( $tx ) ), round( $this->gd_y( $ty ) ), $color, $font, $word );
																										//-> Check
																											if( $result === false ) {
																												//-> Error
																													$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to draw paragraph' );
																												//-> Return
																													return null;
																											}
																										//-> Advance
																											$line_x += canvas_ttf::width( $font, $word . ' ', $size ) + $spacing;
																									}
																							} else {
																								//-> Rotation
																									$dx = $line_x - $element['x'];
																									$dy = $line_y - $element['y'];
																									$tx = $element['x'] + $dx * $cos - $dy * $sin;
																									$ty = $element['y'] + $dx * $sin + $dy * $cos;
																								//-> Draw
																									$result = @imagettftext( $image, $this->gd_pixels( $size ) * 72 / 96, $angle, round( $this->gd_x( $tx ) ), round( $this->gd_y( $ty ) ), $color, $font, $line );
																								//-> Check
																									if( $result === false ) {
																										//-> Error
																											$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to draw paragraph' );
																										//-> Return
																											return null;
																									}
																							}
																					}
																			}
																		//-> Next
																			$index++;
																	}
															}
													}
											}
										break;
									default:
										//-> Error
											$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unsupported element : ' . var_export( $element['type'], true ) );
										//-> Return
											return null;
								}
						}
					//-> Scale
						$this->gd_scale = 1;
					//-> Resize
						$output = @imagecreatetruecolor( $image_width, $image_height );
					//-> Check
						if( $output === false ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to create image' );
							//-> Return
								return null;
						}
					//-> Transparency
						imagealphablending( $output, false );
						imagesavealpha( $output, true );
					//-> Copy
						imagecopyresampled( $output, $image, 0, 0, 0, 0, $image_width, $image_height, imagesx( $image ), imagesy( $image ) );
					//-> Encode
						ob_start();
						$success = $this->gd_encode( $output );
						$data    = ob_get_clean();
					//-> Check
						if( !$success || !is_string( $data ) || $data === '' ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to encode image' );
							//-> Return
								return null;
						}
					//-> Return
						return $data;
				}
		}
	//-> PNG
		class canvas_png extends canvas_gd {
			//-> Variables
				protected $mime        = 'image/png';
				protected $transparent = true;
			//-> Encode
				protected function gd_encode( $image ) {
					//-> Return
						return imagepng( $image, null, 6 );
				}
		}
	//-> JPG
		class canvas_jpg extends canvas_gd {
			//-> Variables
				protected $mime = 'image/jpeg';
			//-> Encode
				protected function gd_encode( $image ) {
					//-> Return
						return imagejpeg( $image, null, 90 );
				}
		}
	//-> PDF
		class canvas_pdf extends canvas_renderer {
			//-> Variables
				protected $mime        = 'application/pdf';
				protected $page_active = false;
				protected $pages       = array();
				protected $bookmarks   = array();
				protected $metadata    = array();
				protected $pdf         = array();
				protected $pdf_length  = 0;
			//-> Constructor
				public function __construct( $width = 210, $height = 297, $unit = 'mm' ) {
					//-> Unit
						$this->unit( $unit );
					//-> Width
						$this->width( $width );
					//-> Height
						$this->height( $height );
				}
			//-> Page count
				public function page_count() {
					//-> Return
						return count( $this->pages ) + 1;
				}
			//-> Page
				public function page( $width = null, $height = null, $unit = null ) {
					//-> Check
						if( $unit !== null && ( $width === null || $height === null ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Width and height are required when changing unit' );
							//-> Return
								return $this;
						}
					//-> Previous page
						if( $this->page_active || count( $this->elements ) > 0 ) {
							//-> Add
								$this->pages[] = $this->pdf_page_data();
						}
					//-> New page
						$this->elements = array();
						$this->link     = null;
					//-> Unit
						if( $unit !== null ) {
							//-> Update
								$this->unit( $unit );
						}
					//-> Width
						if( $width !== null ) {
							//-> Update
								$this->width( $width );
						}
					//-> Height
						if( $height !== null ) {
							//-> Update
								$this->height( $height );
						}
					//-> Active
						$this->page_active = true;
					//-> Return
						return $this;
				}
			//-> Bookmark
				public function bookmark( $title, $page_number = 0, $level = 0, $y = null ) {
					//-> Normalize
						if( is_numeric( $page_number ) && floor( $page_number ) == $page_number ) {
							//-> Update
								$page_number = intval( $page_number );
						}
						if( is_numeric( $level ) && floor( $level ) == $level ) {
							//-> Update
								$level = intval( $level );
						}
					//-> Check
						if(
							is_string( $title ) && $title !== '' && preg_match( '//u', $title ) &&
							is_int( $page_number ) && $page_number >= 0 &&
							is_int( $level ) && $level >= 0 &&
							( $y === null || is_numeric( $y ) )
						) {
							//-> Check
								if( $page_number === 0 ) {
									//-> Update
										$page_number = $this->page_count();
								}
							//-> Store
								$this->bookmarks[] =
									array(
										'title' => $title,
										'page'  => $page_number,
										'level' => $level,
										'y'     => $y
									);
						} else {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid bookmark parameters : ' . var_export( func_get_args(), true ) );
						}
					//-> Return
						return $this;
				}
			//-> Link page
				public function link_page( $page_number = 0, $y = null ) {
					//-> Normalize
						if( is_numeric( $page_number ) && floor( $page_number ) == $page_number ) {
							//-> Update
								$page_number = intval( $page_number );
						}
					//-> Check
						if( is_int( $page_number ) && $page_number >= 0 && ( $y === null || is_numeric( $y ) ) ) {
							//-> Check
								if( $page_number === 0 ) {
									//-> Update
										$page_number = $this->page_count();
								}
							//-> Store
								$this->link = array( 'page' => $page_number, 'y' => $y );
						} else {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid page link parameters : ' . var_export( func_get_args(), true ) );
						}
					//-> Return
						return $this;
				}
			//-> Metadata
				public function metadata( $key = null, $value = null ) {
					//-> Switch
						switch( func_num_args() ) {
							case 0:
								//-> Return
									return $this->metadata;
							case 1:
								//-> Check
									if( is_string( $key ) && isset( $this->metadata[ $key ] ) ) {
										//-> Return
											return $this->metadata[ $key ];
									}
								//-> Return
									return null;
							default:
								//-> Check
									if(
										is_string( $key ) &&
										in_array( $key, array( 'title', 'author', 'subject', 'keywords', 'creator', 'producer' ), true ) &&
										is_string( $value )
									) {
										//-> Store
											$this->metadata[ $key ] = $value;
									} else {
										//-> Error
											$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid metadata parameters : ' . var_export( func_get_args(), true ) );
									}
								break;
						}
					//-> Return
						return $this;
				}
			//-> Current page
				protected function pdf_page_data() {
					//-> Return
						return
							array(
								'width'    => $this->width,
								'height'   => $this->height,
								'unit'     => $this->unit,
								'origin'   => $this->origin,
								'elements' => $this->elements
							);
				}
			//-> Number
				protected function pdf_number( $number ) {
					//-> Check
						if( !is_numeric( $number ) || !is_finite( floatval( $number ) ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid PDF number' );
							//-> Return
								return null;
						}
					//-> Clean
						$number = rtrim( rtrim( sprintf( '%.6F', floatval( $number ) ), '0' ), '.' );
					//-> Zero
						if( $number === '-0' ) {
							//-> Update
								$number = '0';
						}
					//-> Return
						return $number;
				}
			//-> String
				protected function pdf_string( $value ) {
					//-> Variable
						$result = '';
					//-> Check
						if( !is_string( $value ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid PDF string' );
							//-> Return
								return null;
						}
					//-> ASCII
						if( preg_match( '/^[\x20-\x7E]*$/D', $value ) ) {
							//-> Return
								return '(' . str_replace( array( '\\', '(', ')' ), array( '\\\\', '\(', '\)' ), $value ) . ')';
						}
					//-> UTF-8
						if( preg_match_all( '/./us', $value, $characters ) === false ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid UTF-8 string' );
							//-> Return
								return null;
						}
					//-> Encode
						foreach( $characters[0] as $character ) {
							//-> Bytes
								$length = strlen( $character );
								$code   = ord( $character[0] );
							//-> Decode
								switch( $length ) {
									case 2:
										//-> Unicode
											$code = ( ( $code % 32 ) * 64 ) + ( ord( $character[1] ) % 64 );
										break;
									case 3:
										//-> Unicode
											$code = ( ( $code % 16 ) * 4096 ) + ( ( ord( $character[1] ) % 64 ) * 64 ) + ( ord( $character[2] ) % 64 );
										break;
									case 4:
										//-> Unicode
											$code = ( ( $code % 8 ) * 262144 ) + ( ( ord( $character[1] ) % 64 ) * 4096 ) + ( ( ord( $character[2] ) % 64 ) * 64 ) + ( ord( $character[3] ) % 64 );
										break;
								}
							//-> UTF-16
								if( $code <= 65535 ) {
									//-> Add
										$result .= pack( 'n', $code );
								} else {
									//-> Surrogates
										$code -= 65536;
										$result .= pack( 'n', 55296 + intval( $code / 1024 ) );
										$result .= pack( 'n', 56320 + ( $code % 1024 ) );
								}
						}
					//-> Return
						return '<FEFF' . strtoupper( bin2hex( $result ) ) . '>';
				}
			//-> Object
				protected function pdf_object( &$objects, $content = null ) {
					//-> Check
						if( !is_array( $objects ) || ( $content !== null && !is_string( $content ) ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid PDF object' );
							//-> Return
								return null;
						}
					//-> Number
						$number = count( $objects ) + 1;
					//-> Store
						$objects[ $number ] = $content;
					//-> Return
						return $number;
				}
			//-> Bookmarks
				protected function pdf_bookmarks( &$objects, $pages, $page_refs ) {
					//-> Variables
						$nodes = array();
						$roots = array();
						$stack = array();
					//-> Outline
						$outline_id = $this->pdf_object( $objects );
					//-> Bookmarks
						foreach( $this->bookmarks as $bookmark ) {
							//-> Level
								$level = $bookmark['level'];
							//-> Check
								if( $level > count( $stack ) ) {
									//-> Error
										$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid bookmark hierarchy : ' . var_export( $bookmark['title'], true ) );
									//-> Return
										return null;
								}
							//-> Destination
								$destination = $this->pdf_destination( $bookmark['page'], $bookmark['y'], $pages, $page_refs );
							//-> Check
								if( $destination === null ) {
									//-> Return
										return null;
								}
							//-> Parent
								$parent = null;
								if( $level > 0 ) {
									//-> Update
										$parent = $stack[ $level - 1 ];
								}
							//-> Object
								$id = $this->pdf_object( $objects );
							//-> Node
								$nodes[ $id ] =
									array(
										'title'       => $bookmark['title'],
										'destination' => $destination,
										'parent'      => $parent,
										'children'    => array(),
										'count'       => 0
									);
							//-> Attach
								if( $parent === null ) {
									//-> Add
										$roots[] = $id;
								} else {
									//-> Add
										$nodes[ $parent ]['children'][] = $id;
								}
							//-> Stack
								$stack   = array_slice( $stack, 0, $level );
								$stack[] = $id;
						}
					//-> Descendants
						foreach( $nodes as $node ) {
							//-> Parent
								$parent = $node['parent'];
							//-> Count
								while( $parent !== null ) {
									//-> Update
										$nodes[ $parent ]['count']++;
										$parent = $nodes[ $parent ]['parent'];
								}
						}
					//-> Outline
						$objects[ $outline_id ] =
							$this->pdf_dictionary(
								array(
									'Type'  => '/Outlines',
									'First' => $roots[0] . ' 0 R',
									'Last'  => end( $roots ) . ' 0 R',
									'Count' => count( $nodes )
								)
							);
					//-> Items
						foreach( $nodes as $id => $node ) {
							//-> Siblings
								if( $node['parent'] === null ) {
									//-> Update
										$siblings       = $roots;
										$entries_parent = $outline_id . ' 0 R';
								} else {
									//-> Update
										$siblings       = $nodes[ $node['parent'] ]['children'];
										$entries_parent = $node['parent'] . ' 0 R';
								}
								$index = array_search( $id, $siblings, true );
							//-> Entries
								$entries =
									array(
										'Title'  => $this->pdf_string( $node['title'] ),
										'Parent' => $entries_parent,
										'Dest'   => $node['destination']
									);
							//-> Previous
								if( $index > 0 ) {
									//-> Update
										$entries['Prev'] = $siblings[ $index - 1 ] . ' 0 R';
								}
							//-> Next
								if( $index < ( count( $siblings ) - 1 ) ) {
									//-> Update
										$entries['Next'] = $siblings[ $index + 1 ] . ' 0 R';
								}
							//-> Children
								if( count( $node['children'] ) > 0 ) {
									//-> Update
										$entries['First'] = $node['children'][0] . ' 0 R';
										$entries['Last']  = end( $node['children'] ) . ' 0 R';
										$entries['Count'] = $node['count'];
								}
							//-> Store
								$objects[ $id ] = $this->pdf_dictionary( $entries );
						}
					//-> Return
						return $outline_id;
				}
			//-> Destination reference
				protected function pdf_destination( $page_number, $y, $pages, $page_refs ) {
					//-> Check
						if( !is_int( $page_number ) || $page_number < 1 || ( $y !== null && !is_numeric( $y ) ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid destination : ' . var_export( array( $page_number, $y ), true ) );
							//-> Return
								return null;
						}
					//-> Page
						$page_index = $page_number - 1;
					//-> Check
						if( !isset( $page_refs[ $page_index ] ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Destination page does not exist : ' . $page_number );
							//-> Return
								return null;
						}
					//-> Reference
						$reference = $page_refs[ $page_index ];
					//-> Position
						if( $y !== null ) {
							//-> Convert
								$position = $this->pdf_number( $this->pdf_y( floatval( $y ), $pages[ $page_index ] ) );
							//-> Check
								if( $position === null ) {
									//-> Return
										return null;
								}
							//-> Return
								return '[ ' . $reference . ' /XYZ null ' . $position . ' null ]';
						}
					//-> Return
						return '[ ' . $reference . ' /Fit ]';
				}
			//-> Link rectangle
				protected function pdf_link_rectangle( $element, $page ) {
					//-> Variables
						$xs      = array();
						$ys      = array();
						$padding = 1;
					//-> Geometry
						switch( $element['type'] ) {
							case 'line':
								//-> Coordinates
									$xs = array( $this->pdf_x( $element['x1'], $page ), $this->pdf_x( $element['x2'], $page ) );
									$ys = array( $this->pdf_y( $element['y1'], $page ), $this->pdf_y( $element['y2'], $page ) );
								break;
							case 'polyline':
								//-> Points
									for( $i = 0; $i < count( $element['points'] ); $i += 2 ) {
										//-> Add
											$xs[] = $this->pdf_x( $element['points'][ $i ], $page );
											$ys[] = $this->pdf_y( $element['points'][ $i + 1 ], $page );
									}
								break;
							case 'circle':
							case 'ellipse':
							case 'arc':
							case 'ellipse_arc':
								//-> Radii
									if( isset( $element['radius'] ) ) {
										//-> Update
											$radius_x = $element['radius'];
											$radius_y = $element['radius'];
									} else {
										//-> Update
											$radius_x = $element['radius_x'];
											$radius_y = $element['radius_y'];
									}
									$radius_x = $this->pdf_unit( $radius_x, $page['unit'] );
									$radius_y = $this->pdf_unit( $radius_y, $page['unit'] );
								//-> Rotation
									$angle = 0;
									if( isset( $element['angle'] ) ) {
										//-> Update
											$angle = deg2rad( $element['angle'] );
									}
									$cos = cos( $angle );
									$sin = sin( $angle );
								//-> Bounds
									$extent_x = sqrt( pow( $radius_x * $cos, 2 ) + pow( $radius_y * $sin, 2 ) );
									$extent_y = sqrt( pow( $radius_x * $sin, 2 ) + pow( $radius_y * $cos, 2 ) );
								//-> Center
									$x  = $this->pdf_x( $element['x'], $page );
									$y  = $this->pdf_y( $element['y'], $page );
									$xs = array( $x - $extent_x, $x + $extent_x );
									$ys = array( $y - $extent_y, $y + $extent_y );
								break;
							case 'rectangle':
							case 'image':
							case 'text':
							case 'paragraph':
								//-> Dimensions
									if( $element['type'] === 'text' ) {
										//-> Metrics
											$metrics = canvas_ttf::metrics( $element['text_font'], $element['text_size'] );
											$width   = canvas_ttf::width( $element['text_font'], $element['text'], $element['text_size'] );
										//-> Check
											if( !is_array( $metrics ) || !is_numeric( $width ) ) {
												//-> Error
													$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to calculate link bounds' );
												//-> Return
													return null;
											}
										//-> Height
											$height = $metrics['height'];
									} else {
										//-> Dimensions
											$width  = $element['width'];
											$height = $element['height'];
									}
								//-> Convert
									$width  = $this->pdf_unit( $width, $page['unit'] );
									$height = $this->pdf_unit( $height, $page['unit'] );
								//-> Position
									$x      = $this->pdf_x( $element['x'], $page );
									$y      = $this->pdf_y( $element['y'], $page );
									$left   = $this->pdf_position_x( 0, $width, $element['anchor'] );
									$bottom = $this->pdf_position_y( 0, $height, $element['anchor'], $page );
								//-> Rotation
									if( $page['origin'] === 'top-left' ) {
										//-> Update
											$angle = -$element['angle'];
									} else  {
										//-> Update
											$angle = $element['angle'];
									}
									$cos = cos( deg2rad( $angle ) );
									$sin = sin( deg2rad( $angle ) );
								//-> Corners
									$corners =
										array(
											array( $left, $bottom ),
											array( $left + $width, $bottom ),
											array( $left + $width, $bottom + $height ),
											array( $left, $bottom + $height )
										);
								//-> Rotate
									foreach( $corners as $corner ) {
										//-> Add
											$xs[] = $x + ( $corner[0] * $cos ) - ( $corner[1] * $sin );
											$ys[] = $y + ( $corner[0] * $sin ) + ( $corner[1] * $cos );
									}
								break;
						}
					//-> Check
						if( count( $xs ) === 0 || count( $ys ) === 0 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to calculate link bounds' );
							//-> Return
								return null;
						}
					//-> Stroke
						if( isset( $element['stroke_width'] ) ) {
							//-> Update
								$padding = max( $padding, 0.5 * $this->pdf_unit( $element['stroke_width'], $page['unit'] ) );
						}
					//-> Rectangle
						return '[ ' . implode( ' ', array( $this->pdf_number( min( $xs ) - $padding ), $this->pdf_number( min( $ys ) - $padding ), $this->pdf_number( max( $xs ) + $padding ), $this->pdf_number( max( $ys ) + $padding ) ) ) . ' ]';
				}
			//-> Stream
				protected function pdf_stream( $content, $dictionary = '' ) {
					//-> Check
						if( !is_string( $content ) || !is_string( $dictionary ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid PDF stream' );
							//-> Return
								return null;
						}
					//-> Dictionary
						$result = '<< /Length ' . strlen( $content );
					//-> Additional entries
						$dictionary = trim( $dictionary );
					//-> Check
						if( $dictionary !== '' ) {
							//-> Append
								$result .= ' ' . $dictionary;
						}
					//-> Stream
						$result .= " >>\nstream\n";
						$result .= $content;
						$result .= "\nendstream";
					//-> Return
						return $result;
				}
			//-> Dictionary
				protected function pdf_dictionary( $entries ) {
					//-> Variable
						$dictionary = array();
					//-> Entries
						foreach( $entries as $key => $value ) {
							//-> Check
								if( !is_string( $value ) && !is_int( $value ) && !is_float( $value ) ) {
									//-> Error
										$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid dictionary value' );
									//-> Return
										return null;
								}
							//-> Float
								if( is_float( $value ) ) {
									//-> Convert
										$value = $this->pdf_number( $value );
								} else {
									//-> Convert
										$value = strval( $value );
								}
							//-> Add
								$dictionary[] = '/' . $key . ' ' . $value;
						}
					//-> Return
						return '<< ' . implode( ' ', $dictionary ) . ' >>';
				}
			//-> Append
				protected function pdf_append( $data ) {
					//-> Add
						$this->pdf[] = $data . "\n";
					//-> Length
						$this->pdf_length += strlen( $data ) + 1;
				}
			//-> Unit
				protected function pdf_unit( $value, $unit ) {
					//-> Switch
						switch( $unit ) {
							case 'px':
								//-> Return
									return $value * ( 72 / 96 );
							case 'mm':
								//-> Return
									return $value * ( 72 / 25.4 );
							case 'cm':
								//-> Return
									return $value * ( 72 / 2.54 );
							case 'm':
								//-> Return
									return $value * ( 72 / 0.0254 );
							case 'in':
								//-> Return
									return $value * 72;
							case 'pt':
								//-> Return
									return $value;
						}
					//-> Error
						$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid PDF unit : ' . var_export( $unit, true ) );
					//-> Return
						return null;
				}
			//-> X
				protected function pdf_x( $x, $page ) {
					//-> Return
						return $this->pdf_unit( $x, $page['unit'] );
				}
			//-> Y
				protected function pdf_y( $y, $page ) {
					//-> Origin
						if( $page['origin'] === 'top-left' ) {
							//-> Update
								$y = $page['height'] - $y;
						}
					//-> Return
						return $this->pdf_unit( $y, $page['unit'] );
				}
			//-> Position X
				protected function pdf_position_x( $x, $width, $anchor ) {
					//-> Switch
						switch( $anchor ) {
							case 'top-center':
							case 'middle-center':
							case 'bottom-center':
								//-> Return
									return $x - ( 0.5 * $width );
							case 'top-right':
							case 'middle-right':
							case 'bottom-right':
								//-> Return
									return $x - $width;
						}
					//-> Return
						return $x;
				}
			//-> Position Y
				protected function pdf_position_y( $y, $height, $anchor, $page ) {
					//-> Auto
						if( $anchor === 'auto' ) {
							//-> Origin
								if( $page['origin'] === 'top-left' ) {
									//-> Update
										$anchor = 'top-left';
								} else {
									//-> Update
										$anchor = 'bottom-left';
								}
						}
					//-> Switch
						switch( $anchor ) {
							case 'top-left':
							case 'top-center':
							case 'top-right':
								//-> Return
									return $y - $height;
							case 'middle-left':
							case 'middle-center':
							case 'middle-right':
								//-> Return
									return $y - ( 0.5 * $height );
						}
					//-> Return
						return $y;
				}
			//-> Color
				protected function pdf_color( $color, $stroke = false ) {
					//-> Variable
						$pdf_color = array();
					//-> RGB
						$pdf_color[] = $this->pdf_number( hexdec( substr( $color, 1, 2 ) ) / 255 );
						$pdf_color[] = $this->pdf_number( hexdec( substr( $color, 3, 2 ) ) / 255 );
						$pdf_color[] = $this->pdf_number( hexdec( substr( $color, 5, 2 ) ) / 255 );
					//-> Operator
						if( $stroke ) {
							//-> Update
								$pdf_color[] = 'RG';
						} else {
							//-> Update
								$pdf_color[] = 'rg';
						}
					//-> Return
						return implode( ' ', $pdf_color );
				}
			//-> Opacity
				protected function pdf_opacity( $color, $stroke, &$opacities ) {
					//-> Alpha
						$alpha = substr( $color, 7, 2 );
					//-> Opaque
						if( $alpha !== 'FF' ) {
							//-> Fill
								$operator = 'ca';
								$name     = 'GSF' . $alpha;
							//-> Stroke
								if( $stroke ) {
									//-> Update
										$operator = 'CA';
										$name     = 'GSS' . $alpha;
								}
							//-> Register
								if( !isset( $opacities[ $name ] ) ) {
									//-> Update
										$opacities[ $name ] = '<< /Type /ExtGState /' . $operator . ' ' . $this->pdf_number( hexdec( $alpha ) / 255 ) . ' >>';
								}
							//-> Return
								return '/' . $name . ' gs';
						} else {
							//-> Return
								return '';
						}
				}
			//-> Path
				protected function pdf_path( $points, $page, $closed = false ) {
					//-> Variable
						$path = array();
					//-> Points
						for( $i = 0; $i < count( $points ); $i += 2 ) {
							//-> Check
								if( $i > 0 ) {
									//-> Operator
										$operator = 'l';
								} else {
									//-> Operator
										$operator = 'm';
								}
							//-> Add
								$path[] =
									implode(
										' ',
										array(
											$this->pdf_number( $this->pdf_x( $points[ $i ], $page ) ),
											$this->pdf_number( $this->pdf_y( $points[ $i + 1 ], $page ) ),
											$operator
										)
									);
						}
					//-> Close
						if( $closed ) {
							//-> Add
								$path[] = 'h';
						}
					//-> Return
						return implode( "\n", $path );
				}
			//-> Path operator
				protected function pdf_path_operator( $element, $closed = false ) {
					//-> Variables
						$stroke = false;
						$fill   = false;
					//-> Stroke
						if( $element['stroke_width'] > 0 ) {
							//-> Alpha
								$alpha = substr( $element['stroke_color'], 7, 2 );
							//-> Check
								if( $alpha !== '00' ) {
									//-> Update
										$stroke = true;
								}
						}
					//-> Fill
						if( $closed && isset( $element['fill_color'] ) ) {
							//-> Alpha
								$alpha = substr( $element['fill_color'], 7, 2 );
							//-> Check
								if( $alpha !== '00' ) {
									//-> Update
										$fill = true;
								}
						}
					//-> Both
						if( $stroke && $fill ) {
							//-> Return
								return 'B';
						}
					//-> Stroke
						if( $stroke ) {
							//-> Return
								return 'S';
						}
					//-> Fill
						if( $fill ) {
							//-> Return
								return 'f';
						}
					//-> Return
						return 'n';
				}
			//-> Ellipse arc
				protected function pdf_ellipse_arc( $x, $y, $radius_x, $radius_y, $start, $sweep, $angle, $page ) {
					//-> Variables
						$path     = array();
						$segments = ceil( abs( $sweep ) / 90 );
						$step     = deg2rad( $sweep / $segments );
						$start    = deg2rad( $start );
						$angle    = deg2rad( $angle );
						$cos      = cos( $angle );
						$sin      = sin( $angle );
						$factor   = ( 4 / 3 ) * tan( 0.25 * $step );
					//-> Segments
						for( $i = 0; $i < $segments; $i++ ) {
							//-> Angles
								$a = $start + ( $i * $step );
								$b = $a + $step;
							//-> Points
								$points =
									array(
										$radius_x * cos( $a ),
										$radius_y * sin( $a ),
										$radius_x * ( cos( $a ) - $factor * sin( $a ) ),
										$radius_y * ( sin( $a ) + $factor * cos( $a ) ),
										$radius_x * ( cos( $b ) + $factor * sin( $b ) ),
										$radius_y * ( sin( $b ) - $factor * cos( $b ) ),
										$radius_x * cos( $b ),
										$radius_y * sin( $b )
									);
							//-> Coordinates
								$curve = array();
							//-> Each
								for( $j = 0; $j < 8; $j += 2 ) {
									//-> Rotate and translate
										$px = $x + ( $points[ $j ] * $cos ) - ( $points[ $j + 1 ] * $sin );
										$py = $y + ( $points[ $j ] * $sin ) + ( $points[ $j + 1 ] * $cos );
									//-> Convert
										$curve[] = $this->pdf_number( $this->pdf_x( $px, $page ) );
										$curve[] = $this->pdf_number( $this->pdf_y( $py, $page ) );
								}
							//-> Start
								if( $i === 0 ) {
									//-> Add
										$path[] = $curve[0] . ' ' . $curve[1] . ' m';
								}
							//-> Curve
								$path[] = implode( ' ', array_slice( $curve, 2 ) ) . ' c';
						}
					//-> Return
						return implode( "\n", $path );
				}
			//-> JPG
				protected function pdf_jpg( $path, &$objects ) {
					//-> Information
						$info = @getimagesize( $path );
					//-> Check
						if(
							!is_array( $info ) ||
							!isset( $info[0], $info[1], $info['mime'], $info['bits'], $info['channels'] ) ||
							$info['mime'] !== 'image/jpeg' ||
							$info['bits'] !== 8 ||
							!in_array( $info['channels'], array( 1, 3 ), true )
						) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unsupported JPEG image : ' . var_export( $path, true ) );
							//-> Return
								return null;
						}
					//-> Color space
						if( $info['channels'] !== 1 ) {
							//-> Update
								$color_space = '/DeviceRGB';
						} else {
							//-> Update
								$color_space = '/DeviceGray';
						}
					//-> Read
						$data = @file_get_contents( $path );
					//-> Check
						if( $data === false ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to read JPEG image : ' . var_export( $path, true ) );
							//-> Return
								return null;
						}
					//-> Dictionary
						$dictionary =
							implode(
								' ',
								array(
									'/Type /XObject',
									'/Subtype /Image',
									'/Width ' . $info[0],
									'/Height ' . $info[1],
									'/ColorSpace ' . $color_space,
									'/BitsPerComponent 8',
									'/Filter /DCTDecode'
								)
							);
					//-> Return
						return $this->pdf_object( $objects, $this->pdf_stream( $data, $dictionary ) );
				}
			//-> PNG
				protected function pdf_png( $path, &$objects ) {
					//-> Read
						$data = @file_get_contents( $path );
					//-> Check
						if( $data === false || strlen( $data ) < 33 || substr( $data, 0, 16 ) !== "\x89PNG\r\n\x1A\n\x00\x00\x00\x0DIHDR" ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid PNG image : ' . var_export( $path, true ) );
							//-> Return
								return null;
						}
					//-> Header
						$size   = unpack( 'N2', substr( $data, 16, 8 ) );
						$width  = $size[1];
						$height = $size[2];
						$depth  = ord( $data[24] );
						$type   = ord( $data[25] );
						$bpp    = array( 0 => 1, 2 => 3, 3 => 1, 4 => 2, 6 => 4 );
					//-> Check
						if(
							$width < 1 ||
							$height < 1 ||
							$depth !== 8 ||
							!isset( $bpp[ $type ] ) ||
							substr( $data, 26, 3 ) !== "\x00\x00\x00"
						) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unsupported PNG image ( 8-bit, non-interlaced required ) : ' . var_export( $path, true ) );
							//-> Return
								return null;
						}
					//-> Chunks
						$idat        = '';
						$palette     = '';
						$transparent = '';
						$complete    = false;
						$offset      = 8;
						$length_data = strlen( $data );
					//-> Read chunks
						while( ( $offset + 12 ) <= $length_data && !$complete ) {
							//-> Length
								$value  = unpack( 'N', substr( $data, $offset, 4 ) );
								$length = $value[1];
							//-> Check
								if( $length > $length_data - $offset - 12 ) {
									//-> Error
										$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid PNG chunk : ' . var_export( $path, true ) );
									//-> Return
										return null;
								}
							//-> Chunk
								$chunk_type = substr( $data, $offset + 4, 4 );
								$chunk      = substr( $data, $offset + 8, $length );
							//-> Type
								switch( $chunk_type ) {
									case 'PLTE':
										//-> Palette
											$palette = $chunk;
										break;
									case 'tRNS':
										//-> Transparency
											$transparent = $chunk;
										break;
									case 'IDAT':
										//-> Image data
											$idat .= $chunk;
										break;
									case 'IEND':
										//-> Complete
											$complete = true;
										break;
								}
							//-> Next
								$offset += $length + 12;
						}
					//-> Check
						if( !$complete || $idat === '' || ( $type === 3 && ( $palette === '' || strlen( $palette ) % 3 !== 0 ) ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid PNG data : ' . var_export( $path, true ) );
							//-> Return
								return null;
						}
					//-> Decode
						$stride = $width * $bpp[ $type ];
						$length = ( $stride + 1 ) * $height;
						$raw    = @gzuncompress( $idat, $length );
					//-> Check
						if( $raw === false || strlen( $raw ) !== $length ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to decode PNG image : ' . var_export( $path, true ) );
							//-> Return
								return null;
						}
					//-> Pixels
						$rgb       = '';
						$alpha     = '';
						$has_alpha = false;
						$previous  = str_repeat( "\x00", $stride );
						$offset    = 0;
					//-> Rows
						for( $y = 0; $y < $height; $y++ ) {
							//-> Filter
								$filter = ord( $raw[ $offset ] );
								$offset++;
							//-> Check
								if( $filter > 4 ) {
									//-> Error
										$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid PNG filter : ' . var_export( $path, true ) );
									//-> Return
										return null;
								}
							//-> Row
								$row = substr( $raw, $offset, $stride );
								$offset += $stride;
							//-> Undo filter
								for( $i = 0; $i < $stride; $i++ ) {
									//-> Neighbors
										$left   = 0;
										$up     = ord( $previous[ $i ] );
										$corner = 0;
									//-> Left
										if( $i >= $bpp[ $type ] ) {
											//-> Update
												$left   = ord( $row[ $i - $bpp[ $type ] ] );
												$corner = ord( $previous[ $i - $bpp[ $type ] ] );
										}
									//-> Predictor
										$predict = 0;
									//-> Switch
										switch( $filter ) {
											case 1:
												//-> Sub
													$predict = $left;
												break;
											case 2:
												//-> Up
													$predict = $up;
												break;
											case 3:
												//-> Average
													$predict = intval( 0.5 * ( $left + $up ) );
												break;
											case 4:
												//-> Paeth
													$a = abs( $up - $corner );
													$b = abs( $left - $corner );
													$c = abs( $left + $up - ( 2 * $corner ) );
												//-> Select
													if( $a <= $b && $a <= $c ) {
														//-> Update
															$predict = $left;
													} elseif( $b <= $c ) {
														//-> Update
															$predict = $up;
													} else {
														//-> Update
															$predict = $corner;
													}
												break;
										}
									//-> Restore
										$row[ $i ] = chr( ( ord( $row[ $i ] ) + $predict ) % 256 );
								}
							//-> Previous
								$previous = $row;
							//-> Row pixels
								for( $x = 0; $x < $width; $x++ ) {
									//-> Offset
										$i       = $x * $bpp[ $type ];
										$opacity = 255;
									//-> Type
										switch( $type ) {
											case 0:
											case 4:
												//-> Gray
													$gray = ord( $row[ $i ] );
													$rgb .= str_repeat( chr( $gray ), 3 );
												//-> Alpha
													if( $type === 4 ) {
														//-> Update
															$opacity = ord( $row[ $i + 1 ] );
													}
												//-> Transparent gray
													if( $type === 0 && strlen( $transparent ) >= 2 && $gray === ord( $transparent[1] ) ) {
														//-> Update
															$opacity = 0;
													}
												break;
											case 3:
												//-> Palette index
													$index = ord( $row[ $i ] );
												//-> Check
													if( strlen( $palette ) < ( $index + 1 ) * 3 ) {
														//-> Error
															$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid PNG palette : ' . var_export( $path, true ) );
														//-> Return
															return null;
													}
												//-> RGB
													$rgb .= substr( $palette, $index * 3, 3 );
												//-> Alpha
													if( $index < strlen( $transparent ) ) {
														//-> Update
															$opacity = ord( $transparent[ $index ] );
													}
												break;
											case 2:
											case 6:
												//-> RGB
													$pixel = substr( $row, $i, 3 );
													$rgb .= $pixel;
												//-> Alpha
													if( $type === 6 ) {
														//-> Update
															$opacity = ord( $row[ $i + 3 ] );
													}
												//-> Transparent RGB
													if( $type === 2 && strlen( $transparent ) >= 6 && $pixel === ( $transparent[1] . $transparent[3] . $transparent[5] ) ) {
														//-> Update
															$opacity = 0;
													}
												break;
										}
									//-> Transparency
										$alpha .= chr( $opacity );
									//-> Check
										if( $opacity < 255 ) {
											//-> Update
												$has_alpha = true;
										}
								}
						}
					//-> Mask
						$mask = '';
					//-> Check
						if( $has_alpha ) {
							//-> Dictionary
								$dictionary =
									implode(
										' ',
										array(
											'/Type /XObject',
											'/Subtype /Image',
											'/Width ' . $width,
											'/Height ' . $height,
											'/ColorSpace /DeviceGray',
											'/BitsPerComponent 8',
											'/Filter /FlateDecode'
										)
									);
							//-> Object
								$mask_id = $this->pdf_object( $objects, $this->pdf_stream( gzcompress( $alpha ), $dictionary ) );
							//-> Check
								if( $mask_id === null ) {
									//-> Return
										return null;
								}
							//-> Reference
								$mask = '/SMask ' . $mask_id . ' 0 R';
						}
					//-> Image dictionary
						$entries =
							array(
								'/Type /XObject',
								'/Subtype /Image',
								'/Width ' . $width,
								'/Height ' . $height,
								'/ColorSpace /DeviceRGB',
								'/BitsPerComponent 8',
								'/Filter /FlateDecode'
							);
					//-> Mask reference
						if( $mask !== '' ) {
							//-> Add
								$entries[] = $mask;
						}
					//-> Return
						return $this->pdf_object( $objects, $this->pdf_stream( gzcompress( $rgb ), implode( ' ', $entries ) ) );
				}
			//-> Image
				protected function pdf_image( $path, &$objects, &$images ) {
					//-> Cache
						if( isset( $images[ $path ] ) ) {
							//-> Return
								return $images[ $path ];
						}
					//-> Information
						$info = @getimagesize( $path );
					//-> Check
						if( !is_array( $info ) || !isset( $info['mime'] ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid image : ' . var_export( $path, true ) );
							//-> Return
								return null;
						}
					//-> Format
						switch( $info['mime'] ) {
							case 'image/jpeg':
								//-> Read
									$image_id = $this->pdf_jpg( $path, $objects );
								break;
							case 'image/png':
								//-> Read
									$image_id = $this->pdf_png( $path, $objects );
								break;
							default:
								//-> Error
									$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unsupported image format : ' . var_export( $path, true ) );
								//-> Return
									return null;
						}
					//-> Cache
						if( $image_id !== null ) {
							//-> Update
								$images[ $path ] = $image_id;
						}
					//-> Return
						return $image_id;
				}
			//-> TTF
				protected function pdf_ttf( $path, &$objects ) {
					//-> Read
						$data = @file_get_contents( $path );
					//-> Check
						if( $data === false || strlen( $data ) < 4 ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to read TTF font : ' . var_export( $path, true ) );
							//-> Return
								return null;
						}
					//-> Format
						if( !in_array( substr( $data, 0, 4 ), array( "\x00\x01\x00\x00", 'true' ), true ) ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid TTF font : ' . var_export( $path, true ) );
							//-> Return
								return null;
						}
					//-> Dictionary
						$dictionary = '/Length1 ' . strlen( $data );
					//-> Return
						return $this->pdf_object( $objects, $this->pdf_stream( gzcompress( $data ), $dictionary . ' /Filter /FlateDecode' ) );
				}
			//-> TTF map
				protected function pdf_ttf_map( $info, &$objects ) {
					//-> Mappings
						$mappings = array();
					//-> Glyphs
						foreach( $info['glyphs'] as $character => $glyph ) {
							//-> Check
								if( isset( $mappings[ $glyph ] ) ) {
									//-> Continue
										continue;
								}
							//-> Unicode
								if( $character <= 65535 ) {
									//-> Value
										$unicode = sprintf( '%04X', $character );
								} else {
									//-> Surrogates
										$code    = $character - 65536;
										$unicode = sprintf( '%04X%04X', 55296 + intval( $code / 1024 ), 56320 + ( $code % 1024 ) );
								}
							//-> Add
								$mappings[ $glyph ] = '<' . sprintf( '%04X', $glyph ) . '> <' . $unicode . '>';
						}
					//-> Sort
						ksort( $mappings, SORT_NUMERIC );
					//-> Content
						$content =
							array(
								'/CIDInit /ProcSet findresource begin',
								'12 dict begin',
								'begincmap',
								'/CIDSystemInfo << /Registry (Adobe) /Ordering (UCS) /Supplement 0 >> def',
								'/CMapName /Adobe-Identity-UCS def',
								'/CMapType 2 def',
								'1 begincodespacerange',
								'<0000> <FFFF>',
								'endcodespacerange'
							);
					//-> Groups
						foreach( array_chunk( $mappings, 100 ) as $group ) {
							//-> Start
								$content[] = count( $group ) . ' beginbfchar';
							//-> Each
								foreach( $group as $mapping ) {
									//-> Add
										$content[] = $mapping;
								}
							//-> End
								$content[] = 'endbfchar';
						}
					//-> End
						$content[] = 'endcmap';
						$content[] = 'CMapName currentdict /CMap defineresource pop';
						$content[] = 'end';
						$content[] = 'end';
					//-> Return
						return $this->pdf_object( $objects, $this->pdf_stream( gzcompress( implode( "\n", $content ) ), '/Filter /FlateDecode' ) );
				}
			//-> Font descriptor
				protected function pdf_font_descriptor( $path, $font_name, &$objects ) {
					//-> Information
						$info = canvas_ttf::data( $path );
					//-> Check
						if( $info === null ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid TTF font : ' . var_export( $path, true ) );
							//-> Return
								return null;
						}
					//-> Font file
						$file_id = $this->pdf_ttf( $path, $objects );
					//-> Check
						if( $file_id === null ) {
							//-> Return
								return null;
						}
					//-> Scale
						$scale = 1000 / $info['units_per_em'];
					//-> Bounding box
						$bbox = array();
					//-> Each
						foreach( $info['bbox'] as $value ) {
							//-> Update
								$bbox[] = $this->pdf_number( $value * $scale );
						}
					//-> Dictionary
						$dictionary =
							$this->pdf_dictionary(
								array(
									'Type'        => '/FontDescriptor',
									'FontName'    => '/' . $font_name,
									'Flags'       => 32,
									'FontBBox'    => '[ ' . implode( ' ', $bbox ) . ' ]',
									'ItalicAngle' => 0,
									'Ascent'      => $this->pdf_number( $info['ascent'] * $scale ),
									'Descent'     => $this->pdf_number( $info['descent'] * $scale ),
									'CapHeight'   => $this->pdf_number( $info['cap_height'] * $scale ),
									'StemV'       => 80,
									'FontFile2'   => $file_id . ' 0 R'
								)
							);
					//-> Return
						return $this->pdf_object( $objects, $dictionary );
				}
			//-> Font
				protected function pdf_font( $path, &$objects, &$fonts ) {
					//-> Cache
						if( isset( $fonts[ $path ] ) ) {
							//-> Return
								return $fonts[ $path ];
						}
					//-> Information
						$info = canvas_ttf::data( $path );
					//-> Check
						if( $info === null ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid TTF font : ' . var_export( $path, true ) );
							//-> Return
								return null;
						}
					//-> TTF map
						$map_id = $this->pdf_ttf_map( $info, $objects );
					//-> Check
						if( $map_id === null ) {
							//-> Return
								return null;
						}
					//-> Name
						$font_name = 'CanvasFont' . strval( count( $fonts ) + 1 );
					//-> Descriptor
						$descriptor_id = $this->pdf_font_descriptor( $path, $font_name, $objects );
					//-> Check
						if( $descriptor_id === null ) {
							//-> Return
								return null;
						}
					//-> Glyph widths
						$glyph_widths = array();
					//-> Each
						foreach( $info['glyphs'] as $character => $glyph ) {
							//-> Update
								$glyph_widths[ $glyph ] = $info['widths'][ $character ];
						}
					//-> Sort
						ksort( $glyph_widths, SORT_NUMERIC );
					//-> Scale
						$scale = 1000 / $info['units_per_em'];
					//-> Widths
						$widths = array();
					//-> Each
						foreach( $glyph_widths as $glyph => $width ) {
							//-> Update
								$widths[] = $glyph . ' [' . $this->pdf_number( $width * $scale ) . ']';
						}
					//-> CID font
						$cid_dictionary =
							$this->pdf_dictionary(
								array(
									'Type'           => '/Font',
									'Subtype'        => '/CIDFontType2',
									'BaseFont'       => '/' . $font_name,
									'CIDSystemInfo'  => '<< /Registry (Adobe) /Ordering (Identity) /Supplement 0 >>',
									'FontDescriptor' => $descriptor_id . ' 0 R',
									'CIDToGIDMap'    => '/Identity',
									'W'              => '[ ' . implode( ' ', $widths ) . ' ]'
								)
							);
					//-> Object
						$cid_id = $this->pdf_object( $objects, $cid_dictionary );
					//-> Font
						$dictionary =
							$this->pdf_dictionary(
								array(
									'Type'            => '/Font',
									'Subtype'         => '/Type0',
									'BaseFont'        => '/' . $font_name,
									'Encoding'        => '/Identity-H',
									'DescendantFonts' => '[ ' . $cid_id . ' 0 R ]',
									'ToUnicode'       => $map_id . ' 0 R'
								)
							);
					//-> Object
						$font_id = $this->pdf_object( $objects, $dictionary );
					//-> Cache
						$fonts[ $path ] = $font_id;
					//-> Return
						return $font_id;
				}
			//-> Text
				protected function pdf_text( $text, $font ) {
					//-> Information
						$info = canvas_ttf::data( $font );
					//-> Characters
						$characters = canvas_ttf::characters( $text );
					//-> Check
						if( $info === null || $characters === null ) {
							//-> Error
								$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid text or font' );
							//-> Return
								return null;
						}
					//-> Glyphs
						$glyphs = '';
					//-> Each
						foreach( $characters as $character ) {
							//-> Check
								if( !isset( $info['glyphs'][ $character ] ) ) {
									//-> Error
										$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unsupported character : ' . $character );
									//-> Return
										return null;
								}
							//-> Add
								$glyphs .= pack( 'n', $info['glyphs'][ $character ] );
						}
					//-> Return
						return '<' . strtoupper( bin2hex( $glyphs ) ) . '>';
				}
			//-> Build
				protected function build() {
					//-> Reset
						$this->pdf        = array();
						$this->pdf_length = 0;
						$pages            = $this->pages;
						$pages[]          = $this->pdf_page_data();
						$objects     = array();
						$catalog_id  = $this->pdf_object( $objects );
						$pages_id    = $this->pdf_object( $objects );
						$page_refs   = array();
						$images      = array();
						$fonts       = array();
						$annotations = array();
						$layers      = array();
						$info_id     = null;
					//-> Pages
						foreach( $pages as $page ) {
							//-> Dimensions
								$page_width  = $this->pdf_number( $this->pdf_unit( $page['width'], $page['unit'] ) );
								$page_height = $this->pdf_number( $this->pdf_unit( $page['height'], $page['unit'] ) );
							//-> Content
								$content          = array();
								$opacities        = array();
								$image_resources  = array();
								$font_resources   = array();
								$layer_resources  = array();
								$page_annotations = array();
							//-> Elements
								foreach( $page['elements'] as $element ) {
									//-> Layer
										$layer = $element['layer'];
									//-> Register
										if( !isset( $layers[ $layer ] ) ) {
											//-> Name
												$name = $this->pdf_string( $layer );
											//-> Check
												if( $name === null ) {
													//-> Return
														return null;
												}
											//-> Object
												$layer_id = $this->pdf_object( $objects, $this->pdf_dictionary( array( 'Type' => '/OCG', 'Name' => $name ) ) );
											//-> Store
												$layers[ $layer ] = $layer_id;
										}
									//-> Resource
										$layer_id   = $layers[ $layer ];
										$layer_name = 'OC' . $layer_id;
										$layer_resources[ $layer_name ] = $layer_id . ' 0 R';
									//-> Begin layer
										$content[] = '/OC /' . $layer_name . ' BDC';
									//-> Type
										switch( $element['type'] ) {
											case 'line':
												//-> Check
													if( $this->pdf_path_operator( $element ) === 'S' ) {
														//-> Linecap
															switch( $element['stroke_linecap'] ) {
																case 'round':
																	//-> Linecap
																		$linecap = 1;
																	break;
																case 'square':
																	//-> Linecap
																		$linecap = 2;
																	break;
																default:
																	//-> Linecap
																		$linecap = 0;
																	break;
															}
														//-> Opacity
															$opacity   = $this->pdf_opacity( $element['stroke_color'], true, $opacities );
														//-> Start
															$content[] = 'q';
														//-> Stroke
															$content[] = $this->pdf_number( $this->pdf_unit( $element['stroke_width'], $page['unit'] ) ) . ' w';
															$content[] = $linecap . ' J';
															$content[] = $this->pdf_color( $element['stroke_color'], true );
														//-> Opacity
															if( $opacity !== '' ) {
																//-> Add
																	$content[] = $opacity;
															}
														//-> Path
															$content[] = $this->pdf_path( array( $element['x1'], $element['y1'], $element['x2'], $element['y2'] ), $page );
														//-> Draw
															$content[] = 'S';
														//-> End
															$content[] = 'Q';
													}
												break;
											case 'polyline':
												//-> Operator
													$operator = $this->pdf_path_operator( $element, $element['closed'] );
												//-> Check
													if( $operator !== 'n' ) {
														//-> Start
															$content[] = 'q';
														//-> Stroke
															if( in_array( $operator, array( 'S', 'B' ), true ) ) {
																//-> Linecap
																	switch( $element['stroke_linecap'] ) {
																		case 'round':
																			//-> Linecap
																				$linecap = 1;
																			break;
																		case 'square':
																			//-> Linecap
																				$linecap = 2;
																			break;
																		default:
																			//-> Linecap
																				$linecap = 0;
																			break;
																	}
																//-> Linejoin
																	switch( $element['stroke_linejoin'] ) {
																		case 'round':
																			//-> Linejoin
																				$linejoin = 1;
																			break;
																		case 'bevel':
																			//-> Linejoin
																				$linejoin = 2;
																			break;
																		default:
																			//-> Linejoin
																				$linejoin = 0;
																			break;
																	}
																//-> Style
																	$content[] = $this->pdf_number( $this->pdf_unit( $element['stroke_width'], $page['unit'] ) ) . ' w';
																	$content[] = $linecap . ' J';
																	$content[] = $linejoin . ' j';
																	$content[] = $this->pdf_color( $element['stroke_color'], true );
																//-> Opacity
																	$opacity = $this->pdf_opacity( $element['stroke_color'], true, $opacities );
																//-> Check
																	if( $opacity !== '' ) {
																		//-> Add
																			$content[] = $opacity;
																	}
															}
														//-> Fill
															if( in_array( $operator, array( 'f', 'B' ), true ) ) {
																//-> Color
																	$content[] = $this->pdf_color( $element['fill_color'] );
																//-> Opacity
																	$opacity = $this->pdf_opacity( $element['fill_color'], false, $opacities );
																//-> Check
																	if( $opacity !== '' ) {
																		//-> Add
																			$content[] = $opacity;
																	}
															}
														//-> Path
															$content[] = $this->pdf_path( $element['points'], $page, $element['closed'] );
														//-> Draw
															$content[] = $operator;
														//-> End
															$content[] = 'Q';
													}
												break;
											case 'rectangle':
												//-> Operator
													$operator = $this->pdf_path_operator( $element, true );
												//-> Check
													if( $operator !== 'n' ) {
														//-> Dimensions
															$width  = $this->pdf_unit( $element['width'], $page['unit'] );
															$height = $this->pdf_unit( $element['height'], $page['unit'] );
															$radius = $this->pdf_unit( $element['radius'], $page['unit'] );
														//-> Position
															$left   = $this->pdf_position_x( 0, $width, $element['anchor'] );
															$bottom = $this->pdf_position_y( 0, $height, $element['anchor'], $page );
														//-> Coordinates
															$x = $this->pdf_number( $this->pdf_x( $element['x'], $page ) );
															$y = $this->pdf_number( $this->pdf_y( $element['y'], $page ) );
														//-> Rotation
															if( $page['origin'] !== 'top-left' ) {
																//-> Update
																	$angle = $element['angle'];
															} else {
																//-> Update
																	$angle = -$element['angle'];
															}
														//-> Variables
															$angle   = deg2rad( $angle );
															$cos     = $this->pdf_number( cos( $angle ) );
															$sin     = $this->pdf_number( sin( $angle ) );
															$neg_sin = $this->pdf_number( -sin( $angle ) );
														//-> Start
															$content[] = 'q';
														//-> Transform
															$content[] = implode( ' ', array( $cos, $sin, $neg_sin, $cos, $x, $y, 'cm' ) );
														//-> Stroke
															if( in_array( $operator, array( 'S', 'B' ), true ) ) {
																//-> Linejoin
																	switch( $element['stroke_linejoin'] ) {
																		case 'round':
																			//-> Linejoin
																				$linejoin = 1;
																			break;
																		case 'bevel':
																			//-> Linejoin
																				$linejoin = 2;
																			break;
																		default:
																			//-> Linejoin
																				$linejoin = 0;
																			break;
																	}
																//-> Style
																	$content[] = $this->pdf_number( $this->pdf_unit( $element['stroke_width'], $page['unit'] ) ) . ' w';
																	$content[] = $linejoin . ' j';
																	$content[] = $this->pdf_color( $element['stroke_color'], true );
																//-> Opacity
																	$opacity = $this->pdf_opacity( $element['stroke_color'], true, $opacities );
																//-> Check
																	if( $opacity !== '' ) {
																		//-> Add
																			$content[] = $opacity;
																	}
															}
														//-> Fill
															if( in_array( $operator, array( 'f', 'B' ), true ) ) {
																//-> Color
																	$content[] = $this->pdf_color( $element['fill_color'] );
																//-> Opacity
																	$opacity = $this->pdf_opacity( $element['fill_color'], false, $opacities );
																//-> Check
																	if( $opacity !== '' ) {
																		//-> Add
																			$content[] = $opacity;
																	}
															}
														//-> Rectangle
															if( $radius > 0 ) {
																//-> Bezier
																	$factor = ( 4 / 3 ) * ( sqrt( 2 ) - 1 );
																//-> X
																	$px_1 = $this->pdf_number( $left );
																	$px_2 = $this->pdf_number( $left + $radius * ( 1 - $factor ) );
																	$px_3 = $this->pdf_number( $left + $radius );
																	$px_4 = $this->pdf_number( $left + $width - $radius );
																	$px_5 = $this->pdf_number( $left + $width - $radius * ( 1 - $factor ) );
																	$px_6 = $this->pdf_number( $left + $width );
																//-> Y
																	$py_1 = $this->pdf_number( $bottom );
																	$py_2 = $this->pdf_number( $bottom + $radius * ( 1 - $factor ) );
																	$py_3 = $this->pdf_number( $bottom + $radius );
																	$py_4 = $this->pdf_number( $bottom + $height - $radius );
																	$py_5 = $this->pdf_number( $bottom + $height - $radius * ( 1 - $factor ) );
																	$py_6 = $this->pdf_number( $bottom + $height );
																//-> Bottom
																	$content[] = implode( ' ', array( $px_3, $py_1, 'm' ) );
																	$content[] = implode( ' ', array( $px_4, $py_1, 'l' ) );
																	$content[] = implode( ' ', array( $px_5, $py_1, $px_6, $py_2, $px_6, $py_3, 'c' ) );
																//-> Right
																	$content[] = implode( ' ', array( $px_6, $py_4, 'l' ) );
																	$content[] = implode( ' ', array( $px_6, $py_5, $px_5, $py_6, $px_4, $py_6, 'c' ) );
																//-> Top
																	$content[] = implode( ' ', array( $px_3, $py_6, 'l' ) );
																	$content[] = implode( ' ', array( $px_2, $py_6, $px_1, $py_5, $px_1, $py_4, 'c' ) );
																//-> Left
																	$content[] = implode( ' ', array( $px_1, $py_3, 'l' ) );
																	$content[] = implode( ' ', array( $px_1, $py_2, $px_2, $py_1, $px_3, $py_1, 'c' ) );
																//-> Close
																	$content[] = 'h';
															} else {
																//-> Path
																	$content[] = implode( ' ', array( $this->pdf_number( $left ), $this->pdf_number( $bottom ), $this->pdf_number( $width ), $this->pdf_number( $height ), 're' ) );
															}
														//-> Draw
															$content[] = $operator;
														//-> End
															$content[] = 'Q';
													}
												break;
											case 'circle':
												//-> Operator
													$operator = $this->pdf_path_operator( $element, true );
												//-> Check
													if( $operator !== 'n' ) {
														//-> Start
															$content[] = 'q';
														//-> Stroke
															if( in_array( $operator, array( 'S', 'B' ), true ) ) {
																//-> Style
																	$content[] = $this->pdf_number( $this->pdf_unit( $element['stroke_width'], $page['unit'] ) ) . ' w';
																	$content[] = $this->pdf_color( $element['stroke_color'], true );
																//-> Opacity
																	$opacity = $this->pdf_opacity( $element['stroke_color'], true, $opacities );
																//-> Check
																	if( $opacity !== '' ) {
																		//-> Add
																			$content[] = $opacity;
																	}
															}
														//-> Fill
															if( in_array( $operator, array( 'f', 'B' ), true ) ) {
																//-> Color
																	$content[] = $this->pdf_color( $element['fill_color'] );
																//-> Opacity
																	$opacity = $this->pdf_opacity( $element['fill_color'], false, $opacities );
																//-> Check
																	if( $opacity !== '' ) {
																		//-> Add
																			$content[] = $opacity;
																	}
															}
														//-> Path
															$content[] = $this->pdf_ellipse_arc( $element['x'], $element['y'], $element['radius'], $element['radius'], 0, 360, 0, $page );
														//-> Close
															$content[] = 'h';
														//-> Draw
															$content[] = $operator;
														//-> End
															$content[] = 'Q';
													}
												break;
											case 'ellipse':
												//-> Operator
													$operator = $this->pdf_path_operator( $element, true );
												//-> Check
													if( $operator !== 'n' ) {
														//-> Start
															$content[] = 'q';
														//-> Stroke
															if( in_array( $operator, array( 'S', 'B' ), true ) ) {
																//-> Style
																	$content[] = $this->pdf_number( $this->pdf_unit( $element['stroke_width'], $page['unit'] ) ) . ' w';
																	$content[] = $this->pdf_color( $element['stroke_color'], true );
																//-> Opacity
																	$opacity = $this->pdf_opacity( $element['stroke_color'], true, $opacities );
																//-> Check
																	if( $opacity !== '' ) {
																		//-> Add
																			$content[] = $opacity;
																	}
															}
														//-> Fill
															if( in_array( $operator, array( 'f', 'B' ), true ) ) {
																//-> Color
																	$content[] = $this->pdf_color( $element['fill_color'] );
																//-> Opacity
																	$opacity = $this->pdf_opacity( $element['fill_color'], false, $opacities );
																//-> Check
																	if( $opacity !== '' ) {
																		//-> Add
																			$content[] = $opacity;
																	}
															}
														//-> Path
															$content[] = $this->pdf_ellipse_arc( $element['x'], $element['y'], $element['radius_x'], $element['radius_y'], 0, 360, $element['angle'], $page );
														//-> Close
															$content[] = 'h';
														//-> Draw
															$content[] = $operator;
														//-> End
															$content[] = 'Q';
													}
												break;
											case 'arc':
												//-> Operator
													$operator = $this->pdf_path_operator( $element );
												//-> Check
													if( $operator === 'S' ) {
														//-> Linecap
															switch( $element['stroke_linecap'] ) {
																case 'round':
																	//-> Linecap
																		$linecap = 1;
																	break;
																case 'square':
																	//-> Linecap
																		$linecap = 2;
																	break;
																default:
																	//-> Linecap
																		$linecap = 0;
																	break;
															}
														//-> Start
															$content[] = 'q';
														//-> Stroke
															$content[] = $this->pdf_number( $this->pdf_unit( $element['stroke_width'], $page['unit'] ) ) . ' w';
															$content[] = $linecap . ' J';
															$content[] = $this->pdf_color( $element['stroke_color'], true );
														//-> Opacity
															$opacity = $this->pdf_opacity( $element['stroke_color'], true, $opacities );
														//-> Check
															if( $opacity !== '' ) {
																//-> Add
																	$content[] = $opacity;
															}
														//-> Path
															$content[] = $this->pdf_ellipse_arc( $element['x'], $element['y'], $element['radius'], $element['radius'], $element['start'], $element['sweep'], 0, $page );
														//-> Draw
															$content[] = 'S';
														//-> End
															$content[] = 'Q';
													}
												break;
											case 'ellipse_arc':
												//-> Operator
													$operator = $this->pdf_path_operator( $element );
												//-> Check
													if( $operator === 'S' ) {
														//-> Linecap
															switch( $element['stroke_linecap'] ) {
																case 'round':
																	//-> Linecap
																		$linecap = 1;
																	break;
																case 'square':
																	//-> Linecap
																		$linecap = 2;
																	break;
																default:
																	//-> Linecap
																		$linecap = 0;
																	break;
															}
														//-> Start
															$content[] = 'q';
														//-> Stroke
															$content[] = $this->pdf_number( $this->pdf_unit( $element['stroke_width'], $page['unit'] ) ) . ' w';
															$content[] = $linecap . ' J';
															$content[] = $this->pdf_color( $element['stroke_color'], true );
														//-> Opacity
															$opacity = $this->pdf_opacity( $element['stroke_color'], true, $opacities );
														//-> Check
															if( $opacity !== '' ) {
																//-> Add
																	$content[] = $opacity;
															}
														//-> Path
															$content[] = $this->pdf_ellipse_arc( $element['x'], $element['y'], $element['radius_x'], $element['radius_y'], $element['start'], $element['sweep'], $element['angle'], $page );
														//-> Draw
															$content[] = 'S';
														//-> End
															$content[] = 'Q';
													}
												break;
											case 'image':
												//-> Image
													$image_id = $this->pdf_image( $element['path'], $objects, $images );
												//-> Check
													if( $image_id === null ) {
														//-> Return
															return null;
													}
												//-> Resource
													$image_name = 'Im' . $image_id;
													$image_resources[ $image_name ] = $image_id . ' 0 R';
												//-> Dimensions
													$width  = $this->pdf_unit( $element['width'], $page['unit'] );
													$height = $this->pdf_unit( $element['height'], $page['unit'] );
												//-> Position
													$left   = $this->pdf_position_x( 0, $width, $element['anchor'] );
													$bottom = $this->pdf_position_y( 0, $height, $element['anchor'], $page );
												//-> Coordinates
													$x = $this->pdf_number( $this->pdf_x( $element['x'], $page ) );
													$y = $this->pdf_number( $this->pdf_y( $element['y'], $page ) );
												//-> Rotation
													if( $page['origin'] !== 'top-left' ) {
														//-> Update
															$angle = $element['angle'];
													} else {
														//-> Update
															$angle = -$element['angle'];
													}
												//-> Variables
													$angle   = deg2rad( $angle );
													$cos     = $this->pdf_number( cos( $angle ) );
													$sin     = $this->pdf_number( sin( $angle ) );
													$neg_sin = $this->pdf_number( -sin( $angle ) );
												//-> Start
													$content[] = 'q';
												//-> Transform
													$content[] = implode( ' ', array( $cos, $sin, $neg_sin, $cos, $x, $y, 'cm' ) );
												//-> Size
													$content[] = implode( ' ', array( $this->pdf_number( $width ), 0, 0, $this->pdf_number( $height ), $this->pdf_number( $left ), $this->pdf_number( $bottom ), 'cm' ) );
												//-> Draw
													$content[] = '/' . $image_name . ' Do';
												//-> End
													$content[] = 'Q';
												break;
											case 'text':
												//-> Font
													$font_id = $this->pdf_font( $element['text_font'], $objects, $fonts );
												//-> Check
													if( $font_id === null ) {
														//-> Return
															return null;
													}
												//-> Resource
													$font_name = 'F' . $font_id;
													$font_resources[ $font_name ] = $font_id . ' 0 R';
												//-> Text
													$text = $this->pdf_text( $element['text'], $element['text_font'] );
												//-> Check
													if( $text === null ) {
														//-> Return
															return null;
													}
												//-> Metrics
													$metrics = canvas_ttf::metrics( $element['text_font'], $element['text_size'] );
													$width   = canvas_ttf::width( $element['text_font'], $element['text'], $element['text_size'] );
												//-> Check
													if( !is_array( $metrics ) || !is_numeric( $width ) ) {
														//-> Error
															$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to calculate text dimensions' );
														//-> Return
															return null;
													}
												//-> Dimensions
													$width  = $this->pdf_unit( $width, $page['unit'] );
													$height = $this->pdf_unit( $metrics['height'], $page['unit'] );
													$size   = $this->pdf_number( $this->pdf_unit( $element['text_size'], $page['unit'] ) );
												//-> Position
													$left   = $this->pdf_number( $this->pdf_position_x( 0, $width, $element['anchor'] ) );
													$bottom = $this->pdf_number( $this->pdf_position_y( 0, $height, $element['anchor'], $page ) );
												//-> Coordinates
													$x = $this->pdf_number( $this->pdf_x( $element['x'], $page ) );
													$y = $this->pdf_number( $this->pdf_y( $element['y'], $page ) );
												//-> Rotation
													if( $page['origin'] !== 'top-left' ) {
														//-> Update
															$angle = $element['angle'];
													} else {
														//-> Update
															$angle = -$element['angle'];
													}
												//-> Variables
													$angle   = deg2rad( $angle );
													$cos     = $this->pdf_number( cos( $angle ) );
													$sin     = $this->pdf_number( sin( $angle ) );
													$neg_sin = $this->pdf_number( -sin( $angle ) );
												//-> Start
													$content[] = 'q';
												//-> Color
													$content[] = $this->pdf_color( $element['text_color'] );
												//-> Opacity
													$opacity   = $this->pdf_opacity( $element['text_color'], false, $opacities );
												//-> Check
													if( $opacity !== '' ) {
														//-> Add
															$content[] = $opacity;
													}
												//-> Transform
													$content[] = implode( ' ', array( $cos, $sin, $neg_sin, $cos, $x, $y, 'cm' ) );
												//-> Text
													$content[] = 'BT';
												//-> Font
													$content[] = '/' . $font_name . ' ' . $size . ' Tf';
												//-> Position
													$content[] = implode( ' ', array( 1, 0, 0, 1, $left, $bottom, 'Tm' ) );
												//-> Draw
													$content[] = $text . ' Tj';
												//-> End
													$content[] = 'ET';
													$content[] = 'Q';
												break;
											case 'paragraph':
												//-> Font
													$font_id = $this->pdf_font( $element['text_font'], $objects, $fonts );
												//-> Check
													if( $font_id === null ) {
														//-> Return
															return null;
													}
												//-> Resource
													$font_name = 'F' . $font_id;
													$font_resources[ $font_name ] = $font_id . ' 0 R';
												//-> Metrics
													$metrics = canvas_ttf::metrics( $element['text_font'], $element['text_size'] );
												//-> Check
													if( !is_array( $metrics ) ) {
														//-> Error
															$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to read font metrics' );
														//-> Return
															return null;
													}
												//-> Dimensions
													$width       = $this->pdf_unit( $element['width'], $page['unit'] );
													$height      = $this->pdf_unit( $element['height'], $page['unit'] );
													$cap_height  = $this->pdf_unit( $metrics['height'], $page['unit'] );
													$line_height = $this->pdf_unit( $element['line_height'], $page['unit'] );
													$size        = $this->pdf_number( $this->pdf_unit( $element['text_size'], $page['unit'] ) );
												//-> Anchor
													$left   = $this->pdf_position_x( 0, $width, $element['anchor'] );
													$bottom = $this->pdf_position_y( 0, $height, $element['anchor'], $page );
												//-> Coordinates
													$x = $this->pdf_number( $this->pdf_x( $element['x'], $page ) );
													$y = $this->pdf_number( $this->pdf_y( $element['y'], $page ) );
												//-> Rotation
													if( $page['origin'] !== 'top-left' ) {
														//-> Update
															$angle = $element['angle'];
													} else {
														//-> Update
															$angle = -$element['angle'];
													}
												//-> Variables
													$angle   = deg2rad( $angle );
													$cos     = $this->pdf_number( cos( $angle ) );
													$sin     = $this->pdf_number( sin( $angle ) );
													$neg_sin = $this->pdf_number( -sin( $angle ) );
												//-> Start
													$content[] = 'q';
												//-> Color
													$content[] = $this->pdf_color( $element['text_color'] );
												//-> Opacity
													$opacity = $this->pdf_opacity( $element['text_color'], false, $opacities );
												//-> Check
													if( $opacity !== '' ) {
														//-> Add
															$content[] = $opacity;
													}
												//-> Transform
													$content[] = implode( ' ', array( $cos, $sin, $neg_sin, $cos, $x, $y, 'cm' ) );
												//-> Text
													$content[] = 'BT';
												//-> Font
													$content[] = '/' . $font_name . ' ' . $size . ' Tf';
												//-> Line index
													$line_index = 0;
												//-> Paragraphs
													foreach( $element['paragraphs'] as $paragraph ) {
														//-> Lines
															foreach( $paragraph as $line_number => $line ) {
																//-> Width
																	$line_width = canvas_ttf::width( $element['text_font'], $line, $element['text_size'] );
																//-> Check
																	if( !is_numeric( $line_width ) ) {
																		//-> Error
																			$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unable to calculate paragraph line width' );
																		//-> Return
																			return null;
																	}
																//-> Position
																	$line_x = $left;
																	$line_y = $bottom + $height - $cap_height - ( $line_index * $line_height );
																//-> Align
																	if( $element['align'] === 'center' ) {
																		//-> Update
																			$line_x += 0.5 * ( $width - $this->pdf_unit( $line_width, $page['unit'] ) );
																	}
																	if( $element['align'] === 'right' ) {
																		//-> Update
																			$line_x += $width - $this->pdf_unit( $line_width, $page['unit'] );
																	}
																//-> Position
																	$content[] = implode( ' ', array( 1, 0, 0, 1, $this->pdf_number( $line_x ), $this->pdf_number( $line_y ), 'Tm' ) );
																//-> Draw
																	if(
																		$element['align'] === 'justified' &&
																		$line_number < count( $paragraph ) - 1 &&
																		substr_count( $line, ' ' ) > 0
																	) {
																		//-> Spaces
																			$words   = explode( ' ', $line );
																			$spacing = ( $element['width'] - $line_width ) / ( count( $words ) - 1 );
																			$adjust  = $this->pdf_number( -1000 * $spacing / $element['text_size'] );
																			$parts   = array();
																		//-> Words
																			foreach( $words as $index => $word ) {
																				//-> Space
																					if( $index < count( $words ) - 1 ) {
																						//-> Append
																							$word .= ' ';
																					}
																				//-> Encode
																					$text = $this->pdf_text( $word, $element['text_font'] );
																				//-> Check
																					if( $text === null ) {
																						//-> Return
																							return null;
																					}
																				//-> Add
																					$parts[] = $text;
																				//-> Spacing
																					if( $index < count( $words ) - 1 ) {
																						//-> Add
																							$parts[] = $adjust;
																					}
																			}
																		//-> Draw
																			$content[] = '[ ' . implode( ' ', $parts ) . ' ] TJ';
																	} else {
																		//-> Encode
																			$text = $this->pdf_text( $line, $element['text_font'] );
																		//-> Check
																			if( $text === null ) {
																				//-> Return
																					return null;
																			}
																		//-> Draw
																			$content[] = $text . ' Tj';
																	}
																//-> Next
																	$line_index++;
															}
													}
												//-> End
													$content[] = 'ET';
													$content[] = 'Q';
												break;
											default:
												//-> Error
													$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Unsupported element : ' . var_export( $element['type'], true ) );
												//-> Return
													return null;
										}
									//-> End layer
										$content[] = 'EMC';
									//-> Link
										if( $element['link'] !== null ) {
											//-> Rectangle
												$rectangle = $this->pdf_link_rectangle( $element, $page );
											//-> Check
												if( $rectangle === null ) {
													//-> Return
														return null;
												}
											//-> Object
												$annotation_id = $this->pdf_object( $objects );
											//-> Store
												$page_annotations[] = $annotation_id . ' 0 R';
												$annotations[ $annotation_id ] =
													array(
														'rectangle' => $rectangle,
														'link'      => $element['link'],
														'layer'     => $layer_id
													);
										}
								}
							//-> Stream
								$content_id = $this->pdf_object( $objects, $this->pdf_stream( gzcompress( implode( "\n", $content ) ), '/Filter /FlateDecode' ) );
							//-> Resources
								$resources = array();
							//-> Opacities
								if( count( $opacities ) > 0 ) {
									//-> References
										$opacity_refs = array();
									//-> States
										foreach( $opacities as $name => $dictionary ) {
											//-> Object
												$state_id = $this->pdf_object( $objects, $dictionary );
											//-> Reference
												$opacity_refs[ $name ] = $state_id . ' 0 R';
										}
									//-> Add
										$resources['ExtGState'] = $this->pdf_dictionary( $opacity_refs );
								}
							//-> Images
								if( count( $image_resources ) > 0 ) {
									//-> Update
										$resources['XObject'] = $this->pdf_dictionary( $image_resources );
								}
							//-> Fonts
								if( count( $font_resources ) > 0 ) {
									//-> Update
										$resources['Font'] = $this->pdf_dictionary( $font_resources );
								}
							//-> Layers
								if( count( $layer_resources ) > 0 ) {
									//-> Update
										$resources['Properties'] = $this->pdf_dictionary( $layer_resources );
								}
							//-> Dictionary
								$resources = $this->pdf_dictionary( $resources );
							//-> Page
								$page_entries =
									array(
										'Type'      => '/Page',
										'Parent'    => $pages_id . ' 0 R',
										'MediaBox'  => sprintf( '[0 0 %s %s]', $page_width, $page_height ),
										'Resources' => $resources,
										'Contents'  => $content_id . ' 0 R'
									);
							//-> Annotations
								if( count( $page_annotations ) > 0 ) {
									//-> Update
										$page_entries['Annots'] = '[ ' . implode( ' ', $page_annotations ) . ' ]';
								}
							//-> Dictionary
								$page_data   = $this->pdf_dictionary( $page_entries );
							//-> Object
								$page_id     = $this->pdf_object( $objects, $page_data );
							//-> Reference
								$page_refs[] = $page_id . ' 0 R';
						}
					//-> Pages
						$objects[ $pages_id ] =
							$this->pdf_dictionary(
								array(
									'Type'  => '/Pages',
									'Kids'  => '[ ' . implode( ' ', $page_refs ) . ' ]',
									'Count' => count( $pages )
								)
							);
					//-> Annotations
						foreach( $annotations as $annotation_id => $annotation ) {
							//-> Entries
								$entries =
									array(
										'Type'    => '/Annot',
										'Subtype' => '/Link',
										'Rect'    => $annotation['rectangle'],
										'Border'  => '[ 0 0 0 ]',
										'OC'      => $annotation['layer'] . ' 0 R'
									);
							//-> Destination
								if(
									is_array( $annotation['link'] ) &&
									isset( $annotation['link']['page'] ) &&
									array_key_exists( 'y', $annotation['link'] )
								) {
									//-> Target
										$destination = $this->pdf_destination( $annotation['link']['page'], $annotation['link']['y'], $pages, $page_refs );
									//-> Check
										if( $destination === null ) {
											//-> Return
												return null;
										}
									//-> Add
										$entries['Dest'] = $destination;
								} elseif( is_string( $annotation['link'] ) ) {
									//-> URI
										$uri = $this->pdf_string( $annotation['link'] );
									//-> Check
										if( $uri === null ) {
											//-> Return
												return null;
										}
									//-> Add
										$entries['A'] = '<< /S /URI /URI ' . $uri . ' >>';
								} else {
									//-> Error
										$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid link target' );
									//-> Return
										return null;
								}
							//-> Store
								$objects[ $annotation_id ] = $this->pdf_dictionary( $entries );
						}
					//-> Catalog
						$catalog =
							array(
								'Type'  => '/Catalog',
								'Pages' => $pages_id . ' 0 R'
							);
					//-> Bookmarks
						if( count( $this->bookmarks ) > 0 ) {
							//-> Create
								$outline_id = $this->pdf_bookmarks( $objects, $pages, $page_refs );
							//-> Check
								if( $outline_id === null ) {
									//-> Return
										return null;
								}
							//-> Entries
								$catalog['Outlines'] = $outline_id . ' 0 R';
								$catalog['PageMode'] = '/UseOutlines';
						}
					//-> Layers
						if( count( $layers ) > 0 ) {
							//-> References
								$layer_refs = array();
							//-> Each
								foreach( $layers as $layer_id ) {
									//-> Add
										$layer_refs[] = $layer_id . ' 0 R';
								}
							//-> Array
								$layer_refs = '[ ' . implode( ' ', $layer_refs ) . ' ]';
							//-> Configuration
								$configuration =
									$this->pdf_dictionary(
										array(
											'BaseState' => '/ON',
											'Order'     => $layer_refs
										)
									);
							//-> Properties
								$catalog['OCProperties'] =
									$this->pdf_dictionary(
										array(
											'OCGs' => $layer_refs,
											'D'    => $configuration
										)
									);
							//-> Panel
								if( count( $layers ) > 1 && !isset( $catalog['PageMode'] ) ) {
									//-> Update
										$catalog['PageMode'] = '/UseOC';
								}
						}
					//-> Store
						$objects[ $catalog_id ] = $this->pdf_dictionary( $catalog );
					//-> Metadata
						if( count( $this->metadata ) > 0 ) {
							//-> Entries
								$info = array();
							//-> Metadata
								foreach( $this->metadata as $key => $value ) {
									//-> Add
										$info[ ucfirst( $key ) ] = $this->pdf_string( $value );
								}
							//-> Object
								$info_id = $this->pdf_object( $objects, $this->pdf_dictionary( $info ) );
						}
					//-> Offsets
						$offsets = array();
					//-> Header
						$this->pdf_append( '%PDF-1.5' );
						$this->pdf_append( "%\xE2\xE3\xCF\xD3" );
					//-> Objects
						foreach( $objects as $number => $object ) {
							//-> Check
								if( !is_string( $object ) ) {
									//-> Error
										$this->error( get_class( $this ) . '::' . __FUNCTION__ . '() - Invalid PDF object' );
									//-> Return
										return null;
								}
							//-> Offset
								$offsets[ $number ] = $this->pdf_length;
							//-> Append
								$this->pdf_append( $number . ' 0 obj' );
								$this->pdf_append( $object );
								$this->pdf_append( 'endobj' );
						}
					//-> Cross-reference
						$xref_offset = $this->pdf_length;
					//-> Header
						$this->pdf_append( 'xref' );
						$this->pdf_append( '0 ' . ( count( $objects ) + 1 ) );
						$this->pdf_append( '0000000000 65535 f ' );
					//-> Offsets
						foreach( $offsets as $offset ) {
							//-> Append
								$this->pdf_append( sprintf( '%010d 00000 n ', $offset ) );
						}
					//-> Trailer
						$trailer =
							array(
								'Size' => count( $objects ) + 1,
								'Root' => $catalog_id . ' 0 R'
							);
					//-> Info
						if( $info_id !== null ) {
							//-> Update
								$trailer['Info'] = $info_id . ' 0 R';
						}
					//-> Append
						$this->pdf_append( 'trailer' );
						$this->pdf_append( $this->pdf_dictionary( $trailer ) );
						$this->pdf_append( 'startxref' );
						$this->pdf_append( strval( $xref_offset ) );
						$this->pdf_append( '%%EOF' );
					//-> Return
						return implode( '', $this->pdf );
				}
		}
	//-> Aliases
		if( !class_exists( 'svg', false ) ) {
			//-> Alias
				class_alias( 'canvas_svg', 'svg' );
		}
		if( !class_exists( 'dxf', false ) ) {
			//-> Alias
				class_alias( 'canvas_dxf', 'dxf' );
		}
		if( !class_exists( 'png', false ) ) {
			//-> Alias
				class_alias( 'canvas_png', 'png' );
		}
		if( !class_exists( 'jpg', false ) ) {
			//-> Alias
				class_alias( 'canvas_jpg', 'jpg' );
		}
		if( !class_exists( 'pdf', false ) ) {
			//-> Alias
				class_alias( 'canvas_pdf', 'pdf' );
		}
		
?>