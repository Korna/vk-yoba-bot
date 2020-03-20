<?php
define("public_token", "75a7b8ba");
define("important_message", "хуй саси");
define("internal_token", "114e33c45cde37797d6c87c2d0bb653e9dd507e9287065a77c958d546823e7738d0e4eac0d8b8491c8bb5");

function send_message_to_user($userId, $text)
{
    $request_params = array(
        'message' => $text,
        'peer_id' => $userId,
        'access_token' => internal_token,
        'v' => '5.87'
    );

    $get_params = http_build_query($request_params);

    file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
}

function process_user_message($data)
{
    switch ($data->type) {
        case 'confirmation':
            echo public_token;
            break;

        case 'message_new':
            $message_text = strtolower($data->object->text);
            $chat_id = $data->object->peer_id;

            if ($message_text == "привет") {
                send_message_to_user($chat_id, "Привет.");
            }
            if ($message_text == "пока") {
                send_message_to_user($chat_id, "Пока.");
            }
            if ($message_text == "шош" || $message_text == "борь" || $message_text == "тимч" || $message_text == "чом") {
                send_message_to_user($chat_id, important_message);
            }

            echo 'ok';
            break;
    }
}

$data = json_decode(file_get_contents('php://input'));

process_user_message($data);