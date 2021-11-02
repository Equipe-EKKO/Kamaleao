-- deleta e logo depois cria a base de dados, se ainda não existe. Então, declara que o uso dela 
DROP database if exists db_kamaleao;
CREATE database if not exists db_kamaleao DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE db_kamaleao;

-- começa a declarar as tabelas, pela ordem de tabelas mais independentes para as mais dependentes, no relacionamento do modelo.
-- primeiro, tabela de login
CREATE table IF NOT EXISTS  tb_login(
	-- atributos
	cd_login INT UNSIGNED NOT NULL auto_increment, -- chave primária 
    nm_email VARCHAR(200) NOT NULL,  -- chave unica index
	nm_senha VARCHAR(25) NOT NULL,
    nm_username VARCHAR(30) NOT NULL,
    ic_is_administrador BOOLEAN NOT NULL,
    -- definicao das chaves
    -- primaria
    constraint pk_login 
		primary key (cd_login),
	-- email como indice unico para evitar overload de contas no mesmo email
    constraint un_login_email
		unique index (nm_email))
CHARACTER SET utf8mb4;
        

-- tabela de categoria
CREATE table IF NOT EXISTS tb_categoria(
	-- atributos
    cd_categoria INT UNSIGNED NOT NULL auto_increment, -- chave primaria
    nm_categoria VARCHAR(40) NOT NULL,
    `dt_criação` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- definicao das chaves
    -- primaria
    constraint pk_categoria
		primary key (cd_categoria))
CHARACTER SET utf8mb4;

-- tabela de status de pagamento
CREATE table IF NOT EXISTS tb_status_pagamento(
	-- atributos
    cd_status INT UNSIGNED NOT NULL auto_increment, -- chave primaria
    nm_status VARCHAR(20) NOT NULL,
    `dt_criação` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- definicao das chaves
    -- primaria
    constraint pk_status_pagamento
		primary key (cd_status))
CHARACTER SET utf8mb4;

-- tabela de tipos de licença
CREATE table IF NOT EXISTS `tb_tipos_licença`(  
    -- atributos
    `cd_licença` INT UNSIGNED NOT NULL auto_increment, -- chave primaria
    `nm_licença` VARCHAR(20) NOT NULL,
    `dt_criação` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- definicao das chaves
    -- primaria
    constraint pk_status_pagamento
		primary key (`cd_licença`))
CHARACTER SET utf8mb4;
        
-- tabela de usuarios
CREATE table IF NOT EXISTS tb_usuario (
	-- atributos
    cd_usuario INT UNSIGNED NOT NULL auto_increment, -- chave primaria
    nm_nome VARCHAR(60) NOT NULL,
    nm_sobrenome VARCHAR(200) NOT NULL,
    cd_cpf VARCHAR(11) NOT NULL, -- chave unica index
    cd_url_foto_perfil VARCHAR(300),
	ds_usuario VARCHAR(280),
	`dt_nascimento` DATE NOT NULL,
    `dt_criação` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    cd_login INT UNSIGNED NOT NULL, -- chave estrangeira
    -- definicao das chaves
    -- primaria
    constraint pk_usuario
		primary key (cd_usuario),
	-- foreign key
    constraint fk_login_usuario
		foreign key (cd_login)
			references tb_login (cd_login),
	-- unique index para fazer o cd_login se tornar uma relacao one to one
    constraint un_cd_login
		unique index (cd_login),
	-- unique index para não haver duplicacao de cpf
    constraint un_cd_cpf
		unique index (cd_cpf))
CHARACTER SET utf8mb4;
        
-- tabela de servicos
CREATE table IF NOT EXISTS `tb_serviço`(
	-- atributos
    `cd_serviço` INT UNSIGNED NOT NULL auto_increment, -- chave primaria
	`nm_serviço` VARCHAR(50) NOT NULL,
	`ds_serviço` VARCHAR(280) NOT NULL,
	`vl_serviço` DECIMAL(10,2) NOT NULL,
	`dt_criação` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	cd_usuario INT UNSIGNED NOT NULL, -- chave estrangeira
	cd_categoria INT UNSIGNED NOT NULL, -- chave estrangeira
	`cd_licença` INT UNSIGNED NOT NULL, -- chave estrangeira
    -- definicao das chaves
    -- primaria
    constraint `pk_serviço`
		primary key (`cd_serviço`),
	-- estrangeira: usuário e serviço
    constraint fk_usuario_servico
		foreign key (cd_usuario)
			references tb_usuario(cd_usuario),
	-- estrangeira: categoria e serviço
	constraint `fk_categoria_serviço`
		foreign key (cd_categoria)
			references tb_categoria(cd_categoria),
	-- estrangeira: licença e serviço
	constraint `fk_licença_serviço`
		foreign key (`cd_licença`)
			references `tb_tipos_licença`(`cd_licença`))
CHARACTER SET utf8mb4;

-- tabela de avaliação
CREATE table IF NOT EXISTS `tb_avaliação`(
	-- atributos
    `cd_avaliação` INT UNSIGNED NOT NULL auto_increment, -- chave primaria
	`qt_avaliação` DECIMAL(3,2) NOT NULL DEFAULT 0,
    `dt_criação` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	cd_usuario INT UNSIGNED NOT NULL, -- chave estrangeira
	`cd_serviço` INT UNSIGNED NOT NULL, -- chave estrangeira
    -- definicao das chaves
    -- primaria
    constraint `pk_avaliação`
		primary key (`cd_avaliação`),
	-- estrangeira: entre usuario e avaliacao
    constraint fk_usuario_avaliacao
		foreign key (cd_usuario)
			references tb_usuario(cd_usuario),
	-- estrangeira: entre servico e avaliacao
    constraint `fk_serviço_avaliação`
		foreign key (`cd_serviço`)
			references `tb_serviço`(`cd_serviço`))
CHARACTER SET utf8mb4;

-- tabela de denúncias
CREATE table IF NOT EXISTS `tb_denúncia`(
	-- atributos
    `cd_denúncia` INT UNSIGNED NOT NULL auto_increment, -- chave primaria
    `nm_denúncia` VARCHAR(45) NOT NULL,
    `ds_denúncia` VARCHAR(1200),
    ic_avaliado BOOLEAN NOT NULL DEFAULT 0,
    `dt_criação` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    cd_usuario INT UNSIGNED NOT NULL, -- chave estrangeira
	`cd_serviço` INT UNSIGNED NOT NULL, -- chave estrangeira
     -- definicao das chaves
    -- primaria
    constraint `pk_denúncia`
		primary key (`cd_denúncia`),
	-- estrangeira: entre usuario e denuncia
    constraint fk_usuario_denuncia
		foreign key (cd_usuario)
			references tb_usuario(cd_usuario),
	-- estrangeira: entre servico e denuncia
    constraint `fk_serviço_denúncia`
		foreign key (`cd_serviço`)
			references `tb_serviço`(`cd_serviço`))
CHARACTER SET utf8mb4;

-- tabela de pedido
CREATE table IF NOT EXISTS tb_pedido (
	-- atributos
	cd_pedido INT UNSIGNED NOT NULL auto_increment, -- chave primaria
	nm_pedido VARCHAR(45) NOT NULL,
	ds_pedido VARCHAR(200) NOT NULL,
	ic_cancelado BOOLEAN NOT NULL DEFAULT 0, -- verifica cancelamento, se nao foi cancelado, o default é falso
	vl_pedido DECIMAL(10,2) NOT NULL,
	ds_resposta VARCHAR(100),
	cd_serviço INT UNSIGNED NOT NULL, -- chave estrangeira
	-- definicao das chaves
    -- primaria
	constraint pk_pedido
		primary key (`cd_pedido`),
	-- chave estrangeira
	constraint fk_serviço_pedido
		foreign key (`cd_serviço`)
			references `tb_serviço` (`cd_serviço`))
CHARACTER SET utf8mb4;

-- tabela imagem
CREATE table IF NOT EXISTS tb_imagem (
	-- atributos
	cd_imagem INT  NOT NULL auto_increment, -- chave primaria
	cd_url_serviço VARCHAR(300) NOT NULL,
	`cd_serviço` INT UNSIGNED NOT NULL, -- chave estrangeira
    -- definicao das chaves
    -- primaria
    constraint pk_imagem
		primary key (cd_imagem),
	-- cd_serviço como chave única para garantir relacionamento um pra um
    constraint `un_cd_serviço`
		unique index (`cd_serviço`),
	-- chave estrangeira
	constraint `fk_serviço_imagem`
		foreign key (`cd_serviço`)
			references `tb_serviço` (`cd_serviço`))
CHARACTER SET utf8mb4;

-- tabela produto
CREATE table IF NOT EXISTS tb_produto (
	-- atributos
	cd_produto INT UNSIGNED NOT NULL auto_increment,
	nm_produto VARCHAR(45) NOT NULL,
	im_produto LONGBLOB NOT NULL,
	`dt_criação` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	cd_pedido INT UNSIGNED NOT NULL,
    -- definicao das chaves
    -- primaria
    constraint pk_produto
		primary key (cd_produto),
	-- cd_pedido como chave única para garantir relacionamento 1 pra 1
	constraint un_produto_pedido
		unique index (cd_pedido),
	-- chave estrangeira
	constraint fk_pedido_produto
		foreign key (cd_pedido)
			references tb_pedido (cd_pedido))
CHARACTER SET utf8mb4;

-- tabela pagamento
CREATE table IF NOT EXISTS tb_pagamento (
	-- atributos
	cd_pagamento INT UNSIGNED NOT NULL auto_increment,
	cd_status INT UNSIGNED NOT NULL,
	cd_produto INT UNSIGNED NOT NULL,
	cd_usuario INT UNSIGNED NOT NULL,
    vl_pagamento DECIMAL(10,2) NOT NULL,
	`dt_criação` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- definicao das chaves
    -- primaria
    constraint pk_pagamento
	  primary key (cd_pagamento),
	-- produto como chave unica para garantir 1 pra 1
    constraint un_pagamento_produto
		unique index (cd_produto),
	-- estrangeira: status para pagamento
	constraint fk_status_pagamento_pagamento
		foreign key (cd_status)
			references tb_status_pagamento (cd_status),
	-- estrangeira: produto para pagamento
	constraint fk_produto_pagamento
		foreign key (cd_produto)
			references tb_produto (cd_produto),
	-- estrangeira: usuario para pagamento
	constraint fk_usuario_pagamento
		foreign key (cd_usuario)
			references tb_usuario (cd_usuario))
CHARACTER SET utf8mb4;

INSERT INTO tb_login (nm_email, nm_username, nm_senha, ic_is_administrador) VALUES ("kamaleaoctt@gmail.com", "administrador", "GabrielzinhoLindo1012", 1), ("carolsenase@gmail.com", "carolina", "PokemonGo", 0), ("gabrielmunizpinto@hotmail.com", "gabriel", "10122003", 0), ("victinho771@gmail.com", "Victor", "Victinho15", 0), ("lucascomercial199@outlook.com", "cachorrospunk", "cachorros123", 0);

INSERT INTO tb_usuario (nm_nome, nm_sobrenome, cd_cpf, dt_nascimento, cd_login) VALUES ("Carolina", "Senha", "43200368337", "2004-08-14", 2), ("Gabriel", "Muniz", "57184892038", "2003-12-10", 3), ("Victor", "Dias Eugênio", "51885494851", "2004-01-15", 4), ("Lucas", "Ribeiro", "23075351865", "2004-03-24", 5);

INSERT INTO tb_tipos_licença (nm_licença) VALUES ("Não-Comercial"), ("Comercial"), ("Download");

INSERT INTO tb_categoria (nm_categoria) VALUES ("Sem Categoria"), ("Arte Digital"), ("Design"), ("Logos"), ("Concept Art");
