create database hm1_1000001861;
use hm1_1000001861;
create table Account
(
	id_acc integer AUTO_INCREMENT primary key,
    email varchar(255) unique not null,
    username varchar(255) unique not null,
    hashed_p varchar(255) not null,
    reg_date date not null,
    last_access datetime not null,
    profile_photo varchar(255),
    end_date_ban date
);

create table Categoria
(
	id_cat integer AUTO_INCREMENT primary key,
    nome varchar(255) unique not null
);

create table Thread
(
	id_th integer AUTO_INCREMENT primary key,
    titolo varchar(255) not null,
    id_creatore integer not null,
    FOREIGN KEY (id_creatore) REFERENCES account(id_acc),
    index idx_creatore(id_creatore)
);

create table posts
(
	post_id integer AUTO_INCREMENT primary key,
	id_autore integer not null,
	id_th integer not null,
    n_ordine integer not null,
	data_creazione date not null,
    contenuto text not null,
    likes integer default 0,
    FOREIGN key (id_th) REFERENCES Thread(id_th),
    FOREIGN key (id_autore) REFERENCES account(id_acc),
    index idx_thread(id_th),
    index idx_autore(id_autore)
);

create table Th_Ca
(
	id_th integer not null,
    categoria integer not null,
    FOREIGN key (id_th) REFERENCES Thread(id_th),
    FOREIGN key (categoria) REFERENCES categoria(id_cat),
    primary key (id_th, categoria),
    index idx_thread(id_th),
    index idx_cat(categoria)
);

create table likes(
	id_acc integer not null,
	post_id integer not null,
	FOREIGN key (id_acc) REFERENCES account(id_acc),
    FOREIGN key (post_id) REFERENCES posts(post_id),
    primary key (id_acc, post_id),
    index idx_acc(id_acc),
    index idx_posts(post_id)
);


DELIMITER //
CREATE PROCEDURE createTopic(IN title varchar(255), IN body text, IN author integer)
BEGIN
	INSERT INTO thread(id_th, titolo, id_creatore) VALUES(NULL, title, author);
    
    SET @id = ( SELECT max(id_th)
				FROM thread T
				WHERE T.titolo = title AND T.id_creatore = author );
    INSERT INTO posts(post_id, id_autore, id_th, n_ordine, data_creazione, contenuto, likes) VALUES(NULL, author, @id, 0, CURDATE(), body, 0);
    SET @id = NULL;
    
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE addCategoryToTopic(IN thread integer, IN categoria varchar(255))
BEGIN
	SET @id = (	SELECT id_cat
				FROM categoria C
				Where C.nome = categoria );
	if @id is null then
		INSERT INTO categoria(id_cat, nome) VALUES(NULL, categoria);
        SET @id = ( SELECT id_cat
					FROM categoria C
					WHERE C.nome = categoria );
    end if;
    
	INSERT INTO th_ca(id_th, categoria) VALUES(thread, @id);
    SET @id = NULL;
    
END //
DELIMITER ;

delimiter //
CREATE TRIGGER addLike
AFTER INSERT
ON likes FOR EACH ROW
begin
	UPDATE posts
	SET likes = likes + 1
	WHERE NEW.post_id = post_id;
end //
DELIMITER ;
delimiter //
CREATE TRIGGER removeLike
AFTER DELETE
ON likes FOR EACH ROW
begin
	UPDATE posts
	SET likes = likes - 1
	WHERE OLD.post_id = post_id;
end //
delimiter ;