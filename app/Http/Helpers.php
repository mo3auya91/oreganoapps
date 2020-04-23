<?php

function api_response($data, $message, $errors, $code = 200)
{
    $items['code'] = $code;
    $items['message'] = $message;
    $items['error_messages'] = [];
    if ($errors instanceof Illuminate\Validation\Validator) {
        $new_message = '';
        $e = [];
        foreach ($errors->errors()->messages() as $key => $error) {
            $new_message .= $error[0] . ', ';
            array_push($e, ['key' => $key, 'message' => $error[0]]);
        }
        $new_message = mb_substr($new_message, 0, -2);
        $items['error_messages'] = $e;
        $items['message'] = $new_message;
    }
    $items['pagination'] = null;
    $items['data'] = $data;
    if ($data instanceof Illuminate\Pagination\LengthAwarePaginator) {
        $items['data'] = $data->items();
        $items['pagination'] = [
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
        ];
    }
    return response()->json($items, $code);
}

function max_upload_size()
{
    $max = ini_get('upload_max_filesize');
    if (substr($max, -1) == 'M') {
        //MB
        $max = substr(trim($max), 0, -1);
    } else {
        //GB
        $max = substr(trim($max), 0, -1) * 1000;
    }
    return $max * 1000;//convert to KB
}
