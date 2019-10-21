var socket  = require( './public/node_modules/socket.io' );
var express = require('./public/node_modules/express');
var mysql = require('./public/node_modules/mysql');
var bodyParser = require('./public/node_modules/body-parser');
var app = express();
var fs = require('fs');


var options = {
    key: fs.readFileSync('./public/certificates2/learnsbuy.com.key'),
    cert: fs.readFileSync('./public/certificates2/learnsbuy.com.chained.crt'),
  //  requestCert: true
};


var server  = require('https').createServer(options, app);
var io      = socket.listen( server );
var port    = process.env.PORT || 3000;

var con = mysql.createConnection({
  host: "127.0.0.1",
  user: "root",
  password: "mysql9",
  database: "enihongo"
});


var sendNotification = function(data) {
  var headers = {
    "Content-Type": "application/json; charset=utf-8",
    "Authorization": "Basic NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj"
  };

  var options = {
    host: "onesignal.com",
    port: 443,
    path: "/api/v1/notifications",
    method: "POST",
    headers: headers
  };

  var https = require('https');
  var req = https.request(options, function(res) {
    res.on('data', function(data) {
      console.log("Response:");
      console.log(JSON.parse(data));
    });
  });

  req.on('error', function(e) {
    console.log("ERROR:");
    console.log(e);
  });

  req.write(JSON.stringify(data));
  req.end();
};


app.use(bodyParser.json()); // support json encoded bodies
app.use(bodyParser.urlencoded({ extended: true })); // support encoded bodies



// Chat room Start disconnect

app.post('/join_chat_room', function (req, res) {

  con.connect(function(err) {

    var user_id = req.body.user_id;
    var name = req.body.name;
    var provider = req.body.provider;
    var avatar = req.body.avatar;
    var room_id = req.body.room_id;


    var sql = "UPDATE users SET user_status = 1 WHERE id = " + user_id + "";
    con.query(sql, function (err, result) {

    });

    var sqlcheck = "SELECT user_status FROM users where user_status = 1";
    con.query(sqlcheck, function(err, resultcheck) {

    var now = new Date();
    io.sockets.in(room_id).emit( 'adduser', {
      timer: now,
      name: name,
      count_user: resultcheck.length,
      avatar: avatar,
      provider: provider,
      type: 1,
      chat_user_id: user_id,
      message_in: 'ยินดีต้อนรับเข้าสู่ห้อง'
    });



    });

    res.json({'status' : 200, 'message' : 'Success', 'data' : true, 'user_online' : room_id});

    });

});



app.post('/disconnect_chat_room', function (req, res) {

  con.connect(function(err) {

    var user_id_dis = req.body.user_id;
    var name_dis = req.body.name;
    var provider_dis = req.body.provider;
    var avatar_dis = req.body.avatar;
    var room_id_dis = req.body.room_id;


    var sql1 = "UPDATE users SET user_status = 0 WHERE id = " + user_id_dis + "";
    con.query(sql1, function (err, result1) {

    });

    var sqlcheck1 = "SELECT user_status FROM users where user_status = 1";
    con.query(sqlcheck1, function(err, resultcheck1) {


    var now = new Date();
    io.sockets.in(room_id_dis).emit( 'adduser', {
      timer: now,
      name: name_dis,
      count_user: resultcheck1.length,
      avatar: avatar_dis,
      provider: provider_dis,
      type: 0,
      chat_user_id: user_id_dis,
      message_in: 'ได้ออกจากห้อง live'
    });
    });


    res.json({'status' : 200, 'message' : 'Success', 'data' : true, 'name' : name_dis});


    });

});




app.post('/chat_room', function (req, res) {

  con.connect(function(err) {

    var user_id = req.body.user_id;
    var name = req.body.name;
    var message_in = req.body.message_in;
    var playerid = req.body.playerid;
    var provider = req.body.provider;
    var avatar = req.body.avatar;
    var room_id = req.body.room_id;


    var sql = "INSERT INTO message_chat (user_id, room_id, message, created_at, updated_at) VALUES (" + user_id + ", " + room_id + ", '" + message_in + "', NOW(), NOW())";
    con.query(sql, function (err, result) {
      if (err) throw err;
      console.log(name);
      var date = new Date();

        io.sockets.in(room_id).emit( 'new_message_room', {
          timer: date,
          name: name,
          avatar: avatar,
          provider: provider,
          chat_user_id: user_id,
          message_in: message_in,
          playerid: playerid
        });


        var arr = new Array();
        var sqlcheck = "SELECT playerid, user_status FROM users where user_status = 1";
        con.query(sqlcheck, function(err, resultcheck) {

          for (var i = 0; i < resultcheck.length; i++) {
            arr.push(resultcheck[i].playerid);
          }
        //  res.send(arr)

        var message_string = String(message_in);
        var message_string2 = "{\"type\":\"livechat\" , \"message\":\""+message_string+"\" , \"userid\" : " + user_id + " , \"avatar\" : \"" + avatar +"\" , \"name\" : \"" + name + "\" , \"provider\" : \"" + provider + "\"}";

        var message = {
              app_id: "ffd631de-5f47-4069-9a7a-b49087ea0341",
              headings : {"en": name+" ส่งข้อความถึงคุณ"},
              contents: {"en": message_string2},
              include_player_ids: arr,
              ios_badgeType : "Increase",
              ios_badgeCount : 1
            };

        sendNotification(message);

      /*  var message_string1 = String(message_in);

        var message_string2 = "{\"type\":\"livechat\" , \"message\":\""+message_string1+"\" , \"userid\" : " + chat_user_id + " , \"avatar\" : \"" + avatar +"\" , \"name\" : \"" + name + "\" , \"provider\" : \"" + provider + "\"}";
          //  contents: {"en": msg},
          var message = {
                app_id: "ffd631de-5f47-4069-9a7a-b49087ea0341",
                headings : {"en": name+" ส่งข้อความถึงคุณ"},
                contents: {"en": message_string2},
                include_player_ids: arr,
                ios_badgeType : "Increase",
                ios_badgeCount : 1
              };

        sendNotification(message); */

        });






  res.json({'status' : 200, 'message' : message_in, 'data' : true});

    });

});

});


// Chat room End



app.post('/index_2', function (req, res) {

  con.connect(function(err) {

    var user_id = req.body.user_id;
    var name = req.body.name;
    var message_in = req.body.message_in;
    var playerid = req.body.playerid;
    var provider = req.body.provider;
    var avatar = req.body.avatar;

  console.log("Connected!");

  var sqlcheck = "SELECT * FROM messages where chat_user_id = " + user_id + " and seen = 0";
  var check_noti = 0;
  con.query(sqlcheck, function(err, resultcheck) {
      if(resultcheck.length > 0){
        check_noti = 1;
      }else{
        check_noti = 0;
      }

      io.sockets.emit( 'new_count_message', {
      	new_count_message: resultcheck.length

      });


  });


  var sql = "INSERT INTO messages (chat_user_id, agent_id, message,	seen, created_at, updated_at) VALUES (" + user_id + ", 1, '" + message_in + "',0, NOW(), NOW())";
  con.query(sql, function (err, result) {
    if (err) throw err;
    console.log(name);
    var date = new Date();


      io.sockets.emit( 'new_message', {
        timer: date,
        name: name,
        avatar: avatar,
        provider: provider,
        check_noti: check_noti,
        chat_user_id: user_id,
        message_in: message_in,
        agent_id: 1,
        playerid: playerid
      });


      var message_string = String(message_in);

      var message = {
        app_id: "ffd631de-5f47-4069-9a7a-b49087ea0341",
        contents: {"en": message_string},
        include_player_ids: [playerid]
      };
      sendNotification(message_in);


    /*  app.post('/newuser', function (req, res) {
          var json = req.body; 'status'=>200, 'message' => 'register success', 'data' => true
          res.send('Add new ' + json.name + ' Completed!');
      }); */

res.json({'status' : 200, 'message' : message_in, 'data' : true});

  });
});

  //  res.send('<h1>1 record inserted</h1>');
});

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});


io.on('connection', function (socket) {




  socket.on( 'new_count_message', function( data ) {
    io.sockets.emit( 'new_count_message', {
    	new_count_message: data.new_count_message

    });
  });

  socket.on( 'update_count_message', function( data ) {
    io.sockets.emit( 'update_count_message', {
    	update_count_message: data.update_count_message
    });
  });

  socket.on( 'new_message', function( data ) {

    var message_string =  data.message_in.toString();

    var message = {
          app_id: "ffd631de-5f47-4069-9a7a-b49087ea0341",
          headings : {"en": data.name+" ส่งข้อความถึงคุณ"},
          contents: {"en": message_string},
          include_player_ids: [data.playerid],
          ios_badgeType : "Increase",
          ios_badgeCount : 1
        };

  /*  var message = {
      app_id: "ffd631de-5f47-4069-9a7a-b49087ea0341",
      contents: {"en": message_string},
      include_player_ids: [data.playerid],
      ios_badgeType : "Increase",
      ios_badgeCount : 1
    }; */
    sendNotification(message);


    io.sockets.emit( 'new_message', {
      timer: data.timer,
      name: data.name,
      avatar: data.avatar,
      provider: data.provider,
      check_noti: data.check_noti,
      chat_user_id: data.chat_user_id,
      message_in: data.message_in,
      agent_id: data.agent_id,
      playerid:data.playerid
    });
  });


  socket.on( 'new_message_room', function( data ) {

  /*  socket.room = data.channel_id;
    socket.join(data.channel_id); */

    console.log(data);
    var now = new Date();
    io.sockets.in(data.channel_id).emit( 'new_message_room', {
      timer: now,
      name: data.name,
      avatar: data.avatar,
      provider: data.provider,
      check_noti: data.check_noti,
      chat_user_id: data.chat_user_id,
      message_in: data.message_in,
      agent_id: data.agent_id,
      playerid:data.playerid
    });



    var arr1 = new Array();
    var sqlcheck1 = "SELECT playerid, user_status FROM users where user_status = 1";
    con.query(sqlcheck1, function(err, resultcheck) {

      for (var i = 0; i < resultcheck.length; i++) {
        arr1.push(resultcheck[i].playerid);
      }
    //  res.send(arr)

    var message_string = String(data.message_in);


    var message_string1 = "{\"type\":\"livechat\" , \"message\":\""+message_string+"\" , \"userid\" : " + data.chat_user_id + " , \"avatar\" : \"" + data.avatar +"\" , \"name\" : \"" + data.name + "\" , \"provider\" : \"" + data.provider + "\"}";
      //  contents: {"en": msg},

      var message = {
            app_id: "ffd631de-5f47-4069-9a7a-b49087ea0341",
            headings : {"en": data.name+" ส่งข้อความถึงคุณ"},
            contents: {"en": message_string1},
            include_player_ids: arr1,
            ios_badgeType : "Increase",
            ios_badgeCount : 1
          };

    sendNotification(message);

    });

  });


  socket.on( 'adduser', function( data ) {
    //data.room_id


    socket.room = data.room_id;
    socket.join(data.room_id);


    console.log(data);
    var now = new Date();
    io.sockets.in(data.room_id).emit( 'adduser', {
      timer: now,
      name: data.name,
      count_user: data.count_user,
      avatar: data.avatar,
      provider: data.provider,
      chat_user_id: data.chat_user_id,
      type: 1,
      message_in: data.message_in
    });


  });


});
