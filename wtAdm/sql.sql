create database waltertech;
use waltertech; 

create table usuarios(
	id_usuario int primary key auto_increment not null,
    nome varchar(100) not null,
    email varchar(100) not null,
    senha varchar(100) not null
);

create table servico (
	id_servico int primary key auto_increment not null,
    id_usuario int not null,
    cliente varchar(100) not null,
    data_criacao datetime not null default current_timestamp,
    valor decimal(10,2) NOT NULL DEFAULT 0.00,
    foreign key (id_usuario) references usuarios(id_usuario) on update cascade on delete no action
);