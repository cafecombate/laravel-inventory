# You can find the new timestamped tags here: https://hub.docker.com/r/gitpod/workspace-full/tags
FROM gitpod/workspace-mysql:latest


# Change your version here
RUN sudo update-alternatives --set php $(which php8.1)

# Install Laravel required PHP extensions
RUN sudo apt-get update \
    && sudo apt-get install -y \
    openssl \
    php8.1-bcmath \
    php8.1-curl \
    php8.1-mbstring \
    php8.1-mysql \
    php8.1-tokenizer \
    php8.1-xml \
    php8.1-gd \
    php8.1-zip \
    php8.1-xdebug

#Install Node version
RUN bash -c 'VERSION="14.21.3" \
    && source $HOME/.nvm/nvm.sh && nvm install $VERSION \
    && nvm use $VERSION && nvm alias default $VERSION'
RUN echo "nvm use default &>/dev/null" >> ~/.bashrc.d/51-nvm-fix
