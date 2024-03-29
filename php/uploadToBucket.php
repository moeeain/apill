<?php
include './apillon.php';

// Directory containing the files to be uploaded
$dirPath = '../files';

// Define a virtual path in apillon or leave it empty.
$folderName = '';

// It will define directoryPath in the end upload session to wrap file with directory.
// If you don't want to wrap with directory leave it empty
$wrappedDirectory = 'dirr';

// It will return true or false to endUploadSession depending on whether the directoryPath is set.
$wrapWithDirectory = !empty($wrappedDirectory);

// Read all files from the directory
$files = array_diff(scandir($dirPath), array('.', '..'));

$uploadData = [];

foreach ($files as $file) {
    // Full path to the file
    $filePath = $dirPath . '/' . $file;

    // Check if it's a file and not a directory
    if (is_file($filePath)) {
        // Get MIME type of the file
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($filePath);

        $uploadData[] = [
            'fileName' => $file,
            'contentType' => $mimeType,
            'filePath' => $filePath
        ];
    }
}

if (!empty($uploadData)) {
    $response = uploadToBucket($uploadData, $folderName);
    print_r($response);
    // Handle response and complete upload session if needed
}
