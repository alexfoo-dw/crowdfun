CREATE TABLE admin (
first_name  VARCHAR(32),
last_name  VARCHAR(32),
password  VARCHAR(32),
email  VARCHAR(128) check (email like '%_@__%.__%'),
PRIMARY KEY (email)
);

CREATE TABLE users (
first_name    VARCHAR(32) NOT NULL,
last_name     VARCHAR(32) NOT NULL,
password      VARCHAR(6) NOT NULL CHECK (LENGTH(password) >=6),
email         VARCHAR(64) NOT NULL PRIMARY KEY CHECK (email like '%_@_%._%'),
dob           DATE  NOT NULL,
since         DATE  NOT NULL DEFAULT NOW(),
birth_country VARCHAR(32) NOT NULL,
phone         VARCHAR(20) NOT NULL,
CONSTRAINT CHK_valid_dob CHECK (since > dob)
);

CREATE TABLE project (
title             VARCHAR(128) NOT NULL,
description       VARCHAR(256) NOT NULL,
project_id        VARCHAR(32) PRIMARY KEY,
start_date        DATE  NOT NULL DEFAULT NOW(),
duration          INT  NOT NULL CHECK (duration >= 0),
keywords          VARCHAR(256) NOT NULL,
amount_sought     INT  NOT NULL CHECK (amount_sought >= 0),
amount_collected  INT  NOT NULL DEFAULT 0,
percent_collected INT  NOT NULL DEFAULT 0,
category          VARCHAR(32) NOT NULL,
category_url      VARCHAR(56),
clickthrough_url  VARCHAR(128),
image_url         VARCHAR(128),
is_indemand       VARCHAR(5),
product_stage     VARCHAR(10),
source_url        VARCHAR(128)
);

CREATE TABLE creates (
u_email  VARCHAR(64),
p_projectID  VARCHAR(32) PRIMARY KEY,
FOREIGN KEY (u_email) REFERENCES users (email) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (p_projectID) REFERENCES project (project_id)
ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE funds (
fund_date  DATE NOT NULL,
amount  INT NOT NULL CHECK (amount >= 0),
u_email  VARCHAR(64),
p_projectID  VARCHAR(32),
PRIMARY KEY (u_email, p_projectID),
FOREIGN KEY (u_email) REFERENCES users (email) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (p_projectID) REFERENCES project (project_id)
ON DELETE CASCADE ON UPDATE CASCADE		
);