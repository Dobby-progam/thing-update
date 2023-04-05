CREATE TABLE if not exists authentication (
    UID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE,
    mail NVARCHAR(256) UNIQUE,
    password VARCHAR(255)
)