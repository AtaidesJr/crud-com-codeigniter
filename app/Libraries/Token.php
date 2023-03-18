<?php

namespace App\Libraries;

class Token
{
    private $token;


    public function __construct(string $token = null)
    {
        // SE NãO EXISTIR
        if ($token === null) {

            // SE NÃO HOUVER NENHUM TOKEN , ENTÃO IRA CRIA-LÓ
            $this->token = bin2hex(random_bytes(16));
        } else {
            $this->token = $token;
        }
    }


    /**
     * METODO QUE RETORNA O VALOR DO $token
     * 
     */
    public function getValue(): string
    {
        return $this->token;
    }

    public function getHash(): string
    {
        return  hash_hmac("sha256", $this->token, getenv('CHAVE_RECUPERACAO_SENHA'));
    }
}
