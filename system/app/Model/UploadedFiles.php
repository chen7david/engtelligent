<?php
namespace Core\Model;
use Illuminate\Database\Eloquent\Model;
use Slim\Http\UploadedFile;
use Core\Model\Hash;

/**
* 
**/
class UploadedFiles extends Model 
{

	protected $fileNameLength = 10,
			  $fileName,
			  $uploadedFiles,
			  $errorMessage,
			  $fileSize,
			  $mediaType,
			  $error;

	public function getFiles($request, $key){

		$uploadedFiles = $request->getUploadedFiles();

		if (!array_key_exists($key, $uploadedFiles)) {
			$this->error = true;
			$this->errorMessage = "The index ".$key." could not be found";
			return $this;
		}

		$this->uploadedFiles = $uploadedFiles[$key];
		$this->fileSize = $this->uploadedFiles->getSize();
		$this->mediaType = $this->uploadedFiles->getClientMediaType();

	    return $this;
	}

	public function getFileName(){
		return $this->fileName;
	}

	public function getFileSize(){
		return $this->fileSize;
	}

	public function getMediaType(){
		return $this->mediaType;
	}

	public function getExtension(){
		return explode('/', $this->mediaType)[1];
	}

	public function setFileNameLength(int $length){
		return $this->fileNameLength = $length;
	}

	public function hasError(){
		return $this->error;
	}

	public function getErrorMessage(){
		return $this->errorMessage;
	}

	public function moveToDir($dir){
		$path = makedir($dir);
		$uploadedFiles = $this->uploadedFiles;

		if (!$uploadedFiles->getError() === UPLOAD_ERR_OK) {
			$this->error = true;
			$this->errorMessage = "An error offucered during the upload.";
			return $this;
	    }

	    $extension = pathinfo($uploadedFiles->getClientFilename(), PATHINFO_EXTENSION);
	    $this->fileName = Hash::render($this->fileNameLength).'.'.$extension;
	    $uploadedFiles->moveTo($path . DIRECTORY_SEPARATOR . $this->fileName); 

	    return $this;
	}

}