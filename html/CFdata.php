<?php
$url_send = 'http://compfit.us/api/challenge';
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
$data['start_date'] = '2016-4-25';
$data['end_date'] = '2016-5-29';
$data['to_team_id'] = '1';
$data['from_team_id'] = '7';
$data['repetitions'] = '1200';
$data['units'] = 'repetitions';
$data['task_type'] = 'Group';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$url_send = 'http://compfit.us/api/exercise';

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
$data['repetitions'] = '.25';
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
$data['repetitions'] = '1.5';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '22';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '3.2';
$data['units'] = 'kilometers';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '32';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '0.2';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '1';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '.5';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '37';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '1.25';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '11';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '.35';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '13';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '.45';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '16';
$data['date_completed'] = '2016-4-26';
$data['repetitions'] = '.75';
$data['units'] = 'miles';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '41';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '3.6';
$data['units'] = 'kilometers';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Swimming';
$data['user_id'] = '18';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '4';
$data['units'] = 'kilometers';
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
$data['date_completed'] = '2016-4-25';
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
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '15';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '16';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '45';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '13';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '25';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '18';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '25';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '11';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '56';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '2';
$data['date_completed'] = '2016-4-25';
$data['repetitions'] = '14';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '32';
$data['date_completed'] = '2016-4-25';
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
$data['date_completed'] = '2016-4-24';
$data['repetitions'] = '78';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '26';
$data['date_completed'] = '2016-4-23';
$data['repetitions'] = '39';
$data['units'] = 'minutes';
$str_data = json_encode($data, JSON_PRETTY_PRINT);

sendPostData($url_send, $str_data);

$data = array();
$data['exercise_name'] = 'Yoga';
$data['user_id'] = '5';
$data['date_completed'] = '2016-4-24';
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

?>
