# import bq_helper
# from bq_helper import BigQueryHelper
# import os
#
# os.environ["GOOGLE_APPLICATION_CREDENTIALS"]="credentials.json"
# bq_assistant = BigQueryHelper("bigquery-public-data", "stackoverflow")
#
# QUERY = "SELECT q.id, q.title, q.body, q.tags, a.body as answers, a.score FROM `bigquery-public-data.stackoverflow.posts_questions` AS q INNER JOIN `bigquery-public-data.stackoverflow.posts_answers` AS a ON q.id = a.parent_id WHERE q.tags LIKE '%python%' LIMIT 500000"
# df = bq_assistant.query_to_pandas(QUERY)
# df.to_csv('data/Original_data.csv')


import pandas as pd
import numpy as np
import spacy
from pymongo import MongoClient
# client = MongoClient("mongodb://localhost:27017/")
# db = client["q&asystem"]
# questions = db["questions"]
# for x in questions.find():
#     print(x)
#pd.set_option('display.max_colwidth', -1)
#pd.set_option('display.max_columns', None)

EN = spacy.load('en_core_web_sm')
df = pd.read_csv('data/Original_data.csv')
# print(df.head())
# print('Datebase shape:' + str(df.shape))

aggregations = {
    'answers':[lambda x: "\n".join(x)],
    'score':['sum']
}
grouped = df.groupby(['id','title', 'body','tags'],as_index=False).agg(aggregations)


print('Test df')
print(grouped)

deduped_df = pd.DataFrame(grouped)
print(deduped_df.head())
print('Max score before: ')
print(np.max(df.score.values))

print('Max score after: ')
print(np.max(deduped_df.score.values))

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
    return nltk.RegexpTokenizer(r'\w+').tokenize(text)

def preprocess_text(text):
    return ' '.join(normalize(tokenize_text(text)))


from bs4 import BeautifulSoup
from textblob import TextBlob

title_list = []
content_list = []
url_list = []
comment_list = []
sentiment_polarity_list = []
sentiment_subjectivity_list = []
vote_list = []
tag_list = []
corpus_list = []

for i, row in deduped_df.iterrows():
    title_list.append(row.title.values[0])  # Get question title
    tag_list.append(row.tags.values[0])  # Get question tags

    # Questions
    content = row.body.values[0]
    soup = BeautifulSoup(content, 'lxml')
    if soup.code: soup.code.decompose()  # Remove the code section
    tag_p = soup.p
    tag_pre = soup.pre
    text = ''
    if tag_p: text = text + tag_p.get_text()
    if tag_pre: text = text + tag_pre.get_text()

    content_list.append(
        str(row.title.values[0]) + ' ' + str(text))  # Append title and question body data to the updated question body

    url_list.append('https://stackoverflow.com/questions/' + str(row.id.values[0]))

    # Answers
    content = row.answers.values[0]
    soup = BeautifulSoup(content, 'lxml')
    if soup.code: soup.code.decompose()
    tag_p = soup.p
    tag_pre = soup.pre
    text = ''
    if tag_p: text = text + tag_p.get_text()
    if tag_pre: text = text + tag_pre.get_text()
    comment_list.append(text)

    vote_list.append(row.score.values[0])  # Append votes

    corpus_list.append(
        content_list[-1] + ' ' + comment_list[-1])  # Combine the updated body and answers to make the corpus

    sentiment = TextBlob(row.answers.values[0]).sentiment
    sentiment_polarity_list.append(sentiment.polarity)
    sentiment_subjectivity_list.append(sentiment.subjectivity)

content_token_df = pd.DataFrame(
    {'original_title': title_list, 'post_corpus': corpus_list, 'question_content': content_list,
     'question_url': url_list, 'tags': tag_list, 'overall_scores': vote_list, 'answers_content': comment_list,
     'sentiment_polarity': sentiment_polarity_list, 'sentiment_subjectivity': sentiment_subjectivity_list})
print(content_token_df.head())

content_token_df.tags = content_token_df.tags.apply(lambda x: x.split('|'))   # Convert raw text data of tags into lists

# Make a dictionary to count the frequencies for all tags
tag_freq_dict = {}
for tags in content_token_df.tags:
    for tag in tags:
        if tag not in tag_freq_dict:
            tag_freq_dict[tag] = 0
        else:
            tag_freq_dict[tag] += 1

import heapq
most_common_tags = heapq.nlargest(20, tag_freq_dict, key=tag_freq_dict.get)

print(most_common_tags)
final_indices = []
for i,tags in enumerate(content_token_df.tags.values.tolist()):
    if len(set(tags).intersection(set(most_common_tags)))>1:   # The minimum length for common tags should be 2 because 'python' is a common tag for all
        final_indices.append(i)

final_data = content_token_df.iloc[final_indices]

import spacy
EN = spacy.load('en_core_web_sm')

# Preprocess text for 'question_body', 'post_corpus' and a new column 'processed_title'
final_data.question_content = final_data.question_content.apply(lambda x: preprocess_text(x))
final_data.post_corpus = final_data.post_corpus.apply(lambda x: preprocess_text(x))
final_data['processed_title'] = final_data.original_title.apply(lambda x: preprocess_text(x))

# Normalize numeric data for the scores
final_data.overall_scores = (final_data.overall_scores - final_data.overall_scores.mean()) / (final_data.overall_scores.max() - final_data.overall_scores.min())
final_data.tags = final_data.tags.apply(lambda x: '|'.join(x))    # Combine the lists back into text data
final_data.drop(['answers_content'], axis=1)     # Remove the answers_content columns because it is alreaady included in the corpus
# Save the data
final_data.to_csv('data/Preprocessed_data.csv', index=False)
