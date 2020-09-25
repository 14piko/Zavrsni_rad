#c:\xampp\mysql\bin\mysql -uedunova -pedunova < c:\PP21\ribickaudruga.sql

create table operater(
sifra int not null primary key auto_increment,
email varchar(50) not null,
lozinka char(60) not null,
ime varchar(50) not null,
prezime varchar(50) not null,
uloga varchar(10) not null
);

# admin@edunova.hr a 
# oper@edunova o
insert into operater(email,lozinka,ime,prezime,uloga) values
('oper@edunova.hr','$2y$10$RYiO37mfXGodsKPfHdF4bOPAfnkav.XAXxEC89kABZZheyGcqBs9K','Operater','Edunova','oper'),
('admin@edunova.hr','$2y$10$Nsg4inxHgYub/2pGFSN8Mepfjp1e5m7nXBurTF97e9mn50TD3.Dra','Admin','Edunova','admin');


create table clanudruge(
sifra int not null primary key auto_increment,
ime varchar(50) not null,
prezime varchar(50) not null,
oib char(11),
brojdozvole char(6)
);

create table riba(
sifra int not null primary key auto_increment,
naziv varchar(50) not null,
pocetaklovostaja date not null,
krajlovostaja date not null,
opis text
);

create table rijeka(
sifra int not null primary key auto_increment,
naziv varchar(50) not null,
duzina varchar(50) not null
);

create table pecanje(
sifra int not null primary key auto_increment,
datum date not null,
clanudruge int not null,
riba int not null,
kolicina int,
tezina decimal(18,3),
rijeka int not null
);


#vanjski ključevi

alter table pecanje add foreign key (rijeka) references rijeka(sifra);
alter table pecanje add foreign key (clanudruge) references clanudruge(sifra);
alter table pecanje add foreign key (riba) references riba(sifra);


select * from clanudruge;
select * from riba;
select * from rijeka;
select * from pecanje;


insert into clanudruge (ime,prezime,oib,brojdozvole) values
('Mirko','Ereš','68764300996','032546'),
('Katarina','Herceg','58462135789','324568');

insert into rijeka (naziv,duzina) values
('Biđ','37km'),
('Bosut','186km');

insert into riba (naziv,pocetaklovostaja,krajlovostaja,opis) values
('Šaran','2020-05-01','2020-05-31','Krupna ljuska,brkovi,žut trbuh'),
('Smuđ','2020-05-01','2020-05-31','Sitna ljuska,oštri zubi,žut trbuh'),
('Štuka','2020-05-01','2020-05-31','Sitna ljuska,oštri zubi,žut trbuh'),
('Som','2020-05-01','2020-05-31','Sitna ljuska,oštri zubi,žut trbuh');


insert into pecanje (datum,clanudruge,riba,kolicina,tezina,rijeka) values
('2020-06-01',(1),(1),'3',2.55+3.00+3.40,(1)),
('2020-07-01',(2),(2),'2',2.30+3.22,(2));







