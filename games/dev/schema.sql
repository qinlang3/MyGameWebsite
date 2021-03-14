drop table appuser cascade;

create table appuser (
	userid varchar(50) primary key,
	password varchar(50),
	email varchar(50),
	gender varchar(20),
	area varchar(20),
	guessnum int,
	guesswon int,
	rpsplayer int,
	rpscomp int,
	frogsnum int,
	frogswon int
);

insert into appuser (userid, password, guessnum, guesswon, rpsplayer, rpscomp, frogsnum, frogswon) values('auser', 'apassword', 0, 0, 0, 0, 0, 0);

