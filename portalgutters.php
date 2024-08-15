<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

require __DIR__ . '/vendor/autoload.php'; // Include Composer's autoload file

// MongoDB connection details
$mongoUrl = "mongodb+srv://ammad:W0yZ62UMibVB0h31@cluster0.an6btrn.mongodb.net/?retryWrites=true&w=majority";
$databaseName = "gutters";
$collectionName = "gutters";

// Connect to MongoDB
try {
    $client = new MongoDB\Client($mongoUrl);
    $db = $client->selectDatabase($databaseName);
    $collection = $db->selectCollection($collectionName);

    // Query MongoDB collection with sorting by _id in descending order
    $cursor = $collection->find([], ['sort' => ['_id' => -1]]);
} catch (MongoDB\Driver\Exception\Exception $e) {
    error_log("Error connecting to MongoDB: " . $e->getMessage());
    echo "Error connecting to MongoDB: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Style for the modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal content */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        header, .footer {
            background-color: #ff69b4; /* Pink color */
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .row-odd {
            background-color: #f9f9f9;
        }
        .row-even {
            background-color: #fff;
        }
    </style>
    <script>
        async function sendData(api, data) {
            try {
                const response = await fetch(api, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                return await response.json();
            } catch (error) {
                throw new Error('Network response was not ok.');
            }
        }

 function handleLinkClick(row, action) {
            selectedRowData = {
                first_name: row.cells[0].innerText,
                last_name: row.cells[1].innerText,
                dob: row.cells[2].innerText,
                ownership: row.cells[3].innerText,
                start_time: row.cells[4].innerText,
                gutter_material: row.cells[5].innerText,
                project_nature: row.cells[6].innerText,
                address: row.cells[7].innerText,
                state: row.cells[9].innerText,
                zipcode: row.cells[10].innerText,
                phone_number: row.cells[11].innerText,
                email: row.cells[12].innerText,
                universal_leadid: row.cells[13].innerText,
                trusted_form: row.cells[14].innerText
            };

            if (action === 'D1') {
                selectedRowData.api_key = 'M12K45T78R7410-M12K45T78R7410M8520D963E789L456';
                selectedRowData.affiliate_id = '1713793761';
                
                selectedRowData.is_test = 1;
               // selectedRowData.landing_page_url: 'thehomeeservices.com';
                //ip_address:
                //user_agent:
                //sub_id:
                selectedRowData.tcpa_compliant = 1;
                selectedRowData.tcpa_text = 'By submitting this request I authorize XYZ, Inc, directly or by third parties acting on its behalf, to send marketing/promotional messages— including texts and calls made using an automatic telephone dialing system.';
                
                // Display a modal or form for entering Ping ID
                document.getElementById('Modal').style.display = 'block';
                document.getElementById('submitPingId').addEventListener('click', function() {
                    let pingId = document.getElementById('pingIdInput').value;
                    selectedRowData.ping_id = pingId;

                    // API endpoint for D1
                    let api = 'https://app.mktremodel.com/api/post/leads';
                    sendData(api, selectedRowData)
                        .then(response => {
                            alert('API Response:\n' + JSON.stringify(response));
                            console.log('Success:', response);
                            document.getElementById('Modal').style.display = 'none';
                        })
                        .catch(error => {
                            alert('Error: ' + error.message);
                            console.error('Error:', error);
                        });
                });
            } else if (action === 'D2') {
                selectedRowData.lead_token = 'differentTokenForD2';
                selectedRowData.traffic_source_id = 20099524;
                selectedRowData.primary_spoken_language = 'Spanish';
                selectedRowData.tcpa_call_consent = true;
                selectedRowData.tcpa_text = 'By submitting this request I authorize XYZ, Inc, directly or by third parties acting on its behalf, to send marketing/promotional messages— including texts and calls made using an automatic telephone dialing system.';
                let api = 'https://app.mktremodel.com/api/post/leads';
                sendData(api, selectedRowData)
                    .then(response => {
                        alert('API Response:\n' + JSON.stringify(response));
                        console.log('Success:', response);
                    })
                    .catch(error => {
                        alert('Error: ' + error.message);
                        console.error('Error:', error);
                    });
            } else if (action === 'D3') {
                selectedRowData.lead_token = 'anotherTokenForD3';
                selectedRowData.traffic_source_id = 30099524;
                selectedRowData.primary_spoken_language = 'French';
                selectedRowData.tcpa_call_consent = true;
                selectedRowData.tcpa_text = 'By submitting this request I authorize ABC, Inc, directly or by third parties acting on its behalf, to send marketing/promotional messages— including texts and calls made using an automatic telephone dialing system.';
                let api = 'https://app.mktremodel.com/api/post';
                sendData(api, selectedRowData)
                    .then(response => {
                        alert('API Response:\n' + JSON.stringify(response));
                        console.log('Success:', response);
                    })
                    .catch(error => {
                        alert('Error: ' + error.message);
                        console.error('Error:', error);
                    });
            }
        }



        function handleLinkClick1(row, action) {
            let selectedRowData = {
                api_key: 'M12K45T78R7410-M12K45T78R7410M8520D963E789L456',
                affiliate_id: '1713793761',
                is_test: 1,
                state: row.cells[9].innerText,
                zipcode: row.cells[10].innerText,
                landing_page_url: 'thehomeeservices.com',
                user_agent: navigator.userAgent,
                universal_leadid: row.cells[13].innerText,
                //trusted_form: row.cells[14].innerText,
                //tcpa_compliant = 1;
                //tcpa_text = 'By submitting this request I authorize XYZ, Inc, directly or by third parties acting on its behalf, to send marketing/promotional messages— including texts and calls made using an automatic telephone dialing system.';
                //sub-id:
                ownership: row.cells[3].innerText,
                start_time: row.cells[4].innerText,
                gutter_material: row.cells[5].innerText,
                project_nature: row.cells[6].innerText,

            };

            console.log('Data to be sent:', selectedRowData);

            let api = 'https://app.mktremodel.com/api/ping/leads';

            sendData(api, selectedRowData)
                .then(response => {
                    alert('API Response:\n' + JSON.stringify(response));
                    console.log('Success:', response);
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                    console.error('Error:', error);
                });
        }
        function handleLinkClick2(row, action) {
            let selectedRowData = {
                api_key: 'M12K45T78R7410-M12K45T78R7410M8520D963E789L456',
                affiliate_id: '1713793761',
                is_test: 1,
                state: row.cells[9].innerText,
                zipcode: row.cells[10].innerText,
                landing_page_url: 'thehomeeservices.com',
                user_agent: navigator.userAgent,
                universal_leadid: row.cells[13].innerText,
                //trusted_form: row.cells[14].innerText,
                //tcpa_compliant = 1;
                //tcpa_text = 'By submitting this request I authorize XYZ, Inc, directly or by third parties acting on its behalf, to send marketing/promotional messages— including texts and calls made using an automatic telephone dialing system.';
                //sub-id:
                ownership: row.cells[3].innerText,
                start_time: row.cells[4].innerText,
                gutter_material: row.cells[5].innerText,
                project_nature: row.cells[6].innerText,

            };

            console.log('Data to be sent:', selectedRowData);

            let api = 'https://app.mktremodel.com/api/ping/leads';

            sendData(api, selectedRowData)
                .then(response => {
                    alert('API Response 222:\n' + JSON.stringify(response));
                    console.log('Success222:', response);
                })
                .catch(error => {
                    alert('Error2: ' + error.message);
                    console.error('Error2:', error);
                });
        }
    </script>
</head>
<body>
    <header>
        <h1>Portal Data</h1>
    </header>
    <div class="container mt-5">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>DOB</th>
                    <th>Ownership</th>
                    <th>Start Time</th>
                    <th>Gutter Material</th>
                    <th>Project Nature</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zipcode</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>jornaya_leadid</th>
                    <th>Trusted Form</th>
                    <th>Ping</th>
                    <th>D1</th>
                    <th>D2</th>
                    <th>D3</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rowIndex = 0;
                foreach ($cursor as $document) {
                    $rowClass = ($rowIndex % 2 === 0) ? 'row-even' : 'row-odd';
                    echo "<tr class='$rowClass'>";
                    echo "<td>" . htmlspecialchars($document['first_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['dob']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['ownership']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['start_time']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['gutter_material']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['project_nature']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['address']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['city']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['state']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['zipcode']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['phone_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['universal_leadid']) . "</td>";
                    echo "<td>" . htmlspecialchars($document['trusted_form']) . "</td>";
                    
                    echo "<td><a href='#' onclick=\"handleLinkClick1(this.parentNode.parentNode, 'Ping')\">Ping_D1</a></td>";
                    echo "<td><a href='#' onclick=\"handleLinkClick(this.parentNode.parentNode, 'D1')\">D1</a></td>";
                    // echo "<td>
                    //      <a href='#' onclick=\"handleLinkClick(this.parentNode.parentNode, 'D2')\">D2</a> |
                    //      <a href='#' onclick=\"handleLinkClick2(this.parentNode.parentNode, 'D3')\">Pind_D2</a>
                    //       </td>";

                    echo "<td><a href='#' onclick=\"handleLinkClick(this.parentNode.parentNode, 'D2')\">D2</a></td>";
                    //echo "<td><a href='#' onclick=\"handleLinkClick2(this.parentNode.parentNode, 'D3')\">Pind_D2</a></td>";
                    echo "<td><a href='#' onclick=\"handleLinkClick(this.parentNode.parentNode, 'D3')\">D3</a></td>";
                    
                    
                    echo "</td>";
                    
                    $rowIndex++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for D1 action -->
    <div id="Modal" class="modal">
        <div class="modal-content" style="width: 300px; margin: 15% auto; padding: 20px; border: 1px solid #888;">
            <span class="close" onclick="document.getElementById('Modal').style.display = 'none';">&times;</span>
            <label for="pingIdInput">Enter Ping ID:</label>
            <input type="text" id="pingIdInput" name="pingIdInput" class="form-control">
            <button id="submitPingId" class="btn btn-primary mt-2">Submit</button>
        </div>
    </div>
</body>
</html>
