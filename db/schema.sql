CREATE TABLE user (
first_name  VARCHAR(32),
last_name  VARCHAR(32),
password  VARCHAR(32),
email  VARCHAR(128),
PRIMARY KEY (email)
);

CREATE TABLE project (
title  VARCHAR(128),
description  VARCHAR(256),
project_id  VARCHAR(32),
start_date  DATE,
duration  INT,
keywords  VARCHAR(256),
amount_sought  INT,
amount_collected  INT,
PRIMARY KEY (project_id)	
);


CREATE TABLE creates (
date  DATE,
u_email  VARCHAR(128),
p_projectID  VARCHAR(32) PRIMARY KEY,
FOREIGN KEY (u_email) REFERENCES user (email),
FOREIGN KEY (p_projectID) REFERENCES project (project_id)
);

CREATE TABLE funds (
date  DATE,
amount  INT,
u_email  VARCHAR(128),
p_projectID  VARCHAR(32),
PRIMARY KEY (u_email, p_projectID),
FOREIGN KEY (u_email) REFERENCES user (email),
FOREIGN KEY (p_projectID) REFERENCES project (project_id)		
);


CREATE TABLE admin (
first_name  VARCHAR(32),
last_name  VARCHAR(32),
password  VARCHAR(32),
email  VARCHAR(128),
PRIMARY KEY (email)
);
