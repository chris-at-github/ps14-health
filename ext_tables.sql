CREATE TABLE tx_health_domain_model_site (


	title varchar(255) DEFAULT '' NOT NULL


);

CREATE TABLE tx_health_domain_model_uri (


	uri varchar(255) DEFAULT '' NOT NULL,
	site int(11) unsigned DEFAULT '0'


);

CREATE TABLE tx_health_domain_model_urirequest (


	last_request datetime DEFAULT NULL,
	uri int(11) unsigned DEFAULT '0'


);
