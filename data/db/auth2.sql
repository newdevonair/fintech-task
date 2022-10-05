CREATE TABLE oauth_clients (
                               client_id VARCHAR(80) NOT NULL,
                               client_secret VARCHAR(80) NOT NULL,
                               redirect_uri VARCHAR(2000),
                               grant_types VARCHAR(80),
                               scope VARCHAR(2000),
                               user_id VARCHAR(255),
                               CONSTRAINT clients_client_id_pk PRIMARY KEY (client_id)
);
CREATE TABLE oauth_access_tokens (
                                     access_token VARCHAR(40) NOT NULL,
                                     client_id VARCHAR(80) NOT NULL,
                                     user_id VARCHAR(255),
                                     expires TIMESTAMP NOT NULL,
                                     scope VARCHAR(2000),
                                     CONSTRAINT access_token_pk PRIMARY KEY (access_token)
);
