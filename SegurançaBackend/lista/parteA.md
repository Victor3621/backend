1. Conceituação OWASP: O que significa a sigla XSS e por que ela é classificada como uma vulnerabilidade no lado do cliente (Client-Side) que deve ser prevenida pelo Back-End?
**R**: Cross-site scripting, o cliente que coloca os dados maliciosos, ou valida certo ou ele rouba os dados e faz o que quiser

2. Reflected vs Stored: Qual é a diferença entre um ataque XSS Refletido e um XSS Gravado (Stored)? Qual dos dois apresenta maior potencial de estrago para uma empresa e por quê?
**R**:reflected é enviado pela requisição; storage é armazenado e visualizado para outros usuarios. Mais prejudicial é storage

3. Mecanismo de Escapamento: Explique detalhadamente a transformação que a função htmlspecialchars() realiza nos caracteres < e >. Por que o navegador não executa o código após essa transformação?
**R**: ele transforma as <> em texto corrido, dai não fica como código

4. Flags de Proteção: Qual é a função da flag ENT_QUOTES na chamada de htmlspecialchars()? O que pode acontecer se essa flag for omitida em um campo <input value="...">?
**R**: `ENT_QUOTES` faz o `htmlspecialchars()` escapar aspas simples e duplas. Sem essa flag, uma aspa pode fechar prematuramente o atributo value="...", possibilitando injeção de HTML e XSS.

5. Anti-Alucinação PHP: Por que não devemos utilizar o filtro FILTER_SANITIZE_STRING em projetos modernos desenvolvidos em PHP 8.3?
**R**:Para sanitizar os caracteres assim deixando o código mais facil de validar

6. Validação de E-mail: Qual é a diferença prática entre verificar um e-mail com empty($email) e verificar com filter_var($email, FILTER_VALIDATE_EMAIL)?
**R**:emails podem conter espaços, o filter_validate valida se tem o @ que todos os email tem, alguns emails não tem espaço ent aquilo vai pras cucuia com a validação do empty 

7. Roubo de Sessão: Como um atacante pode usar uma brecha XSS para capturar o cookie de sessão de um usuário logado?
**R**: cookies são as configurações que deixamos em um site, ou seja pegar meus dados e informações e usar, ou seja passar-lhe a mão

8. Segurança em Camadas: Por que sanitizar na entrada (ex: com strip_tags) não elimina a necessidade de codificar na saída com htmlspecialchars()?
**R**:Se você já verificou uma vez, não precisa verificar denovo