-- ===============================================================
-- TABLE/SEQUENCE Cliente
-- ===============================================================

CREATE SEQUENCE cliente_seq;

CREATE TABLE cliente (
    id_cliente INTEGER NOT NULL,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(100) NOT NULL,
    cpf VARCHAR(11),
    dt_inclusao TIMESTAMP NOT NULL,
    dt_alteracao TIMESTAMP,
    CONSTRAINT pk_cliente PRIMARY KEY (id_cliente)
);

ALTER SEQUENCE cliente_seq OWNED BY cliente.id_cliente;

-- ===============================================================
-- TABLE Tipo de Contato
-- ===============================================================

CREATE TABLE tipo_contato (
    id_tipo_contato INTEGER NOT NULL,
    descricao VARCHAR(150) NOT NULL,
    CONSTRAINT pk_tipo_contato PRIMARY KEY (id_tipo_contato)
);

-- ===============================================================
-- TABLE/SEQUENCE Contato
-- ===============================================================

CREATE SEQUENCE contato_seq;

CREATE TABLE contato (
    id_contato INTEGER NOT NULL,
    id_tipo_contato INTEGER NOT NULL,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(100),
    apelido VARCHAR(100),
    site VARCHAR(150),
    numero VARCHAR(11) NOT NULL,
    dt_inclusao TIMESTAMP NOT NULL,
    dt_alteracao TIMESTAMP,
    st_ativo BOOLEAN NOT NULL,
    CONSTRAINT pk_contato PRIMARY KEY (id_contato)
);

ALTER SEQUENCE contato_seq OWNED BY contato.id_contato;

-- ===============================================================
-- CONSTRAINT
-- ===============================================================

ALTER TABLE contato ADD CONSTRAINT fk_contato_01
FOREIGN KEY (id_tipo_contato)
REFERENCES tipo_contato (id_tipo_contato)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

-- ===============================================================
-- INSERTS
-- ===============================================================

INSERT INTO public.tipo_contato(id_tipo_contato, descricao) VALUES (1, 'Família');
INSERT INTO public.tipo_contato(id_tipo_contato, descricao) VALUES (2, 'Trabalho');
INSERT INTO public.tipo_contato(id_tipo_contato, descricao) VALUES (3, 'Amigos');
INSERT INTO public.tipo_contato(id_tipo_contato, descricao) VALUES (4, 'Outros');