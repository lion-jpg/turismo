# Etapa de construcción
FROM --platform=linux/amd64 dunglas/frankenphp:static-builder as builder

WORKDIR /go/src/app

# Copiar los archivos de la aplicación al directorio de trabajo
COPY . .

# Instalar las dependencias de Composer sin dev y con optimización de autoload
RUN composer install --ignore-platform-reqs --no-dev -a

# Establecer la variable de entorno para los archivos a incluir en el binario
ENV EMBED=dist/app/

# Establecer la variable de entorno para las extensiones de PHP necesarias
ENV PHP_EXTENSIONS="ctype,curl,dom,mbstring,posix,pcntl,intl,iconv,pdo_sqlite,gd,zip,intl,opcache"

# Ejecutar el script de construcción estática
RUN ./build-static.sh

# Etapa final
FROM alpine:3.19.0

WORKDIR /app

# Copiar el binario generado desde la etapa de construcción
COPY --from=builder /go/src/app/dist/frankenphp-linux-x86_64 laravel-app

# Exponer el puerto 80
EXPOSE 80

# Comando predeterminado para iniciar el servidor
CMD ["./laravel-app", "phpserver"]