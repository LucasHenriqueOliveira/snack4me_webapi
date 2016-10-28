<?php

namespace App;

 

class TratarImagem
{
	
	
	
	public function save_base64_image($base64_image_string, $output_file_without_extentnion, $path_with_end_slash="" ) {
		//usage:  if( substr( $img_src, 0, 5 ) === "data:" ) {  $filename=save_base64_image($base64_image_string, $output_file_without_extentnion, getcwd() . "/application/assets/pins/$user_id/"); }
		//
		//data is like:    data:image/png;base64,asdfasdfasdf
		$splited = explode(',', substr( $base64_image_string , 5 ) , 2);
		$mime=$splited[0];
		$data=$splited[1];
		
		$mime_split_without_base64=explode(';', $mime,2);
		$mime_split=explode('/', $mime_split_without_base64[0],2);
		if(count($mime_split)==2)
		{
			$extension=$mime_split[1];
			if($extension=='jpeg')$extension='jpg';
			else if($extension=='png')$extension='png';
			//if($extension=='text')$extension='txt';
			$output_file_with_extention = $output_file_without_extentnion.'.'.$extension;
		}
		file_put_contents( $path_with_end_slash . $output_file_with_extention, base64_decode($data) );
		return $output_file_with_extention;
	}
	
	
	public function confimarPastas($company){
		
		try {
			$this->createDirectory("../../events");
			$this->createDirectory("../../events/$company");
			$this->createDirectory("../../events/$company/products");
			$this->createDirectory("../../events/$company/products/originals");
			$this->createDirectory("../../events/$company/products/full");
			$this->createDirectory("../../events/$company/products/thumb");
		}catch (Execution $e){
			throw new Exeception("Erro ao criar pastas");
			
		}
		
	}
	
	public function createDirectory($path){
		
		if (is_dir($path)) {
			return true;
		}
		try {
			mkdir($path);
		} catch (Exception $e) {
			$this->error('There was an error creating the new directory:', $e);
			return false;
		}
		return true;
	}
	
	 
	public function compressImage($source_path, $destination_path, $quality){
		
		$info = getimagesize($source_path);
		$quality=85;
		
		if ($info['mime'] == 'image/jpeg') {
			$image = imagecreatefromjpeg($source_path);
		} elseif ($info['mime'] == 'image/png') {
			$quality = 8;
			$image = imagecreatefrompng($source_path);
		}
		
		imagejpeg($image, $destination_path, $quality);
		return $destination_path;
	}
	
}

