FROM mysql:5.7.20

RUN  echo 'sql_mode = "NO_ENGINE_SUBSTITUTION"' >> /etc/mysql/mysql.conf.d/mysqld.cnf
RUN  echo "max_allowed_packet      = 700M" >> /etc/mysql/mysql.conf.d/mysqld.cnf
RUN  echo "character-set-server=utf8" >> /etc/mysql/mysql.conf.d/mysqld.cnf
RUN  echo "collation-server=utf8_general_ci" >> /etc/mysql/mysql.conf.d/mysqld.cnf
