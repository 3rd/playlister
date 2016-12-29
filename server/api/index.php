<?php
// Config
$data_dir = '../data/';
$hash_salt = ':happy-hippo';
$access_control_allow_all = true;

// Headers
header('Content-Type: application/json; Charset=utf-8');
if ($access_control_allow_all) {
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: Content-Type');
}

// POST: Create a new playlist
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $input = json_decode(file_get_contents('php://input'), true);
  // Build playlist object
  $playlist = array();
  $playlist['title'] = $input['title'];
  $playlist['videos'] = array();
  foreach ($input['videos'] as $inputVideo) {
    $video = array();
    $video['title'] = $inputVideo['title'];
    $video['id'] = preg_replace("/[^[:alnum:][:space:]]/u", '', $inputVideo['id']);
    array_push($playlist['videos'], $video);
  }
  $hash = md5(random_bytes(256) . $hash_salt);
  $output = json_encode($playlist);
  $output_path = $data_dir . $hash . '.json';
  file_put_contents($output_path, $output);
  $response = array();
  $response['error'] = false;
  $response['hash'] = $hash;
  echo json_encode($response);
}

// GET: Retrieve a playlist
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Check for "hash" parameter in query
  if (!isset($_GET['hash'])) {
    error('Playlist hash was not provided.');
  }
  // Strip all non-alphanumeric characters
  $playlist_hash = preg_replace("/[^A-Za-z0-9]/", "", $_GET['hash']);
  // Check hash length
  if (strlen($playlist_hash) !== 32) {
    error('Playlist hash was not provided.');
  }
  // Check if we have a playlist with this hash
  if (!file_exists($data_dir . $playlist_hash . '.json')) {
    error('Playlist could not be found.');
  } else {
    // Read playlist data
    $playlist = json_decode(file_get_contents($data_dir . $playlist_hash . '.json'));
    // Pipe it out
    respond($playlist);
  }
}

// Utils
function error ($message) {
  $response = array();
  $response['error'] = true;
  $response['message'] = $message;
  respond($response);
  exit();
}
function respond ($response) {
  $json = json_encode($response);
  if (isset($_GET['callback'])) {
    echo $_GET['callback'] . '(' . $json . ')';
  } else {
    echo $json;
  }
}

?>