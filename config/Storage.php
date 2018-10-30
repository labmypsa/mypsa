<?php
class Storage{
	
	public static function upload($disk,$file){
		move_uploaded_file($file['tmp_name'], 'storage/'.$disk.'/'. $file['name']);
	}
	public static function upload_image($disk, $newWidth, $targetFile, $originalFile){
			$targetFile = 'storage/'.$disk.'/'. $targetFile;
	        $info = getimagesize($originalFile);
		    $mime = $info['mime'];

		    switch ($mime) {
		        case 'image/jpeg':
		            $image_create_func = 'imagecreatefromjpeg';
		            $image_save_func = 'imagejpeg';
		            $new_image_ext = 'jpg';
		            break;

		        case 'image/png':
		            $image_create_func = 'imagecreatefrompng';
		            $image_save_func = 'imagepng';
		            $new_image_ext = 'png';
		            break;

		        case 'image/gif':
		            $image_create_func = 'imagecreatefromgif';
		            $image_save_func = 'imagegif';
		            $new_image_ext = 'gif';
		            break;

		        default:
		            throw new Exception('Unknown image type.');
		    }
	        
		    $img = $image_create_func($originalFile);
		    list($width, $height) = getimagesize($originalFile);
		    $newHeight = ($height / $width) * $newWidth;
		    $tmp = imagecreatetruecolor($newWidth, $newHeight);
		   

		    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

		    if (file_exists($targetFile)) {
		        unlink($targetFile);
		    }
		    $image_save_func($tmp, "$targetFile");
	}
	public static function delete($disk, $file){
		unlink('storage/'.$disk.'/'. $file);
	}
	public static function validate($file,$rules){
		$isValid = true;
	    $original_extension = strtolower(pathinfo(basename($file["name"]), PATHINFO_EXTENSION));
	    $size = $file["size"];
	    $file['extension'] = $original_extension;
	    $file['timestamp'] = (new DateTime)->getTimestamp();
	    $file['timestamp_ext'] = $file['timestamp'] . '.' .  $file['extension'];

	    foreach ($rules as $rule => $value) {
	    	switch ($rule) {
	    		case 'timestamp':
	    			if($value){
	    				$file['name'] = $file['timestamp_ext'];
	    			} break;
	    		case 'max-size':
	    			if($size > $value*1000){
	    				return false;
	    			} break;
	    		case 'allow_extension':
	    			foreach ($value as $extension) {
	    				if ($original_extension == strtolower($extension)) {
	    					$isValid = true;
	    					break;
	    				} else{
	    					$isValid = false;
	    				}
	    			}
	    			break;
	    	}
	    }
	    return ($isValid == true) ? $file : false;
	}
}