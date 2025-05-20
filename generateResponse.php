<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Orhanerday\OpenAi\OpenAi;


$open_ai = new OpenAi('');

$complete = $open_ai->completion([
    'model' => 'text-davinci-002',
    'prompt' => 'what is programing',
    'temperature' => 0.9,
    'max_tokens' => 150,
    'frequency_penalty' => 0,
    'presence_penalty' => 0.6,
]);

if ($complete != null) {
    $php_obj = json_decode($complete);
    $response = $php_obj->choices[0]->text;
    echo $response;
};
