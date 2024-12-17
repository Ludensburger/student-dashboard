<?php
// FILE: api/crud.php
require_once 'config/db.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathSegments = explode('/', trim($path, '/'));
$slug = isset($pathSegments[3]) ? $pathSegments[3] : "";

$request_method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : "";
$id = isset($_GET['id']) ? $_GET['id'] : "";

// get all data
if ($request_method === 'GET' && $slug && !$id) {
    $data = $databaseDump[$slug];
    echo json_encode($data);
}

// get data by id
if ($request_method === 'GET' && $slug && $id) {
    $data = $databaseDump[$slug];
    $result = null;

    switch ($slug) {
        case 'students':
            foreach($data as $key => $value) {
                if (is_array($value) && array_key_exists('studid', $value) && $value['studid'] == $id) {
                    $result = $value;
                    break;
                }
            }
            break;
        case 'programs':
            foreach($data as $key => $value) {
                if (is_array($value) && array_key_exists('progid', $value) && $value['progid'] == $id) {
                    $result = $value;
                    break;
                }
            }
            break;
        case 'colleges':
            foreach($data as $key => $value) {
                if (is_array($value) && array_key_exists('collid', $value) && $value['collid'] == $id) {
                    $result = $value;
                    break;
                }
            }
            break;
        case 'departments':
            foreach($data as $key => $value) {
                if (is_array($value) && array_key_exists('deptid', $value) && $value['deptid'] == $id) {
                    $result = $value;
                    break;
                }
            }
            break;
        default:
            $result = [];
            break;
    }

    echo json_encode($result);
}

// get programs by college id
if ($request_method === 'GET' && $slug === 'programs' && $collid) {
    $stmt = $pdo->prepare("SELECT * FROM programs WHERE progcollid = ?");
    $stmt->execute([$collid]);
    $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($programs);
}

// create data
if ($request_method === 'POST' && $slug) {
    $data = json_decode(file_get_contents('php://input'), true);

    switch($slug) {
        case "students":

            $stnt = $pdo->prepare("SELECT COUNT(*) FROM students WHERE studid = ?");
            $stnt->execute([$data['studid']]);
            $count = $stnt->fetchColumn();

            if ($count > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Student ID already exists']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO students (studid, studfirstname, studlastname, studmidname, studprogid, studcollid, studyear) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$data['studid'], $data['studfirstname'], $data['studlastname'], $data['studmidname'], $data['studprogid'], $data['studcollid'], $data['studyear']]);
            break;

        case "programs":

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM programs WHERE progid = ?");
            $stmt->execute([$data['progid']]);
            $count = $stmt->fetchColumn();


            if ($count > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Duplicate progid']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO programs (progid, progfullname, progshortname, progcollid, progcolldeptid) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$data['progid'], $data['progfullname'], $data['progshortname'], $data['progcollid'], $data['progcolldeptid']]);
            break;

        case "colleges":

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM colleges WHERE collid = ?");
            $stmt->execute([$data['collid']]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Duplicate collid']);
                exit;
            }


            $stmt = $pdo->prepare("INSERT INTO colleges (collid, collfullname, collshortname) VALUES (?, ?, ?)");
            $stmt->execute([$data['collid'], $data['collfullname'], $data['collshortname']]);
            break;

        case "departments":

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM departments WHERE deptid = ?");
            $stmt->execute([$data['deptid']]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Duplicate deptid']);
                exit;
            }


            $stmt = $pdo->prepare("INSERT INTO departments (deptid, deptfullname, deptshortname, deptcollid) VALUES (?, ?, ?, ?)");
            $stmt->execute([$data['deptid'], $data['deptfullname'], $data['deptshortname'], $data['deptcollid']]);
            break;

        default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid route']);
        exit;

    }

    echo json_encode($data);

}

//  update data
if ($request_method === 'PUT' && $slug && $id) {
    $data = json_decode(file_get_contents('php://input'), true);

    switch($slug) {
        case "students":
            $stmt = $pdo->prepare("UPDATE students SET studfirstname = ?, studlastname = ?, studmidname = ?, studprogid = ?, studcollid = ?, studyear = ? WHERE studid = ?");
            $stmt->execute([$data['studfirstname'], $data['studlastname'], $data['studmidname'], $data['studprogid'], $data['studcollid'], $data['studyear'], $id]);
            break;

        case "programs":
            $stmt = $pdo->prepare("UPDATE programs SET progfullname = ?, progshortname = ?, progcollid = ?, progcolldeptid = ? WHERE progid = ?");
            $stmt->execute([$data['progfullname'], $data['progshortname'], $data['progcollid'], $data['progcolldeptid'], $id]);
            break;

        case "colleges":
            $stmt = $pdo->prepare("UPDATE colleges SET collfullname = ?, collshortname = ? WHERE collid = ?");
            $stmt->execute([$data['collfullname'], $data['collshortname'], $id]);
            break;

        case "departments":
            $stmt = $pdo->prepare("UPDATE departments SET deptfullname = ?, deptshortname = ?, deptcollid = ? WHERE deptid = ?");
            $stmt->execute([$data['deptfullname'], $data['deptshortname'], $data['deptcollid'], $id]);
        break;
    }


echo json_encode(['status' => 'success', 'message' => 'Data updated']);


}


// Delete data
if ($request_method === 'DELETE' && $slug && $id) {

    switch ($slug) {

        case "students":
            $stmt = $pdo->prepare("DELETE FROM students WHERE studid = ?");
            $stmt->execute([$id]);
            break;

        case "programs":
            $stmt = $pdo->prepare("DELETE FROM students WHERE progid = ?");
            $stmt->execute([$id]);
            break;

        case "colleges":
            $stmt = $pdo->prepare("DELETE FROM students WHERE collid = ?");
            $stmt->execute([$id]);
            break;

        case "departments":
            $stmt = $pdo->prepare("DELETE FROM students WHERE deptid = ?");
            $stmt->execute([$id]);
            break;


    }

    echo json_encode(['status' => 'success', 'message' => 'Data deleted']);



}