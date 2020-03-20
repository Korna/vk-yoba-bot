<?php

$public_token = "75a7b8ba";

//echo $public_token;

function vk_msg_send($peer_id, $text)
{
    $internal_token = "114e33c45cde37797d6c87c2d0bb653e9dd507e" . "9287065a77c958d546823e7738d0e4eac0d8b8491c8bb5";

    $request_params = array(
        'message' => $text,
        'peer_id' => $peer_id,
        'access_token' => $internal_token,
        'v' => '5.87'
    );

    $get_params = http_build_query($request_params);
    file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
}

$data = json_decode(file_get_contents('php://input'));
switch ($data->type) {
    case 'confirmation':
        echo $public_token;
        break;

    case 'message_new':
        $message_text = $data->object->text;
        $chat_id = $data->object->peer_id;
        if ($message_text == "привет") {
            vk_msg_send($chat_id, "Привет.");
        }
        if ($message_text == "пока") {
            vk_msg_send($chat_id, "Пока.");
        }
        echo 'ok';
        break;
}

$chat_id = 1000;

vk_msg_send($chat_id, "TUPA TEXT");
