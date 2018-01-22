jssearch.index = {"class":[{"f":1,"w":3.2832},{"f":2,"w":2.736}],"reference":[{"f":1,"w":2.28},{"f":2,"w":1.2}],"weesee":[{"f":1,"w":4.8},{"f":2,"w":52.5312}],"pdflabel":[{"f":1,"w":6.912},{"f":2,"w":108.92869632}],"description":[{"f":1,"w":1.2},{"f":2,"w":1.2}],"tcpdflabel":[{"f":1,"w":1.2},{"f":2,"w":52.5312}],"proxy":[{"f":1,"w":1.2},{"f":2,"w":1.2}],"uskur":[{"f":1,"w":1.2},{"f":2,"w":1.44}],"results":[{"f":1,"w":1.2},{"f":2,"w":1.2}],"'":[{"f":1,"w":1.44},{"f":2,"w":1.44}],"+":[{"f":1,"w":2.48832},{"f":2,"w":2.48832}],"result":[{"f":1,"w":1.44},{"f":2,"w":1.44}],"key":[{"f":1,"w":1.44},{"f":2,"w":1.44}],"file":[{"f":1,"w":1.44},{"f":2,"w":1.44}],"t":[{"f":1,"w":1.2},{"f":2,"w":1.2}],"''":[{"f":1,"w":1.44},{"f":2,"w":1.44}],"d":[{"f":1,"w":1.2},{"f":2,"w":1.2}],"public":[{"f":2,"w":1.8}],"methods":[{"f":2,"w":2.16}],"method":[{"f":2,"w":2.16}],"details":[{"f":2,"w":1.8}],"-":[{"f":2,"w":4}],"used":[{"f":2,"w":1.2}],"directly":[{"f":2,"w":1.2}],"access":[{"f":2,"w":1.2}],"tcpdf":[{"f":2,"w":1.2}],"setting":[{"f":2,"w":1.2}],"borders":[{"f":2,"w":1.2}],"hide":[{"f":2,"w":1.2}],"inherited":[{"f":2,"w":1.2}],"add":[{"f":2,"w":2.0736}],"one":[{"f":2,"w":2.0736}],"label":[{"f":2,"w":2.0736}],"using":[{"f":2,"w":2.0736}],"html":[{"f":2,"w":1.44}],"format":[{"f":2,"w":2.0736}],"plain":[{"f":2,"w":1.44}],"text":[{"f":2,"w":1.44}],"inheritance":[{"f":2,"w":1.2}],"&raquo":[{"f":2,"w":1.2}],"defined":[{"f":2,"w":1.2}],"addextendedhtmllabel":[{"f":2,"w":1.2}],"addextendedlabel":[{"f":2,"w":1.2}]};
jssearch.files = {"1":{"u":".\/\/index.html","t":"Class Reference","d":""},"2":{"u":".\/\/weesee-pdflabel-tcpdflabel.html","t":"Class weesee\\pdflabel\\TCPDFLabel","d":"This is a proxy class for Uskur\\PdfLabel\\PdfLabel."}};
jssearch.tokenizeString = function(string) {
		var stopWords = ["a","an","and","are","as","at","be","but","by","for","if","in","into","is","it","no","not","of","on","or","such","that","the","their","then","there","these","they","this","to","was","will","with","yii"];
		return string.split(/[\s\.,;\:\\\/\[\]\(\)\{\}]+/).map(function(val) {
			return val.toLowerCase();
		}).filter(function(val) {
			for (w in stopWords) {
				if (stopWords[w] == val) return false;
			}
			return true;
		}).map(function(word) {
			return {t: word, w: 1};
		});
};