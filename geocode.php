<?php
$servername = "134.173.43.8";
$username = "clinic";
$password = "trickypassword";
$dbname = "queries";

$data = file_get_contents("php://input");
$urlDecoded = urldecode($data);
$geocodeInfo = json_decode($urlDecoded);
switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            echo ' - Unknown error';
        break;
    }

   print_r($geocodeInfo);
   // print $geocodeInfo->{"queryAddress"};

 $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sqlFront = "INSERT INTO geocodes (queryAddress, formattedAddress, lat, lng, hasBounds, NEBoundLat, NEBoundLng, SWBoundLat, SWBoundLng, foundGeocode) VALUES (";

$sqlBack = ")";

$sqlText = $sqlFront . "'" . $geocodeInfo->{"queryAddress"} . "'" . "," . "'" . $geocodeInfo->{"formattedAddress"} . "'" . "," . "'" . $geocodeInfo->{"lat"} . "'" . "," . "'" . $geocodeInfo->{"lng"} . "'" . "," . "'" . $geocodeInfo->{"hasBounds"} . "'" . "," . "'" . $geocodeInfo->{"NEBoundLat"} . "'" . "," . "'" . $geocodeInfo->{"NEBoundLng"} . "'" . "," . "'" . $geocodeInfo->{"SWBoundLat"} . "'" . "," . "'" . $geocodeInfo->{"SWBoundLng"} . "'" . "," . "'" . $geocodeInfo->{"foundGeocode"} . "'" . $sqlBack;

print $sqlText;
if (mysqli_query($conn, $sqlText)) {
	echo "New record created successfully";
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$conn->close();
?>