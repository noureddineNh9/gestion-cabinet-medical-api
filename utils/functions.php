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
      } else if ($type === "compteRendu") {
         $file_explode = explode('.',$file_name);
         $file_ext = end($file_explode);
      
         $extensions = ["pdf", "doc", "docx", "txt"];
      
         if(in_array($file_ext, $extensions) === true){
            $types = ["application/pdf", "image/jpg", "image/png"];
   
            $d = new DateTime();
            $new_file_name = uniqid().".$file_ext";
            
            if(move_uploaded_file($tmp_name,"../../uploads/compteRendu/" . $new_file_name)){
               return "/uploads/compteRendu/" . $new_file_name;
            }
         }
      } else if ($type === "audio") {
         $file_explode = explode('.',$file_name);
         $file_ext = end($file_explode);
      
         $extensions = ["mp3"];
      
         if(in_array($file_ext, $extensions) === true){   
            $new_file_name = uniqid().".$file_ext";
            
            if(move_uploaded_file($tmp_name,"../../uploads/audio/" . $new_file_name)){
               return "/uploads/audio/" . $new_file_name;
            }
         }
      } else if ($type === "document") {
         $file_explode = explode('.',$file_name);
         $file_ext = end($file_explode);
      
         $extensions = ["pdf", "doc", "docx", "txt", "jpeg", "png", "jpg"];
      
         if(in_array($file_ext, $extensions) === true){   
            $new_file_name = uniqid().".$file_ext";
            
            if(move_uploaded_file($tmp_name,"../../uploads/compteRendu/" . $new_file_name)){
               return "/uploads/compteRendu/" . $new_file_name;
            }
         }
      }
   
   }


   return false;
}

function restructureFilesArray($files)
{
    $output = [];
    foreach ($files as $attrName => $valuesArray) {
        foreach ($valuesArray as $key => $value) {
            $output[$key][$attrName] = $value;
        }
    }
    return $output;
}