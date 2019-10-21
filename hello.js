var https = require('https');
var fs = require('fs');

var options = {
    key: fs.readFileSync('./public/certificates/learnsbuy.com.key'),
    cert: fs.readFileSync('./public/certificates2/learnsbuy.com.chained.crt'),
  //  requestCert: true
};

https.createServer(options, (req, res) => {
  res.writeHead(200);
  res.end('hello world\n');
}).listen(3000);
