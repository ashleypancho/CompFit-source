<?php

// $url_send = 'http://127.0.0.1/api/user';
// function sendPostData($url, $post){
//   $ch = curl_init($url);
//   curl_setopt($ch, CURLOPT_POST, true);
//   curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
//   //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//     'Content-Type: application/json'));
//
//     $result = curl_exec($ch);
//     curl_close($ch);
// }
// $data = array();
// $data['first_name'] = 'Mary Charles';
// $data['last_name'] = 'Porter';
// $data['username'] = 'marycharles2';
// $data['email'] = 'mcharles2@gmail.com';
// $data['password'] = '420blazeit2016';
// $str_data = json_encode($data, JSON_PRETTY_PRINT);
// sendPostData($url_send, $str_data);

$url_send = 'http://127.0.0.1/api/challenge';
function sendPostData($url, $post){
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'));

    $result = curl_exec($ch);
    curl_close($ch);
}

$data = array();
$data['task_name'] = 'Cycling';
$data['start_date'] = '2016-4-21';
$data['end_date'] = '2016-4-29';
$data['to_team_id'] = '1';
$data['from_team_id'] = '7';
$data['repetitions'] = '50';
$data['units'] = 'miles';
$data['task_type'] = 'Group';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['task_name'] = 'Cycling';
$data['start_date'] = '2016-4-25';
$data['end_date'] = '2016-5-3';
$data['to_team_id'] = '2';
$data['from_team_id'] = '1';
$data['repetitions'] = '20';
$data['units'] = 'miles';
$data['task_type'] = 'Individual';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['task_name'] = 'Swimming';
$data['start_date'] = '2016-4-21';
$data['end_date'] = '2016-4-29';
$data['to_team_id'] = '1';
$data['from_team_id'] = '16';
$data['repetitions'] = '4';
$data['units'] = 'miles';
$data['task_type'] = 'Individual';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['task_name'] = 'Yoga';
$data['start_date'] = '2016-4-25';
$data['end_date'] = '2016-4-29';
$data['to_team_id'] = '1';
$data['from_team_id'] = '4';
$data['repetitions'] = '120';
$data['units'] = 'minutes';
$data['task_type'] = 'Individual';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['task_name'] = 'Russian Twists';
$data['start_date'] = '2016-4-21';
$data['end_date'] = '2016-5-29';
$data['to_team_id'] = '1';
$data['from_team_id'] = '7';
$data['repetitions'] = '1200';
$data['units'] = 'repetitions';
$data['task_type'] = 'Group';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);








$data = array();
$data['task_name'] = 'Squats';
$data['start_date'] = '2016-4-20';
$data['end_date'] = '2016-4-27';
$data['to_team_id'] = '1';
$data['from_team_id'] = '17';
$data['repetitions'] = '1000';
$data['units'] = 'repetitions';
$data['task_type'] = 'Group';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['task_name'] = 'Burpees';
$data['start_date'] = '2016-4-23';
$data['end_date'] = '2016-4-30';
$data['to_team_id'] = '18';
$data['from_team_id'] = '1';
$data['repetitions'] = '500';
$data['units'] = 'repetitions';
$data['task_type'] = 'Group';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['task_name'] = 'Running';
$data['start_date'] = '2016-4-23';
$data['end_date'] = '2016-4-29';
$data['to_team_id'] = '6';
$data['from_team_id'] = '19';
$data['repetitions'] = '5';
$data['units'] = 'miles';
$data['task_type'] = 'Individual';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['task_name'] = 'Box Jumps';
$data['start_date'] = '2016-4-24';
$data['end_date'] = '2016-5-1';
$data['to_team_id'] = '8';
$data['from_team_id'] = '19';
$data['repetitions'] = '500';
$data['units'] = 'repetitions';
$data['task_type'] = 'Group';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['task_name'] = 'Crunches';
$data['start_date'] = '2016-4-27';
$data['end_date'] = '2016-5-05';
$data['to_team_id'] = '14';
$data['from_team_id'] = '20';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$data['task_type'] = 'Individual';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);


$url_send = 'http://127.0.0.1/api/exercise';

// $data['start_date'] = '2016-4-25';
// $data['end_date'] = '2016-5-3';
// $data['to_team_id'] = '1';
// $data['from_team_id'] = '2';
// $data['repetitions'] = '20';

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '2';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '4.3';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '32';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '2.5';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '28';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '5.4';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '42';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '5.4';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '3';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '1.4';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '26';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '3.7';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '5';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '2.9';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '8';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '4.2';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '38';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '17.6';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '34';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '10';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '21';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '2.25';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '21';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '2.50';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);
sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '19';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '.5';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '42';
$data['date_completed'] = '2016-4-22';
$data['repetitions'] = '1.5';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '24';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '1.2';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '7';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '3.45';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '4';
$data['date_completed'] = '2016-4-21';
$data['repetitions'] = '1.86';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '11';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '13';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '18';
$data['date_completed'] = '2016-4-29';
$data['repetitions'] = '2.2';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '13';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '4.2';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '16';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '1.24';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '37';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '3';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '41';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '1.25';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '41';
$data['date_completed'] = '2016-4-21';
$data['repetitions'] = '.25';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '1.25';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '1.2';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-21';
$data['repetitions'] = '.75';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Cycling';
$data['user_id'] = '38';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '17.6';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '21';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '36';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '19';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '37';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '24';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '40';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '7';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '75';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '4';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '15';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '42';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '10';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '34';
$data['date_completed'] = '2016-4-21';
$data['repetitions'] = '40';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '38';
$data['date_completed'] = '2016-4-21';
$data['repetitions'] = '34';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '25';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '11';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '80';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '13';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '49';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '37';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '190';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);


$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '41';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '60';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);


$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '18';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '30';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Russian Twists';
$data['user_id'] = '16';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '40';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '4';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '4';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '22';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '4';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '32';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '4.3';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '4.5';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '37';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '4.25';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '11';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '4.35';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '13';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '4.45';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '16';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '4.75';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '41';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '4.6';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '18';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '4';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '30';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '20';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '41';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '35';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '37';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '15';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '16';
$data['date_completed'] = '2016-4-29';
$data['repetitions'] = '45';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '13';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '25';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '18';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '25';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '11';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '23';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '11';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '34';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '2';
$data['date_completed'] = '2016-4-29';
$data['repetitions'] = '14';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '32';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '23';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '28';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '40';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '28';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '60';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '42';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '63';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '3';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '78';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '26';
$data['date_completed'] = '2016-4-29';
$data['repetitions'] = '39';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '5';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '25';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '8';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '90';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);



























$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-21';
$data['repetitions'] = '30';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '43';
$data['date_completed'] = '2016-4-22';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-22';
$data['repetitions'] = '100';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '44';
$data['date_completed'] = '2016-4-22';
$data['repetitions'] = '150';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '41';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '200';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '44';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);


$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '37';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '44';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '16';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '150';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '45';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '16';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '46';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '200';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '13';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '150';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '43';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '100';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '18';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '180';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '46';
$data['date_completed'] = '2016-4-21';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Squats';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '90';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);




















$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '47';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '47';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '30';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '41';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '48';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);


$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '37';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '49';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '16';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '70';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '50';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '13';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '18';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '60';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '11';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '30';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Burpees';
$data['user_id'] = '49';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);


























$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '51';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '2';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '51';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '3';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '2';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '12';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '2';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '52';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '12';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '52';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '12';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '52';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '12';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '52';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '24';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '3';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '52';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '24';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '3';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '53';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '2';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '4';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '5';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '53';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '20';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '53';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '2';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '20';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '2';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '54';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '20';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '54';
$data['date_completed'] = '2016-4-29';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '20';
$data['date_completed'] = '2016-4-29';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '40';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '3';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '40';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '3';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '9';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '9';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '9';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '9';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '9';
$data['date_completed'] = '2016-4-29';
$data['repetitions'] = '1';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Running';
$data['user_id'] = '31';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '5';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);































$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '37';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '51';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '10';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '37';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '10';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '51';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '11';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '51';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '10';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);


$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '11';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '30';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '52';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '10';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '10';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '10';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '10';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '30';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '10';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '2';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '40';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '18';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '30';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '18';
$data['date_completed'] = '2016-4-30';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '36';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '53';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '53';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '53';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '53';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '53';
$data['date_completed'] = '2016-4-30';
$data['repetitions'] = '40';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '54';
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '25';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '54';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '25';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '54';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '54';
$data['date_completed'] = '2016-4-27';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '54';
$data['date_completed'] = '2016-4-28';
$data['repetitions'] = '20';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '54';
$data['date_completed'] = '2016-4-29';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Box Jumps';
$data['user_id'] = '54';
$data['date_completed'] = '2016-4-30';
$data['repetitions'] = '50';
$data['units'] = 'repetitions';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);


?>
