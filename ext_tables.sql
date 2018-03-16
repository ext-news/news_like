#
# Table structure for table 'tx_news_domain_model_news'
#
CREATE TABLE tx_news_domain_model_news (
	tx_newslike_count int(11) DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_newslike_log'
#
CREATE TABLE tx_newslike_log (
	ip tinytext,
	log_date date DEFAULT NULL,
	news int(11) DEFAULT '0' NOT NULL,
);