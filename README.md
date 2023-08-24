# Bank API RESTFul

REST API que simula transações de entre usuários e lojistas de um banco/store digital.

Foram utilizados partes dos padrões de: Arquitetura Limpa, DDD, Design Patterns, Injeção de dependência, SOLID.

## Tecnologias
- Laravel - 10.10
- PHP - 8.2
- MYSQL

## Kanban utilizado durante o projeto
https://github.com/users/MatheusMeloAntiquera/projects/1

## Para Testar
Todas as rotas foram validadas através de testes de integração

Para executar os testes é necessário subir docker, criar uma copia do arquivo `.env.example` e depois executar o comando:
```
php artisan test
```
ou: 
```
./vendor/bin/phpunit
```
## CI do Projeto
Foi criado um workflow no repositório para executar os testes ao atualizar a branch develop

Historíco desse workflow: https://github.com/MatheusMeloAntiquera/bank-api/actions/workflows/laravel.yml


