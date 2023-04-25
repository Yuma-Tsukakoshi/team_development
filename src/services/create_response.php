<?php

function create_response($status, $message)
{
  $json = json_encode($message, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=utf-8");
  http_response_code($status);
  echo $json;
}