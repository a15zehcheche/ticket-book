#!/bin/bash
echo "hola"

cd /home/chen/Documentos/ticket-book/bar-app-server
docker-compose up -d
code .
cd /home/chen/Documentos/ticket-book/my-project
code .

