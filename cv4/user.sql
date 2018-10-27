create table user
(
  id          int auto_increment
    primary key,
  username    varchar(100) null,
  password    varchar(100) null,
  email       varchar(100) null,
  description varchar(300) null,
  created     datetime     null
);


