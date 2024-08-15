<?php
// Include Composer's autoload file
require __DIR__ . '/vendor/autoload.php';

// MongoDB connection details
$mongoUrl = "mongodb+srv://ammad:W0yZ62UMibVB0h31@cluster0.an6btrn.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$databaseName = "roofing";
$collectionName = "roofing";

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
        "first_name" => $_POST['first_name'],
        "last_name" => $_POST['last_name'],
        "dob" => $_POST['dob'],
        
        "ownership" => $_POST['ownership'],
        "start_time" => $_POST['start_time'],
        "roof_type" => $_POST['roof_type'],
        "project_nature" => $_POST['project_nature'],
        "property_type" => $_POST['property_type'],
        "address" => $_POST['address'],
        "city" => $_POST['city'],
        "state" => $_POST['state'],
        "zipcode" => $_POST['zipcode'],
        "phone_number" => $_POST['phone_number'],
        "email" => $_POST['email'],
        'universal_leadid' => $_POST['universal_leadid'],
        'trusted_form' => $_POST['xxTrustedFormCertUrl'],
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
