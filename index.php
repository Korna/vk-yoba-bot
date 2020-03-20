<?php
$public_token = "75a7b8ba";
$important_message = "хуй саси";

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
        $message_text = strtolower($data->object->text);
        $chat_id = $data->object->peer_id;

        if ($message_text == "привет") {
            vk_msg_send($chat_id, "Привет.");
        }
        if ($message_text == "пока") {
            vk_msg_send($chat_id, "Пока.");
        }
        if ($message_text == "шош" || $message_text == "борь" || $message_text == "тимч") {
            vk_msg_send($chat_id, $important_message);
        }

        echo 'ok';
        break;
}
