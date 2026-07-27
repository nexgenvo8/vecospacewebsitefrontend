<?php
include_once('inc.php');
include_once('config/session-check.inc.php');

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

if ($action == 'testimonial') {

    $msgId = intval($_POST['msgId'] ?? 0);
    $studentName = mysqli_real_escape_string($conn, $_POST['studentName'] ?? '');
    $regNo = mysqli_real_escape_string($conn, $_POST['regNo'] ?? '');
    $meetingDate = mysqli_real_escape_string($conn, $_POST['meetingDate'] ?? '');
    $mentorName = mysqli_real_escape_string($conn, $_POST['mentorName'] ?? '');
    $duration = mysqli_real_escape_string($conn, $_POST['duration'] ?? '');
    $learner = mysqli_real_escape_string($conn, $_POST['learner'] ?? '');
    $agenda = mysqli_real_escape_string($conn, $_POST['agenda'] ?? '');

    $userId = $_SESSION['sessUserId'];
    $createdBy = $userId;
    $chatId = $msgId;
    $title = "Meeting with " . $mentorName;
    $meetingDateTime = $meetingDate;
    $status = 1;
    $notiStatus = 0;

    if (!$msgId) {
        echo json_encode([
            "status" => false,
            "message" => "Invalid message ID"
        ]);
        exit;
    }

    // Check if record already exists for this chatId and userId
    $check = mysqli_query(
        $conn,
        "SELECT id FROM meetingmsater 
         WHERE chatId = '$chatId' AND userId = '$userId'"
    );

    if (mysqli_num_rows($check) > 0) {
        // Update existing record with ALL fields
        $update = mysqli_query(
            $conn,
            "UPDATE meetingmsater SET 
                student_name = '$studentName',
                registration_no = '$regNo',
                mentor_name = '$mentorName',
                title = '$title',
                meetingDateTime = '$meetingDateTime',
                duration = '$duration',
                agenda = '$agenda',
                learner_remark = '$learner',
                status = '$status',
                notiStatus = '$notiStatus'
             WHERE chatId = '$chatId' AND userId = '$userId'"
        );

        if ($update) {
            echo json_encode([
                "status" => true,
                "mode" => "updated",
                "message" => "Meeting updated successfully"
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "Failed to update: " . mysqli_error($conn)
            ]);
        }
    } else {
        // Insert new record with ALL fields
        $insert = mysqli_query(
            $conn,
            "INSERT INTO meetingmsater (
                userId, 
                student_name,
                registration_no,
                mentor_name,
                createdBy, 
                chatId, 
                title, 
                meetingDateTime, 
                duration, 
                agenda,
                learner_remark,
                status, 
                notiStatus
            ) VALUES (
                '$userId',
                '$studentName',
                '$regNo',
                '$mentorName',
                '$createdBy',
                '$chatId',
                '$title',
                '$meetingDateTime',
                '$duration',
                '$agenda',
                '$learner',
                '$status',
                '$notiStatus'
            )"
        );

        if ($insert) {
            echo json_encode([
                "status" => true,
                "mode" => "inserted",
                "message" => "Meeting saved successfully"
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "Failed to insert: " . mysqli_error($conn)
            ]);
        }
    }
} else {
    echo json_encode([
        "status" => false,
        "message" => "Invalid action"
    ]);
}

exit;
?>