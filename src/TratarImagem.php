<?php

namespace App;


use \App\ImageCache as ImageCache;
 

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
	
	
	/**
	 * @param $pastaOriginal
	 * @param $image
	 * @param $nomePastaSalvar
	 * @@var  recebe o local atual do arquivo e onde deve salvar o arquivo após a compactacao
	 */
	public function salvaFotosCompactadas($pastaOriginal, $image, $nomePastaSalvar){
		
		
		$imagecache = new ImageCache();
		$imagecache->cached_image_directory = $pastaOriginal.$nomePastaSalvar;
		$imagecache->cache($pastaOriginal . '/originals/'.$image);
		$imagecache->check_link_cached = false;
		return $imagecache->cached_filename;
	}
	
}

