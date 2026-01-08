#!/bin/bash

# Sobe os containers do Docker
echo "🚀 Subindo containers..."
docker compose up --build -d

# Executa o npm run watch em background
echo "📦 Iniciando NPM watch..."
npm run watch &

# Executa o Symfony Server
# O Symfony serve geralmente é o processo principal que queremos ver o log,
# então deixamos ele por último sem o & para manter o terminal ocupado.
echo "🎼 Iniciando Symfony server..."
symfony serve
