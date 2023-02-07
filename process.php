<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

/* if (!isset($_FILES["fileToUpload"])) {
  http_response_code(400);
  exit;
} */

$response = array(
  "success" => false,
  "errors" => [],
  "message" => "Unexpected error",
);

$fileCheckErrors = array();
$okToUpload = true;

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = mime_content_type($_FILES["fileToUpload"]["tmp_name"]);

// Validate file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
  $fileCheckErrors[] = "File size exceeds limit: 50MB";
  $okToUpload = false;
}

// Validate file type
$validFileTypes = [
  "application/vnd.ms-excel",
  "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  "application/vnd.openxmlformats-officedocument.spreadsheetml.sharedstrings+xml"
];
if (!in_array($fileType, $validFileTypes)) {
  $fileCheckErrors[] = "Invalid file format. Only 'xls' and 'xlsx' files allowed";
  $okToUpload = false;
}

if (!$okToUpload) {
  $response = array(
    "success" => false,
    "errors" => $fileCheckErrors,
    "message" => "File does not meet requirements",
  );
  exit(json_encode($response));
}

if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
  $fileCheckErrors[] = "Unexpected file upload error";
}

if (sizeof($fileCheckErrors) > 0) {
  $response = array(
    "success" => false,
    "errors" => $fileCheckErrors,
    "message" => "Failed to move file",
  );
  exit(json_encode($response));
}

// All correct upload and process file
$response = array(
  "success" => true,
  "errors" => $fileCheckErrors,
  "message" => "File upload successful",
);
exit(json_encode($response));
