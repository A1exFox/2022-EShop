#!/bin/bash
mysqldump --no-tablespaces -u $MYSQL_USER -p $MYSQL_DATABASE > /docker-entrypoint-initdb.d/$MYSQL_DATABASE.sql