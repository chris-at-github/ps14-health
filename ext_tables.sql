CREATE TABLE tx_health_domain_model_site (
	title varchar(255) DEFAULT '' NOT NULL,
	identifier varchar(255) DEFAULT '' NOT NULL,
	domain int(11) unsigned DEFAULT '0',
	uris int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_health_domain_model_uri (
	uri varchar(1024) DEFAULT '' NOT NULL,
	site int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_health_domain_model_uriresponse (
	last_request_time datetime DEFAULT NULL,
	body mediumtext,
	uri int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_health_domain_model_domain (
	uri varchar(1024) DEFAULT '' NOT NULL
);

CREATE TABLE tx_health_domain_model_queue (
	identifier varchar(255) DEFAULT '' NOT NULL,
	handler varchar(255) DEFAULT '' NOT NULL,
	execute_at datetime DEFAULT NULL,
	arguments text,
	site int(11) unsigned DEFAULT '0'
);