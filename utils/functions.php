<?php

function uploadFile($file, $type){
   $file_name = $file['name'];
   $file_type = $file['type'];
   $tmp_name = $file['tmp_name'];

   if(!$file['error']){
      if ($type === 'image') {
         $file_explode = explode('.',$file_name);
         $file_ext = end($file_explode);
      
         $extensions = ["jpeg", "png", "jpg"];
      
         if(in_array($file_ext, $extensions) === true){
            $types = ["image/jpeg", "image/jpg", "image/png"];
            if(in_array($file_type, $types) === true){
               $d = new DateTime();
               $time = $d->format("YmdHisv");
               $new_file_name = uniqid().".$file_ext";
               if(move_uploaded_file($tmp_name,"../../uploads/images/" . $new_file_name)){
                  return "/uploads/images/" . $new_file_name;
               }
            }
         }
      }
   }



   return false;
}

?>