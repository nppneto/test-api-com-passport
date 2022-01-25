<?php

if (!function_exists('getHttpStatusMessages')) {
    function getHttpStatusMessages($code = null) {
        
        $httpResponses = [
            200 => 'Sucesso',
            201 => 'Criado',
            400 => 'Requisição Inválida',
            401 => 'Não autorizado',
            403 => 'Proibido',
            404 => 'Não encontrado',
            500 => 'Erro interno do servidor',
        ];

        if ($code) {
            return $httpResponses[$code];
        }

        return $httpResponses;
    }
}