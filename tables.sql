create table colors
(
    id int auto_increment,
    name varchar(255) default null null,
    r int default null null,
    g int default null null,
    b int default null null,
    savedate datetime default NOW() null,
    constraint colors_pk
        primary key (id)
);

