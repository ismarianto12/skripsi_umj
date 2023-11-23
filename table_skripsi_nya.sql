create table login (
    id int(14) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email varchar(20) NULL,
    username varchar(15) NULL,
    password varchar(15) NULL,
    level_id enum('1', '2', '3') -- tata usaha
    crated_at datetime NULL,
    updated_at datetime NULL
);

create table presensi(
    id int(15) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    siswa_id int(14) NOT NULL,
    jadwal_id int(15) NULL,
    status enum('H', 'I', 'S', 'TK') NULL,
    pertemuan_ke int(14) NOT NULL,
    crated_at datetime NULL,
    updated_at datetime NULL,
    user_id int(14) NULL
);


