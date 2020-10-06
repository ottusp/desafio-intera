## Introdução

Esse projeto faz parte de um desafio tipo entrevista de emprego para a <a href="https://byintera.com/">Intera</a>.

## O desafio

O desafio consiste em construir, em uma semana, um sistema de cadastro de metas para um squad.  
Cada squad é responsável pela contratação de diferentes vagas para diferentes empresas, e precisa estabelecer metas de:
- Inscrições de candidatos a uma vaga;
- Entrevistas de candidatos;
- Candidatos aprovados na vaga;
- Uma data para entregar os candidatos aprovados;

Nesse sistema, o líder de um squad deve poder escolher seu squad pelo nome, consultar os processos seletivos do seu squad e cadastrar uma meta, levando em conta os 4 parâmetros acima.  

Além disso, o líder do squad também deve poder consultar a relação de todas as metas de processos seletivos ativos.  

## Instalação

Para rodar esse projeto, é necessário ter:
- Composer;
- Mysql;

- Clone o repositório;
- Navegue para a pasta onde o repositório foi clonado;
- Digite o comando ``composer install``;
- Copie o arquivo <b>.env.examples</b> e renomeie-o para <b>.env</b>;
- No arquivo <b>.env</b>, na linha DB_DATABASE=laravel digite o nome do seu banco de dados;
  - Por exemplo, se o seu banco de dados se chamar 'minha_base_de_dados', renomeie a linha para <b>DB_DATABASE=minha_base_de_dados</b>;
- Complete as outras linhas do arquivo .env com as credenciais do seu banco de dados (DB_USERNAME e DB_PASSWORD);
- Rode o comando ``php artisan key:generate``;
- Faça as migrations com o comando ``php artisan migrate``;
- Rode o projeto na máquina local com o comando ``php artisan serve``;
- [Extra] Para copular o banco de dados com exemplos, acesse a url <b>localhost:8000/bootstrap</b>. Isso deverá rodar o script que lê os dados de uma planilha e copula o banco.
