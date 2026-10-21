<?php
declare(strict_types=1);

//ContaPoupanca é uma subClasse de ContaBancaria
//Regras de negócio : ChequeEspecial e Cobrança da tx de saque

final class contaPoupanca extends ContaBancaria{
    //substituir o construtor da contaBancaria
    //ChequeEspecial -> quando criar a conta precisa declarar o cheque especial

    #[Override] //implementando o método 
    public function sacar(float $valor): void {
        if($valor <=0.0) {
            throw new ValorInvalidoException($valor);
        }

        $custoTotal = $valor;
        $saldoTotalDisponivel = $this->saldo;

        //se valor do saque for maior que saldo disponivel lança uma exception
        if($custoTotal > $saldoTotalDisponivel){ 
            throw new SaldoInsuficienteException($saldoTotalDisponivel, $custoTotal);
        }

        //se tudo tiver certo
        $this->saldo -= $custoTotal;
    }
    //criar o método apra calcualr juros
    public function renderJuros(float $percentual):void {
        if($percentual <=0.0) {
            throw new ValorInvalidoException($percentual);
        }
        // se tudo estiver certo
        $rendimento = $this->saldo * ($percentual/100);
        $this->saldo += $rendimento;
    }

}