#!/bin/bash
command="$1";
alias="$2";
if [ "$command" == "up" ]; then
    docker compose down
    docker compose up -d $alias
elif [ "$command" == "down" ]; then
    docker compose down
elif [ "$command" == "bash" ]; then
    docker exec -it php_apache bash
elif [ "$command" == "composer" ]; then
    if [ "$alias" == "init" ]; then
        docker exec php_apache composer init --description '' --no-interaction
    else
        docker exec php_apache composer $alias $3
    fi
elif [ "$command" == "dump" ]; then
    docker exec -it mysql /dumpdb
fi
