var http = require('http');
http.createServer(function (req, res) {
  res.writeHead(200, {'Content-Type': 'text/plain'});
  res.end('Hello World\n');
}).listen(8080, '139.59.252.253');
console.log('Server running at http://139.59.252.253:1337/');
