<?php

/*
         * Gets the jpeg contents of the resized version of an already uploaded image
         * (Returns false if the uploaded file was not an image)
         *
         * @param string $input_name The name of the file input field on the submission form
		 * @param string $prefix The text to prefix to the existing filename
         * @param int $maxwidth The maximum width of the resized image
         * @param int $maxheight The maximum height of the resized image
         * @param true|false $square If set to true, will take the smallest of maxwidth and maxheight and use it to set the dimensions on all size; the image will be cropped.
         * @return false|mixed The contents of the resized image, or false on failure
         */
        function tp_resize($input_name, $prefix, $maxwidth, $maxheight, $square = false, $x1 = 0, $y1 = 0, $x2 = 0, $y2 = 0) {
				$params = array(
					"input_name"=>$input_name,
					"output_name"=>$output_name,
					"maxwidth"=>$maxwidth,
					"maxheight"=>$maxheight,
					"square"=>$square,
					"x1"=>$x1,
					"y1"=>$y1,
					"x2"=>$x2,
					"y2"=>$y2);
				
				$path = pathinfo($input_name);
				$output_name = $path["dirname"] . "/$prefix" . $path["filename"] . "." . $path["extension"];
				
                // Get the size information from the image
                if ($imgsizearray = getimagesize($input_name)) {

                        // Get width and height
                        $width = $imgsizearray[0];
                        $height = $imgsizearray[1];
                        $newwidth = $width;
                        $newheight = $height;
                        
                        // Square the image dimensions if we're wanting a square image
                        if ($square) {
                                if ($width < $height) {
                                        $height = $width;
                                } else {
                                        $width = $height;
                                }
                                
                                $newwidth = $width;
                                $newheight = $height;
                                
                        }

                        if ($width > $maxwidth) {
                                $newheight = floor($height * ($maxwidth / $width));
                                $newwidth = $maxwidth;
                        }
                        if ($newheight > $maxheight) {
                                $newwidth = floor($newwidth * ($maxheight / $newheight));
                                $newheight = $maxheight;
                        }

                        $accepted_formats = array(
                                                                                        'image/jpeg' => 'jpeg',
                                                                                        'image/png' => 'png',
                                                                                        'image/gif' => 'gif'
                                                                        );
                        // If it's a file we can manipulate ...
                        if (array_key_exists($imgsizearray['mime'],$accepted_formats)) {

                            // Crop the image if we need a square
                            if ($square) {
                                    if ($x1 == 0 && $y1 == 0 && $x2 == 0 && $y2 ==0) {
                                            $widthoffset = floor(($imgsizearray[0] - $width) / 2);
                                            $heightoffset = floor(($imgsizearray[1] - $height) / 2);
                                    } else {
                                            $widthoffset = $x1;
                                            $heightoffset = $y1;
                                            $width = ($x2 - $x1);
                                            $height = $width;
                                    }
                            } else {
                                    if ($x1 == 0 && $y1 == 0 && $x2 == 0 && $y2 ==0) {
                                            $widthoffset = 0;
                                            $heightoffset = 0;
                                    } else {
                                            $widthoffset = $x1;
                                            $heightoffset = $y1;
                                            $width = ($x2 - $x1);
                                            $height = ($y2 - $y1);
                                    }
                            }
                            
                            // Resize and return the image contents!
                            if ($square) {
                                    $newheight = $maxheight;
                                    $newwidth = $maxwidth;
                            }
							$command = "convert $input_name -resize ".$newwidth."x".$newheight."^ -gravity center -extent ".$newwidth."x".$newheight." $output_name";
							system($command);
							return $output_name;

                        }
                }

                return false;
        }

?>
