ALTER TABLE administrator DROP column receive_messages_flag;

ALTER TABLE administrator ADD column avatar varchar(255);

ALTER TABLE content ADD column keywords varchar(255);
ALTER TABLE content ADD column creator_id int(11);
UPDATE content set creator_id = 2;

ALTER TABLE category ADD column creator_id int(11);
UPDATE category SET creator_id = 1;

ALTER TABLE administrator_session ADD column browser varchar(255);
ALTER TABLE administrator_session ADD column operating_system varchar(255);

UPDATE content_type_field SET type='file' WHERE type='media';
