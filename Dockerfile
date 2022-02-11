FROM php:8.0-fpm
WORKDIR /var/www
# Install a lot of unused and used dependencies, should filter out unused in order to keep image clean
RUN apt-get update && apt-get install -y \
	build-essential \
	libpng-dev \
	libjpeg62-turbo-dev \
	libfreetype6-dev \
	locales \
	zip \
	libxml2-dev \
	jpegoptim optipng pngquant gifsicle \
	vim \
	unzip \
	libzip-dev \
	libfontconfig \
	wkhtmltopdf 
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# Install extensions
RUN docker-php-ext-configure zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd soap
# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]