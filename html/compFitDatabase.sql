DROP DATABASE IF EXISTS compfit;

CREATE DATABASE compfit;

USE compfit;

CREATE TABLE users
(
  user_id INT NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(20),
  last_name VARCHAR(20),
  username VARCHAR(20),
  email VARCHAR(255),
  password VARCHAR(64),
  salt VARCHAR(64),
  avatar VARCHAR(255) NOT NULL,
  created VARCHAR(19),
  last_login VARCHAR(19),
  token CHAR(16) NULL,
  token_expire DATETIME NULL,
  PRIMARY KEY(user_id)
);

CREATE TABLE teams
(
  team_id INT NOT NULL AUTO_INCREMENT,
  team_name VARCHAR(20),
  captain_id INT,
  avatar VARCHAR (255) NOT NULL,
  team_color VARCHAR(6),
  created VARCHAR(19),
  PRIMARY KEY(team_id),
  FOREIGN KEY(captain_id) REFERENCES users(user_id)
);

CREATE TABLE team_participation
(
  team_participation_id INT NOT NULL AUTO_INCREMENT,
  team_id INT,
  user_id INT,
  created VARCHAR(19),
  PRIMARY KEY(team_participation_id),
  FOREIGN KEY(team_id) REFERENCES teams(team_id),
  FOREIGN KEY(user_id) REFERENCES users(user_id)
);

CREATE TABLE challenges
(
  challenge_id INT NOT NULL AUTO_INCREMENT,
  start_date  DATE,
  end_date  DATE,
  to_team_id  INT,
  from_team_id  INT,
  task_name VARCHAR(40),
  repetitions FLOAT,
  units VARCHAR(20),
  task_type VARCHAR(20),
  status  VARCHAR(20) DEFAULT 'OPEN',
  created VARCHAR(19),
  PRIMARY KEY(challenge_id),
  FOREIGN KEY(to_team_id) REFERENCES teams(team_id),
  FOREIGN KEY(from_team_id) REFERENCES teams(team_id)
);

CREATE TABLE exercise_list
(
  exercise_list_id INT NOT NULL AUTO_INCREMENT,
  exercise_name VARCHAR(40),
  units VARCHAR(20) DEFAULT 'repetitions',
  PRIMARY KEY(exercise_list_id)
);

CREATE TABLE exercises
(
  exercise_id INT NOT NULL AUTO_INCREMENT,
  user_id INT,
  date_completed DATE,
  exercise_name VARCHAR(40),
  repetitions FLOAT,
  units VARCHAR(20),
  created VARCHAR(19),
  PRIMARY KEY(exercise_id),
  FOREIGN KEY(user_id) REFERENCES users(user_id)
  #FOREIGN KEY(exercise_name) REFERENCES exercise_list(exercise_name)
);

CREATE TABLE individual_progress
(
  individual_progress_id INT NOT NULL AUTO_INCREMENT,
  team_id INT,
  user_id INT,
  challenge_id  INT,
  exercise_id INT,
  exercise_name VARCHAR(40),
  repetitions FLOAT,
  units VARCHAR(20),
  date_completed DATE,
  created VARCHAR(19),
  PRIMARY KEY(individual_progress_id),
  FOREIGN KEY(user_id) REFERENCES users(user_id),
  FOREIGN KEY(team_id) REFERENCES teams(team_id),
  FOREIGN KEY(exercise_id) REFERENCES exercises(exercise_id),
  FOREIGN KEY(challenge_id) REFERENCES challenges(challenge_id)
  #FOREIGN KEY(exercise_name) REFERENCES exercise_list(exercise_name)
);

CREATE TABLE challenge_progress
(
  challenge_progress_id INT NOT NULL AUTO_INCREMENT,
  team_id INT,
  challenge_id  INT,
  exercise_name VARCHAR(40),
  repetitions FLOAT,
  units VARCHAR(20),
  status VARCHAR(20) DEFAULT 'ONGOING',
  created VARCHAR(19),
  PRIMARY KEY(challenge_progress_id),
  FOREIGN KEY(challenge_id) REFERENCES challenges(challenge_id),
  FOREIGN KEY(team_id) REFERENCES teams(team_id)
  #FOREIGN KEY(exercise_name) REFERENCES exercise_list(exercise_name)
);


CREATE TABLE units
(
  unit_id INT NOT NULL AUTO_INCREMENT,
  unit_name VARCHAR(20),
  exercise_list_id INT,
  PRIMARY KEY(unit_id),
  FOREIGN KEY(exercise_list_id) REFERENCES exercise_list(exercise_list_id)
);

INSERT INTO users (first_name, last_name, username, email, password, salt, avatar) VALUES ('Mary Charles', 'Porter', 'marycharles', 'mcharles@gmail.com', '$2a$10$7Rzo9kUMhYlij9tT4uwFkeRwmkWVyLskALKW\/ogsgtbd.TS.sHB0e', '$2a$10$7Rzo9kUMhYlij9tT4uwFkg==', '/img/user_avatars/basic_avatar0.png');
INSERT INTO users (first_name, last_name, username, email, password, avatar) VALUES ('Gabe', 'Vargas', 'gvargas', 'gvargas@urmom.com', 'EirXgVZzZcA', '/img/user_avatars/basic_avatar1.png');
insert into users (first_name, last_name, email, password, avatar, username) values ('Annie', 'Allen', 'aallen0@accuweather.com', 'GZq0qt2VL', '/img/user_avatars/basic_avatar0.png', 'aallen0');
insert into users (first_name, last_name, email, password, avatar, username) values ('Fred', 'Hicks', 'fhicks1@edublogs.org', 'IDHOvLjkY8', '/img/user_avatars/basic_avatar1.png', 'fhicks1');
insert into users (first_name, last_name, email, password, avatar, username) values ('Ruth', 'Frazier', 'rfrazier2@bing.com', 'BP35m3sGJj', '/img/user_avatars/basic_avatar2.png', 'rfrazier2');
insert into users (first_name, last_name, email, password, avatar, username) values ('Laura', 'Moore', 'lmoore3@buzzfeed.com', 'EorXgDZzMcA', '/img/user_avatars/basic_avatar3.png', 'lmoore3');
insert into users (first_name, last_name, email, password, avatar, username) values ('Wanda', 'Price', 'wprice4@usgs.gov', 'nVeA2UNc5h1', '/img/user_avatars/basic_avatar4.png', 'wprice4');
insert into users (first_name, last_name, email, password, avatar, username) values ('Rebecca', 'Torres', 'rtorres5@msu.edu', 'TEpO7nrChBA', '/img/user_avatars/basic_avatar5.png', 'rtorres5');
insert into users (first_name, last_name, email, password, avatar, username) values ('Virginia', 'Bailey', 'vbailey6@princeton.edu', 'V4bSeJNO', '/img/user_avatars/basic_avatar6.png', 'vbailey6');
insert into users (first_name, last_name, email, password, avatar, username) values ('Ruth', 'Harper', 'rharper7@dell.com', 'xRAVdkH9', '/img/user_avatars/basic_avatar7.png', 'rharper7');
insert into users (first_name, last_name, email, password, avatar, username) values ('Russell', 'Garrett', 'rgarrett8@bigcartel.com', 'IibF6kDQq', '/img/user_avatars/basic_avatar8.png', 'rgarrett8');
insert into users (first_name, last_name, email, password, avatar, username) values ('Henry', 'Medina', 'hmedina9@mediafire.com', 'LI1LvMSprtL', '/img/user_avatars/basic_avatar9.png', 'hmedina9');
insert into users (first_name, last_name, email, password, avatar, username) values ('Bobby', 'Hall', 'bhalla@boston.com', 'ypRCDJa24', '/img/user_avatars/basic_avatar10.png', 'bhalla');
insert into users (first_name, last_name, email, password, avatar, username) values ('Phyllis', 'Kelley', 'pkelleyb@state.tx.us', 'oh7UXx', '/img/user_avatars/basic_avatar11.png', 'pkelleyb');
insert into users (first_name, last_name, email, password, avatar, username) values ('Rebecca', 'Kennedy', 'rkennedyc@rediff.com', 'vNgwOk9EuqM', '/img/user_avatars/basic_avatar0.png', 'rkennedyc');
insert into users (first_name, last_name, email, password, avatar, username) values ('Wanda', 'Fowler', 'wfowlerd@lulu.com', 'TdemKPVjqCQ', '/img/user_avatars/basic_avatar1.png', 'wfowlerd');
insert into users (first_name, last_name, email, password, avatar, username) values ('Kathleen', 'Garza', 'kgarzae@parallels.com', 'Q0C0DiHepe', '/img/user_avatars/basic_avatar2.png', 'kgarzae');
insert into users (first_name, last_name, email, password, avatar, username) values ('George', 'Thomas', 'gthomasf@feedburner.com', '300bFUH2ZDY', '/img/user_avatars/basic_avatar3.png', 'gthomasf');
insert into users (first_name, last_name, email, password, avatar, username) values ('Carl', 'Wagner', 'cwagnerg@printfriendly.com', '1a0t3GhL', '/img/user_avatars/basic_avatar4.png', 'cwagnerg');
insert into users (first_name, last_name, email, password, avatar, username) values ('Sara', 'Johnson', 'sjohnsonh@taobao.com', 'qOWytzCmZ', '/img/user_avatars/basic_avatar5.png', 'sjohnsonh');
insert into users (first_name, last_name, email, password, avatar, username) values ('Jean', 'Perez', 'jperezi@apple.com', 'P5DoAP', '/img/user_avatars/basic_avatar6.png', 'jperezi');
insert into users (first_name, last_name, email, password, avatar, username) values ('Jason', 'Bennett', 'jbennettj@noaa.gov', 'mr8sEMHZty', '/img/user_avatars/basic_avatar7.png', 'jbennettj');
insert into users (first_name, last_name, email, password, avatar, username) values ('Alice', 'Gordon', 'agordonk@google.ru', 'Bs8ciP13', '/img/user_avatars/basic_avatar8.png', 'agordonk');
insert into users (first_name, last_name, email, password, avatar, username) values ('Scott', 'Wallace', 'swallacel@goodreads.com', 'sJRE3KhafoSa', '/img/user_avatars/basic_avatar9.png', 'swallacel');
insert into users (first_name, last_name, email, password, avatar, username) values ('Jacqueline', 'Clark', 'jclarkm@bloglines.com', 'KdAGRD', '/img/user_avatars/basic_avatar10.png', 'jclarkm');
insert into users (first_name, last_name, email, password, avatar, username) values ('Anna', 'Green', 'agreenn@chron.com', 'jIAn83KPL', '/img/user_avatars/basic_avatar11.png', 'agreenn');
insert into users (first_name, last_name, email, password, avatar, username) values ('Catherine', 'Richardson', 'crichardsono@sfgate.com', 'R0pLaCvUC', '/img/user_avatars/basic_avatar0.png', 'crichardsono');
insert into users (first_name, last_name, email, password, avatar, username) values ('Johnny', 'Duncan', 'jduncanp@census.gov', '86sE5SsPlp3q', '/img/user_avatars/basic_avatar1.png', 'jduncanp');
insert into users (first_name, last_name, email, password, avatar, username) values ('Joyce', 'Watson', 'jwatsonq@cloudflare.com', 'juNRGy', '/img/user_avatars/basic_avatar2.png', 'jwatsonq');
insert into users (first_name, last_name, email, password, avatar, username) values ('Patrick', 'Garcia', 'pgarciar@bizjournals.com', 'Rbx1Ke', '/img/user_avatars/basic_avatar3.png', 'pgarciar');
insert into users (first_name, last_name, email, password, avatar, username) values ('Beverly', 'Turner', 'bturners@oakley.com', 'Aqz1sAj', '/img/user_avatars/basic_avatar4.png', 'bturners');
insert into users (first_name, last_name, email, password, avatar, username) values ('Irene', 'Walker', 'iwalkert@microsoft.com', '4ZQhzkuDr7v', '/img/user_avatars/basic_avatar5.png', 'iwalkert');
insert into users (first_name, last_name, email, password, avatar, username) values ('Kathryn', 'Powell', 'kpowellu@canalblog.com', 'RZNroXOb3', '/img/user_avatars/basic_avatar6.png', 'kpowellu');
insert into users (first_name, last_name, email, password, avatar, username) values ('Jesse', 'Larson', 'jlarsonv@ovh.net', 'ZUyUUys', '/img/user_avatars/basic_avatar7.png', 'jlarsonv');
insert into users (first_name, last_name, email, password, avatar, username) values ('George', 'Reed', 'greedw@google.cn', 'R5tnXAD5na', '/img/user_avatars/basic_avatar8.png', 'greedw');
insert into users (first_name, last_name, email, password, avatar, username) values ('Christina', 'Day', 'cdayx@indiatimes.com', 'fLYYFgI7Sy', '/img/user_avatars/basic_avatar9.png', 'cdayx');
insert into users (first_name, last_name, email, password, avatar, username) values ('Kelly', 'Moreno', 'kmorenoy@hexun.com', 'QIRVyjy', '/img/user_avatars/basic_avatar10.png', 'kmorenoy');
insert into users (first_name, last_name, email, password, avatar, username) values ('David', 'Gutierrez', 'dgutierrezz@scientificamerican.com', 'AW2YUtY', '/img/user_avatars/basic_avatar11.png', 'dgutierrezz');
insert into users (first_name, last_name, email, password, avatar, username) values ('Michael', 'Day', 'mday10@newyorker.com', 'EsGojX', '/img/user_avatars/basic_avatar0.png', 'mday10');
insert into users (first_name, last_name, email, password, avatar, username) values ('Carl', 'Johnson', 'cjohnson11@blog.com', 'Ep3OCnXcgO', '/img/user_avatars/basic_avatar1.png', 'cjohnson11');
insert into users (first_name, last_name, email, password, avatar, username) values ('Frances', 'Mason', 'fmason12@liveinternet.ru', 'M3dhmuphA', '/img/user_avatars/basic_avatar2.png', 'fmason12');
insert into users (first_name, last_name, email, password, avatar, username) values ('Steve', 'Gordon', 'sgordon13@merriam-webster.com', 'LBHzuXrOS', '/img/user_avatars/basic_avatar3.png', 'sgordon13');


insert into users (first_name, last_name, email, password, avatar, username) values ('Alan', 'Carter', 'acarter0@java.com', '0VKA1kJ9gm', '/img/user_avatars/basic_avatar0.png', 'acarter0');
insert into users (first_name, last_name, email, password, avatar, username) values ('Evelyn', 'Gray', 'egray1@bloglovin.com', 'i8A0uuOtgKv', '/img/user_avatars/basic_avatar1.png', 'egray1');
insert into users (first_name, last_name, email, password, avatar, username) values ('Louis', 'Bryant', 'lbryant2@ftc.gov', 'lVCmUipnm', '/img/user_avatars/basic_avatar2.png', 'lbryant2');
insert into users (first_name, last_name, email, password, avatar, username) values ('Robin', 'Phillips', 'rphillips3@e-recht24.de', 'FAeXTR0Ko1Xd', '/img/user_avatars/basic_avatar3.png', 'rphillips3');
insert into users (first_name, last_name, email, password, avatar, username) values ('Louise', 'Gutierrez', 'lgutierrez4@slashdot.org', 'HfEtSAy', '/img/user_avatars/basic_avatar4.png', 'lgutierrez4');
insert into users (first_name, last_name, email, password, avatar, username) values ('Ashley', 'Hughes', 'ahughes5@a8.net', 'yQGmxGkbtv0j', '/img/user_avatars/basic_avatar5.png', 'ahughes5');
insert into users (first_name, last_name, email, password, avatar, username) values ('Chris', 'Ramirez', 'cramirez6@hud.gov', '5FTND9', '/img/user_avatars/basic_avatar6.png', 'cramirez6');
insert into users (first_name, last_name, email, password, avatar, username) values ('Kelly', 'Wagner', 'kwagner7@slashdot.org', '5QF5fid', '/img/user_avatars/basic_avatar7.png', 'kwagner7');
insert into users (first_name, last_name, email, password, avatar, username) values ('Stephanie', 'Marshall', 'smarshall8@irs.gov', 'ZvmznlCst', '/img/user_avatars/basic_avatar8.png', 'smarshall8');
insert into users (first_name, last_name, email, password, avatar, username) values ('Paul', 'Fisher', 'pfisher9@springer.com', 'm1sHGGKqVo', '/img/user_avatars/basic_avatar9.png', 'pfisher9');
insert into users (first_name, last_name, email, password, avatar, username) values ('Gerald', 'Elliott', 'gelliotta@purevolume.com', 'VVI1sumSp', '/img/user_avatars/basic_avatar10.png', 'gelliotta');
insert into users (first_name, last_name, email, password, avatar, username) values ('Kathleen', 'Webb', 'kwebbb@addthis.com', 'ZYugrLIpCMk', '/img/user_avatars/basic_avatar11.png', 'kwebbb');
insert into users (first_name, last_name, email, password, avatar, username) values ('Cheryl', 'Oliver', 'coliverc@digg.com', 'oHuX9huhjh', '/img/user_avatars/basic_avatar0.png', 'coliverc');
insert into users (first_name, last_name, email, password, avatar, username) values ('Jessica', 'Perez', 'jperezd@pcworld.com', 'qheNpe0a3', '/img/user_avatars/basic_avatar1.png', 'jperezd');
insert into users (first_name, last_name, email, password, avatar, username) values ('Jason', 'Ross', 'jrosse@meetup.com', 'Uq7IvDkG', '/img/user_avatars/basic_avatar2.png', 'jrosse');
insert into users (first_name, last_name, email, password, avatar, username) values ('Michael', 'Andrews', 'mandrewsf@intel.com', 'Jqf0lH', '/img/user_avatars/basic_avatar3.png', 'mandrewsf');
insert into users (first_name, last_name, email, password, avatar, username) values ('Paula', 'Ray', 'prayg@issuu.com', 'OeCPE8cV', '/img/user_avatars/basic_avatar4.png', 'prayg');
insert into users (first_name, last_name, email, password, avatar, username) values ('Kenneth', 'Snyder', 'ksnyderh@cbslocal.com', 'VlBn6D3UU', '/img/user_avatars/basic_avatar5.png', 'ksnyderh');
insert into users (first_name, last_name, email, password, avatar, username) values ('Sharon', 'Simmons', 'ssimmonsi@army.mil', 'Go7rH06', '/img/user_avatars/basic_avatar6.png', 'ssimmonsi');
insert into users (first_name, last_name, email, password, avatar, username) values ('Lillian', 'Reid', 'lreidj@boston.com', 'pnFJSe', '/img/user_avatars/basic_avatar7.png', 'lreidj');



INSERT INTO teams (team_name, captain_id, avatar) VALUES ('Tigers', '1', '/img/team_avatars/team_avatar_tiger.png');
INSERT INTO teams (team_name, captain_id, avatar) VALUES ('Ligers', '2', '/img/team_avatars/team_avatar_liger.png');
INSERT INTO teams (team_name, captain_id, avatar) VALUES ('Ligons', '2', '/img/team_avatars/team_avatar2.png');
INSERT INTO teams (team_name, captain_id, avatar) VALUES ('Lions', '2', '/img/team_avatars/team_avatar_lion.png');
INSERT INTO teams (team_name, captain_id, avatar) VALUES ('Sabertooths', '2', '/img/team_avatars/team_avatar4.png');
INSERT INTO teams (team_name, captain_id, avatar) VALUES ('Victorious Secret', '1', '/img/team_avatars/team_avatarvs.png');


insert into teams (team_name, captain_id, avatar) values ('Angels', 38, '/img/team_avatars/team_avatar_angel.png');
insert into teams (team_name, captain_id, avatar) values ('Demons', 37, '/img/team_avatars/team_avatar_demon.png');
insert into teams (team_name, captain_id, avatar) values ('Crybabys', 32, '/img/team_avatars/team_avatar8.png');
insert into teams (team_name, captain_id, avatar) values ('Cheetahs', 2, '/img/team_avatars/team_avatar9.png');
insert into teams (team_name, captain_id, avatar) values ('Panthers', 38, '/img/team_avatars/team_avatar10.png');
insert into teams (team_name, captain_id, avatar) values ('Sloths', 33, '/img/team_avatars/team_avatar11.png');
insert into teams (team_name, captain_id, avatar) values ('Titans', 18, '/img/team_avatars/team_avatar0.png');
insert into teams (team_name, captain_id, avatar) values ('Warriors', 7, '/img/team_avatars/team_avatar_warrior.png');
insert into teams (team_name, captain_id, avatar) values ('Bulls', 25, '/img/team_avatars/team_avatar_bull.png');
insert into teams (team_name, captain_id, avatar) values ('Bandits', 4, '/img/team_avatars/team_avatar_bandit.png');

insert into teams (team_name, captain_id, avatar) values ('Oklahomies', 43, '/img/team_avatars/team_avatar3.png');
insert into teams (team_name, captain_id, avatar) values ('Wii Not Fit', 47, '/img/team_avatars/team_avatar_wii.png');
insert into teams (team_name, captain_id, avatar) values ('Foo Fighters', 51, '/img/team_avatars/team_avatar_foo.png');
insert into teams (team_name, captain_id, avatar) values ('Devpool', 55, '/img/team_avatars/team_avatar7.png');
insert into teams (team_name, captain_id, avatar) values ('Thunder', 59, '/img/team_avatars/team_avatar9.png');


INSERT INTO team_participation (team_id, user_id)
VALUES ('1', '1');

insert into team_participation (team_id, user_id) values (1, 41);
insert into team_participation (team_id, user_id) values (1, 37);
insert into team_participation (team_id, user_id) values (1, 16);
insert into team_participation (team_id, user_id) values (1, 13);
insert into team_participation (team_id, user_id) values (1, 18);
insert into team_participation (team_id, user_id) values (1, 11);

insert into team_participation (team_id, user_id) values (2, 2);
insert into team_participation (team_id, user_id) values (2, 34);
insert into team_participation (team_id, user_id) values (2, 20);
insert into team_participation (team_id, user_id) values (2, 7);
insert into team_participation (team_id, user_id) values (2, 15);
insert into team_participation (team_id, user_id) values (2, 21);
insert into team_participation (team_id, user_id) values (2, 39);

insert into team_participation (team_id, user_id) values (3, 2);
insert into team_participation (team_id, user_id) values (3, 3);
insert into team_participation (team_id, user_id) values (3, 30);
insert into team_participation (team_id, user_id) values (3, 33);
insert into team_participation (team_id, user_id) values (3, 6);
insert into team_participation (team_id, user_id) values (3, 25);
insert into team_participation (team_id, user_id) values (3, 41);
insert into team_participation (team_id, user_id) values (3, 36);

insert into team_participation (team_id, user_id) values (4, 2);
insert into team_participation (team_id, user_id) values (4, 32);
insert into team_participation (team_id, user_id) values (4, 28);
insert into team_participation (team_id, user_id) values (4, 42);
insert into team_participation (team_id, user_id) values (4, 3);
insert into team_participation (team_id, user_id) values (4, 26);
insert into team_participation (team_id, user_id) values (4, 5);
insert into team_participation (team_id, user_id) values (4, 8);

insert into team_participation (team_id, user_id) values (5, 2);
insert into team_participation (team_id, user_id) values (5, 29);
insert into team_participation (team_id, user_id) values (5, 34);
insert into team_participation (team_id, user_id) values (5, 27);
insert into team_participation (team_id, user_id) values (5, 37);
insert into team_participation (team_id, user_id) values (5, 14);
insert into team_participation (team_id, user_id) values (5, 21);
insert into team_participation (team_id, user_id) values (5, 23);

insert into team_participation (team_id, user_id) values (6, 1);
insert into team_participation (team_id, user_id) values (6, 12);
insert into team_participation (team_id, user_id) values (6, 24);
insert into team_participation (team_id, user_id) values (6, 4);
insert into team_participation (team_id, user_id) values (6, 20);
insert into team_participation (team_id, user_id) values (6, 40);
insert into team_participation (team_id, user_id) values (6, 9);
insert into team_participation (team_id, user_id) values (6, 31);

insert into team_participation (team_id, user_id) values (7, 4);
insert into team_participation (team_id, user_id) values (7, 7);
insert into team_participation (team_id, user_id) values (7, 24);
insert into team_participation (team_id, user_id) values (7, 42);
insert into team_participation (team_id, user_id) values (7, 19);
insert into team_participation (team_id, user_id) values (7, 21);
insert into team_participation (team_id, user_id) values (7, 34);
insert into team_participation (team_id, user_id) values (7, 38);

insert into team_participation (team_id, user_id) values (8, 37);
insert into team_participation (team_id, user_id) values (8, 11);
insert into team_participation (team_id, user_id) values (8, 10);
insert into team_participation (team_id, user_id) values (8, 2);
insert into team_participation (team_id, user_id) values (8, 18);
insert into team_participation (team_id, user_id) values (8, 1);
insert into team_participation (team_id, user_id) values (8, 36);
insert into team_participation (team_id, user_id) values (8, 28);

insert into team_participation (team_id, user_id) values (9, 32);
insert into team_participation (team_id, user_id) values (9, 34);
insert into team_participation (team_id, user_id) values (9, 29);
insert into team_participation (team_id, user_id) values (9, 22);
insert into team_participation (team_id, user_id) values (9, 7);
insert into team_participation (team_id, user_id) values (9, 4);
insert into team_participation (team_id, user_id) values (9, 11);
insert into team_participation (team_id, user_id) values (9, 31);

insert into team_participation (team_id, user_id) values (10, 2);
insert into team_participation (team_id, user_id) values (10, 3);
insert into team_participation (team_id, user_id) values (10, 4);
insert into team_participation (team_id, user_id) values (10, 5);

insert into team_participation (team_id, user_id) values (11, 2);
insert into team_participation (team_id, user_id) values (11, 21);
insert into team_participation (team_id, user_id) values (11, 13);
insert into team_participation (team_id, user_id) values (11, 25);
insert into team_participation (team_id, user_id) values (11, 38);

insert into team_participation (team_id, user_id) values (12, 33);
insert into team_participation (team_id, user_id) values (12, 17);
insert into team_participation (team_id, user_id) values (12, 41);
insert into team_participation (team_id, user_id) values (12, 21);
insert into team_participation (team_id, user_id) values (12, 40);

insert into team_participation (team_id, user_id) values (13, 18);
insert into team_participation (team_id, user_id) values (13, 30);
insert into team_participation (team_id, user_id) values (13, 19);
insert into team_participation (team_id, user_id) values (13, 21);
insert into team_participation (team_id, user_id) values (13, 41);
insert into team_participation (team_id, user_id) values (13, 33);

insert into team_participation (team_id, user_id) values (14, 7);
insert into team_participation (team_id, user_id) values (14, 28);
insert into team_participation (team_id, user_id) values (14, 1);
insert into team_participation (team_id, user_id) values (14, 37);
insert into team_participation (team_id, user_id) values (14, 39);
insert into team_participation (team_id, user_id) values (14, 26);
insert into team_participation (team_id, user_id) values (14, 41);

insert into team_participation (team_id, user_id) values (15, 25);
insert into team_participation (team_id, user_id) values (15, 39);
insert into team_participation (team_id, user_id) values (15, 1);
insert into team_participation (team_id, user_id) values (15, 29);
insert into team_participation (team_id, user_id) values (15, 37);
insert into team_participation (team_id, user_id) values (15, 15);
insert into team_participation (team_id, user_id) values (15, 41);

insert into team_participation (team_id, user_id) values (16, 4);
insert into team_participation (team_id, user_id) values (16, 22);
insert into team_participation (team_id, user_id) values (16, 32);


insert into team_participation (team_id, user_id) values (17, 43);
insert into team_participation (team_id, user_id) values (17, 44);
insert into team_participation (team_id, user_id) values (17, 45);
insert into team_participation (team_id, user_id) values (17, 46);


insert into team_participation (team_id, user_id) values (18, 47);
insert into team_participation (team_id, user_id) values (18, 48);
insert into team_participation (team_id, user_id) values (18, 49);
insert into team_participation (team_id, user_id) values (18, 50);


insert into team_participation (team_id, user_id) values (19, 51);
insert into team_participation (team_id, user_id) values (19, 52);
insert into team_participation (team_id, user_id) values (19, 53);
insert into team_participation (team_id, user_id) values (19, 54);


insert into team_participation (team_id, user_id) values (20, 55);
insert into team_participation (team_id, user_id) values (20, 56);
insert into team_participation (team_id, user_id) values (20, 57);
insert into team_participation (team_id, user_id) values (20, 58);


insert into team_participation (team_id, user_id) values (21, 59);
insert into team_participation (team_id, user_id) values (21, 60);
insert into team_participation (team_id, user_id) values (21, 61);
insert into team_participation (team_id, user_id) values (21, 62);



-- INSERT INTO challenges (start_date, end_date, to_team_id, from_team_id, task_name, repetitions, units)
-- VALUES ('2016-3-30', '2016-4-06', '1', '4', 'Pullups', 200, 'repetitions');
--
-- INSERT INTO challenge_progress (team_id, challenge_id, exercise_name, repetitions, units, created)
-- VALUES ('1', '1', 'Pullups', 0, 'repetitions', UTC_TIMESTAMP());
-- INSERT INTO challenge_progress (team_id, challenge_id, exercise_name, repetitions, units, created)
-- VALUES ('4', '1', 'Pullups', 0, 'repetitions', UTC_TIMESTAMP());
--
-- INSERT INTO challenges (start_date, end_date, to_team_id, from_team_id, task_name, repetitions, units)
-- VALUES ('2016-4-07', '2016-4-14', '2', '1', 'Swimming', 20, 'miles');
-- INSERT INTO challenge_progress (team_id, challenge_id, exercise_name, repetitions, units, created)
-- VALUES ('2', '2', 'Swimming', 0, 'miles', UTC_TIMESTAMP());
-- INSERT INTO challenge_progress (team_id, challenge_id, exercise_name, repetitions, units, created)
-- VALUES ('1', '2', 'Swimming', 0, 'miles', UTC_TIMESTAMP());
--
-- INSERT INTO challenges (start_date, end_date, to_team_id, from_team_id, task_name, repetitions, units)
-- VALUES ('2016-4-07', '2016-6-14', '2', '1', 'Running', 15, 'miles');
-- INSERT INTO challenge_progress (team_id, challenge_id, exercise_name, repetitions, units, created)
-- VALUES ('2', '3', 'Running', 0, 'miles', UTC_TIMESTAMP());
-- INSERT INTO challenge_progress (team_id, challenge_id, exercise_name, repetitions, units, created)
-- VALUES ('1', '3', 'Running', 0, 'miles', UTC_TIMESTAMP());
--
-- INSERT INTO challenges (start_date, end_date, to_team_id, from_team_id, task_name, repetitions, units, task_type)
-- VALUES ('2016-4-07', '2016-6-14', '2', '16', 'Pushups', 300, 'repetitions', 'Individual');
-- INSERT INTO challenge_progress (team_id, challenge_id, exercise_name, repetitions, units, created)
-- VALUES ('2', '4', 'Pushups', 0, 'repetitions', UTC_TIMESTAMP());
-- INSERT INTO challenge_progress (team_id, challenge_id, exercise_name, repetitions, units, created)
-- VALUES ('16', '4', 'Pushups', 0, 'repetitions', UTC_TIMESTAMP());
--
-- INSERT INTO exercises (user_id, date_completed, exercise_name)
-- VALUES('1', '2016-4-07', 'Pushups');
-- INSERT INTO individual_progress (team_id, user_id, challenge_id, exercise_id, exercise_name, repetitions, units, created)
-- VALUES ('2', '2', '4', '1', 'Pushups', 10, 'repetitions', UTC_TIMESTAMP());
-- INSERT INTO individual_progress (team_id, user_id, challenge_id, exercise_id, exercise_name, repetitions, units, created)
-- VALUES ('2', '2', '4', '1', 'Pushups', 18, 'repetitions', UTC_TIMESTAMP());
-- INSERT INTO individual_progress (team_id, user_id, challenge_id, exercise_id, exercise_name, repetitions, units, created)
-- VALUES ('2', '2', '4', '1', 'Pushups', 20, 'repetitions', UTC_TIMESTAMP());
-- UPDATE challenge_progress SET repetitions = 48 WHERE team_id = 2 AND challenge_id = 4;
-- INSERT INTO exercises (user_id, date_completed, exercise_name)
-- VALUES('22', '2016-4-07', 'Pushups');
-- INSERT INTO individual_progress (team_id, user_id, challenge_id, exercise_id, exercise_name, repetitions, units, created)
-- VALUES ('16', '22', '4', '2', 'Pushups', 20, 'repetitions', UTC_TIMESTAMP());
-- INSERT INTO individual_progress (team_id, user_id, challenge_id, exercise_id, exercise_name, repetitions, units, created)
-- VALUES ('16', '22', '4', '2', 'Pushups', 20, 'repetitions', UTC_TIMESTAMP());
-- INSERT INTO individual_progress (team_id, user_id, challenge_id, exercise_id, exercise_name, repetitions, units, created)
-- VALUES ('16', '22', '4', '2', 'Pushups', 30, 'repetitions', UTC_TIMESTAMP());
-- UPDATE challenge_progress SET repetitions = 70 WHERE team_id = 16 AND challenge_id = 4;
-- INSERT INTO exercises (user_id, date_completed, exercise_name)
-- VALUES('1', '2016-4-07', 'Pullups');
-- INSERT INTO exercises (user_id, date_completed, exercise_name)
-- VALUES('1', '2016-4-07', 'Situps');

# Mock Data for billybob -> teams he is on: 1
-- INSERT INTO challenges (start_date, end_date, to_team_id, from_team_id, task_name, repetitions, units, task_type)
-- VALUES ('2016-4-07', '2016-6-14', '1', '7', 'Cycling', 30, 'miles', 'Group');
-- INSERT INTO challenge_progress (team_id, challenge_id, exercise_name, repetitions, units, created)
-- VALUES ('2', '3', 'Running', 0, 'miles', UTC_TIMESTAMP());
-- INSERT INTO challenge_progress (team_id, challenge_id, exercise_name, repetitions, units, created)
-- VALUES ('1', '3', 'Running', 0, 'miles', UTC_TIMESTAMP());
-- INSERT INTO exercises (user_id, date_completed, exercise_name, units, repetitions)
-- VALUES('1', '2016-5-07', 'Cycling');
-- INSERT INTO individual_progress (team_id, user_id, challenge_id, exercise_id, exercise_name, repetitions, units, created)
-- VALUES ('16', '22', '4', '2', 'Pushups', 20, 'repetitions', UTC_TIMESTAMP());



-- INSERT INTO exercises (user_id, date_completed, exercise_name)
-- VALUES('1', '2016-4-07', 'Running');
-- INSERT INTO exercises (user_id, date_completed, exercise_name)
-- VALUES('2', '2016-4-07', 'Running');
-- INSERT INTO exercises (user_id, date_completed, exercise_name)
-- VALUES('1', '2016-4-15', 'Swimming');
-- INSERT INTO exercises (user_id, date_completed, exercise_name)
-- VALUES('2', '2016-4-07', 'Swimming');

INSERT INTO exercise_list (exercise_name, units)
VALUES( 'Running', 'NULL');
INSERT INTO exercise_list (exercise_name, units)
VALUES( 'Swimming', 'NULL');
INSERT INTO exercise_list (exercise_name, units)
VALUES( 'Cycling', 'NULL');
INSERT INTO exercise_list (exercise_name, units)
VALUES( 'Rowing', 'NULL');
INSERT INTO exercise_list (exercise_name, units)
VALUES( 'Planks', 'seconds');
INSERT INTO exercise_list (exercise_name, units)
VALUES( 'Yoga', 'minutes');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Pullups');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Pushups');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Situps');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Crunches');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Russian Twists');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Lunges');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Burpees');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Squats');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Wall Sits');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Planks');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Mountain Climbers');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Box Jumps');
INSERT INTO exercise_list (exercise_name)
VALUES( 'Stairs');

INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'miles', 1);
INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'kilometers', 1);
INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'meters', 1);
INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'miles', 2);
INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'kilometers', 2);
INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'meters', 2);
INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'miles', 3);
INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'kilometers', 3);
INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'miles', 4);
INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'kilometers', 4);
INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'meters', 4);
INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'minutes', 6);
INSERT INTO units (unit_name, exercise_list_id)
VALUES( 'hours', 6);
