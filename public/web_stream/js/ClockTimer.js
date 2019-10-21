var clock = {};
$(document).ready(function() {
  clock.hr = 0;
  clock.sec = 0;
  clock.min = 0;
  clock.permission = 1;
  clock.configuration = {};
  clock._constr = function() {
    clock.sec = 0;
    clock.min = 0;
    clock.hr = 0;
    clock.display = $('#timestamp');
  }();
  clock.config = function(obj) {
    clock.configuration = obj;
  };
  clock.StartTime = function() {
    if (clock.configuration.display !== null) {
      clock.display = $('#' + clock.configuration.display);
    }
    clock.machine = setInterval(function() {
      if (clock.sec < 60) {
        if (clock.min < 60) {
          clock.sec++;
        } else {
          clock.hr++;
          clock.min = 0;
        }
      } else {
        clock.min++;
        clock.sec = 0;
      }
      if (clock.permission) {
        clock.processDisplay();
      }
    }, 1000);
  };
  clock.Stop = function() {
    clearInterval(clock.machine);
  };
  clock.ShowTime = function() {
    $('#showtime').css('background-color', '#006666');
    $('#closetime').css('background-color', '#cccccc');
    clock.permission = 1;
  };
  clock.HideTime = function() {
    $('#closetime').css('background-color', '#006666');
    $('#showtime').css('background-color', '#cccccc');
    clock.permission = 0;
    clock.display.html('--:--');
  };
  clock.processDisplay = function() {
    if (clock.sec < 10) {
      if (clock.min < 10) {
        if (clock.hr < 1) {
          clock.display.html('0' + clock.min + ':0' + clock.sec);
        } else {
          clock.display.html(clock.hr + ':0' + clock.min + ':0' + clock.sec);
        }
      } else {
        if (clock.hr < 1) {
          clock.display.html(clock.min + ':0' + clock.sec);
        } else {
          clock.display.html(clock.hr + ':' + clock.min + ':0' + clock.sec);
        }
      }
    } else {
      if (clock.min < 10) {
        if (clock.hr < 1) {
          clock.display.html('0' + clock.min + ':' + clock.sec);
        } else {
          clock.display.html(clock.hr + ':' + clock.min + ':0' + clock.sec);
        }
      } else {
        if (clock.hr < 1) {
          clock.display.html(clock.min + ':' + clock.sec);
        } else {
          clock.display.html(clock.hr + ':' + clock.min + ':' + clock.sec);
        }
      }
    }
  };
  clock.config({display: 'timestamp'});
});
