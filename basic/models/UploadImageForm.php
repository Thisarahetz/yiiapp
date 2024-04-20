<?php
    namespace app\models;
    use yii\base\Model;

    class UploadImageForm extends Model {
        public $image;
        public function rules() {
            return [
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg, png'],
            ];
        }
        // This method is used to save the uploaded image to the server
        public function upload() {
            if ($this->validate()) {
                $uploadDir = '../uploads/';
                
                // Create the directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // You can adjust the permissions as needed
                }
                
                $targetFile = $uploadDir . $this->image->baseName . '.' . $this->image->extension;
        
                // Use copy instead of move_uploaded_file if needed
                $success = $this->image->saveAs($targetFile);
        
                if ($success) {
                    return true;
                } else {
                    // Handle the case when the file cannot be saved
                    return false;
                }
            } else {
                return false;
            }
        }
        
    }
?>