<?php

function currencyBrToEn($var)
{
    if (is_null($var) || $var === '') {
        return $var;
    }

    return preg_replace('#\D#', '', $var) / 100;
}

function currencyEnToBr($var)
{
    if (is_null($var) || $var === '') {
        return $var;
    }

    return number_format($var, 2, ',', '.');
}

function dateBrToEn($date)
{
    if (is_null($date) || $date === '') {
        return $date;
    }

    return \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
}

function dateEnToBr($date)
{
    if (is_null($date) || $date === '') {
        return $date;
    }

    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
}

function handleResponses($response)
{
    if ($response instanceof \Illuminate\Database\QueryException) {
        report($response);
        return response()->json(['error' => $response->getMessage()], 400);
    } else if (is_array($response) && isset($response['error'])) {
        $response['code'] = $response['code'] ?? 400;
        return response()->json(['error' => $response['error']], $response['code']);
        exit;
    } else if (is_bool($response)) {
        return response()->json(['message' => ($response ? 'OK' : 'ERROR')], 200);
        exit;
    } else if (is_null($response)) {
        response()->json(['error' => 'A informação solicitada não foi encontrada'], 400);
    }

    return $response;
}

function convertSecondsToHours($seconds)
{
    $H = floor($seconds / 3600);
    $i = ($seconds / 60) % 60;
    $s = $seconds % 60;

    return sprintf("%02d:%02d:%02d", $H, $i, $s);
}
