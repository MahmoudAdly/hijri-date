# You can add this to a cron job like:
# 0 * * * * cd /user/mahmoud/hijri-date && python ./hijri_scraper.py
import urllib2
from HTMLParser import HTMLParser

class HijriDateParser(HTMLParser):
  def __init__(self):
    HTMLParser.__init__(self)
    self.recording = 0
    self.data = []

  def handle_starttag(self, tag, attributes):
    if tag != 'span':
      return
    if self.recording:
      self.recording += 1
      return
    for name, value in attributes:
      if name == 'id' and value == 'lblDate':
        break
    else:
      return
    self.recording = 1

  def handle_endtag(self, tag):
    if tag == 'span' and self.recording:
      self.recording -= 1

  def handle_data(self, data):
    if self.recording:
      self.data.append(data)

response = urllib2.urlopen('http://www.dar-alifta.org/dateservice.aspx?LangID=1&BGColor=FFFFFF')
html = response.read()
p = HijriDateParser()
p.feed(html)
hijri_date = p.data[0]
p.close()

file = open("hijri_date.txt", "w")
file.write(hijri_date)
file.close()

