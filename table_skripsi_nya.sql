create table login (
    id int(14) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email varchar(20) NULL,
    username varchar(15) NULL,
    password varchar(15) NULL,
    level_id enum('1', '2', '3') -- tata usaha
    crated_at datetime NULL,
    updated_at datetime NULL
);
create table jadwal(
    id int(15) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    mapel_id int(14) NULL,
    kelas_id int(14) NULL,
    pertemuan int(14) NULL,
    sesi int(15) NULL,
    jumlah_siswa int(14) NULL,
    guru_id int(14) NULL, 
    crated_at datetime NULL,
    updated_at datetime NULL,
    user_id int(14) NULL
);
create table presensi(
    id int(15) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_siswa int(14) NOT NULL,
    jadwal_id int(14) NOT NULL,
    jam int(14) NOT NULL,
    status enum('H', 'I', 'S', 'TK') NULL, 
    guru_id int(14) NULL,
    crated_at datetime NULL,
    updated_at datetime NULL,
    user_id int(14) NULL
);