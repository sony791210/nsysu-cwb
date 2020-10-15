FROM python:3.6.2
ENV PYTHONUNBUFFERED=1
ARG DJANGO_DIRNAME
RUN mkdir -p /var/www/${DJANGO_DIRNAME}
WORKDIR /var/www/${DJANGO_DIRNAME}
COPY requirements.txt ./
RUN pip install -r requirements.txt
