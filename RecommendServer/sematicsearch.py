# import libraries
import os
import numpy as np
import pandas as pd
import tensorflow as tf
import tensorflow_hub as hub
from sklearn import preprocessing

import spacy
from spacy.lang.en import English
import spacy
EN = spacy.load('en_core_web_sm')

from IPython.display import HTML
import logging
logging.getLogger('tensorflow').disabled = True #OPTIONAL - to disable outputs from Tensorflow

data = pd.read_csv('data/Preprocessed_data.csv')
data

# Import saved Wordvec Embeddings
import gensim
w2v_model = gensim.models.word2vec.Word2Vec.load('models/SO_word2vec_embeddings.bin')

def question_to_vec(question, embeddings, dim=300):
    question_embedding = np.zeros(dim)
    valid_words = 0
    for word in question.split(' '):
        if word in embeddings:
            valid_words += 1
            question_embedding += embeddings[word]
    if valid_words > 0:
        return question_embedding/valid_words
    else:
        return question_embedding
all_title_embeddings = []
for title in data.processed_title:
    all_title_embeddings.append(question_to_vec(title, w2v_model))
all_title_embeddings = np.array(all_title_embeddings)

embeddings = pd.DataFrame(data = all_title_embeddings)
embeddings.to_csv('models/title_embeddings.csv', index=False)

all_title_embeddings = pd.read_csv('models/title_embeddings.csv').values
import keras.backend as K

# Custom loss function to handle multilabel classification task
def multitask_loss(y_true, y_pred):
    # Avoid divide by 0
    y_pred = K.clip(y_pred, K.epsilon(), 1 - K.epsilon())
    # Multi-task loss
    return K.mean(K.sum(- y_true * K.log(y_pred) - (1 - y_true) * K.log(1 - y_pred), axis=1))

from keras.models import load_model
import keras.losses

keras.losses.multitask_loss = multitask_loss
model = load_model('models/Tag_predictor.h5')

def predict_tags(text, include_neutral=True):
    # Tokenize text
    x_test = pad_sequences(tokenizer.texts_to_sequences([text]), maxlen=MAX_SEQUENCE_LENGTH)
    # Predict
    prediction = model.predict([x_test])[0]
    for i,value in enumerate(prediction):
        if value > 0.5:
            prediction[i] = 1
        else:
            prediction[i] = 0
    tags = tag_encoder.inverse_transform(np.array([prediction]))
    return tags

import re
import nltk
import inflect
from nltk.corpus import stopwords

def tokenize_text(text):
    "Apply tokenization using spacy to docstrings."
    tokens = EN.tokenizer(text)
    return [token.text.lower() for token in tokens if not token.is_space]

def to_lowercase(words):
    """Convert all characters to lowercase from list of tokenized words"""
    new_words = []
    for word in words:
        new_word = word.lower()
        new_words.append(new_word)
    return new_words

def remove_punctuation(words):
    """Remove punctuation from list of tokenized words"""
    new_words = []
    for word in words:
        new_word = re.sub(r'[^\w\s]', '', word)
        if new_word != '':
            new_words.append(new_word)
    return new_words

def remove_stopwords(words):
    """Remove stop words from list of tokenized words"""
    new_words = []
    for word in words:
        if word not in stopwords.words('english'):
            new_words.append(word)
    return new_words

def normalize(words):
    words = to_lowercase(words)
    words = remove_punctuation(words)
    words = remove_stopwords(words)
    return words

def tokenize_code(text):
    "A very basic procedure for tokenizing code strings."
    return RegexpTokenizer(r'\w+').tokenize(text)

def preprocess_text(text):
    return ' '.join(normalize(tokenize_text(text)))

from keras.preprocessing.text import Tokenizer
from keras.preprocessing.sequence import pad_sequences

MAX_SEQUENCE_LENGTH = 300
import pickle
with open('models/tokenizer.pickle', 'rb') as handle:
    tokenizer = pickle.load(handle)

from IPython.display import HTML
import logging
from sklearn.metrics.pairwise import cosine_similarity

search_string = "Combine lists of lists"
search_string = ' '.join(normalize(tokenize_text(search_string)))
results_returned = "5"
search_vect = np.array([question_to_vec(search_string, w2v_model)])  # Vectorize the user query

# Calculate Cosine similarites for the query and all titles
cosine_similarities = pd.Series(cosine_similarity(search_vect, all_title_embeddings)[0])

# Custom Similarity Measure
cosine_similarities = cosine_similarities * (1 + 0.4 * data.overall_scores + 0.1 * (data.sentiment_polarity))

output = ""
for i, j in cosine_similarities.nlargest(int(results_returned)).iteritems():
    output += '<a target="_blank" href=' + str(data.question_url[i]) + '><h2>' + data.original_title[i] + '</h2></a>'
    output += '<h3> Similarity Score: ' + str(j) + '</h3>'
    output += '<h3> Stackover Votes: ' + str(data.overall_scores[i]) + '</h3>'
    output += '<p style="font-family:verdana; font-size:110%;"> '
    for i in data.question_content[i][:50].split():
        if i.lower() in search_string:
            output += " <b>" + str(i) + "</b>"
        else:
            output += " " + str(i)
    output += "</p><hr>"

output = '<h3>Results:</h3>' + output
print(output)
