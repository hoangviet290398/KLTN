FROM ubuntu:latest
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update -y
RUN apt-get install -y tzdata
RUN apt-get install -y pkg-config
RUN dpkg-reconfigure tzdata
RUN apt-get install -y libhdf5-dev
RUN apt-get install -y python3-dev git libxslt-dev libxml2-dev
RUN apt-get install -y python3-pip
RUN apt-get install -y python3-scipy
RUN apt-get install -y python3-matplotlib
RUN apt-get install -y build-essential gcc wget libc-dev 
RUN apt-get install -y  autoconf libtool pkg-config python-opengl python-pyrex idle-python2.7 libgle3 libssl-dev
RUN apt-get install -y libpq-dev libxslt1-dev libldap2-dev libsasl2-dev libffi-dev zlib1g-dev
RUN mkdir -p /app/flaskapi
WORKDIR /app/flaskapi

COPY . /app/flaskapi
RUN pip3 install --upgrade pip
RUN pip3 install nltk
RUN [ "python3", "-c", "import nltk; nltk.download('stopwords')" ]
RUN pip3 install tensorflow
RUN pip3 install tensorflow-estimator
RUN pip3 install --upgrade grpcio
RUN pip3 install --upgrade numpy
RUN pip3 install --upgrade wheel
RUN pip3 install --upgrade Cython
RUN pip3 install --upgrade lxml
RUN pip3 install --upgrade h5py
RUN pip3 install --upgrade setuptools
RUN pip3 --no-cache-dir install -r requirements.txt

EXPOSE 5000

ENTRYPOINT ["python3"]
CMD ["app.py"]