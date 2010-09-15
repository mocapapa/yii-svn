CREATE TABLE tbl_user (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(128) NOT NULL,
    password VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    profile VARCHAR(128) NOT NULL
);

INSERT INTO "tbl_user" VALUES(13,'mocapapa','91a56e040eb4823df1ff6fe8411dc935','mocapapa@g.pugpug.org','a');
INSERT INTO "tbl_user" VALUES(15,'sakurai','9f9a585cb04cd8b8dfefb1d7044270c1','sakurai@pugpug.org','pugpug');

CREATE TABLE tbl_access (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(128) NOT NULL,
    project VARCHAR(128) NOT NULL,
    description VARCHAR(1024) NOT NULL,
);
