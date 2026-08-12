<?php 
declare(strict_types=1);

//Motor de Análise de Créditos

// Regras do Negócio:
// Regra da Idade: O cliente precisa ter 18 anos ou mais e menos de 70 anos 
// Regra da Parcela (renda): O valor da parcela do empréstimo NÃO pode ser maior que 30% da renda mensal do cliente
// Regra VIP: Se o cliente tiver um "Score de Crédito" maior que 800, ele tem aprovação automática. ( as Regra de Idade e Renda não importam)
// Aprovação Final: O Crédito é liberado se (Regra1 e Regra2 forem superadas) OU Se (Regra 3 passar).
?>