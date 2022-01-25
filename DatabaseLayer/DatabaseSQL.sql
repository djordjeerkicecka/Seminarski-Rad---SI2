CREATE DATABASE `PrijemniIspit`;

CREATE TABLE `PrijemniIspit`.`Korisnik` (
    KorisnikID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    KorisnikUsername varchar(50) NOT NULL UNIQUE, 
    KorisnikPassword varchar(50) NOT NULL,
    KorisnikIme varchar(30) NOT NULL,
    KorisnikPrezime varchar(30) NOT NULL,
    KorisnikStatus varchar(15) NOT NULL
);

CREATE TABLE `PrijemniIspit`.`Ispit` (
    IspitID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    IspitSifra varchar(6) NOT NULL UNIQUE,
    IspitPredmet varchar(30) NOT NULL,
    IspitRok varchar(30) NOT NULL,
    IspitDatum date NOT NULL,
    IspitVreme time NOT NULL,
    IspitKapacitet int NOT NULL
);

CREATE TABLE `PrijemniIspit`.`Kandidat` (
    KandidatID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    KandidatJMBG char(13) NOT NULL,
    KandidatIme varchar(30) NOT NULL,
    KandidatPrezime varchar(30) NOT NULL,
    DatumRodjenja date NOT NULL,
    KandidatAdresa varchar(50) NOT NULL,
    KandidatBodovi int NULL,
    PrijemniID int NOT NULL,
    FOREIGN KEY (PrijemniID) 
        REFERENCES `PrijemniIspit`.`Ispit` (IspitID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    KandidatPolozio BOOL NULL
);

INSERT INTO `PrijemniIspit`.`Korisnik` (KorisnikUsername, KorisnikPassword, KorisnikIme, KorisnikPrezime, KorisnikStatus) VALUES ("djole", "123", "Đorđe", "Erkić", "admin");
INSERT INTO `PrijemniIspit`.`Korisnik` (KorisnikUsername, KorisnikPassword, KorisnikIme, KorisnikPrezime, KorisnikStatus) VALUES ("korisnik", "123", "Nikola", "Nikolic", "user");
INSERT INTO `PrijemniIspit`.`Korisnik` (KorisnikUsername, KorisnikPassword, KorisnikIme, KorisnikPrezime, KorisnikStatus) VALUES ("profesor", "123", "Stefan", "Stefanovic", "prof");

INSERT INTO `PrijemniIspit`.`Ispit` (IspitSifra, IspitPredmet, IspitRok, IspitDatum, IspitVreme, IspitKapacitet) VALUES ("OS3B14", "Mathematics", "June", "2019-6-19", "12:00:00", "90");
INSERT INTO `PrijemniIspit`.`Ispit` (IspitSifra, IspitPredmet, IspitRok, IspitDatum, IspitVreme, IspitKapacitet) VALUES ("A4B31A", "Informatics", "September", "2018-8-23", "09:00:00", "80");

INSERT INTO `PrijemniIspit`.`Kandidat` (KandidatJMBG, KandidatIme, KandidatPrezime, DatumRodjenja, KandidatAdresa, KandidatBodovi, PrijemniID, KandidatPolozio) VALUES ("1113335556668", "Nikola", "Nikolic", "1999-12-12", "Pupinova 12", "50", "1", true);
INSERT INTO `PrijemniIspit`.`Kandidat` (KandidatJMBG, KandidatIme, KandidatPrezime, DatumRodjenja, KandidatAdresa, KandidatBodovi, PrijemniID, KandidatPolozio) VALUES ("2224446668889", "Marko", "Markovic", "1998-2-24", "Osmanska 25", "6", "1", false);
INSERT INTO `PrijemniIspit`.`Kandidat` (KandidatJMBG, KandidatIme, KandidatPrezime, DatumRodjenja, KandidatAdresa, KandidatBodovi, PrijemniID, KandidatPolozio) VALUES ("3335557779991", "Petar", "Petrovic", "2000-1-15", "Beogradska 19", "100", "2", true);