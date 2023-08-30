#!/bin/bash

if [ "$MYSQL_USER" ] && [ "$MYSQL_PASSWORD" ] && [ "$MYSQL_DATABASE" ]; then
    /usr/bin/mysql -u $MYSQL_USER -p$MYSQL_PASSWORD << EOF
        CREATE DATABASE IF NOT EXISTS ${MYSQL_DATABASE}_test;
EOF
    /usr/bin/mysqldump -u $MYSQL_USER -p$MYSQL_PASSWORD ${MYSQL_DATABASE} > ${MYSQL_DATABASE}_backup.sql
    /usr/bin/mysql -u $MYSQL_USER -p$MYSQL_PASSWORD ${MYSQL_DATABASE}_test < ${MYSQL_DATABASE}_backup.sql
fi
