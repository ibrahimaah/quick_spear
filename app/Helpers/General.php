<?php

use Illuminate\Support\Facades\Config;

function get_default_lang(){
    return   Config::get('app.locale');
}


function uploadImage($folder, $image)
{
    //$image->store( $folder);
    $filename = $image->hashName();
    $path2 = public_path("images/".$folder);
    $image->move($path2,$filename);
    $path = 'images/' . $folder . '/' . $filename;
    return $path;
}

function sendmessage( $token, $title , $body)
{

    $token = $token;
    $from = "AAAAgBjiSMI:APA91bFvSGmrnykYugq8s4QX7Co49ypJJK1u7_maf-P0gJFl5BUuThFd9ZlIoQ9EH0tZvaYUKVJ5weOAFp5cwMeIenf1MH35jRBzR_nYufOuCFveUUvUHxk57Xoo9chwY2ZmNrsJSZtu";
    $msg = array
            (
            'body'     => $body,
            'title'    => $title,
            'receiver' => 'erw',
            'icon'     => "https://salon-eljoker.com/images/joker.jpg",/*Default Icon*/
            'vibrate'	=> 1,
            'sound'		=> "http://commondatastorage.googleapis.com/codeskulptor-demos/DDR_assets/Kangaroo_MusiQue_-_The_Neverwritten_Role_Playing_Game.mp3",
            );

    $fields = array
            (
                'to'        => $token,
                'notification'  => $msg
            );

    $headers = array
            (
                'Authorization: key=' . $from,
                'Content-Type: application/json'
            );
    //#Send Reponse To FireBase Server
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    curl_close( $ch );
    return $result;
}


/* 

// Get status message
$statusMessage = getStatusInfo($status_number);

// Get status ID
$statusId = getStatusInfo($status_number, 'id');

*/

function getStatusInfo($status_number, $info='msg')
{
    $statusConfig = config('constants.STATUS_NUMBER');

    switch ($status_number) {
        case $statusConfig['UNDER_REVIEW']:
            return $info === 'msg' ? __('under_review') : 'under_review';
        case $statusConfig['UNDER_DELIVERY']:
            return $info === 'msg' ? __('under_delivery') : 'under_delivery';
        case $statusConfig['DELIVERED']:
            return $info === 'msg' ? __('delivered') : 'delivered';
        case $statusConfig['REJECTED_WITHOUT_PAY']:
            return $info === 'msg' ? __('rejected_without_pay') : 'rejected_without_pay';
        case $statusConfig['REJECTED_WITH_PAY']:
            return $info === 'msg' ? __('rejected_with_pay') : 'rejected_with_pay';
        case $statusConfig['POSTPONED']:
            return $info === 'msg' ? __('postponed') : 'postponed';
        case $statusConfig['NO_RESPONSE']:
            return $info === 'msg' ? __('no_response') : 'no_response';
        // case $statusConfig['RETURNED']:
        //     return $info === 'msg' ? __('returned') : 'returned';
        default:
            return $info === 'msg' ? __('unknown_status') : 'unknown_status';
    }
}

