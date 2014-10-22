from elasticsearch import Elasticsearch
import glob
import re
import os

es = Elasticsearch()

# delete existig index
es.indices.delete(index="kamervragen")

# create index with certain analyzer mapped to certain fields
es.indices.create(index="kamervragen",
                  body= {
                          "settings" : {
                              "analysis" : {
                                  "analyzer" : "dutch"
                              }
                          },
                          "mappings" : {
                              "xml" : {
                                  "properties" : {
                                      "vraag" : {
                                          "type" : "string",
                                          "analyzer" : "dutch"
                                      },
                                      "antwoord" : {
                                          "type" : "string",
                                          "analyzer" : "dutch"
                                      },
                                      "inhoud" : {
                                          "type" : "string",
                                          "analyzer" : "dutch"
                                      },
                                      "rubriek" : {
                                          "type" : "string",
                                          "analyzer" : "dutch"
                                      },
                                      "trefwoorden" : {
                                          "type" : "string",
                                          "analyzer" : "dutch"
                                      },
                                      "doc_id" : {
                                          "type" : "string",
                                          "index" : "not_analyzed"
                                      }
                                  }}}})

os.chdir("D:/zoekmachines/week8/data/KVR")

# counter for entry id
i = 0

# loop through all kamervragen to find the field needed for the index
for file in glob.glob('*.xml'):
    if i % 1000 == 0:
        print i
    
    entry = {}

    entry['Inhoud'] = ''
    entry['Rubriek'] = ''
    entry['Trefwoorden'] = ''
    entry['Indiener'] = ''
    entry['Partij'] = ''
    entry['Jaar'] = ''
    entry['DocID'] = file
    entry['Vraag'] = ''
    entry['Antwoord'] = ''

    file_obj = open(file, 'rb')

    for line in file_obj.readlines():
        inhoud = re.search('<item attribuut="Inhoud">(.*?)</item>', line)
        if inhoud == None:
            inhoud = re.search('<item attribuut="Bibliografische_omschrijving">(.*?)</item>', line)
        rubriek = re.search('<item attribuut="Rubriek">(.*?)</item>', line)
        trefwoorden = re.search('<item attribuut="Trefwoorden">(.*?)</item>', line)
        indiener = re.search('<vrager partij="(.*?)" oorsprong="parlement">(.*?)</vrager>', line)
        jaar = re.search('<item attribuut="Datum_indiening">(.*?)-[0-9]+-[0-9]+</item>', line)
        vraag = re.search('<vraag .*?>(.*?)</vraag>', line)
        antwoord = re.search('<antwoord .*?>(.*?)</antwoord>', line)

        if inhoud:
            entry['Inhoud'] = inhoud.group(1)
        elif rubriek:
            entry['Rubriek'] = rubriek.group(1)
        elif trefwoorden:
            entry['Trefwoorden'] = trefwoorden.group(1)
        elif indiener:
            if entry['Indiener'] != '':
                entry['Indiener'] += ', '
            if entry['Partij'] != '':
                entry['Partij'] += ', '
            entry['Indiener'] += indiener.group(2)

            temp = re.sub("[^a-zA-Z0-9][^a-zA-Z0-9]*" ,"", re.sub(" ", "", indiener.group(1))).lower()
            if temp == 'christenunie':
                temp = 'cu'
            elif temp == 'chistenunie':
                temp = 'cu'
            elif temp == 'cristenunie':
                temp = 'cu'
            elif temp == 'groenlinks':
                temp = 'gl'
            elif temp == 'groenlmks':
                temp = 'gl'
            elif temp == 'beidengroenlinks':
                temp = 'gl, gl'
            elif temp == 'partijvoordedieren':
                temp = 'pvdd'
            elif temp == 'frhendriks':
                temp = 'hendriks'
            elif temp == 'hdrk':
                temp = 'hendriks'
            elif temp == 'beidencda':
                temp = 'cda, cda'
            elif temp == 'beidecda':
                temp = 'cda, cda'
            elif temp == 'beidenvvd':
                temp = 'vvd, vvd'
            elif temp == 'beidenpvda':
                temp = 'pvda'
            elif temp == 'artivaawb':
                temp = 'pvda'
            elif temp == 'partijvandearbeid':
                temp = 'pvda'
            elif temp == 'pvdafractie':
                temp = 'pvda'
            elif temp == 'beidend66':
                temp = 'd66, d66'
            elif temp == 'allend66':
                temp = 'd66, d66, d66'
            elif temp == 'fractied66':
                temp = 'd66'
            elif temp == 'spfractie':
                temp = 'sp'
            elif temp == 'partijvoordevrijheid':
                temp = 'pvv'
            elif temp == 'spg':
                temp = 'sgp'
            elif temp == 'onafhankelijkesenaatsfractie':
                temp = 'bierman'
            elif temp == 'centrumdemocraten':
                temp = 'cd'
            elif temp == 'leefbaarnederland':
                temp = 'ln'

            temp = re.sub("groep", "", temp)
            temp = re.sub("fractie", "", temp)
            temp = re.sub("lid", "", temp)

            entry['Partij'] += temp
        elif jaar:
            entry['Jaar'] = jaar.group(1)
        elif vraag:
            body = re.sub("<[^>]*>", "", vraag.group(1))
            entry['Vraag'] += body
        elif antwoord:
            body = re.sub("<[^>]*>", "", antwoord.group(1))
            entry['Antwoord'] += body
    
    file_obj.close()

    # fill index
    es.index(index="kamervragen", doc_type="xml", id=i,
             body={
                 "inhoud" : entry["Inhoud"],
                 "rubriek" : entry["Rubriek"],
                 "trefwoorden" : entry["Trefwoorden"],
                 "indiener" : entry["Indiener"],
                 "partij" : entry["Partij"],
                 "jaar" : entry["Jaar"],
                 "doc_id" : entry["DocID"],
                 "vraag" : entry["Vraag"],
                 "antwoord" : entry["Antwoord"],
             })
    
    i += 1

# es.search(index="kamervragen", doc_type="xml", body={"query" : { "match" : { "vraag" : "nederlands"}}}, fields="partij")
