
create database Escola;
use Escola;
create table alunos(
id int primary key auto_increment,
nome varchar (50),
idade int, 
email varchar (50),
curso varchar (50));
insert into Escola.alunos (id,nome,idade,email,curso)
values("Rafael",18,"rafael@gmail.com","TI"),
("Rafaela",18,"rafaela@gmail.com","TI"),
("gabriel",17,"gbiel@gmail.com","TI"),
("fernando",17,"fernado@gmail.com","TI");
select*from Escola.alunos;
