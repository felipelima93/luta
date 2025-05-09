<?php
namespace App\Model;

class Arma {
    private $nome;
    private $dano;
    private $tipo;

    public function __construct($nome, $dano, $tipo) {
        $this->nome = $nome;
        $this->dano = $dano;
        $this->tipo = $tipo;
    }

    public function getDano() {
        return $this->dano;
    }

    public function getNome() {
        return $this->nome;
    }
}

class Heroi {
    private $nome;
    private $nivel;
    private $armas;

    public function __construct($nome, $nivel) {
        $this->nome = $nome;
        $this->nivel = $nivel;
        $this->armas = [];
    }

    public function adicionarArma(Arma $arma) {
        $this->armas[] = $arma;
    }

    public function getArmas() {
        return $this->armas;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getNivel() {
        return $this->nivel;
    }
}

class Monstro {
    private $nome;
    private $pontosDeVida;
    private $tipo;

    public function __construct($nome, $pontosDeVida, $tipo) {
        $this->nome = $nome;
        $this->pontosDeVida = $pontosDeVida;
        $this->tipo = $tipo;
    }

    public function receberDano($dano) {
        $this->pontosDeVida -= $dano;
    }

    public function estaVivo() {
        return $this->pontosDeVida > 0;
    }

    public function getNome() {
        return $this->nome;
    }
}

class Resultado {
    private $vencedor;
    private $log;

    public function __construct() {
        $this->log = [];
    }

    public function setVencedor($vencedor) {
        $this->vencedor = $vencedor;
    }

    public function adicionarLog($acao) {
        $this->log[] = $acao;
    }

    public function getVencedor() {
        return $this->vencedor;
    }

    public function getLog() {
        return $this->log;
    }
}

class Batalha {
    private $heroi;
    private $monstro;
    private $resultado;

    public function __construct(Heroi $heroi, Monstro $monstro) {
        $this->heroi = $heroi;
        $this->monstro = $monstro;
        $this->resultado = new Resultado();
    }

    public function lutar() {
        $turno = 0;
        while ($this->heroi->getArmas() && $this->monstro->estaVivo()) {
            $turno++;
            $arma = $this->heroi->getArmas()[array_rand($this->heroi->getArmas())];
            $dano = $arma->getDano();
            $this->monstro->receberDano($dano);
            $this->resultado->adicionarLog("Turno $turno: {$this->heroi->getNome()} ataca {$this->monstro->getNome()} com {$arma->getNome()} causando $dano de dano.");

            if (!$this->monstro->estaVivo()) {
                $this->resultado->setVencedor($this->heroi->getNome());
                break;
            }

            // Monstro ataca de volta
            $danoMonstro = rand(1, 10); // Dano aleatório do monstro
            $this->resultado->adicionarLog("Turno $turno: {$this->monstro->getNome()} ataca {$this->heroi->getNome()} causando $danoMonstro de dano.");
            // Aqui você pode implementar a lógica de vida do herói se necessário
        }

        if (!$this->resultado->getVencedor()) {
            $this->resultado->setVencedor($this->monstro->getNome());
        }

        return $this->resultado;
    }
}
