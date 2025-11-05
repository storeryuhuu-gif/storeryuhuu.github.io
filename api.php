<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// File to store website data
$dataFile = 'website_data.json';

// Default data structure
$defaultData = [
    'storeName' => 'Ryuhuu Store',
    'heroTitle' => 'Premium Gaming & Tech Services',
    'heroDesc' => 'Professional game top-up, boosting services, and expert technical solutions for all your digital needs.',
    'services' => [
        [
            'title' => 'Game Top-Up',
            'description' => 'Fast and reliable top-up services for Mobile Legends, PUBG Mobile, Free Fire, Genshin Impact, and more. Competitive prices with instant delivery.'
        ],
        [
            'title' => 'Game Boosting',
            'description' => 'Professional rank boosting and account leveling services. Expert players to help you reach your desired rank safely and efficiently.'
        ],
        [
            'title' => 'Coding Services',
            'description' => 'Custom software development, website creation, bug fixes, and technical consultations. Professional solutions for all your coding needs.'
        ],
        [
            'title' => 'Remote Control Services',
            'description' => 'Professional remote technical support for troubleshooting, installations, and system maintenance. Quick and reliable assistance.'
        ]
    ],
    'contact' => [
        'whatsapp' => '+62 xxx-xxxx-xxxx',
        'email' => 'contact@ryuhuustore.com',
        'discord' => 'Ryuhuu#0000',
        'telegram' => '@RyuhuuStore'
    ],
    'paymentInfo' => 'Please complete your payment via PayPal. After payment is completed, contact us using the information above to confirm your order and receive your service.',
    'adminPassword' => 'admin123'
];

// Initialize data file if it doesn't exist
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode($defaultData, JSON_PRETTY_PRINT));
}

// Get action from query parameter
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'get':
        // Read and return data
        $data = json_decode(file_get_contents($dataFile), true);
        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
        break;

    case 'save':
        // Save data from POST request
        $input = file_get_contents('php://input');
        $newData = json_decode($input, true);

        if ($newData) {
            // Save to file
            $result = file_put_contents($dataFile, json_encode($newData, JSON_PRETTY_PRINT));

            if ($result !== false) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Data saved successfully'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to save data'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid data format'
            ]);
        }
        break;

    default:
        echo json_encode([
            'success' => false,
            'message' => 'Invalid action'
        ]);
        break;
}
?>