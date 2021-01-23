CREATE TABLE `itineraries` (
  `uuid` char(36) NOT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `students` (
  `uuid` char(36) NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `activities` (
  `id` varchar(10) NOT NULL,
  `name` varchar(32) NOT NULL,
  `level` integer NOT NULL,
  `time` integer NOT NULL,
  `solution` JSON NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `activities_itineraries` (
   `uuid` char(36) NOT NULL,
  `itinerary_uuid` char(36) NOT NULL,
  `activity_id` varchar(10) NOT NULL,
  `position` integer NOT NULL,
  PRIMARY KEY (`uuid`),
  KEY (`activity_id`, `position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `evaluations` (
   `uuid` char(36) NOT NULL,
  `itinerary_uuid` char(36) NOT NULL,
  `activity_id` varchar(10) NOT NULL,
  `student_uuid` char(36) NOT NULL,
  `create_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `answer` varchar(32) NOT NULL,
  `inverted_time` integer NOT NULL,
  `score` integer NOT NULL,
  `percentage_inverted_time` integer NOT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE activities_itineraries ADD CONSTRAINT itinerary_FK FOREIGN KEY (itinerary_uuid) REFERENCES itineraries(uuid);
ALTER TABLE activities_itineraries ADD CONSTRAINT activity_FK FOREIGN KEY (activity_id) REFERENCES activities(id);

ALTER TABLE evaluations ADD CONSTRAINT student_activity_itinerary_FK FOREIGN KEY (itinerary_uuid) REFERENCES itineraries(uuid);
ALTER TABLE evaluations ADD CONSTRAINT student_activity_activity_FK FOREIGN KEY (activity_id) REFERENCES activities(id);
ALTER TABLE evaluations ADD CONSTRAINT student_activity_student_FK FOREIGN KEY (student_uuid) REFERENCES students(uuid);

INSERT INTO itineraries VALUES ('99f951bf-7d49-4a1a-9152-7bdee1f5ce2e');
INSERT INTO students VALUES ('70f066f6-1cb7-4c45-97e2-287f0258ba02', 'Max');
INSERT INTO activities VALUES ('A1', 'activity 1', 1, 120, '{"0":1, "1":0, "2":2}');
INSERT INTO activities VALUES ('A2', 'activity 2', 1, 60, '{"0":-2, "1":40, "2":56}');
INSERT INTO activities VALUES ('A3', 'activity 3', 1, 120, '{"0":1, "1":0}');
INSERT INTO activities VALUES ('A4', 'activity 4',1, 180, '{"0":1, "1":0, "2":2, "3":-5, "4":9}');
INSERT INTO activities VALUES ('A5', 'activity 5', 2, 120, '{"0":1, "1":0, "2":2}');
INSERT INTO activities VALUES ('A6', 'activity 6', 2, 120, '{"0":1, "1":0, "2":2}');
INSERT INTO activities VALUES ('A7', 'activity 7', 3, 120, '{"0":1, "1":-1, "2":"Si", "3":34, "4":-6}');
INSERT INTO activities VALUES ('A8', 'activity 8', 3, 120, '{"0":1, "1":2}');
INSERT INTO activities VALUES ('A9', 'activity 9', 4, 120, '{"0":1, "1":0, "2":2}');
INSERT INTO activities VALUES ('A10', 'activity 10', 5, 120, '{"0":1, "1":0, "2":2}');
INSERT INTO activities VALUES ('A11', 'activity 11', 6, 120, '{"0":1, "1":0, "2":2}');
INSERT INTO activities VALUES ('A12', 'activity 12', 7, 120, '{"0":1, "1":0, "2":2}');
INSERT INTO activities VALUES ('A13', 'activity 13', 8, 120, '{"0":1, "1":0, "2":2}');
INSERT INTO activities VALUES ('A14', 'activity 14',9, 120, '{"0":1, "1":0, "2":2}');
INSERT INTO activities VALUES ('A15', 'activity 15', 10, 120, '{"0":1, "1":0, "2":2}');
