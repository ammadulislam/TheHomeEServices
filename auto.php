<?php
// Include Composer's autoload file
require __DIR__ . '/vendor/autoload.php';

// MongoDB connection details
$mongoUrl = "mongodb+srv://ammad:W0yZ62UMibVB0h31@cluster0.an6btrn.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$databaseName = "auto";
$collectionName = "auto";

// Function to get the user's IP address
function getUserIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // IP from shared internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IP passed from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // IP address from remote address
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// Connect to MongoDB
try {
    $client = new MongoDB\Client($mongoUrl);
    $collection = $client->$databaseName->$collectionName;
} catch (Exception $e) {
    die("Error connecting to MongoDB: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $formData = [
        "first_name" => $_POST['fname'],
        "last_name" => $_POST['lname'],
        "dob" => $_POST['dob'],
        "gender" => $_POST['gender'],
        "make" => $_POST['make'],
        "model" => $_POST['model'],
        "year" => $_POST['year'],
        "address1" => $_POST['address'],
        "city" => $_POST['city'],
        "state" => $_POST['state'],
        "zip" => $_POST['zipCode'],
        "caller_id" => $_POST['phoneNo'],
        "email" => $_POST['email'],
        'jornaya_leadid' => $_POST['universal_leadid'],
        'xxTrustedFormCertUrl' => $_POST['xxTrustedFormCertUrl'],
        "timestamp" => new MongoDB\BSON\UTCDateTime(),
        // "ipAddress" => getUserIpAddr()  // Include the user's IP address
    ];

    // Insert form data into MongoDB
    try {
        $result = $collection->insertOne($formData);
        if ($result->getInsertedCount() == 1) {
            echo "Data successfully saved to MongoDB.";
        } else {
            echo "Failed to save data.";
        }
    } catch (Exception $e) {
        die("Error inserting data into MongoDB: " . $e->getMessage());
    }
}
?>
