CREATE TABLE user (
first_name  VARCHAR(32),
last_name  VARCHAR(32),
password  VARCHAR(32),
email  VARCHAR(128),
PRIMARY KEY (email)
);

CREATE TABLE project(
title             VARCHAR(128) NOT NULL,
description       VARCHAR(256) NOT NULL,
project_id        VARCHAR(32) PRIMARY KEY,
start_date        DATETIME  NOT NULL,
duration          INT  NOT NULL,
keywords          VARCHAR(256) NOT NULL,
amount_sought     INT  NOT NULL,
amount_collected  INT  NOT NULL,
percent_collected INT  NOT NULL,
category          VARCHAR(32) NOT NULL,
category_url      VARCHAR(56) NOT NULL,
clickthrough_url  VARCHAR(128) NOT NULL,
image_url         VARCHAR(128) NOT NULL,
is_indemand       VARCHAR(5) NOT NULL,
product_stage     VARCHAR(10),
source_url        VARCHAR(128) NOT NULL
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
