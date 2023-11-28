<?php
$srm = $_SERVER['REQUEST_METHOD'];

function guidv4($data = null)
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function exit_info($str, $rc)
{
    $val = ["txt" => $str, "rc" => $rc, "uuid" => guidv4()];
    $jval = json_encode($val);
    print($jval);
    error_log($jval);
};

header('Content-Type: application/json; charset=utf-8');

if ($srm == "GET") {
    if (isset($_GET["uuid"])) {
        $uuid = $_GET["uuid"];
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            exit_info("wrong format of uuid", -1);
        } else {
            // get from file or db
            $fn = "/www-data/" . $uuid;
            if (is_file($fn)) {
                $fc = file_get_contents($fn);
                $jval = json_decode($fc, false);
                print(json_encode($jval, JSON_PRETTY_PRINT));
            } else {
                exit_info("data record not found", -5);
            }
        }
    } else {
        print(json_encode($_GET, JSON_PRETTY_PRINT));
        exit_info("GET: missing uuid query parameter", -2);
    }
} elseif ($srm == "POST") {
    if (isset($_GET["uuid"])) {
        $uuid = $_GET["uuid"];
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            exit_info("wrong format of uuid", -1);
        } else {
            // get from file or db
            $fn = "/www-data/" . $uuid;
            $jstr = file_get_contents('php://input');
            $jval = json_decode($jstr, false);
            $jval_str = json_encode($jval, JSON_PRETTY_PRINT);
            file_put_contents($fn, $jval_str);
            exit_info("POST: saved as uuid : " . $uuid, 0);
        }
    } else {
        exit_info("POST: missing uuid query parameter", -3);
    }
} else {
    exit_info("Invalid method : " . $srm, -4);
};
