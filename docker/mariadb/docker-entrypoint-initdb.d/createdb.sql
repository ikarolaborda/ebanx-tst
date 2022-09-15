#
# example: .env MYSQL_USER=appuser and need db name is myshop_db
#
#    CREATE DATABASE IF NOT EXISTS `myshop_db` ;
#    GRANT ALL ON `myshop_db`.* TO 'appuser'@'%' ;
#
###
### this sql script is auto run when mariadb container start and $DATA_PATH_HOST/mariadb not exists.
###
### if your $DATA_PATH_HOST/mariadb is exists and you do not want to delete it, you can run by manual execution:
###
###     docker-compose exec mariadb bash
###     mysql -u root -p < /docker-entrypoint-initdb.d/createdb.sql
###

CREATE DATABASE IF NOT EXISTS `ebanxtst` COLLATE 'utf8_general_ci' ;
GRANT ALL ON `ebanxtst`.* TO 'ebanx'@'%' ;

CREATE DATABASE IF NOT EXISTS `ebanxtst_test` COLLATE 'utf8_general_ci' ;
GRANT ALL ON `ebanxtst_test`.* TO 'ebanx'@'%' ;

FLUSH PRIVILEGES ;